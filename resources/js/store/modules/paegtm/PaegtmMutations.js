export const paegtmMutations = {
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
    CHANGE_DATE_RANGE (state, value) {
        state.dateRange = value
    },
    CHANGE_DZO_ID (state, value) {
        state.dzoId = value;
    },
    CHANGE_DZO_NAME (state, value) {
        state.dzoName = value;
    },
    CHANGE_CLICKABLE (state, value) {
        console.log('in state')
        state.clickable = value
    }
}