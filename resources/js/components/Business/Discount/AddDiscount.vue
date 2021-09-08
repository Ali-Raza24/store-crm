<template>
  <div
    class="add-customer-panel scroll-bar-thin add-discount1"
    id="add-discountModal"
  >
    <div class="add-customer-heading">
      <h3 class="dark-one font-weight-700" v-if="isEdit === 'true'">
        Edit Discount
      </h3>
      <h3 class="dark-one font-weight-700" v-else>Add Discount</h3>
      <span class="add-discount-btn">
        <a
          id="bottle"
          :href="base_url + '/store-admin/discount'"
          v-if="isEdit === 'true'"
        >
          <img
            :src="base_url + '/business_assets/images/close-black.png'"
            alt="image"
          />
        </a>
        <a id="bottle" v-else>
          <img
            :src="base_url + '/business_assets/images/close-black.png'"
            alt="image"
          />
        </a>
      </span>
    </div>
    <Alert ref="alert" />
    <div class="alert alert-danger" v-if="errors.length > 0">
      Please fill all required fields
    </div>
    <form
      class="right-side-from"
      id="add-discount-form"
      @submit.prevent="save"
      v-if="discountForm.errors"
    >
      <div class="row">
        <div class="col-md-12">
          <div class="form-group mt-5 discount-code">
            <label>Discount Title</label>
            <input
              type="text"
              v-model="discountForm.title"
              class="form-control order-edit-control"
              :class="{ 'danger-border': discountForm.errors.has('title') }"
              @input="removeError('title')"
            />
            <div
              class="input-info danger-bg"
              v-if="discountForm.errors.has('title')"
            >
              <p>{{ discountForm.errors.first('title') }}</p>
            </div>
          </div>
          <div class="form-group discount-code">
            <label>Discount Code</label>
            <div class="form-icon">
              <input
                type="text"
                v-model="discountForm.code"
                class="form-control order-edit-control"
                :class="{ 'danger-border': discountForm.errors.has('code') }"
                @input="removeError('code')"
              />
              <div
                class="input-info danger-bg"
                v-if="discountForm.errors.has('code')"
              >
                <p>{{ discountForm.errors.first('code') }}</p>
              </div>
              <span @click="generateCode" style="cursor:pointer;"
                >Generate Code</span
              >
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 col-sm-12">
              <div class="form-group">
                <label>Max usage</label>
                <input
                  type="number"
                  v-model="discountForm.max_usage"
                  id="maximum_usage"
                  class="order-edit-control form-control"
                  :class="{
                    'danger-border': discountForm.errors.has('max_usage')
                  }"
                  @input="removeError('max_usage')"
                />
                <div
                  class="input-info danger-bg"
                  v-if="discountForm.errors.has('max_usage')"
                >
                  <p>{{ discountForm.errors.first('max_usage') }}</p>
                </div>
              </div>
            </div>
            <div
              class="col-md-6 col-sm-12 d-flex justify-content-start align-items-center"
            >
              <div class="form-group custom-checkbox align-items-center">
                <input
                  type="checkbox"
                  v-model="discountForm.auto_apply"
                  value="1"
                  class="custom-control-input"
                  id="auto-apply"
                />
                <label
                  class="custom-control-label w-100 h-100 pl-4"
                  for="auto-apply"
                  ><span class="pl-2">Auto Apply at Checkout</span></label
                >
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr />
      <h4 class="dark-one font-weight-700 mt-5 mb-4">Discount Type</h4>
      <div class="row">
        <div class="col-md-6 col-sm-6">
          <div class="form-group">
            <label>Discount Type</label>
            <div class="form-icon">
              <select
                v-model="discountForm.discount_type"
                class="order-edit-control form-control"
                :class="{
                  'danger-border': discountForm.errors.has('discount_type')
                }"
                @input="removeError('discount_type')"
                @change="checkDiscountType"
              >
                <option value="">--Select--</option>
                <option :value="1">Percentage</option>
                <option :value="2">Flat</option>
              </select>
              <div
                class="input-info danger-bg"
                v-if="discountForm.errors.has('discount_type')"
              >
                {{ discountForm.errors.first('discount_type') }}
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
          <div class="form-group" v-if="discountForm.discount_type === 2">
            <label>Discount Amount</label>
            <input
              type="number"
              v-model="discountForm.discount_amount"
              class="form-control order-edit-control"
              :class="{
                'border-danger': discountForm.errors.has('discount_amount')
              }"
              @input="removeError('discount_amount')"
            />
            <div
              class="input-info danger-bg"
              v-if="discountForm.errors.has('discount_amount')"
            >
              <p>{{ discountForm.errors.first('discount_amount') }}</p>
            </div>
          </div>
          <div class="form-group" v-else>
            <label>Discount %</label>
            <input
              type="number"
              v-model="discountForm.discount_percentage"
              class="form-control order-edit-control"
              :class="{
                'border-danger': discountForm.errors.has('discount_percentage')
              }"
              @input="removeError('discount_percentage')"
            />
            <div
              class="input-info danger-bg"
              v-if="discountForm.errors.has('discount_percentage')"
            >
              <p>{{ discountForm.errors.first('discount_percentage') }}</p>
            </div>
          </div>
        </div>
      </div>
      <h4 class="dark-one font-weight-700 mt-4 mb-4">Applies to</h4>
      <div class="form-group custom-checkbox">
        <input
          type="radio"
          name="allProducts"
          :value="1"
          v-model="discountForm.all_products"
          class="custom-control-input"
          id="All-Products"
          @click="toggleValue('products')"
        />
        <label class="custom-control-label w-100 h-100 pl-4" for="All-Products"
          ><span class="pl-2">All Products</span></label
        >
      </div>
      <div class="form-group custom-checkbox">
        <input
          type="radio"
          name="allProducts"
          class="custom-control-input"
          v-model="discountForm.all_products"
          id="Specific-Products1"
          :value="2"
        />
        <label
          class="custom-control-label w-100 h-100 pl-4"
          for="Specific-Products1"
          ><span class="pl-2">Specific Products</span></label
        >
      </div>

      <div class="from-group" v-if="discountForm.all_products === 2">
        <Select2
          v-model="discountForm.products"
          :options="productsList"
          :settings="{ multiple: true, placeholder: 'Please Select' }"
          :class="{
            'danger-border order-edit-control form-control p-0': discountForm.errors.has(
              'products.0'
            )
          }"
        />
        <div
          v-if="discountForm.errors.has('products.0')"
          class="input-info danger-bg ml-5 mr-5"
        >
          {{ discountForm.errors.first('products.0') }}
        </div>
      </div>

      <hr />
      <div class="form-group custom-checkbox">
        <input
          type="radio"
          name="min_qty_amount"
          class="custom-control-input"
          v-model="discountForm.min_qty_amount"
          id="min_purchase"
          :value="1"
        />
        <label class="custom-control-label w-100 h-100 pl-4" for="min_purchase"
          ><span class="pl-2">Minimum Purchase Amount</span></label
        >
      </div>
      <div class="col-md-6 col-sm-6" v-if="discountForm.min_qty_amount === 1">
        <div class="form-group">
          <label>Add Minimum Purchase Amount</label>
          <input
            type="number"
            v-model="discountForm.min_purchase_amount"
            id="min_purchase_amount"
            class="order-edit-control form-control"
            :class="{
              'danger-border': discountForm.errors.has('min_purchase_amount')
            }"
            @input="removeError('min_purchase_amount')"
          />
          <div
            class="input-info danger-bg"
            v-if="discountForm.errors.has('min_purchase_amount')"
          >
            {{ discountForm.errors.first('min_purchase_amount') }}
          </div>
        </div>
      </div>
      <div class="form-group custom-checkbox">
        <input
          type="radio"
          name="min_qty_amount"
          v-model="discountForm.min_qty_amount"
          class="custom-control-input"
          id="min-qty"
          :value="2"
        />
        <label class="custom-control-label w-100 h-100 pl-4" for="min-qty"
          ><span class="pl-2">Minimum Quantity of items</span></label
        >
      </div>
      <div class="col-md-6 col-sm-6" v-if="discountForm.min_qty_amount === 2">
        <div class="form-group">
          <label>Add Minimum Quantity of items</label>
          <input
            type="number"
            v-model="discountForm.min_qty_value"
            class="order-edit-control form-control"
            :class="{
              'danger-border': discountForm.errors.has('min_qty_value')
            }"
            @input="removeError('min_qty_val')"
          />
          <div
            class="input-info danger-bg"
            v-if="discountForm.errors.has('min_qty_value')"
          >
            <p>{{ discountForm.errors.first('min_qty_value') }}</p>
          </div>
        </div>
      </div>
      <hr />
      <h4 class="dark-one font-weight-700 mt-4 mb-4">Active Dates</h4>
      <div class="row">
        <div class="col-md-6 col-sm-6">
          <div class="form-group">
            <label>Start Date</label>
            <datetime
              v-model="discountForm.start_date"
              type="date"
              format="dd/MM/yyyy"
              :min-datetime="currentDate"
              :input-class="'form-control order-edit-control'"
              :class="{
                'danger-border': discountForm.errors.has('start_date')
              }"
              @input="removeError('start_date')"
            />
            <div
              class="input-info danger-bg"
              v-if="discountForm.errors.has('start_date')"
            >
              {{ discountForm.errors.first('start_date') }}
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="form-group">
            <label>Start time</label>
            <datetime
              v-model="discountForm.start_time"
              type="time"
              format="hh:mm:a"
              :input-class="'form-control order-edit-control'"
              :min-datetime="currentDate"
              :class="{
                'danger-border': discountForm.errors.has('start_time')
              }"
              @input="removeError('start_time')"
            />
            <div
              class="input-info danger-bg"
              v-if="discountForm.errors.has('start_time')"
            >
              {{ discountForm.errors.first('start_time') }}
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="form-group">
            <label>End Date</label>
            <datetime
              v-model="discountForm.end_date"
              type="date"
              format="dd/MM/yyyy"
              :min-datetime="discountForm.start_date"
              :input-class="'form-control order-edit-control'"
              :class="{
                'danger-border': discountForm.errors.has('end_date')
              }"
              @input="removeError('end_date')"
            />
            <div
              class="input-info danger-bg"
              v-if="discountForm.errors.has('end_date')"
            >
              {{ discountForm.errors.first('end_date') }}
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="form-group">
            <label>End time</label>
            <datetime
              v-model="discountForm.end_time"
              type="time"
              format="hh:mm:a"
              :input-class="'form-control order-edit-control'"
              :class="{
                'danger-border': discountForm.errors.has('end_time')
              }"
              @input="removeError('end_time')"
              :min-datetime="discountForm.start_time"
            />
            <div
              class="input-info danger-bg"
              v-if="discountForm.errors.has('end_time')"
            >
              {{ discountForm.errors.first('end_time') }}
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <button class="btn-size btn-rounded btn-primary ml-1 mr-1">
          Save Discount
        </button>
        <a
          class="btn-gray btn-rounded btn-size add-discount-btn"
          :href="base_url + '/store-admin/discount'"
          v-if="isEdit === 'true'"
          >Cancel</a
        >
        <a class="btn-gray btn-rounded btn-size add-discount-btn" v-else
          >Cancel</a
        >
      </div>
    </form>
  </div>
</template>

<script>
import Alert from '../../Common/Alert'
import Select2 from 'v-select2-component'
import Form from '../../../libs/Form'
import Datetime from '../../Common/Date/Datetime'
export default {
  name: 'AddDiscount',
  components: { Alert, Select2, Datetime },
  props: {
    products: {
      type: [Object, String, Array],
      required: true
    },
    save_discount_url: {
      type: String,
      required: true
    },
    generate_code_url: {
      type: String,
      required: true
    },
    isEdit: {
      type: String,
      default: 'false'
    },
    editDiscount: {
      type: [Object, Array],
      default: () => {}
    },
    currentDate: {
      type: String
    },
    existingDiscount: {
      type: [Array, String, Object]
    }
  },
  data() {
    return {
      base_url: this.$parent.$data.base_url,
      discount: {
        title: '',
        code: '',
        max_usage: '',
        auto_apply: false,
        discount_type: '',
        discount_percentage: '',
        discount_amount: '',
        all_products: 1,
        products: [],
        min_qty_amount: false,
        min_purchase_amount: '',
        min_qty_value: '',
        start_date: this.currentDate,
        start_time: this.currentDate,
        end_date: '',
        end_time: ''
      },
      discountForm: {}
    }
  },

  watch: {
    'discountForm.products': function(newValue, oldValue) {
      this.removeError('products.0')
    }
  },
  mounted() {
    if (this.existingDiscount) {
      this.discount = JSON.parse(this.existingDiscount)
    }
    this.discountForm = new Form(this.discount)
  },
  methods: {
    checkDiscountType() {
      if (this.discountForm.discount_type === 2) {
        this.discountForm.min_qty_amount = 1
      }
    },
    save() {
      $('.add-customer-panel').animate(
        {
          scrollTop: $('.add-customer-panel').offset().top
        },
        1000
      )
      this.discountForm.post(this.save_discount_url).then((response) => {
        if (this.discountForm.discount_id) {
          this.$refs.alert.set('success', 'Discount updated successfully', true)
        } else {
          this.$refs.alert.set('success', 'Discount added successfully', true)
        }
        setTimeout(function() {
          window.location.href =
            window.location.origin + '/store-admin/discount'
        }, 2000)
      })
    },
    generateCode() {
      axios.post(this.generate_code_url).then((response) => {
        this.discountForm.code = response.data.data.code
        this.discountForm.errors.clear('code')
      })
    },
    removeError($field) {
      console.log($field)
      this.discountForm.errors.clear($field)
    },
    toggleValue($field) {
      this.discountForm[$field] = ''
    }
  },
  computed: {
    productsList() {
      let list = JSON.parse(this.products)
      return Object.keys(list).map((key) => {
        return { id: key, text: list[key] }
      })
    },
    errors() {
      if (this.discountForm.errors) {
        return Object.keys(this.discountForm.errors.errors).map((key) => {
          return this.discountForm.errors.errors[key]
        })
      }
      return []
    }
  }
}
</script>

<style scoped>
@import './../../../../../public/business_assets/css/style.css';
@import './../../../../../public/css/datetime.css';
</style>
