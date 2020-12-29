export default {
  data: function () {
    return {
      t1:'',
      t2:'',
      t3:'',
      t4:'',
      t5:'',
      t6:'',
      tSum:'',
      dateStart: '',
      dateEnd: '',
      isEnableSpeedometers: false,
      isShowInteractiveBlock: false,
      isShowMainBlock: true,
      tableToShowId: 0,
      t2TableData: [],
      t3TableData: [],
      t4TableData: [],
      t5TableData: [],
    };
  },
  methods: {
    getDefaultData() {
      this.$store.commit('globalloading/SET_LOADING',true);
      this.axios
        .get('/ru/getdzocalcsactualmonth', {})
        .then(response => {
          if (response.data) {
            let dateStart = new Date(2020, 0, 1);
            let dateEnd = new Date(2020, response.data - 1, 1);
            dateEnd.setDate(0);
            dateEnd.setHours(23,59,59);
            this.dateStart = dateStart;
            this.dateEnd = dateEnd;
          }
        });
      this.axios
        .get('/ru/kpicalc', {})
        .then(response => {
          if (response.data) {
            // console.log((month_number; porog; tsel; vyzov; fact; formula1; formula2))
            // console.log((company_id; date; otklonenie ot tseli; otklonenie ot tseli %; vlianie na uluchshenie-uhudshenie))
            this.t1 = response.data['Marabayev1'][0];
            this.t2 = response.data['Marabayev2'][0];
            this.t2TableData = response.data['Marabayev2Table'];
            this.t3 = response.data['Marabayev3'][0];
            this.t3TableData = response.data['Marabayev3Table'];
            this.t4 = response.data['Marabayev4'][0];
            this.t4TableData = response.data['Marabayev4Table'];
            this.t5 = response.data['Marabayev5'][0];
            this.t5TableData = response.data['Marabayev5Table'];
            this.tSum = response.data['Marabayev1'][0][6] +
              response.data['Marabayev2'][0][6] + response.data['Marabayev3'][0][6] +
              response.data['Marabayev4'][0][6] + response.data['Marabayev5'][0][6];
            this.t6 = [1, 0, 5, 10, 10, 0];
            this.isEnableSpeedometers = true;
          }
          this.$store.commit('globalloading/SET_LOADING',false);
        });
    },
    changeTable(tableId) {
      this.isShowInteractiveBlock = true;
      this.isShowMainBlock = false;
      this.tableToShowId = tableId;
    },
    closeTable() {
      this.isShowMainBlock = true;
      this.isShowInteractiveBlock = false;
      this.tableToShowId = 0;
    }
  },
  async mounted() {
    this.getDefaultData();
  }
}