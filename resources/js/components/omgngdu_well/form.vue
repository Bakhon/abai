<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
    <cat-loader v-show="loading"/>
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.gu.gu') }}</label>
      <div class="form-label-group">
        <select class="form-control" name="gu_id" v-model="formFields.gu_id" @change="chooseGu">
          <option v-for="gu in gus" v-bind:value="gu.id">{{ gu.name }}</option>
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
      <label>{{ trans('monitoring.omgngdu_well.fields.temperature') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.temperature"
            type="number"
            step="0.0001"
            :min="validationParams.temperature.min"
            :max="validationParams.temperature.max"
            name="temperature"
            class="form-control"
            placeholder=""
        >
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.ngdu') }}</label>
      <div class="form-label-group">
        <select class="form-control" name="ngdu_id" v-model="formFields.ngdu_id" @change="chooseNgdu($event)">
          <option v-for="ngdu in ngdus" v-bind:value="ngdu.id">{{ ngdu.name }}</option>
        </select>
      </div>
      <label>ЗУ</label>
      <div class="form-label-group">
        <select class="form-control" name="zu_id" v-model="formFields.zu_id" @change="chooseZu">
          <option v-for="zu in zus" v-bind:value="zu.id">{{ zu.name }}</option>
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
          <option v-for="cdng in cdngs" v-bind:value="cdng.id">{{ cdng.name }}</option>
        </select>
      </div>
      <label>{{ trans('monitoring.well.well') }}</label>
      <div class="form-label-group">
        <select class="form-control" name="well_id" v-model="formFields.well_id">
          <option v-for="well in wells" v-bind:value="well.id">{{ well.name }}</option>
        </select>
      </div>
      <label>{{ trans('monitoring.omgngdu_well.fields.gas_factor') }}</label>
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
import CatLoader from '../ui-kit/CatLoader'

Vue.use(Datetime)

const averageOilDensity = 853;

export default {
  name: "omgngdu-well-form",
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
  components: {
    CatLoader
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
      loading: false,
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
        return moment.parseZone(this.formFields.date).format('Y-m-d')
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
  mounted() {
    this.$nextTick(async () => {
      this.loading = true;
      await this.getAllComplicationMonitoringObjectsData();

      if (this.omgngduWell) {
        this.formFields = {
          gu_id: this.omgngduWell.zu.gu_id,
          date: this.omgngduWell.date,
          bsw: this.omgngduWell.bsw,
          daily_water_production: this.omgngduWell.daily_water_production,
          ngdu_id: this.omgngduWell.zu.ngdu_id,
          zu_id: this.omgngduWell.zu_id,
          daily_fluid_production: this.omgngduWell.daily_fluid_production,
          temperature: this.omgngduWell.temperature,
          daily_oil_production: this.omgngduWell.daily_oil_production,
          cdng_id: this.omgngduWell.zu.gu.cdng_id,
          well_id: this.omgngduWell.well_id,
          pressure: this.omgngduWell.pressure,
          gas_factor: this.omgngduWell.gas_factor,
        }

        this.chooseZu();
      }
      this.loading = false;
    });

  },
  methods: {
    ...complicationMonitoringActions([
      'getAllComplicationMonitoringObjectsData',
      'getAllNgdus',
      'getAllGus',
      'getAllCdngs',
      'getAllZus',
      'getAllWells',
      'getGuRelations',
      'getZuRelations',
      'getNgduRelations',
      'getCdngRelations'
    ]),
    calculateFluidParams () {
      if (this.formFields.daily_fluid_production && this.formFields.bsw) {
        this.formFields.daily_water_production = (this.formFields.daily_fluid_production * this.formFields.bsw) / 100;
        this.formFields.daily_oil_production = ((this.formFields.daily_fluid_production * (100 - this.formFields.bsw)) / 100) * averageOilDensity / 1000;
      }
    },
    async chooseGu() {
      this.loading = true;
      let gu = await this.getGuRelations(this.formFields.gu_id);
      this.loading = false;

      this.formFields.ngdu_id = gu.ngdu_id;
      this.formFields.cdng_id = gu.cdng_id;
    },
    async chooseZu() {
      this.loading = true;
      let zu = await this.getZuRelations(this.formFields.zu_id);
      this.loading = false;

      this.formFields.gu_id = zu.gu_id;
      this.formFields.ngdu_id = zu.ngdu_id;
      this.formFields.cdng_id = zu.gu.cdng_id;
    },
    async chooseNgdu () {
      this.loading = true;
      await this.getNgduRelations(this.formFields.ngdu_id);
      this.loading = false;
      this.formFields.gu_id = null;
    },
    async chooseCdng () {
      this.loading = true;
      let cdng = await this.getCdngRelations(this.formFields.cdng_id);
      this.loading = false;
      this.formFields.ngdu_id = cdng.ngdu_id;
      this.formFields.gu_id = null;
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
