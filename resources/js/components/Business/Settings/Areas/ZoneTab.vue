<template>
  <div
    class="tab-pane fade show active"
    id="Zones"
    role="tabpanel"
    aria-labelledby="settAccount"
  >
    <div class="col-12">
      <div class="row" v-if="parseInt(business_zone_count) > 0">
        <h4 class="col-6 font-weight-700 dark-one mb-4">
          Manage Zones Areas
        </h4>
      </div>

      <div
        class="row"
        v-if="parseInt(business_zone_count) > 0 && !checkEmpty(stores)"
      >
        <div class="col-md-6">
          <div class="form-icon">
            <select
              v-model="defaultStore"
              class="form-control order-edit-control"
              @change="updateStoreState"
            >
              <option
                v-for="(store, index) in stores"
                :key="index"
                :value="index"
              >
                {{ store }}</option
              >
            </select>
            <span>
              <img
                alt=""
                :src="base_url + '/business_assets/images/angledown.png'"
              />
            </span>
          </div>
        </div>
        <div class="col-md-6 col-12 form-group" v-if="!checkEmpty(stores)">
          <div class="form-icon">
            <select
              @change="updateStoreState"
              class="order-edit-control form-control"
              v-model="delivery_company_id"
              disabled
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
        </div>
        <div class="col-12">
          <div
            class="text-danger text-center mt-3 font-weight-600"
            v-if="zones.length === 0 && !delivery_company_id"
          >
            No zone found
          </div>
        </div>
      </div>
      <div class="row" v-if="parseInt(business_zone_count) > 0">
        <div class="col-md-12">
          <div class="area-selected" v-if="zones.length > 0">
            <zones-list
              :get_zone_by_id="get_zone_by_id"
              :delete_zone_url="delete_zone_url"
              :lists="zones"
              :save_zone_areas="save_zone_areas"
              :get_active_area="get_active_area"
              :zone_permissions="zone_permissions"
            ></zones-list>
            <div
              class="tab-content scroll-bar-thin w-100"
              id="pills-tabContent"
            >
              <Zones
                ref="zones"
                :states="states"
                :get_active_area="get_active_area"
                :save_zone_areas="save_zone_areas"
                :get_active_zone_areas="get_active_zone_areas"
              ></Zones>
            </div>
          </div>
        </div>
      </div>

      <hr class="mt-5 mb-3" />
      <div class="d-flex text-right justify-content-end">
        <a
          href="javascript:void(0)"
          class="btn-size btn-rounded btn-primary add-customer-btn"
          @click="toggleForm"
          v-if="
            zone_permissions.some((permission) => permission === 'zone-create')
          "
          >Add New Zone</a
        >
      </div>
    </div>
  </div>
</template>

<script>
import Zones from './Partials/Zones'
import ZonesList from './Partials/ZonesList'

export default {
  name: 'ZoneTab',
  components: {
    ZonesList,
    Zones
  },
  props: {
    store_id: {
      type: String,
      default: ''
    },
    business_zone_count: {
      type: Number,
      default: 0
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
    },
    get_active_area: {
      type: String,
      default: ''
    },
    save_zone_areas: {
      type: String,
      default: ''
    },
    states_url: {
      type: String,
      default: ''
    },
    get_active_zone_areas: {
      type: String,
      default: ''
    },
    deliveryMethods: {
      type: [Array, Object],
      default: () => {}
    },
    get_delivery_type: {
      type: String,
      default: ''
    },
    delete_zone_url: {
      type: String,
      default: ''
    },
    get_zone_by_id: {
      type: String,
      default: ''
    },
    zone_permission: {
      type: Boolean,
      default: false
    },
    zone_permissions: {
      type: [Array, Object],
      default: () => {}
    }
  },
  data() {
    return {
      base_url: this.$parent.$data.base_url,
      delivery_company_id: 0,
      stores: [],
      zones: [],
      zone_areas: [],
      states: [],
      defaultStore: parseInt(this.store_id) || 0
    }
  },
  created() {
    axios
      .get(this.get_stores)
      .then((response) => (this.stores = response.data.data))

    axios.get(this.states_url).then((response) => {
      this.states = response.data.data
    })
    this.updateStoreState()
  },

  methods: {
    checkEmpty(val) {
      return empty(val)
    },
    fetchSelectedZones() {
      let delivery = 0
      if (this.delivery_company_id !== 0) {
        delivery = this.delivery_company_id
      }
      axios
        .get(
          this.get_active_zone_areas +
            '?store_id=' +
            this.default_store_id +
            '&delivery_company_id=' +
            delivery
        )
        .then((response) => {
          this.$store.commit('SET_SELECTED_ZONES', response.data.data)
          this.$refs.zones.isAllCheck()
        })
    },
    fetchAreas() {
      this.$store.commit('SET_DELIVERY_COMPANY_ID', 0)
      this.fetchZones()
    },
    fetchZones() {
      let delivery = 0
      if (this.delivery_company_id !== 0) {
        delivery = this.delivery_company_id
      }
      axios
        .get(
          this.get_zone_url +
            '?store_id=' +
            this.default_store_id +
            '&delivery_company_id=' +
            delivery
        )
        .then((response) => {
          this.zones = response.data.data
          if (this.zones.length > 0) {
            this.$store.commit('SET_ZONE_ID', this.zones[0].id)
            this.$store.commit('SET_ZONE', this.zones[0])
          }
        })
    },
    updateStoreState() {
      this.$store.commit('SET_DEFAULT_STORE', this.defaultStore)
      this.fetchSelectedZones()
      this.fetchZones()
    },
    toggleForm() {
      // console.log(this.$parent.$refs)
      this.$parent.$refs.addZone.$data.zoneForm.clear()
      this.$parent.$refs.addZone.$data.zoneForm.delivery_company_id = 0
      this.$parent.$refs.addZone.$refs.alert.reset()
      $('body').toggleClass('add-customer')
    }
  },
  computed: {
    default_store_id() {
      return this.$store.state.default_store
    },
    defaultCompanyId() {
      return this.$store.state.delivery_company_id
    }
  }
}
</script>

<style scoped></style>
