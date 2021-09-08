import Vue from 'vue';

require('./../bootstrap');

import VueRouter from 'vue-router';
window.Vue = require('vue').default;

[VueRouter].forEach((x) => Vue.use(x));

const router = new VueRouter({
  mode: 'history',
  routes: []
});

const stores = new Vue({
  router,
  data: function() {
    return {
      base_url: $('meta[name="base_url"]').attr('content')
    };
  },
  el: '#discounts',
  components: {
    AddDiscount: require('./../components/Business/Discount/AddDiscount')
      .default
  }
});
