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
        clustersList: [],
        polygonFeatures: [],
        choosePolygons: null,
        chooseModelPrediction: null,
        optimizationTask: null,
        polygonList: [],
        LastSeries: [],
        chooseObject: null,
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
        polygonFeatures: (state) => state.polygonFeatures,
        choosePolygons: (state) => state.choosePolygons,
        chooseModelPrediction: (state) => state.chooseModelPrediction,
        optimizationTask: (state) => state.optimizationTask,
        polygonList: (state) => state.polygonList,
        LastSeries: (state) => state.LastSeries,
        chooseObject: (state) => state.chooseObject,
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
        SAVE_POLYGON_FEATURES (state, value) {
            state.polygonFeatures = value;
        },
        SAVE_CHOOSE_POLYGONS (state, value) {
            state.choosePolygons = value;
        },
        CHANGE_MODEL_PREDICTION (state, value) {
            state.chooseModelPrediction = value;
        },
        CHANGE_OPTIMIZATION_TASK (state, value) {
            state.optimizationTask = value;
        },
        CHANGE_POLYGON_LIST (state, value) {
            state.polygonList = value;
        },
        SAVE_LAST_SERIES (state, value) {
            state.LastSeries = value;
        },
        CHANGE_CHOOSE_OBJECT (state, value) {
            state.chooseObject = value;
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
        async getLastSeries({dispatch, commit}){
            let url = process.env.MIX_WATERFLOODING_MANAGMENT + 'object_selections/excepted-output/'
            await axios.get(url)
                .then((response) =>{
                    commit('SAVE_LAST_SERIES', response.data)
                }).catch((error) => {
                    console.log(error)
                });
        },
        changeChoosePolygons({commit}, value){
            commit('SAVE_CHOOSE_POLYGONS', value);
        },
        changeChooseModelPrediction ({commit}, value) {
            commit('CHANGE_MODEL_PREDICTION', value);
        },
        changeOptimizationTask ({commit}, value) {
            commit('CHANGE_OPTIMIZATION_TASK', value);
        },
        changePolygonWells({commit}, value){
            commit('SAVE_POLYGON_WELLS', value)
        },
        changePolygonFeatures({commit}, value){
            commit('SAVE_POLYGON_FEATURES', value)
        },
        changeChooseObjectDate ({commit}, value) {
            commit('CHANGE_CHOOSE_OBJECT_DATE', value);
        },
        changeGraphicStartDate ({commit}, value) {
            commit('CHANGE_GRAPHIC_START_DATE', value);
        },
        changeChooseObject ({commit}, value) {
            commit('CHANGE_CHOOSE_OBJECT', value);
        },
        changeGraphicEndDate ({commit}, value) {
            commit('CHANGE_GRAPHIC_END_DATE', value);
        },
        changePolygonList ({commit}, value) {
            commit('CHANGE_POLYGON_LIST', value);
        },
    }
}

export default waterfloodingManagement