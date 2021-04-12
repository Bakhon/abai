import axios from 'axios'

const complicationMonitoring = {
    namespaced: true,

    state: {
        zus: [],
        gus: [],
        ngdus: [],
        cdngs: [],
        wells: [],
    },

    mutations: {
        SET_ZUS(state, payload) {
            state.zus = payload;
        },
        SET_GUS(state, payload) {
            state.gus = payload;
        },
        SET_NGDUS(state, payload) {
            state.ngdus = payload;
        },
        SET_CDNGS(state, payload) {
            state.cdngs = payload;
        },
        SET_WELLS(state, payload) {
            state.wells = payload;
        },

    },

    actions: {
        async getAllComplicationMonitoringData({dispatch}) {
            dispatch('getAllNgdus')
            dispatch('getAllGus');
            dispatch('getAllCdngs')
            dispatch('getAllZus')
            dispatch('getAllWells');
        },

        getAllNgdus({commit}) {
            return axios.get(this._vm.localeUrl("/getallngdu")).then((response) => {
                let ngdus = response.data.data;
                commit('SET_NGDUS', ngdus);
            });
        },

        getAllGus({commit}) {
            return axios.get(this._vm.localeUrl("/getallgus")).then((response) => {
                let gus = response.data.data;
                commit('SET_GUS', gus);
            });
        },

        getAllCdngs({commit}) {
            return axios.get(this._vm.localeUrl("/getallcdng")).then((response) => {
                let cdng = response.data.data;
                commit('SET_CDNGS', cdng);
            });
        },

        getAllZus({commit}) {
            return axios.get(this._vm.localeUrl("/getallzu")).then((response) => {
                let zus = response.data.data;
                commit('SET_ZUS', zus);
            });
        },

        getAllWells({commit}) {
            return axios.get(this._vm.localeUrl("/getallwell")).then((response) => {
                let wells = response.data.data;
                commit('SET_WELLS', wells);
            });
        },

        getGuRelations ({commit}, gu_id) {
            return axios.post(this._vm.localeUrl("/get_gu_relations"), {gu_id: gu_id}).then((response) => {
                console.log(response);
                let wells = response.data.data.wells;
                let zus = response.data.data.zus;
                commit('SET_WELLS', wells);
                commit('SET_ZUS', zus);
                return response.data.data;
            });
        }
    },

    getters: {},
};

export default complicationMonitoring;

