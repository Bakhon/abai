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
                //commit("SAVE_FORM_PARAMS", {...data.params, ...{available_actions: data.available_actions}})
                return {...data.params, ...{available_actions: data.available_actions}}
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
        async loadDict({commit}, code) {
            return axios.get(this._vm.localeUrl(`/api/bigdata/dict/${code}`)).then(data => {
                commit("SAVE_DICT", {
                    code: code,
                    items: data.data
                });
                return data.data
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
        dict: (state) => code => state.dicts[code],
        dictFlat: (state) => code => {
            let dict = {children: Object.values(state.dicts[code])}
            console.log(dict)
            let flatten = (children, getChildren, level, parent) => {
                console.log(parent)
                return Array.prototype.concat.apply(
                    children.map(x => ({...x, level: level || 1, parent: parent || null})),
                    children.map(x => flatten(getChildren(x) || [], getChildren, (level || 1) + 1, x.id))
                )
            }
            let extractChildren = x => x.children;
            return flatten(extractChildren(dict), extractChildren).map(x => delete x.children && x);
        }
    },
};

export default bdform;
