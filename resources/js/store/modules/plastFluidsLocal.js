import translation from "../../VueTranslation/Translation";
import { getTemplateData } from "../../components/PlastFluids/services/templateService";
import { getTableGraphData } from "../../components/PlastFluids/services/graphService";

const plastFluidsLocal = {
  namespaced: true,

  state: {
    fileLog: null,
    reportDuplicated: false,
    tableFields: [],
    tableRows: [],
    currentTemplate: {},
    tableState: 'default',
    loading: false,
    graphType: "ps_bs_ds_ms",
  },

  mutations: {
    SET_FILE_LOG(state, payload) {
      state.fileLog = payload;
    },
    SET_REPORT_DUPLICATED_STATUS(state, payload) {
      state.reportDuplicated = payload;
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
  },

  actions: {
    HANDLE_FILE_LOG({ commit }, log) {
      let entries = [];
      for (let key in log) {
        let replacedKey = key.replace(
          "sheet",
          translation.translate("plast_fluids.page")
        );
        entries.push([replacedKey, log[key]]);
      }
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
    async handleTableGraphData({ commit, state }, dataToPost) {
      try {
        commit("SET_LOADING", true);
        const postDataMock = {
          horizons: "None",
          blocks: "None",
          vid_fluid: "None",
          data_start: "None",
          data_end: "None",
          graph_type: state.graphType,
        };
        let merged = { ...postDataMock, ...dataToPost };
        const postData = new FormData();
        for (let key in merged) {
          postData.append(key, merged[key]);
        }
        const data = await getTableGraphData(postData);
        commit("SET_TABLE_FIELDS", data[0].table_header);
        commit("SET_TABLE_ROWS", data.slice(2));
      } catch (error) {
        alert(error);
      } finally {
        commit("SET_LOADING", false);
      }
    },
  },
};

export default plastFluidsLocal;
