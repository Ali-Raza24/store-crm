<template>
  <div class="text-center mt-5">
    <h4>Please wait! we are verifying your details</h4>
    <Spinner :show="true" class="mt-5"></Spinner>
  </div>
</template>

<script>
import Spinner from '../Common/Spinner';
export default {
  components: { Spinner },
  props: {
    url: {
      type: String,
      default: ''
    }
  },
  created() {
    axios
      .post(
        this.url +
          '/' +
          this.$route.params.id +
          '/' +
          this.$route.params.token +
          '?expires=' +
          this.$route.query.expires +
          '&signature=' +
          this.$route.query.signature
      )
      .then((response) => {
        if (response.data.status === true) {
          window.location.href = this.$parent.$data.base_url + '/login';
        }
      });
  }
};
</script>

<style scoped></style>
