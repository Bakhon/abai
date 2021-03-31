const paegtm = {
  state: {
    isShadowBlockShow: false,
    treeChildrenComponent: Object,
    treeSettingComponent: Object,
  },
  mutations: {
    changeIsShadowBlockShow (state, value) {
      this.state.isShadowBlockShow = value;
    },
    changeTreeSettingComponent (state, value) {
      this.state.treeSettingComponent = value;
    },
    changeTreeChildrenComponent (state, value) {
      this.state.treeChildrenComponent = value;
    },
  },
  getters: {
    isShadowBlockShow: (state) => state.isShadowBlockShow,
  },
};

export default paegtm;
