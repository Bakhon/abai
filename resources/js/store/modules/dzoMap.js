import axios from 'axios'
import guMap from "./guMap";

const dzoMap = {
    namespaced: true,

    state: {
        yearlyPlan: [],
    },

    mutations: {
        SET_YEARLY_PLAN(state, payload) {
            state.yearlyPlan = payload;
        }
    },

    actions: {
        getYearlyPlan({state, commit}, objectData) {
            return axios.get(this._vm.localeUrl("/get-dzo-yearly-plan")).then((response) => {
                if (response.status == 200) {
                    commit('SET_YEARLY_PLAN', response.data);
                    return response.data.yearlyPlan;
                } else {
                    console.log('error getting DZO Yearly plan');
                }
            });
        }
    },
}

export default dzoMap;