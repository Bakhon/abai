const paegtmMap = {
  namespaced: true,
  state: {
    isShadowBlockShow: false,
    treeChildrenComponent: Object,
    treeSettingComponent: Object,
    isTreeMainComponentShow: true,
    dateStart: null,
    dateEnd: null,
  },
  mutations: {
    CHANGE_DISPLAY_SHADOW_BLOCK (state, value) {
      this.state.isShadowBlockShow = value;
    },
    CHANGE_TREE_SETTINGS_COMPONENT (state, value) {
      this.state.treeSettingComponent = value;
    },
    CHANGE_TREE_CHILDREN_COMPONENT (state, value) {
      this.state.treeChildrenComponent = value;
    },
    CHANGE_DISPLAY_MAIN_COMPONENT (state, value) {
      this.state.isTreeMainComponentShow = value;
    },
    CHANGE_DATE_START (state, value) {
      state.dateStart = value;
    },
    CHANGE_DATE_END (state, value) {
      state.dateEnd = value;
    },
  },
  getters: {
    isShadowBlockShow: (state) => state.isShadowBlockShow,
    dateStart: (state) => state.dateStart,
    dateEnd: (state) => state.dateEnd,
  },
  actions: {
    changeDisplayShadowBlock({commit}, value) {
      commit('CHANGE_DISPLAY_SHADOW_BLOCK', value);
    },
    changeDisplayMainComponent ({commit}, value) {
      commit('CHANGE_DISPLAY_MAIN_COMPONENT', value);
    },
    changeTreeSettingComponent ({commit}, value) {
      commit('CHANGE_TREE_SETTINGS_COMPONENT', value);
      if (value) {
        commit('CHANGE_DISPLAY_MAIN_COMPONENT', true);
      }
    },
    changeTreeChildrenComponent ({commit}, value) {
      commit('CHANGE_TREE_CHILDREN_COMPONENT', value);
    },
    changeDateStart ({commit}, value) {
      commit('CHANGE_DATE_START', value);
    },
    changeDateEnd ({commit}, value) {
      commit('CHANGE_DATE_END', value);
    },
  }
};

export default paegtmMap;
