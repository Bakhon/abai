const tr = {
  namespaced: true,

  state: {
    month: false,
    year: false,
    chart: 0,
  },

  mutations: {
    SET_MONTH: (state, val) => {
      state.month = val;
    },
    SET_YEAR: (state, val) => {
      state.year = val;
    },
    SET_CHART: (state, val) => {
      state.chart = val;
    },
  },

  actions: {
  },

  getters: {
    month: (state) => state.month,
    year: (state) => state.year,
    chart: (state) => state.chart,
  },
};

export default tr;
