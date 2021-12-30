import Vue from "vue";
import {
  getSubsoilCounters,
  getTableData,
} from "../../components/PlastFluids/services/mapService";
import { getHorizonBlocks } from "../../components/PlastFluids/services/templateService";
import { convertToFormData } from "../../components/PlastFluids/helpers";

const plastFluids = {
  namespaced: true,

  state: {
    subsoils: [],
    currentSubsoil: [],
    subsoilFields: [],
    currentSubsoilField: [],
    subsoilHorizons: [],
    currentSubsoilHorizon: [],
    blocks: [],
    currentBlocks: [],
    subsoilFieldCounters: {},
    loading: false,
    analysisTableFields: [],
    analysisTableRows: [],
    analysisTableActiveColumns: [],
  },

  mutations: {
    SET_SUBSOILS(state, payload) {
      state.subsoils = payload;
    },
    SET_CURRENT_SUBSOIL(state, payload) {
      state.currentSubsoil = [];
      state.currentSubsoil.push(payload);
    },
    SET_SUBSOIL_FIELDS(state, payload) {
      state.subsoilFields = payload;
    },
    SET_CURRENT_SUBSOIL_FIELD(state, payload) {
      state.currentSubsoilField = [];
      Vue.set(state.currentSubsoilField, 0, payload);
    },
    SET_SUBSOIL_HORIZONS(state, payload) {
      state.subsoilHorizons = payload;
    },
    SET_CURRENT_SUBSOIL_HORIZON(state, payload) {
      state.currentSubsoilHorizon = payload;
    },
    SET_BLOCKS(state, payload) {
      state.blocks = payload;
    },
    SET_CURRENT_BLOCKS(state, payload) {
      state.currentBlocks = payload;
    },
    SET_SUBSOIL_FIELD_COUNTERS(state, payload) {
      state.subsoilFieldCounters = payload;
    },
    SET_LOADING(state, payload) {
      state.loading = payload;
    },
    SET_ANALYSIS_TABLE_FIELDS(state, payload) {
      state.analysisTableFields = payload;
    },
    SET_ANALYSIS_TABLE_ROWS(state, payload) {
      state.analysisTableRows = payload;
    },
    SET_ANALYSIS_ACTIVE_COLUMNS(state, payload) {
      state.analysisTableActiveColumns = payload;
    },
  },
  actions: {
    UPDATE_CURRENT_SUBSOIL({ commit }, value) {
      commit("SET_CURRENT_SUBSOIL", value);
      commit("SET_CURRENT_SUBSOIL_FIELD", {});
      commit("SET_CURRENT_SUBSOIL_HORIZON", []);
      commit("SET_SUBSOIL_FIELDS", value?.fields);
      commit("SET_SUBSOIL_HORIZONS", []);
      commit("SET_CURRENT_BLOCKS", []);
      commit("SET_SUBSOIL_FIELD_COUNTERS", {});
    },
    UPDATE_CURRENT_SUBSOIL_FIELD({ commit }, value) {
      commit("SET_CURRENT_SUBSOIL_FIELD", value);
      commit("SET_CURRENT_SUBSOIL_HORIZON", []);
      commit("SET_SUBSOIL_HORIZONS", value?.horizons ?? []);
      commit("SET_CURRENT_BLOCKS", []);
    },
    async GET_HORIZON_BLOCKS({ state, commit }) {
      const horizonIDs = state.currentSubsoilHorizon.map(
        (horizon) => horizon.horizon_id
      );
      if (horizonIDs.length) {
        const postData = new FormData();
        horizonIDs.forEach((horizon) => postData.append("horizons", horizon));
        const blocks = await getHorizonBlocks(postData);
        commit("SET_BLOCKS", blocks);
      } else {
        commit("SET_BLOCKS", []);
      }
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
    async handleAnalysisTableData({ commit, state, rootState }, dataToPost) {
      const { postUrl, ...rest } = dataToPost;
      try {
        commit("plastFluidsLocal/SET_LOADING", true, { root: true });
        let horizonIDs = "None";
        let blockIDs = "None";
        if (state.currentSubsoilHorizon.length)
          horizonIDs = state.currentSubsoilHorizon.map(
            (horizon) => horizon.horizon_id
          );

        if (state.currentBlocks.length)
          blockIDs = state.currentBlocks.map((block) => block.block_id);

        const postDataMock = {
          horizons: horizonIDs,
          blocks: blockIDs,
          vid_fluid: "None",
          data_start: "None",
          data_end: "None",
          graph_type: rootState.plastFluidsLocal.graphType,
        };
        let merged = { ...postDataMock, ...rest };
        const postData = convertToFormData(merged);
        const data = await getTableData(postData, postUrl);
        if (Array.isArray(data)) {
          commit("SET_ANALYSIS_TABLE_FIELDS", data[0].table_header);
          if (rootState.plastFluidsLocal.graphType === "ps_bs_ds_ms") {
            commit(
              "plastFluidsLocal/SET_DEFAULT_INTERSECTION",
              data[2].intersection,
              { root: true }
            );
            commit("SET_ANALYSIS_TABLE_ROWS", data.slice(3));
            return;
          }
          commit("SET_ANALYSIS_TABLE_ROWS", data.slice(2));
        } else {
          commit("SET_ANALYSIS_TABLE_FIELDS", data.header);
          commit("SET_ANALYSIS_TABLE_ROWS", data.table);
        }
      } catch (error) {
        console.log(error);
      } finally {
        commit("plastFluidsLocal/SET_LOADING", false, { root: true });
      }
    },
  },
};

export default plastFluids;
