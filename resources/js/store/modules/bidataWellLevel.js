const bidataWellLevel = {
    namespaced: true,

    state: {
        isInjectionWellsHistoricalVisible: false,
        isProductionWellsHistoricalVisible: false,
        injectionHistoricalData: [],
        injectionMeasurementSchedule: [],
        productionMeasurementSchedule: [],
        productionHistoricalData: [],
    },

    mutations: {
        SET_VISIBLE_INJECTION: (state, val) => {
            state.isInjectionWellsHistoricalVisible = val;
        },
        SET_VISIBLE_PRODUCTION: (state, val) => {
            state.isProductionWellsHistoricalVisible = val;
        },
        SET_INJECTION_HISTORICAL(state, payload) {
            state.injectionHistoricalData = payload;
        },
        SET_PRODUCTION_HISTORICAL(state, payload) {
            state.productionHistoricalData = payload;
        },
        SET_INJECTION_HISTORICAL_PERIOD(state, payload) {
            state.injectionMeasurementSchedule = payload;
        },
        SET_PRODUCTION_HISTORICAL_PERIOD(state, payload) {
            state.productionMeasurementSchedule = payload;
        }
    },
};

export default bidataWellLevel;
