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
        pump27: false,
        pump32: false,
        pump38: false,
        pump44: false,
        pump50: false,
        pump57: false,
        pump60: false,
        pump70: false,
        pump95: false,
    },
    
    mutations: {
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

      UPDATE_PUMP_27: (state, val) => {
        state.pump27 = val
      },
      UPDATE_PUMP_32: (state, val) => {
        state.pump32 = val
      },
      UPDATE_PUMP_38: (state, val) => {
        state.pump38 = val
      },
      UPDATE_PUMP_44: (state, val) => {
        state.pump44 = val
      },
      UPDATE_PUMP_50: (state, val) => {
        state.pump50 = val
      },
      UPDATE_PUMP_57: (state, val) => {
        state.pump57 = val
      },
      UPDATE_PUMP_60: (state, val) => {
        state.pump60 = val
      },
      UPDATE_PUMP_70: (state, val) => {
        state.pump70 = val
      },
      UPDATE_PUMP_95: (state, val) => {
        state.pump95 = val
      },
      UPDATE_GROUP_POSAD(state, val) {
        state.groupPosad = val
      },
      UPDATE_YAKOR(state, val) {
        state.yakor = val
      },
      UPDATE_PAKER(state, val) {
        state.paker = val
      },
      UPDATE_HVOSTOVIK(state, val) {
        state.hvostovik = val
      },

      
      UPDATE_HPUMP(state, payload) {
        state.hPump = payload
      },
    },
    
    actions: {},
    
    getters: {
      pump27: (state) => state.pump27,
      pump32: (state) => state.pump32,
      pump38: (state) => state.pump38,
      pump44: (state) => state.pump44,
      pump50: (state) => state.pump50,
      pump57: (state) => state.pump57,
      pump60: (state) => state.pump60,
      pump70: (state) => state.pump70,
      pump95: (state) => state.pump95,
      kpodMin: (state) => state.kpodMin,
      spmMin: (state) => state.spmMin,
      spmMax: (state) => state.spmMax,
      strokeLenMin: (state) => state.strokeLenMin,
      strokeLenMax: (state) => state.strokeLenMax,
      groupPosad: (state) => state.groupPosad,
      yakor: (state) => state.yakor,
      paker: (state) => state.paker,
      hvostovik: (state) => state.hvostovik,
      hPump: (state) => state.hPump,
    },
}

export default pgno;