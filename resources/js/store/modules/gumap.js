import axios from 'axios'

const gumap = {
    namespaced: true,

    state: {
        pipes: [],
        zuPoints: [],
        wellPoints: [],
        guPoints: [],
        guCenters: [],
        guPointsIndexes: [],
        mapCenter: {},
        pipeLayerId: 1
    },

    mutations: {
        SET_PIPES(state, payload) {
            state.pipes = payload;
        },
        SET_ZU_POINTS(state, payload) {
            state.zuPoints = payload;
        },
        SET_WELL_POINTS(state, payload) {
            state.wellPoints = payload;
        },
        SET_GU_POINTS(state, payload) {
            state.guPoints = payload;
        },
        SET_GU_CENTERS(state, payload) {
            state.guCenters = payload;
        },
        SET_GU_POINT_INDEX(state, payload) {
            state.guPointsIndexes[payload.index] = payload.id;
        },
        SET_MAP_CENTER(state, value) {
            state.mapCenter = value;
        },
        ADD_GU_POINT(state, guPoint) {
            state.guPoints.push(guPoint);
        },
        ADD_WELL_POINT(state, wellPoint) {
            state.wellPoints.push(wellPoint);
        },
        ADD_ZU_POINT(state, zuPoint) {
            state.zuPoints.push(zuPoint);
        },
        ADD_PIPE(state, pipe) {
            state.pipes.push(pipe);
        },
        ADD_GU_POINT_INDEX(state, id) {
            state.guPointsIndexes.push(id);
        },
        INCREASE_PIPE_LAYER_ID(state) {
            state.pipeLayerId++;
        }
    },

    actions: {
        async getPipes({dispatch, commit}, gu) {
            await axios.get(this._vm.localeUrl("/gu-map/pipes"), {params: {gu: gu}}).then((response) => {
                commit('SET_PIPES', response.data.pipes);
                commit('SET_ZU_POINTS', response.data.zuPoints);
                commit('SET_WELL_POINTS', response.data.wellPoints);
                commit('SET_GU_POINTS', response.data.guPoints);
                commit('SET_GU_CENTERS', response.data.guCenters);
                commit('SET_MAP_CENTER', {
                    latitude: response.data.center[1],
                    longitude: response.data.center[0]
                });
                dispatch('indexingGuPoints');
            })
        },

        indexingGuPoints({state, commit}) {
            state.guPoints.forEach((gu, index) => {
                commit('SET_GU_POINT_INDEX', {index: index, id: gu.id});
            });
        },

        storeGu({state, commit}, objectData) {
            return axios.post(this._vm.localeUrl("/gu-map/storegu"), {gu: objectData}).then((response) => {
                if (response.data.status == 'success') {
                    commit('ADD_GU_POINT', response.data.gu);
                    commit('ADD_GU_POINT_INDEX', response.data.gu.id);
                    return response.data.gu;
                } else {
                    console.log('error save Gu in DB');
                }
            });
        },

        storeZu({state, commit}, objectData) {
            return axios.post(this._vm.localeUrl("/gu-map/storezu"), {zu: objectData}).then((response) => {
                if (response.data.status == 'success') {
                    commit('ADD_ZU_POINT', response.data.zu);
                    return response.data.zu;
                } else {
                    console.log('error save Zu in DB');
                }
            });
        },

        storeWell({state, commit}, objectData) {
            return axios.post(this._vm.localeUrl("/gu-map/storewell"), {well: objectData}).then((response) => {
                if (response.data.status == 'success') {
                    commit('ADD_WELL_POINT', response.data.well);
                    return response.data.well;
                } else {
                    console.log('error save Well in DB');
                }
            });
        },

        storePipe({state, commit}, newPipe) {
            return axios.post(this._vm.localeUrl("/gu-map/storepipe"), {pipe: newPipe}).then((response) => {
                if (response.data.status == 'success') {
                    commit('ADD_PIPE', response.data.pipe);
                    commit('INCREASE_PIPE_LAYER_ID');
                    return response.data.pipe;
                } else {
                    console.log('error save Pipe in DB');
                }
            });
        }
    },

    getters: {},
};

export default gumap;

