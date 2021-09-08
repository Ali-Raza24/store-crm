<template>
  <div class="col-filter">
    <div class="table-misc d-flex justify-content-between">
      <ul class="table-filter">
        <li data-toggle="modal" data-target="#impCsv">
          <img
            alt=""
            :src="base_url + '/admin_assets/images/download.png'"
          />Import
        </li>
        <li>
          <img alt="" :src="base_url + '/admin_assets/images/upload.png'" />
          Export
        </li>
        <li>
          <div class="dropdown order-list-drop">
            <button
              class="dropdown-toggle"
              type="button"
              id="dropTFilter"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <img alt="" :src="base_url + '/admin_assets/images/filter.png'" />
              Filters
            </button>
            <div
              class="dropdown-menu dropdown-menu-right"
              aria-labelledby="dropTFilter"
            >
              <div class="dropdown-box">
                <div class="form-group">
                  <label class="dark-one font-weight-600">City</label>
                  <Select2
                    v-model="selectedState"
                    :options="statesList"
                    :placeholder="'Multi select'"
                    :settings="{ multiple: true }"
                  />
                </div>
                <div class="form-group">
                  <label class="dark-one font-weight-600">Plan Type</label>
                  <div class="form-icon">
                    <select
                      class="form-control sm-radius-control white-border-control"
                    >
                      <option selected="">-- Multi Select --</option>
                      <option>select</option>
                    </select>
                    <span>
                      <img
                        alt=""
                        :src="base_url + '/admin_assets/images/angledown.png'"
                      />
                    </span>
                  </div>
                </div>
                <div class="form-group">
                  <div class="dropdown-box mb-3">
                    <p class="dark-one font-weight-600">
                      Business Registration
                    </p>
                    <div class="date-picker">
                      <div class="form-group form-icon">
                        <input type="date" class="form-control" />
                        <span>
                          <img
                            alt=""
                            :src="base_url + '/admin_assets/images/calle.png'"
                          />
                        </span>
                      </div>
                      <div class="form-group text-center">to</div>
                      <div class="form-group form-icon">
                        <input type="date" class="form-control" />
                        <span>
                          <img
                            alt=""
                            :src="base_url + '/admin_assets/images/calle.png'"
                          />
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="drop-footer grey-one">
                <a href="javascript:void(0)" class="cancel-filter dark-two"
                  >Cancel</a
                >
                <a
                  href="javascript:void(0)"
                  class="apply-filter dark-one"
                  @click="applyFilter"
                >
                  Apply
                </a>
              </div>
            </div>
          </div>
        </li>
        <li>
          <a
            href="javascript:void(0)"
            class="btn-size btn-rounded btn-primary add-business-btn mobile-hide"
            @click="showForm"
            >Add Businesses</a
          >
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import Select2 from 'v-select2-component'
export default {
  name: 'Filters',
  components: { Select2 },
  props: {
    url: {
      type: String,
      default: ''
    },
    state_url: {
      type: String,
      default: ''
    }
  },
  data: function() {
    return {
      base_url: this.url,
      states: [],
      selectedState: []
    }
  },
  computed: {
    statesList() {
      return Object.keys(this.states).map((key) => {
        return { id: key, text: this.states[key] }
      })
    }
  },
  mounted() {
    axios.get(this.state_url).then((response) => {
      this.states = response.data.data
    })
  },
  methods: {
    showForm() {
      $('body').toggleClass('add-customer')
    },
    applyFilter() {}
  }
}
</script>

<style scoped>
@import './../../../../../../public/business_assets/css/style.css';
</style>
