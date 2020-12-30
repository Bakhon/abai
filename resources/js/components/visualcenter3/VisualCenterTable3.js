import { EventBus } from "../../event-bus.js";
import Calendar from "v-calendar/lib/components/calendar.umd";
import DatePicker from "v-calendar/lib/components/date-picker.umd";
Vue.component("calendar", Calendar);
Vue.component("date-picker", DatePicker);
export default {
  components: {
    Calendar,
    DatePicker
  },
  data: function () {
    return {
      innerWellsButtonProstoi: 0,
      innerWellsButtonProstoi2: 0,
      nameChartLeft: 'Добыча нефти',
      oilChartHeadName: 'Динамика добычи нефти',     
      innerWells: [
        { name: "ЭФ", value: 603, value2: 101 },
        { name: "ДФ", value: 98, value2: 56 },
        { name: "В работе добывающие скважины", value: 45, value2: 31 },
        { name: "БД", value: 121, value2: 108 },
        { name: "Освоение", value: 143, value2: 114 },
        { name: "ОФЛС", value: 98, value2: 36 },
        { name: "Простой добывающих скважин", value: 86, value2: 54 }
      ],
      innerWells2:'',
      prod_wells_work: 0,
      prod_wells_idle: 0,
      inj_wells_idle: 0,
      inj_wells_work: 0,
      productionFactPercentOneDzo: '',
      productionFactPercentSumm: '',
      quantityRange: '',
      productionFactPersent: '',
      productionPlanPersent: '',
      quantityGetProductionOilandGas: "",
      /*calendar*/
      range: {
        start: "2020-12-18T06:00:00+06:00",
        end: "2020-12-18T09:00:00+06:00",
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
      changeMenuButton: "color: #fff;",
      changeMenuButton1: "",
      changeMenuButton2: "",
      changeMenuButton3: "",
      changeMenuButton4: "",
      changeMenuButton5: "",
      changeMenuButton6: "",
      changeMenuButton7: "",
      changeMenuButton8: "",
      changeMenuButton9: "",
      changeMenuButton10: "",
      changeMenuButton11: "",
      changeMenuButton12: "",
      changeMenuButton13: "",
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
      periodSelectOil: "",
      oilPeriod: "",
      period: "7",
      periodUSD: "7",
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
      displayChart: "display: none;",
      showTableOn: "",
      buttonHover: "border: none;" + " background: #2E50E9;color:white",
      buttonHover1: "",
      buttonHover2: "",
      buttonHover3: "",
      buttonHover4: "",
      buttonHover5: "",
      buttonHover6: "",
      buttonHover7: "border: none; background: #2E50E9;color:white",
      buttonHover8: "",
      buttonHover9: "",
      buttonHover10: "",
      buttonHover11: "color: #fff;",//this.changeMenuButton,
      buttonHover12: "",//this.changeMenuButton,
      buttonHover13: "",
      buttonHoverNagInnerWells: "",
      buttonHoverProdInnerWells: "",

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
        'АО "Озенмунайгаз"',
        'АО "Эмбамунайгаз"',
        'АО "Каражанбасмунай"',
        'ТОО "Казгермунай"',
        "ТОО «Тенгизшевройл»",
        'АО "Мангистаумунайгаз"',
        'ТОО "Казахтуркмунай"',
        'ТОО "Казахойл Актобе"',
        '"ПетроКазахстан Инк."',
        '"Амангельды Газ"',
        "«Карачаганак Петролеум Оперейтинг б.в.»",
        "«Норт Каспиан Оперейтинг Компани н.в.»",
        "(конденсат)(100%)",
        "в т.ч.:газовый конденсат",
        'АО "Тургай-Петролеум" (50%*33)',
      ],
      date: new Date(),
      selectedDay: undefined,
      selectedMonth: undefined,
      selectedYear: undefined,
      selectedDMY: 0,

      wells: [""],
      wells2: [""],
      bigTable: [""],
      displayTable: "display:  none;",
      displayHeadTables: "display: block;",
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
      this.company = com;
      this.getProduction(this.item, this.item2, this.item3, this.item4, this.nameLeftChart);
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
      this.changeMenuButton1 = '';
      this.changeMenuButton2 = '';
      this.changeMenuButton3 = '';
      this.changeMenuButton4 = '';
      this.changeMenuButton5 = '';
      this.changeMenuButton6 = '';
      this.changeMenuButton7 = '';
      this.changeMenuButton8 = '';
      this.changeMenuButton9 = '';
      this.changeMenuButton10 = '';
      this.changeMenuButton11 = '';
      this.changeMenuButton12 = '';
      this.changeMenuButton13 = '';




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


      if (change == "106") {
        this.changeMenuButton6= changeMenuButton;
      }

      if (change == "107") {
        this.changeMenuButton7 = changeMenuButton;
      }

      if (change == "108") {
        this.changeMenuButton8 = changeMenuButton;
      }

      if (change == "109") {
        this.changeMenuButton9 = changeMenuButton;
      }

      if (change == "110") {
        this.changeMenuButton10 = changeMenuButton;
      }

      if (change == "111") {
        this.changeMenuButton11 = changeMenuButton;
      }

      if (change == "112") {
        this.changeMenuButton12 = changeMenuButton;
      }

      if (change == "113") {
        this.changeMenuButton13 = changeMenuButton;
      }

    },

    dayClicked() {

  
      this.changeMenu2('4');
    },


    changeMenu2(change) {

      var buttonHover = this.buttonHover;
      if (change == 1) {

        this.buttonHover7 = buttonHover;
        //console.log(this.date.getDate() - 1);
        this.range = {
          start: new Date(this.year + '-' + this.month + '-' + this.pad(this.date.getDate() - 1) + 'T06:00:00+06:00'),
          //start: (this.date.setDate(this.date.getDate() - 1)),//.toISOString(),
          end: new Date().toISOString(),//"F j, Y", time() - 60 * 60 * 24

          //  start: new Date(this.year + '-' + this.month + '-04T06:00:00+06:00').toISOString(),
          // end: new Date(this.year + '-' + this.month + '-04T06:00:00+06:00').toISOString(),
          formatInput: true,
        };

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

      return menuDMY;

    },

    periodSelect(event) {
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

    periodSelectUSD(event) {
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
      let uri = this.localeUrl("/getcurrency?fdate=") + dates + "";
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
        this.localeUrl("/getcurrencyperiod?dates=") + dates + "&period=" + item2 + " ";
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
      let uri = "/js/json/graph_1006.json";
      //let uri =        "https://cors-anywhere.herokuapp.com/" +        "https://yandex.ru/news/quotes/graph_1006.json";
      this.axios.get(uri).then((response) => {
        var data = response.data;
        if (data) {
          var timestampToday = this.timestampToday;
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
          //console.log(dateInOil);
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
      return this.getProduction(this.item, this.item2, this.item3, this.item4, this.nameLeftChart);
    },

    getColor(status) {
      if (status < "0") return "margin-top: 0.6em;border-top: 10px solid #b40300";
      if (status == "0") return "    ";
      return "margin-top: 0.2em; border-bottom: 10px solid #008a17";
    },

    getColor2(status) {
      if (status < "0") return "margin-top:17em!important; border-top: 10px solid #b40300;margin-right:0.2em;";
      if (status == "0") return "    ";
      return "margin-top: 16.6em!important; border-bottom: 10px solid #008a17;margin-right:0.2em;";
    },


    /*   getMonths: function () {
         var monthAll = [];
         var month = new Date(this.year, this.month + 1, 0).getMonth();
   
         for (let i = 1; i <= 12; i++) {
           if (new Date(this.year, this.month + 1, i)) {
             var a = { index: i, id: i };
             monthAll.push(a);
             if (this.selectedMonth == i) {
               a.current = "#232236";
             } else if (
               i == Number(new Date().getMonth() + 1) && 
               this.year ==
               new Date().getFullYear() 
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
             year 
           ) {
             a.current = "#13B062";
           }
         }
   
         if (this.selectedDMY == "2") {
           this.display = "none";
           return yearAll;
         }
       },*/

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




    getProductionOilandGas(data) {
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

        if (oil_factSumm) { this.oil_factDay = oil_factSumm; }
        if (oil_planSumm) { this.oil_planDay = oil_planSumm; }
        if (oil_factSumm || oil_planSumm) { this.oil_factDayProgressBar = (oil_factSumm / oil_planSumm) * 100; }

        if (oil_dlv_factSumm) { this.oil_dlv_factDay = oil_dlv_factSumm; }
        if (oil_dlv_planSumm) { this.oil_dlv_planDay = oil_dlv_planSumm; }
        if (oil_dlv_factSumm || oil_dlv_planSumm) { this.oil_dlv_factDayProgressBar = (oil_dlv_factSumm / oil_dlv_planSumm) * 100; }

        if (gas_factSumm) { this.gas_factDay = gas_factSumm; }
        if (gas_planSumm) { this.gas_planDay = gas_planSumm; }
        if (gas_factSumm || gas_planSumm) { this.gas_factDayProgressBar = (gas_factSumm / gas_planSumm) * 100; }

      }
      //});
    },
    getProductionOilandGasPercent(data) {
      if (data) {
        var timestampToday = this.timestampToday;
        var timestampEnd = this.timestampEnd;
        var company = this.company;
        if (company != "all") {
          data = _.filter(data, _.iteratee({ dzo: company }));
        }

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
      // });
    },

    getProduction(item, item2, item3, item4, item5) {
      this.$store.commit('globalloading/SET_LOADING', true);
      var timestampToday = this.timestampToday;
      var timestampEnd = this.timestampEnd;


      this.item = item;
      this.item2 = item2;
      this.item3 = item3;
      this.item4 = item4;
      this.nameChartLeft = item5;

      localStorage.setItem("production-plan", item);
      localStorage.setItem("production-fact", item2);

      var productionPlan = localStorage.getItem("production-plan");
      var productionFact = localStorage.getItem("production-fact");

      this.circleMenu = item3;

      var company = this.company;

      if (company === null) {
        alert("Сначала выберите название компании");
      }

      //data from the day
      let uri = this.localeUrl("/visualcenter3GetData?timestampToday=") + this.timestampToday + "&timestampEnd=" + this.timestampEnd + " ";

      //let uri = this.localeUrl("/getnkkmg");
      // let uri = "/js/json/getnkkmg.json";
      this.axios.get(uri).then((response) => {
        let data = response.data;
        if (data) {
          //console.log(data);
          var NameDzoFull = this.NameDzoFull;
          var company = this.company;
          var summForTables = [];


         /* if (company === 'ПКИ') {
            summForTables.push({ dzo: NameDzoFull[9], productionFactForMonth: 1, productionPlanForMonth: 1 });
            this.tables = summForTables;
            this.productionFactPercentOneDzo = 0;
          }

          else if (company === 'АМГ') {
            summForTables.push({ dzo: NameDzoFull[10], productionFactForMonth: 1, productionPlanForMonth: 1 });
            this.tables = summForTables;
            this.productionFactPercentOneDzo = 0;
          }

          else if (company === 'ТШ') {
            summForTables.push({ dzo: NameDzoFull[5], productionFactForMonth: 1, productionPlanForMonth: 1 });
            this.tables = summForTables;
            this.productionFactPercentOneDzo = 0;
          }


          else if (company === 'НКО') {
            summForTables.push({ dzo: NameDzoFull[12], productionFactForMonth: 1, productionPlanForMonth: 1 });
            this.tables = summForTables;
            this.productionFactPercentOneDzo = 0;
          }

          else if (company === 'КПО') {
            summForTables.push({ dzo: NameDzoFull[11], productionFactForMonth: 1, productionPlanForMonth: 1 });
            this.tables = summForTables;
            this.productionFactPercentOneDzo = 0;
          }*/

          if (company != "all") {
            var arrdata = new Array();
            arrdata = _.filter(data, _.iteratee({ dzo: company }));


















            /*  this.wells = dataDay;
              this.wells2 = dataDay;*/


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

            dataWithMay = _.orderBy(
              dataWithMay,
              ["__time"],
              ["asc"]
            );


            this.innerWells = this.innerWellsNagMet(dataWithMay,this.innerWellsButtonProstoi); 
            this.innerWells2 = this.innerWellsProdMet(dataWithMay,this.innerWellsButtonProstoi2);   


            var productionForChart = _(dataWithMay)
              .groupBy("__time")
              .map((__time, id) => ({
                time: id,
                productionFactForChart: _.round(_.sumBy(__time, productionFact), 0),
                productionPlanForChart: _.round(_.sumBy(__time, productionPlan), 0),
              }))
              .value();

            var dataWithMayLast = [];
            dataWithMayLast = _.last(dataWithMay);//.slice(-1);



            this.inj_wells_idle = dataWithMayLast['inj_wells_idle'];
            this.inj_wells_work = dataWithMayLast['inj_wells_work'];
            this.prod_wells_work = dataWithMayLast['prod_wells_work'];
            this.prod_wells_idle = dataWithMayLast['prod_wells_idle'];


            //console.log(productionForChart);
            if (this.company != "all") {
              this.$store.commit('globalloading/SET_LOADING', false);
              this.$emit("data", productionForChart); //k1q new
            }

            summForTables = _(dataWithMay)
              .groupBy("dzo")
              .map((dzo, id) => ({
                dzo: id,
                productionFactForMonth: _.round(_.sumBy(dzo, productionFact), 0),
                productionPlanForMonth: _.round(_.sumBy(dzo, productionPlan), 0),
              }))
              .value();

            if (this.buttonHover12 != '') {
              _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "ОМГ" }));
              _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "КГМ" }));
              _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "ММГ" }));
              _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "КТМ" }));
              _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "КБМ" }));
              _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "КОА" }));

              data = _.reject(data, _.iteratee({ dzo: "ОМГ" }));
              data = _.reject(data, _.iteratee({ dzo: "КГМ" }));
              data = _.reject(data, _.iteratee({ dzo: "ММГ" }));
              data = _.reject(data, _.iteratee({ dzo: "КТМ" }));
              data = _.reject(data, _.iteratee({ dzo: "КБМ" }));
              data = _.reject(data, _.iteratee({ dzo: "КОА" }));


              /*dzoMonth.push({ dzoMonth: NameDzoFull[5] }, { dzoMonth: NameDzoFull[11] }, { dzoMonth: NameDzoFull[12] });
              factMonth.push({ factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 });
              planMonth.push({ planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 });
              productionFactPercent.push({ productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 });*/
            }

            if (this.buttonHover13 != '') {
              /*  dzoMonth.push({ dzoMonth: NameDzoFull[5] }, { dzoMonth: NameDzoFull[11] }, { dzoMonth: NameDzoFull[12] }, { dzoMonth: NameDzoFull[2] }, { dzoMonth: NameDzoFull[9] }, { dzoMonth: NameDzoFull[10] });
                factMonth.push({ factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 });
                planMonth.push({ planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 });
                productionFactPercent.push({ productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 });
            */
            }


            this.tables = summForTables;
          }


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

          if (productionPlan == "liq_plan") {//inj_plan
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
          this.$store.commit('globalloading/SET_LOADING', false);
          var dataDay = [];
          var dataYear = [];
          var dzo = [];
          dataDay = data;
          //dataYear = data2;
          var factYear = [];
          var planYear = [];
          var dataMonth = [];
          var dzoYear = [];
          /*dataMonth = _.filter(
            data2,
            _.iteratee({ period: "2020 (с начала года)" })
          );*/

          /*  dataMonth = _.orderBy(dataMonth, ["dzo"], ["desc"]);
  
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
            });*/

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


          dataWithMay = _.orderBy(
            dataWithMay,
            ["__time"],
            ["asc"]
          );



          //Summ plan and fact from dzo k1q for month!!!
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
  

          this.innerWells = this.innerWellsNagMet(dataWithMay,this.innerWellsButtonProstoi);     
          this.innerWells2 = this.innerWellsProdMet(dataWithMay,this.innerWellsButtonProstoi2);      

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


          dataDay = _.filter(data, function (item) {
            return _.every([
              _.inRange(
                //item.dateSimple,
                item.__time,
                timestampEnd - 86400000,// * Number(period),
                timestampEnd// + 86400000
              ),
            ]);
          });


          //dataDay = _.filter(data, _.iteratee({ __time: timestampToday }));
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
          var dataDayLast = [];



          _.forEach(dataDay, function (item) {


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
          });
       

          if (inj_wells_idle) {
            inj_wells_idle = _.reduce(
              inj_wells_idle,
              function (memo, item) {
                return memo + item.inj_wells_idle;
              },
              0
            );
            this.inj_wells_idle = inj_wells_idle;
          }

          if (inj_wells_work) {
            inj_wells_work = _.reduce(
              inj_wells_work,
              function (memo, item) {
                return memo + item.inj_wells_work;
              },
              0
            );
            this.inj_wells_work = inj_wells_work;
          }

          if (prod_wells_work) {
            prod_wells_work = _.reduce(
              prod_wells_work,
              function (memo, item) {
                return memo + item.prod_wells_work;
              },
              0
            );
            this.prod_wells_work = prod_wells_work;
          }

          if (prod_wells_idle) {
            prod_wells_idle = _.reduce(
              prod_wells_idle,
              function (memo, item) {
                return memo + item.prod_wells_idle;
              },
              0
            );

            this.prod_wells_idle = prod_wells_idle;
          }

          var dzoMonth = [];
          var factMonth = [];
          var planMonth = [];

   //delete after paste data for dzo
          if (this.buttonHover12 != '') {
            productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "ОМГ" }));
            productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "КГМ" }));
            productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "ММГ" }));
            productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "КТМ" }));
            productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "КБМ" }));
            productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "КОА" }));
            productionPlanAndFactMonth = _.reject(productionPlanAndFactMonth, _.iteratee({ dzo: "ЭМГ" }));

            data = _.reject(data, _.iteratee({ dzo: "ОМГ" }));
            data = _.reject(data, _.iteratee({ dzo: "КГМ" }));
            data = _.reject(data, _.iteratee({ dzo: "ММГ" }));
            data = _.reject(data, _.iteratee({ dzo: "КТМ" }));
            data = _.reject(data, _.iteratee({ dzo: "КБМ" }));
            data = _.reject(data, _.iteratee({ dzo: "КОА" }));
            data = _.reject(data, _.iteratee({ dzo: "ЭМГ" }));


            dzoMonth.push({ dzoMonth: "ТШ" }, { dzoMonth: "НКО" }, { dzoMonth: "КПО" });
            factMonth.push({ factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 });
            planMonth.push({ planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 });
            productionFactPercent.push({ productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 });
          }

          if (this.buttonHover13 != '') {
           /* dzoMonth.push({ dzoMonth: "ТШ" }, { dzoMonth: "НКО" }, { dzoMonth: "КПО" }, { dzoMonth: "ПКИ" }, { dzoMonth: "АМГ" });
            factMonth.push({ factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 });
            planMonth.push({ planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 });
            productionFactPercent.push({ productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 });
         */
          }





          _.forEach(productionPlanAndFactMonth, function (item) { //k1q!!!
            factMonth.push({ factMonth: item.productionFactForChart });
            planMonth.push({ planMonth: item.productionPlanForChart });
            dzoMonth.push({ dzoMonth: item.dzo });
          });




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



          /*   var productionFactPercentSumm = _.reduce(
               productionFactPercent,
               function (memo, item) {
                 return memo + item.productionFactPercent;
               },
               0
             );
   
   
             this.productionFactPercentSumm = productionFactPercentSumm;*/

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

          // console.log(bigTable);
          this.bigTable = bigTable;


      

          this.$emit("data", productionForChart);

          productionForChart = { data: productionForChart };
          this.productionForChart = productionForChart;
        }
        this.getProductionOilandGas(data);
        this.getProductionOilandGasPercent(data);

      });
      this.showTable(localStorage.getItem("changeButton"));


    },


    getProductionPercentOneDzo(data) {
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
      this.productionFactPercentOneDzo = productionForChart[0]['productionFactPercent'];
      // console.log(productionForChart[0]['productionFactPercent']);
      // return productionForChart;
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
          this.displayHeadTables = "d-flex";
          this.displayTable = "display:none;";
        } else {
          this.displayTable = "d-flex;";
          this.displayHeadTables = "display: none";
        }
        this.showTableOn = ""; //colour button
      } else if (showTableItem == "No") {
        this.displayTable = "display:none;";
        this.displayHeadTables = "display: none";
        this.displayChart = "display:block;";
        this.ChartTable = "Таблица";


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
      this.getProduction(this.item, this.item2, this.item3, this.item4, this.nameChartLeft);
      this.getCurrencyNow(this.timeSelect);
      this.getOilNow(this.timeSelect, this.period);
    },




    buttonInnerWellsNag(){     
      if (this.innerWellsButtonProstoi==1)
      { this.buttonHoverNagInnerWells = this.buttonHover;  
        this.innerWellsButtonProstoi=0;} 
      else
      { this.buttonHoverNagInnerWells = "";
        this.innerWellsButtonProstoi=1;}      
    this.getProduction(this.item, this.item2, this.item3, this.item4, this.nameChartLeft);
  },    

    innerWellsNagMet(arr,i){
      var productionPlanAndFactMonthWells = _(arr)
      .groupBy("data")
      .map((__time, id) => ({
        __time: id,
        fond_nagnetat_ef: _.round(_.sumBy(__time, 'fond_nagnetat_ef'), 0),
        fond_nagnetat_df: _.round(_.sumBy(__time, 'fond_nagnetat_df'), 0),
        fond_nagnetat_bd: _.round(_.sumBy(__time, 'fond_nagnetat_bd'), 0),
        fond_nagnetat_ofls: _.round(_.sumBy(__time, 'fond_nagnetat_ofls'), 0),
        fond_nagnetat_prs: _.round(_.sumBy(__time, 'fond_nagnetat_prs'), 0),
        fond_nagnetat_oprs: _.round(_.sumBy(__time, 'fond_nagnetat_oprs'), 0),
        fond_nagnetat_krs: _.round(_.sumBy(__time, 'fond_nagnetat_krs'), 0),
        fond_nagnetat_okrs: _.round(_.sumBy(__time, 'fond_nagnetat_okrs'), 0),
        fond_nagnetat_osvoenie: _.round(_.sumBy(__time, 'fond_nagnetat_osvoenie'), 0),
        fond_nagnetat_konv: _.round(_.sumBy(__time, 'fond_nagnetat_konv'), 0),
        fond_nagnetat_well_survey: _.round(_.sumBy(__time, 'fond_nagnetat_well_survey'), 0),
        fond_nagnetat_others: _.round(_.sumBy(__time, 'fond_nagnetat_others'), 0),


   
      }))
      .value();
    //  console.log(productionPlanAndFactMonthWells);

      var productionPlanAndFactMonthWellsName = [];

      if (i!=1) {
      productionPlanAndFactMonthWellsName.push(
        { value: productionPlanAndFactMonthWells[0]['fond_nagnetat_ef'], name: 'Эксплуатационный фонд' },  
        { value: productionPlanAndFactMonthWells[0]['fond_nagnetat_df'], name: 'Действующий фонд' },
        { value: productionPlanAndFactMonthWells[0]['fond_nagnetat_bd'], name: 'Бездействующий фонд скважин' },
        { value: productionPlanAndFactMonthWells[0]['fond_nagnetat_osvoenie'], name: 'Освоение' },
        { value: productionPlanAndFactMonthWells[0]['fond_nagnetat_ofls'], name: 'Ожидание физической ликвидации скважин' },
        { value: productionPlanAndFactMonthWells[0]['fond_nagnetat_konv'], name: 'Консервация' },
        );
      };

      if (i==1) {
        productionPlanAndFactMonthWellsName.push(
        { value: productionPlanAndFactMonthWells[0]['fond_nagnetat_prs'], name: 'Подземный ремонт скважин' },
        { value: productionPlanAndFactMonthWells[0]['fond_nagnetat_oprs'], name: 'Ожидание подземного ремонта скважин' },
        { value: productionPlanAndFactMonthWells[0]['fond_nagnetat_krs'], name: 'Капитальный ремонт скважин' },
        { value: productionPlanAndFactMonthWells[0]['fond_nagnetat_okrs'], name: 'Ожидание капитального ремонта скважин' },
        { value: productionPlanAndFactMonthWells[0]['fond_nagnetat_well_survey'], name: 'Исследование скважин' },
        { value: productionPlanAndFactMonthWells[0]['fond_nagnetat_others'], name: 'Прочие' },
          );};

      return productionPlanAndFactMonthWellsName;

    },

    innerWellsNagMetOnChange($event){
      this.company = $event.target.value;
      this.getProduction(this.item, this.item2, this.item3, this.item4, this.nameChartLeft);
    },


    buttonInnerWellsProd(){     
      if (this.innerWellsButtonProstoi==1)
      { this.buttonHoverProdInnerWells = this.buttonHover;  
        this.innerWellsButtonProstoi2=0;} 
      else
      { this.buttonHoverProdInnerWells = "";
        this.innerWellsButtonProstoi2=1;}      
    this.getProduction(this.item, this.item2, this.item3, this.item4, this.nameChartLeft);
  },    

    innerWellsProdMet(arr,i){
      var productionPlanAndFactMonthWells = _(arr)
      .groupBy("data")
      .map((__time, id) => ({
        __time: id,
        fond_neftedob_ef: _.round(_.sumBy(__time, 'fond_neftedob_ef'), 0),
        fond_neftedob_df: _.round(_.sumBy(__time, 'fond_neftedob_df'), 0),
        fond_neftedob_bd: _.round(_.sumBy(__time, 'fond_neftedob_bd'), 0),
        fond_neftedob_osvoenie: _.round(_.sumBy(__time, 'fond_neftedob_osvoenie'), 0),
        fond_neftedob_ofls: _.round(_.sumBy(__time, 'fond_neftedob_ofls'), 0),
        fond_neftedob_prs: _.round(_.sumBy(__time, 'fond_neftedob_prs'), 0),
        fond_neftedob_oprs: _.round(_.sumBy(__time, 'fond_neftedob_oprs'), 0),
        fond_neftedob_krs: _.round(_.sumBy(__time, 'fond_neftedob_krs'), 0),
        fond_neftedob_okrs: _.round(_.sumBy(__time, 'fond_neftedob_okrs'), 0),
        fond_neftedob_well_survey: _.round(_.sumBy(__time, 'fond_neftedob_well_survey'), 0),
        fond_neftedob_nrs: _.round(_.sumBy(__time, 'fond_neftedob_nrs'), 0),       
        fond_neftedob_others: _.round(_.sumBy(__time, 'fond_neftedob_others'), 0),   
      }))
      .value();
      console.log(productionPlanAndFactMonthWells);

      var productionPlanAndFactMonthWellsName = [];

      if (i!=1) {
      productionPlanAndFactMonthWellsName.push(
        { value: productionPlanAndFactMonthWells[0]['fond_neftedob_ef'], name: 'Эксплуатационный фонд' },  
        { value: productionPlanAndFactMonthWells[0]['fond_neftedob_df'], name: 'Действующий фонд' },
        { value: productionPlanAndFactMonthWells[0]['fond_neftedob_bd'], name: 'Бездействующий фонд скважин' },
        { value: productionPlanAndFactMonthWells[0]['fond_neftedob_osvoenie'], name: 'Освоение' },
        { value: productionPlanAndFactMonthWells[0]['fond_neftedob_ofls'], name: 'Ожидание физической ликвидации скважин' },
       // { value: productionPlanAndFactMonthWells[0]['fond_nagnetat_konv'], name: 'Консервация' },
        );
      };

      if (i==1) {
        productionPlanAndFactMonthWellsName.push(
        { value: productionPlanAndFactMonthWells[0]['fond_neftedob_prs'], name: 'Подземный ремонт скважин' },
        { value: productionPlanAndFactMonthWells[0]['fond_neftedob_oprs'], name: 'Ожидание подземного ремонта скважин' },
        { value: productionPlanAndFactMonthWells[0]['fond_neftedob_krs'], name: 'Капитальный ремонт скважин' },
        { value: productionPlanAndFactMonthWells[0]['fond_neftedob_okrs'], name: 'Ожидание капитального ремонта скважин' },
        { value: productionPlanAndFactMonthWells[0]['fond_neftedob_well_survey'], name: 'Исследование скважин' },
        { value: productionPlanAndFactMonthWells[0]['fond_neftedob_nrs'], name: 'Нерентабельные скважины' },
        { value: productionPlanAndFactMonthWells[0]['fond_neftedob_others'], name: 'Прочие' },
          );};

      return productionPlanAndFactMonthWellsName;

    },

    innerWellsProdMetOnChange($event){
      this.company = $event.target.value;
      this.getProduction(this.item, this.item2, this.item3, this.item4, this.nameChartLeft);
    },






    getNameDzoFull: function (dzo) {
      var NameDzoFull = this.NameDzoFull;
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
      else if (String(dzo) === "ЭМГ") {
        name = NameDzoFull[2];
      }

      else if (String(dzo) === "ТП") {
        name = NameDzoFull[15];
      }
      else if (String(dzo) === "ПКИ") {
        name = NameDzoFull[9];
      } else if (String(dzo) === "АМГ") {
        name = NameDzoFull[10];
      }
      else if (String(dzo) === "ТШ") {
        name = NameDzoFull[5];
      }
      else if (String(dzo) === "НКО") {
        name = NameDzoFull[12];
      }
      else if (String(dzo) === "КПО") {
        name = NameDzoFull[11];
      }
      else { name = dzo }
      return name;
    },

  },
  created() {

    if (window.location.host === 'dashboard') {
  
   // this.Table5 = "display:block";
   // this.Table1 = "display:none";
    }

  },

  async mounted() {

    this.item3 = this.oilChartHeadName;

    if (window.location.host === 'dashboard') {


      this.range = {     
        start: "2020-06-01T06:00:00+06:00",
        end: "2020-06-01T09:00:00+06:00",
        formatInput: true,
      };
    } else {
      this.range = {
        start: new Date(this.year + '-' + this.month + '-' + this.pad(this.date.getDate() - 1) + 'T06:00:00+06:00'),
        end: new Date().toISOString(),
        formatInput: true,
      };
    }
    localStorage.setItem("changeButton", "Yes");
    var nowDate = new Date().toLocaleDateString();
    this.timeSelect = nowDate;
    this.timestampToday = new Date(this.range.start).getTime();
    this.timestampEnd = new Date(this.range.end).getTime();
    if (this.company == "all") {
    }
    this.selectedYear = this.year;
    //var productionPlan = localStorage.getItem("production-plan");
    //var productionFact = localStorage.getItem("production-fact");

    localStorage.setItem("selectedDMY", "undefined");
    this.getCurrencyNow(this.timeSelect);
    this.getOilNow(this.timeSelect, this.period);
    this.getCurrencyPeriod(this.timeSelect, this.periodUSD);
    this.changeAssets('b13');
    // this.getProductionOilandGasPercent();

  },
  computed: {
  },


};
