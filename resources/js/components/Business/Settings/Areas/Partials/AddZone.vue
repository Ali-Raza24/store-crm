<template>
  <div class="add-customer-panel add-customer scroll-bar-thin">
    <div class="add-customer-heading">
      <h3 class="dark-one font-weight-700">Add Zone</h3>
      <span class="add-area-btn">
        <img
          :src="base_url + '/admin_assets/images/close-black.png'"
          alt="image"
        />
      </span>
    </div>
    <form @submit.prevent="save" v-if="zoneForm">
      <Alert ref="alert" />
      <div class="row">
        <h4 class="col-12 font-weight-700 dark-one mb-4 mt-4">
          Delivery
        </h4>
        <div class="form-group col-sm-12">
          <label class="font-weight-600 dark-one mb-2">Select Store</label>
          <div class="form-icon">
            <select
              v-model="zoneForm.store_id"
              class="form-control order-edit-control"
              :class="{ 'danger-border': zoneForm.errors.has('store_id') }"
              @input="removeError('store_id')"
            >
              <option selected disabled>-- Select --</option>
              <option
                v-for="(store, index) in stores"
                :key="index"
                :value="index"
              >
                {{ store }}</option
              >
            </select>
            <div
              class="input-info danger-bg"
              v-if="zoneForm.errors.has('store_id')"
            >
              {{ zoneForm.errors.first('store_id') }}
            </div>
            <span>
              <img
                alt=""
                :src="base_url + '/business_assets/images/angledown.png'"
              />
            </span>
          </div>
        </div>
        <div class="col-12 form-group">
          <label for="">Select Delivery Company</label>
          <div class="form-icon">
            <select
              class="order-edit-control form-control"
              v-model="zoneForm.delivery_company_id"
              :class="{
                'danger-border': zoneForm.errors.has('delivery_company_id')
              }"
              @input="removeError('delivery_company_id')"
              disabled
            >
              <option
                :key="id + 1"
                :value="id"
                v-for="(method, id) in deliveryMethods"
                >{{ method }}</option
              >
            </select>
            <div
              class="input-info danger-bg"
              v-if="zoneForm.errors.has('delivery_company_id')"
            >
              {{ zoneForm.errors.first('delivery_company_id') }}
            </div>
            <span>
              <img
                :src="base_url + '/admin_assets/images/angledown.png'"
                alt="image"
              />
            </span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 form-group mb-3">
          <label class="font-weight-600 dark-one mb-2"> Zone Name </label>
          <input
            type="text"
            v-model="zoneForm.name"
            class="form-control order-edit-control"
            :class="{ 'danger-border': zoneForm.errors.has('name') }"
            @input="removeError('name')"
          />
          <div class="input-info danger-bg" v-if="zoneForm.errors.has('name')">
            {{ zoneForm.errors.first('name') }}
          </div>
        </div>
        <div class="col-sm-12 form-group mb-3">
          <label class="font-weight-600 dark-one mb-2">
            Delivery Rate
          </label>
          <input
            type="number"
            v-model.number="zoneForm.rate"
            class="form-control order-edit-control"
            :class="{ 'danger-border': zoneForm.errors.has('rate') }"
            @input="removeError('rate')"
          />
          <div class="input-info danger-bg" v-if="zoneForm.errors.has('rate')">
            <p>{{ zoneForm.errors.first('rate') }}</p>
          </div>
        </div>
      </div>
      <h4 class="font-weight-700 dark-one mb-4 mt-4">Delivery Time</h4>
      <hr class="mt-3 mb-3" />
      <div class="row">
        <div class="form-group col-sm-6">
          <label class="font-weight-600 dark-one mb-2">Days</label>
          <select
            v-model="zoneForm.days"
            class="form-control order-edit-control"
            :class="{ 'danger-border': zoneForm.errors.has('days') }"
            @input="removeError('days')"
          >
            <option :value="index" v-for="(day, index) in days" :key="index">{{
              day
            }}</option>
          </select>
          <div class="input-info danger-bg" v-if="zoneForm.errors.has('days')">
            <p>{{ zoneForm.errors.first('days') }}</p>
          </div>
        </div>
        <div class="form-group col-sm-3">
          <label class="font-weight-600 dark-one mb-2">Hours</label>
          <div class="quantity form-group ">
            <select
              v-model="zoneForm.hours"
              class="form-control order-edit-control"
              :class="{ 'danger-border': zoneForm.errors.has('hours') }"
              @input="removeError('hours')"
            >
              <option
                :value="index"
                v-for="(hour, index) in hours"
                :key="index"
                >{{ hour }}</option
              >
            </select>
            <div
              class="input-info danger-bg"
              v-if="zoneForm.errors.has('hours')"
            >
              <p>{{ zoneForm.errors.first('hours') }}</p>
            </div>
          </div>
        </div>
        <div class="form-group col-sm-3">
          <label class="font-weight-600 dark-one mb-2">Minutes</label>
          <div class="quantity form-group">
            <select
              v-model="zoneForm.minutes"
              class="form-control order-edit-control"
              :class="{ 'danger-border': zoneForm.errors.has('minutes') }"
              @input="removeError('hours')"
            >
              <option
                :value="index"
                v-for="(min, index) in minutes"
                :key="index"
                >{{ min }}</option
              >
            </select>
            <div
              class="input-info danger-bg"
              v-if="zoneForm.errors.has('minutes')"
            >
              <p>{{ zoneForm.errors.first('minutes') }}</p>
            </div>
          </div>
        </div>
      </div>
      <hr class="mb-3 mt-5" />
      <div class="row">
        <div class="col-12">
          <div class="form-group mb-0 text-right">
            <div v-if="!zoneForm.id">
              <button class="btn-size btn-rounded btn-primary mr-3">
                Add
              </button>
              <a
                href="#"
                class="btn-size btn-rounded btn-primary mr-3 add-area-btn"
              >
                Cancel
              </a>
            </div>
            <div v-else>
              <button class="btn-size btn-rounded btn-primary mr-3">
                Update
              </button>
              <a
                href="#"
                class="btn-size btn-rounded btn-primary mr-3 add-area-btn"
              >
                Cancel
              </a>
            </div>
          </div>
        </div>
      </div>
      <ConfirmDialog ref="confirmBox" />
    </form>
  </div>
</template>

<script>
import ConfirmDialog from '../../../../Common/ConfirmDialog'
import Form from '../../../../../libs/Form'
import Alert from '../../../../Common/Alert'
// import 'vue-datetime/dist/vue-datetime.min.css'
import Datetime from '../../../../Common/Date/Datetime'
export default {
  name: 'AddZone',
  components: { Alert, ConfirmDialog, Datetime },
  props: {
    deliveryMethods: {
      type: [Array, Object],
      default: () => {}
    },
    store_id: {
      type: String,
      default: ''
    },
    get_zone_url: {
      type: String,
      default: ''
    },
    save_zone_url: {
      type: String,
      default: ''
    },
    get_stores: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      base_url: this.$parent.$data.base_url,
      zoneForm: {
        store_id: parseInt(this.store_id) || 0,
        name: '',
        rate: '',
        days: '',
        hours: '',
        minutes: '',
        delivery_company_id: 0
      },
      defaultStore: parseInt(this.store_id) || 0,
      stores: [],
      show: false
    }
  },
  created() {
    this.zoneForm = new Form(this.zoneForm)
    axios
      .get(this.get_stores)
      .then((response) => (this.stores = response.data.data))
  },
  methods: {
    removeError($field) {
      this.zoneForm.errors.clear($field)
    },
    setShow(val) {
      this.show = val
    },
    resetZoneForm() {
      this.zoneForm = new Form({
        store_id: parseInt(this.store_id) || 0,
        name: '',
        rate: '',
        days: '',
        hours: '',
        minutes: '',
        delivery_company_id: '',
        id: ''
      })
    },
    setZoneForm(form) {
      this.zoneForm = form
    },
    onlyNumber($event) {
      let keyCode = $event.keyCode ? $event.keyCode : $event.which
      if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) {
        $event.preventDefault()
      }
    },
    save() {
      this.zoneForm.post(this.save_zone_url).then((response) => {
        if (this.zoneForm.id) {
          this.$refs.alert.set('success', 'Zone updated successfully', true)
        } else {
          this.$refs.alert.set('success', 'Zone created successfully', true)
        }
        this.$parent.$refs.zoneTab.fetchZones()
        let self = this
        setTimeout(function() {
          self.showForm()
        }, 2000)
      })
    },
    showForm() {
      $('body').toggleClass('add-customer')
    }
  },
  computed: {
    default_store_id() {
      return this.$store.state.default_store
    },
    days() {
      let days = []
      for (let i = 0; i <= 90; i++) {
        days.push(i)
      }
      return days
    },
    hours() {
      let hours = []
      for (let i = 0; i <= 24; i++) {
        hours.push(i)
      }
      return hours
    },
    minutes() {
      let min = []
      for (let i = 0; i <= 60; i++) {
        min.push(i)
      }
      return min
    }
  }
}
</script>

<style scoped></style>
