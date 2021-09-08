<template>
  <div class=" scroll-bar-thin add-area add-customer-panel">
    <div class="add-customer-heading">
      <h3 class="dark-one font-weight-700">Add Area</h3>
      <span class="add-area-btn" @click="showForm">
        <img
          :src="base_url + '/admin_assets/images/close-black.png'"
          alt="image"
        />
      </span>
    </div>
    <form class="right-side-from" @submit.prevent="save">
      <div class="row">
        <div class="col-12 mt-3">
          <Alert ref="alert" style="display:block !important;" />
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="form-group">
            <label class="font-weight-normal">Name</label>
            <input
              v-model="areaForm.name"
              type="text"
              placeholder=""
              class="order-edit-control form-control"
              :class="{ 'danger-border': areaForm.errors.has('name') }"
              @input="removeError('name')"
            />
            <div
              class="input-info danger-bg"
              v-if="areaForm.errors.has('name')"
            >
              {{ areaForm.errors.first('name') }}
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="form-group">
            <div class="d-flex justify-content-between">
              <label class="font-weight-normal">City</label>
            </div>
            <div class="form-icon">
              <select
                class="order-edit-control form-control"
                v-model="areaForm.state_id"
                :class="{ 'danger-border': areaForm.errors.has('state_id') }"
                @input="removeError('state_id')"
              >
                <option value="0" selected disabled>--Select--</option>
                <option
                  :key="index"
                  :value="state.id"
                  v-for="(state, index) in states"
                  >{{ state.name }}</option
                >
              </select>
              <div
                class="input-info danger-bg"
                v-if="areaForm.errors.has('state_id')"
              >
                {{ areaForm.errors.first('state_id') }}
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
        <div class="col-12">
          <h4 class="dark-one font-weight-700 mt-4 mb-3">
            Geo Location
          </h4>
          <div class="form-group">
            <label>Search Address</label>
            <GmapAutocomplete
              :class="{ 'danger-border': areaForm.errors.has('address') }"
              ref="autocomplete"
              class="order-edit-control form-control"
              @place_changed="setPlace"
              :value="areaForm.address"
              :options="{
                fields: ['geometry', 'formatted_address', 'address_components']
              }"
              @input="removeError('address')"
            />
            <div
              class="input-info danger-bg"
              v-if="areaForm.errors.has('address')"
            >
              {{ areaForm.errors.first('address') }}
            </div>
          </div>
          <div class="form-group">
            <GmapMap
              class="mt-3"
              :center="center"
              :zoom="10"
              mapTypeId="roadmap"
              :fullscreenControl="false"
              :mapTypeControl="false"
              :streetViewControl="false"
              style="width:100%; height: 400px;"
            >
              <Gmap-Marker
                :draggable="true"
                @dragend="updateLocation"
                v-for="(marker, index) in markers"
                :key="index"
                :position="marker.position"
              ></Gmap-Marker>
            </GmapMap>
          </div>
        </div>
      </div>
      <div class="form-group">
        <button class="btn-primary btn-rounded btn-size">Save</button>
        <a
          href="javascript:void(0)"
          class="btn-gray btn-rounded btn-size add-area-btn"
          @click="showForm"
          >Cancel</a
        >
      </div>
    </form>
    <ConfirmDialog ref="confirmBox" />
  </div>
</template>

<script>
import Alert from '../../Common/Alert'
import Form from '../../../libs/Form'
import { OpenStreetMapProvider } from 'leaflet-geosearch'
import ConfirmDialog from '../../Common/ConfirmDialog'

export default {
  name: 'AddArea',
  components: { ConfirmDialog, Alert },
  props: {
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
    delete_area_url: {
      type: String,
      default: ''
    },
    edit_area: {
      type: [Array, Object, String],
      default: () => {}
    }
  },
  data() {
    return {
      center: { lat: 25.276987, lng: 55.296249 },
      base_url: this.$parent.$data.base_url,
      areaObj: {
        name: '',
        state_id: '',
        address: '',
        lat: '',
        lng: ''
      },
      areaForm: {
        name: '',
        state_id: '',
        address: '',
        lat: '',
        lng: ''
      },
      states: [],
      areas: [],
      currentPlace: null,
      markers: [],
      editArea: {}
    }
  },
  created() {
    if (this.edit_area === undefined) {
      this.areaForm = new Form(this.areaForm)
    } else {
      this.editArea = JSON.parse(this.edit_area)
      this.areaForm = new Form(this.editArea)
      this.center = {
        lat: parseFloat(this.editArea.lat),
        lng: parseFloat(this.editArea.lng)
      }
      this.markers.push({
        position: {
          lat: parseFloat(this.center.lat),
          lng: parseFloat(this.center.lng)
        }
      })
    }
    axios.get(this.states_url).then((response) => {
      this.states = response.data.data
    })
  },
  methods: {
    removeError(field) {
      this.areaForm.errors.clear(field)
    },
    async deleteArea() {
      let confirmation = await this.$refs.confirmBox.show({
        title: 'Confirm',
        message: 'Are you sure you want to delete this area?',
        okButton: 'Delete',
        cancelButton: 'Cancel'
      })
      if (confirmation) {
        axios
          .post(this.delete_area_url + '/' + this.areaForm.area_id)
          .then((response) => {
            window.location.reload()
          })
      }
    },
    setPlace(place) {
      this.currentPlace = place
      if (this.currentPlace) {
        this.markers.push({
          position: {
            lat: this.currentPlace.geometry.location.lat(),
            lng: this.currentPlace.geometry.location.lng()
          }
        })
        this.center = {
          lat: this.markers[0].position.lat,
          lng: this.markers[0].position.lng
        }
        this.areaForm.lat = this.center.lat
        this.areaForm.lng = this.center.lng
        this.areaForm.address = place.formatted_address
        this.currentPlace = null
      }
    },
    updateLocation(location) {
      this.center = { lat: location.latLng.lat(), lng: location.latLng.lng() }
      this.areaForm.lat = this.center.lat
      this.areaForm.lng = this.center.lng
    },
    showForm() {
      if (this.edit_area === undefined) {
        $('body').toggleClass('add-area')
        console.log(this.areaForm)
        this.areaForm = new Form(this.areaObj)
      } else {
        window.location.href = this.base_url + '/admin/areas'
      }
    },
    save() {
      $('.add-customer-panel').animate(
        {
          scrollTop: $('.add-customer-panel').offset().top
        },
        1000
      )
      let self = this
      this.areaForm.post(this.save_area_url).then((response) => {
        this.$refs.alert.set('success', response.message, true)
        setTimeout(function() {
          if (this.edit_area === undefined) {
            window.location.href = window.location.origin + '/admin/areas'
          } else {
            window.location.reload()
          }
        }, 1000)
      })
    }
  }
}
</script>

<style scoped>
.cursor-pointer > * {
  cursor: pointer !important;
}
#map {
  height: 400px;
  width: 100%;
}
.pac-container {
  top: 350px !important;
}
</style>
