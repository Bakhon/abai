export const pgnoMutations = {
    CLEAR(state, value) {
        state = {}
    },
    SET_HPUMP(state,value){
        state.curveSettings.hPumpValue = value
    },
    SET_MAIN_SETTINGS(state,value){
        state.mainSettings = value
    },
    SET_SENSETIVE_SETTINGS(state,value){
        state.sensetiveSettings = value
    },
    SET_KPOD_SETTINGS(state,value){
        state.kPodSettings = value
    },
    SET_SETTINGS_MODE(state, value){
        state.settingsMode = value
    },
    SET_ECONOMIC(state, value) {
        state.expAnalysisData = value
    },
    SET_NEAR_WELLS(state,value){
        state.nearWells = value
    },
    SET_WELL(state, value) {
        state.well = value
    },
    SET_LINES(state, value) {
        state.lines = value
    },
    SET_POINTS(state, value) {
        state.points = value
    },
    SET_WELL_ANALYSIS(state, value) {
        state.wellAnalysis = value
    },
    SET_LINES_ANALYSIS(state, value) {
        state.linesAnalysis = value
    },
    SET_POINTS_ANALYSIS(state, value) {
        state.pointsAnalysis = value
    },

    SET_POST_RESPONSE_DATA(state, value) {
        state.calcedWell = value
    },

    UPDATE_SHGN_SETTINGS(state, val) {
        state.shgnSettings = val
    },
    UPDATE_DEFAULT_SHGN_SETTINGS(state, val) {
        state.shgnSettingsDefault = val
    },
    UPDATE_CURVE_SETTINGS(state, val) {
        state.curveSettings = val
    },
    UPDATE_ANALYSIS_SETTINGS(state, val) {
        state.analysisSettings = val
    },
    UPDATE_KPOD_CALCED(state, val) {
        state.shgnSettings.kPodCalced = val
    },
    SET_INCLINOMETRY(state, val) {
        state.inclinometry = val
    },
    SET_CENTRALIZER(state, val) {
        state.centralizer = val
    },
    SET_CENTRALIZER_RANGE(state, val) {
        state.centralizer_range = val
    },

    SET_EDITING(state, val) {
        state.isEditing = val
    },
    SET_INTERVALS(state, val) {
        state.isIntervals = val
    }
}