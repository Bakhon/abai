export default {
  data: function () {
    return {
      data: [],
      fullCompanyNames: {
        'ЭМГ': 'АО "ЭмбаМунайГаз"',
        'ПКИ': 'АО "ЭмбаМунайГаз"',
        'АМГ': 'АО "ЭмбаМунайГаз"',
        'ТШ': 'АО "ЭмбаМунайГаз"',
        'НКО': 'АО "ЭмбаМунайГаз"',
        'КПО': 'АО "ЭмбаМунайГаз"',
      },
    }
  },
  methods: {
    getDZOdata(dateStart, dateEnd) {
      let uri = "/ru/getdzocalcs";
      this.axios
        .get(uri, {params: {'dateStart': dateStart, 'dateEnd': dateEnd}})
        .then(response => {
        if (response.data) {
          let dataPlan = 0.00,
            dataFact = 0.00,
            dataFactPrevYear = 0.00,
            plan2020 = 0.00,
            spendingPlan = 0.00,
            spendingFact = 0.00,
            spendingFactPrevYear = 0.00,
            spendingPlan2020 = 0.00,
            costPlan = 0.00,
            costFact = 0.00,
            costPlanPrevYear = 0.00,
            costPlan2020 = 0.00;
          _.forEach(response.data['dzoDataActual'], (item) => {
            dataPlan += item.main_prc_val_plan;
            dataFact += item.main_prc_val_fact;
            spendingPlan += item.spending_val_plan;
            spendingFact += item.spending_val_fact;
            plan2020 = item.main_prc_plan_2020;
            spendingPlan2020 = item.spending_plan_2020;
            costPlan = item.cost_val_plan;
            costFact = item.cost_val_fact;
            costPlan2020 = item.cost_plan_2020;
          });
          _.forEach(response.data['dzoDataPrevYear'], (item) => {
            dataFactPrevYear += item.main_prc_val_fact;
            spendingFactPrevYear += item.spending_val_fact;
            costPlanPrevYear += item.cost_val_fact;
          });
          this.data.push({
            title: 'Выручка от основной деятельности',
            units: 'млрд.тг.',
            dataPlan: dataPlan,
            dataFact: dataFact,
            dataFactPrevYear: dataFactPrevYear,
            plan2020: plan2020,
            progress: 'План/факт',
          });
          this.data.push({
            title: 'Расходы',
            units: 'млрд.тг.',
            dataPlan: spendingPlan,
            dataFact: spendingFact,
            dataFactPrevYear: spendingFactPrevYear,
            plan2020: spendingPlan2020,
            progress: 'План/факт',
          });
          this.data.push({
            title: 'Себестоимость',
            units: 'млрд.тг.',
            dataPlan: costPlan,
            dataFact: costFact,
            dataFactPrevYear: costPlanPrevYear,
            plan2020: costPlan2020,
            progress: 'План/факт',
          });
        } else {
          console.log("No data");
        }
      })
    }
  },
  async mounted() {
    let dateStart = '01.05.2020 00:00:00';
    this.getDZOdata(dateStart);
  }
}