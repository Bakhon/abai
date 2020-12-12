import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import tr from './modules/tr';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    tr,
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
