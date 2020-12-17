export default {
  data: function () {
    return {
      dzoData: [],
      fullCompanyNames: [
        {
          code: 'ОМГ',
          title: 'АО "ОзенМунайГаз"'
        },
        {
          code: 'ЭМГ',
          title: 'АО "ЭмбаМунайГаз"'
        },
        {
          code: 'КГМ',
          title: 'ТОО "КазГерМунай"'
        },
        {
          code: 'ММГ',
          title: 'АО "Мангистаумунайгаз"'
        },
        {
          code: 'КТМ',
          title: 'ТОО "Казахтуркмунай"'
        },
        {
          code: 'КОА',
          title: 'ТОО "Казахойл Актобе"'
        },
      ],
      dzoSelect: 'ALL',
      fromBeginOfYearSelect: 0,
      byMonthSelect: 0,
      quarterSelect: 0,
      actualMonthSelect: 0,
      needToChangeProp: true,
      dateStart: '',
      dateEnd: '',
    }
  },
  methods: {
    refreshData() {
      let uri = "/ru/getdzocalcs";
      let queryParams = {params: {'dateStart': this.dateStart, 'dateEnd': this.dateEnd}};
      this.dzoData = [];
      if (this.dzoSelect !== 'ALL') {
        queryParams.params.dzo = this.dzoSelect;
      }
      this.axios
        .get(uri, queryParams)
        .then(response => {
        if (response.data) {
          let
            dataPlan = 0.00, dataFact = 0.00, dataFactPrevYear = 0.00, plan2020 = 0.00,
            spendingPlan = 0.00, spendingFact = 0.00, spendingFactPrevYear = 0.00, spendingPlan2020 = 0.00,
            costPlan = 0.00, costFact = 0.00, costFactPrevYear = 0.00, costPlan2020 = 0.00,
            rlzSpendingPlan = 0.00, rlzSpendingFact = 0.00, rlzSpendingPrevYear = 0.00, rlzSpendingPlan2020 = 0.00,
            admSpendingPlan = 0.00, admSpendingFact = 0.00, admSpendingFactPrevYear = 0.00, admSpendingPlan2020 = 0.00,
            ebitdaMarginPlan = 0.00, ebitdaMarginFact = 0.00, ebitdaMarginFactPrevYear = 0.00, ebitdaMarginPlan2020 = 0.00,
            ebitdaPlan = 0.00, ebitdaFact = 0.00, ebitdaFactPrevYear = 0.00, ebitdaPlan2020 = 0.00,
            netProfitPlan = 0.00, netProfitFact = 0.00, netProfitFactPrevYear = 0.00, netProfitPlan2020 = 0.00,
            capitalInvPlan = 0.00, capitalInvFact = 0.00, capitalInvFactPrevYear = 0.00, capitalInvPlan2020 = 0.00,
            cashFlowPlan = 0.00, cashFlowFact = 0.00, cashFlowFactPrevYear = 0.00, cashFlowPlan2020 = 0.00;

          _.forEach(response.data['dzoDataActual'], (item) => {
            dataPlan += item.main_prc_val_plan;
            dataFact += item.main_prc_val_fact;

            spendingPlan += item.spending_val_plan;
            spendingFact += item.spending_val_fact;

            costPlan += item.cost_val_plan;
            costFact += item.cost_val_fact;

            rlzSpendingPlan += item.rlz_spending_val_plan;
            rlzSpendingFact += item.rlz_spending_val_fact;

            admSpendingPlan += item.adm_spending_val_plan;
            admSpendingFact += item.adm_spending_val_fact;

            ebitdaMarginPlan += item.editba_margin_val_plan;
            ebitdaMarginFact += item.editba_margin_val_fact;

            ebitdaPlan += item.editba_val_plan;
            ebitdaFact += item.editba_val_fact;

            netProfitPlan += item.net_profit_val_plan;
            netProfitFact += item.net_profit_val_fact;

            capitalInvPlan += item.capital_inv_val_plan;
            capitalInvFact += item.capital_inv_val_fact;

            cashFlowPlan += item.cash_flow_val_plan;
            cashFlowFact += item.cash_flow_val_fact;

            plan2020 = item.main_prc_plan_2020;
            spendingPlan2020 = item.spending_plan_2020;
            costPlan2020 = item.cost_plan_2020;
            admSpendingPlan2020 = item.adm_spending_plan_2020;
            rlzSpendingPlan2020 = item.rlz_spending_plan_2020;
            ebitdaMarginPlan2020 = item.editba_margin_plan_2020;
            ebitdaPlan2020 = item.editba_plan_2020;
            netProfitPlan2020 = item.net_profit_plan_2020;
            capitalInvPlan2020 = item.capital_inv_plan_2020;
            cashFlowPlan2020 = item.cash_flow_plan_2020;
          });
          _.forEach(response.data['dzoDataPrevYear'], (item) => {
            dataFactPrevYear += item.main_prc_val_fact;
            spendingFactPrevYear += item.spending_val_fact;
            costFactPrevYear += item.cost_val_fact;
            rlzSpendingPrevYear += item.rlz_spending_val_fact;
            admSpendingFactPrevYear += item.adm_spending_val_fact;
            ebitdaFactPrevYear += item.editba_val_fact;
            ebitdaMarginFactPrevYear += item.editba_margin_val_fact;
            netProfitFactPrevYear += item.net_profit_val_fact;
            capitalInvFactPrevYear += item.capital_inv_val_fact;
            cashFlowFactPrevYear += item.cash_flow_val_fact;
          });
          this.dzoData.push({
            title: 'Выручка от основной деятельности',
            units: 'млрд.тг.',
            dataPlan: dataPlan,
            dataFact: dataFact,
            dataFactPrevYear: dataFactPrevYear,
            plan2020: plan2020,
            divider: 1000000,
          });
          this.dzoData.push({
            title: 'Расходы',
            units: 'млрд.тг.',
            dataPlan: spendingPlan,
            dataFact: spendingFact,
            dataFactPrevYear: spendingFactPrevYear,
            plan2020: spendingPlan2020,
            divider: 1000000,
          });
          this.dzoData.push({
            title: 'Себестоимость',
            units: 'млрд.тг.',
            dataPlan: costPlan,
            dataFact: costFact,
            dataFactPrevYear: costFactPrevYear,
            plan2020: costPlan2020,
            divider: 1000000,
          });
          this.dzoData.push({
            title: 'Расходы по реализации',
            units: 'млрд.тг.',
            dataPlan: rlzSpendingPlan,
            dataFact: rlzSpendingFact,
            dataFactPrevYear: rlzSpendingPrevYear,
            plan2020: rlzSpendingPlan2020,
            divider: 1000000,
          });
          this.dzoData.push({
            title: 'Общие административные вопросы',
            units: 'млрд.тг.',
            dataPlan: admSpendingPlan,
            dataFact: admSpendingFact,
            dataFactPrevYear: admSpendingFactPrevYear,
            plan2020: admSpendingPlan2020,
            divider: 1000000,
          });
          this.dzoData.push({
            title: 'EBITDA margin (Без СП)',
            units: '%',
            dataPlan: ebitdaMarginPlan,
            dataFact: ebitdaMarginFact,
            dataFactPrevYear: ebitdaMarginFactPrevYear,
            plan2020: ebitdaMarginPlan2020,
            divider: 1,
          });
          this.dzoData.push({
            title: 'EBITDA',
            units: 'млрд.тг.',
            dataPlan: ebitdaPlan,
            dataFact: ebitdaFact,
            dataFactPrevYear: ebitdaFactPrevYear,
            plan2020: ebitdaPlan2020,
            divider: 1000000,
          });
          this.dzoData.push({
            title: 'Чистая прибыль*',
            units: 'млрд.тг.',
            dataPlan: netProfitPlan,
            dataFact: netProfitFact,
            dataFactPrevYear: netProfitFactPrevYear,
            plan2020: netProfitPlan2020,
            divider: 1000000,
          });
          this.dzoData.push({
            title: 'Капитальные вложения',
            units: 'млрд.тг.',
            dataPlan: capitalInvPlan,
            dataFact: capitalInvFact,
            dataFactPrevYear: capitalInvFactPrevYear,
            plan2020: capitalInvPlan2020,
            divider: 1000000,
          });
          this.dzoData.push({
            title: 'Свободный денежный поток',
            units: 'млрд.тг.',
            dataPlan: cashFlowPlan,
            dataFact: cashFlowFact,
            dataFactPrevYear: cashFlowFactPrevYear,
            plan2020: cashFlowPlan2020,
            divider: 1000000,
          });
          this.dzoData = this.dzoData.map((item) => {
            return {
              title: item.title,
              units: item.units,
              dataPlan: item.dataPlan / item.divider,
              dataFact: item.dataFact / item.divider,
              dataFactPrevYear: item.dataFactPrevYear / item.divider,
              plan2020: item.plan2020 / item.divider,
            }
          });
        } else {
          console.log("No data");
        }
      })
    },
  },
  watch: {
    dzoSelect: function (newValue, oldValue) {
      this.refreshData()
    },
    fromBeginOfYearSelect: function (newValue, oldValue) {
      let dateStart = new Date(2020, 1, 1);
      let dateEnd = new Date(2020, newValue + 1, 1);
      dateEnd.setDate(0);
      dateEnd.setHours(23,59,59);
      this.dateStart = dateStart;
      this.dateEnd = dateEnd;
      this.refreshData();

      if (newValue !== 0) {
        this.byMonthSelect = this.quarterSelect = this.actualMonthSelect = 0;
      }
    },
    byMonthSelect: function (newValue, oldValue) {
      let dateStart = new Date(2020, newValue, 1);
      let dateEnd = new Date(2020, newValue + 1, 1);
      dateEnd.setDate(0);
      this.dateStart = dateStart;
      this.dateEnd = dateEnd;
      this.refreshData();

      if (newValue !== 0) {
        this.fromBeginOfYearSelect = this.quarterSelect = this.actualMonthSelect = 0;
      }
    },
    quarterSelect: function (newValue, oldValue) {
      newValue = newValue - 1;
      let dateStart = new Date(2020, newValue, 1);
      let dateEnd = new Date();
      dateEnd.setMonth(dateStart.getMonth() + 3);
      dateEnd.setDate(0);
      dateEnd.setHours(23,59,59);
      this.dateStart = dateStart;
      this.dateEnd = dateEnd;
      this.refreshData();

      if (newValue !== 0) {
        this.fromBeginOfYearSelect = this.byMonthSelect = this.actualMonthSelect = 0;
      }
    },
    actualMonthSelect: function (newValue, oldValue) {
      let dateStart = new Date();
      dateStart.setDate(1);
      dateStart.setHours(0,0,0);
      dateStart.setMonth(dateStart.getMonth() - 1);
      let dateEnd = new Date();
      dateEnd.setDate(0);
      dateEnd.setHours(23,59,59);
      this.dateStart = dateStart;
      this.dateEnd = dateEnd;
      this.refreshData();

      if (newValue !== 0) {
        this.fromBeginOfYearSelect = this.byMonthSelect = this.quarterSelect = 0;
      }
    },

  },
  async mounted() {
    let dateStart = new Date(2020, 1, 1);
    let dateEnd = new Date();
    dateEnd.setHours(23,59,59);
    this.dateStart = dateStart;
    this.dateEnd = dateEnd;
    this.refreshData();
  }
}