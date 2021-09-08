<template>
  <section class="busi_build">
    <div class="container pt-5">
      <div class="title text-center mb-4">
        <h2>Register your business</h2>
      </div>
      <Alert ref="alert"></Alert>
      <form id="register-form" @submit.prevent="register">
        <div class="busi_form">
          <div class="form-row">
            <div class="form-group col-md-6">
              <select
                v-model="registerForm.business_type_id"
                class="form-control"
                name="business_type_id"
                v-bind:class="{
                  'is-invalid': registerForm.errors.has('business_type_id')
                }"
              >
                <option
                  :value="type.id"
                  v-for="type in businessTypes"
                  :key="type.id"
                >
                  {{ type.title }}
                </option>
              </select>
              <span
                v-if="registerForm.errors.has('business_type_id')"
                class="invalid-feedback"
              >
                {{ registerForm.errors.first('business_type_id') }}
              </span>
            </div>
            <div class="form-group input-group col-md-6">
              <input
                id="name"
                v-model="registerForm.name"
                type="text"
                class="form-control"
                value=""
                autofocus
                placeholder="Business Name"
                v-bind:class="{
                  'is-invalid': registerForm.errors.has('name')
                }"
              />
              <span
                v-if="registerForm.errors.has('name')"
                class="invalid-feedback"
              >
                {{ registerForm.errors.first('name') }}
              </span>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group input-group col-md-6">
              <input
                id="email"
                v-model="registerForm.email"
                type="email"
                class="form-control"
                value=""
                placeholder="Business Email"
                v-bind:class="{
                  'is-invalid': registerForm.errors.has('email')
                }"
              />
              <span
                v-if="registerForm.errors.has('email')"
                class="invalid-feedback"
              >
                {{ registerForm.errors.first('email') }}
              </span>
            </div>
            <div class="form-group input-group col-md-6">
              <input
                id="phone_number"
                v-model="registerForm.phone"
                type="text"
                class="form-control bfh-phone"
                value=""
                placeholder="Business Phone"
                v-bind:class="{
                  'is-invalid': registerForm.errors.has('phone')
                }"
              />
              <span
                v-if="registerForm.errors.has('phone')"
                class="invalid-feedback"
              >
                {{ registerForm.errors.first('phone') }}
              </span>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group input-group col-md-6">
              <input
                id="password"
                v-model="registerForm.password"
                type="password"
                class="form-control"
                placeholder="Password"
                v-bind:class="{
                  'is-invalid': registerForm.errors.has('password')
                }"
              />
              <span
                v-if="registerForm.errors.has('password')"
                class="invalid-feedback"
              >
                {{ registerForm.errors.first('password') }}
              </span>
            </div>
            <div class="form-group col-md-6">
              <input
                id="password-confirm"
                v-model="registerForm.password_confirmation"
                type="password"
                class="form-control"
                placeholder="Confirm password"
                v-bind:class="{
                  'is-invalid': registerForm.errors.has('password_confirmation')
                }"
              />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group input-group col-md-6">
              <select
                id="plan_id"
                v-model="registerForm.plan_id"
                class="form-control"
                v-bind:class="{
                  'is-invalid': registerForm.errors.has('plan_id')
                }"
              >
                <option :value="plan.id" v-for="plan in plans" :key="plan.id">
                  {{ plan.title }}
                </option>
              </select>
              <span
                v-if="registerForm.errors.has('plan_id')"
                class="invalid-feedback"
              >
                {{ registerForm.errors.first('plan_id') }}
              </span>
            </div>
          </div>
          <div class="terms_cond_btn text-center">
            <div class="form-group">
              <div class="form-check">
                <input
                  id="gridCheck"
                  v-model="registerForm.terms"
                  class="form-check-input"
                  type="checkbox"
                  required
                />
                <label class="form-check-label" for="gridCheck">
                  I Agree
                  <a href="https://yabee.me/terms-conditions"
                    >Terms & Conditions</a
                  >
                </label>
              </div>
              <button id="register" class="btn btn-primary mt-5">
                set up my business
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
import Form from '../../libs/Form'
import Alert from '../Common/Alert'

export default {
  name: 'Register',
  components: { Alert },
  props: {
    url: {
      type: String,
      default: ''
    }
  },
  data: function() {
    return {
      registerForm: {
        business_type_id: '',
        name: '',
        email: '',
        phone: '',
        password: '',
        password_confirmation: '',
        plan_id: '',
        terms: ''
      },
      businessTypes: [
        { id: '', title: 'Select Business Type', selected: true },
        { id: 1, title: 'Food and beverage' },
        { id: 2, title: 'Retail' }
      ],
      plans: [
        { id: '', title: 'Select Plan', selected: true },
        { id: 1, title: 'Free' },
        { id: 2, title: 'Basic' },
        { id: 3, title: 'Advance' }
      ]
    }
  },
  created() {
    this.registerForm = new Form(this.registerForm)
  },
  methods: {
    register: function() {
      this.registerForm.post(this.url).then((response) => {
        this.$refs.alert.set('success', response.message, true)
      })
    }
  }
}
</script>

<style scoped></style>
