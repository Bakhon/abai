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
      mainTitle: '',
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
            this.t1 = [1].concat(response.data['Abdulgafarov1'][0]);
            this.t2 = [1].concat(response.data['Abdulgafarov2'][0]);
            this.t3 = [1].concat(response.data['Abdulgafarov3'][0]);
            this.t4 = [1].concat(response.data['Abdulgafarov4'][0]);
            this.t5 = [1].concat(response.data['Abdulgafarov5'][0]);
            this.tSum = response.data['Abdulgafarov1'][0][5] +
              response.data['Abdulgafarov2'][0][5] + response.data['Abdulgafarov3'][0][5] +
              response.data['Abdulgafarov4'][0][5] + response.data['Abdulgafarov5'][0][5];
            this.t6 = [1, 0, 1, 2, 2, 0];
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