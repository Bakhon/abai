import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import modules from './modules';

Vue.use(Vuex);

export default new Vuex.Store({
    modules,

    state: {},
    getters: {},
    mutations: {},
    actions: {},
    plugins: [createPersistedState({
        paths: [
            'bd',
            'complicationMonitoring',
            'dzoMap',
            'fa',
            'globalloading',
            'guMap',
            'index',
            'paegtmMap',
            'pgno',
            'techMode',
            'tr'
        ]
    })],
});
