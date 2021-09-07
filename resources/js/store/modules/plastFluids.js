const plastFluids = {
  namespaced: true,

  state: {
    pickedSubsoilChildRadio: "",
    pickedSubsoil: [],
    currentSubsoilChildren: [],
  },

  mutations: {
    SET_PICKED_SUBSOIL_CHILD_RADIO(state, payload) {
      state.pickedSubsoilChildRadio = payload;
    },
    SET_PICKED_SUBSOIL(state, payload) {
      state.pickedSubsoil = [];
      state.pickedSubsoil = [payload];
    },
    SET_CURRENT_SUBSOIL_CHILDREN(state, payload) {
      state.currentSubsoilChildren = payload;
    },
  },
};

export default plastFluids;
