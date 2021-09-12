import axios from "axios";

const waterfloodingManagement = {
    namespaced: true,
    state: {
        kin: [],
        chooseObjectDate: new Date(),
        graphicStartDate: new Date(),
        graphicEndDate: new Date(),
        objectDate: new Date('2020-12-31T23:59:59+00:00'),
    },
    getters: {
        chooseObjectDate: (state) => state.chooseObjectDate,
        graphicStartDate: (state) => state.graphicStartDate,
        kin: (state) => state.kin,
        graphicEndDate: (state) => state.graphicEndDate,
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