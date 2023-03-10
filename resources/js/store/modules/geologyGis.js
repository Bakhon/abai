import {
    FETCH_WELLS_CURVES,
    FETCH_DZOS,
    FETCH_FIELDS,
    FETCH_WELLS,
    FETCH_WELLS_MNEMONICS,
    FETCH_WELLS_HORIZONS,
    FETCH_AUTOCORRELATION,
    FETCH_FACIES_CLASSIFICATION,

    POST_HORIZON,
    POST_INTERPRETATION,

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
    SET_AUTOCORRELATION,
    SET_SHOW_STRATIGRAPHY_ELEMENTS,
    SET_FACIES_CLASSIFICATION_TO_ELEMENTS,
    SET_TIME_START_AUTOINTERPRETATION,
    SET_CURRENT_TIME_AUTOINTERPRETATION,

    GET_WELLS_OPTIONS,
    GET_TREE_CURVES,
    GET_FIELDS_OPTIONS,
    GET_DZOS_OPTIONS,
    GET_GIS_GROUPS,
    CURVE_ELEMENT_OPTIONS,
    GET_TREE_STRATIGRAPHY,

    COLOR_PALETTE,
    CHECK_INTERPRETATION,
    RESET_TIME_START_AUTOINTERPRETATION,
    CHECK_TIMER,
    RUN_TIMER,
} from "./geologyGis.const";

import {uuidv4} from "../../components/geology/js/utils";
import AwGisClass from "../../components/geology/petrophysics/graphics/awGis/utils/AwGisClass";
import {
    Fetch_Curves, Fetch_DZOS, Fetch_Fields, Fetch_Wells, Fetch_WellsMnemonics
} from "../../components/geology/api/petrophysics.api";
import {Fetch_Horizons, Post_Horizons} from "../../components/geology/api/horizons.api";
import THorizon from '../../components/geology/petrophysics/graphics/awGis/utils/THorizon'
import {Fetch_Autocorrelation} from "../../components/geology/api/autocorrelation.api";
import {Fetch_FaciesClassification} from "../../components/geology/api/facies.api";
import {Get_InterpretationStatus, Post_Interpretation} from "../../components/geology/api/interpretation.api";

const geologyGis = {
    state: {
        autoInterpretation:{
            isActive: false,
            scoreboard: "00:00",
            currentTime: Date.now(),
            startTime: null,
            endTime: null,
            minutesToAdd: 15, //min
            updateInterval: "00", //sec
            calculation_id: null
        },
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
        wellsElementsMap: new Map(),
        awGisElementsCount: 0,
        gisWells: [],
        showStratigraphyElements: [],
        showStratigraphyElementsForResultDropdown: [],
        blocksScrollY: 0,
        wellTreeParam: {
            dragElement: {
                value: null
            }, toGroup: {
                value: null, func: (state) => {
                    state.awGis.moveElement(state.wellTreeParam.dragElement.value, state.wellTreeParam.fromGroup.value, state.wellTreeParam.toGroup.value);
                }
            }, fromGroup: {
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
        WELLS_HORIZONS_ELEMENTS: [],
        AUTOCORRELATION: [],
    },
    getters: {
        [CHECK_TIMER](state){
            let {isActive, currentTime, endTime} = state.autoInterpretation;
            return (isActive&&currentTime<new Date(endTime).getTime());
        },

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
            state.tHorizon.scrollY = y;
        },

        [SET_CURVE_NAME](state, curveName) {
            state.curveName = curveName;
        },

        [SET_SELECTED_WELL_CURVES_FORCE](state, value) {
            state.selectedGisCurves = value;
        },

        [SET_SELECTED_WELL_CURVES](state, value) {
            // TODO ???????????????????? ?? ???????????????????? ??????.
            value = value.split('/');
            let existElementsCount = value.reduce((acc, val) => {
                if (state.selectedGisCurves.includes(val)) acc++
                return acc;
            }, 0);

            if (value.length > 1) {
                if (existElementsCount < value.length) {
                    for (const val of value) {
                        if (!state.selectedGisCurves.includes(val)) state.selectedGisCurves.push(val)
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
                                code: el.code,
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

        [SET_GIS_DATA](state, customMnemonics = false) {
            state.gisData = mnemonicsSort.apply(state.awGis, [(customMnemonics || state.WELLS_MNEMONICS), state]);
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
                        min: {}, max: {}, sum: {}, startX: {}, isLithology: {}, isCSAT: {}, GIS46: {}, name: {}, colorPalette: {}
                    };
                    let isLithology = curveName.toLowerCase().trim() === "litho";
                    let isFluid = curveName.toLowerCase().trim() === "fluid";
                    let GIS46 = "6gis_4gis".match(curveName.toLowerCase().trim())
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
                            curveOptions.GIS46[key] = GIS46;
                            if (curve) acc[key] = curve;
                            return acc;
                        }, {})
                    })
                    if (isLithology || isFluid || GIS46) {
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
        },

        [SET_AUTOCORRELATION](state, [payload, data]) {
            let newObject = {}
            let toShow = []
            let lastMD = 0;
            state.showStratigraphyElementsForResultDropdown = [];
            for (let [wellName, wellData = {}] of Object.entries(payload)) {
                newObject[wellName] = Object.entries(wellData).map(([stratigraphyName, stratigraphyValue]) => {
                    let horizonData = state.tHorizon.getElement(stratigraphyName);
                    toShow.push(`${stratigraphyName}_${data.method}`)
                    state.showStratigraphyElementsForResultDropdown.push({
                        label: `${stratigraphyName}/ ${wellName} ${data.method}`,
                        value: `${stratigraphyName}_${data.method}`
                    })
                    return {
                        name: `${stratigraphyName}_${data.method}`,
                        code: horizonData.code,
                        md: lastMD = Math.abs(stratigraphyValue[0])
                    }
                })
            }

            this.commit(SET_WELLS_HORIZONS, newObject);
            this.commit(SET_SHOW_STRATIGRAPHY_ELEMENTS, toShow);
            state.tHorizon.drawSelectedPath(state.showStratigraphyElements);
            this.commit(SET_SCROLL_BLOCK_Y, Math.round(lastMD) - 100);
            state.AUTOCORRELATION = newObject;
        },

        [SET_SHOW_STRATIGRAPHY_ELEMENTS](state, stratigraphy) {
            state.showStratigraphyElements = stratigraphy;
            state.tHorizon.updateMaps();
        },

        [SET_FACIES_CLASSIFICATION_TO_ELEMENTS](state, [wellDataMnemonic, [well, model]]) {
            let curveName = `${well}_${model}`;
            let customMnemonic = {
                "well": well,
                "mnemonics": [{
                    "curve_id": curveName,
                    "name": model,
                    "depth_start": wellDataMnemonic.depth_start,
                    "depth_end": wellDataMnemonic.depth_end,
                    "step": wellDataMnemonic.step,
                }]
            }
            this.commit(SET_CURVES, {[curveName]:wellDataMnemonic.data});
            this.commit(SET_GIS_DATA, [customMnemonic]);
            this.commit(SET_SELECTED_WELL_CURVES, model);
            this.commit(SET_GIS_DATA_FOR_GRAPH);
        },

        [RESET_TIME_START_AUTOINTERPRETATION](state) {
            state.autoInterpretation.isActive = false;
            state.autoInterpretation.calculation_id = null;
            state.autoInterpretation.currentTime = Date.now();
            state.autoInterpretation.startTime = null;
            state.autoInterpretation.endTime = null;
            state.autoInterpretation.scoreboard = `00:00`;
        },
        [SET_TIME_START_AUTOINTERPRETATION](state, calculation_id) {
            state.autoInterpretation.isActive = true;
            state.autoInterpretation.calculation_id = calculation_id;
            state.autoInterpretation.currentTime = Date.now();
            state.autoInterpretation.startTime = new Date();
            state.autoInterpretation.endTime = new Date(state.autoInterpretation.currentTime + state.autoInterpretation.minutesToAdd*60000);
        },
        [SET_CURRENT_TIME_AUTOINTERPRETATION](state, [time = false, scoreboard = false]){
            state.autoInterpretation.currentTime = time||Date.now();
            if(scoreboard) state.autoInterpretation.scoreboard = scoreboard;
        }
    },

    actions: {
        [RUN_TIMER]({state, getters, commit, dispatch}){
            const two = (num)=> ((num<10)?`0${num}`:num);
            let minutes, seconds;
            let difference = (new Date(state.autoInterpretation.endTime) - new Date(state.autoInterpretation.currentTime)) / 1000;
            let timer = setInterval(async ()=>{
                difference--;
                if(getters[CHECK_TIMER]){
                    minutes = two(Math.floor(difference / 60));
                    seconds = two(Math.trunc((difference - minutes * 60))).toString();
                    if(seconds === state.autoInterpretation.updateInterval) await dispatch(CHECK_INTERPRETATION);
                    commit(SET_CURRENT_TIME_AUTOINTERPRETATION, [false, `${minutes}:${seconds}`]);
                }else{
                    commit(RESET_TIME_START_AUTOINTERPRETATION);
                    clearInterval(timer);
                }
            }, 1000);
        },

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

        async [FETCH_AUTOCORRELATION]({commit, state}, payload) {
            try {
                commit(SET_AUTOCORRELATION, [await Fetch_Autocorrelation(payload), payload]);
            } catch (e) {
                console.log('e', e);
            }
        },

        async [FETCH_FACIES_CLASSIFICATION]({commit, state}, payload) {
            let results = await Fetch_FaciesClassification(payload).catch(error=>error)
            commit(SET_FACIES_CLASSIFICATION_TO_ELEMENTS, [results, payload]);
            return results
        },

        async [POST_HORIZON]({commit, state}, payload) {
            return await Post_Horizons(payload);
        },

        async [CHECK_INTERPRETATION]({state, commit}){
            if(state.autoInterpretation.calculation_id)
                return Get_InterpretationStatus(state.autoInterpretation.calculation_id).then(()=>{
                    commit(RESET_TIME_START_AUTOINTERPRETATION);
                })
        },

        async [POST_INTERPRETATION]({commit, state, dispatch}, payload) {
            let result = await Post_Interpretation(payload)||{calculation_id:""};
            commit(SET_TIME_START_AUTOINTERPRETATION, result.calculation_id);
            dispatch(RUN_TIMER);
            return result;
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
let wellEl = [];

function mnemonicsSort(data, state) {
    // TODO ???????????????????? ?? ???????????????????? ??????.
    for (let datum of data) {
        if (datum.hasOwnProperty("mnemonics")) {
            wellID = datum.well;
            wellEl = [];
            mnemonicsSort.apply(this, [datum.mnemonics, state]);
        } else {
            let {name, curve_id, depth_start, depth_end, step} = datum;
            let groupId = uuidv4();
            if (!wellEl.includes(name)) wellEl.push(name);
            if (!groupsIds.has(name)) {
                groupsIds.set(name, groupId);
                this.addGroup(groupId, {
                    id: groupId, name: name, value: name, iconType: 'oilTower', iconFill: '#FF6600', isOpen: true,
                });
            }

            if (this.hasElement(name)) {
                state.awGis.editPropertyElementData(name, 'data', [['wellID', (wellIDS) => {
                    if (!wellIDS.includes(wellID)) wellIDS.push(wellID);
                    return wellIDS;
                }], ['curve_id', (elCurveIDS) => {
                    if (!elCurveIDS.hasOwnProperty(wellID.toString())) elCurveIDS[wellID.toString()] = curve_id;
                    return elCurveIDS;
                }], ['depth_start', (d_start) => {
                    if (!d_start.hasOwnProperty(wellID.toString())) d_start[wellID.toString()] = depth_start;
                    return d_start;
                }], ['depth_end', (d_end) => {
                    if (!d_end.hasOwnProperty(wellID.toString())) d_end[wellID.toString()] = depth_end;
                    return d_end;
                }], ['step', (d_step) => {
                    if (!d_step.hasOwnProperty(wellID.toString())) d_step[wellID.toString()] = step;
                    return d_step;
                }]]);
            } else {
                let curveColor = COLOR_PALETTE.curves, hex;
                if (curveColor.hasOwnProperty(name.toLowerCase())) {
                    let [r, g, b] = curveColor[name.toLowerCase()];
                    hex = "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
                    CURVE_ELEMENT_OPTIONS.customParams = {
                        ...CURVE_ELEMENT_OPTIONS.customParams,
                        curveColor: COLOR_PALETTE.curves.hasOwnProperty(name.toLowerCase()) ? {
                            use: true, value: hex
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
    state.wellsElementsMap.set(wellID, [...(state.wellsElementsMap.get(wellID)||[]),...wellEl]);
    return this.getGroupsWithData;
}

function componentToHex(c) {
    let hex = c.toString(16);
    return hex.length === 1 ? "0" + hex : hex;
}

export default geologyGis;
