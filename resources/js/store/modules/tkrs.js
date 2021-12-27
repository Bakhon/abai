const tkrs = {
  namespaced: true,

  state: {
    table_work: null,
    wellFile: null,
    areaChartData: null,
    maximum: null,
    minimum: null,
    currentArchiveWellName: null,
  },

  mutations: {
    SET_TABLEWORK(state, val) {
      state.table_work = val;
    },
    SET_WELLFILE(state, val) {
      state.wellFile = val;
    },
    SET_AREACHARTDATA(state, val) {
      state.areaChartData = val;
    },
    SET_MAXIMUM(state, val) {
      state.maximum = val;
    },
    SET_MINIMUM(state, val) {
      state.minimum = val;
    },
    SET_CURRENTARCHIVEWELLNAME(state, val) {
      state.currentArchiveWellName = val;
    },

  },

  actions: {
    getTableWork({commit, state}, { well_name, well_date }) {
      axios
          .get(
            process.env.MIX_TKRS_POST_API_URL + `dayliWork1/${well_name}/${well_date}/`,
              
          )
          .then((response) => {
              let data = response.data;
              if (data) {
                commit("SET_TABLEWORK", data);

              } else {
                  console.log("No data");
              }
          });
    },
    getSelectedtWellFile({commit, state}, { well_name_chart, well_date_chart }) {
      commit('globalloading/SET_LOADING', true, { root: true })
        axios
            .get(
                `http://172.20.103.203:8090/chooseDate/${well_name_chart}/${well_date_chart}/`,
            )
            .then((response) => {
              commit('globalloading/SET_LOADING', false, { root: true })
                let data = response.data;
                if (data) {
                  commit("SET_WELLFILE", data);
                  commit("SET_AREACHARTDATA", data.data);
                  commit("SET_MAXIMUM", data.data[0].rangeSlider.max);
                  commit("SET_MINIMUM", data.data[0].rangeSlider.min);

                    
                } else {
                    console.log("No data");
                }
            });
    },
  },
};

export default tkrs;