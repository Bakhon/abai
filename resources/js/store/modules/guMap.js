import axios from 'axios'

const guMap = {
    namespaced: true,

    state: {
        pipes: [],
        zuPoints: [],
        wellPoints: [],
        guPoints: [],
        guPointsIndexes: [],
        mapCenter: {},
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
        UPDATE_GU_POINT(state, payload) {
            Vue.set(state.guPoints, [payload.index], payload.gu)
        },
        UPDATE_ZU_POINT (state, payload) {
            Vue.set(state.zuPoints, [payload.index], payload.zu)
        },
        UPDATE_WELL_POINT (state, payload) {
            Vue.set(state.wellPoints, [payload.index], payload.well)
        },
        UPDATE_PIPE_POINT (state, payload) {
            Vue.set(state.pipes, [payload.index], payload.pipe)
        },
        DELETE_GU(state, index) {
            state.guPoints.splice(index, 1);
        },
        DELETE_ZU(state, index) {
            state.zuPoints.splice(index, 1);
        },
        DELETE_WELL(state, index) {
            state.wellPoints.splice(index, 1);
        },
        DELETE_PIPE(state, index) {
            state.pipes.splice(index, 1);
        },

    },

    actions: {
        async getPipes({dispatch, commit}, gu) {
            return await axios.get(this._vm.localeUrl("/gu-map/pipes"), {params: {gu: gu}}).then((response) => {
                // commit('SET_PIPES', response.data.pipes);
                commit('SET_ZU_POINTS', response.data.zuPoints);
                commit('SET_WELL_POINTS', response.data.wellPoints);
                commit('SET_GU_POINTS', response.data.guPoints);
                commit('SET_MAP_CENTER', {
                    latitude: response.data.center[1],
                    longitude: response.data.center[0]
                });
                dispatch('indexingGuPoints');
                return response.data.pipes;
            })
        },

        indexingGuPoints({state, commit}) {
            state.guPoints.forEach((gu, index) => {
                commit('SET_GU_POINT_INDEX', {index: index, id: gu.id});
            });
        },

        storeGu({state, commit}, objectData) {
            return axios.post(this._vm.localeUrl("/gu-map/gu"), {gu: objectData}).then((response) => {
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
            return axios.post(this._vm.localeUrl("/gu-map/zu"), {zu: objectData}).then((response) => {
                if (response.data.status == 'success') {
                    commit('ADD_ZU_POINT', response.data.zu);
                    return response.data.zu;
                } else {
                    console.log('error save Zu in DB');
                }
            });
        },

        storeWell({state, commit}, objectData) {
            return axios.post(this._vm.localeUrl("/gu-map/well"), {well: objectData}).then((response) => {
                if (response.data.status == 'success') {
                    commit('ADD_WELL_POINT', response.data.well);
                    return response.data.well;
                } else {
                    console.log('error save Well in DB');
                }
            });
        },

        storePipe({state, commit}, newPipe) {
            return axios.post(this._vm.localeUrl("/gu-map/pipe"), {pipe: newPipe}).then((response) => {
                if (response.data.status == 'success') {
                    commit('ADD_PIPE', response.data.pipe);
                    return response.data.pipe;
                } else {
                    console.log('error save Pipe in DB');
                }
            });
        },

        updateGu({state, commit}, gu) {
            return axios.put(this._vm.localeUrl("/gu-map/gu/" + gu.id), {gu: gu}).then((response) => {
                if (response.data.status == 'success') {
                    let guIndex = state.guPoints.findIndex((guPoint) => {
                        return guPoint.id == gu.id;
                    });
                    commit('UPDATE_GU_POINT', {index: guIndex, gu: response.data.gu});
                    return response.data.gu;
                } else {
                    console.log('error update Gu in DB');
                }
            });
        },

        updateZu({state, commit}, zu) {
            return axios.put(this._vm.localeUrl("/gu-map/zu/" + zu.id), {zu: zu}).then((response) => {
                if (response.data.status == 'success') {
                    let zuIndex = state.zuPoints.findIndex((zuPoint) => {
                        return zuPoint.id == zu.id;
                    });
                    commit('UPDATE_ZU_POINT', {zu: response.data.zu, index: zuIndex});
                    return response.data.zu;
                } else {
                    console.log('error update Zu in DB');
                }
            });
        },

        updateWell({state, commit}, well) {
            return axios.put(this._vm.localeUrl("/gu-map/well/" + well.id), {well: well}).then((response) => {
                if (response.data.status == 'success') {
                    let wellIndex = state.zuPoints.findIndex((wellPoint) => {
                        return wellPoint.id == well.id;
                    });
                    commit('UPDATE_WELL_POINT', {well: response.data.well, index: wellIndex});
                    return response.data.well;
                } else {
                    console.log('error update Well in DB');
                }
            });
        },

        updatePipe({state, commit}, pipe) {
            return axios.put(this._vm.localeUrl("/gu-map/pipe/" + pipe.id), {pipe: pipe}).then((response) => {
                if (response.data.status == 'success') {
                    let pipeIndex = state.pipes.findIndex((pipeItem) => {
                        return pipeItem.id == pipe.id;
                    });
                    commit('UPDATE_PIPE_POINT', {pipe: response.data.pipe, index: pipeIndex});
                    return response.data.pipe;
                } else {
                    console.log('error update Pipe in DB');
                }
            });
        },

        deleteGu({state, commit}, gu) {
            return axios.delete(this._vm.localeUrl("/gu-map/gu/" + gu.id)).then((response) => {
                if (response.data.status == 'success') {
                    commit('DELETE_GU', gu.index);
                    return response.data.status
                } else {
                    console.log('error in delete Gu');
                }
            });
        },
        deleteZu({state, commit}, zu) {
            return axios.delete(this._vm.localeUrl("/gu-map/zu/" + zu.id)).then((response) => {
                if (response.data.status == 'success') {
                    commit('DELETE_ZU', zu.index);
                    return response.data.status
                } else {
                    console.log('error in delete Zu');
                }
            });
        },
        deleteWell({state, commit}, well) {
            return axios.delete(this._vm.localeUrl("/gu-map/well/" + well.id)).then((response) => {
                if (response.data.status == 'success') {
                    commit('DELETE_WELL', well.index);
                    return response.data.status
                } else {
                    console.log('error in delete Well');
                }
            });
        },
        deletePipe ({state, commit}, pipe) {
            return axios.delete(this._vm.localeUrl("/gu-map/pipe/" + pipe.id ))
                .then((response) => {
                if (response.data.status == 'success') {
                    commit('DELETE_PIPE', pipe.index);
                    return response.data.status
                } else {
                    console.log('error in delete Pipe');
                }
            });
        }
    },

    getters: {},
};

export default guMap;

