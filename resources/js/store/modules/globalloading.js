const globalloading = {
  namespaced: true,

  state: {
    loading: true,
  },

  mutations: {
    SET_LOADING: (state, val) => {
      state.loading = val;
    },
  },

  actions: {
  },

  getters: {
    loading: (state) => state.loading,
  },
};

export default globalloading;
