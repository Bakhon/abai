import axios from 'axios'

const bd = {
    namespaced: true,

    state: {
        dicts: {},
    },

    actions: {
        getGeoDictByDZO({commit}, params) {
            axios.get(this._vm.localeUrl(`/bigdata/dict/geos/${params.dzo}`)).then(({data}) => {
                commit("SAVE_DICT", {
                    code: params.code,
                    items: data
                });
            })
        }
    },

    mutations: {
        SAVE_DICT: (state, val) => {
            state.dicts[val.code] = val.items;
        },
    },

    getters: {
        dict: (state) => code => state.dicts[code]
    },
};

export default bd;
