const globalloading = {
  namespaced: true,

  state: {
    loading: false,
  },

  mutations: {
    SET_LOADING: (state, val) => {
      state.loading = val;
    },
  },
};

export default globalloading;
