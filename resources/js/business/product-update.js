import Vue from 'vue';

require('./../bootstrap');
require('../../../public/vendor/jsvalidation/js/jsvalidation.min.js');
import VueRouter from 'vue-router';
window.Vue = require('vue').default;
window.array_end = require('locutus/php/array/end');
window.array_count = require('locutus/php/array/count');

import Vuetify from '../../plugins/vuetify';

[VueRouter].forEach((x) => Vue.use(x));

const router = new VueRouter({
  mode: 'history',
  routes: []
});

const stores = new Vue({
  router,
  vuetify: Vuetify,
  data: function() {
    return {
      base_url: $('meta[name="base_url"]').attr('content')
    };
  },
  el: '#products',
  components: {
    ProductExtraUpdate: require('./../components/Business/Product/ProductExtraUpdate')
      .default
  }
}).$mount('#products');
