<template>
  <div>
    <div
      class="modal fade customer-modal"
      v-if="show"
      id="addNewaddons"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
    >
      <form v-if="addAddonForm" class="" @submit.prevent="save">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <h3 class="font-weight-700 dark-one mb-2" v-if="editCaseHeading">
                Edit Addon
              </h3>
              <h3 class="font-weight-700 dark-one mb-2" v-else>
                Add New Addon
              </h3>
              <Alert ref="alert"></Alert>
              <div class="mt-4 mb-4 w-75 ml-auto mr-auto">
                <div class="form-group">
                  <span class="add-brand">
                    <input
                      type="file"
                      accept="image/x-png,image/gif,image/jpeg"
                      class="d-none"
                      id="imguploadaddon"
                      @change="selectedFile($event)"
                    />

                    <img
                      v-if="editCaseHeading"
                      id="previewAddon"
                      alt=""
                      :src="addAddonForm.image.url"
                      @click="uploadDialog"
                    />

                    <img
                      v-else
                      id="previewAddon"
                      alt=""
                      :src="
                        base_url +
                          '/business_assets/images/customer-placeholder.png'
                      "
                      @click="uploadDialog"
                    />
                  </span>
                </div>
                <div class="form-group text-left">
                  <label class="font-weight-600 dark-one mb-2"
                    >Addon Name</label
                  >
                  <input
                    type="text"
                    class="form-control sm-radius-control white-border-control"
                    v-model="addAddonForm.title"
                    :class="{
                      'danger-border': addAddonForm.errors.has('title')
                    }"
                  />

                  <div
                    v-if="addAddonForm.errors.has('title')"
                    class="input-info danger-bg"
                  >
                    <p>{{ addAddonForm.errors.first('title') }}</p>
                  </div>
                </div>
                <div class="form-group text-left">
                  <label class="font-weight-600 dark-one mb-2"
                    >Addon Price</label
                  >
                  <input
                    type="text"
                    class="form-control sm-radius-control white-border-control"
                    v-model="addAddonForm.price"
                    :class="{
                      'danger-border': addAddonForm.errors.has('price')
                    }"
                  />

                  <div
                    v-if="addAddonForm.errors.has('price')"
                    class="input-info danger-bg"
                  >
                    <p>{{ addAddonForm.errors.first('price') }}</p>
                  </div>
                </div>
                <div class="form-group text-left">
                  <label class="font-weight-600 dark-one mb-2">Status</label>
                  <div class="form-icon">
                    <select
                      class="form-control sm-radius-control white-border-control"
                      v-model="addAddonForm.is_active"
                      :class="{
                        'is-invalid': addAddonForm.errors.has('is_active')
                      }"
                    >
                      <div
                        v-if="addAddonForm.errors.has('is_active')"
                        class="input-info danger-bg"
                      >
                        <p>{{ addAddonForm.errors.first('is_active') }}</p>
                      </div>
                      <option value="1">Active</option>
                      <option value="2">Inactive</option>
                    </select>

                    <span>
                      <img
                        alt="image"
                        :src="
                          base_url + '/business_assets/images/angledown.png'
                        "
                      />
                    </span>
                  </div>
                </div>
              </div>
              <a
                href="javascript:void(0)"
                v-show="showbuttons"
                class="btn-size btn-rounded btn-gray ml-1 mr-1"
                data-dismiss="modal"
              >
                Cancel
              </a>
              <button
                class="btn-size btn-rounded btn-primary ml-1 mr-1"
                v-if="editCaseHeading"
                v-show="showbuttons"
              >
                Update
              </button>
              <button
                class="btn-size btn-rounded btn-primary ml-1 mr-1"
                v-else
                v-show="showbuttons"
              >
                Add
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Form from '../../../libs/Form'
import Alert from '../../Common/Alert'

export default {
  name: 'AddAddon',
  props: {
    add_addon_url: {
      type: String,
      default: ''
    },
    base_url: {
      type: String,
      default: ''
    },
    show: {
      type: Boolean,
      default: true
    }
  },
  components: {
    Alert
  },
  data: function() {
    return {
      addAddonForm: {
        id: '',
        title: '',
        price: '',
        business_id: 1,
        is_active: 1,
        images: []
      },
      showbuttons: true,
      editCaseHeading: false
    }
  },

  created: function() {
    this.addAddonForm = new Form(this.addAddonForm)
    if (this.edit) {
    }
  },
  methods: {
    updateCatForm(addon) {
      this.addAddonForm.id = addon.id
      this.addAddonForm.title = addon.title
      this.addAddonForm.price = addon.price
      this.addAddonForm.business_id = addon.business_id
      this.addAddonForm.is_active = addon.is_active
      this.addAddonForm.image = addon.image
      this.editCaseHeading = true
    },
    resetForm() {
      this.addAddonForm.id = ''
      this.addAddonForm.title = ''
      this.addAddonForm.price = ''
      this.addAddonForm.business_id = ''
      this.addAddonForm.is_active = ''
      this.addAddonForm.image = ''
      this.editCaseHeading = false
    },
    save() {
      this.addAddonForm.post(this.add_addon_url).then((response) => {
        this.$refs.alert.set('success', response.message, true)
        // this.showbuttons = !this.showbutton;

        $('#previewAddon').attr(
          'src',
          this.base_url + '/business_assets/images/customer-placeholder.png'
        )
        this.$parent.fetch()

        this.resetForm()
        this.addAddonForm.images = []
        //
        var self = this
        setTimeout(function() {
          $('.modal').modal('hide')
          self.$refs.alert.reset()
        }, 2000)
        /*setTimeout(function() {
          window.location.reload();
        }, 1500);*/
      })
    },
    selectedFile(event) {
      //image uploading
      var preview = document.querySelector('#previewAddon')
      var files = document.querySelector('#imguploadaddon').files

      var self = this

      function readAndPreview(file) {
        // Make sure `file.name` matches our extensions criteria
        if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
          var reader = new FileReader()
          reader.addEventListener(
            'load',
            function() {
              $('#previewAddon').attr('src', this.result)
              self.addAddonForm.images.push(this.result)
            },
            false
          )
          reader.readAsDataURL(file)
        }
      }

      if (files) {
        ;[].forEach.call(files, readAndPreview)
      }
    },
    uploadDialog() {
      $('#imguploadaddon').trigger('click')
    }
  }
}
</script>

<style scoped></style>
