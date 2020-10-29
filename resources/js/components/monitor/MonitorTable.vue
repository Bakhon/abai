<template>
  <div class="main col-md-12 col-lg-12 row">
    <div class="tables-one col-xs-12 col-sm-5 col-md-5 col-lg-2 col-xl-2">
      <div class="tables-string-gno col-12">
        <div class="head-monitor">Фактическая содержание углекислого газа</div>
        <monitor-chart1></monitor-chart1>
      </div>

      <div class="tables-string-gno col-12">
        <div class="head-monitor">Фактическое содержание сероводорода</div>
        <monitor-chart2></monitor-chart2>
      </div>

      <div class="tables-string-gno col-12">
        <div class="head-monitor">Фактическая скорость коррозии</div>
        <monitor-chart3></monitor-chart3>
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
                <div class="form-label-group">
                  <select
                    class="form-control"
                    name="gu_id"
                    v-model="gu"
                    @change="chooseGu($event)"
                  >
                    <option v-for="row in gus" v-bind:value="row.id">
                      {{ row.name }}
                    </option>
                  </select>
                </div>
              </li>

              <li class="nav-string second">
                Vкор(f-g) <input type="text" class="square2" value="888.88" />
                мм/г
              </li>

              <li class="nav-string kormas">
                <div class=""></div>
                <input type="text" class="square2 gu2" v-model = "kormass" />
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
      <div class="tables-string-gno4">
        <calendar
          is-dark
          color="orange"
          is-expanded
          :first-day-of-week="2"
          locale="ru"
          :max-date="new Date()"
          @dayclick="dayClicked"
        >
        </calendar>
      </div>
    </div>
  </div>
</template>

<script>
import Calendar from "v-calendar/lib/components/calendar.umd";
import DatePicker from "v-calendar/lib/components/date-picker.umd";

// Register components in your 'main.js'
Vue.component("calendar", Calendar);
Vue.component("date-picker", DatePicker);
export default {
  components: {
    Calendar,
    DatePicker,
  },
  data: function () {
    return {
      gus: null,
      gu: null,
      date: null,
      kormass: null,
      showCalendar: false
    };
  },
  beforeCreate: function () {
    this.axios.get("/ru/getallgus").then((response) => {
      let data = response.data;
      if (data) {
        this.gus = data.data;
      } else {
        console.log("No data");
      }
    });
  },
  methods: {
    chooseGu(event) {
      this.axios
        .post("/ru/getgudata", {
          gu_id: event.target.value,
        })
        .then((response) => {
          let data = response.data;
          if (data) {
            this.$emit("chart1", data.chart1),
            this.$emit("chart2", data.chart2),
            this.$emit("chart3", data.chart3),
            this.$emit("chart4", data.chart4),
            this.kormass = data.kormass
          } else {
            console.log("No data");
          }
        });
    },
    dayClicked(day) {
      this.date = day.id;
    }
  },
};
</script>
