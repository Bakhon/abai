import { EventBus } from "../../event-bus.js";
import Calendar from "v-calendar/lib/components/calendar.umd";
import DatePicker from "v-calendar/lib/components/date-picker.umd";
Vue.component("calendar", Calendar);
Vue.component("date-picker", DatePicker);
export default {
  components: {
    Calendar,
    DatePicker,
  },
  template: "#vue-status-overview-template",
  data: function () {
    return {
      productionFactPercentSumm: '',
      quantityRange: '',
      productionFactPersent: '',
      productionPlanPersent: '',
      quantityGetProductionOilandGas: "",
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
      oil_factDayPercent: "",
      oil_dlv_factDayPercent: "",
      gas_factDayPercent: "",
      oil_factDay: "",
      oil_planDay: "",
      oil_dlv_factDay: "",
      oil_dlv_planDay: "",
      gas_factDay: "",
      gas_planDay: "",
      oil_dlv_factDayProgressBar: "",
      oil_factDayProgressBar: "",
      gas_factDayProgressBar: "",
      selectedDate: "",
      tableHover1: "",
      tableHover2: "",
      tableHover3: "",
      tableHover4: "",
      tableHover5: "",
      tableHover6: "",
      tableHover7: "",
      changeMenuButton: "color: #fff;",
      changeMenuButton1: "",
      changeMenuButton2: "",
      changeMenuButton3: "",
      changeMenuButton4: "",
      changeMenuButton5: "",
      Table1: "display:block;",
      Table2: "display:none;",
      Table3: "display:none;",
      Table4: "display:none;",
      Table5: "display:none;",
      Table6: "display:none;",
      Table7: "display:none;",
      //oil and currency down
      currencyNow: "",
      currencyChart: "",
      currencyNowUsd: "",
      selectedDMY2: "",
      selectedDMY: "",
      periodSelectOil: "",
      oilPeriod: "",
      period: "7",
      periodUSD: "7",
      company: "",
      timeSelect: "",
      oilNow: "",
      oilChart: "",
      //oil and currency up
      index: "",
      widthProgress: "90",
      //showTableItem: "No",]
      DMY: "День",
      item: "oil_plan",
      item2: "oil_fact",
      item3: "Добыча нефти",
      item4: "тн",
      productionForChart: "",
      tables: "",
      showTable2: "Yes",
      displayTable: "display: none;",
      displayChart: "display: none;",
      showTableOn: "",
      buttonHover: "border: none;" + " background: #2E50E9;color:white",
      buttonHover1: "",
      buttonHover2: "",
      buttonHover3: "",
      buttonHover4: "",
      buttonHover5: "",
      buttonHover6: "",
      buttonHover7: "",
      buttonHover8: "",
      buttonHover9: "",
      buttonHover10: "",
      buttonHover11: "",//this.changeMenuButton,
      buttonHover12: "",//this.changeMenuButton,
      buttonHover13: "",

      tableHover7: "",
      tableHover8: "",
      tableHover9: "",
      tableHover10: "",
      tableHover11: "",
      tableHover12: "",

      circleMenu: "",
      month: new Date().getMonth() + 1,
      year: new Date().getFullYear(),
      currentMonth: [],
      ChartTable: "График",
      date2: new Date().toLocaleString("ru", {
        /*year: 'numeric',
  month: 'long',
  day: 'numeric',
  weekday: 'long',
  timezone: 'UTC',*/
        hour: "numeric",
        minute: "numeric",
        //second: 'numeric'
      }),

      date3: new Date().toLocaleString("ru", {
        weekday: "long",
      }),
      dFirstMonth: "0",
      day: ["Mn", "Tu", "We", "Th", "Fr", "Sa", "Su"],
      monthes: [
        "ЯНВАРЬ",
        "ФЕВРАЛЬ",
        "МАРТ",
        "АПРЕЛЬ",
        "МАЙ",
        "ИЮНЬ",
        "ИЮЛЬ",
        "АВГУСТ",
        "СЕНТЯБРЬ",
        "ОКТЯБРЬ",
        "НОЯБРЬ",
        "ДЕКАБРЬ",
      ],
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
      monthes2: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],

      NameDzoFull: [
        "Всего добыча нефти с учётом доли участия АО НК КазМунайГаз",
        'АО "Озенмунайгаз" (100%)',
        'АО "Эмбамунайгаз" (100%)',
        'АО "Каражанбасмунай" (50%)',
        'ТОО "Казгермунай" (50%)',
        "ТОО «Тенгизшевройл»",
        'АО "Мангистаумунайгаз" (50%)',
        'ТОО "Казахтуркмунай" (100%)',
        'ТОО "Казахойл Актобе" (50%)',
        '"ПетроКазахстан Инк."',
        '"Амангельды Газ"',
        "«Карачаганак Петролеум Оперейтинг б.в.»",
        "«Норт Каспиан Оперейтинг Компани н.в.»",
        "(конденсат)(100%)",
        "в т.ч.:газовый конденсат",
      ],
      date: new Date(),
      selectedDay: undefined,
      selectedMonth: undefined,
      selectedYear: undefined,
      selectedDMY: 0,

      wells: [""],
      wells2: [""],
      bigTable: [""],
      displayHeadTables: "",
      starts: [""],
      test: [""],
      series: ["", ""],
      display: "none",
      company: "all",
      factYearSumm: "",
      planYearSumm: "",
      planMonthSumm: "",
      factMonthSumm: "",
      factDaySumm: "",
      planDaySumm: "",
      timestampToday: "",
      timestampEnd: "",
    };
  },
  methods: {
    saveCompany(com) {
     // localStorage.setItem("company", com);
     // var company = localStorage.getItem("company");
     var company = com;
    // this.company = com;

      this.getProductionOilandGas();
      this.getProductionOilandGasPercent();

      /*  var buttonMenuHover =
        "background: url(../img/visualcenter/circle-menu-white.png) no-repeat;" +
        "background-size: 9% auto;" +
        "background-position: 75% 50%;" +
        "border: none;" +
        "height: 40px;" +
        "pointer-events: none;";

      if (company == "ОМГ") {
        this.buttonMenuHover1 = buttonMenuHover;
      } else {
        this.buttonMenuHover1 = "";
      }
      if (company == "КБМ") {
        this.buttonMenuHover2 = buttonMenuHover;
      } else {
        this.buttonMenuHover2 = "";
      }

      if (company == "КГМ") {
        this.buttonMenuHover3 = buttonMenuHover;
      } else {
        this.buttonMenuHover3 = "";
      }

      if (company == "ЭМГ") {
        this.buttonMenuHover4 = buttonMenuHover;
      } else {
        this.buttonMenuHover4 = "";
      }

      if (company == "ММГ") {
        this.buttonMenuHover5 = buttonMenuHover;
      } else {
        this.buttonMenuHover5 = "";
      }

      if (company == "КТМ") {
        this.buttonMenuHover6 = buttonMenuHover;
      } else {
        this.buttonMenuHover6 = "";
      }

      if (company == "КОА") {
        this.buttonMenuHover7 = buttonMenuHover;
      } else {
        this.buttonMenuHover7 = "";
      }

      if (company == "ПКИ") {
        this.buttonMenuHover8 = buttonMenuHover;
      } else {
        this.buttonMenuHover8 = "";
      }

      if (company == "АГГ") {
        this.buttonMenuHover9 = buttonMenuHover;
      } else {
        this.buttonMenuHover9 = "";
      }

      if (company == "all") {
        this.buttonMenuHover10 = buttonMenuHover;

      } else {
        this.buttonMenuHover10 = "";
      }*/

      this.company = com;
      this.getProduction(this.item, this.item2, this.item3, this.item4);
    },
    changeTable(change) {
      this.Table1 = "display:none";
      this.Table2 = "display:none";
      this.Table3 = "display:none";
      this.Table4 = "display:none";
      this.Table5 = "display:none";
      this.Table6 = "display:none";
      this.Table7 = "display:none";

      this.tableHover1 = "";
      this.tableHover2 = "";
      this.tableHover3 = "";
      this.tableHover4 = "";
      this.tableHover5 = "";
      this.tableHover6 = "";
      this.tableHover7 = "";
      var buttonHover2 = " background: #0d2792";

      if (change == "1") {
        this.Table1 = "display:block";
        this.tableHover1 = buttonHover2;
      } else if (change == "2") {
        this.Table2 = "display:block";
        this.tableHover2 = buttonHover2;
      } else if (change == "3") {
        this.Table3 = "display:block";
        this.tableHover3 = buttonHover2;
      } else if (change == "4") {
        this.Table4 = "display:block";
        this.tableHover4 = buttonHover2;
      } else if (change == "5") {
        this.Table5 = "display:block";
        this.tableHover5 = buttonHover2;
      } else if (change == "6") {
        this.Table6 = "display:block";
        this.tableHover6 = buttonHover2;
      } else if (change == "7") {
        this.Table7 = "display:block";
        this.tableHover7 = buttonHover2;
      }
    },

    changeMenu(change) {
      var changeMenuButton = this.changeMenuButton;
      this.changeMenuButton1 = "color: ##237deb";
      this.changeMenuButton2 = "color: ##237deb";
      this.changeMenuButton3 = "color: ##237deb";
      this.changeMenuButton4 = "color: ##237deb";
      this.changeMenuButton5 = "color: ##237deb";


      if (change == "101") {
        this.changeMenuButton1 = changeMenuButton;
      }

      if (change == "102") {
        this.changeMenuButton2 = changeMenuButton;
      }

      if (change == "103") {
        this.changeMenuButton3 = changeMenuButton;
      }

      if (change == "104") {
        this.changeMenuButton4 = changeMenuButton;
      }

      if (change == "105") {
        this.changeMenuButton5 = changeMenuButton;
      }
    },


    changeMenu2(change) {

      var buttonHover = this.buttonHover;
      if (change == 1) {

        this.buttonHover7 = buttonHover;
        this.range = {
          start: new Date(),
          end: new Date(),
          formatInput: true,
        };

        //this.updateValue();

        //this.range.start = new Date();
        //this.range.end = new Date();

        this.changeDate();

      } else {
        this.buttonHover7 = "";
      }

      if (change == 2) {
        this.buttonHover8 = buttonHover;
        this.range = {
          start: new Date(this.year + '-' + this.month + '-01T06:00:00+06:00'),
          end: new Date(),
          formatInput: true,
        };


        this.changeDate();
      } else {
        this.buttonHover8 = "";
      }

      if (change == 3) {
        this.buttonHover9 = buttonHover;
        this.range = {
          start: new Date(this.year + '-' + '01' + '-01T06:00:00+06:00'),
          end: new Date(),
          formatInput: true,
        };
        //  this.updateValue();      
        this.changeDate();
      } else {
        this.buttonHover9 = "";
      }

      if (change == 4) {
        this.buttonHover10 = buttonHover;
      } else {
        this.buttonHover10 = "";
      }
    },


    /*updateValue()
    {this.range, {
                formatInput: true,
      }},*/



    changeAssets(change) {
      var changeMenuButton = this.changeMenuButton;
      this.buttonHover11 = "";
      this.buttonHover12 = "";
      this.buttonHover13 = "";

      if (change == "b11") {
        this.buttonHover11 = changeMenuButton;
        this.NameDzoFull[0] = 'Итого по операционным активам:';
        this.changeDate();
      }

      if (change == "b12") {
        this.buttonHover12 = changeMenuButton;
        this.NameDzoFull[0] = 'Итого по неоперационным активам:';
        this.changeDate();
      }

      if (change == "b13") {
        this.buttonHover13 = changeMenuButton;
        this.NameDzoFull[0] = 'Итого по всем активам:';
        this.changeDate();
      }

    },

    //currency and oil down
    periodSelectFunc() {
      var DMY = ["7 дней", "1 мес", "6 мес", "1 год", "5 лет"];
      var menuDMY = [];
      var id = 0;
      for (let i = 0; i <= 4; i++) {
        var a = { index: i, id: i };
        a.DMY = DMY[i];
        menuDMY.push(a);
        if (this.selectedDMY == i) {
          a.current = "#fff";
          this.DMY = menuDMY[i]["DMY"];
        }
        if (this.selectedDMY2 == i) {
          a.current2 = "#fff";
          this.DMY = menuDMY[i]["DMY"];
        }
      }

    /*  if (this.selectedDMY != undefined) {
      }*/

      // localStorage.setItem("selectedDMY", this.selectedDMY);

      return menuDMY;
      // this.periodSelect();
    },

    periodSelect: function (event) {
      if (this.selectedDMY == 0) {
        this.period = 7;
      }
      if (this.selectedDMY == 1) {
        this.period = 30;
      }
      if (this.selectedDMY == 2) {
        this.period = 183;
      }
      if (this.selectedDMY == 3) {
        this.period = 365;
      }
      if (this.selectedDMY == 4) {
        this.period = 1825;
      }
      return this.getOilNow(this.timeSelect, this.period);
    },

    periodSelectUSD: function (event) {
      if (this.selectedDMY2 == 0) {
        this.periodUSD = 7;
      }
      if (this.selectedDMY2 == 1) {
        this.periodUSD = 30;
      }
      if (this.selectedDMY2 == 2) {
        this.periodUSD = 183;
      }
      if (this.selectedDMY2 == 3) {
        this.periodUSD = 365;
      }
      if (this.selectedDMY2 == 4) {
        this.periodUSD = 1825;
      }
      return this.getCurrencyPeriod(this.timeSelect, this.periodUSD);
    },

    getCurrencyNow(dates) {
      let uri = "/ru/getcurrency?fdate=" + dates + "";
      this.axios.get(uri).then((response) => {
        var data = response.data;
        if (data) {
          //console.log(data);
          this.currencyNow = parseInt(data.description * 10) / 10;
          this.currencyNowUsd = parseInt(data.description * 10) / 10;
        } else {
          console.log("No data");
        }
      });
    },

    getCurrencyPeriod: function (dates, item2) {
      var dates = dates;
      let uri =
        "/ru/getcurrencyperiod?dates=" + dates + "&period=" + item2 + " ";
      this.axios.get(uri).then((response) => {
        var data = response.data;
        if (data) {
          var arrdata2 = [];
          _.forEach(data, function (item) {
            arrdata2.push({ dates: item.dates, value: item.description["0"] });
          });

          //var currencyChart = Array({ data: arrdata2 });
          this.$emit("currencyChart", arrdata2);
          //this.currencyChart = currencyChart;
        } else {
          console.log("No data");
        }
      });
    },

    getOilNow(dates, period) {
      var timestampToday = this.timestampToday;
      let uri = "/js/json/graph_1006.json";
      //let uri =        "https://cors-anywhere.herokuapp.com/" +        "https://yandex.ru/news/quotes/graph_1006.json";
      this.axios.get(uri).then((response) => {
        var data = response.data;
        if (data) {
          var oilDate;
          var oilDate2;
          var oilValue;
          var splits = [];
          var oil = [];
          var oil2;
          _.forEach(data.prices, function (prices) {
            splits = prices.toString().split(",");
            oilValue = splits["1"];
            oilDate = Number(splits["0"]);

            (oilDate2 = new Date(oilDate).toLocaleString("ru", {
              year: "numeric",
              day: "numeric",
              month: "numeric",
              timeZone: "Europe/Moscow",
            })),
              oil.push({
                dateSimple: oilDate,
                date: oilDate2,
                value: oilValue,
              });
          });

          var oil2 = [];

          oil2 = _.filter(oil, _.iteratee({ date: dates }));

          if (oil2.length != "0") {
            this.oilNow = Number(oil2[0].value).toFixed(1);
          } else {
            oil2 = _.last(oil);
            /*var oilNow2=oil.value;
            oilNow2=oilNow2.toFixed(1);*/

            this.oilNow = Number(oil2.value).toFixed(1);
          }

          var datesNow = [];
          datesNow = dates.split(".");
          var day = datesNow[0];
          var month = datesNow[1].replace(/^0+/, "");
          var year = datesNow[2];


          /*var timestampToday = new Date(
            this.monthes2[month - 1] + day + " " + year + " 06:00:00 GMT+0600"
          ).getTime();*/


          var dateInOil = [];

          dateInOil = _.filter(oil, function (item) {
            return _.every([
              _.inRange(
                item.dateSimple,
                timestampToday - 86400000 * Number(period),
                timestampToday + 86400000
              ),
            ]);
          });
          //this.oilChart=    [_.takeRight(oil, 31)];
          // this.oilChart = [dateInOil];
          this.$emit("oilChart", dateInOil);
        } else {
          console.log("No data");
        }
      });
    },
    //currency and oil up
    pushBign(bign) {
      // @click="pushBign('bign1')"
      switch (bign) {
        case "bign1":
          //  this.params.data = this.wellsList;
          break;
      }
      this.$modal.show(bign);
    },
    displaynumbers: function (event) {
      return this.getProduction(this.item, this.item2, this.item3, this.item4);
    },

    getColor(status) {
      if (status < "0") return "    margin-top: 17px;border-top: 10px solid #b40300";
      if (status == "0") return "    ";
      return "border-bottom: 10px solid #008a17";
    },


    getMonths: function () {
      var monthAll = [];
      var month = new Date(this.year, this.month + 1, 0).getMonth();

      for (let i = 1; i <= 12; i++) {
        if (new Date(this.year, this.month + 1, i)) {
          var a = { index: i, id: i };
          monthAll.push(a);
          if (this.selectedMonth == i) {
            a.current = "#232236";
          } else if (
            i == Number(new Date().getMonth() + 1) && //new Date().getMonth() &&
            this.year ==
            new Date().getFullYear() /* &&
        this.month == new Date().getMonth()*/
          ) {
            a.current = "#13B062";
          }
        }
      }
      if (this.selectedDMY == "1") {
        this.display = "none";
        return monthAll;
      }
    },

    getDays: function () {
      var DaysInMonth = [];
      var dlast = new Date(this.year, this.month + 1, 0).getDate();
      for (let i = 1; i <= dlast; i++) {
        var a = { index: i, id: i };
        DaysInMonth.push(a);
      }
      return DaysInMonth;
    },

    getDaysMonth: function () {
      var DaysInMonth = [];
      var dlast = new Date(this.year, this.selectedMonth, 0).getDate();
      for (let i = 1; i <= dlast; i++) {
        var a = { index: i, id: i };
        DaysInMonth.push(a);
      }
      return DaysInMonth;
    },

    getDaysInYear: function () {
      var getDaysInYear = [];
      for (let q = 1; q <= 12; q++) {
        var dlast = new Date(this.year, q, 0).getDate();
        for (let i = 1; i <= dlast; i++) {
          var a = { month: q, day: i };
          getDaysInYear.push(a);
        }
      }
      return getDaysInYear;
    },

    getYears: function () {
      var yearAll = [];
      var year = this.year;
      for (let i = 2018; i <= year; i++) {
        //if (this.year, this.month, i).getYear() ) {
        var a = { index: i, id: i };
        yearAll.push(a);
        if (this.selectedYear == i) {
          a.current = "#232236";
        } else if (
          i ==
          year /*&&
          this.year == new Date().getFullYear() &&
          this.month == new Date().getMonth()*/
        ) {
          a.current = "#13B062";
        }
      }

      if (this.selectedDMY == "2") {
        this.display = "none";
        return yearAll;
      }
    },

    menuDMY() {
      var DMY = ["День", "Месяц", "Год"];
      var menuDMY = [];
      var id = 0;
      for (let i = 0; i <= 2; i++) {
        var a = { index: i, id: i };
        a.DMY = DMY[i];
        menuDMY.push(a);
        if (this.selectedDMY == i) {
          a.current = "#1D70B7";
          this.DMY = menuDMY[i]["DMY"];
        }
      }
      if (this.selectedDMY != undefined) {
      }

      localStorage.setItem("selectedDMY", this.selectedDMY);

      return menuDMY;
    },
    pad(n) {
      return n < 10 ? "0" + n : n;
    },




    getProductionOilandGas() {
      //data from the day
      let uri = "/js/json/getnkkmg.json";
      //let uri = "/ru/getnkkmg";
      this.axios.get(uri).then((response) => {
        let data = response.data;
        if (data) {

          var timestampToday = this.timestampToday;
          var timestampEnd = this.timestampEnd;
var company = this.company;
          if (company != "all") {
                  data = _.filter(data, _.iteratee({ dzo: company }));
          }
          var dataWithMay = new Array();
          dataWithMay = _.filter(data, function (item) {
            return _.every([
              _.inRange(
                item.__time,
                timestampToday,
                timestampEnd + 86400000
              ),
            ]);
          });
          //this.quantityGetProductionOilandGas = Object.keys(dataWithMay).length;//k1q
          var quantityGetProductionOilandGas = Object.keys(_.filter(dataWithMay, _.iteratee({ dzo: dataWithMay[0].dzo }))).length;//k1q
          this.quantityGetProductionOilandGas = quantityGetProductionOilandGas;



          //Summ plan and fact from dzo
          var SummFromRange = _(dataWithMay)
            .groupBy("dzo")
            .map((dzo, id) => ({
              dzo: id,
              oil_plan: _.round(_.sumBy(dzo, 'oil_plan'), 0),
              oil_fact: _.round(_.sumBy(dzo, 'oil_fact'), 0),
              oil_dlv_plan: _.round(_.sumBy(dzo, 'oil_dlv_plan'), 0),
              oil_dlv_fact: _.round(_.sumBy(dzo, 'oil_dlv_fact'), 0),
              gas_plan: _.round(_.sumBy(dzo, 'gas_plan'), 0),
              gas_fact: _.round(_.sumBy(dzo, 'gas_fact'), 0),
            }))

            .value();


          var oil_planSumm = _.reduce(
            SummFromRange,
            function (memo, item) {
              return memo + item.oil_plan;
            },
            0
          );


          var oil_factSumm = _.reduce(
            SummFromRange,
            function (memo, item) {
              return memo + item.oil_fact;
            },
            0
          );


          var oil_dlv_planSumm = _.reduce(
            SummFromRange,
            function (memo, item) {
              return memo + item.oil_dlv_plan;
            },
            0
          );



          var oil_dlv_factSumm = _.reduce(
            SummFromRange,
            function (memo, item) {
              return memo + item.oil_dlv_fact;
            },
            0
          );



          var gas_planSumm = _.reduce(
            SummFromRange,
            function (memo, item) {
              return memo + item.gas_plan;
            },
            0
          );


          var gas_factSumm = _.reduce(
            SummFromRange,
            function (memo, item) {
              return memo + item.gas_fact;
            },
            0
          );

          this.oil_factDay = oil_factSumm;
          this.oil_planDay = oil_planSumm;
          this.oil_factDayProgressBar = (oil_factSumm / oil_planSumm) * 100;
          this.oil_dlv_factDay = oil_dlv_factSumm;
          this.oil_dlv_planDay = oil_dlv_planSumm;
          this.oil_dlv_factDayProgressBar = (oil_dlv_factSumm / oil_dlv_planSumm) * 100;
          this.gas_factDay = gas_factSumm;
          this.gas_planDay = gas_planSumm;
          this.gas_factDayProgressBar = (gas_factSumm / gas_planSumm) * 100;

        }
      });





    },



    getProductionOilandGasPercent() {     //data from the day
      let uri = "/js/json/getnkkmg.json";
      //let uri = "/ru/getnkkmg";
      this.axios.get(uri).then((response) => {
        let data = response.data;
        if (data) {

          var timestampToday = this.timestampToday;
          var timestampEnd = this.timestampEnd;
          var company = this.company;
          if (company != "all") {
                  data = _.filter(data, _.iteratee({ dzo: company }));
          }
          //var quantity = this.quantityGetProductionOilandGas;
          var quantityRange = this.quantityRange;

          var dataWithMay = new Array();
          dataWithMay = _.filter(data, function (item) {
            return _.every([
              _.inRange(
                item.__time,
                timestampToday - quantityRange * 86400000,
                timestampToday
              ),
            ]);
          });


          //Summ plan and fact from dzo
          var SummFromRange = _(dataWithMay)
            .groupBy("dzo")
            .map((dzo, id) => ({
              dzo: id,
              oil_plan: _.round(_.sumBy(dzo, 'oil_plan'), 0),
              oil_fact: _.round(_.sumBy(dzo, 'oil_fact'), 0),
              oil_dlv_plan: _.round(_.sumBy(dzo, 'oil_dlv_plan'), 0),
              oil_dlv_fact: _.round(_.sumBy(dzo, 'oil_dlv_fact'), 0),
              gas_plan: _.round(_.sumBy(dzo, 'gas_plan'), 0),
              gas_fact: _.round(_.sumBy(dzo, 'gas_fact'), 0),
            }))

            .value();


          var oil_planSumm = _.reduce(
            SummFromRange,
            function (memo, item) {
              return memo + item.oil_plan;
            },
            0
          );


          var oil_factSumm = _.reduce(
            SummFromRange,
            function (memo, item) {
              return memo + item.oil_fact;
            },
            0
          );


          var oil_dlv_planSumm = _.reduce(
            SummFromRange,
            function (memo, item) {
              return memo + item.oil_dlv_plan;
            },
            0
          );



          var oil_dlv_factSumm = _.reduce(
            SummFromRange,
            function (memo, item) {
              return memo + item.oil_dlv_fact;
            },
            0
          );



          var gas_planSumm = _.reduce(
            SummFromRange,
            function (memo, item) {
              return memo + item.gas_plan;
            },
            0
          );


          var gas_factSumm = _.reduce(
            SummFromRange,
            function (memo, item) {
              return memo + item.gas_fact;
            },
            0
          );

          this.oil_factDayPercent = oil_factSumm;
          this.gas_factDayPercent = gas_factSumm;
          this.oil_dlv_factDayPercent = oil_dlv_factSumm;  

        }
      });
    },

    getProduction(item, item2, item3, item4) {
      var timestampToday = this.timestampToday;
      var timestampEnd = this.timestampEnd;
     

      this.item = item;
      this.item2 = item2;
      this.item3 = item3;
      this.item4 = item4;

      localStorage.setItem("production-plan", item);
      localStorage.setItem("production-fact", item2);

      var productionPlan = localStorage.getItem("production-plan");
      var productionFact = localStorage.getItem("production-fact");

      this.circleMenu = item3;

      var company = this.company;

      if (company === null) {
        alert("Сначала выберите название компании");
      }

      //data from the year
      var data2;
      let uri2 = "/js/json/getnkkmgyear.json";
      this.axios.get(uri2).then((response) => {
        data2 = response.data;
      });

      //data from the day
      let uri = "/js/json/getnkkmg.json";
      //let uri = "/ru/getnkkmg";
      this.axios.get(uri).then((response) => {
        let data = response.data;
        if (data) {
          var NameDzoFull= this.NameDzoFull;
          var company = this.company;



        /*  if (company==='ЭМГ' ){  
            //NameDzoFull[2]
                      console.log('Выполняется');
         
            summForTables.push({dzo: NameDzoFull[2], productionFactForMonth:  1,  productionPlanForMonth: 1});
          } */

         
           if (company != "all") {              
            var arrdata = new Array();
            arrdata = _.filter(data, _.iteratee({ dzo: company }));

            var dataDay = [];
            dataDay = _.filter(arrdata, _.iteratee({ __time: timestampToday }));
            dataDay = _.orderBy(dataDay, ["dzo"], ["desc"]);
            this.wells = dataDay;
            this.wells2 = dataDay;
           

            //get data by Month        
            var dataWithMay = new Array();
            dataWithMay = _.filter(arrdata, function (item) {
              return _.every([
                _.inRange(
                  item.__time,
                  // 1588291200000, // May 2020
                  timestampToday,
                  timestampEnd + 86400000 //* dayInMonth
                ),
              ]);
            });

            var productionForChart = _(dataWithMay)
              .groupBy("__time")
              .map((__time, id) => ({
                time: id,
                productionFactForChart: _.round(_.sumBy(__time, productionFact), 0),
                productionPlanForChart: _.round(_.sumBy(__time, productionPlan), 0),
              }))
              .value();
            if (this.company != "all") {
              this.$emit("data", productionForChart); //k1q new
            }

            var summForTables = _(dataWithMay)
              .groupBy("dzo")
              .map((dzo, id) => ({
                dzo: id,
                productionFactForMonth: _.round(_.sumBy(dzo, productionFact), 0),
                productionPlanForMonth: _.round(_.sumBy(dzo, productionPlan), 0),
              }))
              .value();


         
    
            
                
              /*                           
                productionFactForMonth.push({ productionFact:1}, { productionFact: 1 }, { productionFact: 1 });
               planMonth.push({ planMonth:1}, { planMonth: 1 }, { planMonth: 1 });
               productionFactPercent.push({ productionFactPercent:0}, { productionFactPercent: 0 }, { productionFactPercent: 0 });*/  
              
    
              if (this.buttonHover12 != '') {
                productionFactForMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "ОМГ" }));
                productionFactForMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "КГМ" }));
                productionFactForMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "ММГ" }));
                productionFactForMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "КТМ" }));
                productionFactForMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "КБМ" }));
                productionFactForMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "КОА" }));
    
                data = _.reject(data, _.iteratee({ dzo: "ОМГ" }));
                data = _.reject(data, _.iteratee({ dzo: "КГМ" }));
                data = _.reject(data, _.iteratee({ dzo: "ММГ" }));
                data = _.reject(data, _.iteratee({ dzo: "КТМ" }));
                data = _.reject(data, _.iteratee({ dzo: "КБМ" }));
                data = _.reject(data, _.iteratee({ dzo: "КОА" }));
    
    
                dzoMonth.push({ dzoMonth: NameDzoFull[5] }, { dzoMonth: NameDzoFull[11] }, { dzoMonth: NameDzoFull[12] });
                factMonth.push({ factMonth: 1}, { factMonth: 1 }, { factMonth: 1 });
                planMonth.push({ planMonth:1}, { planMonth: 1 }, { planMonth: 1 });
                productionFactPercent.push({ productionFactPercent:0}, { productionFactPercent: 0 }, { productionFactPercent: 0 });
              }
    
              if (this.buttonHover13 != '') {
                dzoMonth.push({ dzoMonth: NameDzoFull[5] }, { dzoMonth: NameDzoFull[11] }, { dzoMonth: NameDzoFull[12] },{ dzoMonth: NameDzoFull[2] }, { dzoMonth: NameDzoFull[9] }, { dzoMonth: NameDzoFull[10] });
                factMonth.push({ factMonth: 1}, { factMonth: 1 }, { factMonth: 1},{ factMonth: 1}, { factMonth: 1 }, { factMonth: 1});
                planMonth.push({ planMonth:1}, { planMonth: 1 }, { planMonth: 1 },{ planMonth:1}, { planMonth: 1 }, { planMonth: 1 });
                productionFactPercent.push({ productionFactPercent:0}, { productionFactPercent: 0 }, { productionFactPercent: 0 },{ productionFactPercent:0}, { productionFactPercent: 0 }, { productionFactPercent: 0 });
              }

console.log(summForTables);
            this.tables = summForTables;
          }

          //all variables
          /*var NameDzoFull = this.NameDzoFull;
          var dzo2 = new Array();
          var dzoBriefly2 = new Array();
          var name;
          _.each(dzo, function (dzo) {
            if (String(dzo) === "ОМГ") {
              name = NameDzoFull[1];
            } else if (String(dzo) === "ММГ") {
              name = NameDzoFull[6];
            } else if (String(dzo) === "КТМ") {
              name = NameDzoFull[7];
            } else if (String(dzo) === "КОА") {
              name = NameDzoFull[8];
            } else if (String(dzo) === "КГМ") {
              name = NameDzoFull[4];
            } else if (String(dzo) === "КБМ") {
              name = NameDzoFull[3];
            }
            var dzoBriefly = dzo;
            dzo = name;

            dzoBriefly2.push({ dzoBriefly });
            dzo2.push({ dzo });
          });*/

          var buttonHover = this.buttonHover;
          if (productionPlan == "oil_plan") {
            this.buttonHover1 = buttonHover;
          } else {
            this.buttonHover1 = "";
          }
          if (productionPlan == "oil_dlv_plan") {
            this.buttonHover2 = buttonHover;
          } else {
            this.buttonHover2 = "";
          }

          if (productionPlan == "gas_plan") {
            this.buttonHover3 = buttonHover;
          } else {
            this.buttonHover3 = "";
          }

          if (productionPlan == "liq_plan") {
            this.buttonHover4 = buttonHover;
          } else {
            this.buttonHover4 = "";
          }

          if (productionPlan == "gk_plan") {
            this.buttonHover5 = buttonHover;
          } else {
            this.buttonHover5 = "";
          }

          if (productionPlan == "inj_plan") {
            this.buttonHover6 = buttonHover;
          } else {
            this.buttonHover6 = "";
          }

        } else {
          console.log("No data");
        }

        //bigtable
        //year
        if (this.company == "all") {
          var dataDay = [];
          var dataYear = [];
          var dzo = [];
          dataDay = data;
          dataYear = data2;
          var factYear = [];
          var planYear = [];
          var dataMonth = [];
          var dzoYear = [];
          dataMonth = _.filter(
            data2,
            _.iteratee({ period: "2020 (с начала года)" })
          );

          dataMonth = _.orderBy(dataMonth, ["dzo"], ["desc"]);

          _.forEach(dataMonth, function (item) {
            var e = [];
            e = { dzoYear: item.dzo };
            dzoYear.push(e);

            var f = [];
            f = { factYear: Math.ceil(item[productionFact]) };
            factYear.push(f);
            var p = [];
            p = { planYear: Math.ceil(item[productionPlan]) };
            planYear.push(p);
          });

          var dataWithMay = new Array();
          dataWithMay = _.filter(data, function (item) {
            return _.every([
              _.inRange(
                item.__time,
                timestampToday,
                timestampEnd + 86400000
              ),
            ]);
          });

          //Summ plan and fact from dzo k1q!!!
          var productionPlanAndFactMonth = _(dataWithMay)
            .groupBy("dzo")
            .map((dzo, id) => ({
              dzo: id,
              productionFactForChart: _.round(_.sumBy(dzo, productionFact), 0),
              productionPlanForChart: _.round(_.sumBy(dzo, productionPlan), 0),
            }))

            .value();

          productionPlanAndFactMonth = _.orderBy(
            productionPlanAndFactMonth,
            ["dzo"],
            ["desc"]
          );

          var productionForChart = _(dataWithMay)
            .groupBy("__time")
            .map((__time, id) => ({
              time: id,
              productionFactForChart: _.round(_.sumBy(__time, productionFact), 0),
              productionPlanForChart: _.round(_.sumBy(__time, productionPlan), 0),
            }))
            .value();

          var dzo2 = [];
          var planMonth = [];
          var factMonth = [];
          var oil_fact = [];
          var oil_plan = [];

          var e = [];
          var f = [];
          var p = [];
          var getMonthBigTable = [];


          _.forEach(dataWithMay, function (item) {
            e = { dzo2: item.dzo };
            f = { factMonth: Math.ceil(item[productionFact]) };
            p = { planMonth: Math.ceil(item[productionPlan]) };
            oil_fact = { oil_fact: item.oil_fact };
            oil_plan = { oil_plan: item.oil_plan };
            getMonthBigTable.push([e, f, p, oil_fact, oil_plan]);
          });

          var factMonth = _.reduce(
            factMonth,
            function (memo, item) {
              return memo + item.productionFact;
            },
            0
          );

          var planMonth = _.reduce(
            planMonth,
            function (memo, item) {
              return memo + item[productionPlan];
            },
            0
          );

          var dataDay = [];


          dataDay = _.filter(data, _.iteratee({ __time: timestampToday }));
          dataDay = _.orderBy(dataDay, ["dzo"], ["desc"]);

          var dzoDay = [];
          var factDay = [];
          var planDay = [];
          var inj_wells_idle = [];
          var inj_wells_work = [];
          var prod_wells_work = [];
          var prod_wells_idle = [];
          var starts_krs = [];
          var starts_prs = [];
          var starts_drl = [];
          var NameDzoFull = this.NameDzoFull;
          var dzoBriefly = [];
          var dzoPercent = [];
          var productionFactPercent = [];


    
          
            _.forEach(dataDay, function (item) {

            /*  if (String(item.dzo) === "ОМГ") {
                name = NameDzoFull[1];
              } else if (String(item.dzo) === "ММГ") {
                name = NameDzoFull[6];
              } else if (String(item.dzo) === "КТМ") {
                name = NameDzoFull[7];
              } else if (String(item.dzo) === "КОА") {
                name = NameDzoFull[8];
              } else if (String(item.dzo) === "КГМ") {
                name = NameDzoFull[4];
              } else if (String(item.dzo) === "КБМ") {
                name = NameDzoFull[3];
              }*/

              dzoBriefly.push({ dzoBriefly: item.dzo });
              e = { dzoDay: name };
              f = { factDay: Math.ceil(item[productionFact]) };
              p = { planDay: Math.ceil(item[productionPlan]) };

              dzoDay.push(e);
              factDay.push(f);
              planDay.push(p);
              inj_wells_idle.push({ inj_wells_idle: item.inj_wells_idle });
              inj_wells_work.push({ inj_wells_work: item.inj_wells_work });
              prod_wells_work.push({ prod_wells_work: item.prod_wells_work });
              prod_wells_idle.push({ prod_wells_idle: item.prod_wells_idle });
              starts_krs.push({ starts_krs: item.starts_krs });
              starts_prs.push({ starts_prs: item.starts_prs });
              starts_drl.push({ starts_drl: item.starts_drl });
            });

            
         
        
          var starts_krs = _.reduce(
            starts_krs,
            function (memo, item) {
              return memo + item.starts_krs;
            },
            0
          );

          var starts_prs = _.reduce(
            starts_prs,
            function (memo, item) {
              return memo + item.starts_prs;
            },
            0
          );

          var starts_drl = _.reduce(
            starts_drl,
            function (memo, item) {
              return memo + item.starts_drl;
            },
            0
          );

          var inj_wells_idle = _.reduce(
            inj_wells_idle,
            function (memo, item) {
              return memo + item.inj_wells_idle;
            },
            0
          );

          var inj_wells_work = _.reduce(
            inj_wells_work,
            function (memo, item) {
              return memo + item.inj_wells_work;
            },
            0
          );

          var prod_wells_work = _.reduce(
            prod_wells_work,
            function (memo, item) {
              return memo + item.prod_wells_work;
            },
            0
          );

          var prod_wells_idle = _.reduce(
            prod_wells_idle,
            function (memo, item) {
              return memo + item.prod_wells_idle;
            },
            0
          );

          var dzoMonth = [];
          var factMonth = [];
          var planMonth = [];

          if (this.buttonHover11 != '') {        
            dzoMonth.push(
              { dzoMonth: "ЭМГ" }, { dzoMonth: "ПКИ" }, { dzoMonth: "АМГ" }
              //{ dzoMonth: NameDzoFull[2] }, { dzoMonth: NameDzoFull[9] }, { dzoMonth: NameDzoFull[10] }
              );                         
           factMonth.push({ factMonth:1}, { factMonth: 1 }, { factMonth: 1 });
           planMonth.push({ planMonth:1}, { planMonth: 1 }, { planMonth: 1 });
           productionFactPercent.push({ productionFactPercent:0}, { productionFactPercent: 0 }, { productionFactPercent: 0 });  
          }

          if (this.buttonHover12 != '') {
            productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "ОМГ" }));
            productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "КГМ" }));
            productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "ММГ" }));
            productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "КТМ" }));
            productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "КБМ" }));
            productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "КОА" }));

            data = _.reject(data, _.iteratee({ dzo: "ОМГ" }));
            data = _.reject(data, _.iteratee({ dzo: "КГМ" }));
            data = _.reject(data, _.iteratee({ dzo: "ММГ" }));
            data = _.reject(data, _.iteratee({ dzo: "КТМ" }));
            data = _.reject(data, _.iteratee({ dzo: "КБМ" }));
            data = _.reject(data, _.iteratee({ dzo: "КОА" }));


            dzoMonth.push({ dzoMonth: NameDzoFull[5] }, { dzoMonth: NameDzoFull[11] }, { dzoMonth: NameDzoFull[12] });
            factMonth.push({ factMonth: 1}, { factMonth: 1 }, { factMonth: 1 });
            planMonth.push({ planMonth:1}, { planMonth: 1 }, { planMonth: 1 });
            productionFactPercent.push({ productionFactPercent:0}, { productionFactPercent: 0 }, { productionFactPercent: 0 });
          }

          if (this.buttonHover13 != '') {
            dzoMonth.push({ dzoMonth: NameDzoFull[5] }, { dzoMonth: NameDzoFull[11] }, { dzoMonth: NameDzoFull[12] },{ dzoMonth: NameDzoFull[2] }, { dzoMonth: NameDzoFull[9] }, { dzoMonth: NameDzoFull[10] });
            factMonth.push({ factMonth: 1}, { factMonth: 1 }, { factMonth: 1},{ factMonth: 1}, { factMonth: 1 }, { factMonth: 1});
            planMonth.push({ planMonth:1}, { planMonth: 1 }, { planMonth: 1 },{ planMonth:1}, { planMonth: 1 }, { planMonth: 1 });
            productionFactPercent.push({ productionFactPercent:0}, { productionFactPercent: 0 }, { productionFactPercent: 0 },{ productionFactPercent:0}, { productionFactPercent: 0 }, { productionFactPercent: 0 });
          }
     
      
       
          
  
         /*
         productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "ОМГ" }));
         productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "КГМ" }));
         data = _.reject(data, _.iteratee({ dzo: "ОМГ" }));
         data = _.reject(data, _.iteratee({ dzo: "КГМ" }));*/


         
          //productionPlanAndFactMonth= _.reject([{dzo:"ОМГ"}]);
      
          _.forEach(productionPlanAndFactMonth, function (item) { //k1q!!!
            factMonth.push({ factMonth: item.productionFactForChart });
            planMonth.push({ planMonth: item.productionPlanForChart });
            dzoMonth.push({ dzoMonth: item.dzo });
          });
          

         
  

    
     
//changed data reject
          var getProductionPercent = this.getProductionPercent(data);
          getProductionPercent = _.orderBy(getProductionPercent, ["dzoPercent"], ["desc"]);


          _.forEach(getProductionPercent, function (item) {
           // dzoPercent.push({ dzoPercent: item.dzoPercent });
            productionFactPercent.push({ productionFactPercent: item.productionFactPercent });
          });













        //if (this.buttonHover11 != '') {

          //summ table value
          var factYearSumm = _.reduce(
            factYear,
            function (memo, item) {
              return memo + item.factYear;
            },
            0
          );

          var planYearSumm = _.reduce(
            planYear,
            function (memo, item) {
              return memo + item.planYear;
            },
            0
          );

          var planMonthSumm = _.reduce(
            planMonth,
            function (memo, item) {
              return memo + item.planMonth;
            },
            0
          );

          var factMonthSumm = _.reduce(
            factMonth,
            function (memo, item) {
              return memo + item.factMonth;
            },
            0
          );

          var factDaySumm = _.reduce(
            factDay,
            function (memo, item) {
              return memo + item.factDay;
            },
            0
          );

          var planDaySumm = _.reduce(
            planDay,
            function (memo, item) {
              return memo + item.planDay;
            },
            0
          );

          this.factYearSumm = factYearSumm;
          this.planYearSumm = planYearSumm;
          this.planMonthSumm = planMonthSumm;
          this.factMonthSumm = factMonthSumm;
          this.factDaySumm = factDaySumm;
          this.planDaySumm = planDaySumm;
          


          var productionFactPercentSumm = _.reduce(
            productionFactPercent,
            function (memo, item) {
              return memo + item.productionFactPercent;
            },
            0
          );
      

          this.productionFactPercentSumm = productionFactPercentSumm;

          var bigTable = _.zipWith(
            productionFactPercent,
            dzoPercent,
            //getProductionPercent
           // dzoBriefly,
            /* dzoYear,,*/
            dzoMonth,
            //factYear
            dzo,
            dzo2,
            /* planYear,*/
            planMonth,
            factMonth,
           // dzoDay,
           // factDay,
           // planDay,
            (
              productionFactPercent,
              dzoPercent,
             //dzoBriefly,
              /*  dzoYear,*/
              dzoMonth,
              //factYear,
              dzo,
              dzo2,
              /*  planYear,*/
              planMonth,
              factMonth,
             // dzoDay,
             // factDay,
            //  planDay
            ) =>
              _.defaults(
                productionFactPercent,
                dzoPercent,
               // dzoBriefly,
                /*  dzoYear,*/
                dzoMonth,
                //factYear,
                dzo,
                dzo2,
                /*  planYear,*/
                planMonth,
                factMonth,
              //  dzoDay,
              //  factDay,
              //  planDay
              )
          );


          bigTable = _.orderBy(bigTable, ["dzoMonth"], ["desc"]);

//console.log(bigTable);
          this.bigTable = bigTable;



          var wells = [];
          wells = _.zipWith(
            [{ inj_wells_idle: inj_wells_idle }],
            [{ inj_wells_work: inj_wells_work }],
            (inj_wells_idle, inj_wells_work) =>
              _.defaults(inj_wells_idle, inj_wells_work)
          );

          this.wells = wells;

          var wells2 = _.zipWith(
            [{ prod_wells_work: prod_wells_work }],
            [{ prod_wells_idle: prod_wells_idle }],

            (prod_wells_work, prod_wells_idle) =>
              _.defaults(prod_wells_work, prod_wells_idle)
          );

          this.wells2 = wells2;

          var starts = _.zipWith(
            [{ starts_krs: starts_krs }],
            [{ starts_prs: starts_prs }],
            [{ starts_drl: starts_drl }],

            (prod_wells_work, prod_wells_idle) =>
              _.defaults(prod_wells_work, prod_wells_idle)
          );

          this.starts = starts;

          this.$emit("data", productionForChart);

          productionForChart = { data: productionForChart };
          this.productionForChart = productionForChart;
        }
      });
      this.showTable(localStorage.getItem("changeButton"));
    },



    getProductionPercent(data) {
      var timestampToday = this.timestampToday;
      var timestampEnd = this.timestampEnd
      var quantityRange = this.quantityRange;


      var productionPlan = localStorage.getItem("production-plan");
      var productionFact = localStorage.getItem("production-fact");


      //console.log(this.quantityGetProductionOilandGas);

      var dataWithMay = new Array();
      dataWithMay = _.filter(data, function (item) {
        return _.every([
          _.inRange(
            item.__time,
            timestampToday - quantityRange * 86400000,
            timestampToday
          ),
        ]);
      });


      var productionForChart = _(dataWithMay)
        .groupBy("dzo")
        .map((dzo, id) => ({
          dzoPercent: id,
          productionFactPercent: _.round(_.sumBy(dzo, productionFact), 0),
          productionPlanPercent: _.round(_.sumBy(dzo, productionPlan), 0),
        }))
        .value();
      return productionForChart;
    },

    changeButton(showTableItem, changeButton) {
      var a;
      if (changeButton == "Yes") {
        if (showTableItem == "Yes") {
          a = "No";
        } else {
          a = "Yes";
        }
        this.showTable2 = a;
        localStorage.setItem("changeButton", a);
      }
      this.showTable(localStorage.getItem("changeButton"));
    },

    showTable(showTableItem, changeButton) {
      var showTableOn =
        " border: none;" +
        "color: white;" +
        "background: url(../img/level1/button-on.png) no-repeat;" +
        "background-size: 16% auto;" +
        "background-position: 80% 50%;" +
        "outline: none;";

      if (showTableItem == "Yes") {
        this.ChartTable = "График";
        this.displayChart = "display:none;";

        if (this.company == "all") {
          this.displayHeadTables = "display: block";
          this.displayTable = "display:none;";
        } else {
          this.displayTable = "display:block;";
          this.displayHeadTables = "display: none";
        }
        this.showTableOn = ""; //colour button
      } else if (showTableItem == "No") {
        this.displayTable = "display:none;";
        this.displayHeadTables = "display: none";
        this.displayChart = "display:block;";
        this.ChartTable = "Таблица";
        this.displayHeadTables = "display: none";

        this.showTableOn = showTableOn; //colour button
      }
    },
    //When we change date
    changeDate() {
      //"27.05.2020"
      this.selectedDay = 0;
      this.timestampToday = new Date(this.range.start).getTime();
      this.timestampEnd = new Date(this.range.end).getTime();
      this.quantityRange = ((this.timestampEnd - this.timestampToday) / 86400000) + 1;
      var nowDate = new Date(this.range.start).toLocaleDateString();
      this.timeSelect = nowDate;
      this.getProduction(this.item, this.item2, this.item3, this.item4);
      this.getProductionOilandGas();
      this.getCurrencyNow(this.timeSelect);
      this.getOilNow(this.timeSelect, this.period);
      this.getProductionOilandGasPercent();
    },

        getNameDzoFull:function(dzo){
    var NameDzoFull=this.NameDzoFull; 
if (String(dzo) === "ОМГ") {
              name = NameDzoFull[1];
            } else if (String(dzo) === "ММГ") {
              name = NameDzoFull[6];
            } else if (String(dzo) === "КТМ") {
              name = NameDzoFull[7];
            } else if (String(dzo) === "КОА") {
              name = NameDzoFull[8];
            } else if (String(dzo) === "КГМ") {
              name = NameDzoFull[4];
            } else if (String(dzo) === "КБМ") {
              name = NameDzoFull[3];
            }
            else {name= dzo}
            return name;
          },

  },

  async mounted() {
    var nowDate = new Date().toLocaleDateString();
    this.timeSelect = nowDate;
    this.timestampToday = new Date(this.range.start).getTime();
    this.timestampEnd = new Date(this.range.end).getTime();
    if (this.company == "all") {
      // this.getProduction("oil_plan", "oil_fact", "Добыча нефти", "тн");
      //this.changeButton("No");
    }
    this.selectedYear = this.year;
    var productionPlan = localStorage.getItem("production-plan");
    var productionFact = localStorage.getItem("production-fact");

    localStorage.setItem("selectedDMY", "undefined");
    this.getCurrencyNow(this.timeSelect);
    this.getOilNow(this.timeSelect, this.period);
    this.getCurrencyPeriod(this.timeSelect, this.periodUSD);
    this.changeAssets('b11');
    // this.getProductionOilandGasPercent();
  },
  computed: {
  },

 /* filters: {
    replace: function (dzo) {
      var NameDzoFull=this.NameDzoFull; 
      if (String(dzo) === "ОМГ") {
        name = NameDzoFull[1];
      } else if (String(dzo) === "ММГ") {
        name = NameDzoFull[6];
      } else if (String(dzo) === "КТМ") {
        name = NameDzoFull[7];
      } else if (String(dzo) === "КОА") {
        name = NameDzoFull[8];
      } else if (String(dzo) === "КГМ") {
        name = NameDzoFull[4];
      } else if (String(dzo) === "КБМ") {
        name = NameDzoFull[3];
      }
      return name;

      //return '<strong>' + value + '</strong>'
    }}*/
  
};
