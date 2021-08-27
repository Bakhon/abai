<template>
  <div>
    <div class="row monitor">
      <div class="col-2 monitor__charts">
        <div class="monitor__charts-item">
          <p class="monitor__charts-item-title">{{ trans('monitoring.action_substance_of_co2') }}</p>
          <chart
              :title="trans('monitoring.action_substance_of_co2')"
              :measurement="trans('measurements.mg/dm3')"
              :data="chartDtCarbonDioxide"/>
        </div>
        <div class="monitor__charts-item">
          <p class="monitor__charts-item-title">{{ trans('monitoring.action_substance_of_h2s') }}</p>
          <chart
              :title="trans('monitoring.action_substance_of_h2s')"
              :measurement="trans('measurements.mg/dm3')"
              :data="chartDtHydrogenSulfide"/>
        </div>
        <div class="monitor__charts-item">
          <p class="monitor__charts-item-title">{{ trans('monitoring.actual_corrosion_speed') }}</p>
          <chart
              :title="trans('monitoring.actual_corrosion_speed')"
              :measurement="trans('measurements.mm/g')"
              :data="chartCorrosion"/>
        </div>
        <div class="monitor__charts-item">
          <p class="monitor__charts-item-title">{{ trans('monitoring.actual_inhibitor_level') }}</p>
          <chart
              :title="trans('monitoring.actual_inhibitor_level')"
              :measurement="trans('measurements.g/m3')"
              :data="chartIngibitor"/>
        </div>
      </div>
      <div class="col-8 monitor__schema">
        <div class="tables-string-gno3">
          <div class="schema">
            <img :src="schemaImage">
            <ul class="string1">
              <li class="nav-string">
              </li>
              <li class="nav-string">
              </li>
              <li class="nav-string">
              </li>
            </ul>
            <div class="kormas">
              <div class=""></div>
              <input type="text" class="square2 gu2" readonly v-model="kormass"/>
            </div>

            <div class="block-gu">
              <span>{{ trans('monitoring.gu.gu') }}</span>
              <select
                  name="gu_id"
                  v-model="localGu"
                  @change="chooseGu()"
              >
                <option v-for="row in gus" v-bind:value="row.id">
                  {{ row.name }}
                </option>
              </select>
            </div>

            <ul class="string3 col-12">
              <li class="nav-string">
                <br/>
              </li>
            </ul>

            <ul class="string4">
              <li class="nav-string">
                <span class="before">{{ trans('monitoring.units.q_zh') }}</span>
                <input
                    readonly
                    type="text"
                    class="square2"
                    v-model="daily_fluid_production"
                />
                <span class="afetr">{{ trans('monitoring.units.m3_day') }}</span>
              </li>

              <li class="nav-string">
                <span class="before">t</span>
                <input
                    readonly
                    type="text"
                    class="square2"
                    v-model="heater_output_temperature"
                />
                <span class="after">С</span>
              </li>

              <li class="nav-string">
              </li>
            </ul>
            <ul class="string6 vertical">
              <li class="nav-string">
                <span class="before">{{ trans('monitoring.units.ik_recommended') }}</span>
                <input
                    readonly
                    type="text"
                    class="square2"
                    v-model="dose"
                />
                <span class="after">{{ trans('monitoring.units.g_m3') }}</span>
              </li>

              <li class="nav-string">
                <span class="before">{{ trans('monitoring.units.ik_actual') }}</span>
                <input
                    readonly
                    type="text"
                    class="square2"
                    v-model="current_dosage"
                />
                <span class="after">{{ trans('monitoring.units.g_m3') }}</span>
              </li>
              <li class="nav-string">
                <span class="before">{{ trans('monitoring.units.ik_plan') }}</span>
                <input
                    readonly
                    type="text"
                    class="square2"
                    v-model="plan_dosage"
                />
                <span class="after">{{ trans('monitoring.units.g_m3') }}</span>
              </li>
            </ul>

            <ul class="string7 vertical">
              <li class="nav-string">
                <span class="before">{{ trans('monitoring.units.v_kor') }}(A)</span>
                <input type="text" class="square2" readonly v-model="corA"/>
                <span class="after">{{ trans('monitoring.units.mm_g') }}</span>
              </li>
              <li class="nav-string">
                <span class="before">{{ trans('monitoring.units.v_kor_fact') }}</span>
                <input
                    readonly
                    type="text"
                    class="square2"
                    v-model="corrosionVelocity"
                />
                <span class="after">{{ trans('monitoring.units.mm_g') }}</span>
              </li>
            </ul>

            <ul class="string9">
              <li class="nav-string">
                <span class="before">р</span>
                <input
                    readonly
                    type="text"
                    class="square2"
                    v-model="surge_tank_pressure"
                />
                <span class="after">{{ trans('monitoring.units.bar') }}</span>
              </li>
            </ul>
            <ul class="string8">
              <li class="nav-string">
                <span class="before">р</span>
                <input
                    readonly
                    type="text"
                    class="square2"
                    v-model="pump_discharge_pressure"
                />
                <span class="after">{{ trans('monitoring.units.bar') }}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-2 monitor__right">
        <div class="monitor__right-block monitor__right-block_radial">
          <p class="monitor__right-block-title">{{ trans('monitoring.ik_recommend') }}</p>
          <div class="radial">
            <chart-radial-bar/>
          </div>
          <div class="signalizator">
            <div class="signalizator-gus" v-if="problemGus.length > 0">
              <p>{{ trans('monitoring.problem_gu_list') }}:</p>
              <a
                  href="#"
                  v-for="gu in problemGus"
                  @click.prevent="chooseProblemGu(gu.id)"
                  class="badge"
                  :class="{
                      'badge-success': gu.diff <= 5,
                      'badge-warning': gu.diff > 5 && gu.diff <= 10,
                      'badge-danger': gu.diff > 10
                  }"
              >
                {{ gu.name }}
              </a>
            </div>
            <div v-if="signalizatorAbs > 0 && signalizatorAbs != null" class="text-wrap">
              <div
                  v-if=""
                  class="alert"
                  :class="{
                                    'alert-success': signalizatorAbs <= 5,
                                    'alert-warning': signalizatorAbs > 5 && signalizatorAbs <= 10,
                                    'alert-danger': signalizatorAbs > 10
                                }"
                  role="alert"
              >
                {{ trans('monitoring.fact_more_than_plan_dosage') }} {{ signalizatorAbs }}%
              </div>
            </div>
          </div>
        </div>
        <div class="monitor__right-block monitor__right-block_calendar">
          <div class="media">
            <calendar
                is-expanded
                :first-day-of-week="2"
                :locale="{id: currentLang, masks: { weekdays: 'WW' }}"
                :max-date="new Date()"
                @dayclick="dayClicked"
            >
            </calendar>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import Calendar from "v-calendar/lib/components/calendar.umd"
import DatePicker from "v-calendar/lib/components/date-picker.umd"
import VueTableDynamic from 'vue-table-dynamic'
import moment from 'moment';
import chart from './chart';
import chartRadialBar from './MonitorChartRadialBar';
import {globalloadingMutations} from '@store/helpers';

Vue.component("calendar", Calendar);
Vue.component("date-picker", DatePicker);

export default {
  components: {
    Calendar,
    DatePicker,
    VueTableDynamic,
    chart,
    chartRadialBar
  },
  props: {
    gu: {
      type: Number,
      default: null
    },
  },
  data: function () {
    return {
      localGu: this.gu,
      gus: null,
      date: null,
      kormass: null,
      showCalendar: false,
      ngdu: null,
      plan_dosage: null,
      current_dosage: null,
      t_final_celsius_point_F: null,
      final_pressure: null,
      temperature: null,
      pump_discharge_pressure: null,
      surge_tank_pressure: null,
      heater_inlet_temperature: null,
      heater_output_temperature: null,
      daily_fluid_production: null,
      signalizator: null,
      signalizatorAbs: null,
      pipe: null,
      pipeab: null,
      lastCorrosion: null,
      wmLast: null,
      constantsValues: null,
      corrosionRateInMm: null,
      doseMgPerL: null,
      corrosionRateInMmAB: null,
      doseMgPerLAB: null,
      corrosionVelocity: null,
      wmLastH2S: null,
      wmLastCO2: null,
      wmLastH2O: null,
      wmLastHCO3: null,
      wmLastCl: null,
      wmLastSO4: null,
      oilGas: null,
      corA: null,
      corE: null,
      corF: null,
      dose: 0,
      result: {},
      chartDtCarbonDioxide: null,
      chartDtHydrogenSulfide: null,
      chartCorrosion: null,
      chartIngibitor: null,
      problemGus: [],
      validation: [
        {
          key: 'ngdu',
          error: this.trans('monitoring.monitor.errors.ngdu')
        },
        {
          key: 'oilGas',
          error: this.trans('monitoring.monitor.errors.oilGas')
        },
        {
          key: 'pipe',
          error: this.trans('monitoring.monitor.errors.pipe')
        },
        {
          key: 'pump_discharge_pressure',
          error: this.trans('monitoring.monitor.errors.pump_discharge_pressure')
        },
        {
          key: 'surge_tank_pressure',
          error: this.trans('monitoring.monitor.errors.surge_tank_pressure')
        },
        {
          key: 'wmLastH2S.hydrogen_sulfide',
          error: this.trans('monitoring.monitor.errors.hydrogen_sulfide')
        },

      ],
      isDataValidated: false,
      validationErrors: [],
    };
  },
  computed: {
    schemaImage() {
      if (this.currentLang === 'kz') return '/img/monitor/schema_kz.svg'
      return '/img/monitor/schema.svg'
    }
  },
  beforeCreate: function () {
    this.axios.get(this.localeUrl("/getallgus")).then((response) => {
      let data = response.data;
      if (data) {
        this.gus = data.data;
      } else {
        console.log("No data");
      }
    })

    this.axios.get(this.localeUrl("/getguproblems"))
        .then((response) => {
          let data = response.data;
          if (data) {
            this.problemGus = data.problemGus;
          } else {
            console.log("No data");
          }
        })
  },
  mounted: function () {
    this.$nextTick(function () {
      this.chooseGu();
    })
  },
  methods: {
    ...globalloadingMutations([
      'SET_LOADING'
    ]),
    chooseProblemGu(gu_id) {
      this.localGu = gu_id
      this.chooseGu()
      this.dayClicked({
        id: moment().format('YYYY-MM-DD')
      })
    },
    chooseGu() {
      this.dose = 0;
      this.SET_LOADING(true);
      this.axios
          .post(this.localeUrl("/getgudata"), {
            gu_id: this.localGu
          })
          .then((response) => {
            let data = response.data;
            if (data) {
              this.chartDtCarbonDioxide = data.chartDtCarbonDioxide
              this.chartDtHydrogenSulfide = data.chartDtHydrogenSulfide
              this.chartCorrosion = data.chartCorrosion
              this.chartIngibitor = data.chartIngibitor

              this.kormass = data.kormass
              this.pipe = data.pipe
              this.pipeab = data.pipeab
              this.lastCorrosion = data.lastCorrosion
              this.constantsValues = data.constantsValues
            } else {
              console.log("No data");
            }
          })
          .finally(() => {
            this.SET_LOADING(false);
          });
    },
    resetData() {
      this.corA = null;
      this.corE = null;
      this.corF = null;
      this.dose = 0;
      this.result = {};
      this.t_final_celsius_point_F = null;
      this.final_pressure = null;
      this.ngdu = null;
      this.uhe = null;
      this.plan_dosage = null;
      this.current_dosage = null;
      this.temperature = null;
      this.pump_discharge_pressure = null;
      this.surge_tank_pressure = null;
      this.heater_inlet_temperature = null;
      this.heater_output_temperature = null;
      this.daily_fluid_production = null;
      this.signalizator = null;
      this.signalizatorAbs = null;
      this.corrosionRateInMm = null;
      this.doseMgPerL = null;
      this.corrosionRateInMmAB = null;
      this.doseMgPerLAB = null;
      this.corrosionVelocity = null;
    },
    dayClicked(day) {
      this.date = day.id;

      this.resetData();

      this.$emit("chart5", this.dose);
      this.SET_LOADING(true);
      this.axios
          .post(this.localeUrl("/getgudatabyday"), {
            gu_id: this.localGu,
            dt: day.id,
          })
          .then((response) => {
            let data = response.data;
            this.isDataValidated = false;

            if (data) {
              this.ngdu = data.ngdu
              this.uhe = data.uhe
              this.plan_dosage = data.ca ? data.ca.plan_dosage : null
              this.current_dosage = data.uhe ? data.uhe.current_dosage : null
              this.final_pressure = data.ngdu ? data.ngdu.pressure : null
              this.temperature = data.ngdu ? data.ngdu.temperature : null
              this.pump_discharge_pressure = data.ngdu ? data.ngdu.pump_discharge_pressure : null
              this.surge_tank_pressure = data.ngdu ? data.ngdu.surge_tank_pressure : null
              this.heater_inlet_temperature = data.ngdu ? data.ngdu.heater_inlet_temperature : null
              this.heater_output_temperature = data.ngdu ? data.ngdu.heater_output_temperature : null
              this.daily_fluid_production = data.ngdu ? data.ngdu.daily_fluid_production : null

              if (data.uhe && data.ca) {
                this.signalizator = (data.uhe.current_dosage - data.ca.plan_dosage) * 100 / data.ca.plan_dosage
                this.signalizatorAbs = Math.round(this.signalizator)
              }

              this.lastCorrosion = data.lastCorrosion
              this.wmLast = data.wmLast
              this.wmLastH2S = data.wmLastH2S
              this.wmLastCO2 = data.wmLastCO2
              this.wmLastH2O = data.wmLastH2O
              this.wmLastHCO3 = data.wmLastHCO3
              this.wmLastCl = data.wmLastCl
              this.wmLastSO4 = data.wmLastSO4
              this.oilGas = data.oilGas

              let corrosion_with_inhibitor = this.lastCorrosion.corrosion_velocity_with_inhibitor;
              let background_corrosion = this.lastCorrosion.background_corrosion_velocity;
              this.corrosionVelocity = corrosion_with_inhibitor ? corrosion_with_inhibitor : background_corrosion;

              if (this.isValidData()) {
                this.calc();
              }

              this.displayErrors();

            } else {
              console.log("No data");
            }
          })
          .finally(() => {
            this.SET_LOADING(false);
          });
      ;
    },
    validateData() {
      this.validationErrors = [];

      this.validation.forEach((rule) => {
        let ruleKeys = rule.key.split('.');

        let value = 'empty';
        for (let i = 0; i < ruleKeys.length; i++) {
          if (value !== 'empty') {
            value = value[ruleKeys[i]]
          } else {
            value = this[ruleKeys[i]];
          }
        }
        if (!value || value == 'empty') {
          this.validationErrors.push(rule.error);
        }
      });
      this.isDataValidated = true;
    },
    isValidData() {
      if (!this.isDataValidated) {
        this.validateData()
      }
      return this.validationErrors.length === 0;
    },
    displayErrors() {
      this.validationErrors.forEach((error) => {
        this.showToast(error, this.trans('app.error'), 'danger', 10000);
      });
    },
    calc() {
      this.axios
          .post(this.localeUrl("/corrosion-dosage"), {
            gu_id: this.localGu,
            t_heater_inlet: this.ngdu.heater_inlet_temperature,
            conH2S: this.wmLastH2S.hydrogen_sulfide,
            conCO2: this.wmLastCO2.carbon_dioxide,
            P_bufer: this.ngdu.surge_tank_pressure,
            current_dosage: this.current_dosage
          })
          .then((response) => {
            let data = response.data;
            if (data) {
              this.corA = data.corrosion_rate_mm_per_y_point_A
              this.dose = data.dose_mg_per_l_point_A;
              this.result = data
              this.$emit("chart5", data.dose_mg_per_l_point_A)
            } else {
              console.log("No data")
            }
          });
    }
  }
};
</script>
<style scoped>
.economicModalTable {
  color: #fff;
  border: #fff solid 2px;
}

.corrosion {
  margin: 2px;
}
</style>
