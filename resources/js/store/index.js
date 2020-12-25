import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import tr from './modules/tr';
import fa from './modules/fa';
import globalloading from './modules/globalloading';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    tr,
    fa,
    globalloading,
  },

  state: {
  },
  getters: {
  },
  mutations: {
  },
  actions: {
  },
  plugins: [createPersistedState()],
});
