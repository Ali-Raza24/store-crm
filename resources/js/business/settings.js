import Vue from 'vue';

require('./../bootstrap');

import VueRouter from 'vue-router';
window.Vue = require('vue').default;

[VueRouter].forEach((x) => Vue.use(x));

const router = new VueRouter({
  mode: 'history'
});

const settings = new Vue({
  router,
  data: function() {
    return {
      base_url: $('meta[name="base_url"]').attr('content')
    };
  },
  el: '#settings',
  components: {
    /* BrandLists: require('./../components/Business/Settings/BrandListing').default,
    CategoryLists: require('./../components/Business/Settings/CategoryListing').default,
    AddonListing:require('./../components/Business/Settings/AddonListing').default,
    ProductsSettingsTabs:require('./../components/Business/Settings/ProductsSettingsTabs').default*/
    ProductSetting: require('./../components/Business/Settings/Main').default,
    AddAddon: require('./../components/Business/Settings/AddAddon').default,
    AddBrand: require('./../components/Business/Settings/AddBrand').default,
    AddCategory: require('./../components/Business/Settings/AddCategory')
      .default
  }
});
