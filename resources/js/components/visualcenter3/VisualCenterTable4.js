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
            this.t1 = response.data['CorpAll1'][0];
            this.t2 = response.data['CorpAll2'][0];
            this.t3 = response.data['CorpAll3'][0];
            this.t4 = response.data['CorpAll4'][0];
            this.t5 = response.data['CorpAll5'][0];
            this.t6 = response.data['CorpAll6'][0];
            this.tSum = response.data['CorpAll1'][0][6] +
              response.data['CorpAll2'][0][6] + response.data['CorpAll3'][0][6] +
              response.data['CorpAll4'][0][6] + response.data['CorpAll5'][0][6] + response.data['CorpAll6'][0][6];
            this.isEnableSpeedometers = true;
          }
          this.$store.commit('globalloading/SET_LOADING',false);
        });
    },
  },
  async mounted() {
    this.getDefaultData();
  }
}