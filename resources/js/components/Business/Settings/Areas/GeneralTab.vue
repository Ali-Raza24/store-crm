<template>
  <div
    class="tab-pane fade show active"
    id="General"
    role="tabpanel"
    aria-labelledby="settStore"
  >
    <form @submit.prevent="updateDelivery">
      <div class="row">
        <h4 class="col-12 font-weight-700 dark-one mb-4">
          Setup your delivery method
        </h4>
        <div class="col-12" v-if="areaForm">
          <div class="row mb-2">
            <div class="col-md-3 col-6"><strong>Stores</strong></div>
            <div class="col-md-3 col-6"><strong>Delivery Methods</strong></div>
            <div class="col-md-3 col-6" v-if="store_delivery_permission">
              <strong>Action</strong>
            </div>
            <div class="col-md-3 col-6"><strong></strong></div>
          </div>
          <div class="row mt-3" v-for="(store, id) in stores" :key="id">
            <div class="col-md-3 col-6">
              <h6>{{ store }}</h6>
            </div>
            <div class="col-md-3 col-6">
              <div class="form-icon" v-if="store_delivery_permission">
                <select
                  class="order-edit-control form-control"
                  v-model="areaForm[id].delivery_company_id"
                  @change="checkLocation(id)"
                >
                  <option
                    :key="id + 1"
                    :value="id"
                    v-for="(method, id) in deliveryMethods"
                    >{{ method }}</option
                  >
                </select>
                <span>
                  <img
                    :src="base_url + '/admin_assets/images/angledown.png'"
                    alt="image"
                  />
                </span>
              </div>
              <div v-else>
                {{ deliveryMethods[areaForm[id].delivery_company_id] }}
              </div>
            </div>
            <div class="col-md-3 col-6" v-if="store_delivery_permission">
              <a
                href="javascript:void(0)"
                class="btn-size btn-rounded btn-primary"
                @click="updateDelivery(id)"
              >
                Update
              </a>
            </div>
            <div class="col-md-3 col-6" :id="'alert' + id"></div>
          </div>
        </div>
      </div>
    </form>
    <StoreLocation
      ref="storeLocationForm"
      :save_store_locations_url="save_store_locations_url"
      :update_delivery_type="update_delivery_type"
    />
  </div>
</template>

<script>
import Alert from '../../../Common/Alert'
import Form from '../../../../libs/Form'
import StoreLocation from './Partials/StoreLocation'

export default {
  name: 'GeneralTab',
  components: { StoreLocation, Alert },
  props: {
    store_delivery_permission: {
      type: Boolean,
      default: false
    },
    update_delivery_type: {
      type: String,
      default: ''
    },
    get_delivery_type: {
      type: String,
      default: ''
    },
    get_delivery_companies: {
      type: String,
      default: ''
    },
    get_stores: {
      type: String,
      default: ''
    },
    deliveryMethods: {
      type: [Array, Object],
      default: () => {}
    },
    get_store_by_id: {
      type: String,
      default: ''
    },
    save_store_locations_url: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      base_url: this.$parent.$data.base_url,
      areaForm: [],
      deliveryCompanies: [],
      stores: [],
      errors: {},
      currentStore: [],
      showStoreLocationForm: false
    }
  },

  created() {
    this.fetchDelivery()
    axios.get(this.get_delivery_companies).then((response) => {
      this.deliveryCompanies = response.data.data
    })
    axios.get(this.get_stores).then((response) => {
      this.stores = response.data.data
    })
  },
  methods: {
    checkLocation(id) {
      if (
        this.areaForm[id].delivery_company_id === 1 ||
        this.areaForm[id].delivery_company_id === '1'
      ) {
        axios.get(this.get_store_by_id + '/' + id).then((response) => {
          this.currentStore = response.data.data
          if (empty(this.currentStore.latitude)) {
            this.$refs.storeLocationForm.resetForm()
            this.$refs.storeLocationForm.storeForm.store_id = id
            $('#addStoreLocation').modal('show')
          }
        })
      }
    },
    fetchDelivery() {
      axios.get(this.get_delivery_type).then((response) => {
        this.areaForm = new Form(response.data.data)
      })
    },
    updateDelivery(id) {
      let $alert = $('#alert' + id)
      let self = this
      axios
        .post(this.update_delivery_type, this.areaForm[id])
        .then((response) => {
          if (response.data.status === true) {
            if ($alert.hasClass('alert-danger')) {
              $alert.removeClass('alert-danger')
            }
            setTimeout(function() {
              $alert.addClass('alert alert-success')
              $alert
                .append(
                  "<div class='alert alert-danger' id='alert_div" +
                    id +
                    "'></div>"
                )
                .text('Your delivery method updated successfully')
                .fadeTo(2000, 500)
                .slideUp(500, function() {
                  $('#alert_div' + id).remove()
                })
            }, 1)
          } else {
            if ($alert.hasClass('alert-success')) {
              $alert.removeClass('alert-success')
            }
            setTimeout(function() {
              $alert.addClass('alert alert-danger')
              $alert
                .append(
                  "<div class='alert alert-danger' id='alert_div" +
                    id +
                    "'></div>"
                )
                .text(response.data.error)
                .fadeTo(2000, 500)
                .slideUp(500, function() {
                  $('#alert_div' + id).remove()
                })
            }, 1)
            this.areaForm[id].delivery_company_id = 0
          }
        })
        .catch((errors) => {
          this.errors = errors.response.data.errors.delivery_company_id
          if ($alert.hasClass('alert-success')) {
            $alert.removeClass('alert-success')
          }
          setTimeout(function() {
            $alert.addClass('alert alert-danger')
            $alert
              .append(
                "<div class='alert alert-danger' id='alert_div" +
                  id +
                  "'></div>"
              )
              .text(self.errors[0])
              .fadeTo(2000, 500)
              .slideUp(500, function() {
                $('#alert_div' + id).remove()
              })
          }, 1)
        })
    }
  },
  computed: {
    deliveryMethodsIds() {
      return Object.keys(this.deliveryMethods).map((key) => {
        return key
      })
    }
  }
}
</script>

<style scoped>
.custom-checkbox
  .custom-control-input:indeterminate
  ~ .custom-control-label::before {
  border-color: #cddeeb !important;
  background-color: transparent !important;
}
</style>
