<template>
  <div>
    <nav class="tabs-head mobile-hide" id="allOrders">
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a
          class="nav-item nav-link"
          :class="{ active: showBrandSection }"
          id="settBarnds-tab"
          data-toggle="tab"
          @click="showBrandTab"
          href="#settBarnds"
          role="tab"
          aria-controls="settBarnds"
          aria-selected="true"
          v-if="brand_permission"
        >
          Brands
        </a>
        <a
          class="nav-item nav-link"
          :class="{ active: showCategorySection }"
          id="settCate-tab"
          data-toggle="tab"
          @click="showCategoryTab"
          href="#settCate"
          role="tab"
          aria-controls="settCate"
          aria-selected="false"
          v-if="category_permission"
        >
          Categories
        </a>
        <a
          class="nav-item nav-link"
          :class="{ active: showAddonSection }"
          id="settAddons-tab"
          data-toggle="tab"
          @click="showAddonTab"
          href="#settAddons"
          role="tab"
          aria-controls="settAddons"
          aria-selected="false"
          v-if="addon_permission"
        >
          Addons
        </a>
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
        v-if="brand_permission || addon_permission || category_permission"
      >
        <span v-if="brand_permission">Brands</span>
        <span
          v-if="addon_permission && !brand_permission && !category_permission"
          >Addon</span
        >
        <span
          v-if="category_permission && !addon_permission && !brand_permission"
          >Category</span
        >
      </button>
      <div class="dropdown-menu" aria-labelledby="dropTab">
        <a
          class="nav-item nav-link"
          href="javascript:void(0)"
          v-if="brand_permission"
        >
          Brands
        </a>
        <a
          class="nav-item nav-link active"
          href="javascript:void(0)"
          v-if="category_permission"
        >
          Categories
        </a>
        <a
          class="nav-item nav-link"
          href="javascript:void(0)"
          v-if="addon_permission"
        >
          Addons
        </a>
      </div>
    </div>
    <hr class="m-0" />
    <div class="tab-content mt-5" id="nav-settingContent">
      <brand-listing
        v-if="showBrandSection === true && brand_permission"
        :brands_status_change_confirmation_url="
          brands_status_change_confirmation_url
        "
        :delete_brands_popup_confirmation_url="
          delete_brands_popup_confirmation_url
        "
        :brand_status_change_url="brand_status_change_url"
        :get_all_brands_url="get_all_brands_url"
        :edit_brand_url="edit_brand_url"
        :add_brand_url="add_brand_url"
        :delete_brand_url="delete_brand_url"
        :brand_permissions="brand_permissions"
      ></brand-listing>
      <category-listing
        v-if="showCategorySection === true && category_permission"
        :bulk_categories_status_change="bulk_categories_status_change"
        :delete_categories_popup_confirmation_url="
          delete_categories_popup_confirmation_url
        "
        :get_all_categories="get_all_categories"
        :edit_category_url="edit_category_url"
        :add_category_url="add_category_url"
        :delete_category_url="delete_category_url"
        :category_status_update_url="category_status_update_url"
        :category_permissions="category_permissions"
      ></category-listing>
      <addon-listing
        v-if="showAddonSection === true && addon_permission"
        :bulk_addons_status_change="bulk_addons_status_change"
        :delete_addons_popup_confirmation_url="
          delete_addons_popup_confirmation_url
        "
        :get_all_addons="get_all_addons"
        :edit_addon_url="edit_addon_url"
        :add_addon_url="add_addon_url"
        :delete_addon_url="delete_addon_url"
        :addon_status_update_url="addon_status_update_url"
        :addon_permissions="addon_permissions"
      ></addon-listing>
    </div>
  </div>
</template>
<script>
import BrandListing from './BrandListing'
import CategoryListing from './CategoryListing'
import AddonListing from './AddonListing'

export default {
  name: 'Main',
  components: {
    BrandListing,
    CategoryListing,
    AddonListing
  },
  mounted() {
    if (this.addon_permission) {
      this.showAddonTab()
    }
    if (this.category_permission) {
      this.showCategoryTab()
    }
    if (this.brand_permission) {
      this.showBrandTab()
    }
  },
  props: {
    brand_permission: {
      type: Boolean,
      default: false
    },
    addon_permission: {
      type: Boolean,
      default: false
    },
    category_permission: {
      type: Boolean,
      default: false
    },
    brand_permissions: {
      type: [Array, Object],
      default: () => {}
    },
    addon_permissions: {
      type: [Array, Object],
      default: () => {}
    },
    category_permissions: {
      type: [Array, Object],
      default: () => {}
    },
    brand_status_change_url: {
      type: String,
      default: ''
    },
    bulk_addons_status_change: {
      type: String,
      default: ''
    },
    bulk_categories_status_change: {
      type: String,
      default: ''
    },
    brands_status_change_confirmation_url: {
      type: String,
      default: ''
    },
    delete_categories_popup_confirmation_url: {
      type: String,
      default: ''
    },
    delete_brands_popup_confirmation_url: {
      type: String,
      default: ''
    },
    delete_addons_popup_confirmation_url: {
      type: String,
      default: ''
    },
    delete_popup_confirmation_url: {
      type: String,
      default: ''
    },
    get_all_brands_url: {
      type: String,
      default: ''
    },
    edit_brand_url: {
      type: String,
      default: ''
    },
    add_brand_url: {
      type: String,
      default: ''
    },
    delete_brand_url: {
      type: String,
      default: ''
    },

    get_all_categories: {
      type: String,
      default: ''
    },
    edit_category_url: {
      type: String,
      default: ''
    },
    add_category_url: {
      type: String,
      default: ''
    },
    delete_category_url: {
      type: String,
      default: ''
    },
    category_status_update_url: {
      type: String,
      default: ''
    },
    get_all_addons: {
      type: String,
      default: ''
    },
    edit_addon_url: {
      type: String,
      default: ''
    },
    add_addon_url: {
      type: String,
      default: ''
    },
    delete_addon_url: {
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
      activeClass: 'active',
      showBrandSection: true,
      showCategorySection: false,
      showAddonSection: false
    }
  },
  methods: {
    showAddonTab() {
      this.showBrandSection = false
      this.showCategorySection = false
      this.showAddonSection = true
    },
    showCategoryTab() {
      this.showBrandSection = false
      this.showCategorySection = true
      this.showAddonSection = false
    },
    showBrandTab() {
      this.showBrandSection = true
      this.showCategorySection = false
      this.showAddonSection = false
    }
  }
}
</script>

<style scoped></style>
