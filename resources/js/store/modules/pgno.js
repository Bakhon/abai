import axios from 'axios'

const pgno = {
    state: {
        wells: [],
        wellType: '',
        wellNumber: '',
        hPump: null,
        buttonHpump: false,
        spmMin: 3,
        spmMax: 8,
        strokeLenMin: 2,
        strokeLenMax: 3,
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
      

      UPDATE_MESSAGE(state, payload) {
        state.wells = payload
      },
      SET_WELL_NUMBER(state, payload) {
        state.wellNumber = payload
      },
      UPDATE_HPUMP(state, payload) {
        state.hPump = payload
      },
      UPDATE_HPUMP_BUTTON(state, payload) {
        state.buttonHpump = payload
      },
      SET_WELLS_TYPE(state, wellType) {
        state.wellType = wellType
      },
      SET_WELL_NUM(state, wellType) {
        state.wellType = wellType
      },
      updateWellNumber(state, wellNumber) {
        state.obj.wellNumber = wellNumber
        console.log(wellNumber);
      }
    },
    
    actions: {
        loadWells({commit}) {
          commit('SET_WELLS_NUMBER', wellNumber)
          if(this.wellNumber) {
            axios
                .get('http://172.20.103.187:7575/api/pgno/UZN/' + this.wellNumber)
                .then(data => {
                    console.log(data.data, 'vuex work');
                    // let wells = data.data
                    // commit('SET_WELLS_TYPE', wells)
                    // commit('SET_WELLS_NUM', getWellNumber)
                })
                .catch(error => {
                    console.log(error);
                })
          } else {
            return console.log('no number')
          }
        },
        getHpumpValue({commit}) {
          commit = this.hPump
        },
        getHpumpButton({commit}) {
          commit = this.buttonHpump
        },
        getWellNumber({commit}) {
          commit = this.wellNumber
        }
        
    },
    
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
      spmMin: (state) => state.spmMin,
      spmMax: (state) => state.spmMax,
      strokeLenMin: (state) => state.strokeLenMin,
      strokeLenMax: (state) => state.strokeLenMax,
      getWellNumber: (state) => state.wellNumber,
      WELLDATA: (state) => state.wellData,
      getHpump: (state) => state.hPump,
      getHpumpButton: (state) => state.buttonHpump
    },
}

export default pgno;