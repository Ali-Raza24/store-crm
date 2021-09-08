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
          :class="{ ['disabled text-grey']: checkCount }"
        >
          <input
            type="checkbox"
            class="custom-control-input"
            id="Select-All"
            :checked="checkCount === true"
          />
          <label
            class="custom-control-label w-100 h-100 pl-4"
            for="Select-All"
            @click="selectAll"
          >
            <span class="pl-2">Activate All</span>
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
      </div>
      <div class="portfolio order-list-drop">
        <div
          :key="area.id"
          class="portfolio--project"
          data-category="AD"
          v-for="(area, index) in areas"
          :class="{ ['disabled cursor-blocked']: !shipping_areas_permission }"
        >
          <label
            :for="'areas' + area.id"
            class="filter-opt btn-gray cursor-pointer"
            :id="'selectedArea' + area.id"
            :class="{
              ['selected']: selectedMark(area),
              ['cursor-blocked']: !shipping_areas_permission
            }"
          >
            <input
              :id="'areas' + area.id"
              v-model="selectedAreas"
              type="checkbox"
              :value="area"
              class="d-none"
              @change="markActive(area, index)"
              :disabled="!shipping_areas_permission"
            />
            {{ area.title }}
          </label>
        </div>
      </div>
    </div>
    <ConfirmDialog ref="confirmBox" />
  </div>
</template>

<script>
import ConfirmDialog from '../../../../Common/ConfirmDialog'
export default {
  name: 'AreasTab',
  components: { ConfirmDialog },
  props: {
    shipping_areas_permission: {
      type: Boolean,
      default: false
    },
    areas: {
      type: [Array, Object],
      default: () => {}
    },
    get_business_areas: {
      type: String,
      default: ''
    },
    zone: {
      type: Boolean,
      default: false
    },
    save_business_areas: {
      type: String,
      default: ''
    },
    get_areas: {
      type: String,
      default: ''
    },
    delete_area_url: {
      type: String,
      default: ''
    },
    selected_count: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      selectedAreas: [],
      checkAll: 0,
      activeAreas: []
    }
  },
  created() {
    this.fetchSelectedAreas()
    this.fetchAreas()
  },
  methods: {
    fetchSelectedAreas() {
      axios.get(this.get_business_areas).then((response) => {
        this.activeAreas = response.data.data

        this.checkAll =
          this.selectedBusinessAreas.length > 0 &&
          this.selected_count === this.selectedBusinessAreas.length
            ? 1
            : 0
      })
    },
    fetchAreas() {
      axios.get(this.get_areas).then((response) => {
        this.$store.commit('SET_AREAS', response.data.data)
      })
    },
    selectAll() {
      let areas = []
      for (let i = 0; i < this.areas.length; i++) {
        areas[i] = this.areas[i]
        areas[i].is_active = 1
      }

      axios
        .post(this.save_business_areas, { areas: areas })
        .then((response) => {
          this.fetchSelectedAreas()
        })

      this.$store.commit('SET_SELECTED_AREAS', areas)
    },
    selectedMark(area) {
      return this.areas.some(
        (activeArea) =>
          this.selectedBusinessAreas.includes(activeArea.area_id) &&
          activeArea.id === area.id
      )
    },
    async markActive(area, index) {
      let areas = []
      areas.push({ ...this.areas[index] })
      let existingArea = this.areas.find((ar) => ar.area_id === area.area_id)
      let existing = this.activeAreas.some(
        (act_area) =>
          act_area.area_id === existingArea.area_id && act_area.zone > 0
      )

      if (existing) {
        let confirmation = await this.$refs.confirmBox.show({
          title: 'Confirm DeActivate?',
          message:
            'This area is associated with Zone. Are you sure you want to deactivate it?',
          okButton: 'Un-Select',
          cancelButton: 'Cancel'
        })
        if (confirmation) {
          axios
            .post(this.save_business_areas, { areas: areas })
            .then((response) => {
              this.fetchSelectedAreas()
            })

          this.$store.commit('SET_SELECTED_AREAS', areas)
        }
      } else {
        axios
          .post(this.save_business_areas, { areas: areas })
          .then((response) => {
            this.fetchSelectedAreas()
          })

        this.$store.commit('SET_SELECTED_AREAS', areas)
      }
    },
    deleteArea(id) {
      axios
        .post(this.delete_area_url + '/' + id)
        .then((response) => this.fetchAreas())
    },
    editArea(id) {
      this.$parent.editArea(id)
    }
  },
  computed: {
    selectedBusinessAreas() {
      let activeAreas = this.activeAreas.filter(
        (area) => area.state_id === this.state
      )

      return Object.keys(activeAreas).map((key) => {
        return activeAreas[key].area_id
      })
    },
    state() {
      return this.$store.state.state_id
    },
    selectedCount() {
      return this.selectedBusinessAreas.length
    },
    checkCount() {
      return this.areas.length === this.selectedCount
    }
  }
}
</script>

<style scoped>
.cursor-pointer {
  cursor: pointer;
}
.disabled,
[disabled],
fieldset[disabled] {
  cursor: not-allowed;
  pointer-events: none;
}

.filter-opt {
  margin: 0 !important;
}
.portfolio--project {
  margin-bottom: 10px !important;
}
.order-list-drop .portfolio--project .filter-opt span {
  font-weight: 600;
  display: flex !important;
}

.span {
  position: absolute;
  z-index: 0;
  top: 5px;
  right: 10px;
  width: 25px !important;
  font-size: 14px !important;
}

.span i {
  cursor: pointer;
  position: relative;
  display: flex;
  color: #ffffff;
  justify-content: center;
  align-items: center;
  margin: auto;
  border: 2px solid;
  border-color: #ffffff;
  border-radius: 100%;
  padding: 2px 2px 3px 5px;
}
i:hover {
  border-color: #444444 !important;
  color: #444444 !important;
}
.cursor-blocked {
  cursor: no-drop !important;
}

.disabled {
  cursor: not-allowed !important;
}
div[disabled] {
  cursor: not-allowed !important;
}
</style>
