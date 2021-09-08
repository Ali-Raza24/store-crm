import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    areasList: [],
    areasListByState: [],
    state_id: 1,
    activeAreas: [],
    selectedAreas: [],
    zone: [],
    zone_id: 0,
    selectedZones: [],
    zoneAreas: [],
    zone_state_ids: [],
    delivery_company_id: 0,
    default_store: 0
  },

  getters: {
    get_state_id: (state) => state.state_id
  },

  mutations: {
    SET_AREAS(state, payload) {
      state.areasList = payload;
    },
    SET_AREAS_BY_STATE(state, payload) {
      state.areasListByState = payload;
    },
    SET_STATE_ID(state, payload) {
      state.state_id = payload;
    },
    SET_SELECTED_AREAS(state, payload) {
      state.selectedAreas = payload;
    },
    SET_ZONE_ID(state, payload) {
      state.zone_id = payload;
    },
    SET_ZONE(state, payload) {
      state.zone = payload;
    },
    SET_SELECTED_ZONES(state, payload) {
      state.selectedZones = payload;
    },
    SET_ZONE_AREAS(state, payload) {
      state.zoneAreas = payload;
    },
    SET_ZONE_STATE_ID(state, payload) {
      state.zone_state_ids = payload;
    },
    SET_DELIVERY_COMPANY_ID(state, payload) {
      state.delivery_company_id = payload;
    },
    SET_DEFAULT_STORE(state, payload) {
      state.default_store = payload;
    }
  },

  actions: {}
});
