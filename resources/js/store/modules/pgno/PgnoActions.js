import axios from 'axios'

export const pgnoActions = {
    async sethPumpValue({ commit }, payload) {
        return commit("SET_HPUMP", payload)
    },
    setEconomic({ commit }, payload) {
        commit("SET_ECONOMIC", payload)
    },
    setSensetiveSettings({ commit }, payload) {
        commit("SET_SENSETIVE_SETTINGS", payload)
    },
    setShgnSettings({ commit }, payload) {
        commit("UPDATE_SHGN_SETTINGS", payload);
    },
    setDefaultShgnSettings({ commit }, payload) {
        commit("UPDATE_DEFAULT_SHGN_SETTINGS", payload);
    },
    setCurveSettings({ commit }, payload) {
        commit("UPDATE_CURVE_SETTINGS", payload);
    },
    setAnalysisSettings({ commit }, payload) {
        commit("UPDATE_ANALYSIS_SETTINGS", payload);
    },
    updateWell({ commit }, payload) {
        commit("SET_LINES", payload.linesAnalysis)
        commit("SET_POINTS", payload.pointsAnalysis)
    },
    setKpodSettings({ commit }, payload) {
        commit("SET_KPOD_SETTINGS", payload)
    },
    setEditing({ commit }, payload) {
        commit("SET_EDITING", payload)
    },
    setIntervals({ commit }, payload) {
        commit("SET_INTERVALS", payload)
    },
    setCentralizersResult({ commit }, payload){
        commit("SET_CENTRALIZER_RESULT", payload)
    },
    async setDefault({ commit }) {
        commit("SET_POST_RESPONSE_DATA", {})
        commit("SET_WELL", {})
        commit("SET_LINES", {})
        commit("SET_POINTS", {})
        commit("SET_WELL_ANALYSIS", {})
        commit("SET_LINES_ANALYSIS", {})
        commit("SET_POINTS_ANALYSIS", {})
        commit("UPDATE_CURVE_SETTINGS", {})
        commit("SET_CENTRALIZER_RESULT", {
            data: {},
            result:[[null, "Ø 19 мм", "Ø 22 мм", "Ø _ мм"],
            ["С центратом", 0, 0, 0],
            ["Без центратом", 0, 0, 0],
            ["Всего", 0, 0, 0]]})
        commit("SET_CENTRALIZER_SETTINGS", {
            hasRotarTableElevation: false,
            rotarTableElevation: 0,
            hasLowerRod: false,
            lowerRod: null,
            hasCentralizer: true,
            hasRequiredIntervals:true,
            requiredRanges: [],
            hasRecommendedIntervals: true,
            recommendedRanges: [],
            hasAbrasionIntervals: true,
            pumpAccuracy: 0,
            intervalCombining: 0,
            abrasionIntervals: {
              row1: {
                value1: null,
                value2: null,
              },
              row2: {
                value1: null,
                value2: null,
              },
              row3: {
                value1: null,
                value2: null,
              },
              row4: {
                value1: null,
                value2: null,
              },
              row5: {
                value1: null,
                value2: null,
              },
            },
          },)
        commit("UPDATE_ANALYSIS_SETTINGS", {
            analysisOld: [
                "analysisOldPres",
                "analysisOldHdyn",
                "analysisOldBhp",
                "analysisOldQlAsma",
                "analysisOldWctAsma",
                "analysisOldGorAsma",],
            analysisNew: [
                "analysisNewPres",
                "analysisNewPi",
                "analysisNewBhp",
            ],
            nearDist: 1000,
            hasGrp: false,
        })
        commit("SET_SETTINGS_MODE", "getDefault")
        commit("SET_MAIN_SETTINGS", {
            isSkError: false,
            isEditing: false,
            activeRightTabName: "techmode",
            isVisibleChart: true,
        })
        commit("SET_SENSETIVE_SETTINGS", {
            option1: {
                name: null,
                value1: null,
                value2: null,
                value3: null,
            },

            option2: {
                name: null,
                value1: null,
                value2: null,
                value3: null,
            },
            option3: {
                name: null,
                value1: null,
                value2: null,
                value3: null,
            },
        })

        return
    },
    async getWell({ commit }, payload) {
        return axios.get(payload).then((response) => {
            let data = response.data
            commit("SET_WELL", data['well_data'])
            commit("SET_LINES", data['lines'])
            commit("SET_POINTS", data['points'])
        }).catch(function (error) {
            console.error("oops, something went wrong!", error);
        })
    },
    async postWell({ commit }, payload) {
        return axios.post(payload.url, payload.data).then((response) => {
            let data = response.data
            commit("SET_POST_RESPONSE_DATA", data['well_data'])
            commit("SET_LINES", data['lines'])
            commit("SET_POINTS", data['points'])
            return true
        }).catch(function (error) {
            console.error("oops, something went wrong!", error);
            return false
        })
    },
    async postAnalysis({ commit }, payload) {
        return axios.post(payload.url, payload.data).then((response) => {
            let data = response.data
            commit("SET_WELL_ANALYSIS", data['well_data'])
            commit("SET_LINES_ANALYSIS", data['lines'])
            commit("SET_POINTS_ANALYSIS", data['points'])
            if (data['near_wells']) {
                commit("SET_NEAR_WELLS", data['near_wells'])
            }
        }).catch(function (error) {
            console.error("oops, something went wrong!", error);
        })
    },
    async getInclinometry({ commit }, payload) {
        return axios.post(payload.url, payload.data).then((response) => {
            let data = response.data
            commit("SET_INCLINOMETRY", data['inclinometry'])
            commit("SET_CENTRALIZER", data['centralizer'])
            commit("SET_CENTRALIZER_RANGE", data['centralizer_range'])
        }).catch(function (error) {
            console.error("oops, something went wrong!", error);
        })
    },
}