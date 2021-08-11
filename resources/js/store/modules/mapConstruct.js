
const mapConstruct = {
  namespaced: true,
  state: {
    pieCharts: [],
    loader: false
  },
  mutations: {
    SAVE_MY_DATA (state, value) {
      state.pieCharts = value;
    },
    SET_LOADER(state, loader = null) {
      state.loader = loader;
    }
  },
  getters: {
    isMyData: (state) => state.pieCharts,
    getLoader: state => state.loader

  },
  actions: {
    async getMapData({dispatch, commit}) {
      return await fetch('https://abai.dashboard/img/map-constructor/data.json').then(response => {
        response.json().then(res => {
          commit('SAVE_MY_DATA', res.data);
          return res.data;
        });
      });
    },
    setLoader({commit}, loader = null) {
      commit('SET_LOADER', loader);

    },
  },

};

export default mapConstruct;
