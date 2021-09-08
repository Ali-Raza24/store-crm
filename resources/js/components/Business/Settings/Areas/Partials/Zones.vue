<template>
  <div
    class="tab-pane fade show active"
    id="vOne"
    role="tabpanel"
    aria-labelledby="vOne-tab"
  >
    <div class="area-selected-panel scroll-bar-thin">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <!--        <div
          class="custom-checkbox"
          :class="{ ['disabled text-grey']: checkCount === true }"
        >
          <input
            type="checkbox"
            class="custom-control-input"
            id="Select-All"
            :checked="checkCount === true"
            @input="selectAll"
          />
          <label class="custom-control-label w-100 h-100 pl-4" for="Select-All">
            <span class="pl-2">Select All</span>
          </label>
        </div>-->
        <v-app>
          <v-checkbox
            v-model="checkAll"
            label="Select All"
            :value="1"
            @click="selectAll"
          ></v-checkbox>
        </v-app>
        <span class="selcted-item primary-text font-weight-500"
          >{{ selectedCount }} Area(s) Selected</span
        >
        <div class="dropdown order-list-drop ml-3">
          <button
            class="dropdown-toggle"
            type="button"
            id="dropTFilter"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="true"
          >
            <img
              alt=""
              :src="
                $parent.$data.base_url + '/business_assets/images/filter.png'
              "
            />
            Filters
          </button>
          <div
            class="dropdown-menu dropdown-menu-right"
            aria-labelledby="dropTFilter"
            x-placement="top-end"
            style="position: absolute; transform: translate3d(-266px, -11px, 0px); top: 0px; left: 0px; will-change: transform;"
          >
            <div class="dropdown-box">
              <p class="dark-one font-weight-600">Filter by city</p>
              <label
                :key="index"
                v-for="(state, index) in states"
                :for="'state' + state.id"
                class="filter-opt btn-gray cursor-pointer"
                :id="'selectedState' + state.id"
                :class="{ ['selected']: selectedFilterMark(state.id) }"
              >
                <input
                  :id="'state' + state.id"
                  v-model="stateIds"
                  type="checkbox"
                  :value="state.id"
                  class="d-none"
                />
                {{ state.name }}
              </label>
            </div>
            <div class="drop-footer grey-one">
              <a
                href="javascript:void(0)"
                class="cancel-filter dark-two"
                @click="cancelFilter"
                data-toggle="dropdown"
              >
                Cancel</a
              >
              <a
                href="javascript:void(0)"
                class="apply-filter dark-one"
                data-toggle="dropdown"
                @click="applyFilter"
              >
                Apply
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="portfolio order-list-drop" v-if="zoneAreas">
        <div
          :key="area.id"
          class="portfolio--project"
          data-category="AD"
          v-for="(area, index) in zoneAreas"
        >
          <label
            :for="'areas' + area.id"
            class="filter-opt btn-gray cursor-pointer"
            :id="'selectedArea' + area.id"
            :class="{
              ['selected']: selectedMark(area)
            }"
          >
            <input
              :id="'areas' + area.id"
              v-model="selectedZones"
              type="checkbox"
              :value="area"
              class="d-none"
              @change="markActive(area, index)"
            />
            {{ area.title }}
            <div>
              <span class="d-inline" v-if="zone.days"
                >({{ zone.days + 'D ' }}</span
              ><span class="d-inline" v-else>(0D </span
              ><span class="d-inline" v-if="zone.hours_string"
                >{{ zone.hours_string + 'H ' }} </span
              ><span class="d-inline" v-else>0H </span
              ><span class="d-inline" v-if="zone.min"
                >{{ zone.min + 'M' }})</span
              ><span class="d-inline" v-else>0M)</span>- {{ zone.charges }} AED
            </div>
          </label>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Zones',
  props: {
    zone_permission: {
      type: Boolean,
      default: false
    },
    zone_permissions: {
      type: [Array, Object],
      default: () => {}
    },
    areas: {
      type: [Array, Object],
      default: () => {}
    },
    states: {
      type: [Array, Object],
      default: () => {}
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
    }
  },
  data() {
    return {
      selectedZones: [],
      stateIds: [],
      count: 1,
      checkAll: 0
    }
  },
  created() {
    this.fetchZoneAreas()
  },
  methods: {
    fetchZoneAreas() {
      axios.get(this.get_active_area).then((response) => {
        this.$store.commit('SET_ZONE_AREAS', response.data.data)
        this.isAllCheck()
      })
    },
    selectAll: function() {
      let areas = Object.keys(this.zoneAreas).map((key) => {
        return { area_id: this.zoneAreas[key].area_id, zone_id: this.zone.id }
      })
      if (this.checkCount) {
        axios
          .post(this.save_zone_areas, {
            areas: areas,
            all_unselect: true
          })
          .then((response) => {
            this.$parent.fetchSelectedZones()
          })
      } else {
        axios
          .post(this.save_zone_areas, {
            areas: areas
          })
          .then((response) => {
            this.$parent.fetchSelectedZones()
          })
      }
    },
    isAllCheck() {
      this.checkAll =
        this.selectedCount > 0 && this.zoneAreas.length === this.selectedCount
          ? 1
          : 0
    },
    selectedMark(area) {
      return (
        this.selectedZonesList.some(
          (x) => parseInt(x.area_id) === parseInt(area.area_id)
        ) &&
        this.selectedZoneAreaZoneIds.some(
          (x) => parseInt(x) === parseInt(this.zone.id)
        )
      )
    },
    selectedFilterMark(id) {
      return (
        this.stateIds.some((selected) => selected === id) ||
        this.$store.state.zone_state_ids.some((selected) => selected === id)
      )
    },
    markActive(area, index) {
      let exist = this.existingZone.find(
        (zone) => zone.area_id === area.area_id && zone.zone_id === this.zone.id
      )

      let areas = {}
      axios
        .post(this.save_zone_areas, {
          areas: [
            {
              area_id: area.area_id,
              zone_id: this.zone.id
            }
          ]
        })
        .then((response) => {
          this.$parent.fetchSelectedZones()
        })
    },
    applyFilter() {
      this.$store.commit('SET_ZONE_STATE_ID', this.stateIds)
    },
    cancelFilter() {
      this.stateIds = []
      this.$store.commit('SET_ZONE_STATE_ID', [])
    }
  },
  computed: {
    default_store_id() {
      return this.$store.state.default_store
    },
    zoneAreas() {
      return this.$store.state.zoneAreas.filter(
        (area) =>
          ((this.$store.state.zone_state_ids.length > 0
            ? this.$store.state.zone_state_ids.includes(area.state_id)
            : true) &&
            !this.selectedZoneAreaIds.includes(area.area_id)) ||
          this.currentZoneAreaIds.includes(area.area_id)
      )
    },
    currentZoneAreaIds() {
      return Object.keys(this.existingZone).map((key) => {
        return this.zone.id === this.existingZone[key].zone_id
          ? this.existingZone[key].area_id
          : 0
      })
    },
    existingZone() {
      return this.$store.state.selectedZones
    },
    selectedZonesList() {
      return this.$store.state.selectedZones.filter(
        (zone) => zone.zone_id === this.zone.id
      )
    },
    selectedZoneAreaIds() {
      return Object.keys(this.existingZone).map((key) => {
        return this.existingZone[key].area_id
      })
    },
    selectedZoneAreaZoneIds() {
      return Object.keys(this.selectedZonesList).map((key) => {
        return this.selectedZonesList[key].zone_id === this.zone.id
          ? this.selectedZonesList[key].zone_id
          : 0
      })
    },
    zone() {
      return this.$store.state.zone
    },
    selectedCount() {
      return this.selectedZonesList.filter(
        (area) => parseInt(area.zone_id) === this.zone.id
      ).length
    },
    store_id() {
      return this.$store.state.default_store
    },
    checkCount() {
      return this.selectedCount === this.zoneAreas.length
    }
  }
}
</script>

<style scoped>
.cursor-pointer {
  cursor: pointer;
}
.disabled {
  cursor: not-allowed !important;
}
div[disabled] {
  cursor: not-allowed !important;
}
</style>
