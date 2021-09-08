<template>
  <popup-modal ref="popup">
    <div
      class="modal fade refund-modal"
      style="display: block; opacity: 1"
      id="cancelRefund"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <h2 class="font-weight-700 dark-one mb-2">{{ title }}</h2>
            <!--            <h4 class="font-weight-600 dark-five">
              {{ title }}
            </h4>-->
            <h2 class="danger-text font-weight-700 modal-amount mt-4">
              <slot name="extra"></slot>
            </h2>

            <slot name="extra">
              <p class="font-weight-700 dark-one mb-4">{{ sub_title }}</p>
              <h4 class="dark-two mb-3">{{ message }}</h4>
            </slot>

            <button
              type="button"
              class="btn-size btn-rounded btn-primary ml-1 mr-1"
              @click="_cancel"
              data-dismiss="modal"
            >
              {{ cancelButton }}
            </button>
            <button
              type="button"
              class="btn-size btn-rounded btn-gray ml-1 mr-1"
              data-dismiss="modal"
              @click="_confirm"
            >
              {{ okButton }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </popup-modal>
</template>

<script>
import PopupModal from './PopupModal'
export default {
  name: 'ConfirmDialog',
  components: { PopupModal },
  data: () => ({
    title: '',
    message: '',
    sub_title: '',

    okButton: '',
    cancelButton: '',

    resolvePromise: undefined,
    rejectPromise: undefined
  }),

  methods: {
    show(opts = {}) {
      this.title = opts.title
      this.message = opts.message
      this.okButton = opts.okButton
      if (opts.cancelButton) {
        this.cancelButton = opts.cancelButton
      }

      this.$refs.popup.open()

      return new Promise((resolve, reject) => {
        this.resolvePromise = resolve
        this.rejectPromise = reject
      })
    },

    _confirm() {
      this.$refs.popup.close()
      this.resolvePromise(true)
    },

    _cancel() {
      this.$refs.popup.close()
      this.resolvePromise(false)
    }
  }
}
</script>

<style scoped></style>
