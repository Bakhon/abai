<template>
<div class="container-fluid">
    <modal name="economicmodal" :width="1000" :height="430" :adaptive="true">
      <div class="container economicModal">
        <div class="row">
          <div class="col-9">
            <h3 class="economicHeader">Экономический эффект 2021</h3>
          </div>
          <div class="col-3">
            <!-- <button type="button" class="btn btn-success">
              Скачать отчет в excel
            </button> -->
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <vue-table-dynamic
            :params="params"
            ref="table"
            >
            </vue-table-dynamic>
          </div>
        </div>
        <!-- <div class="row">
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
        </div> -->
      </div>
    </modal><modal name="corrosion" :width="1000" :height="430" :adaptive="true">
      <div class="container economicModal" style="min-height: 430px">
        <br />
        <div class="row">
          <div class="col-4">
            <h6 class="economicHeader">
              Cкорость потока, м/сек: {{ result.flow_velocity_meter_per_sec }}
            </h6>
          </div>
          <div class="col-4">
            <h6 class="economicHeader">
              Массовый расход, кг/сек: {{ result.m_dot }}
            </h6>
          </div>
          <div class="col-4">
            <h6 class="economicHeader">
              Конечное давление, бар: {{ result.final_pressure_bar_point_F }}
            </h6>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <h6 class="economicHeader">
              Cкорость коррзоии в точке А, мм/год:
              {{ result.corrosion_rate_mm_per_y_point_A }}
            </h6>
          </div>
          <div class="col-4">
            <h6 class="economicHeader">
              Cкорость коррзоии в точке Е, мм/год:
              {{ result.corrosion_rate_mm_per_y_point_E }}
            </h6>
          </div>
          <div class="col-4">
            <h6 class="economicHeader">
              Cкорость коррзоии в точке F, мм/год:
              {{ result.corrosion_rate_mm_per_y_point_F }}
            </h6>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <h6 class="economicHeader">
              Дозировка в точке А, г/м3: {{ result.dose_mg_per_l_point_A }}
            </h6>
          </div>
          <div class="col-4">
            <h6 class="economicHeader">
              Дозировка в точке E, г/м3: {{ result.dose_mg_per_l_point_E }}
            </h6>
          </div>
          <div class="col-4">
            <h6 class="economicHeader">
              Дозировка в точке F, г/м3: {{ result.dose_mg_per_l_point_F }}
            </h6>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <h6 class="economicHeader">
              Cреда в точке А: {{ result.environment_point_A }}
            </h6>
          </div>
          <div class="col-4">
            <h6 class="economicHeader">
              Cреда в точке E: {{ result.environment_point_E }}
            </h6>
          </div>
          <div class="col-4">
            <h6 class="economicHeader">
              Cреда в точке F: {{ result.environment_point_F }}
            </h6>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <h6 class="economicHeader">
              Папавинасам скорость коррзоии в точке А, мм/год:
              {{ result.papavinasam_corrosion_mm_per_y_point_A }}
            </h6>
          </div>
          <div class="col-4">
            <h6 class="economicHeader">
              Папавинасам скорость коррзоии в точке E, мм/год:
              {{ result.papavinasam_corrosion_mm_per_y_point_E }}
            </h6>
          </div>
          <div class="col-4">
            <h6 class="economicHeader">
              Папавинасам скорость коррзоии в точке F, мм/год:
              {{ result.papavinasam_corrosion_mm_per_y_point_F }}
            </h6>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <h6 class="economicHeader">Падение давления: {{ result.dP }}</h6>
          </div>
          <div class="col-4">
            <h6 class="economicHeader">
              Конечная температура в точке F:
              {{ result.t_final_celsius_point_F }}
            </h6>
          </div>
          <div class="col-4">
            <h6 class="economicHeader">
              Скорость коррзоии,мм/год: {{ result.corrosion_mm_per_year }}
            </h6>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <h6 class="economicHeader">
              Парциальное давление pCO2, кПа: {{ result.pCO2_kPa }}
            </h6>
          </div>
          <div class="col-4">
            <h6 class="economicHeader">
              Парциальное давление pH2S, кПа: {{ result.pH2S_kPa }}
            </h6>
          </div>
          <div class="col-4">
            <h6 class="economicHeader">H2S, мг/л: {{ result.H2S_mg_per_l }}</h6>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <h6 class="economicHeader">CO2, мг/л: {{ result.CO2_mg_perl }}</h6>
          </div>
          <div class="col-4">
            <h6 class="economicHeader">
              Пропорция pCO2 к pH2S: {{ result.pCO2_per_pH2S }}
            </h6>
          </div>
          <div class="col-4"></div>
        </div>
      </div>
    </modal>
    <div class="row no-gutters">
        <div class="col-2">
            <h6>Фактическая содержание углекислого газа</h6>
            <monitor-chart1></monitor-chart1>
            <h6>Фактическое содержание сероводорода</h6>
            <monitor-chart2></monitor-chart2>
            <h6>Фактическая скорость коррозии</h6>
            <monitor-chart3></monitor-chart3>
            <h6>Фактическая закачка ингибитора коррозии</h6>
            <monitor-chart-tide></monitor-chart-tide>
        </div>
        <div class="col-8">
            <div class="tables-string-gno3">
                <div class="center">
                <div class="schema">
                    <ul class="string1 col-12">
                    <li class="nav-string">
                        T кон. <input
                        type="text"
                        class="square2"
                        v-model="daily_fluid_production_kormass"
                        />
                        C
                    </li>

                    <li class="nav-string">
                        P кон.<input type="text" class="square2" v-model="pressure" />
                        бар
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
                        Vкор(F) <input type="text" class="square2" v-model="corF" />
                        мм/г
                    </li>

                    <li class="nav-string kormas">
                        <div class=""></div>
                        <input type="text" class="square2 gu2" v-model="kormass" />
                    </li>
                    </ul>

                    <ul class="string3 col-12">
                    <li class="nav-string">
                        <br />
                    </li>
                    </ul>

                    <ul class="string4 col-12">
                    <li class="nav-string">
                        Q1 м3/сут<input
                        type="text"
                        class="square2"
                        v-model="daily_fluid_production"
                        />
                    </li>

                    <li class="nav-string">
                        t2 выход<input
                        type="text"
                        class="square2"
                        v-model="heater_output_pressure"
                        />С
                    </li>

                    <li class="nav-string">
                        Vкор(E)<input type="text" class="square2" v-model="corE" />С
                    </li>
                    </ul>

                    <ul class="string5 col-12">
                    <li class="nav-string">
                        T1вход
                        <input
                        type="text"
                        class="square2"
                        v-model="heater_inlet_pressure"
                        />
                        C
                    </li>
                    </ul>

                    <div class="col-4 trio">
                    <ul class="string6 col-12">
                        <li class="nav-string">
                        ИК (реком.)<input
                            type="text"
                            class="square2"
                            v-model="dose"
                        />
                        г/м3
                        </li>

                        <li class="nav-string">
                        ИК (факт)<input
                            type="text"
                            class="square2"
                            v-model="current_dosage"
                        />
                        г/м3
                        </li>
                        <li class="nav-string">
                        ИК (план)<input
                            type="text"
                            class="square2"
                            v-model="plan_dosage"
                        />
                        г/м3
                        </li>
                    </ul>
                    </div>
                    <div class="col-4 trio">
                    <ul class="string7 col-12">
                        <li class="vkor-ab">
                        Vкор(A)<input type="text" class="square2" v-model="corA" />
                        мм/г
                        </li>
                        <li class="vkor-fact">
                        Vкор(факт)<input
                            type="text"
                            class="square2"
                            v-model="corrosionVelocityWithInhibitor"
                        />
                        мм/г
                        </li>
                    </ul>

                    <ul class="string9 col-12">
                        <li class="nav-string">
                        р
                        <input
                            type="text"
                            class="square2"
                            v-model="surge_tank_pressure"
                        />
                        бар
                        </li>
                    </ul>
                    </div>
                    <div class="col-4 trio">
                    <ul class="string8 col-12">
                        <li class="nav-string">
                        р
                        <input
                            type="text"
                            class="square2"
                            v-model="pump_discharge_pressure"
                        />
                        бар
                        </li>
                    </ul>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-2">
            <h6>Рекомендации дозирования ИК</h6>
            <div class="radial">
                <monitor-chart-radialbar></monitor-chart-radialbar>
            </div>
            <div>
                <div
                    v-if="signalizator < 0 && signalizator != null"
                    class="text-wrap"
                >
                    <div
                    v-if="signalizatorAbs <= 10"
                    class="alert alert-success"
                    role="alert"
                    >
                    Фактическая превышает плановую дозировку на {{ signalizatorAbs }}%
                    </div>
                    <div
                    v-if="signalizatorAbs > 10 && signalizatorAbs <= 30"
                    class="alert alert-warning"
                    role="alert"
                    >
                    Фактическая превышает плановую дозировку на {{ signalizatorAbs }}%
                    </div>
                    <div
                    v-if="signalizatorAbs > 30"
                    class="alert alert-danger"
                    role="alert"
                    >
                    Фактическая превышает плановую дозировку на {{ signalizatorAbs }}%
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-info" @click="pushBtn" :disabled="!gu">
            Экономический эффект</button
            ><br />
            <button type="button" class="btn btn-info" @click="pushBtn2" :disabled="!dose">
            Коррозия
            </button>
            <br>
            <div class="media">
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
</div>
</template>

<script>
import Calendar from "v-calendar/lib/components/calendar.umd";
import DatePicker from "v-calendar/lib/components/date-picker.umd";
import VModal from "vue-js-modal";
import VueTableDynamic from 'vue-table-dynamic';

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
	  params: {
		data: [],
		enableSearch: false,
		header: "row",
		border: true,
		stripe: true,
		pageSize: 10,
		height: 430,
		wordWrap: "break-word"
	  },
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
			  this.kormass = data.kormass,
			  this.pipe = data.pipe,
			  this.pipeab = data.pipeab,
			  this.lastCorrosion = data.lastCorrosion,
			  this.constantsValues = data.constantsValues;
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
		this.signalizator = null,
		this.signalizatorAbs = null,
		this.corrosionRateInMm = null,
		this.doseMgPerL = null,
		this.corrosionRateInMmAB = null,
		this.doseMgPerLAB = null,
		this.corrosionVelocityWithInhibitor = null,
		this.dose = 0,
		this.$emit("chart5", this.dose);
	  this.axios
		.post("/ru/getgudatabyday", {
		  gu_id: this.gu,
		  dt: day.id,
		})
		.then((response) => {
		  let data = response.data;
		  if (data) {
			  this.ngdu = data.ngdu,
			  this.uhe = data.uhe,
			  this.plan_dosage = response.data.ca.plan_dosage,
			  this.current_dosage = response.data.uhe.current_dosage,
			  this.pressure = response.data.ngdu.pressure,
			  this.temperature = response.data.ngdu.temperature,
			  this.pump_discharge_pressure = response.data.ngdu.pump_discharge_pressure,
			  this.surge_tank_pressure = response.data.ngdu.surge_tank_pressure,
			  this.heater_inlet_pressure = response.data.ngdu.heater_inlet_pressure,
			  this.heater_output_pressure = response.data.ngdu.heater_output_pressure,
			  this.daily_fluid_production = response.data.ngdu.daily_fluid_production,
			  this.signalizator = ((response.data.ca.plan_dosage - response.data.uhe.current_dosage) * response.data.ca.plan_dosage) / 100,
			  this.signalizatorAbs = Math.abs(this.signalizator),
			  this.corrosionVelocityWithInhibitor = this.lastCorrosion.corrosion_velocity_with_inhibitor.toFixed(1),
			  this.wmLast = data.wmLast,
			  this.wmLastH2S = data.wmLastH2S,
			  this.wmLastCO2 = data.wmLastCO2,
			  this.wmLastH2O = data.wmLastH2O,
			  this.wmLastHCO3 = data.wmLastHCO3,
			  this.wmLastCl = data.wmLastCl,
			  this.wmLastSO4 = data.wmLastSO4,
			  this.oilGas = data.oilGas;
			  this.calc();
		  } else {
			console.log("No data");
		  }
		});
	},
	calc() {
	  this.axios
		.post("/ru/corrosion", {
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
			this.corA = data.corrosion_rate_mm_per_y_point_A,
			this.corE = data.corrosion_rate_mm_per_y_point_E,
			this.corF = data.corrosion_rate_mm_per_y_point_F,
			this.dose = data.max_dose,
            this.result = data,
            this.daily_fluid_production_kormass = data.t_final_celsius_point_F,
            this.pressure = data.final_pressure_bar_point_F
		    this.$emit("chart5", data.max_dose);
		  } else {
			console.log("No data");
		  }
		});
	},
	pushBtn() {
	  this.axios
		.post("/ru/vcoreconomic", {
		  gu: this.gu,
		})
		.then((response) => {
		  let data = response.data;
		  if (data) {
			console.log(data);
			this.params.data = data;
			this.$modal.show("economicmodal");
		  } else {
			console.log("No data");
		  }
		});
	},
	pushBtn2() {
	  this.$modal.show("corrosion");
	},
  },
  components: { VueTableDynamic }
};
</script>
<style scoped>
.btn {
  display: block !important;
  width: 100% !important;
}

.economicModal {
  background-color: #0f1430;
  border: 1px solid #0d2b4d;
}
.radial {
    max-height: 250px;
    min-height: 250px;
}
.signalizator{
    max-height: 125px;
    min-height: 125px;
}
</style>
