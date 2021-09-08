<template>
  <div class="selected-item-panel">
    <div class="selected-item">
      <ul class="selected-list">
        <li>
          <div class="item-show">
            <span
              ><img
                :src="base_url + '/business_assets/images/close-wgite.png'"
                alt="image"
            /></span>
            <p class="mobile-hide">{{ selected_items }} Items Selected</p>
          </div>
        </li>
        <li>
          <a
            href="javascript:void(0)"
            @click="deleteBrandConfirmation(selectedItemsIds)"
            class="item-btn"
            v-if="
              permissions.some((permission) => permission === 'bulk-delete')
            "
          >
            <span>{{ delete_title }} Delete</span>
          </a>
        </li>
        <li>
          <a
            href="javascript:void(0)"
            class="item-btn"
            @click="statusActiveConfirmation(1)"
            v-if="
              permissions.some((permission) => permission === 'bulk-status')
            "
          >
            <span>{{ status_title }} Active</span>
          </a>
        </li>
        <li>
          <a
            href="javascript:void(0)"
            class="item-btn"
            @click="statusActiveConfirmation(2)"
            v-if="
              permissions.some((permission) => permission === 'bulk-status')
            "
          >
            <span>{{ status_title }} Inactive</span>
          </a>
        </li>
      </ul>
    </div>
    <confirm-dialog ref="confirmBox" />
  </div>
</template>

<script>
import ConfirmDialog from './ConfirmDialog'
export default {
  name: 'DeleteStatusChangePopUp',
  components: { ConfirmDialog },
  props: {
    permissions: {
      type: [Array, Object],
      default: () => {}
    },
    delete_popup_confirmation_url: {
      type: String,
      default: ''
    },
    bulk_status_url: {
      type: String,
      default: ''
    },

    current_page: {
      type: Number,
      default: 1
    },
    status_title: {
      type: String,
      default: ''
    },
    selected_items: {
      type: Number,
      default: 0
    },
    selectedItemsIds: {
      type: [Array, Object],
      default: () => {}
    },
    delete_title: {
      type: String,
      default: ''
    }
  },
  data: function() {
    return {
      base_url: this.$parent.$data.base_url,
      brandIdsDel: []
    }
  },
  methods: {
    async deleteBrandConfirmation(selectedItemsIds) {
      let confirm = await this.$refs.confirmBox.show({
        title: 'Confirm',
        message:
          'Are you sure you want to delete these ' + this.status_title + '?',
        okButton: 'Delete',
        cancelButton: 'Cancel'
      })
      if (confirm) {
        for (let i = 0; i < this.selectedItemsIds.length; i++) {
          if (this.selectedItemsIds[i].value == true) {
            this.brandIdsDel.push(this.selectedItemsIds[i].id)
          }
        }

        axios
          .post(this.delete_popup_confirmation_url, {
            delete_data: this.brandIdsDel
          })
          .then((response) => {
            this.$parent.fetch(this.current_page)
          })
      }
    },
    async statusActiveConfirmation(status) {
      let message =
        'Are you sure you want to active these ' + this.status_title + '?'
      let okButton = 'Active'
      if (status === 2) {
        message =
          'Are you sure you want to inactive these ' + this.status_title + '?'
        okButton = 'Inactive'
      }

      let confirm = await this.$refs.confirmBox.show({
        title: 'Confirm',
        message: message,
        okButton: okButton,
        cancelButton: 'Cancel'
      })
      if (confirm) {
        for (let i = 0; i < this.selectedItemsIds.length; i++) {
          if (this.selectedItemsIds[i].value == true) {
            this.brandIdsDel.push(this.selectedItemsIds[i].id)
          }
        }

        axios
          .post(this.bulk_status_url, {
            delete_data: this.brandIdsDel,
            status: status
          })
          .then((response) => {
            this.$parent.fetch(this.current_page)
          })
      }
    }
  }
}
</script>

<style scoped></style>
