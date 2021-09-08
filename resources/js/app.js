import Vue from 'vue';

require('./bootstrap');

import VueRouter from 'vue-router';
window.Vue = require('vue').default;
import Vuex from 'vuex';

import Verify from './components/auth/Verify';
import ResetPassword from './components/auth/ResetPassword';
import store from './store/users';

[VueRouter, Vuex].forEach((x) => Vue.use(x));

const router = new VueRouter({
  mode: 'history',
  routes: [
    { path: '/email/verify/:id/:token', component: Verify },
    { path: '/password/reset/:token', component: ResetPassword }
  ]
});

const auth = new Vue({
  router,
  store,
  data: function() {
    return {
      base_url: $('meta[name="base_url"]').attr('content')
    };
  },
  el: '#auth',
  components: {
    register: require('./components/auth/Register').default,
    verify: require('./components/auth/Verify').default,
    login: require('./components/auth/Login').default,
    ForgotPassword: require('./components/auth/ForgotPassword').default,
    ResetPassword: require('./components/auth/ResetPassword').default
  }
});
