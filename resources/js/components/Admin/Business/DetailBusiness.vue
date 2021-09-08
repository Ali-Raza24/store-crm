<template>
  <section v-if="businessForm">
    <div class="row">
      <div class="col">
        <div class="header-lefter mobile-title desktop-hide text-center mt-4">
          <h2 class="dark-one font-weight-700 text-center">
            Agree to Subscribe
          </h2>
        </div>
      </div>
    </div>
    <div class="location-update pt-4">
      <div class="row align-items-center">
        <div class="col-6">
          <div class="custom-checkbox">
            <input
              type="checkbox"
              class="custom-control-input"
              id="customCheck1"
            />
            <label
              class="custom-control-label w-100 h-100 pl-4"
              for="customCheck1"
            >
              <span class="pl-2">Agree to Subscribe</span>
            </label>
          </div>
        </div>
        <div class="col-6 pl-0">
          <div class="text-right">
            <a
              class="btn-size btn-rounded btn-primary"
              :href="base_url + '/admin/business/edit/' + $route.params.id"
            >
              Edit Business
            </a>
          </div>
        </div>
      </div>
    </div>
    <Alert ref="alert" class="mt-2" />
    <div class="row counter-wrapp scroller-h mb-4">
      <CounterBox
        :url="base_url"
        title="Branches"
        border-color="primary"
        text-color="primary"
        total="45"
        extra-class="mt-lg-4 mt-3"
      ></CounterBox>
      <CounterBox
        :url="base_url"
        title="Total Sales"
        border-color="primary"
        text-color="primary"
        total="1854"
        extra-class="mt-lg-4 mt-3"
      >
        <template #currency>$</template>
      </CounterBox>
      <CounterBox
        :url="base_url"
        title="Number of Products"
        border-color="success"
        text-color="success"
        total="10241"
        extra-class="mt-lg-4 mt-3"
      ></CounterBox>
      <CounterBox
        :url="base_url"
        title="Paid Invoice"
        border-color="danger"
        text-color="danger"
        total="26"
        extra-class="mt-lg-4 mt-3"
      ></CounterBox>
    </div>
    <div class="customer-panel">
      <div class="row align-items-center">
        <div class="col-md-4 col-sm-12 text-center">
          <div class="customer-img-panel">
            <div class="basic-customer">
              <span>
                <img
                  v-if="businessForm.imagesList.url === ''"
                  :src="base_url + '/admin_assets/images/customer-img.png'"
                  alt="image"
                />
                <img
                  v-else
                  :src="businessForm.imagesList.thumbnail"
                  alt="image"
                  width="100%"
                />
              </span>
              <p>{{ businessForm.plan }}</p>
            </div>
            <h3 class="dark-one font-weight-700 mt-3">
              {{ businessForm.name }}
            </h3>
          </div>
        </div>
        <div class="col-md-8 col-sm-12 b-l">
          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="customer-detail-panel">
                <h6 class="dark-one">Admin Name</h6>
                <p>{{ businessForm.owner_name }}</p>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="customer-detail-panel">
                <h6 class="dark-one">Admin Email</h6>
                <p>{{ businessForm.owner_email }}</p>
              </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-6">
              <div class="customer-detail-panel">
                <h6 class="dark-one">Admin Mobile</h6>
                <p>{{ businessForm.owner_mobile }}</p>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="customer-detail-panel">
                <h6 class="dark-one">
                  Business Name
                </h6>
                <p>{{ businessForm.name }}</p>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="customer-detail-panel">
                <h6 class="dark-one">
                  Email
                </h6>
                {{ businessForm.email }}
              </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-6">
              <div class="customer-detail-panel">
                <h6 class="dark-one">
                  Phone
                </h6>
                <p>{{ businessForm.mobile }}</p>
              </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7">
              <div class="customer-detail-panel">
                <h6 class="dark-one">
                  Address
                </h6>
                {{ businessForm.address_1 }}
              </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5">
              <div class="customer-detail-panel">
                <h6 class="dark-one">
                  Brand Color
                </h6>
                <div
                  :style="
                    'width: 50px; height: 30px; background-color:' +
                      businessForm.brand_color
                  "
                ></div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="customer-detail-panel">
                <h6 class="dark-one">KYC Detail</h6>
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                  do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                  Ut enim ad minim veniam, quis nostrud exercitation ullamco
                  laboris nisi.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-md-12 table-filter-wrap">
        <div class="col-filter">
          <nav class="tabs-head mobile-hide" id="allOrders">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <a
                class="nav-item nav-link active"
                id="Staff-Accounts-tab"
                data-toggle="tab"
                href="#Staff-Accounts"
                role="tab"
                aria-selected="true"
                >Staff Accounts</a
              >
              <a
                class="nav-item nav-link"
                id="Transaction-History-tab"
                data-toggle="tab"
                href="#Transaction-History"
                role="tab"
                aria-selected="true"
                >Transaction History</a
              >
            </div>
          </nav>
          <div class="dropdown tabs-dropdown desktop-hide">
            <button
              class="dropdown-toggle"
              type="button"
              id="dropTab"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              Staff Accounts
            </button>
            <div class="dropdown-menu" aria-labelledby="dropTab">
              <a class="nav-item nav-link active" href="javascript:void(0)"
                >Staff Accounts</a
              >
              <a class="nav-item nav-link" href="javascript:void(0)"
                >Transaction History</a
              >
            </div>
          </div>
        </div>
        <div class="col-filter">
          <div class="table-misc d-flex justify-content-between">
            <div class="form-group form-icon all-transection mb-0 mobile-hide">
              <select class="form-control">
                <option>All Transacions</option>
                <option>All Transacions</option>
                <option>All Transacions</option>
              </select>
              <span>
                <img
                  alt=""
                  :src="base_url + '/admin_assets/images/angledown1.png'"
                />
              </span>
            </div>
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
              <div class="form-group text-center">
                to
              </div>
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
    </div>
    <hr class="m-0" />
    <div class="tab-content" id="nav-tabContent">
      <div
        class="tab-pane fade show active"
        id="Staff-Accounts"
        role="tabpanel"
        aria-labelledby="Staff-Accounts"
      >
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive scroll-bar-thin">
              <table class="table table-space table-check bor-input.table">
                <thead>
                  <tr>
                    <th scope="col" class="custom-checkbox">
                      <input
                        type="checkbox"
                        class="custom-control-input"
                        id="customCheck"
                      />
                      <label
                        class="custom-control-label"
                        for="customCheck"
                      ></label>
                    </th>
                    <th scope="col">Account Name</th>
                    <th scope="col">Role</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="custom-checkbox">
                      <input
                        type="checkbox"
                        class="custom-control-input"
                        id="customCheck3"
                      />
                      <label
                        class="custom-control-label"
                        for="customCheck3"
                      ></label>
                    </td>
                    <td>
                      <div class="table-order-no">
                        <strong class="dark-one">
                          <a href="#">John Smith</a>
                        </strong>
                        <p class="mb-0">
                          johnsmith23
                        </p>
                      </div>
                    </td>
                    <td><p class="mb-0 order-name">Admin</p></td>
                    <td>
                      <p class="mb-0 order-total">+1 1254 3546</p>
                      <p class="mb-0 order-total">johnsmith@gmail.com</p>
                    </td>
                    <td><p class="mb-0 order-name">Active</p></td>
                    <td>
                      <div class="w-100">
                        <a
                          href=""
                          class="btn-size btn-rounded btn-light danger-text"
                          >Suspend User</a
                        >
                      </div>
                    </td>
                    <td>
                      <div class="table-action">
                        <a href="javascript:void(0)" class="edit-order">
                          <img
                            alt=""
                            :src="base_url + '/admin_assets/images/edit.png'"
                          />
                        </a>
                        <a href="javascript:void(0)" class="print-order">
                          <img
                            alt=""
                            :src="
                              base_url + '/admin_assets/images/delete-gray.png'
                            "
                          />
                        </a>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div
        class="tab-pane fade"
        id="Transaction-History"
        role="tabpanel"
        aria-labelledby="Transaction-History"
      >
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive scroll-bar-thin">
              <table class="table table-space table-check">
                <thead>
                  <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Type</th>
                    <th scope="col">Description</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Ref ID</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <div class="table-order-no">
                        <strong class="dark-one">14 Nov, 2020</strong>
                      </div>
                    </td>
                    <td><p class="mb-0">Membership Fee</p></td>
                    <td><p class="mb-0">Subscription Renewal Charges</p></td>
                    <td><p class="mb-0">AED 20.00</p></td>
                    <td><p class="mb-0 primary-text">292644890</p></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import Form from '../../../libs/Form'
import Pagination from '../../Common/Pagination'
import CounterBox from '../../Common/CounterBox'
import Alert from '../../Common/Alert'

export default {
  name: 'DetailBusiness',
  components: { Alert, CounterBox },
  props: {
    get_url: {
      type: String,
      default: ''
    }
  },
  data: function() {
    return {
      businessForm: null,
      base_url: this.$parent.$data.base_url,
      business_types: [],
      countries: [],
      states: [],
      industries: []
    }
  },
  created() {
    this.fetchBusiness()
  },
  methods: {
    fetchBusiness() {
      let id = this.$route.params.id
      axios.get(this.get_url + '/' + id).then((response) => {
        this.businessForm = new Form(response.data.data)
      })
    }
  }
}
</script>

<style scoped>
.active {
  margin-right: 0;
}
</style>
