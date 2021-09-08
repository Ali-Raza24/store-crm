<template>
  <div class="sf-order">
    <div class="table-responsive scroll-bar-thin">
      <table class="table table-space table-check no-bor-input">
        <thead>
          <tr>
            <th scope="col" class="custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                id="selectAll"
                v-model="selectAllItems"
                @change="selectAll"
              />
              <label class="custom-control-label" for="selectAll"></label>
            </th>
            <th scope="col">Business ID</th>
            <th scope="col">Name</th>
            <th scope="col">Business Dashboard</th>
            <th scope="col">Contact</th>
            <th scope="col">Plan Type</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(business, index) in businessList"
            :key="index"
            class="cursor-pointer"
          >
            <td class="custom-checkbox show-selected">
              <input
                v-model="checkedItemsList[index].value"
                type="checkbox"
                class="custom-control-input business-list"
                :id="'customCheck' + index + 2"
                @click="checkItem"
              />
              <label
                class="custom-control-label"
                :for="'customCheck' + index + 2"
              ></label>
            </td>
            <td @click="loadBusinessDetail(business.id)">
              <div class="table-order-no">
                <strong class="dark-one">
                  <a
                    href="javascript:void(0)"
                    @click="loadBusinessDetail(business.id)"
                    >#{{ business.id }}</a
                  >
                </strong>
                <p class="mb-0">Added: {{ business.created_at }}</p>
              </div>
            </td>
            <td>
              <p class="mb-0 order-name">{{ business.name }}</p>
            </td>
            <td><p class="mb-0 order-store">Login</p></td>
            <td>
              <p class="mb-0 order-store">{{ business.phone }}</p>
              <p class="mb-0 order-store">{{ business.email }}</p>
            </td>
            <td>
              <div class="dropdown border-dropdown">
                <button
                  class="dropdown-toggle"
                  type="button"
                  id="dropProd"
                  data-toggle="dropdown"
                  aria-haspopup="false"
                  aria-expanded="false"
                >
                  {{ business.plan }}
                </button>
                <div
                  class="dropdown-menu dropdown-menu-right"
                  aria-labelledby="dropProd"
                  style="
                        position: absolute;transform: translate3d(-63px,40px,0px);top: 0px;left: 0px;will-change: transform;"
                  x-placement="bottom-end"
                >
                  <a
                    class="dropdown-item"
                    @click="updateBusinessPlan(business.id, 1)"
                    href="javascript:void(0)"
                    >Free</a
                  >
                  <a
                    class="dropdown-item"
                    @click="updateBusinessPlan(business.id, 2)"
                    href="javascript:void(0)"
                    >Basic</a
                  >
                  <a
                    class="dropdown-item"
                    @click="updateBusinessPlan(business.id, 3)"
                    href="javascript:void(0)"
                    >Standard</a
                  >
                </div>
              </div>
            </td>
            <td>
              <div class="dropdown border-dropdown">
                <button
                  class="dropdown-toggle"
                  type="button"
                  id="dropStatus"
                  data-toggle="dropdown"
                  aria-haspopup="false"
                  aria-expanded="false"
                >
                  {{ business.business_status }}
                </button>
                <ul
                  class="dropdown-menu dropdown-menu-right"
                  aria-labelledby="dropStatus"
                  style="
                        position: absolute;transform: translate3d(-63px,40px,0px);top: 0px;left: 0px;will-change: transform;"
                  x-placement="bottom-end"
                >
                  <li v-for="(status, id) in business_status" :key="id">
                    <a
                      v-if="status !== business.business_status"
                      class="dropdown-item"
                      @click="updateBusinessStatus(business.id, id)"
                      href="javascript:void(0)"
                      >{{ status }}</a
                    >
                  </li>
                </ul>
              </div>
            </td>
            <td>
              <div class="table-action">
                <a
                  :href="url + '/admin/business/detail/' + business.id"
                  class="edit-order"
                >
                  <img alt="" :src="url + '/admin_assets/images/edit.png'" />
                </a>
                <a
                  href="#"
                  class="print-order"
                  @click="deleteBusiness(business.id)"
                >
                  <img
                    alt=""
                    :src="url + '/admin_assets/images/delete-gray.png'"
                  />
                </a>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <pagination
      :data="paginate"
      @pagination-change-page="fetchBusiness"
      :limit="limit"
      :show-disabled="showDisabled"
      :size="size"
      :align="align"
    ></pagination>
    <confirm-dialog ref="confirmBox" />

    <div class="selected-item-panel" id="business-list-panel">
      <div class="selected-item">
        <ul class="selected-list">
          <li>
            <div class="item-show">
              <span
                ><img
                  :src="url + '/admin_assets/images/close-wgite.png'"
                  alt="image"
              /></span>
              <p class="mobile-hide">{{ checkedItemsCount }} Items Selected</p>
            </div>
          </li>
          <!--          <li>
            <a href="javascript:void(0)" class="item-btn" @click="bulkDelete">
              <span>Delete</span>
            </a>
          </li>-->
          <li v-for="(status, id) in business_status" :key="id">
            <a
              v-if="status !== 'Suspended'"
              href="javascript:void(0)"
              class="item-btn"
              @click="bulkActive(id, status)"
            >
              <span>{{ status }}</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import Pagination from 'laravel-vue-pagination'
import ConfirmDialog from '../../../Common/ConfirmDialog'

export default {
  name: 'BusinessList',
  components: { ConfirmDialog, Pagination },
  props: {
    url: {
      type: String,
      default: ''
    },
    get_business_list: {
      type: String,
      default: ''
    },
    delete_business_url: {
      type: String,
      default: ''
    },
    bulk_delete_url: {
      type: String,
      default: ''
    },
    bulk_status_url: {
      type: String,
      default: ''
    },
    update_plan: {
      type: String,
      default: ''
    },
    type: {
      type: String,
      default: ''
    },
    update_business_status: {
      type: String,
      default: ''
    },
    business_status: {
      type: [Array, Object],
      default: () => {}
    }
  },
  data() {
    return {
      paginate: {
        type: Object
      },
      limit: 5,
      showDisabled: false,
      size: 'default',
      align: 'center',
      businessList: [],
      checkedItems: {
        id: '',
        value: false
      },
      checkedItemsList: [],
      selectAllItems: false,
      getBusinessList: ''
    }
  },
  created() {
    this.fetchBusiness()
  },
  computed: {
    checkedItemsCount() {
      let count = this.filterCheckedItems()
      return count.length
    }
  },
  methods: {
    loadBusinessDetail(id) {
      window.location.href = this.url + '/admin/business/detail/' + id
    },
    filterCheckedItems() {
      return this.checkedItemsList.filter((item) => item.value === true)
    },
    fetchBusiness(page = 1) {
      this.getBusinessList = this.get_business_list
      this.getBusinessList = this.getBusinessList + '?page=' + page
      if (this.type !== '') {
        this.getBusinessList =
          this.getBusinessList + '?page=' + page + '&type=' + this.type
      }

      axios.get(this.getBusinessList).then((response) => {
        this.businessList = response.data.data
        this.paginate = response.data.pagination
        this.checkedItemsList = []
        for (let i = 0; i < this.businessList.length; i++) {
          this.checkedItems.id = this.businessList[i].id
          this.checkedItems.value = false
          let cloneItem = { ...this.checkedItems }
          this.checkedItemsList.push(cloneItem)
        }
      })
    },
    async deleteBusiness(id) {
      let confirmation = await this.$refs.confirmBox.show({
        title: 'Confirm',
        message: 'Are you sure you want to delete this business?',
        okButton: 'Delete',
        cancelButton: 'Cancel'
      })

      if (confirmation) {
        axios.delete(this.delete_business_url + '/' + id).then((response) => {
          this.fetchBusiness(this.paginate.current_page)
        })
      }
    },
    selectAll() {
      if ($('#selectAll').is(':checked') === true) {
        for (let i = 0; i < this.checkedItemsList.length; i++) {
          this.checkedItemsList[i].value = true
          $('#business-list-panel').addClass('active')
        }
      } else {
        for (let i = 0; i < this.checkedItemsList.length; i++) {
          this.checkedItemsList[i].value = false
          $('#business-list-panel').removeClass('active')
        }
      }
    },
    checkItem() {
      let $selectItemPanel = $('#business-list-panel')
      if (!$selectItemPanel.hasClass('active')) {
        $selectItemPanel.addClass('active')
      }

      if ($('.business-list:checked').length === this.checkedItemsList.length) {
        this.selectAllItems = true
      } else {
        this.selectAllItems = false
      }
      if ($('.business-list:checked').length > 0) {
        if (!$selectItemPanel.hasClass('active')) {
          $selectItemPanel.addClass('active')
        }
      } else {
        $selectItemPanel.removeClass('active')
      }
    },
    getSelectedItemIds() {
      let items = this.filterCheckedItems()
      return Object.keys(items).map((key) => {
        return items[key].id
      })
    },
    async bulkDelete() {
      let confirmation = await this.$refs.confirmBox.show({
        title: 'Confirm Delete?',
        message: 'Are you sure you want to delete these businesses?',
        okButton: 'Delete',
        cancelButton: 'Cancel'
      })
      if (confirmation) {
        axios
          .post(this.bulk_delete_url, { ids: this.getSelectedItemIds() })
          .then((response) => {
            $('#business-list-panel').removeClass('active')
            this.fetchBusiness(this.paginate.current_page)
          })
      }
    },
    async bulkActive(id, status) {
      let message = 'Are you sure you want to Active these businesses?'
      let okButton = 'Active'
      if (status === 'InActive') {
        message = 'Are you sure you want to InActive these businesses?'
        okButton = 'InActive'
      }
      let confirmation = await this.$refs.confirmBox.show({
        title: 'Change Status?',
        message: message,
        okButton: okButton,
        cancelButton: 'Cancel'
      })
      if (confirmation) {
        axios
          .post(this.bulk_status_url, {
            ids: this.getSelectedItemIds(),
            status: id
          })
          .then((response) => {
            $('#business-list-panel').removeClass('active')
            this.fetchBusiness(this.paginate.current_page)
            this.$parent.$refs.alert.set('success', 'Status updated', true)
          })
      }
    },
    async updateBusinessPlan(business_id, plan_id) {
      let confirm = await this.$refs.confirmBox.show({
        title: 'Change Plan?',
        message: 'Are you sure want to update plan?',
        okButton: 'Yes',
        cancelButton: 'Cancel'
      })
      if (confirm) {
        axios
          .post(this.update_plan, { id: business_id, plan_id: plan_id })
          .then((response) => {
            this.fetchBusiness(this.paginate.current_page)
            this.$parent.$refs.alert.set('success', 'Plan updated', true)
          })
      }
    },
    async updateBusinessStatus(business_id, status_id) {
      let confirm = await this.$refs.confirmBox.show({
        title: 'Change Status?',
        message: 'Are you sure want to change?',
        okButton: 'Yes',
        cancelButton: 'Cancel'
      })
      if (confirm) {
        axios
          .post(this.update_business_status, {
            id: business_id,
            status_id: status_id
          })
          .then((response) => {
            this.fetchBusiness(this.paginate.current_page)
            this.$parent.$refs.alert.set('success', 'Status updated', true)
          })
      }
    }
  }
}
</script>

<style scoped>
.cursor-pointer {
  cursor: pointer;
}
</style>
