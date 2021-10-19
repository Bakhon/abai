import {
    FETCH_GIS_DATA,
    SET_GIS_DATA,
    SET_WELL_NAME,
    SET_SELECTED_WELL_CURVES,
    SET_DZOS,
    SET_SCROLL_BLOCK_Y,
    GET_TREE_CURVES,
    FETCH_DZOS,
    FETCH_FIELDS,
    FETCH_WELLS,
    FETCH_WELLS_MNEMONICS,
    SET_WELLS_MNEMONICS,
    SET_MNEMONICS_FOR_TREE,
    SET_FIELDS,
    SET_WELLS,
    SET_WELLS_BLOCKS,
    GET_WELLS_OPTIONS,
    GET_FIELDS_OPTIONS,
    GET_DZOS_OPTIONS,
} from "./geologyGis.const";

import {uuidv4} from "../../components/geology/petrophysics/graphics/awGis/utils/utils";
import AwGisClass from "../../components/geology/petrophysics/graphics/awGis/utils/AwGisClass";
import {
    Fetch_DZOS,
    Fetch_Fields,
    Fetch_Wells,
    Fetch_WellsMnemonics
} from "../../components/geology/api/petrophysics.api";

const geologyGis = {
    state: {
        gisDataCurves: {},
        gisData: [],
        wellName: null,
        selectedGisCurves: [],
        awGis: new AwGisClass(),
        gisWells: [],
        blocksScrollY: 0,
        DZOS: [],
        FIELDS: [],
        WELLS: [],
        WELLS_MNEMONICS: [],
        WELLS_MNEMONICS_FOR_TREE: [],
    },
    getters: {
        [GET_WELLS_OPTIONS](state) {
            return forDropDownMap(state.WELLS);
        },

        [GET_FIELDS_OPTIONS](state) {
            return forDropDownMap(state.FIELDS);
        },

        [GET_DZOS_OPTIONS](state) {
            return forDropDownMap(state.DZOS);
        },

        [GET_TREE_CURVES](state) {
            return state.gisData.map(({groupName, elements, options}) => {
                elements = Array.isArray(elements) ? elements.join('/') : elements;
                return {
                    ...options,
                    value: elements,
                    name: elements,
                    children: state.awGis.getGroupElementsWithData(groupName).map(({options}) => {
                        return options
                    })
                }
            })
        }
    },
    mutations: {
        [SET_DZOS](state, data) {
            state.DZOS = data;
        },

        [SET_FIELDS](state, data) {
            state.FIELDS = data;
        },

        [SET_WELLS](state, data) {
            state.WELLS = data;
        },

        [SET_SCROLL_BLOCK_Y](state, y) {
            state.blocksScrollY = y;
        },

        [SET_WELL_NAME](state, wellName) {
            state.wellName = wellName;
        },

        [SET_SELECTED_WELL_CURVES](state, arr) {
            state.selectedGisCurves = arr;
        },

        [SET_WELLS_BLOCKS](state, blockIds) {
            state.gisWells = blockIds.map(({sort}) => {
                return state.WELLS[sort];
            })
        },

        [SET_WELLS_MNEMONICS](state, mnemonics) {
            state.WELLS_MNEMONICS = mnemonics;
        },
    },

    actions: {
        async [FETCH_DZOS]({commit}) {
            commit(SET_DZOS, await Fetch_DZOS());
        },

        async [FETCH_FIELDS]({commit}, payload) {
            if (typeof payload === "number") {
                commit(SET_FIELDS, await Fetch_Fields(payload));
            }
        },

        async [FETCH_WELLS]({commit}, payload) {
            if (typeof payload === "number") {
                commit(SET_WELLS, await Fetch_Wells(payload));
            }
        },

        async [FETCH_WELLS_MNEMONICS]({commit, state}, payload) {
            commit(SET_WELLS_MNEMONICS, await Fetch_WellsMnemonics(payload));
            state.gisData = mnemonicsSort.apply(state.awGis, [state.WELLS_MNEMONICS]);
        },
    }
}

function forDropDownMap(arr) {
    return arr.map((item) => {
        return {
            label: item.name?.replace(/[a-zA-Z0-9]+_/, ''),
            value: item.id || item.name
        }
    })
}

let wellID = null;
function mnemonicsSort(data) {
    for (let datum of data) {
        if (datum.mnemonics) {
            wellID = datum.well_id;
            mnemonicsSort.apply(this, [datum.mnemonics]);
        } else {
            let {name, curve_id} = datum;
            this.addGroup(name, {
                id: uuidv4(),
                name: name,
                value: name,
                iconType: 'oilTower',
                iconFill: '#FF6600',
                isOpen: true,
            });

            this.addElementToGroup(name, name, curve_id, {
                wellID,
                name: name,
                value: name,
                curve_id,
                id: uuidv4(),
            });
        }
    }
    return this.getGroupsWithData;
}

export default geologyGis;
