import Vue from 'vue';

require('./../bootstrap');

import VueRouter from 'vue-router';
import Create from '../components/Business/Stores/Create';
window.Vue = require('vue').default;

[VueRouter].forEach((x) => Vue.use(x));

const router = new VueRouter({
  mode: 'history',
  routes: [{ path: '/:store/?', component: Create }]
});

const stores = new Vue({
  router,
  data: function() {
    return {
      base_url: $('meta[name="base_url"]').attr('content')
    };
  },
  el: '#stores',
  components: {
    StoreCreate: require('./../components/Business/Stores/Create').default
  }
});
