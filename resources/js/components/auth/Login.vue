<template
  ><div class="row m-0 h-100">
    <div class="col-md-5 p-0">
      <div class="login-left">
        <div class="img-thumb">
          <img alt="" :src="base_url + '/business_assets/images/login.png'" />
        </div>
        <a href="javascript:void(0)" class="brand-logo brand-lg">
          <img alt="" :src="base_url + '/images/yabee_logo_1.png'" />
        </a>
      </div>
    </div>
    <div class="col-md-7 p-0">
      <div
        class="form-area d-flex align-items-center justify-content-center h-100"
      >
        <form class="outh-form" @submit.prevent="login">
          <div class="form-group radius-group padding-h-30 p-6">
            <h2 class="login-title dark-one">Welcome Back!</h2>
            <h3 class="font-weight-500 dark-one">
              Please login to your account.
            </h3>
            <Alert ref="alert" class="mt-3" style="line-height: 30px">
              <template #action v-if="resendEmail">
                <a
                  href="#"
                  class="bg-success text-white p-2 m-1"
                  @click="sendLink"
                  >Resend Email</a
                >
              </template>
            </Alert>
            <div class="form-icon mt-5 mb-2">
              <input
                style="-webkit-border-bottom-left-radius: 10px;-moz-border-radius-bottomleft: 10px;border-bottom-left-radius: 10px;-webkit-border-bottom-right-radius: 10px;-moz-border-radius-bottomright: 10px;border-bottom-right-radius: 10px"
                v-model="loginForm.email"
                type="email"
                placeholder="Enter your email"
                class="form-control mb-2"
                @input="removeError('email')"
                :class="{ 'border-danger': loginForm.errors.has('email') }"
              />
              <div
                v-if="loginForm.errors.has('email')"
                class="input-info danger-bg"
              >
                {{ loginForm.errors.first('email') }}
              </div>
              <span>
                <img
                  alt=""
                  :src="base_url + '/business_assets/images/user.png'"
                />
              </span>
            </div>
            <div class="form-icon">
              <input
                @input="removeError('password')"
                style="-webkit-border-top-left-radius: 10px;-moz-border-radius-topleft: 10px;border-top-left-radius: 10px;-webkit-border-top-right-radius: 10px;-moz-border-radius-topright: 10px;border-top-right-radius: 10px;"
                v-model="loginForm.password"
                :type="this.passwordField"
                placeholder="Enter your password"
                class="form-control"
                :class="{ 'border-danger': loginForm.errors.has('password') }"
              />
              <div
                v-if="loginForm.errors.has('password')"
                class="input-info danger-bg"
              >
                {{ loginForm.errors.first('password') }}
              </div>
              <span>
                <img
                  v-if="passwordField === 'password'"
                  @click="showPassword"
                  class="cursor-pointer"
                  alt=""
                  :src="base_url + '/business_assets/images/eye.png'"
                />
                <img
                  v-else
                  @click="showPassword"
                  class="cursor-pointer"
                  alt=""
                  :src="base_url + '/business_assets/images/eye-close.png'"
                />
              </span>
            </div>
            <vue-recaptcha
              class="mt-2 mb-2"
              @verify="onVerify"
              sitekey="6LewCnEaAAAAAI9ePRZNRGMZZ3-xha9almby0AF_"
              :loadRecaptchaScript="true"
              @expired="onExpire"
            ></vue-recaptcha>
            <button class="btn btn-primary btn-rounded w-100 mt-4 mb-2">
              Login
            </button>
            <h4 class="text-center">
              <a href="/password/reset" class="forgetpass mt-2"
                >Forgot Password?</a
              >
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
import VueRecaptcha from 'vue-recaptcha'

export default {
  name: 'Login',
  components: { Alert, VueRecaptcha },
  props: {
    url: {
      type: String,
      default: ''
    },
    sendEmailLink: {
      type: String,
      default: ''
    }
  },
  data: function() {
    return {
      loginForm: {
        email: '',
        password: '',
        captcha: false,
        _token: $('meta[name="csrf-token"]').attr('content')
      },
      base_url: this.$parent.$data.base_url,
      errors: [],
      passwordField: 'password',
      resendEmail: false
    }
  },
  created() {
    this.loginForm = new Form(this.loginForm)
  },
  mounted() {
    if (this.$route.query.success !== undefined) {
      this.$refs.alert.set(
        'success',
        'An email sent to your email address. Please verify your account to continue',
        true
      )
    }
  },
  methods: {
    removeError(field) {
      this.loginForm.errors.clear(field)
    },
    sendLink() {
      this.resendEmail = false
      axios
        .post(this.sendEmailLink, { email: this.loginForm.email })
        .then((response) => {
          this.$refs.alert.set('success', response.data.message, true)
        })
    },
    showPassword() {
      if (this.passwordField === 'password') {
        this.passwordField = 'text'
      } else {
        this.passwordField = 'password'
      }
    },
    login: function() {
      var self = this
      this.$refs.alert.reset()
      axios.post(this.url, this.loginForm).then((response) => {
        if (response.data.status === false) {
          this.loginForm.errors.errors = response.data.error
          if (this.loginForm.errors.has('captcha')) {
            this.$refs.alert.set(
              'danger',
              this.loginForm.errors.first('captcha'),
              true
            )
          }
          if (this.loginForm.errors.has('invalid')) {
            this.$refs.alert.set(
              'danger',
              this.loginForm.errors.first('invalid'),
              true
            )
          }

          if (this.loginForm.errors.has('email_verification_pending')) {
            this.$refs.alert.set(
              'danger',
              this.loginForm.errors.first('email_verification_pending'),
              true
            )
            this.resendEmail = true
          }
        }
        if (response.data.status === true) {
          this.$refs.alert.set('success', 'Logged in successfully', true)
          const user = response.data.data
          if (user.business_id > 0) {
            if (user.business.has_store > 0) {
              window.location.href = '/store-select'
            } else {
              window.location.href = '/store-create'
            }
          } else {
            window.location.href = '/admin/dashboard'
          }
        }
      })
    },
    onVerify: function(response) {
      if (response) this.loginForm.captcha = true
    },
    onExpire: function(response) {
      this.loginForm.captcha = false
    }
  }
}
</script>

<style scoped>
.login-left {
  height: 100vh;
}
</style>
