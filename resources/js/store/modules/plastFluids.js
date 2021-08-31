const plastFluids = {
  namespaced: true,

  state: {
    currentSubsoilHorizon: "",
    currentSubsoilField: "",
    currentSubsoil: [],
    subsoils: [],
    subsoilFields: [],
    currentPage: "",
  },

  mutations: {
    SET_CURRENT_SUBSOIL(state, payload) {
      state.currentSubsoil = [];
      state.currentSubsoil = [payload];
    },
    SET_CURRENT_SUBSOIL_FIELD(state, payload) {
      state.currentSubsoilField = [];
      state.currentSubsoilField = [payload];
    },
    SET_CURRENT_SUBSOIL_HORIZON(state, payload) {
      state.currentSubsoilHorizon = payload;
    },
    SET_SUBSOILS(state, payload) {
      state.subsoils = payload;
    },
    SET_SUBSOIL_FIELDS(state, payload) {
      state.subsoilFields = payload;
    },
    SET_CURRENT_PAGE(state, payload) {
      state.currentPage = payload;
    },
  },
};

export default plastFluids;
