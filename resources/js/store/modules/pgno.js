import axios from 'axios'

const pgno = {
    state: {
        wells: [],
        // wellType: '',
        wellNum: '',
        wellNumber: '',
        hPump: null,
        buttonHpump: false
    },
    
    mutations: {
      UPDATE_MESSAGE(state, payload) {
        payload = state.wells
      },
      SET_WELLS_NUM(state, payload) {
        payload = state.wellNum
      },
      UPDATE_HPUMP(state, payload) {
        state.hPump = payload
      },
      UPDATE_HPUMP_BUTTON(state, payload) {
        state.buttonHpump = payload
      }
      // SET_WELLS_TYPE(state, wellType) {
      //   state.wellType = wellType
      // }
    },
    
    actions: {
        loadWells({commit}) {
            axios
                .get('http://172.20.103.187:7575/api/pgno/UZN/')
                .then(data => {
                    console.log(data.data, 'vuex work');
                    let wells = data. data
                    commit('SET_WELLS', wells)
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getHpumpValue({commit}) {
          commit = this.hPump
        },
        getHpumpButton({commit}) {
          commit = this.buttonHpump
        }
        
    },
    
    getters: {
      getHpump: (state) => state.hPump,
      getHpumpButton: (state) => state.buttonHpump
    },
}

export default pgno;