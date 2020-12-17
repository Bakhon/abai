const tr = {
  namespaced: true,

  state: {
    month: false,
    year: false,
  },

  mutations: {
    SET_MONTH: (state, val) => {
      state.month = val;
    },
    SET_YEAR: (state, val) => {
      state.year = val;
    },
  },

  actions: {
  },

  getters: {
    month: (state) => state.month,
    year: (state) => state.year,
  },
};

export default tr;
