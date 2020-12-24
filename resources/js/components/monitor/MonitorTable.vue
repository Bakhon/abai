<template>
  <div>
    <modal name="economicmodal" :width="1200" :height="600" :adaptive="true">
      <div class="container-fluid economicModal" style="width: 100%; height: 100%; overflow-y: auto;">
        <div class="row">
          <div class="col-12">
            <h3 class="economicHeader">{{ trans('monitoring.economic_effect') }} {{ nextYear }}</h3>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <table class="table table-bordered economicModalTable">
              <tbody>
              <tr v-for="row in economicNextYear">
                <td>{{ row[0] }}</td>
                <td>{{ row[1] }}</td>
                <td>{{ row[2] }}</td>
                <td>{{ row[3] }}</td>
                <td>{{ row[4] }}</td>
                <td>{{ row[5] }}</td>
                <td>{{ row[6] }}</td>
                <td>{{ row[7] }}</td>
                <td>{{ row[8] }}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <h3 class="economicHeader">{{ trans('monitoring.economic_effect') }} {{ currentYear }}</h3>
            <h4 class="economicHeader" v-if="economicCurrentDays">{{ trans('monitoring.days_count') }}: {{ economicCurrentDays }}</h4>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <table class="table table-bordered economicModalTable">
              <tbody>
              <tr v-for="row in economicCurrentYear">
                <td>{{ row[0] }}</td>
                <td>{{ row[1] }}</td>
                <td>{{ row[2] }}</td>
                <td>{{ row[3] }}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </modal>
    <modal name="corrosion" :width="1200" :height="800" :adaptive="true">
      <div class="container-fluid economicModal" style="width: 100%; height: 100%; overflow-y: auto;">
        <h1>{{ trans('monitoring.corrosion_simulator') }}</h1>
        <div class="row corrosion">
          <div class="col-12">
            <h4>{{ trans('monitoring.environment_conditions') }}</h4>
          </div>
          <div class="col-4">
            <table class="table table-bordered economicModalTable">
              <tbody>
              <tr>
                <td>H2S {{ trans('monitoring.in_water') }}</td>
                <td v-if="wmLastH2S">{{ wmLastH2S.hydrogen_sulfide }} мг/л</td>
              </tr>
              <tr>
                <td>CO2 {{ trans('monitoring.in_water') }}</td>
                <td v-if="wmLastCO2">{{ wmLastCO2.carbon_dioxide }} мг/л</td>
              </tr>
              <tr>
                <td>H2S {{ trans('monitoring.in_gas') }}</td>
                <td v-if="oilGas">{{ oilGas.hydrogen_sulfide_in_gas }} ppm</td>
              </tr>
              <tr>
                <td>H2S {{ trans('monitoring.in_gas') }}</td>
                <td v-if="oilGas">{{ oilGas.carbon_dioxide_in_gas }} %</td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="col-4">
            <table class="table table-bordered economicModalTable">
              <tbody>
              <tr>
                  <td>{{ trans('monitoring.partial_pressure') }} рH2S</td>
                <td>{{ result.pH2S_kPa }} кПа</td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.partial_pressure') }} рCO2</td>
                <td>{{ result.pCO2_kPa }} кПа</td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="col-4">
            <table class="table table-bordered economicModalTable">
              <tbody>
              <tr>
                <td>{{ trans('monitoring.environment_in_communication_point') }} А</td>
                <td>{{ result.environment_point_A }}</td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.environment_in_point') }} E</td>
                <td>{{ result.environment_point_E }}</td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.environment_in_point') }} F</td>
                <td>{{ result.environment_point_F }}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
        <br>
        <div class="row corrosion">
          <div class="col-12">
            <h4>{{ trans('monitoring.fluid_parameters') }}</h4>
          </div>
          <div class="col-4">
            <table class="table table-bordered economicModalTable">
              <tbody>
              <tr>
                <td colspan="2"><h5>{{ trans('monitoring.gu') }}, {{ trans('monitoring.point') }} А</h5></td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.pressure') }}</td>
                <td v-if="ngdu">{{ ngdu.surge_tank_pressure }} {{ trans('monitoring.units.bar') }}</td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.temperature') }}</td>
                <td>25 С</td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="col-4">
            <table class="table table-bordered economicModalTable">
              <tbody>
              <tr>
                <td colspan="2"><h5>{{ trans('monitoring.collector') }}, {{ trans('monitoring.point') }} Е</h5></td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.pressure') }}</td>
                <td v-if="ngdu">{{ ngdu.pump_discharge_pressure }} {{ trans('monitoring.units.bar') }}</td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.temperature') }}</td>
                <td>{{ result.t_final_celsius_point_E }} С</td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="col-4">
            <table class="table table-bordered economicModalTable">
              <tbody>
              <tr>
                <td colspan="2"><h5>{{ trans('monitoring.collector') }}, {{ trans('monitoring.point') }} F</h5></td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.pressure') }}</td>
                <td>{{ result.final_pressure_bar_point_F }} {{ trans('monitoring.units.bar') }}</td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.temperature') }}</td>
                <td>{{ result.t_final_celsius_point_F }} C</td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.stream_velocity') }}</td>
                <td>{{ result.flow_velocity_meter_per_sec }} {{ trans('monitoring.units.m_s') }}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
        <br>
        <div class="row corrosion">
          <div class="col-12">
            <h4>{{ trans('monitoring.corrosion_name') }}</h4>
          </div>
          <div class="col-4">
            <table class="table table-bordered economicModalTable">
              <tbody>
              <tr>
                <td colspan="2"><h5>{{ trans('monitoring.gu') }}, {{ trans('monitoring.point') }} A</h5></td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.fact_common_corrosion_speed') }} ({{ trans('monitoring.test_coupons') }}), {{ trans('monitoring.units.v_kor_fact') }}</td>
                <td v-if="corrosionVelocityWithInhibitor">{{ corrosionVelocityWithInhibitor.toFixed(2) }}
                  {{ trans('monitoring.units.mm_year') }}
                </td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.calc_common_corrosion_speed') }}, {{ trans('monitoring.units.v_kor') }} (А)</td>
                <td>{{ result.corrosion_rate_mm_per_y_point_A }} {{ trans('monitoring.units.mm_year') }}</td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="col-4">
            <table class="table table-bordered economicModalTable">
              <tbody>
              <tr>
                <td colspan="2"><h5>{{ trans('monitoring.collector') }}, {{ trans('monitoring.point') }} E</h5></td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.calc_common_corrosion_speed') }}, {{ trans('monitoring.units.v_kor') }} (Е)</td>
                <td>{{ result.corrosion_rate_mm_per_y_point_E }} {{ trans('monitoring.units.mm_year') }}</td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.calc_local_corrosion_speed') }} ({{ trans('monitoring.test_coupons') }}), {{ trans('monitoring.units.v_kor') }} (Е)</td>
                <td>{{ result.papavinasam_corrosion_mm_per_y_point_E }} {{ trans('monitoring.units.mm_year') }}</td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="col-4">
            <table class="table table-bordered economicModalTable">
              <tbody>
              <tr>
                <td colspan="2"><h5>{{ trans('monitoring.collector') }}, {{ trans('monitoring.point') }} F</h5></td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.calc_common_corrosion_speed') }}, {{ trans('monitoring.units.v_kor') }} (F)</td>
                <td>{{ result.corrosion_rate_mm_per_y_point_F }} {{ trans('monitoring.units.mm_year') }}</td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.calc_local_corrosion_speed') }} ({{ trans('monitoring.test_coupons') }}), {{ trans('monitoring.units.v_kor') }} (F)</td>
                <td>{{ result.papavinasam_corrosion_mm_per_y_point_F }} {{ trans('monitoring.units.mm_year') }}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
        <br>
        <div class="row corrosion">
          <div class="col-12">
            <h4>{{ trans('monitoring.corrosion_inhibitor') }}</h4>
          </div>
          <div class="col-4">
            <table class="table table-bordered economicModalTable">
              <tbody>
              <tr>
                <td colspan="2"><h5>{{ trans('monitoring.gu') }}, {{ trans('monitoring.point') }} A</h5></td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.recommended_dosage') }}</td>
                <td v-if="result">{{ result.dose_mg_per_l_point_A }} {{ trans('monitoring.units.mg_l') }}</td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="col-4">
            <table class="table table-bordered economicModalTable">
              <tbody>
              <tr>
                <td colspan="2"><h5>{{ trans('monitoring.collector') }}, {{ trans('monitoring.point') }} E</h5></td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.recommended_dosage') }}</td>
                <td v-if="result">{{ result.dose_mg_per_l_point_E }} {{ trans('monitoring.units.mg_l') }}</td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="col-4">
            <table class="table table-bordered economicModalTable">
              <tbody>
              <tr>
                <td colspan="2"><h5>{{ trans('monitoring.collector') }}, {{ trans('monitoring.point') }} F</h5></td>
              </tr>
              <tr>
                <td>{{ trans('monitoring.recommended_dosage') }}</td>
                <td v-if="result">{{ result.dose_mg_per_l_point_F }} {{ trans('monitoring.units.mg_l') }}</td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="col-4">
            <table class="table table-bordered economicModalTable">
              <tbody>
              <tr>
                <td>{{ trans('monitoring.max_recommended_dosage') }}</td>
                <td v-if="result">{{ result.max_dose }} {{ trans('monitoring.units.mg_l') }}</td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="col-4">
            <table class="table table-bordered economicModalTable">
              <tbody>
              <tr>
                <td>{{ trans('monitoring.fact_dosage') }}</td>
                <td v-if="current_dosage">{{ current_dosage }} {{ trans('monitoring.units.mg_l') }}</td>
              </tr>
              </tbody>
            </table>
          </div>
          <div class="col-4">
            <table class="table table-bordered economicModalTable">
              <tbody>
              <tr>
                <td>{{ trans('monitoring.plan_dosage') }}</td>
                <td v-if="plan_dosage">{{ plan_dosage }} {{ trans('monitoring.units.mg_l') }}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </modal>
    <div class="row monitor">
      <div class="col-2 monitor__charts">
        <div class="monitor__charts-item">
          <p class="monitor__charts-item-title">{{ trans('monitoring.action_substance_of_co2') }}</p>
          <monitor-chart :title="trans('monitoring.action_substance_of_co2')" :data="chart1Data"></monitor-chart>
        </div>
        <div class="monitor__charts-item">
          <p class="monitor__charts-item-title">{{ trans('monitoring.action_substance_of_h2s') }}</p>
          <monitor-chart :title="trans('monitoring.action_substance_of_h2s')" :data="chart2Data"></monitor-chart>
        </div>
        <div class="monitor__charts-item">
          <p class="monitor__charts-item-title">{{ trans('monitoring.actual_corrosion_speed') }}</p>
          <monitor-chart :title="trans('monitoring.actual_corrosion_speed')" :data="chart3Data"></monitor-chart>
        </div>
        <div class="monitor__charts-item">
          <p class="monitor__charts-item-title">{{ trans('monitoring.actual_inhibitor_level') }}</p>
          <monitor-chart :title="trans('monitoring.actual_inhibitor_level')" :data="chart4Data"></monitor-chart>
        </div>
      </div>
      <div class="col-8 monitor__schema">
        <div class="tables-string-gno3">
          <div class="schema">
            <img src="/img/monitor/schema.svg">
            <ul class="string1">
              <li class="nav-string">
                <span class="before">{{ trans('monitoring.units.p_kon') }}</span>
                <input type="text" class="square2" readonly v-model="pressure"/>
                <span class="after">{{ trans('monitoring.units.bar') }}</span>
              </li>
              <li class="nav-string">
                <span class="before">{{ trans('monitoring.units.t_kon') }}</span>
                <input
                    readonly
                    type="text"
                    class="square2"
                    v-model="daily_fluid_production_kormass"
                />
                <span class="after">C</span>
              </li>
              <li class="nav-string">
                <span class="before">{{ trans('monitoring.units.v_kor') }}(F)</span>
                <input type="text" class="square2" readonly v-model="corF"/>
                <span class="after">{{ trans('monitoring.units.mm_g') }}</span>
              </li>
            </ul>
            <div class="kormas">
              <div class=""></div>
              <input type="text" class="square2 gu2" readonly v-model="kormass"/>
            </div>

            <div class="block-gu">
              <span>{{ trans('monitoring.gu') }}</span>
              <select
                  name="gu_id"
                  v-model="gu"
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
                    v-model="heater_output_pressure"
                />
                <span class="after">С</span>
              </li>

              <li class="nav-string">
                <span class="before">{{ trans('monitoring.units.v_kor') }}(E)</span>
                <input type="text" class="square2" readonly v-model="corE"/>
                <span class="after">{{ trans('monitoring.units.mm_g') }}</span>
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
                    v-model="corrosionVelocityWithInhibitor"
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
            <monitor-chart-radialbar></monitor-chart-radialbar>
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
        <button type="button" class="btn btn-info" @click="pushBtn" :disabled="economicCurrentYear.length < 1">
          {{ trans('monitoring.economic_effect') }}
        </button
        >
        <button type="button" class="btn btn-info" @click="pushBtn2" :disabled="!dose">
          {{ trans('monitoring.corrosion_simulator') }}
        </button>
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
import Calendar from "v-calendar/lib/components/calendar.umd"
import DatePicker from "v-calendar/lib/components/date-picker.umd"
import VueTableDynamic from 'vue-table-dynamic'
import moment from 'moment'

Vue.component("calendar", Calendar);
Vue.component("date-picker", DatePicker);

export default {
  components: {
    Calendar,
    DatePicker,
    VueTableDynamic
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
      corrosionVelocityWithInhibitor: null,
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
      economicNextYear: [],
      economicCurrentYear: [],
      currentYear: new Date().getFullYear(),
      nextYear: new Date(new Date().setFullYear(new Date().getFullYear() + 1)).getFullYear(),
      chart1Data: null,
      chart2Data: null,
      chart3Data: null,
      chart4Data: null,
      problemGus: [],
      economicCurrentDays: null
    };
  },
  beforeCreate: function () {
    this.axios.get(this.localeUrl("/getallgus")).then((response) => {
      let data = response.data;
      if (data) {
        this.gus = data.data;
      } else {
        console.log("No data");
      }
    });
    this.axios.get(this.localeUrl("/getguproblems")).then((response) => {
      let data = response.data;
      if (data) {
        this.problemGus = data.problemGus;
      } else {
        console.log("No data");
      }
    });
  },
  methods: {
    chooseProblemGu(gu_id) {
      this.gu = gu_id
      this.chooseGu()
      this.dayClicked({
        id: moment().format('YYYY-MM-DD')
      })
    },
    chooseGu() {
      this.dose = 0;
      this.axios
          .post(this.localeUrl("/getgudata"), {
            gu_id: this.gu
          })
          .then((response) => {
            let data = response.data;
            if (data) {
              this.chart1Data = data.chart1
              this.chart2Data = data.chart2
              this.chart3Data = data.chart3
              this.chart4Data = data.chart4

              this.kormass = data.kormass
              this.pipe = data.pipe
              this.pipeab = data.pipeab
              this.lastCorrosion = data.lastCorrosion
              this.constantsValues = data.constantsValues
              this.getEconomicData(event.target.value);
            } else {
              console.log("No data");
            }
          });
    },
    dayClicked(day) {
      this.date = day.id;
      this.ngdu = null
      this.uhe = null
      this.plan_dosage = null
      this.current_dosage = null
      this.daily_fluid_production_kormass = null
      this.pressure = null
      this.temperature = null
      this.pump_discharge_pressure = null
      this.surge_tank_pressure = null
      this.heater_inlet_pressure = null
      this.heater_output_pressure = null
      this.daily_fluid_production = null
      this.signalizator = null
      this.signalizatorAbs = null
      this.corrosionRateInMm = null
      this.doseMgPerL = null
      this.corrosionRateInMmAB = null
      this.doseMgPerLAB = null
      this.corrosionVelocityWithInhibitor = null
      this.dose = 0
      this.$emit("chart5", this.dose)
      this.axios
          .post(this.localeUrl("/getgudatabyday"), {
            gu_id: this.gu,
            dt: day.id,
          })
          .then((response) => {
            let data = response.data;
            if (data) {
              this.ngdu = data.ngdu
              this.uhe = data.uhe
              this.plan_dosage = response.data.ca.plan_dosage
              this.current_dosage = response.data.uhe.current_dosage
              this.pressure = response.data.ngdu.pressure
              this.temperature = response.data.ngdu.temperature
              this.pump_discharge_pressure = response.data.ngdu.pump_discharge_pressure
              this.surge_tank_pressure = response.data.ngdu.surge_tank_pressure
              this.heater_inlet_pressure = response.data.ngdu.heater_inlet_pressure
              this.heater_output_pressure = response.data.ngdu.heater_output_pressure
              this.daily_fluid_production = response.data.ngdu.daily_fluid_production
              this.signalizator = (response.data.uhe.current_dosage - response.data.ca.plan_dosage) * 100 / response.data.ca.plan_dosage
              this.signalizatorAbs = Math.round(this.signalizator)
              this.corrosionVelocityWithInhibitor = this.lastCorrosion.corrosion_velocity_with_inhibitor
              this.wmLast = data.wmLast
              this.wmLastH2S = data.wmLastH2S
              this.wmLastCO2 = data.wmLastCO2
              this.wmLastH2O = data.wmLastH2O
              this.wmLastHCO3 = data.wmLastHCO3
              this.wmLastCl = data.wmLastCl
              this.wmLastSO4 = data.wmLastSO4
              this.oilGas = data.oilGas
              this.calc()
            } else {
              console.log("No data");
            }
          });
    },
    calc() {
      this.axios
          .post(this.localeUrl("/corrosion"), {
            WC: this.ngdu.bsw,
            GOR1: this.constantsValues[0].value,
            sigma: this.constantsValues[1].value,
            do: this.pipe.outside_diameter,
            roughness: this.pipe.roughness,
            l: this.pipe.length,
            thickness: this.pipe.thickness,
            P: this.ngdu.pump_discharge_pressure,
            t_heater: this.ngdu.heater_output_pressure,
            conH2S: this.wmLastH2S.hydrogen_sulfide,
            conCO2: this.wmLastCO2.carbon_dioxide,
            q_l: this.ngdu.daily_fluid_production,
            H2O: this.ngdu.bsw,
            HCO3: this.wmLastHCO3.hydrocarbonate_ion,
            Cl: this.wmLastCl.chlorum_ion,
            SO4: this.wmLastSO4.sulphate_ion,
            q_g_sib: this.ngdu.daily_gas_production_in_sib,
            P_bufer: this.ngdu.surge_tank_pressure,
            rhol: this.wmLastH2S.density,
            rho_o: this.oilGas.water_density_at_20,
            rhog: this.oilGas.gas_density_at_20,
            mul: this.oilGas.oil_viscosity_at_20,
            mug: this.oilGas.gas_viscosity_at_20,
            q_o: this.ngdu.daily_oil_production
          })
          .then((response) => {
            let data = response.data;
            if (data) {
              this.corA = data.corrosion_rate_mm_per_y_point_A
              this.corE = data.corrosion_rate_mm_per_y_point_E
              this.corF = data.corrosion_rate_mm_per_y_point_F
              this.dose = data.max_dose
              this.result = data
              this.daily_fluid_production_kormass = data.t_final_celsius_point_F
              this.pressure = data.final_pressure_bar_point_F
              this.$emit("chart5", data.max_dose)
            } else {
              console.log("No data")
            }
          });
    },
    pushBtn() {
      this.$modal.show("economicmodal");
    },
    pushBtn2() {
      this.$modal.show("corrosion");
    },
    getEconomicData(gu) {
      this.axios
          .post(this.localeUrl("/vcoreconomic"), {
            gu: this.gu,
          })
          .then((response) => {
            let data = response.data;
            if (data) {
              this.economicNextYear = data;
            } else {
              console.log("No data");
            }
          });

      this.axios
          .post(this.localeUrl("/vcoreconomiccurrent"), {
            gu: this.gu,
          })
          .then((response) => {
            let data = response.data;
            if (data) {
              console.log(data);
              this.economicCurrentYear = data.tableData;
              this.economicCurrentDays = data.daysEcoCurrent;
            } else {
              console.log("No data");
            }
          });
    }
  }
};
</script>
<style scoped>

.economicModal {
  background-color: #0F1430;
}

.economicModalTable {
  color: #fff;
  border: #fff solid 2px;
}

.corrosion {
  background-color: #20274F;
  margin: 2px;
}
</style>
