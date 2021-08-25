const digitalDrilling = {
    namespaced: true,
    state: {
        currentWell: {},
    },
    mutations: {
        CHANGE_CURRENT_WELL (state, value) {
            state.currentWell = value;
        },
    },
    getters: {
    },
    actions: {
        changeCurrentWellValue({commit}, value) {
            commit('CHANGE_CURRENT_WELL', value);
        },
    }
};

export default digitalDrilling;