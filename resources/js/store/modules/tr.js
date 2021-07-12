const tr = {
  namespaced: true,

  state: {
    month: false,
    year: false,
    chart: 0,
    searchString: "",
    filter: "Все месторождения",
    isSortType: "true",
    sortParam: "",
    year_dyn_start: false,
    year_dyn_end: false,
    month_dyn_start: false,
    month_dyn_end: false,
    day_dyn_start: false,
    day_dyn_end: false,
    isDynamic: "false",
    field: [],
    horizon: [],
    wellType: [],
    object: [],
    block: [],
    expMeth: [],
    pageNumber: 1,
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
    SET_SEARCH: (state, val) => {
      state.searchString = val;
    },
    SET_FILTER: (state, val) => {
      state.filter = val;
    },
    SET_SORTTYPE: (state, val) => {
      state.isSortType = val;
    },
    SET_SORTPARAM: (state, val) => {
      state.sortParam = val;
    },  
    SET_DYN_YEAR_START: (state, val) => {
      state.year_dyn_start = val;
    },
    SET_DYN_YEAR_END: (state, val) => {
      state.year_dyn_end = val;
    },
    SET_DYN_MONTH_START: (state, val) => {
      state.month_dyn_start = val;
    },
    SET_DYN_MONTH_END: (state, val) => {
      state.month_dyn_end = val;
    },
    SET_DYN_DAY_START: (state, val) => {
      state.day_dyn_start = val;
    },
    SET_DYN_DAY_END: (state, val) => {
      state.day_dyn_end = val;
    },
    SET_IS_DYNAMIC: (state, val) => {
      state.isDynamic = val;
    },
    SET_FIELD: (state, val) => {
      state.field = val;
    },   
    SET_HORIZON: (state, val) => {
      state.horizon = val;
    },  
    SET_WELLTYPE: (state, val) => {
      state.wellType = val;
    },  
    SET_OBJECT: (state, val) => {
      state.object = val;
    },
    SET_BLOCK: (state, val) => {
      state.block = val;
    },
    SET_EXPMETH: (state, val) => {
      state.expMeth = val;
    },
    SET_PAGENUMBER: (state, val) => {
      state.pageNumber = val;
    }, 
  },

  actions: {
  },

  getters: {
    month: (state) => state.month,
    year: (state) => state.year,
    chart: (state) => state.chart,
    searchString: (state) => state.searchString,
    filter: (state) => state.filter,
    isSortType: (state) => state.isSortType,
    sortParam: (state) => state.sortParam,
    year_dyn_start: (state) => state.year_dyn_start,
    year_dyn_end: (state) => state.year_dyn_end,
    month_dyn_start: (state) => state.month_dyn_start,
    month_dyn_end: (state) => state.month_dyn_end,
    day_dyn_start: (state) => state.day_dyn_start,
    day_dyn_end: (state) => state.day_dyn_end,
    isDynamic: (state) => state.isDynamic,
    field: (state) => state.field,
    horizon: (state) => state.horizon,
    wellType: (state) => state.wellType,
    object: (state) => state.object,
    block: (state) => state.block,
    expMeth: (state) => state.expMeth,
    pageNumber: (state) => state.pageNumber,
  },
};

export default tr;