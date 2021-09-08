<template
  ><div class="row m-0 h-100">
    <div class="col-md-4 p-0">
      <div class="login-left">
        <a href="javscript:void(0)" class="brand-logo">
          <img alt="" :src="base_url + '/images/yabee_logo_1.png'" />
        </a>
      </div>
    </div>
    <div class="col-md-8 p-0">
      <div
        class="form-area d-flex align-items-center justify-content-center h-100"
      >
        <form class="outh-form" @submit.prevent="sendPasswordResetLink">
          <div
            class="form-group radius-group single-input text-center p-8 padding-h-30"
          >
            <Alert ref="alert"></Alert>
            <h2 class="login-title dark-one mb-3">Forgot Your Password</h2>
            <h3 class="dark-one">
              Enter your email address and we‘ll send you a link to rest your
              password
            </h3>
            <div class="form-icon mt-5">
              <input
                type="email"
                v-model="forgotPasswordForm.email"
                placeholder="Enter your email"
                class="form-control"
                :class="{
                  'danger-border': forgotPasswordForm.errors.has('email')
                }"
              />
              <div
                class="input-info danger-bg"
                v-if="forgotPasswordForm.errors.has('email')"
              >
                <p>{{ forgotPasswordForm.errors.first('email') }}</p>
              </div>
              <span>
                <img
                  alt=""
                  :src="base_url + '/business_assets/images/user.png'"
                />
              </span>
            </div>
            <button class="btn btn-primary btn-rounded w-100 mt-4 mb-2">
              Forgot Password
            </button>
            <h4 class="text-center">
              <a href="/login" class="forgetpass mt-2">Back to Login</a>
            </h4>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Form from '../../libs/Form'
import Alert from '../Common/Alert'

export default {
  name: 'ForgotPassword',
  components: { Alert },
  props: {
    url: {
      type: String,
      default: ''
    }
  },
  data: function() {
    return {
      forgotPasswordForm: {
        email: ''
      },
      base_url: this.$parent.$data.base_url
    }
  },
  created() {
    this.forgotPasswordForm = new Form(this.forgotPasswordForm)
  },
  methods: {
    sendPasswordResetLink: function() {
      this.$refs.alert.reset()
      this.forgotPasswordForm.post(this.url).then((response) => {
        this.$refs.alert.set(
          'success',
          'Thanks for submitting your email address. We will send you an email with further instructions. The email might take a couple of minutes to reach your account. Please check your junk folder to ensure you receive it.',
          true,
          true
        )
      })
    }
  }
}
</script>

<style scoped>
.login-left {
  height: 100vh;
}
</style>
