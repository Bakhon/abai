import axios from "axios";

export const paegtmActions = {
    changeDisplayShadowBlock({commit}, value) {
        commit('CHANGE_DISPLAY_SHADOW_BLOCK', value);
    },
    changeDisplayMainComponent({commit}, value) {
        commit('CHANGE_DISPLAY_MAIN_COMPONENT', value);
    },
    changeTreeSettingComponent({commit}, value) {
        commit('CHANGE_TREE_SETTINGS_COMPONENT', value);
        if (value) {
            commit('CHANGE_DISPLAY_MAIN_COMPONENT', true);
        }
    },
    changeTreeChildrenComponent({commit}, value) {
        commit('CHANGE_TREE_CHILDREN_COMPONENT', value);
    },
    changeDateStart({commit}, value) {
        commit('CHANGE_DATE_START', value);
    },
    changeDateEnd({commit}, value) {
        commit('CHANGE_DATE_END', value);
    },
    changeDateRange({commit}, value) {
        commit('CHANGE_DATE_RANGE', value)
    },
    changeTreeDate({commit}, value) {
        commit('CHANGE_TREE_DATE', value)
    },
    changeDzoId({commit}, value) {
        commit('CHANGE_DZO_ID', value);
    },
    changeDzoName({commit}, value) {
        commit('CHANGE_DZO_NAME', value);
    },
    changeClickable({commit}, value) {
        commit('CHANGE_CLICKABLE', value)
    },
    async onGetTableByClickableValue({commit}, payload) {
        return axios.post(payload.url, payload.body).then((res) => {
            let data = res.data
            commit("CHANGE_CLICKABLE_TABLE", data['main_data'])
        }).catch((error) => {
            console.log(error)
        })
    }
}