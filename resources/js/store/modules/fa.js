const fa = {
  namespaced: true,

  state: {
    month: false,
    year: false,
    prmonth: false,
    pryear: false,
  },

  mutations: {
    SET_MONTH: (state, val) => {
      state.month = val;
    },
    SET_YEAR: (state, val) => {
      state.year = val;
    },
    SET_PR_MONTH: (state, val) => {
      state.prmonth = val;
    },
    SET_PR_YEAR: (state, val) => {
      state.pryear = val;
    },
  },

  actions: {
  },

  getters: {
    month: (state) => state.month,
    year: (state) => state.year,
    prmonth: (state) => state.prmonth,
    pryear: (state) => state.pryear,
  },
};

export default fa;
