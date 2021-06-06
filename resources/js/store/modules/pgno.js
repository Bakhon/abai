import axios from 'axios'

const pgno = {
    state: {
        hPump: null,
        spmMin: null,
        spmMax: null,
        strokeLenMin: null,
        strokeLenMax: null,
        kpodMin: null,
        groupPosad: null,
        yakor: false,
        paker: false,
        hvostovik: false,
        dmPumps: ["32", "38", "44", "57", "70"],
        dmRods: ["19", "22", "25"],
        komponovka: ["hvostovik"],
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
    },
    
    actions: {
      setDmPumps({commit}, value) {
        commit('UPDATE_DMPUMPS', value)
      },
      setDmRods({commit}, value) {
        commit('UPDATE_DMRODS', value)
      },
      setKomponovka({commit}, value) {
        commit('UPDATE_KOMPONOVKA', value)
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
      groupPosad: (state) => state.groupPosad,
      hPump: (state) => state.hPump,
    },
}

export default pgno;