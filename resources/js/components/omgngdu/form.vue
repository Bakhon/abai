<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>Месторождение</label>
      <div class="form-label-group">
        <select class="form-control" name="field_id" v-model="formFields.field_id">
          <option v-for="row in fields" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>ГУ</label>
      <div class="form-label-group">
        <select class="form-control" name="gu_id" v-model="formFields.gu_id" @change="chooseGu()">
          <option v-for="row in gus" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>Дата и время</label>
      <div class="form-label-group">
        <datetime
            type="date"
            v-model="formFields.date"
            input-class="form-control date"
            value-zone="Asia/Almaty"
            zone="Asia/Almaty"
            :format="{ year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }"
            :phrases="{ok: 'Выбрать', cancel: 'Выход'}"
            :hour-step="1"
            :minute-step="5"
            :week-start="1"
            use24-hour
            auto
        >
        </datetime>
        <input type="hidden" name="date" v-model="formatedDate" class="form-control" placeholder="">

      </div>
      <label>Давление на выходе насоса в ГУ, бар</label>
      <div class="form-label-group">
        <input
            v-model="formFields.pump_discharge_pressure"
            type="number"
            step="0.0001"
            :min="validationParams.pump_discharge_pressure.min"
            :max="validationParams.pump_discharge_pressure.max"
            name="pump_discharge_pressure"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Обводненность в ГУ, %</label>
      <div class="form-label-group">
        <input
            v-model="formFields.bsw"
            type="number"
            step="0.0001"
            :min="validationParams.bsw.min"
            :max="validationParams.bsw.max"
            name="bsw"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Суточная добыча воды, м3/сут</label>
      <div class="form-label-group">
        <input
            v-model="formFields.daily_water_production"
            type="number"
            step="0.0001"
            :min="validationParams.daily_water_production.min"
            :max="validationParams.daily_water_production.max"
            name="daily_water_production"
            class="form-control"
            placeholder=""
        >
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>НГДУ</label>
      <div class="form-label-group">
        <select class="form-control" name="ngdu_id" v-model="formFields.ngdu_id" @change="chooseNgdu($event)">
          <option v-for="row in ngdus" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>ЗУ</label>
      <div class="form-label-group">
        <select class="form-control" name="zu_id" v-model="formFields.zu_id" @change="chooseZu()">
          <option v-for="row in zus" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>Суточная добыча жидкости в ГУ, м3/сут</label>
      <div class="form-label-group">
        <input
            v-model="formFields.daily_fluid_production"
            type="number"
            step="0.0001"
            :min="validationParams.daily_fluid_production.min"
            :max="validationParams.daily_fluid_production.max"
            name="daily_fluid_production"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Температура на входе в печь в ГУ, С</label>
      <div class="form-label-group">
        <input
            v-model="formFields.heater_inlet_pressure"
            type="number"
            step="0.0001"
            :min="validationParams.heater_inlet_pressure.min"
            :max="validationParams.heater_inlet_pressure.max"
            name="heater_inlet_pressure"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Суточная добыча нефти, т/сут</label>
      <div class="form-label-group">
        <input
            v-model="formFields.daily_oil_production"
            type="number"
            step="0.0001"
            :min="validationParams.daily_oil_production.min"
            :max="validationParams.daily_oil_production.max"
            name="daily_oil_production"
            class="form-control"
            placeholder=""
        >
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>ЦДНГ</label>
      <div class="form-label-group">
        <select class="form-control" name="cdng_id" v-model="formFields.cdng_id" @change="chooseCdng($event)">
          <option v-for="row in cndgs" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>Скважина</label>
      <div class="form-label-group">
        <select class="form-control" name="well_id" v-model="formFields.well_id">
          <option v-for="row in wells" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>Давление в буферной емкости в ГУ, бар</label>
      <div class="form-label-group">
        <input
            v-model="formFields.surge_tank_pressure"
            type="number"
            step="0.0001"
            :min="validationParams.surge_tank_pressure.min"
            :max="validationParams.surge_tank_pressure.max"
            name="surge_tank_pressure"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Количество газа в СИБ, ст.м3/сут</label>
      <div class="form-label-group">
        <input
            v-model="formFields.daily_gas_production_in_sib"
            type="number"
            step="0.0001"
            :min="validationParams.daily_gas_production_in_sib.min"
            :max="validationParams.daily_gas_production_in_sib.max"
            name="daily_gas_production_in_sib"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>Температура на выходе из печи в ГУ, С</label>
      <div class="form-label-group">
        <input
            v-model="formFields.heater_output_pressure"
            type="number"
            step="0.0001"
            :min="validationParams.heater_output_pressure.min"
            :max="validationParams.heater_output_pressure.max"
            name="heater_output_pressure"
            class="form-control"
            placeholder=""
        >
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button type="submit" :disabled="!formFields.date" class="btn btn-success">Сохранить</button>
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
import {Datetime} from 'vue-datetime'
import moment from 'moment'
// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css'
import {Settings} from 'luxon'

Settings.defaultLocale = 'ru'

Vue.use(Datetime)

export default {
  name: "omgngdu-form",
  props: [
    'omgngdu',
    'validationParams'
  ],
  data: function () {
    return {
      formFields: {
        field_id: null,
        gu_id: null,
        date: null,
        pump_discharge_pressure: null,
        bsw: null,
        daily_water_production: null,
        ngdu_id: null,
        zu_id: null,
        daily_fluid_production: null,
        heater_inlet_pressure: null,
        daily_oil_production: null,
        cdng_id: null,
        well_id: null,
        surge_tank_pressure: null,
        daily_gas_production_in_sib: null,
        heater_output_pressure: null,
      },
      ngdus: {},
      cndgs: {},
      gus: {},
      zus: {},
      wells: {},
      fields: {},
      kormass: null,
      kormass_id: null,
      field: null,
    }
  },
  computed: {
    formatedDate() {
      if (this.formFields.date) {
        return moment(this.formFields.date).format('YYYY-MM-DD HH:mm')
      }
      return null
    }
  },
  beforeCreate: function () {

    this.axios.get("/ru/getfields").then((response) => {
      let data = response.data;
      if (data) {
        this.fields = data.data;
      } else {
        console.log('No data');
      }
    });

    this.axios.get("/ru/getngdu").then((response) => {
      let data = response.data;
      if (data) {
        this.ngdus = data.data;
      } else {
        console.log('No data');
      }
    });

    this.axios.get("/ru/getcdng").then((response) => {
      let data = response.data;
      if (data) {
        this.cndgs = data.data;
      } else {
        console.log('No data');
      }
    });

    this.axios.get("/ru/getallgus").then((response) => {
      let data = response.data;
      if (data) {
        this.gus = data.data;
      } else {
        console.log('No data');
      }
    });

    this.axios.get("/ru/getallkormasses").then((response) => {
      let data = response.data;
      if (data) {
        this.kormass = data.data;
      } else {
        console.log('No data');
      }
    });

  },
  mounted() {
    if (this.omgngdu) {
      this.formFields = {
        field_id: this.omgngdu.field_id,
        gu_id: this.omgngdu.gu_id,
        date: this.omgngdu.date,
        pump_discharge_pressure: this.omgngdu.pump_discharge_pressure,
        bsw: this.omgngdu.bsw,
        daily_water_production: this.omgngdu.daily_water_production,
        ngdu_id: this.omgngdu.ngdu_id,
        zu_id: this.omgngdu.zu_id,
        daily_fluid_production: this.omgngdu.daily_fluid_production,
        heater_inlet_pressure: this.omgngdu.heater_inlet_pressure,
        daily_oil_production: this.omgngdu.daily_oil_production,
        cdng_id: this.omgngdu.cdng_id,
        well_id: this.omgngdu.well_id,
        surge_tank_pressure: this.omgngdu.surge_tank_pressure,
        daily_gas_production_in_sib: this.omgngdu.daily_gas_production_in_sib,
        heater_output_pressure: this.omgngdu.heater_output_pressure,
      }
      if (this.omgngdu.gu_id) {
        this.chooseGu(true)
      }
      if (this.omgngdu.zu_id) {
        this.chooseZu()
      }
    }
  },
  methods: {
    chooseNgdu(event) {
      this.axios.get("/ru/getcdng", {
        ngdu_id: event.target.value,
      }).then((response) => {
        let data = response.data;
        if (data) {
          this.cndgs = data.data;
        } else {
          console.log('No data');
        }
      });
    },
    chooseCdng(event) {
      this.axios.post("/ru/getgu", {
        cdng_id: event.target.value,
      }).then((response) => {
        let data = response.data;
        if (data) {
          this.gus = data.data;
        } else {
          console.log('No data');
        }
      });
    },
    chooseGu(init = false) {
      if (!init) {
        this.formFields.well_id = null
      }
      this.axios.post("/ru/getzu", {
        gu_id: this.formFields.gu_id,
      }).then((response) => {
        let data = response.data;
        if (data) {
          this.zus = data.data;
        } else {
          console.log('No data');
        }
      });
    },
    chooseZu() {
      this.axios.post("/ru/getwell", {
        zu_id: this.formFields.zu_id,
      }).then((response) => {
        let data = response.data;
        if (data) {
          this.wells = data.data;
        } else {
          console.log('No data');
        }
      });
    }
  },
};
</script>
<style scoped>
.form-label-group {
  padding-bottom: 30px;
}
</style>
