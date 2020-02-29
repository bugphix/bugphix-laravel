import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import issues from './Modules/issues';
import projects from './Modules/projects';
import users from './Modules/users';
import Cookies from 'js-cookie'

import ProjectApi from '@/services/ProjectApi';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    issues,
    projects,
    users,
  },
  state: {
    isPageLoading: false,
    activeProject: {},
    activePage: '',
    searchFilter: {},
    projectListOptions: {},
  },
  getters: {
    getActiveProjectId: (state) => {
      if( typeof state.activeProject.project_id !== 'undefined' ) return state.activeProject.project_id;
      return '';
    },
    getActiveProjectName: (state) => {
      if( typeof state.activeProject.project_name !== 'undefined' ) return state.activeProject.project_name;
      return '';
    },
    getSearchKeyword: (state) => {
      if(typeof state.searchFilter[state.activePage] === 'undefined') return '';
      return state.searchFilter[state.activePage].keyword || '';
    },
    getFilterSort: (state) => {
      if(typeof state.searchFilter[state.activePage] === 'undefined') return 'latest';
      return state.searchFilter[state.activePage].sort || '';
    },
    getFilterByPage: (state) => (page) => {
      if(typeof state.searchFilter[page] === 'undefined') return {};
      return state.searchFilter[page];
    }
  },
  mutations: {
    setIsPageLoading(state, item){
      state.isPageLoading = item;
    },
    setActiveProject(state, item){
      state.activeProject = item;
    },
    setActivePage(state, item){
      state.activePage = item;
    },
    setSearchFilter(state, item){
      Vue.set(state.searchFilter, state.activePage, item);
    },
    setProjectListOptions(state, item){
      state.projectListOptions = item;
    }
  },
  actions: {
    async bootApplication({ state, dispatch, commit, getters }, projectId){
      if(Cookies.get('bugphix_default_project') && (Cookies.get('bugphix_default_project') !== 'undefined' || Cookies.get('bugphix_default_project') !== '')){
        projectId = Cookies.get('bugphix_default_project');
      }
      dispatch('setActiveProject', projectId);
      dispatch('setProjectListOptions');
    },
    async setActiveProject({ commit, dispatch}, projectId=''){
      ProjectApi.getActiveProject(projectId)
        .then((response) => {
          if(response.data.success){
            commit('setActiveProject', response.data.results);
            Cookies.set('bugphix_default_project', response.data.results.project_id);
          }
          else{
            setTimeout(()=>{
              Cookies.set('bugphix_default_project', '');
              dispatch('setActiveProject', '');
            }, 200)
          }
        })
        .catch((error) => {
          // console.log(error);
        });
    },
    async setProjectListOptions({commit, dispatch}){

      ProjectApi.getProjectListOptions()
        .then((response) => {
          if(response.data.success){
            commit('setProjectListOptions', response.data.results);
          }
        })
        .catch((error) => {
          // console.log(error);
        });
    }
  }
});
