<template>
  <div>
    <div
      class="modal fade customer-modal"
      id="addStoreLocation"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
    >
      <form class="" @submit.prevent="save">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <h3 class="font-weight-700 dark-one mb-2">
                Store Locations
              </h3>
              <Alert ref="alert"></Alert>
              <div class="mt-4 mb-4 w-75 ml-auto mr-auto">
                <div class="form-group text-left">
                  <label class="font-weight-600 dark-one mb-2"
                    >Select store location</label
                  >
                  <GmapAutocomplete
                    :class="{
                      'danger-border': storeForm.errors.has('address')
                    }"
                    ref="autocomplete"
                    class="order-edit-control form-control"
                    @place_changed="setPlace"
                    :value="storeForm.address"
                    :options="{
                      fields: [
                        'geometry',
                        'formatted_address',
                        'address_components'
                      ]
                    }"
                  />
                  <div
                    class="input-info danger-bg"
                    v-if="storeForm.errors.has('address')"
                  >
                    {{ storeForm.errors.first('address') }}
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
              <a
                href="javascript:void(0)"
                class="btn-size btn-rounded btn-gray ml-1 mr-1"
                data-dismiss="modal"
              >
                Cancel
              </a>
              <button class="btn-size btn-rounded btn-primary ml-1 mr-1">
                Update
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Form from '../../../../../libs/Form'
import Alert from '../../../../Common/Alert'

export default {
  name: 'StoreLocation',

  props: {
    save_store_locations_url: {
      type: String,
      default: ''
    },
    update_delivery_type: {
      type: String,
      default: ''
    }
  },

  components: {
    Alert
  },

  data: function() {
    return {
      center: { lat: 25.276987, lng: 55.296249 },
      storeFormObj: {
        lat: '',
        lng: '',
        store_id: 0,
        address: ''
      },
      storeForm: [],
      currentPlace: null,
      markers: []
    }
  },

  created: function() {
    this.storeForm = new Form(this.storeFormObj)
  },

  methods: {
    resetForm() {
      this.storeForm.lat = ''
      this.storeForm.lng = ''
      this.storeForm.store_id = 0
      this.storeForm.address = ''
    },
    save() {
      this.storeForm.post(this.save_store_locations_url).then((response) => {
        this.$refs.alert.set('success', response.message, true)
        var self = this
        setTimeout(function() {
          $('#addStoreLocation').modal('hide')
        }, 2000)
      })
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
        this.storeForm.lat = this.center.lat
        this.storeForm.lng = this.center.lng
        this.storeForm.address = place.formatted_address
        this.currentPlace = null
      }
    },
    updateLocation(location) {
      this.center = { lat: location.latLng.lat(), lng: location.latLng.lng() }
      this.storeForm.lat = this.center.lat
      this.storeForm.lng = this.center.lng
    }
  }
}
</script>

<style scoped>
#map {
  height: 400px;
  width: 100%;
}
.pac-container {
  top: 350px !important;
}
</style>
