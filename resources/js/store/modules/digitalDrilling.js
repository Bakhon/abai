const digitalDrilling = {
    namespaced: true,
    state: {
        currentWell: [],
        currentPage: {},
    },
    mutations: {
        CHANGE_CURRENT_WELL (state, value) {
            state.currentWell.push(value);
        },
        CHANGE_CURRENT_PAGE (state, value) {
            state.currentPage = value;
        },
    },
    getters: {
    },
    actions: {
        changeCurrentWellValue({commit}, value) {
            commit('CHANGE_CURRENT_WELL', value);
        },
        changeCurrentPageValue({commit}, value) {
            commit('CHANGE_CURRENT_PAGE', value);
        },
    }
};

export default digitalDrilling;
