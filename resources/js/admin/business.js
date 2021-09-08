import Vue from 'vue';

require('./../bootstrap');

import VueRouter from 'vue-router';
window.Vue = require('vue').default;

import store from '../store/users';
import AddBusiness from '../components/Admin/Business/AddBusiness';
import EditBusiness from '../components/Admin/Business/EditBusiness';
import DetailBusiness from '../components/Admin/Business/DetailBusiness';
import { Datetime } from 'vue-datetime';
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css';

[VueRouter, Datetime].forEach((x) => Vue.use(x));

Vue.component('datetime', Datetime);

const router = new VueRouter({
  mode: 'history',
  routes: [
    { path: '/admin/business/edit/:id', component: AddBusiness },
    {
      path: '/admin/business/edit/:id',
      component: EditBusiness,
      name: 'edit-business'
    },
    { path: '/admin/business/detail/:id', component: DetailBusiness }
  ]
});

const business = new Vue({
  router,
  store,
  data: function() {
    return {
      base_url: $('meta[name="base_url"]').attr('content')
    };
  },
  el: '#business',
  components: {
    List: require('./../components/Admin/Business/List').default,
    AddBusiness: require('./../components/Admin/Business/AddBusiness').default,
    EditBusiness: require('./../components/Admin/Business/EditBusiness')
      .default,
    DetailBusiness: require('./../components/Admin/Business/DetailBusiness')
      .default
  }
});
