import axios from 'axios'

const pgno = {
    state: {
        hPump: null,
        spmMin: 3,
        spmMax: 8,
        strokeLenMin: 2,
        strokeLenMax: 3,
        kpodMin: 0.6,
        pintakeMin: 30,
        gasMax: 10,
        inclStep: 10,
        groupPosad: 2,
        h2s: false,
        heavyDown: true,
        corrosion: "mediumCorrosion",
        dmrPumps: ["32", "38", "44", "57", "70"],
        dmrRods: ["19", "22", "25"],
        komponovka: ["hvostovik"],
        stupColumns: "2",
        markShtang: "30ХМ(А) (НсУ)",
    },
    mutations: {
      UPDATE_HEAVYDOWN(state, val) {
        state.heavyDown = val
      },
      UPDATE_DMRPUMPS(state, val) {
        state.dmrPumps = val
      },
      UPDATE_DMRRODS(state, val) {
        state.dmrRods = val
      },
      UPDATE_MARKSHTANG(state, val) {
        state.markShtang = val
      },
      UPDATE_SPM_MIN: (state, val) => {
        state.spmMin = val
      },
      UPDATE_SPM_MAX: (state, val) => {
        state.spmMax = val
      },
      UPDATE_LEN_MIN: (state, val) => {
        state.strokeLenMin = val
      },
      UPDATE_LEN_MAX: (state, val) => {
        state.strokeLenMax = val
      },
      UPDATE_PINTAKE_MIN: (state, val) => {
        state.pintakeMin = val
      },
      UPDATE_GAS_MAX: (state, val) => {
        state.gasMax = val
      },
      UPDATE_INCL_STEP: (state, val) => {
        state.inclStep = val
      },
      UPDATE_H2S: (state, val) => {
        state.h2s = val
      },
      UPDATE_STUP_COLUMNS: (state, val) => {
        state.stupColumns = val
      },
      UPDATE_KPOD: (state, val) => {
        state.kpodMin = val
      },
      UPDATE_GROUP_POSAD(state, val) {
        state.groupPosad = val
      },
      UPDATE_KOMPONOVKA(state, val) {
        state.komponovka = val
      },
      UPDATE_HPUMP(state, val) {
        state.hPump = val
      },
      UPDATE_CORROSION(state, val) {
        state.corrosion = val
      }
    },
    
    actions: {
      setDefault({commit}) {
        commit("UPDATE_SPM_MIN", 3)
        commit("UPDATE_SPM_MAX", 8)
        commit("UPDATE_LEN_MIN", 2)
        commit("UPDATE_LEN_MAX", 3)
        commit("UPDATE_KPOD", 0.6)
        commit("UPDATE_KOMPONOVKA", ["hvostovik"])
        commit("UPDATE_DMRPUMPS", ["32", "38", "44", "57", "70"])
        commit("UPDATE_DMRRODS", ["19", "22", "25"])
        commit("UPDATE_H2S", false)
        commit("UPDATE_DAV_MIN", 30)
        commit("UPDATE_GAS_MAX", 10)
        commit("UPDATE_DLINA_POLKI", 10)
        commit("UPDATE_CORROSION", "mediumCorrosion")
        commit("UPDATE_GROUP_POSAD", "2")
        commit("UPDATE_HEAVYDOWN", true)
      },
      setDmrPumps({commit}, value) {
        commit('UPDATE_DMRPUMPS', value)
      },
      setDmrRods({commit}, value) {
        commit('UPDATE_DMRRODS', value)
      },
      setKomponovka({commit}, value) {
        commit('UPDATE_KOMPONOVKA', value)
      },
      setH2S({commit}, value) {
        commit('UPDATE_H2S', value)
      },
      setheavyDown({commit}, value) {
        commit('UPDATE_HEAVYDOWN', value)
      },
      selectedMarkShtang({commit}, value) {
        commit('UPDATE_MARKSHTANG', value)
      }
    },
    
    getters: {
      markShtang: (state) => state.markShtang,
      dmrPumps: (state) => state.dmrPumps,
      dmrRods: (state) => state.dmrRods,
      komponovka: (state) => state.komponovka,
      kpodMin: (state) => state.kpodMin,
      spmMin: (state) => state.spmMin,
      spmMax: (state) => state.spmMax,
      strokeLenMin: (state) => state.strokeLenMin,
      strokeLenMax: (state) => state.strokeLenMax,
      pintakeMin: (state) => state.pintakeMin,
      gasMax: (state) => state.gasMax,
      inclStep: (state) => state.inclStep,
      groupPosad: (state) => state.groupPosad,
      hPump: (state) => state.hPump,
      corrosion: (state) => state.corrosion,
      stupColumns: (state) => state.stupColumns,
      h2s: (state) => state.h2s,
      heavyDown: (state) => state.heavyDown
    },
}

export default pgno;