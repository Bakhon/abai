import axios from 'axios'

const pgno = {
    state: {
        hPump: null,
        spmMin: null,
        spmMax: null,
        strokeLenMin: null,
        strokeLenMax: null,
        kpodMin: null,
        davMin: null,
        gasMax: null,
        dlinaPolki: null,
        groupPosad: null,
        h2s: false,
        heavyDown: true,
        corrosion: "mediumCorrosion",
        dmPumps: ["32", "38", "44", "57", "70"],
        dmRods: ["19", "22", "25"],
        komponovka: ["hvostovik"],
        stupColumns: "2",
        markShtang: "30ХМ(А) (НсУ)",
    },
    mutations: {
      UPDATE_HEAVYDOWN(state, val) {
        state.heavyDown = val
      },
      UPDATE_DMPUMPS(state, val) {
        state.dmPumps = val
      },
      UPDATE_DMRODS(state, val) {
        state.dmRods = val
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
      UPDATE_DAV_MIN: (state, val) => {
        state.davMin = val
      },
      UPDATE_GAS_MAX: (state, val) => {
        state.gasMax = val
      },
      UPDATE_DLINA_POLKI: (state, val) => {
        state.dlinaPolki = val
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
        commit("UPDATE_DMPUMPS", ["32", "38", "44", "57", "70"])
        commit("UPDATE_DMRODS", ["19", "22", "25"])
        commit("UPDATE_H2S", false)
        commit("UPDATE_DAV_MIN", 30)
        commit("UPDATE_GAS_MAX", 10)
        commit("UPDATE_DLINA_POLKI", 10)
        commit("UPDATE_CORROSION", "mediumCorrosion")
        commit("UPDATE_GROUP_POSAD", "2")
        commit("UPDATE_HEAVYDOWN", true)
      },
      setDmPumps({commit}, value) {
        commit('UPDATE_DMPUMPS', value)
      },
      setDmRods({commit}, value) {
        commit('UPDATE_DMRODS', value)
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
      dmPumps: (state) => state.dmPumps,
      dmRods: (state) => state.dmRods,
      komponovka: (state) => state.komponovka,
      kpodMin: (state) => state.kpodMin,
      spmMin: (state) => state.spmMin,
      spmMax: (state) => state.spmMax,
      strokeLenMin: (state) => state.strokeLenMin,
      strokeLenMax: (state) => state.strokeLenMax,
      davMin: (state) => state.davMin,
      gasMax: (state) => state.gasMax,
      dlinaPolki: (state) => state.dlinaPolki,
      groupPosad: (state) => state.groupPosad,
      hPump: (state) => state.hPump,
      corrosion: (state) => state.corrosion,
      stupColumns: (state) => state.stupColumns,
      h2s: (state) => state.h2s,
      heavyDown: (state) => state.heavyDown
    },
}

export default pgno;