const bidataWellLevel = {
    namespaced: true,

    state: {
        isHistoricalVisible: false,
    },

    mutations: {
        SET_VISIBLE: (state, val) => {
            state.isHistoricalVisible = val;
        },
    },
};

export default bidataWellLevel;
