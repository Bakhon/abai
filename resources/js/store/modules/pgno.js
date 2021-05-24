import axios from 'axios'

const pgno = {
    state: {
        wells: [],
        wellType: '',
        wellNumber: '',
        hPump: null,
        buttonHpump: false,
    },
    
    mutations: {
      UPDATE_MESSAGE(state, payload) {
        payload = state.wells
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
      getWellNumber: (state) => state.wellNumber,
      WELLDATA: (state) => state.wellData,
      getHpump: (state) => state.hPump,
      getHpumpButton: (state) => state.buttonHpump
    },
}

export default pgno;