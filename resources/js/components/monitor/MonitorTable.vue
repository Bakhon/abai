<template>
  <div class="main col-md-12 col-lg-12 row">
    <div class="tables-one col-xs-12 col-sm-5 col-md-5 col-lg-2 col-xl-2">
      <div class="tables-string-gno col-12">
        <div class="head-monitor">Фактическая содержание углекислого газа</div>

        <!-- <div><monitor-chart-tide></monitor-chart-tide></div>-->
        <monitor-chart-bar-rounded></monitor-chart-bar-rounded>
      </div>

      <div class="tables-string-gno col-12">
        <div class="head-monitor">Фактическое содержание сероводорода</div>
        <monitor-chart-bar-rounded></monitor-chart-bar-rounded>
      </div>

      <div class="tables-string-gno col-12">
        <div class="head-monitor">Фактическая скорость коррозии</div>

        <monitor-chart-bar-rounded></monitor-chart-bar-rounded>
      </div>

      <div class="tables-string-gno col-12">
        <div class="head-monitor">Фактическая закачка ингибитора коррозии</div>
        <div><monitor-chart-tide></monitor-chart-tide></div>
      </div>
    </div>

    <div class="tables-two col-xs-12 col-sm-7 col-md-7 col-lg-8 col-xl-8">
      <div class="tables-string-gno3">
        <div class="center">
          <div class="schema">
            <ul class="string1 col-12">
              <li class="nav-string">
                Q1 м3/сут<input type="text" class="square2" value="888.88" />
                м3/сут
              </li>

              <li class="nav-string">
                р<input type="text" class="square2" value="888.88" />
                бар
              </li>

              <li class="nav-string">
                t3 выход<input type="text" class="square2" value="888.88" />
                C
              </li>
            </ul>

            <ul class="string2 col-12">
              <li class="nav-string">
                <div class="gu"></div>
                <input type="text" class="square2 gu2" value="25" />
              </li>

              <li class="nav-string second">
                Vкор(f-g) <input type="text" class="square2" value="888.88" />
                мм/г
              </li>

              <li class="nav-string kormas">
                <div class=""></div>
                <input type="text" class="square2 gu2" value="25" />
              </li>
            </ul>

            <ul class="string3 col-12">
              <li class="nav-string">
                Vкор(e-f)<input type="text" class="square2" value="888.88" />
                мм/г
              </li>
            </ul>

            <ul class="string4 col-12">
              <li class="nav-string">
                Q1 м3/сут<input type="text" class="square2" value="888.88" />
              </li>

              <li class="nav-string">
                t2 выход<input type="text" class="square2" value="888.88" />С
              </li>
            </ul>

            <ul class="string5 col-12">
              <li class="nav-string">
                T1вход <input type="text" class="square2" value="25" /> C
              </li>
            </ul>

            <div class="col-4 trio">
              <ul class="string6 col-12">
                <li class="nav-string">
                  ИК (реком.)<input
                    type="text"
                    class="square2"
                    value="888.88"
                  />
                  г/м3
                </li>

                <li class="nav-string">
                  ИК (факт)<input type="text" class="square2" value="888.88" />
                  г/м3
                </li>
                <li class="nav-string">
                  ИК (план)<input type="text" class="square2" value="888.88" />
                  г/м3
                </li>
              </ul>
            </div>
            <div class="col-4 trio">
              <ul class="string7 col-12">
                <li class="vkor-ab">
                  Vкор(a-b)<input type="text" class="square2" value="888.88" />
                  мм/г
                </li>
                <li class="vkor-fact">
                  Vкор(факт)<input type="text" class="square2" value="888.88" />
                  мм/г
                </li>
              </ul>

              <ul class="string9 col-12">
                <li class="nav-string">
                  р <input type="text" class="square2" value="888.88" /> бар
                </li>
              </ul>
            </div>
            <div class="col-4 trio">
              <ul class="string8 col-12">
                <li class="nav-string">
                  р <input type="text" class="square2" value="888.88" /> бар
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="tables-two col-xs-12 col-sm-7 col-md-7 col-lg-2 col-xl-2">
      <div class="tables-string-gno4">
        <div class="head-monitor">Рекомендации</div>
        <div class="rek">Рекомендации дозирования ИК</div>
        <monitor-chart-radialbar></monitor-chart-radialbar>
        <div class="head-monitor">Сообщения</div>
        <div class="messages">В нашем здании будет проводится мероприятие</div>

        <div class="head-monitor">Ответственный: Ипполитов К.В.</div>
        <div class="responsible"></div>
      </div>
      <div class="tables-string-gno5">
        <div class="head-monitor">Календарь</div>
        <div
          class="calendar-tab"
          v-for="(menuDMY, index) in menuDMY()"
          @click="selectedDMY = menuDMY.id"
          :style="{
            'background-color': menuDMY.current,
          }"
        >
          {{ menuDMY.DMY }}
        </div>

        <div class="month-day">
          <div class="navigation-table" v-bind:style="{ display: display }">
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
          <div style="clear: both;"></div>
          <div class="calendar-days" v-bind:style="{ display: display }">
            <div class="day" v-for="d in day">{{ d }}</div>
          </div>
          <div style="clear: both;"></div>
          <div class="calendar-day">
            <div v-for="week in calendar()">
              <div
                @click="selectedDay = day.index"
                class="week"
                v-for="(day, index) in week"
                :style="{
                  color: day.weekend,
                  'background-color': day.current,
                }"
                v-on:click="displaynumbers"
              >
                <div class="day-begin">{{ day.index }}</div>
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
              v-on:click="displaynumbers"
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
              v-on:click="displaynumbers"
            >
              {{ year.index }}
            </div>
          </div>
        </div>
        <div class="radialbar2">
          <div class="rek2">Фактическая закачка ИК</div>
          <monitor-chart-radialbar></monitor-chart-radialbar>
        </div>
      </div>
    </div>
    <!--<monitor-chart-donut></monitor-chart-donut>-->
    <!--<monitor-chart-bar></monitor-chart-bar>-->
  </div>
</template>

<script>
import { EventBus } from "../../event-bus.js";
export default {
  data: function () {
    return {
      display: "none",
      date: new Date(),
      selectedDay: undefined,
      selectedMonth: undefined,
      selectedYear: undefined,
      selectedDMY: undefined,
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
      //day: ["Mn", "Tu", "We", "Th", "Fr", "Sa", "Su"],
      day: ["Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс"],
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
    };
  },

  methods: {
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
          if (this.selectedDay == i) {
            a.current = "#232236";
          } else if (
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
      if (days[0].length > 0) {
        for (let i = days[0].length; i < 6; i++) {
          days[0].unshift("");
        }
      }
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
            i == Number(new Date().getMonth() + 1) &&
            this.year == new Date().getFullYear()
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
        var a = { index: i, id: i };
        yearAll.push(a);
        if (this.selectedYear == i) {
          a.current = "#232236";
        } else if (i == year) {
          a.current = "#13B062";
        }
      }

      if (this.selectedDMY == "3") {
        this.display = "none";
        return yearAll;
      }
    },

    menuDMY() {
      var DMY = ["День", "Месяц", "Квартал", "Год"];
      var menuDMY = [];
      var id = 0;
      for (let i = 0; i <= 3; i++) {
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

    getLinePoints: function () {
      let uri = "/js/json/gno/line_points.json";
      this.axios.get(uri).then((response) => {
        var data = response.data;
        if (data) {
          this.$emit("data", data);
        } else {
          console.log("No data");
        }
      });
    },
  },
  async mounted() {
    this.getLinePoints();
  },
};
</script>
