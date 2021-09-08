<template>
  <div>
    <div class="card-repeat setting-general pb-3 mt-4">
      <NavTabs
        :zone_permissions="zone_permissions"
        :zone_permission="zone_permission"
      ></NavTabs>
      <div class="tab-content mt-5" id="nav-settingContent">
        <GeneralTab
          :get_stores="get_stores"
          :deliveryMethods="deliveryMethods"
          :update_delivery_type="update_delivery_type"
          :get_delivery_type="get_delivery_type"
          :get_delivery_companies="get_delivery_companies"
          :get_store_by_id="get_store_by_id"
          :save_store_locations_url="save_store_locations_url"
          :store_delivery_permission="store_delivery_permission"
        />
        <Areas
          :delete_area_url="delete_area_url"
          :get_delivery_type="get_delivery_store"
          :deliveryMethods="deliveryMethods"
          :base_url="base_url"
          :states_url="states_url"
          v-if="showAreaTab"
          :get_areas="get_areas"
          :get_business_areas="get_business_areas"
          :get_stores="get_stores"
          :save_business_areas="save_business_areas"
          :save_area_url="save_area_url"
          :get_area_by_id="get_area_by_id"
          :shipping_areas_permission="shipping_areas_permission"
        />
        <ZoneTab
          ref="zoneTab"
          :delete_zone_url="delete_zone_url"
          :business_zone_count="business_zone_count"
          :store_id="store_id"
          :get_delivery_type="get_delivery_store"
          :deliveryMethods="deliveryMethods"
          :get_stores="get_stores"
          v-if="showZoneTab && (zone_permission || zone_permissions.length > 0)"
          :save_zone_url="save_zone_url"
          :get_zone_url="get_zone_url"
          :get_active_area="get_active_area"
          :get_active_zone_areas="get_active_zone_areas"
          :save_zone_areas="save_zone_areas"
          :states_url="states_url"
          :get_zone_by_id="get_zone_by_id"
          :zone_permission="zone_permission"
          :zone_permissions="zone_permissions"
        />
        <add-zone
          ref="addZone"
          :delivery-methods="deliveryMethods"
          :get_stores="get_stores"
          :get_zone_url="get_zone_url"
          :save_zone_url="save_zone_url"
          :store_id="store_id"
        />
      </div>
    </div>
  </div>
</template>

<script>
import NavTabs from './NavTabs'
import GeneralTab from './GeneralTab'
import ZoneTab from './ZoneTab'
import Areas from './Areas'
import AddZone from './Partials/AddZone'

export default {
  name: 'Main',
  components: { AddZone, ZoneTab, GeneralTab, NavTabs, Areas },
  props: {
    store_id: {
      type: String,
      default: ''
    },
    business_zone_count: {
      type: Number,
      default: 0
    },
    states_url: {
      type: String,
      default: ''
    },
    save_area_url: {
      type: String,
      default: ''
    },
    get_areas: {
      type: String,
      default: ''
    },
    get_business_areas: {
      type: String,
      default: ''
    },
    get_stores: {
      type: String,
      default: ''
    },
    save_business_areas: {
      type: String,
      default: ''
    },
    save_zone_url: {
      type: String,
      default: ''
    },
    get_zone_url: {
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
    get_active_zone_areas: {
      type: String,
      default: ''
    },
    update_delivery_type: {
      type: String,
      default: ''
    },
    get_delivery_type: {
      type: String,
      default: ''
    },
    get_delivery_store: {
      type: String,
      default: ''
    },
    get_delivery_companies: {
      type: String,
      default: ''
    },
    delete_area_url: {
      type: String,
      default: ''
    },
    delete_zone_url: {
      type: String,
      default: ''
    },
    get_area_by_id: {
      type: String,
      default: ''
    },
    get_zone_by_id: {
      type: String,
      default: ''
    },
    get_store_by_id: {
      type: String,
      default: ''
    },
    save_store_locations_url: {
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
    },
    store_delivery_permission: {
      type: Boolean,
      default: false
    },
    shipping_areas_permission: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      base_url: this.$parent.$data.base_url,
      showGeneralTab: true,
      showAreaTab: false,
      showZoneTab: false,
      defaultDelivery: { 0: 'Own Delivery' },
      deliveryCompanies: []
    }
  },
  created() {
    axios.get(this.get_delivery_companies).then((response) => {
      this.deliveryCompanies = response.data.data
    })
    axios.get(this.get_delivery_store).then((response) => {
      this.$store.commit('SET_DELIVERY_COMPANY_ID', 0)
    })
    this.$store.commit('SET_DEFAULT_STORE', this.store_id)
  },
  computed: {
    deliveryMethods() {
      return { ...this.defaultDelivery, ...this.deliveryCompanies }
    }
  }
}
</script>

<style scoped>
@import './../../../../../../public/admin_assets/css/style.css';
@import './../../../../../../public/plugins/fontawesome/css/all.css';
@import 'https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css';
</style>
