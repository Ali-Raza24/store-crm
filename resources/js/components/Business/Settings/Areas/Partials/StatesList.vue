<template>
  <!--  <div
    class="nav flex-column nav-tabs scroll-bar-thin"
    aria-orientation="vertical"
    role="tablist"
  >
    <a
      v-for="(list, index) in lists"
      :key="list.id"
      class="nav-link"
      :class="{ ['active']: parseInt(state_id) === parseInt(list.id) }"
      @click="filterAreas(list.id)"
    >
      {{ list.name }}
    </a>
  </div>-->
  <v-card>
    <v-tabs vertical v-model="activeState">
      <v-tab
        v-for="(state, index) in lists"
        :key="index + 1"
        @click="filterAreas(state.id)"
      >
        {{ state.name }}
      </v-tab>
    </v-tabs>
  </v-card>
</template>

<script>
export default {
  name: 'StatesList',
  props: {
    lists: {
      type: [Array, Object],
      default: () => {}
    },
    zone: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      activeState: false
    }
  },
  mounted() {
    this.activeState = this.$store.state.state_id - 1
  },
  methods: {
    filterAreas(index) {
      this.$store.commit('SET_STATE_ID', index)

      let areas = this.$store.state.areasList
      let areasByState = areas.filter((area) => {
        return parseInt(area.state_id) === parseInt(index)
      })

      this.$store.commit('SET_AREAS_BY_STATE', areasByState)

      console.log(
        this.$store.state.areasListByState.length > 0 &&
          this.selectedBusinessAreas.length > 0 &&
          this.$store.state.areasListByState.length ===
            this.selectedBusinessAreas.length
          ? 1
          : 0
      )

      this.$parent.$refs.areasTab.$data.checkAll =
        this.$store.state.areasListByState.length > 0 &&
        this.selectedBusinessAreas.length > 0 &&
        this.$store.state.areasListByState.length ===
          this.selectedBusinessAreas.length
          ? 1
          : 0
    }
  },
  computed: {
    state_id() {
      return this.$store.getters.get_state_id
    },
    selectedBusinessAreas() {
      let activeAreas = this.$parent.$refs.areasTab.$data.activeAreas.filter(
        (area) => area.state_id === this.state
      )

      return Object.keys(activeAreas).map((key) => {
        return activeAreas[key].area_id
      })
    },
    state() {
      return this.$store.state.state_id
    }
  }
}
</script>

<style></style>
