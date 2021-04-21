<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.field') }}</label>
      <div class="form-label-group">
        <select class="form-control" name="field_id" v-model="formFields.field_id">
          <option v-for="row in fields" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>{{ trans('monitoring.gu.gu') }}</label>
      <div class="form-label-group">
        <select class="form-control" name="gu_id" v-model="formFields.gu_id" @change="chooseGu()">
          <option v-for="row in gus" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>{{ trans('app.date_time') }}</label>
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
            :disabled="!formFields.editable"
        >
        </datetime>
        <input type="hidden" name="date" v-model="formatedDate" class="form-control" placeholder="">

      </div>
      <label>{{ trans('monitoring.omgngdu.fields.pump_discharge_pressure') }}</label>
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
            :disabled="!formFields.editable"
        >
      </div>
      <label>{{ trans('monitoring.omgngdu.fields.bsw') }}</label>
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
            :disabled="!formFields.editable"
        >
      </div>
      <label>{{ trans('monitoring.omgngdu.fields.daily_water_production') }}</label>
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
            :disabled="!formFields.editable"
        >
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.ngdu') }}</label>
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
      <label>{{ trans('monitoring.omgngdu.fields.daily_fluid_production') }}</label>
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
            :disabled="!formFields.editable"
        >
      </div>
      <label>{{ trans('monitoring.omgngdu.fields.heater_inlet_temperature') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.heater_inlet_temperature"
            type="number"
            step="0.0001"
            :min="validationParams.heater_inlet_temperature.min"
            :max="validationParams.heater_inlet_temperature.max"
            name="heater_inlet_temperature"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>{{ trans('monitoring.omgngdu.fields.daily_oil_production') }}</label>
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
            :disabled="!formFields.editable"
        >
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.cdng') }}</label>
      <div class="form-label-group">
        <select class="form-control" name="cdng_id" v-model="formFields.cdng_id" @change="chooseCdng($event)">
          <option v-for="row in cndgs" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>{{ trans('monitoring.well.well') }}</label>
      <div class="form-label-group">
        <select class="form-control" name="well_id" v-model="formFields.well_id">
          <option v-for="row in wells" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>{{ trans('monitoring.omgngdu.fields.surge_tank_pressure') }}</label>
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
      <label>{{ trans('monitoring.omgngdu.fields.daily_gas_production_in_sib') }}</label>
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
            :disabled="!formFields.editable"
        >
      </div>
      <label>{{ trans('monitoring.omgngdu.fields.heater_output_temperature') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.heater_output_temperature"
            type="number"
            step="0.0001"
            :min="validationParams.heater_output_temperature.min"
            :max="validationParams.heater_output_temperature.max"
            name="heater_output_temperature"
            class="form-control"
            placeholder=""
        >
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button type="submit" :disabled="!formFields.date" class="btn btn-success">{{ trans('app.save') }}</button>
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
import {Datetime} from 'vue-datetime'
import moment from 'moment'
import 'vue-datetime/dist/vue-datetime.css'

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
        heater_inlet_temperature: null,
        daily_oil_production: null,
        cdng_id: null,
        well_id: null,
        surge_tank_pressure: null,
        daily_gas_production_in_sib: null,
        heater_output_temperature: null,
        editable: 1,
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

    this.axios.get(this.localeUrl("/getfields")).then((response) => {
      let data = response.data;
      if (data) {
        this.fields = data.data;
      } else {
        console.log('No data');
      }
    });

    this.axios.get(this.localeUrl("/getngdu")).then((response) => {
      let data = response.data;
      if (data) {
        this.ngdus = data.data;
      } else {
        console.log('No data');
      }
    });

    this.axios.get(this.localeUrl("/getcdng")).then((response) => {
      let data = response.data;
      if (data) {
        this.cndgs = data.data;
      } else {
        console.log('No data');
      }
    });

    this.axios.get(this.localeUrl("/getallgus")).then((response) => {
      let data = response.data;
      if (data) {
        this.gus = data.data;
      } else {
        console.log('No data');
      }
    });

    this.axios.get(this.localeUrl("/getallkormasses")).then((response) => {
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
      let daily_water_production = (this.omgngdu.daily_fluid_production * this.omgngdu.bsw)/100;

      this.formFields = this.omgngdu;
      this.formFields.daily_water_production = daily_water_production;

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
      this.axios.get(this.localeUrl("/getcdng"), {
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
      this.axios.post(this.localeUrl("/getgu"), {
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
      this.axios.post(this.localeUrl("/getzu"), {
        gu_id: this.formFields.gu_id,
      }).then((response) => {
        let data = response.data;
        if (data) {
          this.zus = data.data;
        } else {
          console.log('No data');
        }
      });

      this.axios
          .post(this.localeUrl("/get-gu-cdng-ngdu-field"), {
            gu_id: this.formFields.gu_id,
          })
          .then((response) => {
            let data = response.data;
            if (data) {
              this.formFields.cdng_id = data.cdng;
              this.formFields.ngdu_id = data.ngdu;
            } else {
              console.log("No data");
            }
          });
    },
    chooseZu() {
      this.axios.post(this.localeUrl("/getwell"), {
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
