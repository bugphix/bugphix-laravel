require('./bootstrap');

import Vue from 'vue'
import axios from 'axios';
import Vuex from 'vuex'
import router from './router'
import store from './store/main'
import Notifications from 'vue-notification'

// extensions
Vue.use(Vuex)
Vue.use(Notifications)

window.axios = axios;
axios.defaults.baseURL = window.Bugphix.api;

// components
import App from './components/App'

new Vue({
  el: '#bugphix-app',
  components: {App},
  store,
  router,
});
