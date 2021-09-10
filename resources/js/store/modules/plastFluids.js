import Vue from "vue";

const plastFluids = {
  namespaced: true,

  state: {
    currentSubsoilHorizon: "",
    currentSubsoilField: [],
    currentSubsoil: [],
    subsoils: [],
    subsoilFields: [],
  },

  mutations: {
    SET_CURRENT_SUBSOIL(state, payload) {
      state.currentSubsoil = [];
      Vue.set(state.currentSubsoil, 0, payload);
    },
    SET_CURRENT_SUBSOIL_FIELD(state, payload) {
      state.currentSubsoilField = [];
      Vue.set(state.currentSubsoilField, 0, payload);
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
  },
};

export default plastFluids;
