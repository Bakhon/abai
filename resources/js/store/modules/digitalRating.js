const digitalRating = {
  namespaced: true,
  state: {
    sectorNumber: null,
    horizonNumber: 13,
    indicators: null,
    injDiagramIndicators: null,
    prodDiagramIndicators: null,
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
    SET_INJ_DIAGRAM(state, payload) {
      state.injDiagramIndicators = payload;
    },
    SET_PROD_DIAGRAM(state, payload) {
      state.prodDiagramIndicators = payload;
    },
    CLEAR_ATLAS(state) {
      state.indicators = null;
      state.injDiagramIndicators = null;
      state.prodDiagramIndicators = null;
    },
  },

  getters: {
    injDiagramIndicators: (state) => {
      return {
        ...state.injDiagramIndicators,
        type: 'scatter',
        name: 'Приемистость'
      }
    },
    liguidDiagramIndicators: (state) => {
      return {
        ...state.prodDiagramIndicators?.liquid_prod,
        type: 'scatter',
        name: 'Добыча жидкости',
      }
    },
    oilProdDiagramIndicators: (state) => {
      return {
        ...state.prodDiagramIndicators?.oil_prod,
        type: 'scatter',
        name: 'Добыча нефти',
        yaxis: 'y2',
      }
    }
  },

  actions: {
    async fetchIndicators({ commit, state }) {
      const { sectorNumber, horizonNumber } = {...state};
      try {
        commit('globalloading/SET_LOADING', true, { root: true });
        await axios.get(`${process.env.MIX_DIGITAL_RATING_MAPS}/graphs/${horizonNumber}/${sectorNumber}`)
          .then(res => {
            commit('SET_INDICATORS', res.data);
            commit('SET_INJ_DIAGRAM', res.data?.inj_graph?.injection);
            commit('SET_PROD_DIAGRAM', res.data?.prod_graph);
          });
      } catch(e) {
        throw new Error(e);
      } finally {
        commit('globalloading/SET_LOADING', false, { root: true });
      }
    }
  }
}

export default digitalRating;