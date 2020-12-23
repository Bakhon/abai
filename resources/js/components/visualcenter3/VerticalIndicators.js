export default {
  props: {
    dateStart: '',
    dateEnd: '',
    dzo: '',
  },
  data: function () {
    return {
      leftNumbers: [{
        title: 'план',
        value: 224543,
      }],
      leftUnits: "тыс.тенге/тонна",
      rightNumbers: [{
        title: 'факт',
        value: 789373,
        units: '$/bbl',
      }],
      rightUnits: "$/bbl",
      title: "Удельные доходы",
      isUpArrow: false,
      progressPercents: 32,
      udIncomePlan: 0,
      udIncomeBblPlan: 0,
      udIncomeFact: 0,
      udIncomeBblFact: 0,
      udSpendingPlan: 0,
      udSpendingBblPlan: 0,
      udSpendingFact: 0,
      udSpendingBblFact: 0,
      kvlPlan: 0,
      kvlFact: 0,
      rentGtm: 0,
      neRentGtm: 0,
      rentBurenie: 0,
      neRentBurenie: 0,
      fines: 0,
    };
  },
  methods: {
    getIndicatorsData() {
      let uri = "/ru/getdzocalcs";
      let dateStart = new Intl.DateTimeFormat('en', {year: 'numeric', month: 'short', day: '2-digit'}).format(this.dateStart);
      let dateEnd = new Intl.DateTimeFormat('en', {year: 'numeric', month: 'short', day: '2-digit'}).format(this.dateEnd);
      let prevPeriodDateStart = new Date(
        this.dateStart.getFullYear(),
        this.dateStart.getMonth() - Math.abs(this.dateStart.getMonth() - this.dateEnd.getMonth()),
        this.dateStart.getDate()
      );
      prevPeriodDateStart = new Intl.DateTimeFormat('en', {year: 'numeric', month: 'short', day: '2-digit'}).format(prevPeriodDateStart);
      let queryParams = {params: {dateStart: dateStart, dateEnd: dateEnd, dzo: ''}};
      if (this.dzo !== '' && this.dzo !== 'ALL') {
        queryParams.params.dzo = this.dzo;
      }
      this.axios
        .get(uri, queryParams)
        .then(response => {
          if (response.data) {
            let
              udIncomePlan = 0.00,
              udIncomeBblPlan = 0.00,
              udIncomeFact = 0.00,
              udIncomeBblFact = 0.00,
              udSpendingPlan = 0.00,
              udSpendingBblPlan = 0.00,
              udSpendingFact = 0.00,
              udSpendingBblFact = 0.00,
              kvlPlan = 0.00,
              kvlFact = 0.00,
              rentGtm = 0.00,
              neRentGtm = 0.00,
              rentBurenie = 0.00,
              neRentBurenie = 0.00,
              fines = 0.00
              ;
            _.forEach(response.data['dzoDataActual'], (item) => {
              udIncomePlan += item.ud_income_val_plan;
              udIncomeBblPlan += item.ud_income_bbl_val_plan;
              udIncomeFact += item.ud_income_val_fact;
              udIncomeBblFact += item.ud_income_bbl_val_fact;

              udSpendingPlan += item.ud_spending_val_plan;
              udSpendingBblPlan += item.ud_spending_bbl_val_plan;
              udSpendingFact += item.ud_spending_val_fact;
              udSpendingBblFact += item.ud_spending_bbl_val_fact;

              kvlPlan += item.kvl_val_plan;
              kvlFact += item.kvl_val_fact;

              rentGtm += item.rent_gtm_fact_2020;
              neRentGtm += item.ne_rent_gtm_fact_2020;

              rentBurenie += item.rent_burenie_fact_2020;
              neRentBurenie += item.ne_rent_burenie_fact_2020;

              fines += item.fine_2020;
            });

            this.udIncomePlan = udIncomePlan / 1000;
            this.udIncomeBblPlan = udIncomeBblPlan;
            this.udIncomeFact = udIncomeFact / 1000;
            this.udIncomeBblFact = udIncomeBblFact;

            this.udSpendingPlan = udSpendingPlan / 1000;
            this.udSpendingBblPlan = udSpendingBblPlan;
            this.udSpendingFact = udSpendingFact / 1000;
            this.udSpendingBblFact = udSpendingBblFact;

            this.kvlPlan = kvlPlan / 1000;
            this.kvlFact = kvlFact / 1000;

            this.rentGtm = rentGtm;
            this.neRentGtm = neRentGtm;

            this.rentBurenie = rentBurenie;
            this.neRentBurenie = neRentBurenie;

            this.fines = fines.toFixed(0);
          }
        });
      queryParams = {params: {'dateStart': prevPeriodDateStart, 'dateEnd': dateStart}};
      this.axios
        .get(uri, queryParams)
        .then(response => {
          if (response.data) {

          }
        });
    }
  },
  watch: {
    dateStart: function () {
      this.getIndicatorsData();
    },
    dateEnd: function () {
      this.getIndicatorsData();
    },
    dzo: function () {
      this.getIndicatorsData();
    },
  },
  mounted() {
    this.getIndicatorsData();
  }
}