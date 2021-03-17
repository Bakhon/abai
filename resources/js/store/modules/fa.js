const fa = {
  namespaced: true,

  state: {
    month: false,
    year: false,
    prmonth: false,
    pryear: false,
    chart: 0,
    searchString: "",
    filter: "Все месторождения",
    sortType: "asc",
    sortParam: "",
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
    SET_CHART: (state, val) => {
      state.chart = val;
    },
    SET_SEARCH: (state, val) => {
      state.searchString = val;
    },
    SET_FILTER: (state, val) => {
      state.filter = val;
    },
    SET_SORTTYPE: (state, val) => {
      state.sortType = val;
    },
    SET_SORTPARAM: (state, val) => {
      state.sortParam = val;
    },
  },

  actions: {
  },

  getters: {
    month: (state) => state.month,
    year: (state) => state.year,
    prmonth: (state) => state.prmonth,
    pryear: (state) => state.pryear,
    chart: (state) => state.chart,
    searchString: (state) => state.searchString,
    filter: (state) => state.filter,
    sortType: (state) => state.sortType,
    sortParam: (state) => state.sortParam,
  },
};

export default fa;
