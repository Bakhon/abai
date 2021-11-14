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
        reverse_gr_table: [],
        totalSelection: [],
        polygonWells: [],
        clustersList: []
    },
    getters: {
        chooseObjectDate: (state) => state.chooseObjectDate,
        graphicStartDate: (state) => state.graphicStartDate,
        kin: (state) => state.kin,
        graphicEndDate: (state) => state.graphicEndDate,
        wellList: (state) => state.wellList,
        reverse_gr_table: (state) => state.reverse_gr_table,
        totalSelection: (state) => state.totalSelection,
        polygonWells: (state) => state.polygonWells,
        clustersList: (state) => state.clustersList,
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
        TOTAL_SELECTION(state, value) {
            state.totalSelection = value;
        },
        SAVE_GR_TABLE(state, value) {
            state.gr_table = value;
        },
        SAVE_POLYGON_WELLS (state, value) {
            state.polygonWells = value;
        },
        SAVE_CLUSTERS_LIST (state, value) {
            state.clustersList = value;
        },
    },
    actions: {
        async getKin({dispatch, commit, state}, fieldObject){
            let url = process.env.MIX_WATERFLOODING_MANAGMENT + 'object_selections/kin/' + fieldObject + '/';
            axios.get(url)
                .then((response) =>{
                    commit('SAVE_KIN', response.data)
                }).catch((error) => {
                console.log(error)
            })
        },
        async getWellList({dispatch, commit}){
            let url = process.env.MIX_WATERFLOODING_MANAGMENT + 'object_selections/well-list/';
            axios.get(url)
                .then((response) =>{
                    commit('SAVE_WELL_LIST', response.data)
                }).catch((error) => {
                console.log(error)
            })
        },
        async getClustersList({dispatch, commit}) {
            let url = process.env.MIX_WATERFLOODING_MANAGMENT + 'utils/clusters-list/';
            axios.get(url)
                .then((response) =>{
                    commit('SAVE_CLUSTERS_LIST', response.data);
                }).catch((error) => {
                console.log(error)
            })
        },
        async getGrTable({dispatch, commit, state}){
            axios.get(process.env.MIX_WATERFLOODING_MANAGMENT + "object_selections/vault/")
                .then((response) =>{
                    commit('SAVE_GR_TABLE', response.data.data)
                    commit('SAVE_REVERSE_GR_TABLE', response.data.data)
                    return response.data.data
                }).catch((error) => {
                console.log(error)
            })
        },
        async getTotalSelection({dispatch, commit, state}){
            axios.get(process.env.MIX_WATERFLOODING_MANAGMENT + "object_selections/forecasting-graphic-list/")
                .then((response) =>{
                    commit('TOTAL_SELECTION', response.data);
                    return response.data;
                }).catch((error) => {
                console.log(error)
            })
        },
        changePolygonWells({commit}, value){
            commit('SAVE_POLYGON_WELLS', value)
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