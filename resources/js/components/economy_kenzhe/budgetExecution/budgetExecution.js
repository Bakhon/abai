import moment from "moment";
export default {
  data: function () {
    return {
      params:{differenceBetweenMonths: "12", company: "7", reload: true},
      numbersOfMonths: [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],  
      repttData: "0",
      dzoData: [],
      macroData: [],
      fullCompanyNames: [
        {
          code: 'ОМГ',
          title: this.trans('visualcenter.omg')          
        },
        {
          code: 'ЭМГ',
          title: this.trans('visualcenter.emg')        
        },
        {
          code: 'КГМ',
          title: this.trans('visualcenter.kgm')         
        },
        {
          code: 'ММГ',
          title: this.trans('visualcenter.mmg') 
        },
        {
          code: 'КТМ',
          title: this.trans('visualcenter.ktm')    
        },
        {
          code: 'КОА',
          title: this.trans('visualcenter.koa')         
        },
      ],
      dzoSelect: 'ALL',
      selectMonthFromBeginOfTheYearh: 0,
      selectMonth: 0,
      selectQuarter: 0,
      actualMonth: 0,
      selectActualMonth: 0,
      isNeedToChangeProperty: true,
      dateStart: '',
      dateEnd: '',
      factFromOneDay:'30.01.2019',
    }
  },
  methods: {
    getCompany() {  
      this.params['reload'] = true;
      return  axios.get('/ru/module_economy/company', {params: this.params})
      .then(response => {
      this.repttData = response.data;    
     });     
        
    },
    refreshData() {
      let uri = this.localeUrl("/getdzocalcs");
      let dateStart = (moment(this.dateStart).locale("en").format('MMM DD, YYYY'))  
      let dateEnd =(moment(this.dateEnd).locale("en").format('MMM DD, YYYY'))     
      let queryParams = {params: {'dateStart': dateStart, 'dateEnd': dateEnd}};
      this.$store.commit('globalloading/SET_LOADING',true);
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
            dataPlan = 0, 
            dataFact = 0, 
            dataFactPrevYear = 0, 
            plan2020 = 0,
            spendingPlan = 0, 
            spendingFact = 0, 
            spendingFactPrevYear = 0, 
            spendingPlan2020 = 0,
            costPlan = 0, 
            costFact = 0, 
            costFactPrevYear = 0, 
            costPlan2020 = 0,
            rlzSpendingPlan = 0, 
            rlzSpendingFact = 0, 
            rlzSpendingPrevYear = 0, 
            rlzSpendingPlan2020 = 0,
            admSpendingPlan = 0, 
            admSpendingFact = 0, 
            admSpendingFactPrevYear = 0, 
            admSpendingPlan2020 = 0,
            ebitdaMarginPlan = 0, 
            ebitdaMarginFact = 0, 
            ebitdaMarginFactPrevYear = 0, 
            ebitdaMarginPlan2020 = 0,
            ebitdaPlan = 0, ebitdaFact = 0, 
            ebitdaFactPrevYear = 0, 
            ebitdaPlan2020 = 0,
            netProfitPlan = 0, 
            netProfitFact = 0, 
            netProfitFactPrevYear = 0, 
            netProfitPlan2020 = 0,
            capitalInvPlan = 0, 
            capitalInvFact = 0, 
            capitalInvFactPrevYear = 0, 
            capitalInvPlan2020 = 0,
            cashFlowPlan = 0, 
            cashFlowFact = 0, 
            cashFlowFactPrevYear = 0, 
            cashFlowPlan2020 = 0,
            kursPlan = 0, 
            kursFact = 0, 
            kursPrevYear = 0, 
            kursPlan2020 = 0,
            oilPricePlan = 0, 
            oilPriceFact = 0, 
            oilPricePrevYear = 0, 
            oilPricePlan2020 = 0;

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
          this.dzoData.push(
            {
            title: this.trans('economy_be.secondTable.operatingIncome'),       
            units: 'млрд.тг.',
            dataPlan: dataPlan,
            dataFact: dataFact,
            dataFactPrevYear: dataFactPrevYear,
            plan2020: plan2020,
            divider: 1000000,
          },
          {
            title: this.trans('economy_be.secondTable.costs'),   
            units: 'млрд.тг.',
            dataPlan: spendingPlan,
            dataFact: spendingFact,
            dataFactPrevYear: spendingFactPrevYear,
            plan2020: spendingPlan2020,
            divider: 1000000,
          },
          {
            title: this.trans('economy_be.secondTable.costPrice'),          
            units: 'млрд.тг.',
            dataPlan: costPlan,
            dataFact: costFact,
            dataFactPrevYear: costFactPrevYear,
            plan2020: costPlan2020,
            divider: 1000000,
          },
          {
            title: this.trans('economy_be.secondTable.implementationCosts'),           
            units: 'млрд.тг.',
            dataPlan: rlzSpendingPlan,
            dataFact: rlzSpendingFact,
            dataFactPrevYear: rlzSpendingPrevYear,
            plan2020: rlzSpendingPlan2020,
            divider: 1000000,
          },
          {
            title: this.trans('economy_be.secondTable.generalAdministrativeIssues'),           
            units: 'млрд.тг.',
            dataPlan: admSpendingPlan,
            dataFact: admSpendingFact,
            dataFactPrevYear: admSpendingFactPrevYear,
            plan2020: admSpendingPlan2020,
            divider: 1000000,
          },
          {
            title: this.trans('economy_be.secondTable.ebitdaMargin'),         
            units: '%',
            dataPlan: ebitdaMarginPlan,
            dataFact: ebitdaMarginFact,
            dataFactPrevYear: ebitdaMarginFactPrevYear,
            plan2020: ebitdaMarginPlan2020,
            divider: 1,
          },
          {
            title: 'EBITDA',
            units: 'млрд.тг.',
            dataPlan: ebitdaPlan,
            dataFact: ebitdaFact,
            dataFactPrevYear: ebitdaFactPrevYear,
            plan2020: ebitdaPlan2020,
            divider: 1000000,
          },
          {
            title: this.trans('economy_be.secondTable.netProfit'),           
            units: 'млрд.тг.',
            dataPlan: netProfitPlan,
            dataFact: netProfitFact,
            dataFactPrevYear: netProfitFactPrevYear,
            plan2020: netProfitPlan2020,
            divider: 1000000,
          },
          {
            title: this.trans('economy_be.secondTable.capitalInvestments'),         
            units: 'млрд.тг.',
            dataPlan: capitalInvPlan,
            dataFact: capitalInvFact,
            dataFactPrevYear: capitalInvFactPrevYear,
            plan2020: capitalInvPlan2020,
            divider: 1000000,
          },
          {
            title: this.trans('economy_be.secondTable.freeCashFlow'),   
            units: 'млрд.тг.',
            dataPlan: cashFlowPlan,
            dataFact: cashFlowFact,
            dataFactPrevYear: cashFlowFactPrevYear,
            plan2020: cashFlowPlan2020,
            divider: 1000000,
          });
          this.macroData.push({
            title: this.trans('economy_be.secondTable.exchangeRate'),      
            units: 'Тенге/$',
            dataPlan: kursPlan,
            dataFact: kursFact,
            dataFactPrevYear: kursPrevYear,
            plan2020: kursPlan2020,
          },
          {
            title: this.trans('economy_be.secondTable.priceBrent'),           
            units: '$/бар.',
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
        }
      })
    },
  },
  watch: {
    dzoSelect: function () {
      this.refreshData()
    },
    selectMonthFromBeginOfTheYearh: function (newValue) {
      if (newValue !== 0) {
        let dateStart = new Date(2020, 0, 1);
        let dateEnd = new Date(2020, newValue, 1);
        this.dateStart = dateStart;
        this.dateEnd = dateEnd;
        this.refreshData();
        this.selectMonth = this.selectQuarter = this.selectActualMonth = 0;
      }
    },
    selectMonth: function (newValue) {
      if (newValue !== 0) {
        let dateStart = new Date(2020, newValue - 1, 1);
        let dateEnd = new Date(2020, newValue, 1);
        this.dateStart = dateStart;
        this.dateEnd = dateEnd;
        this.refreshData();
        this.selectMonthFromBeginOfTheYearh = this.selectQuarter = this.selectActualMonth = 0;
      }
    },
    selectQuarter: function (newValue) {
      if (newValue !== 0) {
        let dateStart = new Date(2020, newValue - 1, 1);
        let dateEnd = new Date(2020, newValue + 2, 1);
        this.dateStart = dateStart;
        this.dateEnd = dateEnd;
        this.refreshData();
        this.selectMonthFromBeginOfTheYearh = this.selectMonth = this.selectActualMonth = 0;
      }
    },
    selectActualMonth: function (newValue) {
      if (newValue !== 0) {
        let dateStart = new Date(2020, this.actualMonth, 1);
        let dateEnd = new Date(2020, this.actualMonth + 1, 1);
        this.dateStart = dateStart;
        this.dateEnd = dateEnd;
        this.refreshData();
        this.selectMonthFromBeginOfTheYearh = this.selectMonth = this.selectQuarter = 0;
      }
    },

  },
  async created () {  
    await this.getCompany(); 
      this.axios
        .get('/ru/getdzocalcsactualmonth', {})
        .then(response => {
          if (response.data) {
            this.actualMonth = response.data - 1;
            this.selectActualMonth = 1;
          }
       })
  },
}