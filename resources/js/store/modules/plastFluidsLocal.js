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
};

export default plastFluidsLocal;
