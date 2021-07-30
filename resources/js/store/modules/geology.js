import {
    SET_TOGGLE_RIGHT_SIDE,
    SET_TOGGLE_LEFT_SIDE
} from "./geology.const";

const geology = {
    namespaced: true,
    state: {
        isOpenedRightSide: true,
        isOpenedLeftSide: true,
    },
    mutations: {
        [SET_TOGGLE_RIGHT_SIDE]: (state, payload) => state.isOpenedRightSide = payload !== 'toggle' ? payload : !state.isOpenedRightSide,
        [SET_TOGGLE_LEFT_SIDE]: (state, payload) => state.isOpenedLeftSide = payload !== 'toggle' ? payload : !state.isOpenedLeftSide
    }
}


export default geology;
