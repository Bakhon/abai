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
    wellName: [],
    plannedEvents: [],
    pageNumber: 1,
    isFullVersion: false,
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
    SET_WELLNAME: (state, val) => {
      state.wellName = val;
    }, 
    SET_VERSION: (state, val) => {
      state.isFullVersion = val;
    },
    SET_EVENT: (state, val) => {
      state.plannedEvents = val;
    },  },

  actions: {
  },

};

export default tr;