import {
    FETCH_WELLS_CURVES,
    FETCH_DZOS,
    FETCH_FIELDS,
    FETCH_WELLS,
    FETCH_WELLS_MNEMONICS,
    FETCH_WELLS_HORIZONS,

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
    SET_WELLS_HORIZONS,

    GET_CURVES,
    GET_WELLS_OPTIONS,
    GET_TREE_CURVES,
    GET_FIELDS_OPTIONS,
    GET_DZOS_OPTIONS,
    GET_GIS_GROUPS, CURVE_ELEMENT_OPTIONS,
    GET_TREE_STRATIGRAPHY, COLOR_PALETTE
} from "./geologyGis.const";

import {isFloat, uuidv4} from "../../components/geology/js/utils";
import AwGisClass from "../../components/geology/petrophysics/graphics/awGis/utils/AwGisClass";
import {
    Fetch_Curves,
    Fetch_DZOS,
    Fetch_Fields,
    Fetch_Wells,
    Fetch_WellsMnemonics
} from "../../components/geology/api/petrophysics.api";
import {Fetch_Horizons} from "../../components/geology/api/horizons.api";
import THorizon from '../../components/geology/petrophysics/graphics/awGis/utils/THorizon'

const geologyGis = {
    state: {
        changeGisData: Date.now(),
        gisDataCurves: {},
        gisData: [],
        gisGroups: [],
        curveName: null,

        selectedGisCurvesOld: [],
        selectedGisCurves: [],

        selectedHorizonOld: [],
        selectedHorizon: [],

        tHorizon: new THorizon(),
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
        CURVES_OF_SELECTED_WELLS: {},
        WELLS_HORIZONS: {},
        WELLS_HORIZONS_ELEMENTS: []
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
        [GET_TREE_STRATIGRAPHY](state) {
            let stratigraphyArray = Object.entries(state.WELLS_HORIZONS);
            if (stratigraphyArray.length) {
                let stratigraphyElements = state.tHorizon.elements.reduce((acc, el) => {
                    acc.push({
                        name: el.name,
                        iconType: "u1",
                        value: el.name,
                        iconFill: el.fill,
                    })

                    acc.push({
                        name: `Zone ${el.name}_top`,
                        iconType: "zone",
                        iconFill: el.fill,
                    })
                    return acc
                }, []);

                return [{
                    name: "Stratigraphy",
                    iconType: "zoneStatic",
                    value: [].join('/'),
                    isOpen: true,
                    children: [...stratigraphyElements]
                }];
            }
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
            state.WELLS = data;
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
            });
            state.tHorizon.selectedWells = blockIds.map((w) => w.value);

        },

        [SET_WELLS_MNEMONICS](state, mnemonics) {
            state.WELLS_MNEMONICS = mnemonics;
        },

        [SET_WELLS_HORIZONS](state, horizons) {
            for (const [wellName, horizonsElement] of Object.entries(horizons)) {
                for (const el of horizonsElement) {
                    if (!state.tHorizon.hasElement(el.name)) {
                        let fillColor = Math.floor(Math.random() * 16777215).toString(16);
                        state.tHorizon.addElement(el.name, {
                                name: el.name,
                                show: false,
                                fill: `#${fillColor}`,
                                toWells: {},
                                wells: [],
                            }
                        );
                    }
                    state.tHorizon.editPropertyElementData(el.name, [
                        ["toWells", (prop) => ({...prop, [wellName]: el})],
                        ["wells", (prop) => (!prop.includes(wellName) && prop.push(wellName), prop)]
                    ]);
                }
            }
            state.WELLS_HORIZONS = horizons;
            state.WELLS_HORIZONS_ELEMENTS = state.tHorizon.elements;
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
                    let curveOptions = {
                        min: {},
                        max: {},
                        sum: {},
                        startX: {},
                        isLithology: {},
                        isCSAT: {},
                        name: {},
                        colorPalette: {}
                    };
                    let isLithology = curveName.toLowerCase().trim() === "litho";
                    let isFluid = curveName.toLowerCase().trim() === "fluid";
                    state.awGis.editElementData(curveName, {
                        curves: Object.entries(curve_id).reduce((acc, [key, id]) => {
                            let curve = state.CURVES_OF_SELECTED_WELLS[id];
                            let curveWithoutNull = [...curve.filter((x) => +x)]
                            curveOptions.name[key] = curveName;
                            curveOptions.startX[key] = curveWithoutNull[0];
                            curveOptions.min[key] = Math.min(...curveWithoutNull);
                            curveOptions.max[key] = Math.max(...curveWithoutNull);
                            curveOptions.sum[key] = curveWithoutNull.reduce((acc, i) => (acc + i), 0);
                            curveOptions.isLithology[key] = isLithology;
                            curveOptions.isCSAT[key] = isFluid;
                            if (curve) acc[key] = curve;
                            return acc;
                        }, {})
                    })
                    if (isLithology || isFluid) {
                        curveOptions.colorPalette = COLOR_PALETTE[curveName.toLowerCase()];
                    }
                    state.awGis.editElementOptions(curveName, JSON.parse(JSON.stringify({...curveOptions})));
                }
            }
            state.changeGisData = Date.now();
        },

        [SET_CURVE_OPTIONS](state, [propName, props]) {
            if (state.awGis.hasElement(state.curveName)) {
                state.awGis.editPropertyElementData(state.curveName, 'options', `customParams.${propName}`, (p) => ({...p, ...props}));
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

        async [FETCH_WELLS_HORIZONS]({commit, state}, payload) {
            if (payload.length) return commit(SET_WELLS_HORIZONS, await Fetch_Horizons(payload));
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
            let {
                name,
                curve_id,
                depth_start,
                depth_end,
                step
            } = datum;
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
                state.awGis.editPropertyElementData(name, 'data', [
                    ['wellID', (wellIDS) => {
                        if (!wellIDS.includes(wellID)) wellIDS.push(wellID);
                        return wellIDS;
                    }],
                    ['curve_id', (elCurveIDS) => {
                        if (!elCurveIDS.hasOwnProperty(wellID.toString())) elCurveIDS[wellID.toString()] = curve_id;
                        return elCurveIDS;
                    }],
                    ['depth_start', (d_start) => {
                        if (!d_start.hasOwnProperty(wellID.toString())) d_start[wellID.toString()] = depth_start;
                        return d_start;
                    }],
                    ['depth_end', (d_end) => {
                        if (!d_end.hasOwnProperty(wellID.toString())) d_end[wellID.toString()] = depth_end;
                        return d_end;
                    }],
                    ['step', (d_step) => {
                        if (!d_step.hasOwnProperty(wellID.toString())) d_step[wellID.toString()] = step;
                        return d_step;
                    }]
                ]);
            } else {
                let curveColor = COLOR_PALETTE.curves, hex;

                if (curveColor.hasOwnProperty(name.toLowerCase())) {
                    let [r, g, b] = curveColor[name.toLowerCase()];
                    hex = "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);

                    CURVE_ELEMENT_OPTIONS.customParams = {
                        ...CURVE_ELEMENT_OPTIONS.customParams,
                        curveColor: COLOR_PALETTE.curves.hasOwnProperty(name.toLowerCase()) ? {
                            use: true,
                            value: hex
                        } : {use: false, value: "#000000"}
                    }
                }

                this.addElement(name, {
                    name: name,
                    value: name,
                    id: uuidv4(),
                    wellID: [wellID],
                    isShow: true,
                    curve_id: {[wellID]: curve_id},
                    depth_start: {[wellID]: depth_start},
                    depth_end: {[wellID]: depth_end},
                    step: {[wellID]: step},
                }, JSON.parse(JSON.stringify(CURVE_ELEMENT_OPTIONS)))
            }

            if (!this.hasElementInGroup(groupsIds.get(name), name)) {
                this.addElementToGroup(groupsIds.get(name), name);
            }
        }
    }
    return this.getGroupsWithData;
}

function componentToHex(c) {
    let hex = c.toString(16);
    return hex.length === 1 ? "0" + hex : hex;
}

export default geologyGis;
