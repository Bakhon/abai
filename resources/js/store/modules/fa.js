const fa = {
  namespaced: true,

  state: {
    month: false,
    year: false,
    day:false,
    prday:false,
    prmonth: false,
    pryear: false,
    chart: 0,
    searchString: "",
    filter: "Все месторождения",
    sortType: "asc",
    sortParam: "",
    isDynamic: true,
    colsize7 : 0,
    colsize2 : 0,
    isGenHide : false,
  },

  mutations: {
    SET_MONTH: (state, val) => {
      state.month = val;
    },
    SET_YEAR: (state, val) => {
      state.year = val;
    },
    SET_DAY: (state, val) => {
      state.day = val;
    },
    SET_PR_DAY: (state, val) => {
      state.prday = val;
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
    SET_IS_DYNAMIC: (state, val) => {
      state.isDynamic = val;
    },
    SET_COLSIZE7: (state, val) => {
      state.colsize7 = val;
    },
    SET_COLSIZE2: (state, val) => {
      state.colsize2 = val;
    },
    SET_GEN_HIDE: (state, val) => {
      state.isGenHide = val;
    },
  },

  actions: {
  },

  getters: {
    month: (state) => state.month,
    year: (state) => state.year,
    day: (state) => state.day,
    prday: (state) => state.prday,
    prmonth: (state) => state.prmonth,
    pryear: (state) => state.pryear,
    chart: (state) => state.chart,
    searchString: (state) => state.searchString,
    filter: (state) => state.filter,
    sortType: (state) => state.sortType,
    sortParam: (state) => state.sortParam,
    isDynamic: (state) => state.isDynamic,
    colsize7: (state) => state.colsize7,
    colsize2: (state) => state.colsize2,
    isGenHide: (state) => state.isGenHide,   
  },
};

export default fa;
