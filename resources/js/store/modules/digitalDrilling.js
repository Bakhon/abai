const digitalDrilling = {
    namespaced: true,
    state: {
        currentWell: {},
        currentUser: {},
        userCanDelete: false,
    },
    mutations: {
        CHANGE_CURRENT_WELL (state, value) {
            state.currentWell = value;
        },
        CHANGE_CURRENT_USER (state, value) {
            state.currentUser = value;
        },
        CHANGE_USER_ACCESS (state, value) {
            state.userCanDelete = value;
        },
    },
    getters: {
    },
    actions: {
        changeCurrentWellValue({commit}, value) {
            commit('CHANGE_CURRENT_WELL', value);
        },
        changeCurrentUserValue({commit}, value) {
            commit('CHANGE_CURRENT_USER', value);
        },
        changeCurrentUserAccess({commit}, value) {
            commit('CHANGE_USER_ACCESS', value);
        },
    }
};

export default digitalDrilling;
