import translation from "../../VueTranslation/Translation";
import { getTemplateData } from "../../components/PlastFluids/services/templateService";

const plastFluidsLocal = {
  namespaced: true,

  state: {
    fileLog: null,
    reportDuplicated: false,
    tableFields: [],
    tableRows: [],
    currentTemplate: {},
  },

  mutations: {
    SET_REPORT_DUPLICATED_STATUS(state, payload) {
      state.reportDuplicated = payload;
    },
    SET_FILE_LOG(state, payload) {
      state.fileLog = payload;
    },
    SET_CURRENT_TEMPLATE(state, payload) {
      state.currentTemplate = payload;
    },
    SET_TABLE_FIELDS(state, payload) {
      state.tableFields = payload;
    },
    SET_TABLE_ROWS(state, payload) {
      state.tableRows = payload;
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
    async getTableData({}, { fieldId, url }) {
      const payload = new FormData();
      payload.append("field_id", fieldId);
      const data = await getTemplateData(payload, url);
      return data;
    },
    async handleTableData({ commit, state, dispatch }, fieldId) {
      const url = state.currentTemplate.api_url ?? undefined;
      const data = await dispatch("getTableData", { fieldId, url });
      commit("SET_CURRENT_TEMPLATE", state.currentTemplate);
      commit("SET_TABLE_FIELDS", data.columns_name);
      commit("SET_TABLE_ROWS", data.rows);
    },
  },
};

export default plastFluidsLocal;
