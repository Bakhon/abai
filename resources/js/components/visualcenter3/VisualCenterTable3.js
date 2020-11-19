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
      /*calendar*/
      range: {
        start: "2020-01-01T06:00:00+06:00",
        end: "2020-01-05T06:00:00+06:00",
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
      oil_factDay: "",
      oil_planDay: "",
      oil_dlv_factDay: "",
      oil_dlv_planDay: "",
      gas_factDay: "",
      gas_planDay: "",
      oil_dlv_factDayProgressBar:"",
      oil_factDayProgressBar:"",
      gas_factDayProgressBar:"",      
      selectedDate: "",
      tableHover1: "",
      tableHover2: "",
      tableHover3: "",
      tableHover4: "",
      tableHover5: "",
      tableHover6: "",
      tableHover7: "",
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
      item: "",
      item2: "",
      item3: "",
      item4: "",
      productionForChart: "",
      tables: "",
      showTable2: "Yes",
      displayTable: "display: none;",
      displayChart: "display: none;",
      showTableOn: "",
      buttonHover:"border: none;" + " background: #2E50E9;color:white",
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

      tableHover7: "",
      tableHover8: "",
      tableHover9: "",
      tableHover10: "",
      tableHover11: "",
      tableHover12: "",

      circleMenu: "",
      month: new Date().getMonth(),
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
      localStorage.setItem("company", com);
      var company = localStorage.getItem("company");
      this.company = company;

      var buttonMenuHover =
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
      }

      this.company = company;
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
      var buttonHover=this.buttonHover;
      var changeMenuButton = "color: #fff;";
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

      
      if (change == "day") {
        this.buttonHover7 = buttonHover;
        this.range.start = new Date();
        this.range.end = new Date();
        this.getProduction(this.item, this.item2, this.item3, this.item4);  
      } else {
        this.buttonHover7 = "";
      }

      if (change == "month") {
        this.buttonHover8 = buttonHover;
        this.getProduction(this.item, this.item2, this.item3, this.item4);  
        this.range.start = new Date(new Date().setDate(1));
        this.range.end = new Date();
      } else {
        this.buttonHover8 = "";
      }
      
      if (change == "year") {
        this.buttonHover9 = buttonHover;
        this.range.start =  new Date(this.year,'00','01');
        this.range.end = new Date();
        this.getProduction(this.item, this.item2, this.item3, this.item4);  
      } else {
        this.buttonHover9 = "";
      }

      if (change == "calendar") {
        this.buttonHover10 = buttonHover;
         } else {
        this.buttonHover10 = "";
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

      if (this.selectedDMY != undefined) {
      }

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
            this.oilNow =Number(oil2[0].value).toFixed(1);
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
      // console.log(event);
      return this.getProduction(this.item, this.item2, this.item3, this.item4);
    },

    getColor(status) {
      if (status < "0") return "    margin-top: 28px;border-top: 10px solid #b40300";
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

          var dataDay = [];
          var timestampToday = this.timestampToday;
          var factDay = [];
          var planDay = [];

          var oil_dlv_fact = [];
          var oil_dlv_plan = [];
          var gas_plan = [];
          var gas_fact = [];


          dataDay = _.filter(data, _.iteratee({ __time: timestampToday }));
          dataDay = _.orderBy(dataDay, ["dzo"], ["desc"]);

          _.forEach(dataDay, function (item) {
            var f = { factDay: Math.ceil(item['oil_fact']) };
            var p = { planDay: Math.ceil(item['oil_plan']) };
            factDay.push(f);
            planDay.push(p);

            var o = { oil_dlv_fact: Math.ceil(item['oil_dlv_fact']) };
            var oi = { oil_dlv_plan: Math.ceil(item['oil_dlv_plan']) };
            oil_dlv_fact.push(o);
            oil_dlv_plan.push(oi);

            var g = { gas_plan: Math.ceil(item['gas_plan']) };
            var ga = { gas_fact: Math.ceil(item['gas_fact']) };
            gas_plan.push(g);
            gas_fact.push(ga);

          });

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

          this.oil_factDay = factDaySumm;
          this.oil_planDay = planDaySumm;
          this.oil_factDayProgressBar=(factDaySumm/planDaySumm)*100;

          var oil_dlv_factDay = _.reduce(
            oil_dlv_fact,
            function (memo, item) {
              return memo + item.oil_dlv_fact;
            },
            0
          );

          var oil_dlv_planDay = _.reduce(
            oil_dlv_plan,
            function (memo, item) {
              return memo + item.oil_dlv_plan;
            },
            0
          );

          this.oil_dlv_factDay = oil_dlv_factDay;
          this.oil_dlv_planDay = oil_dlv_planDay;
          this.oil_dlv_factDayProgressBar=(oil_dlv_factDay/oil_dlv_planDay)*100;

          var gas_factDay = _.reduce(
            gas_fact,
            function (memo, item) {
              return memo + item.gas_fact;
            },
            0
          );

          var gas_planDay = _.reduce(
            gas_plan,
            function (memo, item) {
              return memo + item.gas_plan;
            },
            0
          );

          this.gas_factDay = gas_factDay;
          this.gas_planDay = gas_planDay;
          this.gas_factDayProgressBar=(gas_factDay/gas_planDay)*100;
        }
      });
    },



    getProduction(item, item2, item3, item4) {
      var timestampToday = this.timestampToday;
      var timestampEnd = this.timestampEnd
      var timestampMonthStart = this.timestampToday;
      this.item = item;
      this.item2 = item2;
      this.item3 = item3;
      this.item4 = item4;

      // this.unit = item4;

     /* if (this.selectedDay == undefined) {
        var timeSelect =
          this.pad(new Date().getDate()) +
          "." +
          this.pad(this.month + 1) +
          "." +
          this.year;
      } else {
        var timeSelect =
          this.pad(this.selectedDay) +
          "." +
          this.pad(this.month + 1) +
          "." +
          this.year;
      }
 */

      localStorage.setItem("production-plan", item);
      localStorage.setItem("production-fact", item2);

      var productionPlan = localStorage.getItem("production-plan");
      var productionFact = localStorage.getItem("production-fact");

      var selectedDMY = localStorage.getItem("selectedDMY");

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
          var arrdata = new Array();
          //select date filter k1q
          var timestamp = new Date(
            this.monthes2[this.month] +
            this.selectedDay +
            " " +
            this.year +
            " 06:00:00 GMT+0600"
          ).getTime();

          arrdata = _.filter(data, _.iteratee({ dzo: company }));
          //get data by Month
          var SelectYearInMonth; //value
          if (this.selectedYear == undefined) {
            SelectYearInMonth = this.year;
          } else {
            SelectYearInMonth = this.selectedYear;
          }

          if (this.selectedDMY == 0) {
            //selectedDay by chart
           /* var timestampMonthStart = new Date(
              this.monthes2[this.month] +
              //this.selectedDay +
              "1" +
              " " +
              SelectYearInMonth +
              " 06:00:00 GMT+0600"
            ).getTime();*/

            var dayInMonth = this.getDays().length;

            var dataWithMay = new Array();
            dataWithMay = _.filter(arrdata, function (item) {
              return _.every([
                _.inRange(
                  item.__time,
                  // 1588291200000, // May 2020
                  timestampMonthStart,
                  timestampMonthStart + 86400000 * dayInMonth
                ),
              ]);
            });

            //for chart
            var productionPlanForChart = new Array();
            _.forEach(dataWithMay, function (item) {
              productionPlanForChart.push({
                productionPlanForChart: item[productionPlan],
              });
            });

            var productionFactForChart = new Array();
            _.forEach(dataWithMay, function (item) {
              productionFactForChart.push({
                productionFactForChart: item[productionFact],
              });
            });
          }

          if (this.selectedDMY == 1) {
            //selectedMonth by chart
            var getDaysInYear = [];
            for (let i = 1; i <= 12; i++) {
              var allDays = _.filter(
                this.getDaysInYear(),
                _.iteratee({ month: i })
              );
              getDaysInYear[i] = allDays.length;
            }
            var months = [];
            var getMonthsTime = [];

            var timestampMonthStart = [];
            for (let i = 0; i <= 11; i++) {
              timestampMonthStart[i] = new Date(
                this.monthes2[i] + "01 " + this.year + ""
              ).getTime();
            }

            for (let i = 0; i <= 11; i++) {
              months[i] = _.filter(arrdata, function (item) {
                return _.every([
                  _.inRange(
                    item.__time,
                    timestampMonthStart[i],
                    timestampMonthStart[i] + 86400000 * getDaysInYear[i + 1]
                  ),
                ]);
              });
              getMonthsTime = months;
            }

            var productionFactForChart = _.reduce(
              getMonthsTime[0],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            //  productionFactForChart = productionFactForChart / getDaysInYear[1];

            var productionPlanForChart = _.reduce(
              getMonthsTime[0],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            //  productionPlanForChart = productionPlanForChart / getDaysInYear[1];

            //2
            var productionFactForChart2 = _.reduce(
              getMonthsTime[1],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            //  productionFactForChart2 =              productionFactForChart2 / getDaysInYear[2];

            var productionPlanForChart2 = _.reduce(
              getMonthsTime[1],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            //  productionPlanForChart2 =              productionPlanForChart2 / getDaysInYear[2];

            //3
            var productionFactForChart3 = _.reduce(
              getMonthsTime[2],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            //  productionFactForChart3 =              productionFactForChart3 / getDaysInYear[3];

            var productionPlanForChart3 = _.reduce(
              getMonthsTime[2],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            //  productionPlanForChart3 =              productionPlanForChart3 / getDaysInYear[3];

            //4
            var productionFactForChart4 = _.reduce(
              getMonthsTime[3],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            // productionFactForChart4 =              productionFactForChart4 / getDaysInYear[4];

            var productionPlanForChart4 = _.reduce(
              getMonthsTime[3],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            //  productionPlanForChart4 =              productionPlanForChart4 / getDaysInYear[4];

            //5
            var productionFactForChart5 = _.reduce(
              getMonthsTime[4],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            // productionFactForChart5 =              productionFactForChart5 / getDaysInYear[5];

            var productionPlanForChart5 = _.reduce(
              getMonthsTime[4],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            // productionPlanForChart5 =              productionPlanForChart5 / getDaysInYear[5];

            //6
            var productionFactForChart6 = _.reduce(
              getMonthsTime[5],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            //productionFactForChart6 =              productionFactForChart6 / getDaysInYear[6];

            var productionPlanForChart6 = _.reduce(
              getMonthsTime[5],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            // productionPlanForChart6 =              productionPlanForChart6 / getDaysInYear[6];

            //7
            var productionFactForChart7 = _.reduce(
              getMonthsTime[6],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            //productionFactForChart7 =              productionFactForChart7 / getDaysInYear[7];

            var productionPlanForChart7 = _.reduce(
              getMonthsTime[6],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            //  productionPlanForChart7 =              productionPlanForChart7 / getDaysInYear[7];

            //8
            var productionFactForChart8 = _.reduce(
              getMonthsTime[7],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            //   productionFactForChart8 =              productionFactForChart8 / getDaysInYear[8];

            var productionPlanForChart8 = _.reduce(
              getMonthsTime[7],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            // productionPlanForChart8 =              productionPlanForChart8 / getDaysInYear[8];

            //9
            var productionFactForChart9 = _.reduce(
              getMonthsTime[8],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            // productionFactForChart9 =              productionFactForChart9 / getDaysInYear[9];

            var productionPlanForChart9 = _.reduce(
              getMonthsTime[8],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            //   productionPlanForChart9 =              productionPlanForChart9 / getDaysInYear[9];

            //10
            var productionFactForChart10 = _.reduce(
              getMonthsTime[9],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            //   productionFactForChart10 =              productionFactForChart10 / getDaysInYear[10];

            var productionPlanForChart10 = _.reduce(
              getMonthsTime[9],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            // productionPlanForChart10 =              productionPlanForChart10 / getDaysInYear[10];

            //11
            var productionFactForChart11 = _.reduce(
              getMonthsTime[10],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            //  productionFactForChart11 =              productionFactForChart11 / getDaysInYear[11];

            var productionPlanForChart11 = _.reduce(
              getMonthsTime[10],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            //productionPlanForChart11 =              productionPlanForChart11 / getDaysInYear[11];

            //12
            var productionFactForChart12 = _.reduce(
              getMonthsTime[11],
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );

            //productionFactForChart12 =              productionFactForChart12 / getDaysInYear[12];

            var productionPlanForChart12 = _.reduce(
              getMonthsTime[11],
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );
            // productionPlanForChart12 =              productionPlanForChart12 / getDaysInYear[12];

            var productionFactForChartMonth = [];

            productionFactForChartMonth = [
              { productionFactForChart: Math.ceil(productionFactForChart) },
              { productionFactForChart: Math.ceil(productionFactForChart2) },
              { productionFactForChart: Math.ceil(productionFactForChart3) },
              { productionFactForChart: Math.ceil(productionFactForChart4) },
              { productionFactForChart: Math.ceil(productionFactForChart5) },
              { productionFactForChart: Math.ceil(productionFactForChart6) },
              { productionFactForChart: Math.ceil(productionFactForChart7) },
              { productionFactForChart: Math.ceil(productionFactForChart8) },
              { productionFactForChart: Math.ceil(productionFactForChart9) },
              { productionFactForChart: Math.ceil(productionFactForChart10) },
              { productionFactForChart: Math.ceil(productionFactForChart11) },
              { productionFactForChart: Math.ceil(productionFactForChart12) },
            ];

            var productionPlanForChartMonth = [];
            productionPlanForChartMonth = [
              { productionPlanForChart: Math.ceil(productionPlanForChart) },
              { productionPlanForChart: Math.ceil(productionPlanForChart2) },
              { productionPlanForChart: Math.ceil(productionPlanForChart3) },
              { productionPlanForChart: Math.ceil(productionPlanForChart4) },
              { productionPlanForChart: Math.ceil(productionPlanForChart5) },
              { productionPlanForChart: Math.ceil(productionPlanForChart6) },
              { productionPlanForChart: Math.ceil(productionPlanForChart7) },
              { productionPlanForChart: Math.ceil(productionPlanForChart8) },
              { productionPlanForChart: Math.ceil(productionPlanForChart9) },
              { productionPlanForChart: Math.ceil(productionPlanForChart10) },
              { productionPlanForChart: Math.ceil(productionPlanForChart11) },
              { productionPlanForChart: Math.ceil(productionPlanForChart12) },
            ];
          }

          //select data by
          if (this.selectedDMY == 1) {
            //select only for month
           /* var timestampMonthStart = new Date(
              this.monthes2[this.selectedMonth - 1] +
              //this.selectedDay +
              "1" +
              " " +
              SelectYearInMonth +
              " 06:00:00 GMT+0600"
            ).getTime();*/

            var dayInMonth2 = this.getDaysMonth().length;

            var dataWithMay = new Array();
            dataWithMay = _.filter(arrdata, function (item) {
              return _.every([
                _.inRange(
                  item.__time,
                  timestampMonthStart,
                  timestampMonthStart + 86400000 * dayInMonth2
                ),
              ]);
            });

            var dzo = [];
            var productionPlanForMonth = [];
            var productionFactForMonth = [];
            var __time2 = [];
            _.forEach(dataWithMay, function (item) {
              dzo.push(item.dzo);
              productionPlanForMonth.push({
                productionPlanForMonth: Math.ceil(item[productionPlan]),
              });
              productionFactForMonth.push({
                productionFactForMonth: Math.ceil(item[productionFact]),
              });
              __time2.push({
                timeMonth: new Date(item.__time).toLocaleString("ru", {
                  year: "numeric",
                  month: "numeric",
                  day: "numeric",
                  /*	weekday: 'long',
  timezone: 'UTC',
        hour: "numeric",
        minute: "numeric",*/
                  //second: 'numeric'
                }),
              });
            });

            var prod_wells_work = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item.prod_wells_work;
              },
              0
            );

            //   prod_wells_work = Math.ceil(prod_wells_work / dayInMonth);

            var prod_wells_idle = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item.prod_wells_idle;
              },
              0
            );
            // prod_wells_idle = Math.ceil(prod_wells_idle / dayInMonth);

            var starts_krs = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item.starts_krs;
              },
              0
            );
            // starts_krs = Math.ceil(starts_krs / dayInMonth);

            var starts_prs = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item.starts_prs;
              },
              0
            );
            //starts_prs = Math.ceil(starts_prs / dayInMonth);

            var starts_drl = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item.starts_drl;
              },
              0
            );
            //starts_drl = Math.ceil(starts_drl / dayInMonth);

            var inj_wells_idle = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item.inj_wells_idle;
              },
              0
            );
            //   inj_wells_idle = Math.ceil(inj_wells_idle / dayInMonth);

            var inj_wells_work = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item.inj_wells_work;
              },
              0
            );

            var prod_wells_work2 = [{ prod_wells_work: prod_wells_work }];

            var prod_wells_idle2 = [{ prod_wells_idle: prod_wells_idle }];
            var starts_krs2 = [{ starts_krs: starts_krs }];
            var starts_prs2 = [{ starts_prs: starts_prs }];
            var starts_drl2 = [{ starts_drl: starts_drl }];
            var inj_wells_idle2 = [{ inj_wells_idle: inj_wells_idle }];
            var inj_wells_work2 = [{ inj_wells_work: inj_wells_work }];
          }

          if (this.selectedDMY == 0) {
            arrdata = _.filter(arrdata, _.iteratee({ __time: timestampToday }));
            /*if (arrdata.length == 0) {
            alert(
              "К сожалению на текущую дату нет данных, выберите другую дату"
            );
            } else {*/
            // }
            //select dzo filter

            var dzo = new Array();
            var liq_fact = new Array();
            var liq_plan = new Array();
            var time = new Array();
            var prod_wells_work = new Array();
            var prod_wells_idle = new Array();
            var starts_krs = new Array();
            var starts_prs = new Array();
            var starts_drl = new Array();
            var inj_wells_active = new Array();
            var inj_wells_idle = new Array();
            var inj_wells_work = new Array();
            var prod_wells_active = new Array();

            _.forEach(arrdata, function (item) {
              dzo.push(item.dzo);
              liq_fact.push(item[productionFact]);
              liq_plan.push(item[productionPlan]);
              time.push(item.__time);
              prod_wells_work.push(item.prod_wells_work);
              prod_wells_idle.push(item.prod_wells_idle);
              starts_krs.push(item.starts_krs);
              starts_prs.push(item.starts_prs);
              starts_drl.push(item.starts_drl);
              inj_wells_work.push(item.inj_wells_work);
              inj_wells_idle.push(item.inj_wells_idle);
            });

            //select only for day
            //Create massive with a part

            var liq_fact2 = new Array();
            _.each(liq_fact, function (fact) {
              fact = Math.ceil(fact);
              liq_fact2.push({ fact });
            });

            var liq_plan2 = new Array();
            _.each(liq_plan, function (plan) {
              plan = Math.ceil(plan); //okrugl vverh
              liq_plan2.push({ plan });
            });

            var __time2 = new Array();
            _.each(time, function (time) {
              //time = new Date(time).toLocaleDateString();
              //   time = new Date(time);
              __time2.push({ time });
            });

            var prod_wells_work2 = new Array();
            _.each(prod_wells_work, function (prod_wells_work) {
              prod_wells_work2.push({ prod_wells_work });
            });

            var prod_wells_idle2 = new Array();
            _.each(prod_wells_idle, function (prod_wells_idle) {
              prod_wells_idle2.push({ prod_wells_idle });
            });

            var starts_krs2 = new Array();
            _.each(starts_krs, function (starts_krs) {
              starts_krs2.push({ starts_krs });
            });

            var starts_prs2 = new Array();
            _.each(starts_prs, function (starts_prs) {
              starts_prs2.push({ starts_prs });
            });

            var starts_drl2 = new Array();
            _.each(starts_drl, function (starts_drl) {
              starts_drl2.push({ starts_drl });
            });

            var inj_wells_idle2 = new Array();
            _.each(inj_wells_idle, function (inj_wells_idle) {
              inj_wells_idle2.push({ inj_wells_idle });
            });

            var inj_wells_work2 = new Array();
            _.each(inj_wells_work, function (inj_wells_work) {
              inj_wells_work2.push({ inj_wells_work });
            });
          }

          //for year
          if (this.selectedDMY == 2) {
            var selectedYear = this.selectedYear;
            if (selectedYear === 2020) {
              selectedYear = "2020 (с начала года)";
            }
            var arrdataYear = new Array();
            arrdataYear = _.filter(
              data2,
              _.iteratee({ period: String(selectedYear) })
            );
            arrdataYear = _.filter(arrdataYear, _.iteratee({ dzo: company }));

            var dzo = new Array();
            var factYear = new Array();
            var planYear = new Array();

            var prod_wells_work_year = new Array();
            var prod_wells_idle_year = new Array();

            var inj_wells_idle_year = new Array();
            var inj_wells_work_year = new Array();

            var starts_krs_year = new Array();
            var starts_prs_year = new Array();
            var starts_drl_year = new Array();

            _.forEach(arrdataYear, function (item) {
              dzo.push(item.dzo);
              factYear.push(item[productionFact]);
              planYear.push(item[productionPlan]);
              prod_wells_work_year.push(item.prod_wells_work);
              prod_wells_idle_year.push(item.prod_wells_idle);
              inj_wells_idle_year.push(item.inj_wells_idle);
              inj_wells_work_year.push(item.inj_wells_work);
              starts_krs_year.push(item.starts_krs);
              starts_prs_year.push(item.starts_prs);
              starts_drl_year.push(item.starts_drl);
            });

            var arrdataYearChart = new Array();
            var arrdataYearChart = [];
            arrdataYearChart = _.filter(data2, _.iteratee({ dzo: company }));
            arrdataYearChart = _.orderBy(
              arrdataYearChart,
              ["period"],
              ["desk"]
            );

            var productionPlanForChartYear = new Array();
            _.forEach(arrdataYearChart, function (item) {
              productionPlanForChartYear.push({
                productionPlanForChartYear: Math.ceil(item[productionPlan]),
              });
            });

            var productionFactForChartYear = new Array();
            _.forEach(arrdataYearChart, function (item) {
              productionFactForChartYear.push({
                productionFactForChartYear: Math.ceil(item[productionFact]),
              });
            });

            //select only for year
            var factYear2 = new Array();
            _.each(factYear, function (factYear) {
              factYear = Math.ceil(factYear);
              factYear2.push({ factYear });
            });

            var planYear2 = new Array();
            _.each(planYear, function (planYear) {
              planYear = Math.ceil(planYear);
              planYear2.push({ planYear });
            });

            var prod_wells_work_year2 = new Array();
            _.each(prod_wells_work_year, function (prod_wells_work_year) {
              prod_wells_work_year2.push({ prod_wells_work_year });
            });

            var prod_wells_idle_year2 = new Array();
            _.each(prod_wells_idle_year, function (prod_wells_idle_year) {
              prod_wells_idle_year2.push({ prod_wells_idle_year });
            });

            var inj_wells_idle_year2 = new Array();
            _.each(inj_wells_idle_year, function (inj_wells_idle_year) {
              inj_wells_idle_year = Math.ceil(inj_wells_idle_year);
              inj_wells_idle_year2.push({ inj_wells_idle_year });
            });

            var inj_wells_work_year2 = new Array();
            _.each(inj_wells_work_year, function (inj_wells_work_year) {
              inj_wells_work_year = Math.ceil(inj_wells_work_year);
              inj_wells_work_year2.push({ inj_wells_work_year });
            });

            /* var dzoYear2 = new Array();
            _.each(dzoYear, function (dzoYear) {
              dzoYear2.push({ dzoYear });
            });*/

            var starts_krs_year2 = new Array();
            _.each(starts_krs_year, function (starts_krs_year) {
              starts_krs_year2.push({ starts_krs_year });
            });

            var starts_prs_year2 = new Array();
            _.each(starts_prs_year, function (starts_prs_year) {
              starts_prs_year2.push({ starts_prs_year });
            });

            var starts_drl_year2 = new Array();
            _.each(starts_drl_year, function (starts_drl_year) {
              starts_drl_year2.push({ starts_drl_year });
            });
          }

          //all variables
          var NameDzoFull = this.NameDzoFull;

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
          });

          var productionForChart = [{}];
          productionForChart = _.zipWith(
            _.sortBy(
              productionPlanForChart,
              (productionPlanForChart) =>
                productionPlanForChart.productionPlanForChart
            ),
            _.sortBy(
              productionFactForChart,
              (productionFactForChart) =>
                productionFactForChart.productionFactForChart
            ),

            _.sortBy(
              productionPlanForChartMonth,
              (productionPlanForChartMonth) =>
                productionPlanForChartMonth.productionPlanForChartMonth
            ),

            _.sortBy(
              productionFactForChartMonth,
              (productionFactForChartMonth) =>
                productionFactForChartMonth.productionFactForChartMonth
            ),

            _.sortBy(
              productionPlanForChartYear,
              (productionPlanForChartYear) =>
                productionPlanForChartYear.productionPlanForChartYear
            ),

            _.sortBy(
              productionFactForChartYear,
              (productionFactForChartYear) =>
                productionFactForChartYear.productionFactForChartYear
            ),

            (
              productionPlanForChart2,
              productionFactForChart2,
              productionPlanForChartMonth,
              productionFactForChartMonth,
              productionPlanForChartYear,
              productionFactForChartYear
            ) =>
              _.defaults(
                productionPlanForChart2,
                productionFactForChart2,
                productionPlanForChartMonth,
                productionFactForChartMonth,
                productionPlanForChartYear,
                productionFactForChartYear
              )
          );

          productionForChart = { data: productionForChart };
          this.productionForChart = productionForChart;

          var tables = _.zipWith(
            _.sortBy(dzoBriefly2, (dzoBriefly) => dzoBriefly.dzoBriefly),
            _.sortBy(dzo2, (dzo) => dzo.dzo),
            _.sortBy(liq_fact2, (liq_fact) => liq_fact.liq_fact),
            _.sortBy(liq_plan2, (liq_plan) => liq_plan.liq_plan),
            _.sortBy(__time2, (time) => time.time),
            _.sortBy(factYear2, (factYear) => factYear),
            _.sortBy(planYear2, (planYear) => planYear),
            _.sortBy(
              productionFactForMonth,
              (productionFactForMonth) => productionFactForMonth
            ),
            _.sortBy(
              productionPlanForMonth,
              (productionPlanForMonth) => productionPlanForMonth
            ),
            // _.sortBy(dzoYear2, (dzoYear) => dzoYear),
            (
              dzo,
              liq_fact,
              liq_plan,
              time,
              factYear,
              planYear, //, dzoYear
              productionFactForMonth,
              productionPlanForMonth
            ) =>
              _.defaults(
                dzo,
                liq_fact,
                liq_plan,
                time,
                factYear,
                planYear,
                //dzoYear,
                productionFactForMonth,
                productionPlanForMonth
              )
          );

          this.tables = tables;

          //VisualCenterChartDonutRight1.vue
          var wells2 = _.zipWith(
            _.sortBy(
              prod_wells_work2,
              (prod_wells_work) => prod_wells_work.prod_wells_work
            ),
            _.sortBy(
              prod_wells_idle2,
              (prod_wells_idle) => prod_wells_idle.prod_wells_idle
            ),
            _.sortBy(
              prod_wells_work_year2,
              (prod_wells_work_year) =>
                prod_wells_work_year.prod_wells_work_year
            ),
            _.sortBy(
              prod_wells_idle_year2,
              (prod_wells_idle_year) =>
                prod_wells_idle_year.prod_wells_idle_year
            ),
            (
              prod_wells_work,
              prod_wells_idle,
              prod_wells_work_year,
              prod_wells_idle_year
            ) =>
              _.defaults(
                prod_wells_work,
                prod_wells_idle,
                prod_wells_work_year,
                prod_wells_idle_year
              )
          );

          this.wells2 = wells2;

          var starts = _.zipWith(
            _.sortBy(starts_krs2, (starts_krs) => starts_krs.starts_krs),
            _.sortBy(starts_prs2, (starts_prs) => starts_prs.starts_prs),
            _.sortBy(starts_drl2, (starts_drl) => starts_drl.starts_drl),

            _.sortBy(
              starts_krs_year2,
              (starts_krs_year) => starts_krs_year.starts_krs_year
            ),
            _.sortBy(
              starts_prs_year2,
              (starts_prs_year) => starts_prs_year.starts_prs_year
            ),
            _.sortBy(
              starts_drl_year2,
              (starts_drl_year) => starts_drl_year.starts_drl_year
            ),

            (
              starts_krs,
              starts_prs,
              starts_drl,
              starts_krs_year,
              starts_prs_year,
              starts_drl_year
            ) =>
              _.defaults(
                starts_krs,
                starts_prs,
                starts_drl,
                starts_krs_year,
                starts_prs_year,
                starts_drl_year
              )
          );

          this.starts = starts;

          //VisualCenterChartDonutRight2.vue
          var wells = _.zipWith(
            _.sortBy(
              inj_wells_idle2,
              (inj_wells_idle) => inj_wells_idle.inj_wells_idle
            ),
            _.sortBy(
              inj_wells_work2,
              (inj_wells_work) => inj_wells_work.inj_wells_work
            ),

            _.sortBy(
              inj_wells_idle_year2,
              (inj_wells_idle_year) => inj_wells_idle_year.inj_wells_idle_year
            ),

            _.sortBy(
              inj_wells_work_year2,
              (inj_wells_work_year) => inj_wells_work_year.inj_wells_work_year
            ),

            (
              inj_wells_idle,
              inj_wells_work,
              inj_wells_idle_year,
              inj_wells_work_year
            ) =>
              _.defaults(
                inj_wells_idle,
                inj_wells_work,
                inj_wells_idle_year,
                inj_wells_work_year
              )
          );

          this.wells = wells;

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



        var selectedDay = this.selectedDay;

        //if (selectedDay == undefined) {     
       /* var timestampToday = this.timestampToday;
        var timestampEnd = this.timestampEnd;*/
        //}




        var dayInMonth = this.getDays().length;
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

        //console.log(timestampMonthStart);

        //Summ plan and fact from dzo
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
console.log(dataWithMay);

        _.forEach(dataWithMay, function (item) {
          e = { dzo2: item.dzo };
          f = { factMonth: Math.ceil(item[productionFact]) };
          p = { planMonth: Math.ceil(item[productionPlan]) };
          oil_fact = { oil_fact: item.oil_fact };
          oil_plan = { oil_plan: item.oil_plan };
          getMonthBigTable.push([e, f, p, oil_fact, oil_plan]);
        });

        var factMonth2 = _.reduce(
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
        _.forEach(dataDay, function (item) {
          if (String(item.dzo) === "ОМГ") {
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
          }

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

        _.forEach(productionPlanAndFactMonth, function (item) {
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

        if (this.company == "all") {
          var bigTable = _.zipWith(
            dzoBriefly,
            dzoYear,
            dzoMonth,
            factYear,
            dzo,
            dzo2,
            planYear,
            planMonth,
            factMonth,
            dzoDay,
            factDay,
            planDay,
            (
              dzoBriefly,
              dzoYear,
              dzoMonth,
              factYear,
              dzo,
              dzo2,
              planYear,
              planMonth,
              factMonth,
              dzoDay,
              factDay,
              planDay
            ) =>
              _.defaults(
                dzoBriefly,
                dzoYear,
                dzoMonth,
                factYear,
                dzo,
                dzo2,
                planYear,
                planMonth,
                factMonth,
                dzoDay,
                factDay,
                planDay
              )
          );

          this.bigTable = bigTable;

          var wells = [];
          wells = _.zipWith(
            [{ inj_wells_idle: inj_wells_idle }],
            [{ inj_wells_work: inj_wells_work }],
            (inj_wells_idle, inj_wells_work) =>
              _.defaults(inj_wells_idle, inj_wells_work)
          );
          this.wells = wells;

          wells2 = _.zipWith(
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
      var nowDate=new Date(this.range.start).toLocaleDateString();      
      this.timeSelect = nowDate;    
      this.getProduction(this.item, this.item2, this.item3, this.item4);  
      this.getProductionOilandGas();
      this.getCurrencyNow(this.timeSelect);
    this.getOilNow(this.timeSelect, this.period);
    },
  },

  async mounted() {
    var nowDate=new Date().toLocaleDateString();      
    this.timeSelect = nowDate;
    this.timestampToday = new Date(this.range.start).getTime();
    this.timestampEnd = new Date(this.range.end).getTime();
    this.selectedYear = this.year;
    var productionPlan = localStorage.getItem("production-plan");
    var productionFact = localStorage.getItem("production-fact");
    if (this.company == "all") {
      this.getProduction("oil_plan", "oil_fact", "Добыча нефти", "тн");
      this.changeButton("No");
    }
    localStorage.setItem("selectedDMY", "undefined");
    this.getCurrencyNow(this.timeSelect);
    this.getOilNow(this.timeSelect, this.period);
    this.getCurrencyPeriod(this.timeSelect, this.periodUSD);
    this.getProductionOilandGas();
  },
  computed: {
  },
};
