//getters
export const GET_GIS_DATA = 'geology/petrophysics/GET_GIS_DATA';
export const GET_TREE_CURVES = 'geology/petrophysics/GET_TREE_CURVES';
export const GET_WELLS_OPTIONS = 'geology/petrophysics/GET_WELLS_OPTIONS';
export const GET_FIELDS_OPTIONS = 'geology/petrophysics/GET_FIELDS_OPTIONS';
export const GET_DZOS_OPTIONS = 'geology/petrophysics/GET_DZOS_OPTIONS';
export const GET_GIS_GROUPS = 'geology/petrophysics/GET_GIS_GROUPS';
export const GET_CURVES = 'geology/petrophysics/GET_CURVES';
export const GET_TREE_STRATIGRAPHY = 'geology/petrophysics/GET_TREE_STRATIGRAPHY';

//mutations
export const SET_GIS_DATA = 'geology/mutation/petrophysics/SET_GIS_DATA';
export const SET_CURVE_NAME = 'geology/mutation/petrophysics/SET_CURVE_NAME';
export const SET_SELECTED_WELL_CURVES_FORCE = 'geology/mutation/petrophysics/SET_SELECTED_WELL_CURVES_FORCE';
export const SET_SELECTED_WELL_CURVES = 'geology/mutation/petrophysics/SET_SELECTED_WELL_CURVES';
export const SET_SCROLL_BLOCK_Y = 'geology/mutation/petrophysics/SET_SCROLL_BLOCK_Y';
export const SET_DZOS = 'geology/mutation/petrophysics/SET_DZOS';
export const SET_FIELDS = 'geology/mutation/petrophysics/SET_FIELDS';
export const SET_WELLS = 'geology/mutation/petrophysics/SET_WELLS';
export const SET_WELLS_BLOCKS = 'geology/mutation/petrophysics/SET_WELLS_BLOCKS';
export const SET_WELLS_MNEMONICS = 'geology/mutation/petrophysics/SET_WELLS_MNEMONICS';
export const SET_MNEMONICS_FOR_TREE = 'geology/mutation/petrophysics/SET_MNEMONICS_FOR_TREE';
export const SET_DRAG_PARAMS = 'geology/mutation/petrophysics/SET_DRAG_PARAMS';
export const SET_CURVES = 'geology/mutation/petrophysics/SET_CURVES';
export const SET_GIS_DATA_FOR_GRAPH = 'geology/mutation/petrophysics/SET_GIS_DATA_FOR_GRAPH';
export const SET_CURVE_OPTIONS = 'geology/mutation/petrophysics/SET_CURVE_OPTIONS';
export const SET_WELLS_HORIZONS = 'geology/mutation/petrophysics/SET_WELLS_HORIZONS';
export const SET_AUTOCORRELATION = 'geology/mutation/petrophysics/SET_AUTOCORRELATION';
export const SET_SHOW_STRATIGRAPHY_ELEMENTS = 'geology/mutation/petrophysics/SET_SHOW_STRATIGRAPHY_ELEMENTS';
export const SET_FACIES_CLASSIFICATION_TO_ELEMENTS = 'geology/mutation/petrophysics/SET_FACIES_CLASSIFICATION_TO_ELEMENTS';
export const SET_TIME_START_AUTOINTERPRETATION = 'geology/mutation/petrophysics/SET_TIME_START_AUTOINTERPRETATION';
export const SET_CURRENT_TIME_AUTOINTERPRETATION = 'geology/mutation/petrophysics/SET_CURRENT_TIME_AUTOINTERPRETATION';

//actions
export const FETCH_GIS_DATA = 'geology/action/petrophysics/FETCH_GIS_DATA';
export const FETCH_DZOS = 'geology/action/petrophysics/FETCH_DZOS';
export const FETCH_FIELDS = 'geology/action/petrophysics/FETCH_FIELDS';
export const FETCH_WELLS = 'geology/action/petrophysics/FETCH_WELLS';
export const FETCH_WELLS_MNEMONICS = 'geology/action/petrophysics/FETCH_WELLS_MNEMONICS';
export const FETCH_WELLS_CURVES = 'geology/action/petrophysics/FETCH_WELLS_CURVES';
export const FETCH_WELLS_HORIZONS = 'geology/action/petrophysics/FETCH_WELLS_HORIZONS';
export const FETCH_AUTOCORRELATION = 'geology/action/petrophysics/FETCH_AUTOCORRELATION';
export const FETCH_FACIES_CLASSIFICATION = 'geology/action/petrophysics/FETCH_FACIES_CLASSIFICATION';

export const POST_HORIZON = 'geology/action/petrophysics/POST_HORIZON';
export const POST_INTERPRETATION = 'geology/action/petrophysics/POST_INTERPRETATION';
export const CHECK_INTERPRETATION = 'geology/action/petrophysics/CHECK_INTERPRETATION';
export const RESET_TIME_START_AUTOINTERPRETATION = 'geology/action/petrophysics/RESET_TIME_START_AUTOINTERPRETATION';
export const CHECK_TIMER = 'geology/action/petrophysics/CHECK_TIMER';
export const RUN_TIMER = 'geology/action/petrophysics/RUN_TIMER';

//Other
export const CANVAS_DASH_LINES_TYPES = {
    'Normal': [],
    'Dash 1': [1, 1],
    'Dash 2': [10, 10],
    'Dash 3': [20, 5],
    'Dash 4': [15, 3, 3, 3],
    'Dash 5': [20, 3, 3, 3, 3, 3, 3, 3]
}

let GIS64 = [
    {name: "", color: 'rgba(0,0,0, 0)'},
    {name: "1", color: 'rgb(255,255,0)'},
    {name: "2", color: "rgb(255,165,0)"},
    {name: "3", color: "rgb(184,134,11)"},
    {name: "4", color: "rgb(139,69,19)", textColor: "white"},
    {name: "5", color: "rgb(128,128,128)", textColor: "white"},
]

export const COLOR_PALETTE = {
    "6gis":GIS64,
    "4gis": GIS64,
    "litho": [
        {name: "Глина", color: 'rgb(192,192,192)'},
        {name: "Песчаник", color: "rgb(255,255,0)"},
        {name: "Известняк", color: "rgb(0,0,255)"},
        {name: "Уголь", color: "rgb(0,0,0)", textColor: "white"},
    ],
    "fluid": [
        {name: "", color: 'rgba(0,0,0, 0)'},
        {name: "Вода", color: "rgb(0,255,255)"},
        {name: "Нефть", color: "rgb(0,190,0)"},
        {name: "Газ", color: "rgb(255,0,0)"},
    ],
    "curves": {
        "gr": [255,0,0],
        "lld": [0,0,255],
        "cali": [50, 205, 0],
        "rhob": [0, 0, 0],
        "nphi": [0, 0, 255],
        "dtco": [0, 190, 0],
        "sp": [255, 0, 255],
        "ngld": [0, 0, 255]
    }
}

export const CURVE_ELEMENT_OPTIONS = {
    customParams: {
        min: {use: false, value: ''},
        max: {use: false, value: ''},
        curveColor: {use: false, value: "#000000"},
        direction: {value: 'normal'},
        dash: {value: ''}
    }
}

export const STRATIGRAPHY_CONSTANTS_WITH_CODE = {
    Val:{
        "DTPGL":340,
        "RHOBGL":"2,3",
        "RHOBGL_num": 2.3,
        "Oxf_ngld":"1,05",
        "Oxf_ngld_num":1.05,
        "Val_ngld": "0,5127",
        "Val_ngld_num": 0.5127,
        "x": "-0,1833",
        "x_num": -0.1833,
        "y": "0,5633",
        "y_num": 0.5633,
        "RW": "0,034",
        "RW_num": 0.034,
        "PHIE_cut": "0,14",
        "PHIE_cut_num": 0.14,
        "VSH_fin_cut": "0,38",
        "VSH_fin_cut_num": 0.38,
        "GR_max": 140,
        "GR_min": 55,
        "SP_max": 90,
        "SP_min": 30,
    },
    12:{
        "DTPGL":340,
        "RHOBGL":"2,3",
        "RHOBGL_num": 2.3,
        "Oxf_ngld":"1,05",
        "Oxf_ngld_num":1.05,
        "Val_ngld": "0,5127",
        "Val_ngld_num": 0.5127,
        "x": "-0,1833",
        "x_num": -0.1833,
        "y": "0,5633",
        "y_num": 0.5633,
        "RW": "0,034",
        "RW_num": 0.034,
        "PHIE_cut": "0,14",
        "PHIE_cut_num": 0.14,
        "VSH_fin_cut": "0,38",
        "VSH_fin_cut_num": 0.38,
        "GR_max": 140,
        "GR_min": 55,
        "SP_max": 90,
        "SP_min": 30,
    },
    13:{
        "DTPGL":340,
        "RHOBGL":"2,3",
        "RHOBGL_num": 2.3,
        "Oxf_ngld":"1,05",
        "Oxf_ngld_num":1.05,
        "Val_ngld": "0,5127",
        "Val_ngld_num": 0.5127,
        "x": "-0,1833",
        "x_num": -0.1833,
        "y": "0,5633",
        "y_num": 0.5633,
        "RW": "0,034",
        "RW_num": 0.034,
        "PHIE_cut": "0,14",
        "PHIE_cut_num": 0.14,
        "VSH_fin_cut": "0,38",
        "VSH_fin_cut_num": 0.38,
        "GR_max": 140,
        "GR_min": 55,
        "SP_max": 90,
        "SP_min": 30,
    },
    14:{
        "DTPGL":340,
        "RHOBGL":"2,3",
        "RHOBGL_num": 2.3,
        "Oxf_ngld":"1,05",
        "Oxf_ngld_num":1.05,
        "Val_ngld": "0,5127",
        "Val_ngld_num": 0.5127,
        "x": "-0,1833",
        "x_num": -0.1833,
        "y": "0,5633",
        "y_num": 0.5633,
        "RW": "0,033",
        "RW_num": 0.033,
        "PHIE_cut": "0,14",
        "PHIE_cut_num": 0.14,
        "VSH_fin_cut": "0,38",
        "VSH_fin_cut_num": 0.38,
        "GR_max": 140,
        "GR_min": 55,
        "SP_max": 90,
        "SP_min": 30,
    },
    15:{
        "DTPGL":340,
        "RHOBGL":"2,3",
        "RHOBGL_num": 2.3,
        "Oxf_ngld":"1,05",
        "Oxf_ngld_num":1.05,
        "Val_ngld": "0,5127",
        "Val_ngld_num": 0.5127,
        "x": "-0,1833",
        "x_num": -0.1833,
        "y": "0,5633",
        "y_num": 0.5633,
        "RW": "0,032",
        "RW_num": 0.032,
        "PHIE_cut": "0,14",
        "PHIE_cut_num": 0.14,
        "VSH_fin_cut": "0,38",
        "VSH_fin_cut_num": 0.38,
        "GR_max": 140,
        "GR_min": 55,
        "SP_max": 90,
        "SP_min": 30,
    },
    16:{
        "DTPGL":340,
        "RHOBGL":"2,3",
        "RHOBGL_num": 2.3,
        "Oxf_ngld":"1,05",
        "Oxf_ngld_num":1.05,
        "Val_ngld": "0,5127",
        "Val_ngld_num": 0.5127,
        "x": "-0,1833",
        "x_num": -0.1833,
        "y": "0,5633",
        "y_num": 0.5633,
        "RW": "0,03",
        "RW_num": 0.03,
        "PHIE_cut": "0,14",
        "PHIE_cut_num": 0.14,
        "VSH_fin_cut": "0,38",
        "VSH_fin_cut_num": 0.38,
        "GR_max": 140,
        "GR_min": 55,
        "SP_max": 90,
        "SP_min": 30,
    },
    17:{
        "DTPGL":340,
        "RHOBGL":"2,3",
        "RHOBGL_num": 2.3,
        "Oxf_ngld":"1,05",
        "Oxf_ngld_num":1.05,
        "Val_ngld": "0,5127",
        "Val_ngld_num": 0.5127,
        "x": "-0,1833",
        "x_num": -0.1833,
        "y": "0,5633",
        "y_num": 0.5633,
        "RW": "0,029",
        "RW_num": 0.029,
        "PHIE_cut": "0,14",
        "PHIE_cut_num": 0.14,
        "VSH_fin_cut": "0,38",
        "VSH_fin_cut_num": 0.38,
        "GR_max": 140,
        "GR_min": 55,
        "SP_max": 90,
        "SP_min": 30,
    },
    18:{
        "DTPGL":340,
        "RHOBGL":"2,3",
        "RHOBGL_num": 2.3,
        "Oxf_ngld":"1,05",
        "Oxf_ngld_num":1.05,
        "Val_ngld": "0,5127",
        "Val_ngld_num": 0.5127,
        "x": "-0,1833",
        "x_num": -0.1833,
        "y": "0,5633",
        "y_num": 0.5633,
        "RW": "0,027",
        "RW_num": 0.027,
        "PHIE_cut": "0,14",
        "PHIE_cut_num": 0.14,
        "VSH_fin_cut": "0,38",
        "VSH_fin_cut_num": 0.38,
        "GR_max": 140,
        "GR_min": 55,
        "SP_max": 90,
        "SP_min": 30,
    },
    19:{
        "DTPGL":340,
        "RHOBGL":"2,3",
        "RHOBGL_num": 2.3,
        "Oxf_ngld":"1,05",
        "Oxf_ngld_num":1.05,
        "Val_ngld": "1,55",
        "Val_ngld_num": 1.55,
        "x": "-0,1833",
        "x_num": -0.1833,
        "y": "0,5633",
        "y_num": 0.5633,
        "RW": "0,027",
        "RW_num": 0.027,
        "PHIE_cut": "0,13",
        "PHIE_cut_num": 0.13,
        "VSH_fin_cut": "0,28",
        "VSH_fin_cut_num": 0.28,
        "GR_max": 140,
        "GR_min": 55,
        "SP_max": 90,
        "SP_min": 30,
    },
    20:{
        "DTPGL":340,
        "RHOBGL":"2,3",
        "RHOBGL_num": 2.3,
        "Oxf_ngld":"1,05",
        "Oxf_ngld_num":1.05,
        "Val_ngld": "1,55",
        "Val_ngld_num": 1.55,
        "x": "-0,1833",
        "x_num": -0.1833,
        "y": "0,5633",
        "y_num": 0.5633,
        "RW": "0,026",
        "RW_num": 0.026,
        "PHIE_cut": "0,13",
        "PHIE_cut_num": 0.13,
        "VSH_fin_cut": "0,28",
        "VSH_fin_cut_num": 0.28,
        "GR_max": 100,
        "GR_min": 55,
        "SP_max": 90,
        "SP_min": 30,
    },
    21:{
        "DTPGL":340,
        "RHOBGL":"2,3",
        "RHOBGL_num": 2.3,
        "Oxf_ngld":"1,05",
        "Oxf_ngld_num":1.05,
        "Val_ngld": "1,55",
        "Val_ngld_num": 1.55,
        "x": "-0,1833",
        "x_num": -0.1833,
        "y": "0,5633",
        "y_num": 0.5633,
        "RW": "0,025",
        "RW_num": 0.025,
        "PHIE_cut": "0,13",
        "PHIE_cut_num": 0.13,
        "VSH_fin_cut": "0,28",
        "VSH_fin_cut_num": 0.28,
        "GR_max": 100,
        "GR_min": 55,
        "SP_max": 90,
        "SP_min": 30,
    },
    22:{
        "DTPGL":340,
        "RHOBGL":"2,3",
        "RHOBGL_num": 2.3,
        "Oxf_ngld":"1,05",
        "Oxf_ngld_num":1.05,
        "Val_ngld": "1,55",
        "Val_ngld_num": 1.55,
        "x": "-0,1833",
        "x_num": -0.1833,
        "y": "0,5633",
        "y_num": 0.5633,
        "RW": "0,024",
        "RW_num": 0.024,
        "PHIE_cut": "0,13",
        "PHIE_cut_num": 0.13,
        "VSH_fin_cut": "0,28",
        "VSH_fin_cut_num": 0.28,
        "GR_max": 100,
        "GR_min": 55,
        "SP_max": 90,
        "SP_min": 30,
    },
    23:{
        "DTPGL":340,
        "RHOBGL":"2,3",
        "RHOBGL_num": 2.3,
        "Oxf_ngld":"1,05",
        "Oxf_ngld_num":1.05,
        "Val_ngld": "1,55",
        "Val_ngld_num": 1.55,
        "x": "-0,1833",
        "x_num": -0.1833,
        "y": "0,5633",
        "y_num": 0.5633,
        "RW": "0,023",
        "RW_num": 0.023,
        "PHIE_cut": "0,13",
        "PHIE_cut_num": 0.13,
        "VSH_fin_cut": "0,28",
        "VSH_fin_cut_num": 0.28,
        "GR_max": 100,
        "GR_min": 55,
        "SP_max": 90,
        "SP_min": 30,
    },
    24:{
        "DTPGL":340,
        "RHOBGL":"2,3",
        "RHOBGL_num": 2.3,
        "Oxf_ngld":"1,05",
        "Oxf_ngld_num":1.05,
        "Val_ngld": "1,55",
        "Val_ngld_num": 1.55,
        "x": "-0,1833",
        "x_num": -0.1833,
        "y": "0,5633",
        "y_num": 0.5633,
        "RW": "0,022",
        "RW_num": 0.022,
        "PHIE_cut": "0,13",
        "PHIE_cut_num": 0.13,
        "VSH_fin_cut": "0,28",
        "VSH_fin_cut_num": 0.28,
        "GR_max": 100,
        "GR_min": 55,
        "SP_max": 90,
        "SP_min": 30,
    },
}
