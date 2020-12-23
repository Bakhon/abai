export default {
  data: function () {
    return {
      dzoData: [],
      macroData: [],
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
      actualMonth: 0,
      actualMonthSelect: 0,
      needToChangeProp: true,
      dateStart: '',
      dateEnd: '',
    }
  },
  methods: {
    refreshData() {
      let uri = "/ru/getdzocalcs";
      let dateStart = new Intl.DateTimeFormat('en', {year: 'numeric', month: 'short', day: '2-digit'}).format(this.dateStart)
      let dateEnd = new Intl.DateTimeFormat('en', {year: 'numeric', month: 'short', day: '2-digit'}).format(this.dateEnd)
      let queryParams = {params: {'dateStart': dateStart, 'dateEnd': dateEnd}};
      this.dzoData = [];
      this.macroData = [];
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
            cashFlowPlan = 0.00, cashFlowFact = 0.00, cashFlowFactPrevYear = 0.00, cashFlowPlan2020 = 0.00,
            kursPlan = 0.00, kursFact = 0.00, kursPrevYear = 0.00, kursPlan2020 = 0.00,
            oilPricePlan = 0.00, oilPriceFact = 0.00, oilPricePrevYear = 0.00, oilPricePlan2020 = 0.00;

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

            kursPlan = item.kurs_plan;
            kursFact = item.kurs_fact;

            oilPricePlan = item.oil_price_plan;
            oilPriceFact = item.oil_price_fact;

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
            kursPlan2020 = item.kurs_plan_2020;
            oilPricePlan2020 = item.oil_price_plan_2020;
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
            kursPrevYear = item.kurs_fact;
            oilPricePrevYear = item.oil_price_fact;
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
          this.macroData.push({
            title: 'Обменный курс',
            units: 'Тенге/$',
            dataPlan: kursPlan,
            dataFact: kursFact,
            dataFactPrevYear: kursPrevYear,
            plan2020: kursPlan2020,
          });
          this.macroData.push({
            title: 'Цена Brent',
            units: '$/баррель',
            dataPlan: oilPricePlan,
            dataFact: oilPriceFact,
            dataFactPrevYear: oilPricePrevYear,
            plan2020: oilPricePlan2020,
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
      if (newValue !== 0) {
        let dateStart = new Date(2020, 0, 1);
        let dateEnd = new Date(2020, newValue, 1);
        this.dateStart = dateStart;
        this.dateEnd = dateEnd;
        this.refreshData();
        this.byMonthSelect = this.quarterSelect = this.actualMonthSelect = 0;
      }
    },
    byMonthSelect: function (newValue, oldValue) {
      if (newValue !== 0) {
        let dateStart = new Date(2020, newValue - 1, 1);
        let dateEnd = new Date(2020, newValue, 1);
        this.dateStart = dateStart;
        this.dateEnd = dateEnd;
        this.refreshData();
        this.fromBeginOfYearSelect = this.quarterSelect = this.actualMonthSelect = 0;
      }
    },
    quarterSelect: function (newValue, oldValue) {
      if (newValue !== 0) {
        let dateStart = new Date(2020, newValue - 1, 1);
        let dateEnd = new Date(2020, newValue + 2, 1);
        this.dateStart = dateStart;
        this.dateEnd = dateEnd;
        this.refreshData();
        this.fromBeginOfYearSelect = this.byMonthSelect = this.actualMonthSelect = 0;
      }
    },
    actualMonthSelect: function (newValue, oldValue) {
      if (newValue !== 0) {
        let dateStart = new Date(2020, this.actualMonth, 1);
        let dateEnd = new Date(2020, this.actualMonth + 1, 1);
        this.dateStart = dateStart;
        this.dateEnd = dateEnd;
        this.refreshData();
        this.fromBeginOfYearSelect = this.byMonthSelect = this.quarterSelect = 0;
      }
    },

  },
  created() {
    this.axios
      .get('/ru/getdzocalcsactualmonth', {})
      .then(response => {
        if (response.data) {
          this.actualMonth = response.data - 1;
          this.actualMonthSelect = 1;
        }
      })
  }
}