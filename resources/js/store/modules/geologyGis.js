import {
    FETCH_WELLS_CURVES,
    FETCH_DZOS,
    FETCH_FIELDS,
    FETCH_WELLS,
    FETCH_WELLS_MNEMONICS,

    SET_WELLS_MNEMONICS,
    SET_FIELDS,
    SET_WELLS,
    SET_WELLS_BLOCKS,
    SET_DRAG_PARAMS,
    SET_SELECTED_WELL_CURVES_FORCE,
    SET_GIS_DATA,
    SET_CURVE_NAME,
    SET_SELECTED_WELL_CURVES,
    SET_DZOS,
    SET_SCROLL_BLOCK_Y,
    SET_CURVES,
    SET_GIS_DATA_FOR_GRAPH,
    SET_CURVE_OPTIONS,

    GET_CURVES,
    GET_WELLS_OPTIONS,
    GET_TREE_CURVES,
    GET_FIELDS_OPTIONS,
    GET_DZOS_OPTIONS,
    GET_GIS_GROUPS, CURVE_ELEMENT_OPTIONS,
} from "./geologyGis.const";

import {uuidv4} from "../../components/geology/petrophysics/graphics/awGis/utils/utils";
import AwGisClass from "../../components/geology/petrophysics/graphics/awGis/utils/AwGisClass";
import {
    Fetch_Curves,
    Fetch_DZOS,
    Fetch_Fields,
    Fetch_Wells,
    Fetch_WellsMnemonics
} from "../../components/geology/api/petrophysics.api";

const geologyGis = {
    state: {
        changeGisData: Date.now(),
        gisDataCurves: {},
        gisData: [],
        gisGroups: [],
        curveName: null,
        selectedGisCurvesOld: [],
        selectedGisCurves: [],
        awGis: new AwGisClass(),
        awGisElementsCount: 0,
        gisWells: [],
        blocksScrollY: 0,
        wellTreeParam: {
            dragElement: {
                value: null
            },
            toGroup: {
                value: null,
                func: (state) => {
                    state.awGis.moveElement(state.wellTreeParam.dragElement.value, state.wellTreeParam.fromGroup.value, state.wellTreeParam.toGroup.value);
                }
            },
            fromGroup: {
                value: null,
            }
        },
        DZOS: [],
        FIELDS: [],
        WELLS: [],
        WELLS_MNEMONICS: [],
        WELLS_MNEMONICS_FOR_TREE: [],
        CURVES_OF_SELECTED_WELLS: {}
    },
    getters: {
        [GET_WELLS_OPTIONS](state) {
            return forDropDownMap(state.WELLS, ["name", "name"]);
        },

        [GET_FIELDS_OPTIONS](state) {
            return forDropDownMap(state.FIELDS);
        },

        [GET_DZOS_OPTIONS](state) {
            return forDropDownMap(state.DZOS);
        },

        [GET_GIS_GROUPS](state) {
            return state.gisGroups.reduce((acc, gr) => {
                acc[gr] = state.awGis.getGroupElementsWithData(gr);
                return acc;
            }, {});
        },

        [GET_TREE_CURVES](state) {
            let array = state.selectedGisCurves;
            return state.gisData.map(({groupName, elements, options}) => {
                elements = Array.isArray(elements) ? elements.length ? elements.join('/') : options.name : elements;

                let every = elements.split('/').every((el) => array.includes(el));
                let some = elements.split('/').some((el) => array.includes(el));

                return {
                    ...options,
                    value: elements,
                    name: elements,
                    indeterminate: !every && every !== some,
                    isSelectedAllElements: elements.split('/').every((el) => array.includes(el)),
                    children: state.awGis.getGroupElementsWithData(groupName).map(({data}) => {
                        return {
                            ...data,
                            groupID: groupName,
                            isSelected: array.includes(data.value)
                        }
                    })
                }
            })
        },
    },
    mutations: {
        [SET_DRAG_PARAMS](state, [param, value]) {
            let params = state.wellTreeParam[param];
            params.value = value;
            if (params.func) params.func(state);
            state.gisData = state.awGis.getGroupsWithData;
            state.gisGroups = state.awGis.getGroupList
        },

        [SET_DZOS](state, data) {
            state.DZOS = data;
        },

        [SET_FIELDS](state, data) {
            state.FIELDS = data;
        },

        [SET_WELLS](state, data) {
            state.WELLS = data
        },

        [SET_SCROLL_BLOCK_Y](state, y) {
            state.blocksScrollY = y;
        },

        [SET_CURVE_NAME](state, curveName) {
            state.curveName = curveName;
        },

        [SET_SELECTED_WELL_CURVES_FORCE](state, value) {
            state.selectedGisCurves = value;
        },

        [SET_SELECTED_WELL_CURVES](state, value) {
            // TODO Переделать в нормальный код.
            value = value.split('/');
            let existElementsCount = value.reduce((acc, val) => {
                if (state.selectedGisCurves.includes(val)) acc++
                return acc;
            }, 0);

            if (value.length > 1) {
                if (existElementsCount < value.length) {
                    for (const val of value) {
                        if (!state.selectedGisCurves.includes(val))
                            state.selectedGisCurves.push(val)
                    }
                } else {
                    toggleElements()
                }
            } else {
                toggleElements()
            }

            function toggleElements() {
                for (const val of value) {
                    let existsIndex = state.selectedGisCurves.indexOf(val);
                    if (~existsIndex) {
                        state.selectedGisCurves.splice(existsIndex, 1)
                    } else {
                        state.selectedGisCurves.push(val)
                    }
                }
            }
        },

        [SET_WELLS_BLOCKS](state, blockIds) {
            state.gisWells = blockIds.map(({sort}) => {
                return state.WELLS[sort];
            })
        },

        [SET_WELLS_MNEMONICS](state, mnemonics) {
            state.WELLS_MNEMONICS = mnemonics;
        },
        [SET_GIS_DATA](state) {
            state.gisData = mnemonicsSort.apply(state.awGis, [state.WELLS_MNEMONICS, state]);
            state.gisGroups = state.awGis.getGroupList
            state.awGisElementsCount = state.awGis.getElementsCount
        },

        [SET_CURVES](state, curves) {
            state.CURVES_OF_SELECTED_WELLS = {...state.CURVES_OF_SELECTED_WELLS, ...curves};
        },

        [SET_GIS_DATA_FOR_GRAPH](state) {
            for (const curveName of state.selectedGisCurves) {
                if (state.awGis.hasElement(curveName)) {
                    let {data: {curve_id}} = state.awGis.getElement(curveName);
                    let curveOptions = {min: {}, max: {}, sum: {}, startX: {}};
                    state.awGis.editElementData(curveName, {
                        curves: Object.entries(curve_id).reduce((acc, [key, id]) => {
                            let curve = state.CURVES_OF_SELECTED_WELLS[id];
                            let curveWithoutNull = [...curve.filter((x) => +x)]
                            curveOptions.startX[key] = curveWithoutNull[0];
                            curveOptions.min[key] = Math.min(...curveWithoutNull);
                            curveOptions.max[key] = Math.max(...curveWithoutNull);
                            curveOptions.sum[key] = curveWithoutNull.reduce((acc, i) => (acc + i), 0);

                            if (curve) acc[key] = curve;
                            return acc
                        }, {})
                    })
                    state.awGis.editElementOptions(curveName, JSON.parse(JSON.stringify(curveOptions)));
                }
            }
            state.changeGisData = Date.now();
        },

        [SET_CURVE_OPTIONS](state, [propName, props]) {
            if (state.awGis.hasElement(state.curveName)) {
                let {options: {customParams = {}}} = state.awGis.getElement(state.curveName);
                customParams = Object.assign({...customParams}, {[propName]: {...customParams[propName], ...props}})
                state.awGis.editElementOptions(state.curveName, {customParams});
            }
        }
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
            commit(SET_GIS_DATA)
        },

        async [FETCH_WELLS_CURVES]({commit, state}, payload) {
            if (payload.length) return commit(SET_CURVES, await Fetch_Curves(payload));
        },
    }
}

function forDropDownMap(arr, [first, second] = ["name", "id"]) {
    return arr.map((item) => {
        return {
            label: item[first]?.toString()?.replace(/[a-zA-Z0-9]+_/, ''),
            value: item[second] || item[first]
        }
    })
}

let wellID = null;
let groupsIds = new Map();

function mnemonicsSort(data, state) {
    // TODO Переделать в нормальный код.
    for (let datum of data) {
        if (datum.mnemonics) {
            wellID = datum.well;
            mnemonicsSort.apply(this, [datum.mnemonics, state]);
        } else {
            let {name, curve_id} = datum;
            let groupId = uuidv4();

            if (!groupsIds.has(name)) {
                groupsIds.set(name, groupId);
                this.addGroup(groupId, {
                    id: groupId,
                    name: name,
                    value: name,
                    iconType: 'oilTower',
                    iconFill: '#FF6600',
                    isOpen: true,
                });
            }

            if (this.hasElement(name)) {
                let {data: {curve_id: cId, wellID: wId}} = this.getElement(name);
                if (!wId.includes(wellID)) wId = [...wId, wellID]
                if (!cId[wellID.toString()]) cId[wellID.toString()] = curve_id
                this.editElementData(name, {wellID: wId, curve_id: cId})
            } else {
                this.addElement(name, {
                    name: name,
                    value: name,
                    id: uuidv4(),
                    wellID: [wellID],
                    isShow: true,
                    curve_id: {[wellID]: curve_id},
                }, JSON.parse(JSON.stringify(CURVE_ELEMENT_OPTIONS)))
            }

            if (!this.hasElementInGroup(groupsIds.get(name), name)) {
                this.addElementToGroup(groupsIds.get(name), name);
            }
        }
    }
    return this.getGroupsWithData;
}

export default geologyGis;
