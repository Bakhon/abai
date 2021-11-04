import translation from "../../VueTranslation/Translation";
import { getTemplateData } from "../../components/PlastFluids/services/templateService";
import { getTableGraphData } from "../../components/PlastFluids/services/graphService";
import { convertToFormData } from "../../components/PlastFluids/helpers";

const plastFluidsLocal = {
  namespaced: true,

  state: {
    fileLog: null,
    reportDuplicated: false,
    downloadFileData: {},
    tableFields: [],
    tableRows: [],
    currentTemplate: {},
    tableState: "default",
    loading: false,
    graphType: "ps_bs_ds_ms",
    localHorizons: [],
    blocks: [],
    currentBlocks: [],
    currentSelectedCorrelation_ps: "",
    currentSelectedCorrelation_bs: "",
    currentSelectedCorrelation_ms: "",
    currentSelectedSamples: [],
  },

  mutations: {
    SET_FILE_LOG(state, payload) {
      state.fileLog = payload;
    },
    SET_REPORT_DUPLICATED_STATUS(state, payload) {
      state.reportDuplicated = payload;
    },
    SET_DOWNLOAD_FILE_DATA(state, payload) {
      state.downloadFileData = payload;
    },
    SET_TABLE_FIELDS(state, payload) {
      state.tableFields = payload;
    },
    SET_TABLE_ROWS(state, payload) {
      state.tableRows = payload;
    },
    SET_CURRENT_TEMPLATE(state, payload) {
      state.currentTemplate = payload;
    },
    SET_TABLE_STATE(state, payload) {
      state.tableState = payload;
    },
    SET_LOADING(state, payload) {
      state.loading = payload;
    },
    SET_GRAPH_TYPE(state, payload) {
      state.graphType = payload;
    },
    SET_LOCAL_HORIZONS(state, payload) {
      state.localHorizons = payload;
    },
    SET_BLOCKS(state, payload) {
      state.blocks = payload;
    },
    SET_CURRENT_BLOCKS(state, payload) {
      state.currentBlocks = payload;
    },
    SET_CURRENT_CORRELATION_PS(state, payload) {
      state.currentSelectedCorrelation_ps = payload;
    },
    SET_CURRENT_CORRELATION_BS(state, payload) {
      state.currentSelectedCorrelation_bs = payload;
    },
    SET_CURRENT_CORRELATION_MS(state, payload) {
      state.currentSelectedCorrelation_ms = payload;
    },
    SET_CURRENT_SELECTED_SAMPLES(state, payload) {
      if (payload === "clear") {
        state.currentSelectedSamples = [];
        return;
      }
      if (state.currentSelectedSamples.includes(payload)) {
        const index = state.currentSelectedSamples.findIndex(
          (element) => element === payload
        );
        state.currentSelectedSamples.splice(index, 1);
        return;
      }
      state.currentSelectedSamples.push(payload);
    },
  },

  actions: {
    HANDLE_FILE_LOG({ commit }, sheets) {
      let entries = [];
      sheets.forEach((sheet) => {
        let key = Object.keys(sheet)[0];
        let replacedKey = key.replace(
          "sheet",
          translation.translate("plast_fluids.page")
        );
        entries.push([replacedKey, sheet[key]]);
      });
      commit("SET_FILE_LOG", entries);
    },
    async getTableData({}, obj) {
      const payload = new FormData();
      for (let key in obj.mutatedData) {
        payload.append(key, obj.mutatedData[key]);
      }
      const data = await getTemplateData(payload, obj.url);
      return data;
    },
    async handleTableData({ commit, state, dispatch }, incomeData) {
      try {
        commit("SET_LOADING", true);
        const postDataMock = {
          horizons: "None",
          blocks: "None",
          row_on_page: 30,
          page_number: 1,
        };
        let merged = { ...postDataMock, ...incomeData };
        const url = state.currentTemplate.api_url ?? undefined;
        const data = await dispatch("getTableData", {
          mutatedData: merged,
          url,
        });
        commit("SET_CURRENT_TEMPLATE", state.currentTemplate);
        commit("SET_TABLE_FIELDS", data.header ?? data.data.columns_name);
        commit("SET_TABLE_ROWS", data.data.rows ?? data.data);
      } catch (error) {
        alert(error);
      } finally {
        commit("SET_LOADING", false);
      }
    },
    async handleTableGraphData({ commit, state, rootState }, dataToPost) {
      try {
        commit("SET_LOADING", true);
        const horizons = rootState.plastFluids.currentSubsoilHorizon;
        let horizonIDs, blockIDs;
        if (horizons.length)
          horizonIDs = horizons.map((horizon) => horizon.horizon_id);

        if (state.currentBlocks.length)
          blockIDs = state.currentBlocks.map((block) => block.block_id);

        const postDataMock = {
          horizons: horizons.length ? horizonIDs : "None",
          blocks: state.currentBlocks.length ? blockIDs : "None",
          vid_fluid: "None",
          data_start: "None",
          data_end: "None",
          graph_type: state.graphType,
        };
        let merged = { ...postDataMock, ...dataToPost };
        const postData = convertToFormData(merged);
        const data = await getTableGraphData(postData);
        commit("SET_TABLE_FIELDS", data[0].table_header);
        commit("SET_LOCAL_HORIZONS", data[1].filter_data);
        commit("SET_TABLE_ROWS", data.slice(2));
      } catch (error) {
        console.log(error);
      } finally {
        commit("SET_LOADING", false);
      }
    },
    handleBlocksFilter({ commit, state }, horizons) {
      const blocks = horizons.reduce((prev, horizon) => {
        let found = state.localHorizons.find(
          (lhorizon) => horizon.horizon_id === lhorizon.horizon_id
        );
        return found ? prev.concat(found.blocks) : prev;
      }, []);
      commit("SET_BLOCKS", blocks);
    },
  },
};

export default plastFluidsLocal;
