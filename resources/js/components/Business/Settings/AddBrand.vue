<template>
  <div>
    <div
      class="modal fade customer-modal"
      v-if="show"
      id="addNewbrand"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
    >
      <form v-if="addBrandForm" class="" @submit.prevent="save">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <h3 class="font-weight-700 dark-one mb-2" v-if="editCaseHeading">
                Edit Brand
              </h3>
              <h3 class="font-weight-700 dark-one mb-2" v-else>
                Add New Brand
              </h3>
              <Alert ref="alert"></Alert>
              <div class="mt-4 mb-4 w-75 ml-auto mr-auto">
                <div class="form-group">
                  <span class="add-brand">
                    <input
                      type="file"
                      accept="image/x-png,image/gif,image/jpeg"
                      class="d-none"
                      id="imgupload"
                      @change="selectedFile($event)"
                    />

                    <img
                      v-if="editCaseHeading"
                      id="preview"
                      alt=""
                      :src="addBrandForm.image.url"
                      @click="uploadDialog"
                    />

                    <img
                      v-else
                      id="preview"
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
                    >Brand Name</label
                  >
                  <input
                    type="text"
                    class="form-control sm-radius-control white-border-control"
                    v-model="addBrandForm.title"
                    :class="{
                      'danger-border': addBrandForm.errors.has('title')
                    }"
                  />

                  <div
                    v-if="addBrandForm.errors.has('title')"
                    class="input-info danger-bg"
                  >
                    <p>{{ addBrandForm.errors.first('title') }}</p>
                  </div>
                </div>
                <div class="form-group text-left">
                  <label class="font-weight-600 dark-one mb-2">Status</label>
                  <div class="form-icon">
                    <select
                      class="form-control sm-radius-control white-border-control"
                      v-model="addBrandForm.is_active"
                      :class="{
                        'danger-border': addBrandForm.errors.has('is_active')
                      }"
                    >
                      <option value="1">Active</option>
                      <option value="2">Inactive</option>
                    </select>
                    <div
                      v-if="addBrandForm.errors.has('is_active')"
                      class="input-info danger-bg"
                    >
                      <p>{{ addBrandForm.errors.first('is_active') }}</p>
                    </div>
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
  name: 'AddBrand',
  props: {
    add_url: {
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
      addBrandForm: {
        id: '',
        title: '',
        business_id: 1,
        is_active: 1,
        images: []
      },
      showbuttons: true,
      editCaseHeading: false
    }
  },

  created: function() {
    this.addBrandForm = new Form(this.addBrandForm)
    if (this.edit) {
    }
  },
  methods: {
    updateForm(brand) {
      this.addBrandForm.id = brand.id
      this.addBrandForm.title = brand.title
      this.addBrandForm.business_id = brand.business_id
      this.addBrandForm.is_active = brand.is_active
      this.addBrandForm.image = brand.image
      this.editCaseHeading = true
    },
    resetForm() {
      this.addBrandForm.id = ''
      this.addBrandForm.title = ''
      this.addBrandForm.business_id = ''
      this.addBrandForm.is_active = ''
      this.addBrandForm.image = ''
      this.editCaseHeading = false
    },
    save() {
      this.addBrandForm.post(this.add_url).then((response) => {
        this.$refs.alert.set('success', response.message, true)
        // this.showbuttons = !this.showbuttons
        $('#preview').attr(
          'src',
          this.base_url + '/business_assets/images/customer-placeholder.png'
        )
        this.$parent.fetch()
        this.resetForm()
        this.addBrandForm.images = []
        //
        var self = this
        setTimeout(function() {
          $('.modal').modal('hide')
          self.$refs.alert.reset()
        }, 2000)
      })
    },
    selectedFile(event) {
      //image uploading
      var preview = document.querySelector('#preview')
      var files = document.querySelector('input[type=file]').files
      var self = this

      function readAndPreview(file) {
        // Make sure `file.name` matches our extensions criteria
        if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
          var reader = new FileReader()
          reader.addEventListener(
            'load',
            function() {
              $('#preview').attr('src', this.result)
              self.addBrandForm.images.push(this.result)
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
      $('#imgupload').trigger('click')
    }
  }
}
</script>

<style scoped></style>
