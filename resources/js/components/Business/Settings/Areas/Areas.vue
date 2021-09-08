<template>
  <div
    class="tab-pane fade show active"
    id="Area"
    role="tabpanel"
    aria-labelledby="settStore"
  >
    <form>
      <Alert ref="alert" />
      <div class="row">
        <h4 class="col-6 font-weight-700 dark-one mb-4">
          Manage Delivery Areas
        </h4>
      </div>
      <div class="area-selected">
        <StatesList :lists="states"></StatesList>
        <div class="tab-content scroll-bar-thin w-100" id="pills-tabContent">
          <AreasTab
            :shipping_areas_permission="shipping_areas_permission"
            :selected_count="selectedBusinessAreas.length"
            ref="areasTab"
            :delete_area_url="delete_area_url"
            :areas="areasList"
            :save_business_areas="save_business_areas"
            :get_areas="get_areas"
            :get_business_areas="get_business_areas"
          ></AreasTab>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import StatesList from './Partials/StatesList'
import AreasTab from './Partials/AreasTab'
import Form from '../../../../libs/Form'
import Alert from '../../../Common/Alert'
export default {
  name: 'Areas',
  components: { Alert, AreasTab, StatesList },
  props: {
    states_url: {
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
    deliveryMethods: {
      type: [Array, Object],
      default: () => {}
    },
    get_delivery_type: {
      type: String,
      default: ''
    },
    save_area_url: {
      type: String,
      default: ''
    },
    delete_area_url: {
      type: String,
      default: ''
    },
    get_area_by_id: {
      type: String,
      default: ''
    },
    shipping_areas_permission: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      base_url: this.$parent.$data.base_url,
      states: [],
      delivery_company_id: '0',
      areaForm: {
        own_delivery: false,
        delivery_company_id: false,
        store: '',
        areas: []
      },
      areas: [],
      stores: []
    }
  },
  created() {
    this.areaForm = new Form(this.areaForm)
    axios.get(this.states_url).then((response) => {
      this.states = response.data.data
    })

    axios.get(this.get_stores).then((response) => {
      this.stores = response.data.data
    })

    this.fetchAreas()
  },
  methods: {
    fetchAreas() {
      axios.get(this.get_areas).then((response) => {
        this.areas = response.data.data
        this.$store.commit('SET_AREAS', this.areas)
      })
    },
    filterAreas() {
      this.$store.commit('SET_DELIVERY_COMPANY_ID', this.delivery_company_id)
      this.fetchAreas()
    },
    save() {
      this.areaForm.areas = this.$store.state.selectedAreas
      this.areaForm.post(this.save_business_areas).then((response) => {
        this.$refs.alert.set('success', 'Delivery areas updated', true)
      })
    }
  },
  computed: {
    areasList() {
      // if (this.$store.state.areasListByState.length === 0) {
      if (this.state_id) {
        let areas = this.$store.state.areasList
        let areasByState = areas.filter(
          (area) => parseInt(area.state_id) === parseInt(this.state_id)
        )
        this.$store.commit('SET_AREAS_BY_STATE', areasByState)
      }
      // }
      return this.$store.state.areasListByState
    },
    delivery_type() {
      return this.$store.state.delivery_company_id
    },
    selectedBusinessAreas() {
      let activeAreas = this.areasList.filter(
        (area) => area.state_id === this.state_id
      )

      return Object.keys(activeAreas).map((key) => {
        return activeAreas[key].area_id
      })
    },
    state_id() {
      return this.$store.state.state_id
    }
  }
}
</script>

<style scoped></style>
