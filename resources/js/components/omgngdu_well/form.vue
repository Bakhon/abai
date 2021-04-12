<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.gu.gu') }}</label>
      <div class="form-label-group">
        <select class="form-control" name="gu_id" v-model="formFields.gu_id" @change="chooseGu()">
          <option v-for="row in gus" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>{{ trans('app.date') }}</label>
      <div class="form-label-group">
        <datetime
            type="date"
            v-model="formFields.date"
            input-class="form-control date"
            value-zone="Asia/Almaty"
            zone="Asia/Almaty"
            :format="{ year: 'numeric', month: 'long', day: 'numeric' }"
            :phrases="{ok: trans('app.choose'), cancel: trans('app.cancel')}"
            :hour-step="1"
            :minute-step="5"
            :week-start="1"
            use24-hour
            auto
        >
        </datetime>
        <input type="hidden" name="date" v-model="formatedDate" class="form-control" placeholder="">

      </div>
      <label>{{ trans('monitoring.omgngdu_well.fields.pressure') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.pressure"
            type="number"
            step="0.0001"
            :min="validationParams.pressure.min"
            :max="validationParams.pressure.max"
            name="pressure"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>{{ trans('monitoring.omgngdu_well.fields.bsw') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.bsw"
            @input="calculateFluidParams"
            type="number"
            step="0.0001"
            :min="validationParams.bsw.min"
            :max="validationParams.bsw.max"
            name="bsw"
            class="form-control"
            placeholder=""
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
        <select class="form-control" name="zu_id" v-model="formFields.zu_id" >
          <option v-for="row in zus" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>{{ trans('monitoring.omgngdu_well.fields.daily_fluid_production') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.daily_fluid_production"
            @input="calculateFluidParams"
            type="number"
            step="0.0001"
            :min="validationParams.daily_fluid_production.min"
            :max="validationParams.daily_fluid_production.max"
            name="daily_fluid_production"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>{{ trans('monitoring.omgngdu_well.fields.daily_oil_production') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.daily_oil_production"
            @input="calculateFluidParams"
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
      <label>{{ trans('monitoring.cdng') }}</label>
      <div class="form-label-group">
        <select class="form-control" name="cdng_id" v-model="formFields.cdng_id" @change="chooseCdng($event)">
          <option v-for="row in cdngs" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>{{ trans('monitoring.well.well') }}</label>
      <div class="form-label-group">
        <select class="form-control" name="well_id" v-model="formFields.well_id">
          <option v-for="row in wells" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>{{ trans('monitoring.omgngdu.fields.gas_factor') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.gas_factor"
            type="number"
            step="0.0001"
            :min="validationParams.gas_factor.min"
            :max="validationParams.gas_factor.max"
            name="gas_factor"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>{{ trans('monitoring.omgngdu_well.fields.daily_water_production') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.daily_water_production"
            @input="calculateFluidParams"
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
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button type="submit" :disabled="!formFields.date" class="btn btn-success" @click.prevent="submitForm">{{ trans('app.save') }}</button>
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
import {Datetime} from 'vue-datetime'
import moment from 'moment'
import 'vue-datetime/dist/vue-datetime.css'
import {complicationMonitoringState, complicationMonitoringActions} from '@store/helpers';

Vue.use(Datetime)

export default {
  name: "omgngdu-form",
  props: {
    omgngduWell: {
      type: Object,
      default: null
    },
    validationParams: {
      type: Object,
      required: true,
    },
    isEditing: {
      type: Boolean,
      default: false
    },
  },
  data: function () {
    return {
      formFields: {
        gu_id: null,
        date: null,
        bsw: null,
        daily_water_production: null,
        ngdu_id: null,
        zu_id: null,
        daily_fluid_production: null,
        temperature: null,
        daily_oil_production: null,
        cdng_id: null,
        well_id: null,
        pressure: null,
        gas_factor: null,
      },
    }
  },
  computed: {
    ...complicationMonitoringState([
      'zus',
      'gus',
      'ngdus',
      'cdngs',
      'wells'
    ]),
    formatedDate() {
      if (this.formFields.date) {
        return moment(this.formFields.date).format('Y-m-d')
      }
      return null
    },
    requestUrl () {
      return this.isEditing ? this.localeUrl("/omgngdu_well/" + this.omgngduWell.id) : this.localeUrl("/omgngdu_well");
    },
    requestMethod () {
      return this.isEditing ? "put" : "post";
    }
  },
  created: function () {
    this.getAllComplicationMonitoringData();
  },
  mounted() {
    if (this.omgngduWell) {
      let daily_water_production = (this.omgngduWell.daily_fluid_production * this.omgngduWell.bsw) / 100;

      this.formFields = this.omgngduWell;
      this.formFields.daily_water_production = daily_water_production;
    }
  },
  methods: {
    ...complicationMonitoringActions([
      'getAllComplicationMonitoringData',
      'getAllNgdus',
      'getAllGus',
      'getAllCdngs',
      'getAllZus',
      'getAllWells',
      'getGuRelations'
    ]),
    calculateFluidParams () {
      if (this.formFields.daily_fluid_production && this.formFields.bsw) {
        this.formFields.daily_water_production = (this.formFields.daily_fluid_production * this.formFields.bsw) / 100;
        this.formFields.daily_oil_production = (this.formFields.daily_fluid_production * (100 - this.formFields.bsw)) / 100;
      }
    },
    async chooseGu() {
      let gu = await this.getGuRelations(this.formFields.gu_id);

      this.formFields.ngdu_id = gu.ngdu_id;
      this.formFields.cdng_id = gu.cdng_id;
    },
    submitForm () {
      this.axios
          [this.requestMethod](this.requestUrl, this.formFields)
          .then((response) => {
            if (response.data.status == 'success') {
              window.location.replace(this.localeUrl("/omgngdu_well"));
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
