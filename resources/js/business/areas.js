import Vue from 'vue';

require('./../bootstrap');

import VueRouter from 'vue-router';
import store from './../store/areas-store';
import * as VueGoogleMaps from 'vue2-google-maps';
// import { Datetime } from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css';
import Vuetify from '../../plugins/vuetify';

window.Vue = require('vue').default;

[VueRouter].forEach((x) => Vue.use(x));

Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyB-sV_ZeCp19js0PE683QD8cwzV7JQEd0U',
    libraries: 'places'
  }
});

const router = new VueRouter({
  mode: 'history',
  routes: []
});

const areas = new Vue({
  router,
  vuetify: Vuetify,
  store,
  data: function() {
    return {
      base_url: $('meta[name="base_url"]').attr('content')
    };
  },
  el: '#areas',
  components: {
    Areas: require('./../components/Business/Settings/Areas/Main').default
  }
});
