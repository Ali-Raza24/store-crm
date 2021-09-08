<template>
  <!--  <div
    class="nav nav-tabs scroll-bar-thin"
    id="pills-tab"
    role="tablist"
    aria-orientation="vertical"
  >
    <a
      :key="index"
      class="nav-link"
      :class="{ active: parseInt(list.id) === 1 }"
      :id="'#v' + index + '-tab'"
      data-toggle="pill"
      :href="'#v' + index"
      role="tab"
      aria-controls="'#v' + index"
      aria-selected="true"
      v-for="(list, index) in lists"
      @click="filterAreas(list)"
      style="display: flex; justify-content: space-between; position:relative;"
    >
      <span>
        {{ list.name }}
      </span>
      <span
        style="position:absolute; top:0; right:5px; bottom:0; display: flex; justify-content: center; align-items: center"
      >
        <i
          class="fa fa-edit p-2"
          title="Edit"
          style="color:grey"
          @click="editZone(list.id)"
        ></i>
        <i
          class="fa fa-trash p-2"
          title="Delete"
          style="color:red"
          @click="deleteZone(list.id)"
        ></i>
      </span>
    </a>
    <ConfirmDialog ref="confirmBox" />
  </div>-->
  <div class="zoneslisting">
    <v-card>
      <v-tabs
        vertical
        active-class="success"
        :class="'scroll-bar-thin'"
        style="max-width: 500px; overflow-y: scroll"
      >
        <v-tab
          v-for="(zone, index) in lists"
          :key="index"
          @click="filterAreas(zone)"
        >
          <v-list :key="'index' + index">
            <template>
              <v-list-item :key="index" class="d-flex justify-content-between">
                <v-list-item-content>
                  <v-list-item-title v-html="zone.name"></v-list-item-title>
                </v-list-item-content>
                <v-list-item-avatar>
                  <i
                    v-if="
                      zone_permissions.some(
                        (permission) => permission === 'zone-edit'
                      )
                    "
                    class="fa fa-edit p-2"
                    title="Edit"
                    style="color:grey"
                    @click="editZone(zone.id)"
                  ></i>
                  <i
                    v-if="
                      zone_permissions.some(
                        (permission) => permission === 'zone-delete'
                      )
                    "
                    class="far fa-trash-alt p-2"
                    title="Delete"
                    style="color:red"
                    @click="deleteZone(zone.id)"
                  ></i>
                </v-list-item-avatar>
              </v-list-item>
            </template>
          </v-list>
        </v-tab>
      </v-tabs>
    </v-card>
    <ConfirmDialog ref="confirmBox" />
  </div>
</template>

<script>
import ConfirmDialog from '../../../../Common/ConfirmDialog'
import Form from '../../../../../libs/Form'
export default {
  name: 'ZonesList',
  components: { ConfirmDialog },
  props: {
    zone_permission: {
      type: Boolean,
      default: false
    },
    zone_permissions: {
      type: [Array, Object],
      default: () => {}
    },
    lists: {
      type: [Array, Object],
      default: () => {}
    },
    save_zone_areas: {
      type: String,
      default: ''
    },
    get_active_area: {
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
    }
  },
  methods: {
    filterAreas(zone) {
      this.$store.commit('SET_ZONE_STATE_ID', [])
      this.$store.commit('SET_ZONE', zone)
      this.$store.commit('SET_ZONE_ID', zone.id)

      this.$parent.$refs.zones.$data.checkAll =
        this.selectedCount > 0 && this.zoneAreas.length === this.selectedCount
          ? 1
          : 0
    },
    async deleteZone(id) {
      let confirmation = await this.$refs.confirmBox.show({
        title: 'Delete Zone?',
        message: 'Are you sure you want to delete this zone?',
        okButton: 'Delete',
        cancelButton: 'Cancel'
      })
      if (confirmation) {
        axios.post(this.delete_zone_url + '/' + id).then((response) => {
          this.$parent.fetchZones()
        })
      }
    },
    editZone(id) {
      axios.get(this.get_zone_by_id + '/' + id).then((response) => {
        let zoneForm = new Form(response.data.data)
        this.$parent.$parent.$refs.addZone.setZoneForm(zoneForm)
        $('body').toggleClass('add-customer')
      })
    }
  },
  computed: {
    zone() {
      return this.$store.state.zone
    },
    selectedZonesList() {
      return this.$store.state.selectedZones.filter(
        (zone) => zone.zone_id === this.zone.id
      )
    },
    existingZone() {
      return this.$store.state.selectedZones
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
    selectedZoneAreaIds() {
      return Object.keys(this.existingZone).map((key) => {
        return this.existingZone[key].area_id
      })
    },
    selectedCount() {
      return this.selectedZonesList.filter(
        (area) => parseInt(area.zone_id) === this.zone.id
      ).length
    }
  }
}
</script>

<style scoped></style>
