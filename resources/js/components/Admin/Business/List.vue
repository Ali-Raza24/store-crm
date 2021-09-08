<template>
  <div>
    <AddBusiness
      :get_url="get_url"
      :save_url="add_url"
      :business_type_url="business_type_url"
      :countries_url="countries_url"
      :states_url="states_url"
      :industries_url="industries_url"
    />
  </div>
</template>

<script>
import AddBusiness from './AddBusiness'
export default {
  name: 'List',
  components: {
    AddBusiness
  },
  props: {
    total_business: {
      type: String,
      default: '0'
    },
    total_stores: {
      type: String,
      default: '0'
    },
    cancelled_order: {
      type: String,
      default: '0'
    },
    total_sales: {
      type: String,
      default: '0'
    },
    get_business_url: {
      type: String,
      default: ''
    },
    get_business_status_list: {
      type: String,
      default: ''
    },
    add_url: {
      type: String,
      default: ''
    },
    get_url: {
      type: String,
      default: ''
    },
    business_type_url: {
      type: String,
      default: ''
    },
    countries_url: {
      type: String,
      default: ''
    },
    states_url: {
      type: String,
      default: ''
    },
    industries_url: {
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
    update_business_status: {
      type: String,
      default: ''
    }
  },
  data: function() {
    return {
      base_url: this.$parent.$data.base_url,
      business: [],
      business_status: []
    }
  },
  created() {
    axios
      .get(this.get_business_status_list)
      .then((response) => (this.business_status = response.data.data))
  }
}
</script>

<style scoped></style>
