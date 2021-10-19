import Vue from "vue";
import { getSubsoilCounters } from "../../components/PlastFluids/services/mapService";

const plastFluids = {
  namespaced: true,

  state: {
    currentSubsoilHorizon: [],
    currentSubsoilField: [],
    currentSubsoil: [],
    subsoils: [],
    subsoilFields: [],
    subsoilHorizons: [],
    subsoilFieldCounters: {},
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
    SET_SUBSOIL_FIELD_COUNTERS(state, payload) {
      state.subsoilFieldCounters = payload;
    },
  },
  actions: {
    UPDATE_CURRENT_SUBSOIL({ state, commit }, value) {
      commit("SET_CURRENT_SUBSOIL", value);
      commit("SET_CURRENT_SUBSOIL_FIELD", {});
      commit("SET_CURRENT_SUBSOIL_HORIZON", []);
      commit("SET_SUBSOIL_FIELDS", value?.fields);
      commit("SET_SUBSOIL_HORIZONS", []);
      commit("SET_SUBSOIL_FIELD_COUNTERS", {});
    },
    async UPDATE_CURRENT_SUBSOIL_FIELD({ commit, dispatch }, value) {
      commit("SET_CURRENT_SUBSOIL_FIELD", value);
      commit("SET_CURRENT_SUBSOIL_HORIZON", []);
      commit("SET_SUBSOIL_HORIZONS", value?.horizons ?? []);
      if (value?.field_id) await dispatch("GET_SUBSOIL_FIELD_COUNTERS");
    },
    async GET_SUBSOIL_FIELD_COUNTERS({ state, commit }) {
      const postData = new FormData();
      postData.append("field_id", state.currentSubsoilField[0].field_id);
      postData.append(
        "horizons",
        state.currentSubsoilHorizon.length
          ? state.currentSubsoilHorizon.map((horizon) => horizon.horizon_id)
          : "None"
      );
      const countersData = await getSubsoilCounters(postData);
      commit("SET_SUBSOIL_FIELD_COUNTERS", countersData.data);
    },
  },
};

export default plastFluids;
