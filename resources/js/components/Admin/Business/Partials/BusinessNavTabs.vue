<template>
  <div class="col-filter">
    <nav class="tabs-head mobile-hide" id="allOrders">
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a
          class="nav-item nav-link active"
          id="all-business-tab"
          data-toggle="tab"
          href="#All-Business"
          role="tab"
          aria-controls="All-Business"
          aria-selected="true"
          @click="show('all')"
        >
          All Business
        </a>
        <a
          class="nav-item nav-link"
          id="new-business-tab"
          data-toggle="tab"
          href="#New"
          role="tab"
          aria-controls="New"
          aria-selected="false"
          @click="show('new')"
        >
          New
        </a>
        <a
          class="nav-item nav-link"
          id="active-business-tab"
          data-toggle="tab"
          href="#Actived"
          role="tab"
          aria-controls="Actived"
          aria-selected="false"
          @click="show('active')"
        >
          Actived
        </a>
        <a
          class="nav-item nav-link"
          id="suspended-business-tab"
          data-toggle="tab"
          href="#Suspended"
          role="tab"
          aria-controls="Suspended"
          aria-selected="false"
          @click="show('suspended')"
        >
          Suspended
        </a>
        <a
          class="nav-item nav-link"
          id="upcoming-payment-tab"
          data-toggle="tab"
          href="#Upcoming-Payment"
          role="tab"
          aria-controls="Upcoming-Payment"
          aria-selected="false"
          @click="show('upcoming-payments')"
        >
          Upcoming Payment
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
        @click="show('all')"
      >
        All Business
      </button>
      <div class="dropdown-menu" aria-labelledby="dropTab">
        <a
          class="nav-item nav-link active"
          href="javascript:void(0)"
          @click="show('new')"
          >New</a
        >
        <a
          class="nav-item nav-link"
          href="javascript:void(0)"
          @click="show('active')"
          >Active</a
        >
        <a
          class="nav-item nav-link"
          href="javascript:void(0)"
          @click="show('suspended')"
          >Suspended</a
        >
        <a
          class="nav-item nav-link"
          href="javascript:void(0)"
          @click="show('upcoming-payments')"
        >
          Upcoming Payment
        </a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'NavTabs',
  methods: {
    show(type) {
      if (type === 'all') {
        this.$parent.$data.showAll = true
        this.$parent.$data.showNew = false
        this.$parent.$data.showActive = false
        this.$parent.$data.showSuspended = false
        this.$parent.$data.showUpcoming = false
      }
      if (type === 'new') {
        this.$parent.$data.showAll = false
        this.$parent.$data.showNew = true
        this.$parent.$data.showActive = false
        this.$parent.$data.showSuspended = false
        this.$parent.$data.showUpcoming = false
      }
      if (type === 'active') {
        this.$parent.$data.showAll = false
        this.$parent.$data.showNew = false
        this.$parent.$data.showActive = true
        this.$parent.$data.showSuspended = false
        this.$parent.$data.showUpcoming = false
      }
      if (type === 'suspended') {
        this.$parent.$data.showAll = false
        this.$parent.$data.showNew = false
        this.$parent.$data.showActive = false
        this.$parent.$data.showSuspended = true
        this.$parent.$data.showUpcoming = false
      }
      if (type === 'upcoming-payments') {
        this.$parent.$data.showAll = false
        this.$parent.$data.showNew = false
        this.$parent.$data.showActive = false
        this.$parent.$data.showSuspended = false
        this.$parent.$data.showUpcoming = true
      }
    }
  }
}
</script>

<style scoped></style>
