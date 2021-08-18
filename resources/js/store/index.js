import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import modules from './modules';
import {GEOLOGY_SAVE_TO_LOCAL_STORAGE} from "./modules/geology.const";

Vue.use(Vuex);
export default new Vuex.Store({
    modules,
    plugins: [createPersistedState({
        paths: [
            ...GEOLOGY_SAVE_TO_LOCAL_STORAGE,
            'bd',
            'complicationMonitoring',
            'dzoMap',
            'fa',
            'guMap',
            'index',
            'paegtmMap',
            'pgno',
            'plastFluids',
            'techMode',
            'tr'
        ]
    })],
});
