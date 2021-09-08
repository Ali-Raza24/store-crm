<template>
  <div class="row m-0 h-100">
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
        <form class="outh-form" @submit.prevent="resetPassword" id="resetForm">
          <div class="form-group radius-group text-center p-8 padding-h-30">
            <h2 class="login-title dark-one mb-2">Reset Your Password</h2>
            <Alert ref="alert"></Alert>
            <h3 class="dark-one"></h3>
            <div class="form-icon mt-5 mb-3">
              <input
                style="-webkit-border-bottom-left-radius: 10px;-moz-border-radius-bottomleft: 10px;border-bottom-left-radius: 10px;-webkit-border-bottom-right-radius: 10px;-moz-border-radius-bottomright: 10px;border-bottom-right-radius: 10px"
                v-model="resetPasswordForm.password"
                type="password"
                placeholder="New Password"
                class="form-control"
                :class="{
                  'danger-border': resetPasswordForm.errors.has('password')
                }"
              />
              <div
                class="input-info danger-bg"
                v-if="resetPasswordForm.errors.has('password')"
              >
                <p>{{ resetPasswordForm.errors.first('password') }}</p>
              </div>
              <span>
                <img
                  alt=""
                  :src="base_url + '/business_assets/images/eye.png'"
                />
              </span>
            </div>
            <div class="form-icon">
              <input
                style="-webkit-border-top-left-radius: 10px;-moz-border-radius-topleft: 10px;border-top-left-radius: 10px;-webkit-border-top-right-radius: 10px;-moz-border-radius-topright: 10px;border-top-right-radius: 10px;"
                v-model="resetPasswordForm.password_confirmation"
                type="password"
                placeholder="Confirm Password"
                class="form-control"
                :class="{
                  'danger-border': resetPasswordForm.errors.has(
                    'password_confirmation'
                  )
                }"
              />
              <div
                class="input-info danger-bg"
                v-if="resetPasswordForm.errors.has('password_confirmation')"
              >
                <p>
                  {{ resetPasswordForm.errors.first('password_confirmation') }}
                </p>
              </div>
              <span>
                <img
                  alt=""
                  :src="base_url + '/business_assets/images/eye.png'"
                />
              </span>
            </div>
            <button class="btn btn-primary btn-rounded w-100 mt-4 mb-2">
              Rest Your Password
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
  name: 'ResetPassword',
  components: { Alert },
  props: {
    url: {
      type: String,
      default: ''
    }
  },
  data: function() {
    return {
      resetPasswordForm: {
        email: this.$route.query.email,
        password: '',
        password_confirmation: '',
        token: this.$route.params.token
      },
      base_url: this.$parent.$data.base_url
    }
  },
  created() {
    this.resetPasswordForm = new Form(this.resetPasswordForm)
  },
  methods: {
    resetPassword: function() {
      this.resetPasswordForm
        .post(this.url)
        .then((response) => {
          this.$refs.alert.set(
            'success',
            'Password Reset Successfully',
            true,
            true
          )
          window.location.href = '/reset-success'
        })
        .catch((errors) => {
          /*let message = 'Something went wrong'
          if (
            errors.response.data.errors.password &&
            errors.response.data.errors.password.length > 0
          ) {
            message = errors.response.data.errors.password[0]
          }
          if (
            errors.response.data.errors.email &&
            errors.response.data.errors.email.length > 0
          ) {
            message = errors.response.data.errors.email[0]
          }
          this.$refs.alert.set('danger', message, true)*/
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
