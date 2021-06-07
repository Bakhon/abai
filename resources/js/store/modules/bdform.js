import axios from 'axios'

const bdform = {
    namespaced: true,

    state: {
        dicts: {},
        formParams: {}
    },

    actions: {
        getGeoDictByDZO({commit}, params) {
            axios.get(this._vm.localeUrl(`/api/bigdata/dict/geos/${params.dzo}`)).then(({data}) => {
                commit("SAVE_DICT", {
                    code: params.code,
                    items: data
                });
            })
        },
        updateForm({commit}, formCode) {
            return axios.get(this._vm.localeUrl(`/api/bigdata/forms/${formCode}`)).then(({data}) => {
                commit("SAVE_FORM_PARAMS", data.params)
                return data
            })
        },
        submitForm({}, params) {
            return axios.post(this._vm.localeUrl(`/api/bigdata/forms/${params.code}`), {
                ...params.values,
                well: params.wellId
            })
        },
        getWellPrefix({}, params) {
            return axios.get(this._vm.localeUrl(`/api/bigdata/forms/${params.code}/well-prefix`), {
                params: {
                    geo: params.geo
                }
            })
        },
        getValidationErrors({}, params) {
            return axios.post(
                this._vm.localeUrl(`/api/bigdata/forms/${params.formCode}/validate/${params.fieldCode}`),
                params.values
            )
        },
        loadDict({commit}, code) {
            axios.get(this._vm.localeUrl(`/api/bigdata/dict/${code}`)).then(data => {
                commit("SAVE_DICT", {
                    code: code,
                    items: data.data
                });
            })
        }
    },

    mutations: {
        SAVE_DICT: (state, val) => {
            state.dicts[val.code] = val.items
        },
        SAVE_FORM_PARAMS: (state, val) => {
            state.formParams = val
        },
        SAVE_FORM_VALUES: (state, val) => {
            state.formValues = val
        },
    },

    getters: {
        dict: (state) => code => state.dicts[code]
    },
};

export default bdform;
