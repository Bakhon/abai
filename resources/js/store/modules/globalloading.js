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
};

export default globalloading;
