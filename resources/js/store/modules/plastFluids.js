import Vue from "vue";

const plastFluids = {
  namespaced: true,

  state: {
    currentSubsoilHorizon: [],
    currentSubsoilField: [],
    currentSubsoil: [],
    subsoils: [],
    subsoilFields: [],
    subsoilHorizons: [],
  },

  mutations: {
    SET_CURRENT_SUBSOIL(state, payload) {
      state.currentSubsoil = [];
      state.currentSubsoil.push(payload);
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
    SET_SUBSOIL_HORIZONS(state, payload) {
      state.subsoilHorizons = payload;
    },
  },
  actions: {
    UPDATE_CURRENT_SUBSOIL({ commit }, value) {
      commit("SET_CURRENT_SUBSOIL", value);
      commit("SET_CURRENT_SUBSOIL_FIELD", {});
      commit("SET_CURRENT_SUBSOIL_HORIZON", []);
      commit("SET_SUBSOIL_FIELDS", value?.fields);
      commit("SET_SUBSOIL_HORIZONS", []);
    },
    UPDATE_CURRENT_SUBSOIL_FIELD({ commit }, value) {
      commit("SET_CURRENT_SUBSOIL_FIELD", value);
      commit("SET_CURRENT_SUBSOIL_HORIZON", []);
      commit("SET_SUBSOIL_HORIZONS", value?.horizons ?? []);
    },
  },
};

export default plastFluids;
