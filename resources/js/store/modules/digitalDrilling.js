const digitalDrilling = {
    namespaced: true,
    state: {
        currentWell: {},
        currentUser: {},
    },
    mutations: {
        CHANGE_CURRENT_WELL (state, value) {
            state.currentWell = value;
        },
        CHANGE_CURRENT_USER (state, value) {
            state.currentUser = value;
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
    }
};

export default digitalDrilling;
