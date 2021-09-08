<template>
  <div>
    <div
      class="tab-pane fade in show pro-table-seting pb-4"
      id="settBarnds"
      role="tabpanel"
      aria-labelledby="settBarnds"
    >
      <Alert ref="alert"></Alert>
      <div class="d-flex justify-content-between align-items-center">
        <h4 class="font-weight-700 dark-one">All Brands</h4>
        <a
          class="btn-size btn-rounded btn-primary"
          href="#"
          data-toggle="modal"
          data-target="#addNewbrand"
          @click="showForm"
          v-if="
            brand_permissions.some(
              (permission) => permission === 'brand-create'
            )
          "
        >
          Add New
        </a>
      </div>
      <div class="table-responsive scroll-bar-thin">
        <table class="table table-space table-check">
          <thead>
            <tr>
              <th
                scope="col"
                class="custom-checkbox"
                v-if="bulk_permissions.length > 0"
              >
                <input
                  type="checkbox"
                  class="custom-control-input"
                  id="selectAll"
                  @change="selectItems"
                />
                <label class="custom-control-label" for="selectAll">
                  <span class="ml-4">All</span>
                </label>
              </th>
              <th scope="col">Brand Name</th>
              <th
                scope="col"
                v-if="
                  brand_permissions.some(
                    (permission) => permission === 'brand-status'
                  )
                "
              >
                Status
              </th>
              <th
                scope="col"
                v-if="
                  brand_permissions.some(
                    (permission) =>
                      permission === 'brand-edit' ||
                      permission === 'brand-delete'
                  )
                "
              >
                Actions
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(brand, index) in brandsList">
              <td
                class="custom-checkbox show-selected"
                v-if="bulk_permissions.length > 0"
              >
                <input
                  type="checkbox"
                  v-model="selectedItemsIds[index].value"
                  @change="MultiSelectRecords"
                  :value="brand.id"
                  class="custom-control-input list-checkbox "
                  :id="'customCheckk' + index"
                />
                <label
                  class="custom-control-label"
                  :for="'customCheckk' + index"
                ></label>
              </td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="pro-thumb" v-if="brand.image.thumbnail">
                    <img
                      alt=""
                      :src="brand.image.thumbnail"
                      style="width: 70px; height: 70px"
                    />
                  </div>

                  <div class="table-order-no ml-3">
                    <strong class="dark-one"
                      ><a href="#">{{ brand.title }}</a></strong
                    >
                    <p class="mb-0">{{ brand.created_at }}</p>
                  </div>
                </div>
              </td>
              <td>
                <div
                  class="dropdown"
                  v-if="
                    brand_permissions.some(
                      (permission) => permission === 'brand-status'
                    )
                  "
                >
                  <span
                    v-if="brand.is_active === 1"
                    class="dropdown-toggle"
                    id="dropStore1"
                    role="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    Active
                  </span>
                  <span
                    v-if="brand.is_active === 2"
                    class="dropdown-toggle"
                    id="dropStore1"
                    role="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    Inactive
                  </span>
                  <div
                    class="dropdown-menu dropdown-menu-right"
                    aria-labelledby="dropStore1"
                  >
                    <a
                      class="dropdown-item"
                      href="javascript:void(0)"
                      @click="statusChangeOnClick(brand.id, 1)"
                    >
                      active
                    </a>
                    <a
                      class="dropdown-item"
                      href="javascript:void(0)"
                      @click="statusChangeOnClick(brand.id, 2)"
                    >
                      Inactive
                    </a>
                  </div>
                </div>
              </td>

              <td
                v-if="
                  brand_permissions.some(
                    (permission) =>
                      permission === 'brand-edit' ||
                      permission === 'brand-delete'
                  )
                "
              >
                <div class="table-action">
                  <a
                    href="#"
                    class="edit-order mr-3"
                    data-toggle="modal"
                    data-target="#addNewbrand"
                    @click="showFormEdit(brand.id)"
                    v-if="
                      brand_permissions.some(
                        (permission) => permission === 'brand-edit'
                      )
                    "
                  >
                    <img
                      alt=""
                      :src="base_url + '/business_assets/images/edit1.png'"
                    />
                  </a>
                  <a
                    href="javascript:void(0)"
                    class="print-order"
                    data-toggle="modal"
                    data-target="#sureRefund"
                    @click="confirmDelete(brand.id)"
                    v-if="
                      brand_permissions.some(
                        (permission) => permission === 'brand-delete'
                      )
                    "
                  >
                    <img
                      alt=""
                      :src="base_url + '/business_assets/images/delete.png'"
                    />
                  </a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="d-flex justify-content-between">
        <p class="ml-5">
          Showing {{ paginate.from }} - {{ paginate.to }} of
          {{ paginate.total }} records
        </p>
        <pagination
          :data="paginate"
          @pagination-change-page="fetch"
          :limit="limit"
          :show-disabled="showDisabled"
          :size="size"
          :align="align"
        ></pagination>
      </div>
    </div>

    <add-brand
      :base_url="base_url"
      ref="addBrand"
      :add_url="add_brand_url"
      v-if="
        brand_permissions.some((permission) => permission === 'brand-create') ||
          brand_permissions.some((permission) => permission === 'brand-edit')
      "
    ></add-brand>
    <confirm-dialog ref="confirmBox"> </confirm-dialog>
    <DeleteStatusChangePopUp
      v-if="bulk_permissions.length > 0"
      :permissions="bulk_permissions"
      status_title="Brands"
      :bulk_status_url="brands_status_change_confirmation_url"
      :selectedItemsIds="selectedItemsIds"
      :selected_items="checkedItems"
      :current_page="paginate.current_page"
      :delete_popup_confirmation_url="delete_brands_popup_confirmation_url"
    ></DeleteStatusChangePopUp>
  </div>
</template>

<script>
import Pagination from './../../Common/Pagination/LaravelVuePagination'
import AddBrand from './AddBrand'
import DeleteStatusChangePopUp from '../../Common/DeleteStatusChangePopUp'
import Alert from '../../Common/Alert'
import ConfirmDialog from '../../Common/ConfirmDialog'

export default {
  name: 'BrandListing',
  components: {
    ConfirmDialog,
    DeleteStatusChangePopUp,
    Pagination,
    AddBrand,
    Alert
  },
  props: {
    brand_permissions: {
      type: [Array, Object],
      default: () => {}
    },
    get_all_brands_url: {
      type: String,
      default: ''
    },
    add_brand_url: {
      type: String,
      default: ''
    },
    edit_brand_url: {
      type: String,
      default: ''
    },
    delete_brand_url: {
      type: String,
      default: ''
    },
    delete_brands_popup_confirmation_url: {
      type: String,
      default: ''
    },
    brands_status_change_confirmation_url: {
      type: String,
      default: ''
    },
    brand_status_change_url: {
      type: String,
      default: ''
    }
  },
  data: function() {
    return {
      base_url: this.$parent.$data.base_url,
      brandsList: [],
      showAddForm: false,
      edit_brand_obj: [],
      editCase: false,
      paginate: {
        type: Object
      },
      limit: 5,
      showDisabled: false,
      size: 'default',
      align: 'center',
      show: false,
      deleteID: '',
      selectedItems: [],
      item: {
        id: '',
        value: false
      },
      selectedItemsIds: [],
      checkedItems: 0
    }
  },
  created() {
    this.fetch()
  },
  computed: {
    checkPagiantion() {
      return this.paginate.total < this.paginate.per_page
        ? this.paginate.total
        : this.paginate.per_page
    },
    bulk_permissions() {
      let permissions = []
      Object.keys(this.brand_permissions).map((key) => {
        if (this.brand_permissions[key] === 'brand-bulk-status') {
          permissions.push('bulk-status')
        }
        if (this.brand_permissions[key] === 'brand-bulk-delete') {
          permissions.push('bulk-delete')
        }
      })
      if (permissions.length > 0) {
        return permissions
      }
      return []
    }
  },
  methods: {
    statusChangeOnClick(id, status) {
      $('.dropdown-toggle').dropdown('hide')
      axios
        .post(this.brand_status_change_url + '/' + id, { status: status })
        .then((response) => {
          if (response.data.status === true) {
            this.$refs.alert.set('success', response.data.message, true)
            this.fetch()
          } else {
            this.$refs.alert.set('danger', response.data.message, true)
          }
          //window.location.reload()
        })
    },
    selectItems() {
      if ($('#selectAll').is(':checked')) {
        $('.selected-item-panel').addClass('active')
        for (let i = 0; i < this.selectedItemsIds.length; i++) {
          this.selectedItemsIds[i].value = true
        }
      } else {
        for (let i = 0; i < this.selectedItemsIds.length; i++) {
          this.selectedItemsIds[i].value = false
        }
        $('.selected-item-panel').removeClass('active')
      }
      let selectedItems = this.selectedItemsIds.filter(
        (item) => item.value === true
      )
      this.checkedItems = selectedItems.length
    },
    fetch: function(page = 1) {
      axios.get(this.get_all_brands_url + '?page=' + page).then((response) => {
        this.brandsList = response.data.data
        for (let i = 0; i < this.brandsList.length; i++) {
          this.item.id = this.brandsList[i].id
          this.item.value = false
          let cloneItem = { ...this.item }
          this.selectedItemsIds.push(cloneItem)
        }
        this.paginate = response.data.pagination
      })
    },
    async confirmDelete(id) {
      let confirm = await this.$refs.confirmBox.show({
        title: 'Confirm',
        message: 'Are you sure you want to delete this brand?',
        okButton: 'Delete',
        cancelButton: 'Cancel'
      })
      if (confirm) {
        axios.delete(this.delete_brand_url + '/' + id).then((response) => {
          this.fetch(this.paginate.current_page)
        })
      }
    },
    showForm() {
      this.showAddForm = true
      this.$refs.addBrand.resetForm()
    },
    showFormEdit(id) {
      axios.get(this.edit_brand_url + '/' + id).then((response) => {
        this.edit_brand_obj = response.data.data
        this.showAddForm = true
        this.editCase = true
        this.$refs.addBrand.updateForm(this.edit_brand_obj)
      })
    },
    MultiSelectRecords() {
      let selectedItems = this.selectedItemsIds.filter(
        (item) => item.value === true
      )
      this.checkedItems = selectedItems.length
      // POpup on checked
      if ($('.list-checkbox:checked').length !== this.paginate.total) {
        $('#selectAll').prop('checked', false)
      }
      if ($('.list-checkbox:checked').length === this.paginate.total) {
        $('#selectAll').prop('checked', true)
      }
      $('.show-selected .custom-control-input').on('change', function() {
        if ($(this).is(':checked')) {
          $('.selected-item-panel').addClass('active')
        } else {
          if ($('.list-checkbox:checked').length === 0) {
            $('.selected-item-panel').removeClass('active')
          }
        }
      })
      $(function() {
        $('.item-show span').on('click', function() {
          $('.selected-item-panel').removeClass('active')
        })
      })
    }
  }
}
</script>
