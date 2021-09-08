<template>
  <div class="add-area add-customer-panel scroll-bar-thin" v-if="businessForm">
    <div class="add-customer-heading">
      <h3 class="dark-one font-weight-700">Add Business</h3>
      <span class="add-business-btn" @click="showForm">
        <img
          :src="base_url + '/admin_assets/images/close-black.png'"
          alt="image"
        />
      </span>
    </div>
    <form class="right-side-from" @submit.prevent="save">
      <Alert class="mt-5" ref="alert" />
      <div class="add-customer-img">
        <span>
          <ImageUpload
            @change="handleImages"
            v-model="businessForm.images"
            :image_placeholder="
              base_url + '/admin_assets/images/customer-placeholder.png'
            "
            style-img="height:100px; width:100px"
          />
        </span>
      </div>
      <div class="alert alert-danger" v-if="errors.length > 0">
        Please fill all required fields
      </div>
      <div class="row">
        <div class="col-12">
          <h4 class="dark-one font-weight-700 mt-5 mb-4">Admin Information</h4>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Name</label>
          <input
            v-model="businessForm.owner_name"
            type="text"
            placeholder=""
            class="order-edit-control form-control"
            :class="{ 'danger-border': businessForm.errors.has('owner_name') }"
            @input="removeError('owner_name')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('owner_name')"
          >
            {{ businessForm.errors.first('owner_name') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Email</label>
          <input
            v-model="businessForm.owner_email"
            type="text"
            placeholder=""
            class="order-edit-control form-control"
            :class="{ 'danger-border': businessForm.errors.has('owner_email') }"
            @input="removeError('owner_email')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('owner_email')"
          >
            {{ businessForm.errors.first('owner_email') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Password</label>
          <input
            v-model="businessForm.password"
            type="password"
            placeholder=""
            class="order-edit-control form-control"
            :class="{ 'danger-border': businessForm.errors.has('password') }"
            @input="removeError('owner_password')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('password')"
          >
            {{ businessForm.errors.first('password') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Phone</label>
          <input
            v-model="businessForm.owner_phone"
            type="text"
            placeholder=""
            class="order-edit-control form-control"
            :class="{ 'danger-border': businessForm.errors.has('owner_phone') }"
            @input="removeError('owner_phone')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('owner_phone')"
          >
            {{ businessForm.errors.first('owner_phone') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Mobile</label>
          <input
            v-model="businessForm.owner_mobile"
            type="text"
            placeholder=""
            class="order-edit-control form-control"
            :class="{
              'danger-border': businessForm.errors.has('owner_mobile')
            }"
            @input="removeError('owner_mobile')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('owner_mobile')"
          >
            {{ businessForm.errors.first('owner_mobile') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Business Type</label>
          <div class="form-icon">
            <select
              class="order-edit-control form-control"
              v-model="businessForm.business_type_id"
              :class="{
                'danger-border': businessForm.errors.has('business_type_id')
              }"
              @input="removeError('business_type_id')"
            >
              <option value="-1" disabled selected>--Select--</option>
              <option :value="index" v-for="(type, index) in business_types">{{
                type
              }}</option>
            </select>
            <div
              class="input-info danger-bg"
              v-if="businessForm.errors.has('business_type_id')"
            >
              {{ businessForm.errors.first('business_type_id') }}
            </div>
            <span
              ><img
                :src="base_url + '/admin_assets/images/angledown.png'"
                alt="image"
            /></span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <h4 class="dark-one font-weight-700 mt-5 mb-4">
            Business Information
          </h4>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Name</label>
          <input
            v-model="businessForm.name"
            type="text"
            placeholder=""
            class="order-edit-control form-control"
            :class="{ 'danger-border': businessForm.errors.has('name') }"
            @input="removeError('name')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('name')"
          >
            {{ businessForm.errors.first('name') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Email</label>
          <input
            v-model="businessForm.email"
            type="text"
            placeholder=""
            class="order-edit-control form-control"
            :class="{ 'danger-border': businessForm.errors.has('email') }"
            @input="removeError('email')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('email')"
          >
            {{ businessForm.errors.first('email') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Phone</label>
          <input
            v-model="businessForm.phone"
            type="text"
            placeholder=""
            class="order-edit-control form-control"
            :class="{ 'danger-border': businessForm.errors.has('phone') }"
            @input="removeError('phone')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('phone')"
          >
            {{ businessForm.errors.first('phone') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Mobile</label>
          <input
            v-model="businessForm.mobile"
            type="text"
            placeholder=""
            class="order-edit-control form-control"
            :class="{ 'danger-border': businessForm.errors.has('mobile') }"
            @input="removeError('mobile')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('mobile')"
          >
            {{ businessForm.errors.first('mobile') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Country</label>
          <div class="form-icon">
            <select
              class="order-edit-control form-control"
              v-model="businessForm.country_id"
              :class="{
                'danger-border': businessForm.errors.has('country_id')
              }"
              @input="removeError('country_id')"
            >
              <option value="0" disabled selected>--Select--</option>
              <option :value="index" v-for="(country, index) in countries">
                {{ country }}
              </option>
            </select>
            <span
              ><img
                :src="base_url + '/admin_assets/images/angledown.png'"
                alt="image"
            /></span>
            <div
              class="input-info danger-bg"
              v-if="businessForm.errors.has('country_id')"
            >
              {{ businessForm.errors.first('country_id') }}
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>City</label>
          <div class="form-icon">
            <select
              class="order-edit-control form-control"
              v-model="businessForm.state_id"
              :class="{ 'danger-border': businessForm.errors.has('state_id') }"
              @input="removeError('state_id')"
            >
              <option value="0" disabled selected>--Select--</option>
              <option :value="index" v-for="(state, index) in states">
                {{ state }}
              </option>
            </select>
            <div
              class="input-info danger-bg"
              v-if="businessForm.errors.has('state_id')"
            >
              {{ businessForm.errors.first('state_id') }}
            </div>
            <span
              ><img
                :src="base_url + '/admin_assets/images/angledown.png'"
                alt="image"
            /></span>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Address 1</label>
          <input
            v-model="businessForm.address_1"
            type="text"
            placeholder=""
            class="order-edit-control form-control"
            :class="{ 'danger-border': businessForm.errors.has('address_1') }"
            @input="removeError('address_1')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('address_1')"
          >
            {{ businessForm.errors.first('address_1') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Address 2</label>
          <input
            v-model="businessForm.address_2"
            type="text"
            placeholder=""
            class="order-edit-control form-control"
            :class="{ 'danger-border': businessForm.errors.has('address_2') }"
            @input="removeError('address_2')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('address_2')"
          >
            {{ businessForm.errors.first('address_2') }}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-sm-6 form-group">
          <label>Plan Type</label>
          <div class="form-icon">
            <select
              class="order-edit-control form-control"
              v-model="businessForm.plan_id"
              :class="{ 'danger-border': businessForm.errors.has('plan_id') }"
              @input="removeError('plan_id')"
            >
              <option value="0" disabled selected>--Select--</option>
              <option :value="plan.id" v-for="plan in plans">
                {{ plan.title }}
              </option>
            </select>
            <div
              class="input-info danger-bg"
              v-if="businessForm.errors.has('plan_id')"
            >
              {{ businessForm.errors.first('plan_id') }}
            </div>
            <span
              ><img
                :src="base_url + '/admin_assets/images/angledown.png'"
                alt="image"
            /></span>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Store Url</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">{{
                app_url
              }}</span>
            </div>
            <input
              v-model="businessForm.url"
              type="text"
              placeholder=""
              class="order-edit-control form-control"
              :class="{ 'danger-border': businessForm.errors.has('url') }"
              @input="removeError('url')"
            />
            <div
              class="input-info danger-bg"
              v-if="businessForm.errors.has('url')"
            >
              {{ businessForm.errors.first('url') }}
            </div>
          </div>
        </div>
      </div>
      <hr />

      <div class="row">
        <div class="col-12">
          <h4 class="dark-one font-weight-700 mt-5 mb-4">Store Information</h4>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Name</label>
          <input
            v-model="businessForm.stores[0].name"
            type="text"
            placeholder=""
            class="order-edit-control form-control"
            :class="{
              'danger-border': businessForm.errors.has('stores.0.name')
            }"
            @input="removeError('stores.0.name')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('stores.0.name')"
          >
            {{ businessForm.errors.first('stores.0.name') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Email</label>
          <input
            v-model="businessForm.stores[0].email"
            type="text"
            placeholder=""
            class="order-edit-control form-control"
            :class="{
              'danger-border': businessForm.errors.has('stores.0.email')
            }"
            @input="removeError('stores.0.email')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('stores.0.email')"
          >
            {{ businessForm.errors.first('stores.0.email') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Phone</label>
          <input
            v-model="businessForm.stores[0].phone"
            type="text"
            placeholder=""
            class="order-edit-control form-control"
            :class="{
              'danger-border': businessForm.errors.has('stores.0.phone')
            }"
            @input="removeError('stores.0.phone')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('stores.0.phone')"
          >
            {{ businessForm.errors.first('stores.0.phone') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Mobile</label>
          <input
            v-model="businessForm.stores[0].mobile"
            type="text"
            placeholder=""
            class="order-edit-control form-control"
            :class="{
              'danger-border': businessForm.errors.has('stores.0.mobile')
            }"
            @input="removeError('stores.0.mobile')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('stores.0.mobile')"
          >
            {{ businessForm.errors.first('stores.0.mobile') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Select Industry</label>
          <div class="form-icon">
            <select
              class="order-edit-control form-control"
              v-model="businessForm.stores[0].industry_id"
              :class="{
                'danger-border': businessForm.errors.has('stores.0.industry_id')
              }"
              @input="removeError('stores.0.industry_id')"
            >
              <option value="0" disabled selected>--Select--</option>
              <option :value="index" v-for="(industry, index) in industries">
                {{ industry }}
              </option>
            </select>
            <span
              ><img
                :src="base_url + '/admin_assets/images/angledown.png'"
                alt="image"
            /></span>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Country</label>
          <div class="form-icon">
            <select
              class="order-edit-control form-control"
              v-model="businessForm.stores[0].country_id"
              :class="{
                'danger-border': businessForm.errors.has('stores.0.country_id')
              }"
              @input="removeError('stores.0.country_id')"
            >
              <option value="0" disabled selected>--Select--</option>
              <option :value="index" v-for="(country, index) in countries">
                {{ country }}
              </option>
            </select>
            <span
              ><img
                :src="base_url + '/admin_assets/images/angledown.png'"
                alt="image"
            /></span>
            <div
              class="input-info danger-bg"
              v-if="businessForm.errors.has('stores.0.country_id')"
            >
              {{ businessForm.errors.first('stores.0.country_id') }}
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>City</label>
          <div class="form-icon">
            <select
              class="order-edit-control form-control"
              v-model="businessForm.stores[0].state_id"
              :class="{
                'danger-border': businessForm.errors.has('stores.0.state_id')
              }"
              @input="removeError('stores.0.state_id')"
            >
              <option value="0" disabled selected>--Select--</option>
              <option :value="index" v-for="(state, index) in states">
                {{ state }}
              </option>
            </select>
            <div
              class="input-info danger-bg"
              v-if="businessForm.errors.has('stores.0.state_id')"
            >
              {{ businessForm.errors.first('stores.0.state_id') }}
            </div>
            <span
              ><img
                :src="base_url + '/admin_assets/images/angledown.png'"
                alt="image"
            /></span>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Address 1</label>
          <input
            v-model="businessForm.stores[0].address_1"
            type="text"
            placeholder=""
            class="order-edit-control form-control"
            :class="{
              'danger-border': businessForm.errors.has('stores.0.address_1')
            }"
            @input="removeError('stores.0.address_1')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('stores.0.address_1')"
          >
            {{ businessForm.errors.first('stores.0.address_1') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Address 2</label>
          <input
            v-model="businessForm.stores[0].address_2"
            type="text"
            placeholder=""
            class="order-edit-control form-control"
            :class="{
              'danger-border': businessForm.errors.has('stores.0.address_2')
            }"
            @input="removeError('stores.0.address_2')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('stores.0.address_2')"
          >
            {{ businessForm.errors.first('stores.0.address_2') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Brand Color</label>
          <input
            v-model="businessForm.brand_color"
            type="color"
            placeholder=""
            class="order-edit-control form-control"
            :class="{ 'danger-border': businessForm.errors.has('brand_color') }"
            @input="removeError('brand_color')"
          />

          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('brand_color')"
          >
            {{ businessForm.errors.first('brand_color') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Opening Time</label>
          <datetime
            v-model="businessForm.stores[0].opening_time"
            type="time"
            :input-class="'form-control order-edit-control'"
            :class="{
              'danger-border': businessForm.errors.has('stores.0.opening_time')
            }"
            @input="removeError('stores.0.opening_time')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('stores.0.opening_time')"
          >
            {{ businessForm.errors.first('stores.0.opening_time') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label> Closing Time</label>
          <datetime
            v-model="businessForm.stores[0].closing_time"
            type="time"
            :input-class="'form-control order-edit-control'"
            :class="{
              'danger-border': businessForm.errors.has('stores.0.closing_time')
            }"
            @input="removeError('stores.0.closing_time')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('stores.0.closing_time')"
          >
            {{ businessForm.errors.first('stores.0.closing_time') }}
          </div>
        </div>
        <div class="col-md-6 col-sm-6 form-group">
          <label>Delivery Limit (KM)</label>
          <input
            v-model="businessForm.stores[0].delivery_limit_km"
            type="text"
            placeholder=""
            class="order-edit-control form-control"
            :class="{
              'danger-border': businessForm.errors.has(
                'stores.0.delivery_limit_km'
              )
            }"
            @input="removeError('stores.0.delivery_limit_km')"
          />
          <div
            class="input-info danger-bg"
            v-if="businessForm.errors.has('stores.0.delivery_limit_km')"
          >
            {{ businessForm.errors.first('stores.0.delivery_limit_km') }}
          </div>
        </div>
      </div>
      <div class="form-group mt-4">
        <button class="btn-primary btn-rounded btn-size">Save</button>
        <a
          href="javascript:void(0)"
          @click="showForm"
          class="btn-gray btn-rounded btn-size add-business-btn"
          >Cancel</a
        >
      </div>
    </form>
  </div>
  <div v-else></div>
</template>

<script>
import Form from '../../../libs/Form'
import Alert from '../../Common/Alert'
import ImageUpload from '../../Common/CommonImageUpload'
import 'vue-datetime/dist/vue-datetime.min.css'
// import Datetime from 'vue-datetime'
export default {
  name: 'AddBusiness',
  components: { ImageUpload, Alert },
  props: {
    save_url: {
      type: String,
      default: ''
    },
    get_url: {
      type: String,
      default: ''
    },
    business_type_url: {
      type: String,
      default: ''
    },
    countries_url: {
      type: String,
      default: ''
    },
    states_url: {
      type: String,
      default: ''
    },
    app_url: {
      type: String,
      default: ''
    },
    industries_url: {
      type: String,
      default: ''
    }
  },
  data: function() {
    return {
      businessForm: null,
      base_url: this.$parent.$data.base_url,
      business_types: [],
      countries: [],
      states: [],
      industries: [],
      plans: [
        { id: 1, title: 'Free' },
        { id: 2, title: 'Basic' },
        { id: 3, title: 'Advance' }
      ]
    }
  },
  created() {
    let id = this.$route.params.id
    axios.get(this.get_url + '/' + id).then((response) => {
      this.businessForm = new Form(response.data.data)
    })

    axios.get(this.business_type_url).then((response) => {
      this.business_types = response.data.data
    })

    axios.get(this.countries_url).then((response) => {
      this.countries = response.data.data
    })

    axios.get(this.states_url).then((response) => {
      this.states = response.data.data
    })

    axios.get(this.industries_url).then((response) => {
      this.industries = response.data.data
    })
  },
  methods: {
    removeError(field) {
      this.businessForm.errors.clear(field)
    },
    handleImages(files) {
      var self = this
      function readAndPreview(file) {
        console.log(file)
        // Make sure `file.name` matches our extensions criteria
        if (/\.(jpe?g|png|gif|jfif|pjp|pjpeg|jpeg)$/i.test(file.name)) {
          var reader = new FileReader()
          reader.addEventListener(
            'load',
            function() {
              self.businessForm.images.push(this.result)
            },
            false
          )
          reader.readAsDataURL(file)
        }
      }

      if (files) {
        ;[].forEach.call(files, readAndPreview)
      }
    },
    save() {
      $('.add-customer-panel').animate(
        {
          scrollTop: $('.add-customer-panel').offset().top
        },
        1000
      )
      this.businessForm.post(this.save_url).then((response) => {
        this.$refs.alert.set('success', 'Business created successfully', true)
        window.location.href = window.location.origin + '/admin/business'
      })
    },
    showForm() {
      $('body').toggleClass('add-customer')
      this.businessForm.errors.clear()
    }
  },
  computed: {
    errors() {
      return Object.keys(this.businessForm.errors.errors).map((key) => {
        return this.businessForm.errors.errors[key]
      })
    }
  }
}
</script>

<style scoped>
.active {
  margin-right: 0;
}
</style>
