<template>
  <div>
    <div
      class="tab-pane  pro-table-seting pb-4"
      id="settAddons"
      role="tabpanel"
      aria-labelledby="settAddons"
    >
      <Alert ref="alert"></Alert>
      <div class="d-flex justify-content-between align-items-center">
        <h4 class="font-weight-700 dark-one">All Addons</h4>
        <a
          class="btn-size btn-rounded btn-primary"
          href="#"
          data-toggle="modal"
          data-target="#addNewaddons"
          @click="showCatForm"
          v-if="
            addon_permissions.some(
              (permission) => permission === 'addon-create'
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
              <th scope="col">Addon Name</th>
              <th scope="col">Price</th>
              <th
                scope="col"
                v-if="
                  addon_permissions.some(
                    (permission) => permission === 'addon-status'
                  )
                "
              >
                Status
              </th>
              <th
                scope="col"
                v-if="
                  addon_permissions.some(
                    (permission) =>
                      permission === 'addon-edit' ||
                      permission === 'addon-delete'
                  )
                "
              >
                Actions
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(addon, index) in addonList">
              <td
                class="custom-checkbox show-selected"
                v-if="bulk_permissions.length > 0"
              >
                <input
                  type="checkbox"
                  v-model="selectedItemsIds[index].value"
                  @change="MultiSelectRecords"
                  :value="addon.id"
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
                  <div class="pro-thumb" v-if="addon.image.thumbnail">
                    <img
                      alt=""
                      :src="addon.image.thumbnail"
                      style="width: 70px; height: 70px"
                    />
                  </div>

                  <div class="table-order-no ml-3">
                    <strong class="dark-one"
                      ><a href="#">{{ addon.title }}</a></strong
                    >
                    <p class="mb-0">{{ addon.created_at }}</p>
                  </div>
                </div>
              </td>

              <td>
                <p class="mb-0 order-name">{{ addon.price }}</p>
              </td>

              <td
                v-if="
                  addon_permissions.some(
                    (permission) => permission === 'addon-status'
                  )
                "
              >
                <div class="dropdown">
                  <span
                    v-if="addon.is_active === 1"
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
                    v-if="addon.is_active === 2"
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
                      @click="statusChangeOnClick(addon.id, 1)"
                    >
                      active
                    </a>
                    <a
                      class="dropdown-item"
                      href="javascript:void(0)"
                      @click="statusChangeOnClick(addon.id, 2)"
                    >
                      Inactive
                    </a>
                  </div>
                </div>
              </td>

              <td
                v-if="
                  addon_permissions.some(
                    (permission) =>
                      permission === 'addon-edit' ||
                      permission === 'addon-delete'
                  )
                "
              >
                <div class="table-action">
                  <a
                    href="#"
                    class="edit-order mr-3"
                    data-toggle="modal"
                    data-target="#addNewaddons"
                    @click="showFormEdit(addon.id)"
                    v-if="
                      addon_permissions.some(
                        (permission) => permission === 'addon-edit'
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
                    @click="confirmDelete(addon.id)"
                    v-if="
                      addon_permissions.some(
                        (permission) => permission === 'addon-delete'
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
    <add-addon
      :edit_addon_url="edit_addon_url"
      :base_url="base_url"
      ref="add_addon"
      :add_addon_url="add_addon_url"
    ></add-addon>
    <confirm-dialog ref="confirmBox" />
    <DeleteStatusChangePopUp
      v-if="bulk_permissions.length > 0"
      :permissions="bulk_permissions"
      :bulk_status_url="bulk_addons_status_change"
      :selectedItemsIds="selectedItemsIds"
      :selected_items="checkedItems"
      status_title=""
      delete_title=""
      :delete_popup_confirmation_url="delete_addons_popup_confirmation_url"
    ></DeleteStatusChangePopUp>
  </div>
</template>

<script>
import Pagination from './../../Common/Pagination/LaravelVuePagination'
import AddAddon from './AddAddon'
import DeleteStatusChangePopUp from '../../Common/DeleteStatusChangePopUp'
import Alert from '../../Common/Alert'
import ConfirmDialog from '../../Common/ConfirmDialog'

export default {
  name: 'AddonListing',
  components: {
    ConfirmDialog,
    DeleteStatusChangePopUp,
    Pagination,
    AddAddon,
    Alert
  },
  props: {
    addon_permissions: {
      type: [Array, Object],
      default: () => {}
    },
    bulk_addons_status_change: {
      type: String,
      default: ''
    },
    get_all_addons: {
      type: String,
      default: ''
    },
    add_addon_url: {
      type: String,
      default: ''
    },
    edit_addon_url: {
      type: String,
      default: ''
    },
    delete_addon_url: {
      type: String,
      default: ''
    },
    delete_addons_popup_confirmation_url: {
      type: String,
      default: ''
    },
    addon_status_update_url: {
      type: String,
      default: ''
    }
  },
  data: function() {
    return {
      base_url: this.$parent.$data.base_url,
      addonList: [],
      showAddForm: false,
      edit_addon_obj: [],
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
      Object.keys(this.addon_permissions).map((key) => {
        if (this.addon_permissions[key] === 'addon-bulk-status') {
          permissions.push('bulk-status')
        }
        if (this.addon_permissions[key] === 'addon-bulk-delete') {
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
        .post(this.addon_status_update_url + '/' + id, { status: status })
        .then((response) => {
          console.log(response.data.status)
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
      axios.get(this.get_all_addons + '?page=' + page).then((response) => {
        this.addonList = response.data.data
        for (let i = 0; i < this.addonList.length; i++) {
          this.item.id = this.addonList[i].id
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
        message: 'Are you sure you want to delete this Addon?',
        okButton: 'Delete',
        cancelButton: 'Cancel'
      })
      if (confirm) {
        axios.delete(this.delete_addon_url + '/' + id).then((response) => {
          this.fetch(this.paginate.current_page)
        })
      }
    },
    showCatForm() {
      this.showAddForm = true
      this.$refs.add_addon.resetForm()
    },
    showFormEdit(id) {
      axios.get(this.edit_addon_url + '/' + id).then((response) => {
        this.edit_addon_obj = response.data.data
        this.showAddForm = true
        this.editCase = true
        this.$refs.add_addon.updateCatForm(this.edit_addon_obj)
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

<style scoped>
.pagination .page-link,
.page-item.disabled .page-link {
  height: 30px;
  width: 30px;
  padding: 0;
  border: none;
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  border-radius: 50%;
  line-height: 30px;
  color: #cddeeb;
  margin: 2px;
  text-align: center;
}
.pagination .page-link,
.page-item.disabled .page-link,
.page-item:first-child .page-link:hover,
.page-item:first-child .page-link.active,
.page-item:last-child .page-link:hover,
.page-item:last-child .page-link.active {
  background-color: transparent;
  box-shadow: none;
}
.pagination .page-link:hover,
.pagination .page-link.active {
  /* background-color: #21B6A8; */
  -webkit-box-shadow: inset 0 0 8px 15px#21B6A8;
  -moz-box-shadow: inset 0 0 8px 15px#21B6A8;
  box-shadow: inset 0 0 8px 15px#21B6A8;
  color: #1d262f;
}
</style>
