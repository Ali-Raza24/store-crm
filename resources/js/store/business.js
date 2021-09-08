const businessStore = {
  state: {
    all: [],
    loading: false
  },

  mutations: {
    SET_LOADING(state, payload) {
      state.loading = payload;
    },

    SET(state, payload) {
      state.all = payload;
    }
  },

  actions: {
    fetchAll({ commit }, params) {
      try {
        commit('SET_LOADING', true);
        const { data: data } = axios.get('/api/').then((response) => {
          commit('SET', data);
          commit('SET_LOADING', false);
        });
      } catch (e) {
      } finally {
        commit('SET_LOADING', false);
      }
    }
  }
};

export default businessStore;
