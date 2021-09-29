const bidataWellLevel = {
    namespaced: true,

    state: {
        isInjectionWellsHistoricalVisible: false,
        isProductionWellsHistoricalVisible: false,
    },

    mutations: {
        SET_VISIBLE_INJECTION: (state, val) => {
            state.isInjectionWellsHistoricalVisible = val;
        },
        SET_VISIBLE_PRODUCTION: (state, val) => {
            state.isProductionWellsHistoricalVisible = val;
        },
    },
};

export default bidataWellLevel;
