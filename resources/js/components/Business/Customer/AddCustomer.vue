<template>
  <div class="add-customer-panel scroll-bar-thin">
    <div class="add-customer-heading">
      <h3 class="dark-one font-weight-700">Add Customer</h3>
      <span class="add-customer-btn"
        ><img
          :src="base_url + '/business_assets/images/close-black.png'"
          alt="image"
      /></span>
    </div>
    <form class="right-side-from" id="add-customer-form" @submit.prevent="save">
      <div class="col-12 mt-2">
        <Alert ref="alert" />
      </div>
      <div class="alert alert-danger mt-2" v-if="errors.length > 0">
        Please fill all required fields
      </div>
      <div class="add-customer-img">
        <span>
          <image-upload
            style-img="height:150px; width:150px; border-radius:100%;"
            @change="handleImages"
            v-model="customerForm.images"
            name="images[profile]"
            :image_placeholder="
              base_url + '/business_assets/images/customer-placeholder.png'
            "
          />
        </span>
      </div>
      <div class="row">
        <div class="col-md-6 col-sm-6">
          <div class="form-group">
            <label>First Name</label>
            <input
              v-model="customerForm.first_name"
              type="text"
              placeholder=""
              class="order-edit-control form-control"
              :class="{
                'danger-border': customerForm.errors.has('first_name')
              }"
              @input="removeError('first_name')"
            />
            <div
              class="input-info danger-bg"
              v-if="customerForm.errors.has('first_name')"
            >
              {{ customerForm.errors.first('first_name') }}
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="form-group">
            <label>Last Name</label>
            <input
              v-model="customerForm.last_name"
              type="text"
              placeholder=""
              class="order-edit-control form-control"
              :class="{
                'danger-border': customerForm.errors.has('last_name')
              }"
              @input="removeError('last_name')"
            />
            <div
              class="input-info danger-bg"
              v-if="customerForm.errors.has('last_name')"
            >
              {{ customerForm.errors.first('last_name') }}
            </div>
          </div>
        </div>
      </div>
      <hr />
      <h4 class="dark-one font-weight-700 mt-5 mb-4">Contact Information</h4>
      <div class="row">
        <div class="col-md-6 col-sm-6">
          <div class="form-group">
            <label>Email</label>
            <input
              v-model="customerForm.email"
              type="email"
              placeholder=""
              class="order-edit-control form-control"
              :class="{
                'danger-border': customerForm.errors.has('email')
              }"
              @input="removeError('email')"
            />
            <div
              class="input-info danger-bg"
              v-if="customerForm.errors.has('email')"
            >
              {{ customerForm.errors.first('email') }}
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="form-group">
            <label>Phone No</label>
            <input
              v-model="customerForm.phone"
              type="text"
              placeholder=""
              class="order-edit-control form-control"
              :class="{
                'danger-border': customerForm.errors.has('phone')
              }"
              @input="removeError('phone')"
            />
            <div
              class="input-info danger-bg"
              v-if="customerForm.errors.has('phone')"
            >
              {{ customerForm.errors.first('phone') }}
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="form-group">
            <label>Country</label>
            <div class="form-icon">
              <select
                class="order-edit-control form-control"
                v-model="customerForm.country_id"
                :class="{
                  'danger-border': customerForm.errors.has('country_id')
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
                  :src="base_url + '/business_assets/images/angledown.png'"
                  alt="image"
              /></span>
              <div
                class="input-info danger-bg"
                v-if="customerForm.errors.has('country_id')"
              >
                {{ customerForm.errors.first('country_id') }}
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="form-group">
            <label>P.O Code</label>
            <input
              v-model="customerForm.zip"
              type="text"
              placeholder=""
              class="order-edit-control form-control"
              :class="{
                'danger-border': customerForm.errors.has('zip')
              }"
              @input="removeError('zip')"
            />
            <div
              class="input-info danger-bg"
              v-if="customerForm.errors.has('zip')"
            >
              {{ customerForm.errors.first('zip') }}
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="form-group">
            <label>City</label>
            <div class="form-icon">
              <select
                class="order-edit-control form-control"
                v-model="customerForm.state"
                :class="{
                  'danger-border': customerForm.errors.has('state')
                }"
                @input="removeError('state')"
              >
                <option value="0" disabled selected>--Select--</option>
                <option :value="index" v-for="(state, index) in states">
                  {{ state }}
                </option>
              </select>
              <div
                class="input-info danger-bg"
                v-if="customerForm.errors.has('state')"
              >
                {{ customerForm.errors.first('state') }}
              </div>
              <span
                ><img
                  :src="base_url + '/business_assets/images/angledown.png'"
                  alt="image"
              /></span>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="form-group">
            <label>Address</label>
            <input
              v-model="customerForm.address"
              type="text"
              placeholder=""
              class="order-edit-control form-control"
              :class="{
                'danger-border': customerForm.errors.has('address')
              }"
            />
            <div
              class="input-info danger-bg"
              v-if="customerForm.errors.has('address')"
            >
              {{ customerForm.errors.first('address') }}
            </div>
          </div>
        </div>
      </div>
      <hr />
      <h4 class="dark-one font-weight-700 mt-5 mb-4">Other Information</h4>
      <div class="form-group custom-checkbox">
        <input
          v-model="customerForm.subscribe"
          type="checkbox"
          class="custom-control-input"
          id="Other-Information"
        />
        <label
          class="custom-control-label w-100 h-100 pl-4"
          for="Other-Information"
          ><span class="pl-2">Agree to Subscribe</span></label
        >
      </div>
      <div class="form-group">
        <label>Show Discount %</label>
        <input
          v-model="customerForm.discount"
          type="text"
          placeholder=""
          class="order-edit-control form-control"
          :class="{
            'danger-border': customerForm.errors.has('discount')
          }"
          @input="removeError('discount')"
        />
        <div
          class="input-info danger-bg"
          v-if="customerForm.errors.has('discount')"
        >
          {{ customerForm.errors.first('discount') }}
        </div>
      </div>
      <div class="form-group">
        <label>Notes</label>
        <textarea
          v-model="customerForm.notes"
          placeholder=""
          class="order-edit-control form-control"
        ></textarea>
      </div>
      <div class="form-group">
        <button class="btn-primary btn-rounded btn-size">Save Customer</button>
        <a
          href="javascript:void(0)"
          class="btn-gray btn-rounded btn-size add-customer-btn"
          >Cancel</a
        >
      </div>
    </form>
  </div>
</template>

<script>
import ImageUpload from '../../Common/CommonImageUpload'
import Form from '../../../libs/Form'
import Alert from '../../Common/Alert'
export default {
  name: 'AddCustomer',
  components: { Alert, ImageUpload },
  props: {
    save_customer_url: {
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
    }
  },
  data() {
    return {
      base_url: this.$parent.$data.base_url,
      customerForm: {
        images: [],
        first_name: '',
        last_name: '',
        email: '',
        phone: '',
        country_id: '',
        zip: '',
        state: '',
        address: '',
        subscribe: false,
        discount: '',
        notes: ''
      },
      countries: [],
      states: []
    }
  },
  created() {
    this.customerForm = new Form(this.customerForm)

    axios.get(this.countries_url).then((response) => {
      this.countries = response.data.data
    })

    axios.get(this.states_url).then((response) => {
      this.states = response.data.data
    })
  },
  methods: {
    removeError(field) {
      this.customerForm.errors.clear(field)
    },
    save() {
      $('.add-customer-panel').animate(
        {
          scrollTop: $('.add-customer-panel').offset().top
        },
        1000
      )
      this.customerForm.post(this.save_customer_url).then((response) => {
        this.$refs.alert.set('success', 'Customer created successfully', true)
        setTimeout(function() {
          window.location.reload(false)
        }, 1000)
      })
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
              self.customerForm.images.push(this.result)
            },
            false
          )
          reader.readAsDataURL(file)
        }
      }

      if (files) {
        ;[].forEach.call(files, readAndPreview)
      }
    }
  },
  computed: {
    errors() {
      return Object.keys(this.customerForm.errors.errors).map((key) => {
        return this.customerForm.errors.errors[key]
      })
    }
  }
}
</script>

<style scoped></style>
