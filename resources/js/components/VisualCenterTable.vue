<template>
  <div>
    <div>
      <div class="level1-content row">
        <div class="col-md-12 col-lg-12 row">
          <div class="main col-lg-7-2 row">
            <div class="col-sm-12 col-md-4 col-lg-4"></div>
            <div class="col-sm-12 col-md-4 col-lg-4">
              <div class="col-md-12 col-lg-12 row">
                <div class="timer-visual-center">
                  <!--  <div class="left-arrow"></div>-->
                  <div class="timer">
                    <div class="time">{{ date2 }}</div>
                    <div class="date">{{ date3 }}</div>
                  </div>
                  <!-- <div class="right-arrow"></div>-->
                </div>
              </div>
            </div>
            <div class="visual-center-center">
              <div
                class="level2-tab"
                v-for="(menuDMY, index) in menuDMY()"
                @click="selectedDMY = menuDMY.id"
                :style="{
                  'background-color': menuDMY.current,
                }"
              >
                {{ menuDMY.DMY }}
              </div>

              <div class="month-day">
                <div
                  class="navigation-table"
                  v-bind:style="{ display: display }"
                >
                  <div class="navigation">
                    <div v-on:click="decrease"><</div>
                  </div>
                  <div class="navigation-month navigation" colspan="5">
                    {{ monthes[month] }} {{ year }}
                  </div>
                  <div class="navigation">
                    <div v-on:click="increase">></div>
                  </div>
                </div>
                <!--<div class="day" v-for="d in day">{{d}}</div>-->
                <div v-for="week in calendar()">
                  <div
                    @click="selectedDay = day.index"
                    class="week"
                    v-for="(day, index) in week"
                    :style="{
                      color: day.weekend,
                      'background-color': day.current,
                    }"
                  >
                    <div>{{ day.index }}</div>
                  </div>
                </div>
                <div
                  class="week"
                  v-for="(month, index) in getMonths()"
                  :key="index.id"
                  :style="{
                    'background-color': month.current,
                  }"
                  @click="selectedMonth = month.index"
                >
                  {{ month.index }}
                </div>

                <div
                  class="week"
                  v-for="(year, index) in getYears()"
                  :key="year.id"
                  :style="{
                    'background-color': year.current,
                  }"
                  @click="selectedYear = year.index"
                >
                  {{ year.index }}
                </div>
              </div>
            </div>

            <div class="visual-center-center">
              <div class="tables">
                <div class="visual-center-center">
                  <a href="#">
                    <li
                      class="circle-2"
                      tabindex="-2"
                      :style="`${buttonHover1}`"
                      @click="
                        getProduction('oil_plan', 'oil_fact', ' Добыча нефти')
                      "
                    >
                      <div class="circle-2-string">Добыча нефти</div>
                    </li>
                  </a>
                  <a href="#">
                    <li
                      class="circle-2"
                      tabindex="-2"
                      :style="`${buttonHover2}`"
                      @click="
                        getProduction(
                          'oil_dlv_plan',
                          'oil_dlv_fact',
                          'Сдача нефти'
                        )
                      "
                    >
                      <div class="circle-2-string">Сдача нефти</div>
                    </li>
                  </a>
                  <a href="#">
                    <li
                      class="circle-2"
                      tabindex="-2"
                      :style="`${buttonHover3}`"
                      @click="
                        getProduction('gas_plan', 'gas_fact', 'Добыча газа')
                      "
                    >
                      <div class="circle-2-string">Добыча газа</div>
                    </li>
                  </a>
                  <a href="#">
                    <li
                      class="circle-2"
                      tabindex="-2"
                      :style="`${buttonHover4}`"
                      @click="
                        getProduction('liq_plan', 'liq_fact', 'Добыча жидкости')
                      "
                    >
                      <div class="circle-2-string">Добыча жидкости</div>
                    </li>
                  </a>
                  <a href="#">
                    <li
                      class="circle-2"
                      tabindex="-2"
                      :style="`${buttonHover5}`"
                      @click="
                        getProduction('gk_plan', 'gk_fact', 'Добыча конденсата')
                      "
                    >
                      <div class="circle-2-string">Добыча конденсата</div>
                    </li>
                  </a>
                  <a href="#">
                    <li
                      class="circle-2"
                      tabindex="-2"
                      :style="`${buttonHover6}`"
                      @click="
                        getProduction('inj_plan', 'inj_fact', 'Объём закачки')
                      "
                    >
                      <div class="circle-2-string">Объём закачки</div>
                    </li>
                  </a>
                </div>

                <div class="tables">
                  <div class="tables-name">{{ circleMenu }}</div>
                  <!--<div class="btn btn-info2" >Вывести таблицу</div>-->
                  <div class="tables-string">
                    <!--<div class="cell-colour-top table-border"></div>-->
                    <div class="cell-number-top table-border">№</div>
                    <div class="cell-name-top table-border">Предприятия</div>
                    <div class="cell-last-top table-border cell-last">
                      ДОБЫЧА, тонн
                    </div>
                    <div class="cell2 table-border">
                      План на {{ selectedYear }} год
                    </div>
                    <div class="cell2 table-border">План на июль месяц</div>
                    <div class="cell3 table-border">СУТОЧНАЯ</div>
                    <div class="cell3 table-border">С НАЧАЛА МЕСЯЦА</div>
                    <div class="cell3 table-border cell-last">
                      С НАЧАЛА ГОДА
                    </div>
                    <div class="cell4 table-border">ПЛАН</div>
                    <div class="cell4 table-border">ФАКТ</div>
                    <div class="cell4 table-border">(+,-)</div>
                    <div class="cell4 table-border">ПЛАН</div>
                    <div class="cell4 table-border">ФАКТ</div>
                    <div class="cell4 table-border">(+,-)</div>
                    <div class="cell4 table-border">ПЛАН</div>
                    <div class="cell4 table-border">ФАКТ</div>
                    <div class="cell4 table-border cell-last">(+,-)</div>
                  </div>
                  <div style="clear: both;"></div>
                  <div v-for="item in tables">
                    <div>
                      <div>
                        <!-- <div class="cell-colour table-border">
                 
                        </div>-->
                        <div class="cell-number table-border"></div>
                        <div class="cell-name table-border">
                          {{ item.dzo }}
                          <!--{{item.time}}-->
                        </div>
                        <div class="cell table-border">{{ item.planYear }}</div>
                        <div class="cell table-border"></div>
                        <div class="cell table-border">{{ item.plan }}</div>
                        <div class="cell table-border">{{ item.fact }}</div>
                        <div class="cell table-border colour">
                          <div>
                            <div
                              v-if="item.fact"
                              class="circle-table"
                              :style="`background: ${getColor(
                                item.fact - item.plan
                              )}`"
                            ></div>
                          </div>
                          <div v-if="item.fact">
                            <div>{{ item.fact - item.plan }}</div>
                          </div>
                        </div>
                        <div class="cell table-border">
                          {{ item.productionPlanForMonth }}
                        </div>
                        <div class="cell table-border">
                          {{ item.productionFactForMonth }}
                        </div>
                        <div class="cell table-border colour">
                          <div
                            v-if="item.productionPlanForMonth"
                            class="circle-table"
                            :style="`background: ${getColor(
                              item.productionPlanForMonth -
                                item.productionFactForMonth
                            )}`"
                          ></div>
                          <!--3cell-->
                          <div v-if="item.productionPlanForMonth">
                            {{
                              item.productionPlanForMonth -
                              item.productionFactForMonth
                            }}
                          </div>
                        </div>
                        <div class="cell table-border">{{ item.planYear }}</div>
                        <div class="cell table-border">{{ item.factYear }}</div>
                        <div class="cell table-border cell-last colour">
                          <div
                            v-if="item.planYear"
                            class="circle-table"
                            :style="`background: ${getColor(
                              item.planYear - item.factYear
                            )}`"
                          ></div>
                          <div v-if="item.planYear">
                            {{ item.planYear - item.factYear }}
                          </div>
                        </div>
                      </div>
                      <div style="clear: both;"></div>
                    </div>
                    <div class="tables-bottom-line"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="visual-center-center">
              <div class="tables-name">График добычи</div>
              <visual-center-chart-area-center
                v-for="(serial, index) in productionForChart"
                v-bind:postTitle="serial"
                :key="serial"
              >
              </visual-center-chart-area-center>
            </div>
            <div class="visual-center-center">
              <div class="visual-center-bottom">
                <div class="visual-center-string1">Отключение РП:</div>
                <div class="visual-center-string2"></div>
                <div class="visual-center-string1">Отключение скважин:</div>
                <div class="visual-center-string2"></div>
                <div class="visual-center-string1">Выбросы и разливы:</div>
                <div class="visual-center-string2"></div>
                <div class="visual-center-string1">Прочие:</div>
                <div class="visual-center-string2"></div>
              </div>
              <div class="visual-center-bottom">
                <div class="accidents-first accidents">
                  <div class="number-of-accidents">2</div>
                  Несчастные <br />случаи
                </div>
                <div class="accidents-second accidents">
                  <div class="number-of-accidents">0</div>
                  Смертельные <br />случаи
                </div>
                <div class="accidents-third accidents">
                  <div class="number-of-accidents">14</div>
                  COVID <br />19
                </div>
              </div>
              <div class="visual-center-bottom">
                <div class="difference-of-24">Отклонение</div>
                <div class="visual-center-chart-bar-bottom">
                  <visual-center-chart-bar-bottom
                    v-for="(start, index) in starts"
                    v-bind:starts="start"
                    :key="start"
                  ></visual-center-chart-bar-bottom>
                </div>
              </div>
            </div>
          </div>
          <div class="visual-center-right-column">
            <div class="right-button-panel">
              <div class="right-chart-button right-button" tabindex="-5">
                График
              </div>
              <div class="right-table-button right-button" tabindex="-5">
                Таблица
              </div>
            </div>
            <div class="donut">
              <div class="indent">Фонд добывающих скважин</div>
              <div>
                <visual-center-chart-donut-right1
                  v-for="(well, index) in wells2"
                  v-bind:wells2="well"
                  :key="well"
                ></visual-center-chart-donut-right1>
              </div>
              <!--  <div class="donut-inner1 inner2">
                 В работе <br />{{ well[0] }}
                </div>
                <div class="donut-inner1 inner1">
                  В простое<br />{{ well[1] }}
              </div>-->
            </div>
            <div class="donut donut2">
              <div class="indent">Фонд нагнетательных скважин</div>
              <div>
                <visual-center-chart-donut-right2
                  v-for="(well, index) in wells"
                  v-bind:wells="well"
                  :key="well"
                ></visual-center-chart-donut-right2>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      productionForChart: "",
      tables: "",
      buttonHover1: "",
      buttonHover2: "",
      buttonHover3: "",
      buttonHover4: "",
      buttonHover5: "",
      buttonHover6: "",
      circleMenu: "",
      month: new Date().getMonth(),
      year: new Date().getFullYear(),
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
      monthes2: [
        "",
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
        "Всего добыча нефти и конденсата с учётом доли участия АО НК КазМунайГаз",
        "в т.ч.:газовый конденсат",
        "АО Озенмунайгаз (нефть) (100%)",
        "(конденсат)(100%)",
        "АО Эмбамунайгаз (100%)",
        "АО Каражанбасмунай (50%)",
        "ТОО СП Казгермунай",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
      date: new Date(),
      selectedDay: undefined,
      selectedMonth: undefined,
      selectedYear: undefined,
      selectedDMY: undefined,

      wells: [""],
      wells2: [""],
      starts: [""],
      test: [""],
      series: ["", ""],
      display: "none",
    };
  },

  methods: {
    getColor(status) {
      if (status < "0") return "#b40300";
      return "#008a17";
    },

    calendar: function () {
      var days = [];
      var week = 0;
      days[week] = [];
      var dlast = new Date(this.year, this.month + 1, 0).getDate();
      for (let i = 1; i <= dlast; i++) {
        if (new Date(this.year, this.month, i).getDay() != this.dFirstMonth) {
          var a = { index: i, id: i };
          days[week].push(a);
          if (this.selectedDay == i) {
            a.current = "#232236";
          } else if (
            i == new Date().getDate() &&
            this.year == new Date().getFullYear() &&
            this.month == new Date().getMonth()
          ) {
            a.current = "#13B062";
          }

          if (
            new Date(this.year, this.month, i).getDay() == 6 ||
            new Date(this.year, this.month, i).getDay() == 0
          ) {
            a.weekend = "#ff0000";
          }
        } else {
          week++;

          days[week] = [];
          a = { index: i };
          days[week].push(a);
          if (
            i == new Date().getDate() &&
            this.year == new Date().getFullYear() &&
            this.month == new Date().getMonth()
          ) {
            a.current = "#747ae6";
          }
          if (
            new Date(this.year, this.month, i).getDay() == 6 ||
            new Date(this.year, this.month, i).getDay() == 0
          ) {
            a.weekend = "#ff0000";
          }
        }
      }

      /*	if (days[0].length > 0) {
					for (let i = days[0].length; i < 7; i++) {
						days[0].unshift('');
						
					}
				}*/
      this.dayChange;
      if (this.selectedDMY == "0") {
        this.display = "block";
        return days;
      }
    },

    decrease: function () {
      this.month--;
      if (this.month < 0) {
        this.month = 12;
        this.month--;
        this.year--;
      }
    },
    increase: function () {
      this.month++;
      if (this.month > 11) {
        this.month = -1;
        this.month++;
        this.year++;
      }
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
            i == new Date().getMonth() &&
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
      var dlast = new Date(this.year, this.selectedMonth, 0).getDate();
      for (let i = 1; i <= dlast; i++) {
        var a = { index: i, id: i };
        DaysInMonth.push(a);
      }
      return DaysInMonth;
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
        }
      }
      return menuDMY;
    },

    getProduction(item, item2, item3) {
      localStorage.setItem("production-plan", item);
      localStorage.setItem("production-fact", item2);

      var productionPlan = localStorage.getItem("production-plan");
      var productionFact = localStorage.getItem("production-fact");

      this.circleMenu = item3;

      let company = localStorage.getItem("company");
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
          //select date filter
          var timestamp = new Date(
            this.monthes2[this.month] +
              this.selectedDay +
              " " +
              this.year +
              " 06:00:00 GMT+0600"
          ).getTime();

          arrdata = _.filter(data, _.iteratee({ dzo: company }));

          if (this.selectedDMY == 1) {
            //select only for month
            //get data by Month
            var SelectYearInMonth; //value
            if (this.selectedYear == undefined) {
              SelectYearInMonth = this.year;
            } else {
              SelectYearInMonth = this.selectedYear;
            }
            var timestampMonthStart = new Date(
              this.monthes2[this.selectedMonth] +
                //this.selectedDay +
                "1" +
                " " +
                SelectYearInMonth +
                " 06:00:00 GMT+0600"
            ).getTime();

            var dayInMonth = this.getDays().length;

            var dataWithMay = new Array();
            dataWithMay = _.filter(arrdata, function (item) {
              return _.every([
                _.inRange(
                  item.__time,
                  // 1588291200000, // from May 2020
                  // 1590883200000+1,
                  timestampMonthStart,
                  timestampMonthStart + 86400000 * dayInMonth
                ),
              ]);
            });
            //select data by

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

            /*           var productionPlanForChart2 = new Array();
               _.each(productionPlanForChart, function (item) {
             productionPlanForChart2.push({productionPlanForChart});
            });

                 var productionFactForChart2 = new Array();
                _.each(productionFactForChart, function (item) {
             productionFactForChart2.push({productionFactForChart});
            });*/
            //for chart

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
              (productionPlanForChart, productionFactForChart) =>
                _.defaults(productionPlanForChart, productionFactForChart)
            );
            productionForChart = { data: productionForChart };
            this.productionForChart = productionForChart;

            // console.log(productionForChart);

            var dzo = new Array();
            _.forEach(dataWithMay, function (item) {
              dzo.push(item.dzo);
            });
            dzo = _.uniq(dzo);

            //select summ plan for month
            var productionPlanForMonth = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item[productionPlan];
              },
              0
            );

            productionPlanForMonth = Math.ceil(
              productionPlanForMonth / dayInMonth
            );

            var prod_wells_work = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item.prod_wells_work;
              },
              0
            );
            prod_wells_work = Math.ceil(prod_wells_work / dayInMonth);

            var prod_wells_idle = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item.prod_wells_idle;
              },
              0
            );
            prod_wells_idle = Math.ceil(prod_wells_idle / dayInMonth);

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
            inj_wells_idle = Math.ceil(inj_wells_idle / dayInMonth);

            var inj_wells_work = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item.inj_wells_work;
              },
              0
            );
            inj_wells_work = Math.ceil(inj_wells_work / dayInMonth);

            //for month
            //select summ fact for month
            var productionFactForMonth = _.reduce(
              dataWithMay,
              function (memo, item) {
                return memo + item[productionFact];
              },
              0
            );
            productionFactForMonth = Math.ceil(
              productionFactForMonth / dayInMonth
            );

            //for month
            var productionFactForMonth2 = [
              { productionFactForMonth: Math.ceil(productionFactForMonth) },
            ];
            var productionPlanForMonth2 = [
              { productionPlanForMonth: Math.ceil(productionPlanForMonth) },
            ];

            var prod_wells_work2 = [{ prod_wells_work: prod_wells_work }];

            var prod_wells_idle2 = [{ prod_wells_idle: prod_wells_idle }];
            var starts_krs2 = [{ starts_krs: starts_krs }];
            var starts_prs2 = [{ starts_prs: starts_prs }];
            var starts_drl2 = [{ starts_drl: starts_drl }];
            var inj_wells_idle2 = [{ inj_wells_idle: inj_wells_idle }];
            var inj_wells_work2 = [{ inj_wells_work: inj_wells_work }];
          }

          if (this.selectedDMY == 0) {
            arrdata = _.filter(arrdata, _.iteratee({ __time: timestamp }));
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
          var dzo2 = new Array();
          _.each(dzo, function (dzo) {
            dzo2.push({ dzo });
          });

          //----------------------------
          var tables = _.zipWith(
            _.sortBy(dzo2, (dzo) => dzo.dzo),
            _.sortBy(liq_fact2, (liq_fact) => liq_fact.liq_fact),
            _.sortBy(liq_plan2, (liq_plan) => liq_plan.liq_plan),
            _.sortBy(__time2, (time) => time.time),
            _.sortBy(factYear2, (factYear) => factYear),
            _.sortBy(planYear2, (planYear) => planYear),
            _.sortBy(
              productionFactForMonth2,
              (productionFactForMonth) => productionFactForMonth
            ),
            _.sortBy(
              productionPlanForMonth2,
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

          var buttonHover =
            "border: none;" +
            " background: url(../img/visualcenter/button-hover.png) no-repeat;" +
            "    background-size: 100% auto;" +
            " background-color: #1c6fb6;";

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
      });
    },

    /*getSelectedDay() {
      localStorage.setItem("selected-day", this.selectedDay);
      var selectedDay = localStorage.getItem("selected-day");
      this.selectedDay = selectedDay;
      this.selectedColour = "background:red!important;";
    },

        getSelectedMonth() {
      localStorage.setItem("selected-day", this.selectedDay);
      var selectedDay = localStorage.getItem("selected-month");
      this.selectedDay = selectedDay;
      this.selectedColour = "background:red!important;";
    },*/
  },

  computed: {
    dayChange: function () {
      if (this.dFirstMonth == 0) {
        //this.day = ["Su", "Mn", "Tu", "We", "Th", "Fr", "Sa"];
        this.day = ["ВС", "ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ"];
      }
    },
  },
};
</script>
