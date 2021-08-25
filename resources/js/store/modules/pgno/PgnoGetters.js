export const pgnoGetters = {
    shgnSettings: (state) => {
        if (state.settingsMode === "getDefault") {
            return state.shgnSettingsDefault
        } else {
            return state.shgnSettings
        }
    },
    curveSettingsStore: (state) => state.curveSettings,
    steelMarkStore: (state) => {
        if (state.shgnSettings.corrosion === "highCorrosion" || state.shgnSettings.corrosion === "mediumCorrosion") {
            return []
        } else {
            return state.shgnSettings.steelMark
        }
    },
}