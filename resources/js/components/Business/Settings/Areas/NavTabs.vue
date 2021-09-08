<template>
  <div>
    <nav class="tabs-head mobile-hide" id="allOrders">
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a
          class="nav-item nav-link active"
          id="General-tab"
          data-toggle="tab"
          href="#General"
          role="tab"
          aria-controls="General"
          aria-selected="true"
          @click="activeTab('general')"
        >
          General
        </a>
        <a
          class="nav-item nav-link"
          id="Area-tab"
          data-toggle="tab"
          href="#Area"
          role="tab"
          aria-controls="Area"
          aria-selected="true"
          @click="activeTab('area')"
        >
          Areas
        </a>
        <a
          v-if="zone_permission || zone_permissions.length > 0"
          class="nav-item nav-link"
          id="Zones-tab"
          data-toggle="tab"
          href="#Zones"
          role="tab"
          aria-controls="Zones"
          aria-selected="false"
          @click="activeTab('zone')"
        >
          Zones
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
      >
        General
      </button>
      <div class="dropdown-menu" aria-labelledby="dropTab">
        <a
          class="nav-item nav-link active"
          href="javascript:void(0)"
          @click="activeTab('general')"
        >
          General
        </a>
        <a
          class="nav-item nav-link"
          href="javascript:void(0)"
          @click="activeTab('zone')"
        >
          Zones
        </a>
      </div>
    </div>
    <hr class="m-0" />
  </div>
</template>

<script>
export default {
  name: 'NavTabs',
  props: {
    zone_permission: {
      type: Boolean,
      default: false
    },
    zone_permissions: {
      type: [Array, Object],
      default: () => {}
    },
    store_delivery_permission: {
      type: Boolean,
      default: false
    },
    shipping_areas_permission: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {}
  },
  methods: {
    activeTab(type) {
      this.$store.commit('SET_STATE_ID', 1)
      if (type === 'general') {
        this.$parent.$data.showGeneralTab = true
        this.$parent.$data.showAreaTab = false
        this.$parent.$data.showZoneTab = false
      } else if (type === 'area') {
        this.$parent.$data.showGeneralTab = false
        this.$parent.$data.showAreaTab = true
        this.$parent.$data.showZoneTab = false
      } else {
        this.$parent.$data.showGeneralTab = false
        this.$parent.$data.showAreaTab = false
        this.$parent.$data.showZoneTab = true
      }
    }
  }
}
</script>

<style scoped></style>
