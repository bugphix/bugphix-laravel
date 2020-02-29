import axios from 'axios';
import Vue from 'vue';
import ProjectApi from '@/services/ProjectApi';

const projects = {
  namespaced: true,
  state: {
    projectList: [],
    projectItem: '',
    showCreateProjectModal: false,
    totalProjects:0,
  },
  getters: {
    getProjectList: (state) => {
      if(typeof state.projectList.length === 0) return [];
      return JSON.parse(JSON.stringify(state.projectList));
    },
  },
  mutations: {
    setProjectList(state, item){
      state.currentIssuePage = item.pageId;
      state.projectList = item.results;
    },
    setCurrentProjectPage(state, item){
      if(item<=0) item = 1;
      state.currentProjectPage = item;
    },
    setProjectItem(state, item){
      state.projectItem = item;
    },
    setShowCreateProjectModal(state, item){
      state.showCreateProjectModal = item
    },
    setTotalProjects(state, item){
      state.totalProjects = item
    },
  },
  actions: {
    async setProjectList({rootGetters, commit, dispatch}, pageId){

      commit('setIsPageLoading', true, {root:true});

      const keyword= rootGetters.getFilterByPage('projects').keyword || '';
      const sort = rootGetters.getFilterByPage('projects').sort || 'latest';

      const params = {
        sort,
        keyword,
        page: pageId,
      }

      ProjectApi.browse(params)
        .then((response) => {
          if(response.data.success){
            commit('setProjectList', {
              results: response.data.results,
              pageId,
            });
            commit('setTotalProjects', response.data.results.total || 0)
          }
        })
        .catch((error) => {
          console.log(error);
          setTimeout(()=>{
            dispatch('setProjectList', pageId);
          }, 2000)
        })
        .then(()=>{
          commit('setIsPageLoading', false, {root:true});
        })

    },
    async setProjectItem({state, commit, dispatch}, projectId = ''){
      if(!projectId) return;

      ProjectApi.show(projectId)
        .then((response) => {
          if(response.data.success){
            commit('setProjectItem', response.data.results);
          }
        })
        .catch((error) => {
          setTimeout(()=>{
            dispatch('setProjectItem', projectId);
          }, 2000)
        })
    },
    async createProject({state, commit, dispatch}, data){
      ProjectApi.create(data)
        .then((response) => {
          if(response.data.success){
            dispatch('setProjectList', 1);
          }
        })
        .catch((error) => {
          setTimeout(()=>{
            dispatch('createProject', projectId);
          }, 2000)
        })
    },
    async updateProject({state, commit, dispatch}, params){

      const {projectId, data} = params;

      if(! projectId || ! data) return;

      ProjectApi.create(data)
        .then((response) => {
          if(response.data.success){
            dispatch('setProjectList', 1);
          }
        })
        .catch((error) => {
          setTimeout(()=>{
            dispatch('createProject', projectId);
          }, 2000)
        })
    },
  }
};

export default projects;
