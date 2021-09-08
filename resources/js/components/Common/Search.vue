<template>
  <v-app>
    <v-autocomplete
      v-model="model"
      :items="items"
      :search-input.sync="search"
      label="Search"
      placeholder="Start typing to Search"
      color="blue-grey lighten-2"
      item-text="name"
      item-value="name"
    >
      <template v-slot:item="data">
        <template>
          <v-list-item-content @click="redirect(data.item.url)">
            <v-list-item-title v-html="data.item.name"></v-list-item-title>
            <v-list-item-subtitle
              v-html="data.item.group"
            ></v-list-item-subtitle>
          </v-list-item-content>
        </template>
      </template>
    </v-autocomplete>
  </v-app>
</template>

<script>
export default {
  name: 'Search',
  data() {
    return {
      descriptionLimit: 60,
      entries: [],
      isLoading: false,
      model: null,
      search: null,
      base_url: this.$parent.$data.base_url
    }
  },
  methods: {
    redirect(url) {
      window.location.href = url
    }
  },
  computed: {
    fields() {
      if (!this.model) return []

      return Object.keys(this.model).map((key) => {
        return {
          key,
          value: this.model[key] || 'n/a'
        }
      })
    },
    items() {
      return this.entries
    }
  },

  watch: {
    search(val) {
      // Items have already been requested
      if (this.isLoading) return

      this.isLoading = true

      // Lazily load input items
      axios
        .get(this.base_url + '/search?term=' + val)
        .then((res) => {
          this.entries = res.data.data
          this.entries = Object.keys(this.entries).map((key) => {
            console.log(typeof this.entries[key])
            return this.entries[key]
          })
        })
        .catch((err) => {
          console.log(err)
        })
        .finally(() => (this.isLoading = false))
    }
  }
}
</script>

<style scoped></style>
