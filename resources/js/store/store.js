import Vue from 'vue';
import Vuex from 'vuex';
import businessStore from './business';
import users from './users';
Vue.use(Vuex);

const store = new Vuex.store({
  modules: {
    business: businessStore,
    user: users
  }
});
export default store;
