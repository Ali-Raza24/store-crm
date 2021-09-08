import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    loggedUser: false,
    user: [],
    token: ''
  },

  mutations: {
    SET_LOGGED_INFO(state, payload) {
      state.loggedUser = payload;
    },

    SET_USER_DATA(state, payload) {
      state.user = payload;
    },

    SET_ACCESS_TOKEN(state, payload) {
      state.token = payload;
    }
  },

  actions: {}
});
