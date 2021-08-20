export const pgnoGetters = {
    curveSettingsStore: (state) => state.curveSettings,
    steelMarkStore: (state) => {
        if (state.shgnSettings.corrosion === "highCorrosion" || state.shgnSettings.corrosion === "mediumCorrosion") {
            return []
        } else {
            return state.shgnSettings.steelMark
        }
    },
}