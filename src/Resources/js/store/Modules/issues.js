import axios from 'axios';
import Vue from 'vue';
import IssueApi from '@/services/IssueApi';

const issues = {
  namespaced: true,
  state: {
    issueList: [],
    issueItem: '',
    currentEvent: '',
    totalIssues: 0,
  },
  getters: {
    getIssueList: (state) => {
      if(typeof state.issueList.length === 0) return [];
      return JSON.parse(JSON.stringify(state.issueList));
    },
  },
  mutations: {
    setIssueList(state, item){
      state.currentIssuePage = item.pageId;
      state.issueList = item.results;
    },
    setIssueItem(state, item){
      state.issueItem = item;
    },
    setCurrentEvent(state, item){
      state.currentEvent = item;
    },
    setTotalIssues(state, item){
      state.totalIssues = item
    }
  },
  actions: {
    async setIssueList({rootGetters, commit, dispatch}, pageId){

      const projectId = rootGetters.getActiveProjectId;

      if(projectId === ''){
        setTimeout(()=>{
          dispatch('setIssueList', pageId); // call again when active projet is not yet ready
        }, 1000)
        return;
      }

      commit('setIsPageLoading', true, {root:true});

      const keyword= rootGetters.getFilterByPage('issues').keyword || '';
      const sort = rootGetters.getFilterByPage('issues').sort || 'latest';
      const status = rootGetters.getFilterByPage('issues').status || 'unresolved';

      const params = {
        sort,
        keyword,
        status,
        project_id: projectId,
        page: pageId,
      }

      IssueApi.browse(params)
        .then((response) => {
          if(response.data.success){
            commit('setIssueList', {
              results: response.data.results,
              pageId,
            });
            commit('setTotalIssues', response.data.results.total || 0)
          }
        })
        .catch((error) => {
          console.log(error);
          setTimeout(()=>{
            dispatch('setIssueList', pageId);
          }, 2000)
        })
        .then(()=>{
          commit('setIsPageLoading', false, {root:true});
        })
    },
    async setIssueItem({state, commit, rootGetters, dispatch}, issueId = ''){
      if(!issueId) return;

      const projectId = rootGetters.getActiveProjectId;

      if(projectId === ''){
        setTimeout(()=>{
          dispatch('setIssueItem', issueId); // call again when active projet is not yet ready
        }, 1000)
        return;
      }

      commit('setIsPageLoading', true, {root:true})

      IssueApi.show(issueId, projectId)
        .then((response) => {
          if(response.data.success){
            commit('setIssueItem', response.data.results);
            if(response.data.results.latest_event){
              commit('setCurrentEvent', response.data.results.latest_event);
            }
          }
        })
        .catch((error) => {
          setTimeout(()=>{
            dispatch('setIssueItem', issueId);
          }, 2000)
        })
        .then(()=>{
          commit('setIsPageLoading', false, {root:true})
        })
    },
    async setEventItem({state, commit, rootGetters, dispatch}, eventId = ''){

      if(!eventId) return;

      commit('setIsPageLoading', true, {root:true})

      IssueApi.getEvent(eventId)
        .then((response) => {
          if(response.data.success){
            commit('setCurrentEvent', response.data.results);
          }
        })
        .catch((error) => {
          setTimeout(()=>{
            dispatch('setEventItem', eventId);
          }, 2000)
        })
        .then(()=>{
          commit('setIsPageLoading', false, {root:true})
        })
    },
  }
};

export default issues;
