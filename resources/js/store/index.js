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
    test: 'test',
  },
  getters: {
    test(state) {
      return state.test;
    },
  },
  mutations: {
    SET_TEST(state, value) {
      state.test = 'no test';
    },
  },
  actions: {
  },
  plugins: [createPersistedState()],
});
