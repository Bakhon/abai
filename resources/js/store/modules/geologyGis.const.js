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

//actions
export const FETCH_GIS_DATA = 'geology/action/petrophysics/FETCH_GIS_DATA';
export const FETCH_DZOS = 'geology/action/petrophysics/FETCH_DZOS';
export const FETCH_FIELDS = 'geology/action/petrophysics/FETCH_FIELDS';
export const FETCH_WELLS = 'geology/action/petrophysics/FETCH_WELLS';
export const FETCH_WELLS_MNEMONICS = 'geology/action/petrophysics/FETCH_WELLS_MNEMONICS';
export const FETCH_WELLS_CURVES = 'geology/action/petrophysics/FETCH_WELLS_CURVES';
export const FETCH_WELLS_HORIZONS = 'geology/action/petrophysics/FETCH_WELLS_HORIZONS';
export const FETCH_AUTOCORRELATION = 'geology/action/petrophysics/FETCH_AUTOCORRELATION';

export const POST_HORIZON = 'geology/action/petrophysics/POST_HORIZON';

//Other
export const CANVAS_DASH_LINES_TYPES = {
    'Normal': [],
    'Dash 1': [1, 1],
    'Dash 2': [10, 10],
    'Dash 3': [20, 5],
    'Dash 4': [15, 3, 3, 3],
    'Dash 5': [20, 3, 3, 3, 3, 3, 3, 3]
}

export const COLOR_PALETTE = {
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
