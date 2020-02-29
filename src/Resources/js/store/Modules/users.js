import axios from 'axios';
import Vue from 'vue';
import UserApi from '@/services/UserApi';

const projects = {
  namespaced: true,
  state: {
    userList: [],
    userItem: '',
    totalUsers:0,
  },
  getters: {
    getUserList: (state) => {
      if(typeof state.userList.length === 0) return [];
      return JSON.parse(JSON.stringify(state.userList));
    },
  },
  mutations: {
    setUserList(state, item){
      state.userList = item.results;
    },
    setUserItem(state, item){
      state.userItem = item;
    },
    setTotalUsers(state, item){
      state.totalUsers = item
    }
  },
  actions: {
    async setUserList({rootGetters, commit, dispatch}, pageId){

      commit('setIsPageLoading', true, {root:true});

      const keyword= rootGetters.getFilterByPage('users').keyword || '';
      const sort = rootGetters.getFilterByPage('users').sort || 'latest';

      const params = {
        sort,
        keyword,
        page: pageId,
      }

      UserApi.browse(params)
        .then((response) => {
          if(response.data.success){
            commit('setUserList', {
              results: response.data.results,
              pageId,
            });
            commit('setTotalUsers', response.data.results.total || 0)
          }
        })
        .catch((error) => {
          console.log(error);
          setTimeout(()=>{
            dispatch('setUserList', pageId);
          }, 2000)
        })
        .then(()=>{
          commit('setIsPageLoading', false, {root:true});
        })

    },
    async setUserItem({state, commit, dispatch}, userId = ''){
      if(!userId) return;

      UserApi.show(userId)
        .then((response) => {
          if(response.data.success){
            commit('setUserItem', response.data.results);
          }
        })
        .catch((error) => {
          setTimeout(()=>{
            dispatch('setUserItem', userId);
          }, 2000)
        })
    },
  }
};

export default projects;
