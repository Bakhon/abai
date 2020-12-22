export default {
  props: {
    tableToChange: {
      default: '1',
    },
    dateStart: '',
    dateEnd: '',
    dzo: '',
  },
  data: function () {
    return {
      lastMonth:'',
      //kpi
      oilFact: '',
      oilPlan: '',
      prevOilFact: '',
      dataPlan: '',
      dataFact: '',
      prevDataFact: '',
      spendingPlan: '',
      spendingFact: '',
      prevSpendingFact: '',
      netProfitPlan: '',
      netProfitFact: '',
      prevNetProfitFact: '',
      capitalInvPlan: '',
      capitalInvFact: '',
      prevCapitalInvFact: '',
      cashFlowPlan: '',
      cashFlowFact: '',
      prevCashFlowFact: '',
      //kpi
      //oil and currency down
      currencyNow: "",
      currencyPrevPeriod: "",
      currencyNowUsd: "",
      period: "7",
      timeSelect: "",
      oilNow: "",
      oilChart: "",
      month: new Date().getMonth() + 1,
      year: new Date().getFullYear(),
      day: ["Mn", "Tu", "We", "Th", "Fr", "Sa", "Su"],
      date: new Date(),
      currencyChart: "",
      periodUSD: "7",
      monthes3: [
        "",
        "январь",
        "февраль",
        "март",
        "апрель",
        "май",
        "июнь",
        "июль",
        "август",
        "сентябрь",
        "октябрь",
        "ноябрь",
        "декабрь",
      ],
      timestampToday: 0,
      timestampEnd: 0,
      /*calendar*/
      range: {
        start: "2020-01-06T06:00:00+06:00",
        end: "2020-01-10T06:00:00+06:00",
      },
      modelConfig: {
        start: {
          timeAdjust: '06:00:00',
          type: 'string',
          mask: 'YYYY-MM-DDTHH:mm:ssXXX',
        },
        end: {
          timeAdjust: '06:00:00',
          type: 'string',
          mask: 'YYYY-MM-DDTHH:mm:ssXXX',
        },
      },
      /*calendar*/
      company: "all",
    };
  },
  methods: {
    getOilNow(dates, period) {
      this.axios.get("/js/json/graph_1006.json")
        .then((response) => {
          let data = response.data;
          if (data) {
            let timestampToday = this.timestampToday;
            let oilDate;
            let oilDate2;
            let oilValue;
            let splits = [];
            let oil = [];
            _.forEach(data.prices, function (prices) {
              splits = prices.toString().split(",");
              oilValue = splits["1"];
              oilDate = Number(splits["0"]);
              oilDate2 = new Date(oilDate).toLocaleString("ru", {
                year: "numeric",
                day: "numeric",
                month: "numeric",
                timeZone: "Europe/Moscow",
              });
              oil.push({
                dateSimple: oilDate,
                date: oilDate2,
                value: oilValue,
              });
            });

            let oil2 = [];
            oil2 = _.filter(oil, _.iteratee({ date: dates }));
            if (oil2.length != "0") {
              this.oilNow = Number(oil2[0].value).toFixed(1);
            } else {
              oil2 = _.last(oil);
              this.oilNow = Number(oil2.value).toFixed(1);
            }

            let dateInOil = [];
            dateInOil = _.filter(oil, function (item) {
              return _.every([
                _.inRange(
                  item.dateSimple,
                  timestampToday - 86400000 * Number(period),
                  timestampToday + 86400000
                ),
              ]);
            });
            this.$emit("oilChart", dateInOil);
          } else {
            console.log("No data");
          }
        });
    },
    getCurrencyNow(dates) {
      this.axios.get("/ru/getcurrencyperiod", {params:{dates: dates, period: "2"}})
        .then((response) => {
          var data = response.data;
          if (data) {
            this.currencyNowUsd = this.currencyNow = parseInt(data[2].description[0] * 10) / 10;
            this.currencyPrevPeriod = parseInt(data[1].description[0] * 10) / 10;
          } else {
            console.log("No data");
          }
        });
    },
    getCurrencyPeriod: function (dates, period) {
      this.axios.get("/ru/getcurrencyperiod", {params:{dates: dates, period: period}})
        .then((response) => {
          var data = response.data;
          if (data) {
            var arrdata2 = [];
            _.forEach(data, function (item) {
              arrdata2.push({ dates: item.dates, value: item.description["0"] });
            });
            this.$emit("currencyChart", arrdata2);
          } else {
            console.log("No data");
          }
        });
    },
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
            let oilPlan = 0.00, oilFact = 0.00;
            let dataPlan = 0.00, dataFact = 0.00;
            let spendingPlan = 0.00, spendingFact = 0.00;
            let netProfitPlan = 0.00, netProfitFact = 0.00;
            let capitalInvPlan = 0.00, capitalInvFact = 0.00;
            let cashFlowPlan = 0.00, cashFlowFact = 0.00;
            _.forEach(response.data['dzoDataActual'], (item) => {
              oilPlan += item.oil_val_plan;
              oilFact += item.oil_val_fact;

              dataPlan += item.main_prc_val_plan;
              dataFact += item.main_prc_val_fact;

              spendingPlan += item.spending_val_plan;
              spendingFact += item.spending_val_fact;

              netProfitPlan += item.net_profit_val_plan;
              netProfitFact += item.net_profit_val_fact;

              capitalInvPlan += item.capital_inv_val_plan;
              capitalInvFact += item.capital_inv_val_fact;

              cashFlowPlan += item.cash_flow_val_plan;
              cashFlowFact += item.cash_flow_val_fact;
            });
            this.oilFact = oilFact.toFixed(0);
            this.oilPlan = oilPlan.toFixed(0);

            this.dataPlan = (dataPlan / 1000000000).toFixed(2);
            this.dataFact = (dataFact / 1000000000).toFixed(2);

            this.spendingPlan = (spendingPlan / 1000000000).toFixed(2);
            this.spendingFact = (spendingFact / 1000000000).toFixed(2);

            this.netProfitPlan = (netProfitPlan / 1000000).toFixed(2);
            this.netProfitFact = (netProfitFact / 1000000).toFixed(2);

            this.capitalInvPlan = (capitalInvPlan / 1000000).toFixed(2);
            this.capitalInvFact = (capitalInvFact / 1000000).toFixed(2);

            this.cashFlowPlan = (cashFlowPlan / 1000000).toFixed(2);
            this.cashFlowFact = (cashFlowFact / 1000000).toFixed(2);
          }
        });
      queryParams = {params: {'dateStart': prevPeriodDateStart, 'dateEnd': dateStart}};
      this.axios
        .get(uri, queryParams)
        .then(response => {
          if (response.data) {
            let prevPeriodOilFact = 0.00;
            let prevDataFact = 0.00;
            let prevSpendingFact = 0.00;
            let prevNetProfitFact = 0.00;
            let prevCapitalInvFact = 0.00;
            let prevCashFlowFact = 0.00;
            _.forEach(response.data['dzoDataActual'], (item) => {
              prevPeriodOilFact += item.oil_val_fact;
              prevDataFact += item.main_prc_val_fact;
              prevSpendingFact += item.spending_val_fact;
              prevNetProfitFact += item.net_profit_val_fact;
              prevCapitalInvFact += item.capital_inv_val_fact;
              prevCashFlowFact += item.cash_flow_val_fact;
            });
            this.prevOilFact = prevPeriodOilFact.toFixed(0);
            this.prevDataFact = (prevDataFact / 1000000000).toFixed(2);
            this.prevSpendingFact = (prevSpendingFact / 1000000000).toFixed(2);
            this.prevNetProfitFact = (prevNetProfitFact / 1000000).toFixed(2);
            this.prevCapitalInvFact = (prevCapitalInvFact / 1000000).toFixed(2);
            this.prevCashFlowFact = (prevCashFlowFact / 1000000).toFixed(2);
          }
        });
      this.getCurrencyNow(this.timeSelect);
      this.getOilNow(this.timeSelect, this.period);
      this.getCurrencyPeriod(this.timeSelect, this.periodUSD);
    },
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
  computed: {
    oilPercents: function () {
      return Math.abs(Math.round((this.prevOilFact - this.oilFact ) / this.oilFact * 100))
    },
    dataPercents: function () {
      return Math.abs(Math.round((this.prevDataFact - this.dataFact ) / this.dataFact * 100))
    },
    spendingPercents: function () {
      return Math.abs(Math.round((this.prevSpendingFact - this.spendingFact ) / this.spendingFact * 100))
    },
    netProfitPercents: function () {
      return Math.abs(Math.round((this.prevNetProfitFact - this.netProfitFact ) / this.netProfitFact * 100))
    },
    capitalInvPercents: function () {
      return Math.abs(Math.round((this.prevCapitalInvFact - this.capitalInvFact ) / this.capitalInvFact * 100))
    },
    cashFlowPercents: function () {
      return Math.abs(Math.round((this.prevCashFlowFact - this.cashFlowFact ) / this.cashFlowFact * 100))
    },
    oilNowPercents: function () {
      return Math.abs(Math.round((40 - this.oilNow ) / this.oilNow * 100))
    },
    currencyPercents: function () {
      return Math.abs(Math.round((this.currencyPrevPeriod - this.currencyNow ) / this.currencyNow * 100))
    },
  },
  async mounted() {
    this.currentMonth = this.monthes3[this.month];
    this.lastMonth = this.monthes3[this.month-1];
    this.timestampToday = new Date(this.range.start).getTime();
    this.timestampEnd = new Date(this.range.end).getTime();
    this.selectedYear = this.year;
    this.timeSelect = new Date().toLocaleDateString();
  }
}