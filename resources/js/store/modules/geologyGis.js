import {
    FETCH_GIS_DATA,
    SET_GIS_DATA,
    SET_WELL_NAME,
    SET_SELECTED_WELL_CURVES,
    ADD_BLOCK,
    SET_DZOS,
    SET_SCROLL_BLOCK_Y,
    GET_TREE_CURVES, FETCH_DZOS, FETCH_FIELDS, FETCH_WELLS,
    SET_FIELDS,
    SET_WELLS,
} from "./geologyGis.const";
import {uuidv4} from "../../components/geology/petrophysics/graphics/awGis/utils/utils";
import AwGisClass from "../../components/geology/petrophysics/graphics/awGis/utils/AwGisClass";
import {Fetch_DZOS, Fetch_Fields, Fetch_Wells} from "../../components/geology/api/petrophysics.api";

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
        FILEDS: [],
        WELLS: [],
    },
    getters: {
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
            state.FILEDS = data;
        },

        [SET_WELLS](state, data) {
            state.WELLS = data;
        },

        [SET_SCROLL_BLOCK_Y](state, y) {
            state.blocksScrollY = y;
        },

        [SET_GIS_DATA](state, data) {
            state.gisDataCurves = data.curves.reduce((acc, {mnemonic, curve}) => {
                acc[mnemonic] = curve.filter(item => +item)
                return acc
            }, {});

            for (const {curve, mnemonic} of data.curves) {
                // TODO переделать под api
                state.awGis.addGroup(mnemonic, {
                    id: uuidv4(),
                    name: mnemonic,
                    value: mnemonic,
                    iconType: 'oilTower',
                    iconFill: '#FF6600',
                    isOpen: true,
                });

                // TODO переделать под api
                state.awGis.addElementToGroup(mnemonic, mnemonic, curve, {
                    name: mnemonic,
                    value: mnemonic,
                    id: uuidv4(),
                });
            }
            state.gisData = state.awGis.getGroupsWithData
        },

        [SET_WELL_NAME](state, wellName) {
            state.wellName = wellName;
        },

        [SET_SELECTED_WELL_CURVES](state, arr) {
            state.selectedGisCurves = arr;
        },

        [ADD_BLOCK](state, blockName) {
            let well = state.gisWells.findIndex((w) => w.name === blockName);
            let addedData = {name: blockName, id: uuidv4()}
            if (~well) state.gisWells.splice(well, 1);
            else state.gisWells.push(addedData);
        },
    },

    actions: {
        async [FETCH_GIS_DATA]({commit}) {
            await fetch("/js/json/geology_demo/curve.json").then(async (res) => {
                commit(SET_GIS_DATA, await res.json());
            });
        },
        async [FETCH_DZOS]({commit}) {
            commit(SET_DZOS, forDropDownMap(await Fetch_DZOS()));
        },
        async [FETCH_FIELDS]({commit}, payload) {
            if(typeof payload === "number"){
                commit(SET_FIELDS, forDropDownMap(await Fetch_Fields(payload)));
            }
        },
        async [FETCH_WELLS]({commit}, payload) {
            if(typeof payload === "number"){
                commit(SET_WELLS, forDropDownMap(await Fetch_Wells(payload)));
            }
        },
    }
}

function forDropDownMap(arr) {
    return arr.map((item) => {
        return {
            label: item.name.replace('AKG_', ''),
            value: item.id || item.name
        }
    })
}

export default geologyGis;
