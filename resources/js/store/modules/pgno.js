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
        koroz: "srednekor",
        dmPumps: ["32", "38", "44", "57", "70"],
        dmRods: ["19", "22", "25"],
        komponovka: ["hvostovik"],
        stupColumns: "2",
        selectedMarkShtang: [],
        markShtangs: [
          {
            mValue: 1,
            tempValue: "40 (Н)",
          },
          {
            mValue: 2,
            tempValue: "40 (НсУ)",
          },
          {
            mValue: 3,
            tempValue: "14Х3ГМЮ (НВО)",
          },
          {
            mValue: 4,
            tempValue: "15НЗМА (Н)",
          },
          {
            mValue: 5,
            tempValue: "15НЗМА (НсУ)",
          },
          {
            mValue: 6,
            tempValue: "15Х2ГМФ (НВО)",
          },
          {
            mValue: 7,
            tempValue: "15Х2НМФ (НВО)",
          },
          {
            mValue: 8,
            tempValue: "20Н2М (Н)",
          },
          {
            mValue: 9,
            tempValue: "20Н2М (НсУ)",
          },
          {
            mValue: 10,
            tempValue: "30ХМ(А) (НсУ)",
          },
          {
            mValue: 11,
            tempValue: "АЦ28ХГНЗФТ (О)",
          },
          ],
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
        state.selectedMarkShtang = val
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
      UPDATE_HPUMP(state, payload) {
        state.hPump = payload
      },
      UPDATE_KOROZ(state, payload) {
        state.koroz = payload
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
        commit("UPDATE_KOROZ", "srednekor")
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
      selectedMarkShtang: (state) => state.selectedMarkShtang,
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
      koroz: (state) => state.koroz,
      stupColumns: (state) => state.stupColumns,
      h2s: (state) => state.h2s,
      heavyDown: (state) => state.heavyDown
    },
}

export default pgno;