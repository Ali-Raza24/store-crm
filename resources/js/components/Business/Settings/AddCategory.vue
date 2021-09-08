<template>
  <div>
    <div
      class="modal fade customer-modal"
      v-if="show"
      id="addNewCatergory"
      tabindex="-1"
      role="dialog"
      aria-hidden="true"
    >
      <form v-if="addCategoryForm" class="" @submit.prevent="save">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <h3 class="font-weight-700 dark-one mb-2" v-if="editCaseHeading">
                Edit Category
              </h3>
              <h3 class="font-weight-700 dark-one mb-2" v-else>
                Add New Category
              </h3>
              <Alert ref="alert"></Alert>
              <div class="mt-4 mb-4 w-75 ml-auto mr-auto">
                <div class="form-group">
                  <span class="add-brand">
                    <input
                      type="file"
                      accept="image/x-png,image/gif,image/jpeg"
                      class="d-none"
                      id="imguploadcategory"
                      @change="selectedFile($event)"
                    />

                    <img
                      v-if="editCaseHeading"
                      id="previewCat"
                      alt=""
                      :src="addCategoryForm.image.url"
                      @click="uploadDialog"
                    />

                    <img
                      v-else
                      id="previewCat"
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
                    >Category Name</label
                  >
                  <input
                    type="text"
                    class="form-control sm-radius-control white-border-control"
                    v-model="addCategoryForm.title"
                    :class="{
                      'danger-border': addCategoryForm.errors.has('title')
                    }"
                  />

                  <div
                    v-if="addCategoryForm.errors.has('title')"
                    class="input-info danger-bg"
                  >
                    <p>{{ addCategoryForm.errors.first('title') }}</p>
                  </div>
                </div>
                <div class="form-group text-left">
                  <label class="font-weight-600 dark-one mb-2">Status</label>
                  <div class="form-icon">
                    <select
                      class="form-control sm-radius-control white-border-control"
                      v-model="addCategoryForm.is_active"
                      :class="{
                        'danger-border': addCategoryForm.errors.has('is_active')
                      }"
                    >
                      <option value="1">Active</option>
                      <option value="2">Inactive</option>
                    </select>
                    <div
                      v-if="addCategoryForm.errors.has('is_active')"
                      class="input-info danger-bg"
                    >
                      <p>{{ addCategoryForm.errors.first('is_active') }}</p>
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
  name: 'AddCategory',
  props: {
    add_category_url: {
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
      addCategoryForm: {
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
    this.addCategoryForm = new Form(this.addCategoryForm)
    if (this.edit) {
    }
  },
  methods: {
    updateCatForm(category) {
      this.addCategoryForm.id = category.id
      this.addCategoryForm.title = category.title
      this.addCategoryForm.business_id = category.business_id
      this.addCategoryForm.is_active = category.is_active
      this.addCategoryForm.image = category.image
      this.editCaseHeading = true
    },
    resetForm() {
      this.addCategoryForm.id = ''
      this.addCategoryForm.title = ''
      this.addCategoryForm.business_id = ''
      this.addCategoryForm.is_active = ''
      this.addCategoryForm.image = ''
      this.editCaseHeading = false
    },
    save() {
      this.addCategoryForm.post(this.add_category_url).then((response) => {
        this.$refs.alert.set('success', response.message, true)
        /*this.showbuttons = !this.showbuttons
        setTimeout(function() {
          window.location.reload()
        }, 1500)*/
        $('#previewCat').attr(
          'src',
          this.base_url + '/business_assets/images/customer-placeholder.png'
        )
        this.$parent.fetch()
        this.resetForm()
        this.addCategoryForm.images = []
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
      var preview = document.querySelector('#previewCat')
      var files = document.querySelector('#imguploadcategory').files

      var self = this

      function readAndPreview(file) {
        // Make sure `file.name` matches our extensions criteria
        if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
          var reader = new FileReader()
          reader.addEventListener(
            'load',
            function() {
              $('#previewCat').attr('src', this.result)
              self.addCategoryForm.images.push(this.result)
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
      $('#imguploadcategory').trigger('click')
    }
  }
}
</script>

<style scoped></style>
