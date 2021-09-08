<template>
  <div>
    <div class="row">
      <div class="col-md-6 col-sm-6" v-if="business_type === 1">
        <h4 class="dark-one font-weight-700 mt-4 mb-4">
          Add Ons
        </h4>
        <div class="form-group custom-checkbox">
          <input
            class="custom-control-input"
            type="checkbox"
            id="tab1"
            :value="1"
            name="has_addons_or_variants"
            v-model="has_addons_or_variants"
            @change="updateHasAddonOrVariants(1)"
          />
          <label class="custom-control-label w-100 h-100 pl-4" for="tab1"
            ><span class="pl-2">This item has add ons</span></label
          >
        </div>
      </div>
      <div class="col-md-6 col-sm-6" v-if="business_type === 2">
        <h4 class="dark-one font-weight-700 mt-4 mb-4">Add Variants</h4>
        <div class="form-group custom-checkbox">
          <input
            class="custom-control-input"
            type="checkbox"
            id="tab2"
            :value="2"
            v-model="has_addons_or_variants"
            name="has_addons_or_variants"
            @change="updateHasAddonOrVariants(2)"
          />
          <label class="custom-control-label w-100 h-100 pl-4" for="tab2"
            ><span class="pl-2">This item has Variants</span></label
          >
        </div>
      </div>

      <div class="col-md-12" id="productExtra">
        <div
          class="item-tab"
          v-if="
            business_type === 1 &&
              (has_addons_or_variants === 1 || has_addons_or_variants === '1')
          "
        >
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group mb-3">
                <div class="d-flex justify-content-between">
                  <label class="font-weight-600 mb-2 dark-one">
                    Add On Name
                  </label>
                  <div>
                    <!--                    <a
                      href="javascript:void(0)"
                      class="btn-underline primary-text"
                      data-toggle="modal"
                      data-target="#addNewProd"
                    >
                      + Add New
                    </a>-->
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <Select2 v-model="selectedAddon" :options="allAddonsList" />
                  </div>
                </div>
              </div>
              <a
                href="javascript:void(0)"
                class="btn-size btn-gray-light btn-rounded mb-4"
                @click="addAddon"
              >
                Add
              </a>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <div
                  class="table-responsive scroll-bar-thin location-group sm-radius-control"
                >
                  <table class="table m-0">
                    <tbody>
                      <tr
                        v-for="(list, index) in selectedAddonsList"
                        :key="list.id"
                      >
                        <td>
                          <input
                            type="hidden"
                            name="addon[]"
                            :value="list.id"
                          />
                          <span class="dark-one">{{ list.title }}</span>
                        </td>
                        <td>
                          <span class="dark-one">AED {{ list.price }}</span>
                        </td>
                        <td class="text-right">
                          <span class="delete-rcd">
                            <img
                              @click="removeAddon(index)"
                              alt=""
                              title="Delete Addon"
                              data-tooltip="Delete Addon"
                              :src="
                                base_url + '/business_assets/images/delete.png'
                              "
                            />
                          </span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div
          class=""
          id="variants"
          v-if="
            business_type === 2 &&
              (has_addons_or_variants === 2 || has_addons_or_variants === '2')
          "
        >
          <div
            class="row"
            v-for="(variant, index) in variantsListObj"
            :key="index"
          >
            <div class="col-md-4 col-sm-4">
              <div class="form-group mb-4">
                <label class="font-weight-600 mb-2 dark-one">Variant</label>
                <v-app>
                  <v-combobox
                    hide-selected
                    :name="'variantList[' + index + '][name]'"
                    :items="variant.variants"
                    v-model="variantsListObj[index].variant"
                    @change="loadVariantOptions(index, $event)"
                    :rules="['required']"
                  ></v-combobox>
                </v-app>
              </div>
            </div>
            <div class="col-md-8 col-sm-8">
              <div class="form-group mb-4">
                <div class="d-flex justify-content-between">
                  <label class="font-weight-600 mb-2 dark-one"> Options </label>
                  <div>
                    <a
                      href="javascript:void(0)"
                      class="btn-underline danger-text"
                      title="Remove variant"
                      data-tooltip="Remove variant"
                      @click="removeVariant(index)"
                      v-if="index > 0 || variantsListObj.length > 1"
                    >
                      Remove
                    </a>
                  </div>
                </div>
                <v-app>
                  <v-combobox
                    hide-selected
                    :items="variant.options"
                    auto-select-first
                    :name="'variantList[' + index + '][options][]'"
                    v-model="variantsListObj[index].selectedOptions"
                    @change="addOptionsToList(index)"
                    :ref="'optionsList' + variantsListObj[index]"
                    :rules="['required']"
                  ></v-combobox>
                </v-app>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <a
                href="javascript:void(0)"
                class="btn-size btn-gray-light btn-rounded mb-4"
                @click="addVariantField"
                v-if="
                  variantsListObj.length < (ProductHasVariants === true ? 1 : 3)
                "
              >
                Add Another
              </a>
            </div>
            <div class="col-lg-12">
              <div class="form-group mb-4">
                <div
                  class=" table-responsive scroll-bar-thin location-group sm-radius-control"
                >
                  <table class="table m-0 ">
                    <tbody v-if="variantCombine.length > 0 && checkVariant">
                      <tr
                        v-for="(variant, index) in variantCombine"
                        :key="index"
                      >
                        <td>
                          <table class="variant-table">
                            <thead>
                              <tr>
                                <th style="width: 10px">Active / Image</th>
                                <th style="width: 150px;">Variant</th>
                                <th style="width: 150px;">Cost Price (AED)</th>
                                <th style="width: 150px;">
                                  Retail Price (AED)
                                </th>
                                <th style="width: 150px;">
                                  Discounted Price (AED)
                                </th>
                                <th style="width: 150px;">Barcode</th>
                                <th style="width: 150px;">SKU</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td width="70px">
                                  <div class="custom-checkbox d-inline-block">
                                    <input
                                      type="checkbox"
                                      class="custom-control-input"
                                      value="1"
                                      :id="'variant' + index"
                                      :name="
                                        'variant[' + index + '][is_active]'
                                      "
                                      checked
                                    />
                                    <label
                                      class="custom-control-label"
                                      :for="'variant' + index"
                                    ></label>
                                  </div>

                                  <span>
                                    <ImageUpload
                                      :name="'variant[' + index + '][image]'"
                                      delete-class="delete2"
                                      :round-image="true"
                                      style-img="height:75px;"
                                      :image_placeholder="
                                        base_url +
                                          '/business_assets/images/customer-placeholder.png'
                                      "
                                    />
                                  </span>
                                </td>
                                <td style="white-space: normal">
                                  <div
                                    class="produt-td"
                                    style="word-wrap: break-word"
                                  >
                                    <p
                                      class="font-weight-700 dark-one pl-2 "
                                      style="word-wrap: break-word"
                                    >
                                      {{
                                        variant.toString().replaceAll(',', '/ ')
                                      }}
                                    </p>
                                  </div>
                                </td>
                                <td>
                                  <input
                                    :name="'variant[' + index + '][options]'"
                                    type="hidden"
                                    :value="
                                      variant.toString().replaceAll(',', '/')
                                    "
                                    placeholder=""
                                    style="width: 150px;"
                                    class="order-edit-control form-control"
                                  />
                                  <div class="form-group">
                                    <input
                                      :name="
                                        'variant[' + index + '][cost_price]'
                                      "
                                      type="text"
                                      placeholder=""
                                      :value="variant.variant.cost_price"
                                      class="order-edit-control form-control"
                                      style="width: 150px;"
                                      :class="{
                                        'danger-border': errors.has(
                                          'variant.' + index + '.cost_price'
                                        )
                                      }"
                                    />
                                    <span
                                      class="danger-bg input-info"
                                      v-if="
                                        errors.has(
                                          'variant.' + index + '.cost_price'
                                        )
                                      "
                                    >
                                      {{
                                        errors.first(
                                          'variant.' + index + '.cost_price'
                                        )
                                      }}
                                    </span>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input
                                      :name="
                                        'variant[' + index + '][retail_price]'
                                      "
                                      type="text"
                                      placeholder=""
                                      class="order-edit-control form-control"
                                      :value="variant.variant.retail_price"
                                      style="width: 150px;"
                                      :class="{
                                        'danger-border': errors.has(
                                          'variant.' + index + '.retail_price'
                                        )
                                      }"
                                    />
                                    <span
                                      class="danger-bg input-info"
                                      v-if="
                                        errors.has(
                                          'variant.' + index + '.retail_price'
                                        )
                                      "
                                    >
                                      {{
                                        errors.first(
                                          'variant.' + index + '.retail_price'
                                        )
                                      }}
                                    </span>
                                  </div>
                                </td>
                                <td scope="col">
                                  <div class="form-group">
                                    <input
                                      type="text"
                                      :name="
                                        'variant[' +
                                          index +
                                          '][discounted_price]'
                                      "
                                      placeholder=""
                                      class="order-edit-control form-control"
                                      :value="variant.variant.discounted_price"
                                      style="width: 150px;"
                                      :class="{
                                        'danger-border': errors.has(
                                          'variant.' +
                                            index +
                                            '.discounted_price'
                                        )
                                      }"
                                    />
                                    <span
                                      class="danger-bg input-info"
                                      v-if="
                                        errors.has(
                                          'variant.' +
                                            index +
                                            '.discounted_price'
                                        )
                                      "
                                    >
                                      {{
                                        errors.first(
                                          'variant.' +
                                            index +
                                            '.discounted_price'
                                        )
                                      }}
                                    </span>
                                  </div>
                                </td>
                                <td scope="col">
                                  <div class="form-group">
                                    <input
                                      :name="'variant[' + index + '][barcode]'"
                                      type="text"
                                      class="order-edit-control form-control"
                                      :value="variant.variant.barcode"
                                      style="width: 150px;"
                                      :class="{
                                        'danger-border': errors.has(
                                          'variant.' + index + '.barcode'
                                        )
                                      }"
                                    />
                                    <span
                                      class="danger-bg input-info"
                                      v-if="
                                        errors.has(
                                          'variant.' + index + '.barcode'
                                        )
                                      "
                                    >
                                      {{
                                        errors.first(
                                          'variant.' + index + '.barcode'
                                        )
                                      }}
                                    </span>
                                  </div>
                                </td>
                                <td scope="col">
                                  <div class="form-group">
                                    <input
                                      :name="'variant[' + index + '][sku]'"
                                      type="text"
                                      class="order-edit-control form-control"
                                      :value="variant.variant.sku"
                                      style="width: 150px;"
                                      :class="{
                                        'danger-border': errors.has(
                                          'variant.' + index + '.sku'
                                        )
                                      }"
                                    />
                                    <span
                                      class="danger-bg input-info"
                                      v-if="
                                        errors.has('variant.' + index + '.sku')
                                      "
                                    >
                                      {{
                                        errors.first(
                                          'variant.' + index + '.sku'
                                        )
                                      }}
                                    </span>
                                  </div>
                                </td>
                                <td></td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Select2 from 'v-select2-component'
import ImageUpload from '../../Common/CommonImageUpload'
import Error from '../../../libs/Error'

export default {
  name: 'ProductExtra',
  components: { Select2, ImageUpload },
  props: {
    get_addon_url: {
      type: String,
      default: ''
    },
    get_variant_options: {
      type: String,
      default: ''
    },
    allAddons: {
      type: [Array, String, Object],
      default: () => {}
    },
    allVariants: {
      type: [Array, String, Object],
      default: () => {}
    },
    oldSession: {
      type: [Array, String, Object],
      default: () => {}
    },
    validationErrors: {
      type: [Array, String, Object],
      default: () => {}
    },
    productExistingVariant: {
      type: [Array, String, Object],
      default: () => {}
    },
    productExistingAddons: {
      type: [Array, String, Object],
      default: () => {}
    },
    business_type: {
      type: Number,
      default: 1
    },
    is_addon_or_variant: {
      type: String,
      default: '0'
    },
    variantList: {
      type: [Array, String, Object],
      default: () => {}
    },
    ProductHasVariants: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      base_url: this.$parent.$data.base_url,
      oldSessionData: [],
      productAddons: [],
      has_addons_or_variants: this.business_type,
      productVariants: [],
      selectedAddon: '',
      selectedAddonsList: [],
      addonBackupList: [],
      allAddonsList: [],
      allVariantsList: [],
      variantsList: [],
      selectedVariant: [],
      selectedVariantList: [],
      selectedVariantOption: [[]],
      selectedVariantOptionsList: [[]],
      variantBackupList: [],
      clonedVariant: [],
      showVariantList: [],
      variantOptions: [],
      variantsListObj: [],
      variantObj: {
        variants: [],
        variant: '',
        options: [],
        selectedOptions: []
      },
      variantCombine: [],
      validationErrorsList: [],
      errors: [],
      productVariationObject: {
        barcode: '',
        cost_price: '',
        discounted_price: '',
        id: 50,
        is_active: 0,
        retail_price: '',
        sku: '',
        title: ''
      }
    }
  },
  mounted() {
    if (this.validationErrors) {
      this.validationErrorsList = JSON.parse(this.validationErrors)
      this.errors = new Error()
      this.errors.record(this.validationErrorsList)
    }
    if (this.business_type === 1) {
      if (this.allAddons) {
        this.allAddonsList = JSON.parse(this.allAddons)
        this.allAddonsList = Object.keys(this.allAddonsList).map((key) => {
          return { id: key, text: this.allAddonsList[key] }
        })
        this.addonBackupList = _.cloneDeep(this.allAddonsList)
      }
      if (this.productExistingAddons) {
        this.productAddons = JSON.parse(this.productExistingAddons)

        this.selectedAddonsList = JSON.parse(this.productExistingAddons)

        for (let i = 0; i < this.selectedAddonsList.length; i++) {
          let index = this.allAddonsList.findIndex(
            (addon) => addon.id === this.selectedAddonsList[i].id
          )
          this.allAddonsList.splice(index, 1)
        }
      }
    }

    if (this.allVariants) {
      this.allVariantsList = JSON.parse(this.allVariants)
      this.variantBackupList = _.cloneDeep(this.allVariantsList)

      this.allVariantsList = Object.keys(this.allVariantsList).map((key) => {
        return {
          id: this.allVariantsList[key].name,
          text: this.allVariantsList[key].name,
          options: Object.keys(this.allVariantsList[key].options).map(
            (key2) => this.allVariantsList[key].options[key2].text
          )
        }
      })

      this.clonedVariant = Object.keys(this.allVariantsList).map((key) => {
        return { text: this.allVariantsList[key].text, selected: false }
      })
    }
  },

  methods: {
    addAddon() {
      axios
        .get(this.get_addon_url + '/' + this.selectedAddon)
        .then((response) => {
          this.selectedAddonsList.push(response.data.data)
          let index = this.allAddonsList.findIndex(
            (addon) => addon.id === this.selectedAddon
          )
          this.allAddonsList.splice(index, 1)
          this.selectedAddon = ''
        })
    },
    removeAddon(index) {
      let removedAddon = this.selectedAddonsList.splice(index, 1)

      let addon = this.addonBackupList.find(
        (backup) => parseInt(backup.id) === removedAddon[0].id
      )
      this.allAddonsList.push(addon)
      this.allAddonsList.sort((a, b) => (a.id > b.id ? 1 : -1))
    },

    loadVariantOptions(index, $e) {
      let selectedVariant = this.allVariantsList.find(
        (allVariant) => allVariant.text === $e
      )
      if (selectedVariant === undefined || selectedVariant === '') {
        selectedVariant = this.allVariantsList.find(
          (allVariant) => allVariant.text === $e.text
        )
      }

      if (selectedVariant !== undefined && selectedVariant !== '') {
        this.variantsListObj[index].options = selectedVariant.options
        this.variantsListObj[index].variants = this.clonedVariant
        this.variantsListObj[index].variant = $e
      } else {
        let obj = {
          variant: $e,
          options: [],
          variants: []
        }

        if (
          this.variantsListObj[index].variant === undefined ||
          this.variantsListObj[index].variant === ''
        ) {
          this.variantsListObj.push(obj)
        }
      }
    },

    addOptionsToList() {
      let allSelectedOptions = []
      allSelectedOptions.push(
        Object.keys(this.variantsListObj).map((key) => {
          return this.variantsListObj[key].selectedOptions
        })
      )

      this.variantCombine = this.combos(allSelectedOptions)

      for (let i = 0; i < this.variantCombine.length; i++) {
        this.variantCombine[i].variant = this.productVariationObject
      }
    },

    addVariantField() {
      let clone = Vue.util.extend({}, this.variantObj)

      let availableVariants = Object.keys(this.allVariantsList).map((key) => {
        return this.allVariantsList[key].text
      })

      let allSelectedVariants = []

      allSelectedVariants = Object.keys(this.variantsListObj).map((key) => {
        return this.variantsListObj[key].variant
      })

      if (allSelectedVariants.length > 0) {
        for (let i = 0; i < allSelectedVariants.length; i++) {
          for (let j = 0; j < availableVariants.length; j++) {
            if (availableVariants[j] === allSelectedVariants[i]) {
              availableVariants.splice(j, 1)
            }
          }
        }
      }

      clone.variants = availableVariants
      this.variantsListObj.push(clone)
    },

    removeVariant(index) {
      this.variantsListObj.splice(index, 1)
      this.addOptionsToList()
    },
    combos(list, n = 0, result = [], current = []) {
      if (n === list.length) result.push(current)
      else if (list[n].length > 0)
        list[n].forEach((item) =>
          this.combos(list, n + 1, result, [...current, item])
        )
      return result
    },
    updateHasAddonOrVariants(value) {
      this.has_addons_or_variants = value
    }
  },
  computed: {
    checkVariant() {
      console.log(array_end(this.variantCombine[0]))
      return (
        array_end(this.variantCombine[0]) !== '' &&
        array_end(this.variantCombine[0]) !== undefined
      )
    }
  }
}
</script>

<style scoped>
@import 'https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900';
@import 'https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css';
@import './../../../../../public/business_assets/css/style.css';
.select2-container--default.select2-selection--multiple.select2-selection__choice {
  background-color: #28a745;
  border-color: #3d9970;
}
.beforeUpload .icon[data-v-69bb59a3] {
  width: 20px !important;
  margin: auto;
  display: block;
}
.v-application--wrap {
  min-height: auto !important;
  height: auto !important;
}
</style>
