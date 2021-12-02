import translation from "../../VueTranslation/Translation";
import {
  getTemplateData,
  getUploadTemplates,
} from "../../components/PlastFluids/services/templateService";
import { getTableData } from "../../components/PlastFluids/services/mapService";
import {
  convertToFormData,
  convertTemplateData,
} from "../../components/PlastFluids/helpers";

const plastFluidsLocal = {
  namespaced: true,

  state: {
    fileLog: null,
    reportDuplicated: false,
    downloadFileData: {},
    tableFields: [],
    tableRows: [],
    templates: [],
    currentTemplate: {},
    tableState: "default",
    loading: false,
    graphType: "ps_bs_ds_ms",
    currentGraphics: ["Ps", "Bs", "Ds", "Ms"],
    localHorizons: [],
    blocks: [],
    currentBlocks: [],
    currentSelectedCorrelation_ps: "",
    currentSelectedCorrelation_bs: "",
    currentSelectedCorrelation_ms: "",
    currentSelectedSamples: [],
    models: [],
    currentModel: {},
    depthMultiplier: 5,
    maxDepthMultiplier: 0,
    isIsohypsShown: true,
    isTileLayerShown: true,
    selectedWellsType: [],
    selectedFluidProperty: [],
    currentSelectedWell: {},
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
    SET_TEMPLATES(state, payload) {
      state.templates = payload;
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
    SET_CURRENT_GRAPHICS(state, payload) {
      state.currentGraphics = payload;
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
    SET_MODELS(state, payload) {
      state.models = payload;
    },
    SET_CURRENT_MODEL(state, payload) {
      state.currentModel = payload;
    },
    SET_DEPTH_MULTIPLIER(state, payload) {
      state.depthMultiplier = payload;
    },
    SET_MAX_DEPTH_MULTIPLIER(state, payload) {
      state.maxDepthMultiplier = payload;
    },
    SET_IS_ISOHYPS_SHOWN(state, payload) {
      state.isIsohypsShown = payload;
    },
    SET_IS_TILE_LAYER_SHOWN(state, payload) {
      state.isTileLayerShown = payload;
    },
    SET_SELECTED_WELLS_TYPE(state, payload) {
      state.selectedWellsType = payload;
    },
    SET_SELECTED_FLUID_PROPERTY(state, payload) {
      const last = payload.pop();
      state.selectedFluidProperty = [];
      last ? state.selectedFluidProperty.push(last) : "";
    },
    SET_CURRENT_SELECTED_WELL(state, payload) {
      if (
        state.currentSelectedWell.id === payload.id &&
        state.currentSelectedWell.index === payload.index
      ) {
        state.currentSelectedWell = {};
        return;
      }
      state.currentSelectedWell = payload;
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
    async getTableData({}, postData) {
      const payload = new FormData();
      for (let key in postData) {
        payload.append(key, postData[key]);
      }
      const data = await getTemplateData(payload);
      return data;
    },
    async getTemplates({ state, commit }, payload) {
      const postData = new FormData();
      postData.append("user_id", payload.userID);
      const data = await getUploadTemplates(postData);
      commit("SET_TEMPLATES", convertTemplateData(data, payload.lang));
      const template = data.find(
        (template) => template.id === payload.templateID
      );
      commit("SET_CURRENT_TEMPLATE", template);
    },
    async handleTableData({ commit, dispatch }, incomeData) {
      try {
        const { template, ...rest } = incomeData;
        commit("SET_LOADING", true);
        const postDataMock = {
          horizons: "None",
          blocks: "None",
          row_on_page: 30,
          page_number: 1,
          report_id: 1,
        };
        let merged = { ...postDataMock, ...rest };
        const data = await dispatch("getTableData", merged);
        template ? commit("SET_CURRENT_TEMPLATE", template) : "";
        commit("SET_TABLE_FIELDS", data.header[0]);
        commit("SET_TABLE_ROWS", data.table.rows);
      } catch (error) {
        alert(error);
      } finally {
        commit("SET_LOADING", false);
      }
    },
    async handleAnalysisTableData({ commit, state, rootState }, dataToPost) {
      const { postUrl, ...rest } = dataToPost;
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
        let merged = { ...postDataMock, ...rest };
        const postData = convertToFormData(merged);
        const data = await getTableData(postData, postUrl);
        commit(
          "SET_TABLE_FIELDS",
          Array.isArray(data) ? data[0].table_header : data.header
        );
        commit(
          "SET_LOCAL_HORIZONS",
          Array.isArray(data) ? data[1].filter_data : data.filter_data
        );
        commit(
          "SET_TABLE_ROWS",
          Array.isArray(data) ? data.slice(2) : data.table
        );
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
