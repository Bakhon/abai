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

  actions: {
    setLoading: ({commit}, val) => {
      commit('SET_LOADING', val)
    },
  },
};

export default globalloading;
