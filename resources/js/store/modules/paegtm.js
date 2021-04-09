const paegtm = {
  state: {
    isShadowBlockShow: false,
    treeChildrenComponent: Object,
    treeSettingComponent: Object,
    isTreeMainComponentShow: true,
  },
  mutations: {
    changeTheDisplayShadowBlock (state, value) {
      this.state.isShadowBlockShow = value;
    },
    changeTreeSettingComponent (state, value) {
      this.state.treeSettingComponent = value;
      if (value) {
        this.state.isTreeMainComponentShow = true;
      }
    },
    changeTreeChildrenComponent (state, value) {
      this.state.treeChildrenComponent = value;
    },
    changeTheDisplayMainComponent (state, value) {
      this.state.isTreeMainComponentShow = value;
    },
  },
  getters: {
    isShadowBlockShow: (state) => state.isShadowBlockShow,
  },
};

export default paegtm;
