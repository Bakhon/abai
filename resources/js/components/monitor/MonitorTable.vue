<template>
  <div class="main col-md-12 col-lg-12 row">
      <modal name="economicmodal" :width="1000" :height="430" :adaptive="true">
        <div class="container economicModal">
            <div class="row">
                <div class="col-9">
                    <h3 class="economicHeader">Экономический эффект</h3>
                </div>
                <div class="col-3">
                    <button type="button" class="btn btn-success">Скачать отчет в excel</button>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <monitor-chart1></monitor-chart1>
                </div>
                <div class="col-6">
                    <monitor-chart1></monitor-chart1>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <monitor-chart-tide></monitor-chart-tide>
                </div>
                <div class="col-6">
                    <monitor-chart-tide></monitor-chart-tide>
                </div>
            </div>
        </div>
      </modal>

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
        <div>
            <monitor-chart-tide></monitor-chart-tide>
        </div>
      </div>
    </div>

    <div class="tables-two col-xs-12 col-sm-7 col-md-7 col-lg-8 col-xl-8">
      <div class="tables-string-gno3">
        <div class="center">
          <div class="schema">
            <ul class="string1 col-12">
              <li class="nav-string">
                Q1 м3/сут<input type="text" class="square2" v-model="daily_fluid_production_kormass" />
                м3/сут
              </li>

              <li class="nav-string">
                р<input type="text" class="square2" v-model="pressure" />
                бар
              </li>

              <li class="nav-string">
                t3 выход<input type="text" class="square2" v-model="temperature" />
                C
              </li>
            </ul>

            <ul class="string2 col-12">
              <li class="nav-string">
                <div class="gu"></div>
                <div class="form-label-group">
                  <select
                    class="form-control form-control-sm"
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
                Vкор(e-g) <input type="text" class="square2" v-model = "corrosionRateInMm" />
                мм/г
              </li>

              <li class="nav-string kormas">
                <div class=""></div>
                <input type="text" class="square2 gu2" v-model = "kormass" />
              </li>
            </ul>

            <ul class="string3 col-12">
              <li class="nav-string">
              </li>
            </ul>

            <ul class="string4 col-12">
              <li class="nav-string">
                Q1 м3/сут<input type="text" class="square2" v-model="daily_fluid_production" />
              </li>

              <li class="nav-string">
                t2 выход<input type="text" class="square2" v-model="heater_output_pressure" />С
              </li>
            </ul>

            <ul class="string5 col-12">
              <li class="nav-string">
                T1вход <input type="text" class="square2" v-model="heater_inlet_pressure" /> C
              </li>
            </ul>

            <div class="col-4 trio">
              <ul class="string6 col-12">
                <li class="nav-string">
                  ИК (реком.)<input
                    type="text"
                    class="square2"
                    v-model = "doseMgPerL"
                  />
                  г/м3
                </li>

                <li class="nav-string">
                  ИК (факт)<input type="text" class="square2" v-model="current_dosage" />
                  г/м3
                </li>
                <li class="nav-string">
                  ИК (план)<input type="text" class="square2" v-model="plan_dosage" />
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
                  р <input type="text" class="square2" v-model="surge_tank_pressure" /> бар
                </li>
              </ul>
            </div>
            <div class="col-4 trio">
              <ul class="string8 col-12">
                <li class="nav-string">
                  р <input type="text" class="square2"  v-model="pump_discharge_pressure" /> бар
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
        <div v-if="signalizotor > 0 && signalizotor != null" class="text-wrap">
            <div v-if="signalizotorAbs <= 10" class="alert alert-success" role="alert">
            Плановая превышает фактическую дозировку на {{signalizotorAbs}}%
            </div>
            <div v-if="signalizotorAbs > 10 && signalizotorAbs <=30" class="alert alert-warning" role="alert">
            Плановая превышает фактическую дозировку на {{signalizotorAbs}}%
            </div>
            <div v-if="signalizotorAbs > 30" class="alert alert-danger" role="alert">
            Плановая превышает фактическую дозировку на {{signalizotorAbs}}%
            </div>
        </div>
        <div v-if="signalizotor < 0 && signalizotor != null" class="text-wrap">
            <div v-if="signalizotorAbs <= 10" class="alert alert-success" role="alert">
            Фактическая превышает плановую дозировку на {{signalizotorAbs}}%
            </div>
            <div v-if="signalizotorAbs > 10 && signalizotorAbs <=30" class="alert alert-warning" role="alert">
            Фактическая превышает плановую дозировку на {{signalizotorAbs}}%
            </div>
            <div v-if="signalizotorAbs > 30" class="alert alert-danger" role="alert">
            Фактическая превышает плановую дозировку на {{signalizotorAbs}}%
            </div>
        </div>
        <div class="responsible">
            <button type="button" class="btn btn-info" @click="pushBtn">Экономический эффект</button>
        </div>
      </div>
      <!-- <div class="tables-string-gno4">
      </div> -->
      <div class="tables-string-gno4">
        <calendar
          is-dark
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
import VModal from 'vue-js-modal';

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
      showCalendar: false,
      ngdu: null,
      plan_dosage: null,
      current_dosage: null,
      daily_fluid_production_kormass: null,
      pressure: null,
      temperature: null,
      pump_discharge_pressure: null,
      surge_tank_pressure: null,
      heater_inlet_pressure: null,
      heater_output_pressure: null,
      daily_fluid_production: null,
      signalizotor:null,
      signalizotorAbs:null,
      pipe: null,
      lastCorrosion: null,
      wmLast: null,
      constantsValues: null,
      corrosionRateInMm: null,
      doseMgPerL: null
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
          console.log(data);
          if (data) {
            this.$emit("chart1", data.chart1),
            this.$emit("chart2", data.chart2),
            this.$emit("chart3", data.chart3),
            this.$emit("chart4", data.chart4),
            this.kormass = data.kormass,
            this.pipe = data.pipe,
            this.lastCorrosion = data.lastCorrosion,
            this.wmLast = data.wmLast,
            this.constantsValues = data.constantsValues
          } else {
            console.log("No data");
          }
        });
    },
    dayClicked(day) {
        this.date = day.id;
        this.ngdu = null,
        this.uhe = null,
        this.plan_dosage = null,
        this.current_dosage = null,
        this.daily_fluid_production_kormass = null,
        this.pressure = null,
        this.temperature = null,
        this.pump_discharge_pressure = null,
        this.surge_tank_pressure = null,
        this.heater_inlet_pressure = null,
        this.heater_output_pressure = null,
        this.daily_fluid_production = null,
        this.signalizotor = null,
        this.signalizotorAbs = null
        this.axios
            .post("/ru/getgudatabyday", {
                gu_id: this.gu,
                dt: day.id
            })
            .then((response) => {
                let data = response.data;
                if (data) {
                    this.ngdu = data.ngdu,
                    this.uhe = data.uhe,
                    this.plan_dosage = response.data.ca.plan_dosage,
                    this.current_dosage = response.data.uhe.current_dosage,
                    this.daily_fluid_production_kormass = response.data.ngdu.daily_fluid_production_kormass,
                    this.pressure = response.data.ngdu.pressure,
                    this.temperature = response.data.ngdu.temperature,
                    this.pump_discharge_pressure = response.data.ngdu.pump_discharge_pressure,
                    this.surge_tank_pressure = response.data.ngdu.surge_tank_pressure,
                    this.heater_inlet_pressure = response.data.ngdu.heater_inlet_pressure,
                    this.heater_output_pressure = response.data.ngdu.heater_output_pressure,
                    this.daily_fluid_production = response.data.ngdu.daily_fluid_production,
                    this.signalizotor = ((response.data.ca.plan_dosage - response.data.uhe.current_dosage) * response.data.ca.plan_dosage) / 100,
                    this.signalizotorAbs = Math.abs(this.signalizotor),
                    this.calc()
                } else {
                    console.log("No data");
                }
            });
    },
    calc() {
        this.axios
            .post("/ru/corrosion", {
                wc: this.ngdu.bsw,
                rhol: this.wmLast.density,
                GOR: this.constantsValues[0].value,
                mul: 0.007074,
                mug: 0.00015,
                sigma: this.constantsValues[1].value,
                d: this.pipe.inner_diameter,
                di: this.pipe.inner_diameter,
                do: this.pipe.outside_diameter,
                roughness: this.pipe.roughness,
                length: this.pipe.length,
                p: this.ngdu.surge_tank_pressure,
                to: 10,
                ti: this.ngdu.heater_output_pressure,
                conH2S: this.wmLast.hydrogen_sulfide,
                conCO2: this.wmLast.carbon_dioxide,
                q_l: this.ngdu.daily_fluid_production,
                rhog: 0.7705
            })
            .then((response) => {
                let data = response.data;
                if (data) {
                    this.corrosionRateInMm = data.corrosion_rate_in_mm,
                    this.doseMgPerL = data.dose_mg_per_l
                } else {
                    console.log("No data");
                }
            });
    },
    pushBtn(){
        this.$modal.show('economicmodal');
    }
  },
};
</script>
<style scoped>
.btn {
    display: block !important;
    width: 100% !important;
}

.economicModal{
  background-color: #0F1430;
  border: 1px solid #0D2B4D;
}
</style>
