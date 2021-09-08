<template>
  <section v-if="storeForm">
    <div class="row m-0 justify-content-center">
      <div class="col-lg-6 col-md-8 p-0">
        <div
          class="form-area d-flex align-items-center justify-content-center h-100"
        >
          <form class="outh-form" @submit.prevent="save">
            <div class="form-group radius-group padding-h-30 p-6">
              <Alert ref="alert" />
              <h2 class="login-title dark-one text-center">
                Create Your Store
              </h2>
              <div class="form-icon mt-5">
                <input
                  v-model="storeForm.stores[0].name"
                  type="text"
                  placeholder="Store Name"
                  class="form-control"
                  :class="{
                    'border-danger': storeForm.errors.has('stores.0.name')
                  }"
                />
                <div
                  class="input-info danger-bg"
                  v-if="storeForm.errors.has('stores.0.name')"
                >
                  <p>{{ storeForm.errors.first('stores.0.name') }}</p>
                </div>
              </div>
              <div class="form-icon">
                <select
                  v-model="storeForm.stores[0].industry_id"
                  class="form-control no-btn-radius"
                  :class="{
                    'border-danger': storeForm.errors.has(
                      'stores.0.industry_id'
                    )
                  }"
                >
                  <option value="0" selected disabled>
                    --Select Industry--</option
                  >
                  <option
                    :value="index"
                    v-for="(industry, index) in industries"
                    >{{ industry }}</option
                  >
                </select>
                <div
                  class="input-info danger-bg"
                  v-if="storeForm.errors.has('stores.0.industry_id')"
                >
                  <p>{{ storeForm.errors.first('stores.0.industry_id') }}</p>
                </div>
                <span>
                  <img
                    alt=""
                    :src="base_url + '/business_assets/images/angledown1.png'"
                  />
                </span>
              </div>
              <div class="form-icon">
                <select
                  v-model="storeForm.stores[0].state_id"
                  class="form-control no-btn-radius"
                  :class="{
                    'border-danger': storeForm.errors.has('stores.0.state_id')
                  }"
                >
                  <option value="0" selected disabled> --Select City--</option>
                  <option :value="index" v-for="(state, index) in states">{{
                    state
                  }}</option>
                </select>
                <div
                  class="input-info danger-bg"
                  v-if="storeForm.errors.has('stores.0.state_id')"
                >
                  <p>{{ storeForm.errors.first('stores.0.state_id') }}</p>
                </div>
                <span>
                  <img
                    alt=""
                    :src="base_url + '/business_assets/images/angledown1.png'"
                  />
                </span>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text border-0" id="basic-addon1">{{
                      app_url
                    }}</span>
                  </div>
                  <input
                    v-if="business_store_url !== ''"
                    type="text"
                    :value="business_store_url"
                    placeholder="Store Url"
                    class="form-control"
                    :disabled="business_store_url !== ''"
                    :class="{ 'border-danger': storeForm.errors.has('url') }"
                  />

                  <input
                    v-else
                    v-model="storeForm.url"
                    type="text"
                    placeholder="Store Url"
                    class="form-control"
                    :class="{ 'border-danger': storeForm.errors.has('url') }"
                  />
                  <div
                    class="input-info danger-bg"
                    v-if="storeForm.errors.has('url')"
                  >
                    <p>{{ storeForm.errors.first('url') }}</p>
                  </div>
                </div>
                <div
                  class="danger-text text-center mt-2"
                  v-if="business_store_url === ''"
                >
                  Business Url cannot be change after submitting
                </div>
              </div>
              <button class="btn btn-primary btn-rounded w-100 mt-4 mb-2">
                Create
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import Form from '../../../libs/Form'
import Alert from '../../Common/Alert'

export default {
  name: 'Create',
  components: { Alert },
  props: {
    save_url: {
      type: String,
      default: ''
    },
    app_url: {
      type: String,
      default: ''
    },
    industry_url: {
      type: String,
      default: ''
    },
    business_store_url: {
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
      storeForm: {
        stores: [
          {
            name: '',
            industry_id: 0,
            state_id: 0
          }
        ],
        url: ''
      },
      industries: [],
      states: []
    }
  },
  created() {
    this.storeForm = new Form(this.storeForm)
    axios.get(this.industry_url).then((response) => {
      this.industries = response.data.data
    })

    axios.get(this.states_url).then((response) => {
      this.states = response.data.data
    })
  },
  methods: {
    save() {
      this.storeForm.post(this.save_url).then((response) => {
        this.$refs.alert.set('success', response.message, true)
        setTimeout(function() {
          window.location.href =
            window.location.origin + '/store-admin/settings/general'
        }, 1000)
      })
    }
  }
}
</script>

<style scoped></style>
