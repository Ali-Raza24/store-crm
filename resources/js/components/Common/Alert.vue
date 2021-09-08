<template>
  <div class="alert " :class="alertType" role="alert" v-if="show">
    {{ message }}
    <slot name="action" class="bg-success text-white"></slot>
    <button type="button" class="close" @click="hideAlert">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
</template>

<script>
export default {
  name: 'Alert',
  data: function() {
    return {
      type: '',
      message: '',
      dismissible: false,
      show: false
    }
  },
  computed: {
    alertType() {
      let alertClass = 'alert-success'

      if (this.type === 'primary') {
        alertClass = 'alert-primary'
      }
      if (this.type === 'secondary') {
        alertClass = 'alert-secondary'
      }
      if (this.type === 'success') {
        alertClass = 'alert-success'
      }
      if (this.type === 'danger') {
        alertClass = 'alert-danger'
      }
      if (this.type === 'warning') {
        alertClass = 'alert-warning'
      }
      if (this.type === 'info') {
        alertClass = 'alert-info'
      }
      if (this.type === 'light') {
        alertClass = 'alert-light'
      }
      if (this.type === 'dark') {
        alertClass = 'alert-dark'
      }
      if (this.dismissible === true) {
        alertClass += ' alert-dismissible'
      }

      if (this.show) {
        alertClass += ' show'
      }
      return alertClass
    }
  },
  methods: {
    set(type, message, show, dismissible = false) {
      this.type = type
      this.message = message
      this.show = show
      this.dismissible = dismissible
    },
    reset() {
      this.type = ''
      this.message = ''
      this.show = false
    },
    hideAlert() {
      this.show = !this.show
    }
  }
}
</script>

<style scoped></style>
