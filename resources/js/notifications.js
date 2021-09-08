import Vue from 'vue';
import Echo from 'laravel-echo';

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Accept'] = 'application/json';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = $(
  'meta[name="csrf-token"]'
).attr('content');

Window.Pusher = require('pusher-js');
window.empty = require('locutus/php/var/empty');
window.moment = require('moment');
window.Echo = new Echo({
  broadcaster: 'pusher',
  key: process.env.MIX_PUSHER_APP_KEY,
  cluster: process.env.MIX_PUSHER_APP_CLUSTER,
  encrypted: true,
  forceTLS: true
});

import 'vue-datetime/dist/vue-datetime.css';
import Vuetify from './../plugins/vuetify';

window.Vue = Vue;

const notifications = new Vue({
  data: function() {
    return {
      base_url: $('meta[name="base_url"]').attr('content')
    };
  },
  el: '#header',
  vuetify: Vuetify,
  components: {
    Search: require('./components/Common/Search').default,
    Notification: require('./components/Common/Notification').default
  }
});
