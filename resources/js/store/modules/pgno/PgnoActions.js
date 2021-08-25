import axios from 'axios'

export const pgnoActions = {
    async sethPumpValue({ commit }, payload){
        return commit("SET_HPUMP", payload)
    },
    setEconomic({ commit }, payload){
        commit("SET_ECONOMIC", payload)
    },
    setShgnSettings({ commit }, payload) {
        commit("UPDATE_SHGN_SETTINGS", payload);
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
    setKpodSettings({ commit }, payload){
        commit("SET_KPOD_SETTINGS", payload)
    },
    setEditing({ commit }, payload){
        commit("SET_EDITING", payload)
    },
    setIntervals({ commit }, payload){
        commit("SET_INTERVALS", payload)
    },
    async setDefault({ commit }, payload) {
        commit("CLEAR", {})
        commit("SET_POST_RESPONSE_DATA", {})
        commit("SET_WELL", {})
        commit("SET_LINES", {})
        commit("SET_POINTS", {})
        commit("SET_WELL_ANALYSIS", {})
        commit("SET_LINES_ANALYSIS", {})
        commit("SET_POINTS_ANALYSIS", {})
        commit("UPDATE_CURVE_SETTINGS", {})
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
        if (payload === "setWell") {
            commit("UPDATE_SHGN_SETTINGS", {
                spmMin: 3,
                spmMax: 8,
                strokeLenMin: 2.5,
                strokeLenMax: 3,
                kpodMin: 0.6,
                pintakeMin: 30,
                gasMax: 10,
                inclStep: 10,
                groupPosad: 2,
                h2s: false,
                heavyDown: true,
                corrosion: "antiCorrosion",
                pumpTypes: ["32", "38", "44", "57", "70"],
                rodsTypes: ["19", "22"],
                komponovka: ["hvostovik"],
                stupColumns: "2",
                steelMark: ["С (API)", "D (API)", "15Х2ГМФ-D-sup"],
                kPodMode: true,
                kPodCalced: null,
            })
        }
        
        return
    },
    async getWell({ commit }, payload) {
        return axios.get(payload).then((response) => {
            let data = response.data
            commit("SET_WELL", data['well_data'])
            commit("SET_LINES", data['lines'])
            commit("SET_POINTS", data['points'])
        }).catch(function(error) {
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
        }).catch(function(error) {
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
      }).catch(function(error) {
        console.error("oops, something went wrong!", error);
      })
  },
    async getInclinometry({ commit }, payload) {
    return axios.post(payload.url, payload.data).then((response) => {
          let data = response.data
          commit("SET_INCLINOMETRY", data['inclinometry'])
          commit("SET_CENTRALIZER", data['centralizer'])
          commit("SET_CENTRALIZER_RANGE", data['centralizer_range'])
      }).catch(function(error) {
        console.error("oops, something went wrong!", error);
      })
  },
}