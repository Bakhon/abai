import translation from "../../VueTranslation/Translation";

const plastFluidsLocal = {
  namespaced: true,

  state: {
    fileLog: null,
    reportDuplicated: false,
  },

  mutations: {
    SET_REPORT_DUPLICATED_STATUS(state, payload) {
      state.reportDuplicated = payload;
    },
    SET_FILE_LOG(state, payload) {
      state.fileLog = payload;
    },
  },

  actions: {
    HANDLE_FILE_LOG({ commit }, log) {
      let entries = [];
      for (let key in log) {
        let replacedKey = key.replace('sheet', translation.translate("plast_fluids.page"));
        entries.push([replacedKey, log[key]]);
      }
      commit("SET_FILE_LOG", entries);
    },
  },
};

export default plastFluidsLocal;
