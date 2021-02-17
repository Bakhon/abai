const bd = {
  namespaced: true,

  state: {
    dicts: {},
  },

  mutations: {
    SAVE_DICT: (state, val) => {
      state.dicts[val.code] = val.items;
    },
  },

  getters: {
    dict: (state) => code => state.dicts[code]
  },
};

export default bd;
