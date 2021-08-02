const paegtmMap = {
  namespaced: true,
  state: {
    isShadowBlockShow: false,
    treeChildrenComponent: Object,
    treeSettingComponent: Object,
    isTreeMainComponentShow: true,
    dateStart: new Date('2020-01-01T00:00:00+00:00'),
    dateEnd: new Date('2020-12-31T23:59:59+00:00'),
    dzoId: 112
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
      // this.state.dateStart = value;
      state.dateStart = value;
    },
    CHANGE_DATE_END (state, value) {
      // this.state.dateEnd = value;
      state.dateEnd = value;
    },
    CHANGE_DZO_ID (state, value) {
      state.dzoId = value;
    }
  },
  getters: {
    isShadowBlockShow: (state) => state.isShadowBlockShow,
    dateStart: (state) => state.dateStart,
    dateEnd: (state) => state.dateEnd,
    dzoId: (state) => state.dzoId,
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
    changeDzoId ({commit}, value) {
      commit('CHANGE_DZO_ID', value);
    }
  }
};

export default paegtmMap;
