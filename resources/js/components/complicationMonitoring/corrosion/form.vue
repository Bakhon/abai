<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.gu.gu') }}</label>
      <div class="form-label-group">
        <select class="form-control" name="gu_id" v-model="formFields.gu_id">
          <option v-for="row in gus" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>{{ trans('monitoring.corrosion.fields.start_date_of_background_corrosion') }}</label>
      <div class="form-label-group">
        <datetime
            type="date"
            v-model="formFields.start_date_of_background_corrosion"
            input-class="date form-control"
            value-zone="Asia/Almaty"
            zone="Asia/Almaty"
            :format="{ year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }"
            :phrases="{ok: trans('app.choose'), cancel: trans('app.cancel')}"
            :hour-step="1"
            :minute-step="5"
            :week-start="1"
            use24-hour
            auto
        >
        </datetime>
        <input type="hidden" name="start_date_of_background_corrosion"
               v-bind:value="formatDate(formFields.start_date_of_background_corrosion)"
               class="form-control" placeholder="">
      </div>
      <label>{{ trans('monitoring.corrosion.fields.start_date_of_corrosion_velocity_with_inhibitor_measure') }}</label>
      <div class="form-label-group">
        <datetime
            type="date"
            v-model="formFields.start_date_of_corrosion_velocity_with_inhibitor_measure"
            input-class="date form-control"
            value-zone="Asia/Almaty"
            zone="Asia/Almaty"
            :format="{ year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }"
            :phrases="{ok: trans('app.choose'), cancel: trans('app.cancel')}"
            :hour-step="1"
            :minute-step="5"
            :week-start="1"
            use24-hour
            auto
        >
        </datetime>
        <input type="hidden" name="start_date_of_corrosion_velocity_with_inhibitor_measure"
               v-bind:value="formatDate(formFields.start_date_of_corrosion_velocity_with_inhibitor_measure)"
               class="form-control" placeholder="">
      </div>
      <label>{{ trans('monitoring.corrosion.fields.sample_number') }}</label>
      <div class="form-label-group">
        <input v-model="formFields.sample_number" type="text" name="sample_number" class="form-control" placeholder="">
      </div>
      <label>{{ trans('monitoring.corrosion.fields.days') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.days"
            type="number"
            step="1"
            :min="validationParams.days.min"
            :max="validationParams.days.max"
            name="days"
            class="form-control"
            placeholder=""
        >
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.ngdu') }}</label>
      <div class="form-label-group">
        <select class="form-control" name="ngdu_id" v-model="formFields.ngdu_id">
          <option v-for="row in ngdus" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>{{ trans('monitoring.corrosion.fields.final_date_of_background_corrosion') }}</label>
      <div class="form-label-group">
        <datetime
            type="date"
            v-model="formFields.final_date_of_background_corrosion"
            input-class="date form-control"
            value-zone="Asia/Almaty"
            zone="Asia/Almaty"
            :format="{ year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }"
            :phrases="{ok: trans('app.choose'), cancel: trans('app.cancel')}"
            :hour-step="1"
            :minute-step="5"
            :week-start="1"
            use24-hour
            auto
        >
        </datetime>
        <input type="hidden" name="final_date_of_background_corrosion"
               v-bind:value="formatDate(formFields.final_date_of_background_corrosion)"
               class="form-control" placeholder="">
      </div>
      <label>{{ trans('monitoring.corrosion.fields.final_date_of_corrosion_velocity_with_inhibitor_measure') }}</label>
      <div class="form-label-group">
        <datetime
            type="date"
            v-model="formFields.final_date_of_corrosion_velocity_with_inhibitor_measure"
            input-class="date form-control"
            value-zone="Asia/Almaty"
            zone="Asia/Almaty"
            :format="{ year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit', timeZoneName: 'short' }"
            :phrases="{ok: trans('app.choose'), cancel: trans('app.cancel')}"
            :hour-step="1"
            :minute-step="5"
            :week-start="1"
            use24-hour
            auto
        >
        </datetime>
        <input type="hidden" name="final_date_of_corrosion_velocity_with_inhibitor_measure"
               v-bind:value="formatDate(formFields.final_date_of_corrosion_velocity_with_inhibitor_measure)"
               class="form-control" placeholder="">
      </div>
      <label>{{ trans('monitoring.corrosion.fields.weight_before') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.weight_before"
            type="number"
            step="0.0001"
            :min="validationParams.weight_before.min"
            :max="validationParams.weight_before.max"
            name="weight_before"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>{{ trans('monitoring.corrosion.fields.avg_speed') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.avg_speed"
            type="number"
            step="0.0001"
            :min="validationParams.avg_speed.min"
            :max="validationParams.avg_speed.max"
            name="avg_speed"
            class="form-control"
            placeholder=""
        >
      </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.cdng') }}</label>
      <div class="form-label-group">
        <select class="form-control" name="cdng_id" v-model="formFields.cdng_id">
          <option v-for="row in cndgs" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>{{ trans('monitoring.corrosion.fields.background_corrosion_velocity') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.background_corrosion_velocity"
            type="number"
            step="0.0001"
            :min="validationParams.background_corrosion_velocity.min"
            :max="validationParams.background_corrosion_velocity.max"
            name="background_corrosion_velocity"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>{{ trans('monitoring.corrosion.fields.corrosion_velocity_with_inhibitor') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.corrosion_velocity_with_inhibitor"
            type="number"
            step="0.0001"
            :min="validationParams.corrosion_velocity_with_inhibitor.min"
            :max="validationParams.corrosion_velocity_with_inhibitor.max"
            name="corrosion_velocity_with_inhibitor"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>{{ trans('monitoring.corrosion.fields.weight_after') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.weight_after"
            type="number"
            step="0.0001"
            :min="validationParams.weight_after.min"
            :max="validationParams.weight_after.max"
            name="weight_after"
            class="form-control"
            placeholder=""
        >
      </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button type="submit" :disabled="!formFields.start_date_of_background_corrosion" class="btn btn-success">
        {{ trans('app.save') }}
      </button>
    </div>
  </div>
</template>

<script>
import 'vue-datetime/dist/vue-datetime.css';
import moment from "moment"

export default {
  name: "corrosion-form",
  props: [
    'corrosion',
    'validationParams'
  ],
  data: function () {
    return {
      ngdus: {},
      cndgs: {},
      gus: {},
      formFields: {
        gu_id: null,
        start_date_of_background_corrosion: null,
        start_date_of_corrosion_velocity_with_inhibitor_measure: null,
        ngdu_id: null,
        final_date_of_background_corrosion: null,
        final_date_of_corrosion_velocity_with_inhibitor_measure: null,
        cdng_id: null,
        background_corrosion_velocity: null,
        corrosion_velocity_with_inhibitor: null,
        sample_number: null,
        weight_before: null,
        days: null,
        weight_after: null,
        avg_speed: null,
      }
    }
  },
  beforeCreate: function () {

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
  },
  mounted() {

    if (this.corrosion) {
      this.formFields = {
        gu_id: this.corrosion.gu_id,
        start_date_of_background_corrosion: this.corrosion.start_date_of_background_corrosion,
        start_date_of_corrosion_velocity_with_inhibitor_measure: this.corrosion.start_date_of_corrosion_velocity_with_inhibitor_measure,
        ngdu_id: this.corrosion.ngdu_id,
        final_date_of_background_corrosion: this.corrosion.final_date_of_background_corrosion,
        final_date_of_corrosion_velocity_with_inhibitor_measure: this.corrosion.final_date_of_corrosion_velocity_with_inhibitor_measure,
        cdng_id: this.corrosion.cdng_id,
        background_corrosion_velocity: this.corrosion.background_corrosion_velocity,
        corrosion_velocity_with_inhibitor: this.corrosion.corrosion_velocity_with_inhibitor,
        sample_number: this.corrosion.sample_number,
        weight_before: this.corrosion.weight_before,
        days: this.corrosion.days,
        weight_after: this.corrosion.weight_after,
        avg_speed: this.corrosion.avg_speed,
      }
    }

  },
  methods: {
    formatDate(date) {
      if (date) {
        return moment(date).format('YYYY-MM-DD')
      }
      return null
    }
  },
};
</script>
<style scoped>
.form-label-group {
  padding-bottom: 30px;
}
</style>
