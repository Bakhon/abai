import Calendar from "v-calendar/lib/components/calendar.umd";
import DatePicker from "v-calendar/lib/components/date-picker.umd";

Vue.component("calendar", Calendar);
Vue.component("date-picker", DatePicker);
export default {
  components: {
    Calendar,
    DatePicker,
  },
  props: {
    tableToChange: {
      default: '1'
    }
  },
  data: function () {
    return {
      lastMonth:'',
      //kpi
      oil_fact: '',
      proceeds: '', //выручка/доход
      costs: '',
      net_profit: '', //чистая прибыль
      capital_investment: '', //капиталовложения
      cash_flow: '',
      //kpi
      oil_factDayPercent: "",
      oil_dlv_factDayPercent: "",
      gas_factDayPercent: "",
      oil_factDay: "",
      oil_planDay: "",
      oil_dlv_factDay: "",
      oil_dlv_planDay: "",
      gas_factDay: "",
      oil_dlv_factDayProgressBar: "",
      oil_factDayProgressBar: "",
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
      let uri = "/js/json/graph_1006.json";
      this.axios.get(uri).then((response) => {
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
      let uri = "/ru/getcurrencyperiod?dates=" + dates + "&period=2";
      this.axios.get(uri).then((response) => {
        var data = response.data;
        if (data) {
          this.currencyNowUsd = this.currencyNow = parseInt(data[2].description[0] * 10) / 10;
          this.currencyPrevPeriod = parseInt(data[1].description[0] * 10) / 10;
        } else {
          console.log("No data");
        }
      });
    },
    getCurrencyPeriod: function (dates, item2) {
      let uri = "/ru/getcurrencyperiod?dates=" + dates + "&period=" + item2 + " ";
      this.axios.get(uri).then((response) => {
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
    getProductionOilAndGas() {
      let uri = "/js/json/getnkkmg.json";
      this.axios.get(uri).then((response) => {
        let data = response.data;
        if (data) {
          let timestampToday = this.timestampToday;
          let timestampEnd = this.timestampEnd;
          let company = this.company;
          if (company !== "all") {
            data = _.filter(data, _.iteratee({ dzo: company }));
          }
          let quantityRange = this.quantityRange;
          let plansAndFactsData = _.filter(data, function (item) {
            return _.every([
              _.inRange(
                item.__time,
                timestampToday - quantityRange * 86400000,
                timestampToday
              ),
            ]);
          });
          let plansAndFacts = this.getSumPlanAndFactDzo(plansAndFactsData);
          this.oil_factDayPercent = plansAndFacts.oil_factSum;
          this.gas_factDayPercent = plansAndFacts.gas_factSum;
          this.oil_dlv_factDayPercent = plansAndFacts.oil_dlv_factSum;

          plansAndFactsData = _.filter(data, function (item) {
            return _.every([
              _.inRange(
                item.__time,
                timestampToday,
                timestampEnd + 86400000
              ),
            ]);
          });
          plansAndFacts = this.getSumPlanAndFactDzo(plansAndFactsData);
          this.quantityGetProductionOilandGas = Object.keys(_.filter(plansAndFactsData, _.iteratee({dzo: plansAndFactsData[0].dzo}))).length;
          this.oil_factDay = plansAndFacts.oil_factSum;
          this.oil_planDay = plansAndFacts.oil_planSum;
          this.oil_factDayProgressBar = (plansAndFacts.oil_factSum / plansAndFacts.oil_planSum) * 100;
          this.oil_dlv_factDay = plansAndFacts.oil_dlv_factSum;
          this.oil_dlv_planDay = plansAndFacts.oil_dlv_planSum;
          this.oil_dlv_factDayProgressBar = (plansAndFacts.oil_dlv_factSum / plansAndFacts.oil_dlv_planSum) * 100;
          this.gas_factDay = plansAndFacts.gas_factSum;
          this.gas_planDay = plansAndFacts.gas_planSum;
          this.gas_factDayProgressBar = (plansAndFacts.gas_factSum / plansAndFacts.gas_planSum) * 100;
        }
      });
    },
    getSumPlanAndFactDzo(plansAndFactsData) {
      let SumFromRange = _(plansAndFactsData)
        .groupBy("dzo")
        .map((dzo, id) => ({
          dzo: id,
          oil_plan: _.round(_.sumBy(dzo, 'oil_plan'), 0),
          oil_fact: _.round(_.sumBy(dzo, 'oil_fact'), 0),
          oil_dlv_plan: _.round(_.sumBy(dzo, 'oil_dlv_plan'), 0),
          oil_dlv_fact: _.round(_.sumBy(dzo, 'oil_dlv_fact'), 0),
          gas_plan: _.round(_.sumBy(dzo, 'gas_plan'), 0),
          gas_fact: _.round(_.sumBy(dzo, 'gas_fact'), 0),
        })).value();

      let oil_planSum = _.reduce(
        SumFromRange,
        function (memo, item) {
          return memo + item.oil_plan;
        },
        0
      );

      let oil_factSum = _.reduce(
        SumFromRange,
        function (memo, item) {
          return memo + item.oil_fact;
        },
        0
      );

      let oil_dlv_planSum = _.reduce(
        SumFromRange,
        function (memo, item) {
          return memo + item.oil_dlv_plan;
        },
        0
      );

      let oil_dlv_factSum = _.reduce(
        SumFromRange,
        function (memo, item) {
          return memo + item.oil_dlv_fact;
        },
        0
      );

      let gas_planSum = _.reduce(
        SumFromRange,
        function (memo, item) {
          return memo + item.gas_plan;
        },
        0
      );

      let gas_factSum = _.reduce(
        SumFromRange,
        function (memo, item) {
          return memo + item.gas_fact;
        },
        0
      );

      return {
        oil_factSum: oil_factSum,
        oil_planSum: oil_planSum,
        oil_dlv_factSum: oil_dlv_factSum,
        oil_dlv_planSum: oil_dlv_planSum,
        gas_factSum: gas_factSum,
        gas_planSum: gas_planSum,
      };
    },
    getDefaultData() {
      this.oil_fact = '430';
      this.proceeds = '1913'; //выручка/доход
      this.costs = '1788';
      this.net_profit = '114'; //чистая прибыль
      this.capital_investment = '198'; //капиталовложения
      this.cash_flow = '-10';
    },
  },
  async mounted() {
    this.currentMonth = this.monthes3[this.month];
    this.lastMonth = this.monthes3[this.month-1];
    this.timestampToday = new Date(this.range.start).getTime();
    this.timestampEnd = new Date(this.range.end).getTime();
    this.selectedYear = this.year;
    this.getDefaultData();
    this.timeSelect = new Date().toLocaleDateString();
    this.getCurrencyNow(this.timeSelect);
    this.getOilNow(this.timeSelect, this.period);
    this.getCurrencyPeriod(this.timeSelect, this.periodUSD);
    this.getProductionOilAndGas();
  }
}