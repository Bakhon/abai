export default {
  data: function () {
    return {
      specificIncomeFactTG:'',
      specificIncomePlanUSD:'',
      specificIncomeFactUSD:'',
      unitCostsPlanTG:'',
      unitCostsFactTG:'',
      unitCostsPlanUSD:'',
      unitCostsFactUSD:'',
      kvlPerTonPlan:'',
      kvlPerTonFact:'',
      actualEfficiencyGTMP:'',
      actualEfficiencyGTMUN:'',
      actualDrillingEfficiencyP:'',
      actualDrillingEfficiencyUN:'',
      default2: '111',
      currentMonth:'',
      productionFactPercentOneDzo: '',
      productionFactPercentSumm: '',
      quantityRange: '',
      productionFactPersent: '',
      productionPlanPersent: '',
      quantityGetProductionOilandGas: "",
      gas_planDay: "",
      gas_factDayProgressBar: "",
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
      currencyChart: "",
      selectedDMY2: "",
      selectedDMY: "",
      periodSelectOil: "",
      oilPeriod: "",
      index: "",
      widthProgress: "90",
      period: "7",
      periodUSD: "7",
      timeSelect: "",
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
      circleMenu: "",
      month: new Date().getMonth() + 1,
      year: new Date().getFullYear(),
      ChartTable: "График",
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
      selectedDay: undefined,
      selectedMonth: undefined,
      selectedYear: undefined,
      wells: [""],
      wells2: [""],
      bigTable: [""],
      displayHeadTables: "",
      starts: [""],
      company: "all",
      factYearSumm: "",
      planYearSumm: "",
      planMonthSumm: "",
      factMonthSumm: "",
      factDaySumm: "",
      planDaySumm: "",
      oil_factDayPercent: "",
      oil_dlv_factDayPercent: "",
      gas_factDayPercent: "",
      oil_factDay: "",
      oil_planDay: "",
      oil_dlv_factDay: "",
      oil_dlv_planDay: "",
      gas_factDay: "",
      oil_dlv_factDayProgressBar: "",
      tableHover4: '',
      t1:'',
      t2:'',
      t3:'',
      t4:'',
      t5:'',
      t6:'',
      oil_factDayProgressBar: '',
      dateStart: '',
      dateEnd: '',
      isEnableSpeedometers: false,
    };
  },
  methods: {
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
    getCurrencyPeriod: function (dates, item2) {
      var dates = dates;
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

    changeButton(showTableItem, changeButton) {
      var a;
      if (changeButton === "Yes") {
        if (showTableItem === "Yes") {
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

      if (showTableItem === "Yes") {
        this.ChartTable = "График";
        this.displayChart = "display:none;";
        if (this.company === "all") {
          this.displayHeadTables = "display: block";
          this.displayTable = "display:none;";
        } else {
          this.displayTable = "display:block;";
          this.displayHeadTables = "display: none";
        }
        this.showTableOn = ""; //colour button
      } else if (showTableItem === "No") {
        this.displayTable = "display:none;";
        this.displayHeadTables = "display: none";
        this.displayChart = "display:block;";
        this.ChartTable = "Таблица";
        this.displayHeadTables = "display: none";
        this.showTableOn = showTableOn; //colour button
      }
    },
    changeTable(change) {
      this.Table1 = "display:none";
      this.Table2 = "display:none";
      this.Table3 = "display:none";
      this.Table4 = "display:none";
      this.Table5 = "display:none";
      this.Table6 = "display:none";
      this.Table7 = "display:none";

      if (change === "1") {
        this.Table1 = "display:block";
      } else if (change === "2") {
        this.Table2 = "display:block";
      } else if (change === "3") {
        this.Table3 = "display:block";
      } else if (change === "4") {
        this.Table4 = "display:block";
      } else if (change === "5") {
        this.Table5 = "display:block";
      } else if (change === "6") {
        this.Table6 = "display:block";
      } else if (change === "7") {
        this.Table7 = "display:block";
      }
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
          var NameDzoFull = this.NameDzoFull;
          var company = this.company;
          var summForTables = [];

          //test data
          if (company === 'ЭМГ') {
            summForTables.push({ dzo: NameDzoFull[2], productionFactForMonth: 1, productionPlanForMonth: 1 });
            this.tables = summForTables;
            this.productionFactPercentOneDzo = 0;
          }

          else if (company === 'ПКИ') {
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
          }

          else if (company != "all") {
            var arrdata = new Array();
            arrdata = _.filter(data, _.iteratee({ dzo: company }));

            this.getProductionPercentOneDzo(arrdata);

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

            summForTables = _(dataWithMay)
              .groupBy("dzo")
              .map((dzo, id) => ({
                dzo: id,
                productionFactForMonth: _.round(_.sumBy(dzo, productionFact), 0),
                productionPlanForMonth: _.round(_.sumBy(dzo, productionPlan), 0),
              }))
              .value();

            if (this.buttonHover12 != '') {
              data = _.reject(data, _.iteratee({ dzo: "ОМГ" }));
              data = _.reject(data, _.iteratee({ dzo: "КГМ" }));
              data = _.reject(data, _.iteratee({ dzo: "ММГ" }));
              data = _.reject(data, _.iteratee({ dzo: "КТМ" }));
              data = _.reject(data, _.iteratee({ dzo: "КБМ" }));
              data = _.reject(data, _.iteratee({ dzo: "КОА" }));

              dzoMonth.push({ dzoMonth: NameDzoFull[5] }, { dzoMonth: NameDzoFull[11] }, { dzoMonth: NameDzoFull[12] });
              factMonth.push({ factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 });
              planMonth.push({ planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 });
              productionFactPercent.push({ productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 });
            }

            if (this.buttonHover13 != '') {
              dzoMonth.push({ dzoMonth: NameDzoFull[5] }, { dzoMonth: NameDzoFull[11] }, { dzoMonth: NameDzoFull[12] }, { dzoMonth: NameDzoFull[2] }, { dzoMonth: NameDzoFull[9] }, { dzoMonth: NameDzoFull[10] });
              factMonth.push({ factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 });
              planMonth.push({ planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 });
              productionFactPercent.push({ productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 });
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
          var dzo = [];
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
            );
            factMonth.push({ factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 });
            planMonth.push({ planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 });
            productionFactPercent.push({ productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 });
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


            dzoMonth.push({ dzoMonth: "ТШ" }, { dzoMonth: "НКО" }, { dzoMonth: "КПО" });
            factMonth.push({ factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 });
            planMonth.push({ planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 });
            productionFactPercent.push({ productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 });
          }

          if (this.buttonHover13 != '') {
            dzoMonth.push({ dzoMonth: "ТШ" }, { dzoMonth: "НКО" }, { dzoMonth: "КПО" }, { dzoMonth: "ЭМГ" }, { dzoMonth: "ПКИ" }, { dzoMonth: "АМГ" });
            factMonth.push({ factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 }, { factMonth: 1 });
            planMonth.push({ planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 }, { planMonth: 1 });
            productionFactPercent.push({ productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 }, { productionFactPercent: 0 });
          }

          _.forEach(productionPlanAndFactMonth, function (item) { //k1q!!!
            factMonth.push({ factMonth: item.productionFactForChart });
            planMonth.push({ planMonth: item.productionPlanForChart });
            dzoMonth.push({ dzoMonth: item.dzo });
          });

          //changed data reject
          var getProductionPercent = this.getProductionPercent(data);
          getProductionPercent = _.orderBy(getProductionPercent, ["dzoPercent"], ["desc"]);

          _.forEach(getProductionPercent, function (item) {
            productionFactPercent.push({ productionFactPercent: item.productionFactPercent });
          });

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
            dzoMonth,
            dzo,
            dzo2,
            planMonth,
            factMonth,
            (
              productionFactPercent,
              dzoPercent,
              dzoMonth,
              dzo,
              dzo2,
              planMonth,
              factMonth,
            ) =>
              _.defaults(
                productionFactPercent,
                dzoPercent,
                dzoMonth,
                dzo,
                dzo2,
                planMonth,
                factMonth,
              )
          );

          bigTable = _.orderBy(bigTable, ["dzoMonth"], ["desc"]);
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
    getProductionPercentOneDzo(data) {
      var timestampToday = this.timestampToday;
      var timestampEnd = this.timestampEnd
      var quantityRange = this.quantityRange;
      var productionPlan = localStorage.getItem("production-plan");
      var productionFact = localStorage.getItem("production-fact");
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
    },
    getProductionPercent(data) {
      var timestampToday = this.timestampToday;
      var timestampEnd = this.timestampEnd
      var quantityRange = this.quantityRange;
      var productionPlan = localStorage.getItem("production-plan");
      var productionFact = localStorage.getItem("production-fact");
      var dataWithMay = [];

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
    saveCompany(com) {
      this.company = com;
      this.getProduction(this.item, this.item2, this.item3, this.item4);
    },
    //When we change date
    changeDate() {
      //"27.05.2020"
      this.selectedDay = 0;
      this.timestampToday = new Date(this.range.start).getTime();
      this.timestampEnd = new Date(this.range.end).getTime();
      this.quantityRange = ((this.timestampEnd - this.timestampToday) / 86400000) + 1;
      let nowDate = new Date(this.range.start).toLocaleDateString();
      this.timeSelect = nowDate;
      this.getProduction(this.item, this.item2, this.item3, this.item4);
      this.getCurrencyNow(this.timeSelect);
      this.getOilNow(this.timeSelect, this.period);
    },
    getDefaultData() {
      this.axios
        .get('/ru/getdzocalcsactualmonth', {})
        .then(response => {
          if (response.data) {
            let dateStart = new Date(2020, 0, 1);
            let dateEnd = new Date(2020, response.data - 1, 1);
            dateEnd.setDate(0);
            dateEnd.setHours(23,59,59);
            this.dateStart = dateStart;
            this.dateEnd = dateEnd;
          }
        });
      this.axios
        .get('/ru/kpicalc', {})
        .then(response => {
          if (response.data) {
            // console.log((month_number; porog; tsel; vyzov; fact; formula1; formula2))
            // console.log((company_id; date; otklonenie ot tseli; otklonenie ot tseli %; vlianie na uluchshenie-uhudshenie))
            this.t1 = [1].concat(response.data['Abdulgafarov1'][0]);
            this.t2 = [1].concat(response.data['Abdulgafarov2'][0]);
            this.t3 = [1].concat(response.data['Abdulgafarov3'][0]);
            this.t4 = [1].concat(response.data['Abdulgafarov4'][0]);
            this.t5 = [1].concat(response.data['Abdulgafarov5'][0]);
            this.t6 = [1, 0, 1, 2, 1];
            this.isEnableSpeedometers = true;
          }
        });
    },
  },
  async mounted() {
    this.getDefaultData();
    this.timeSelect = new Date().toLocaleDateString();
    localStorage.setItem("selectedDMY", "undefined");
  }
}