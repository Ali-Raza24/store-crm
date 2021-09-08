import Vue from 'vue';
window.Vue = require('vue').default;

let baseUrl = document.getElementsByName('base_url');
const image = new Vue({
  data: function() {
    return {
      base_url: baseUrl[0].content
    };
  },
  el: '#image',
  components: {
    ImageUpload: require('./../components/Common/CommonImageUpload').default
  }
});
