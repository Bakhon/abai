import axios from "axios";

const waterfloodingManagement = {
    namespaced: true,
    state: {
        kin: [],
        chooseObjectDate: new Date(),
        graphicStartDate: new Date(),
        graphicEndDate: new Date(),
        objectDate: new Date('2020-12-31T23:59:59+00:00'),
        wellList: [],
    },
    getters: {
        chooseObjectDate: (state) => state.chooseObjectDate,
        graphicStartDate: (state) => state.graphicStartDate,
        kin: (state) => state.kin,
        graphicEndDate: (state) => state.graphicEndDate,
        wellList: (state) => state.wellList,
    },
    mutations:{
        CHANGE_CHOOSE_OBJECT_DATE(state, value) {
            state.chooseObjectDate = value;
        },
        CHANGE_GRAPHIC_START_DATE(state, value) {
            state.graphicStartDate = value;
        },
        CHANGE_GRAPHIC_END_DATE(state, value) {
            state.graphicEndDate = value;
        },
        SAVE_KIN(state, value) {
            state.kin = value;
        },
        SAVE_WELL_LIST (state, value) {
            state.wellList = value;
        },
    },
    actions: {
        async getKin({dispatch, commit, state}, fieldObject){
            let url =process.env.MIX_WATERFLOODING_MANAGMENT + 'object_selections/kin/' + fieldObject + '/';
            axios.get(url)
                .then((response) =>{
                    commit('SAVE_KIN', response.data)
                }).catch((error) => {
                console.log(error)
            })
        },
        async getWellList({dispatch, commit}){
            let url = 'http://127.0.0.1:8001/api/v1/object_selections/well-list/';
            axios.get(url)
                .then((response) =>{
                    commit('SAVE_WELL_LIST', response.data)
                }).catch((error) => {
                console.log(error)
            })
        },
        changeChooseObjectDate ({commit}, value) {
            commit('CHANGE_CHOOSE_OBJECT_DATE', value);
        },
        changeGraphicStartDate ({commit}, value) {
            commit('CHANGE_GRAPHIC_START_DATE', value);
        },
        changeGraphicEndDate ({commit}, value) {
            commit('CHANGE_GRAPHIC_END_DATE', value);
        },
    }
}

export default waterfloodingManagement