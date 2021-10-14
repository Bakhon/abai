import axios from 'axios';

const digitalRating = {
  namespaced: true,
  state: {
    sectorNumber: null,
    horizonNumber: 13,
    indicators: [],
  },

  mutations: {
    SET_SECTOR(state, payload) {
      state.sectorNumber = payload;
    },
    SET_HORIZON(state, payload) {
      state.horizonNumber = payload;
    },
    SET_INDICATORS(state, payload) {
      state.indicators = payload;
    },
    CLEAR_ATLAS(state) {
      state.indicators = [];
    },
  },

  actions: {
    async fetchIndicators({ commit, state }) {
      const params = {
        sector: state.sectorNumber,
        horizon: state.horizonNumber
      }
      try {
        const res = await axios.get(this._vm.localeUrl(`digital-rating/get_environment`), {params});
        commit('SET_INDICATORS', res.data);
      } catch(e) {
        throw new Error(e);
      }
    }
  }
}

export default digitalRating;