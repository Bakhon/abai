<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
    <div class="col-xs-12 col-sm-4 col-md-4">
      <label>{{ trans('monitoring.gu.gu') }}</label>
      <div class="form-label-group">
        <select class="form-control" name="gu_id" v-model="formFields.gu_id">
          <option v-for="row in gus" v-bind:value="row.id">{{ row.name }}</option>
        </select>
      </div>
      <label>{{ trans('monitoring.buffer_tank.model') }}</label>
      <div class="form-label-group">
        <input v-model="formFields.model" type="text" name="model" class="form-control" placeholder="">
      </div>
      <label>{{ trans('monitoring.agzu.method_of_measurement') }}</label>
      <div class="form-label-group">
        <input v-model="formFields.method_of_measurement" type="text" name="method_of_measurement" class="form-control" placeholder="">
      </div>
      <label>{{ trans('monitoring.agzu.number_of_connected_wells') }}</label>
      <div class="form-label-group">
        <input
            v-model="formFields.number_of_connected_wells"
            type="number"
            step="1"
            :min="validationParams.number_of_connected_wells"
            :max="validationParams.number_of_connected_wells"
            name="number_of_connected_wells"
            class="form-control"
            placeholder=""
        >
      </div>
      <label>{{ trans('monitoring.buffer_tank.date_of_exploitation') }}</label>
      <div class="form-label-group">
        <datetime
            type="date"
            v-model="formFields.date_of_exploitation"
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
        <input type="hidden" name="date_of_exploitation"
               v-bind:value="formatDate(formFields.date_of_exploitation)"
               class="form-control" placeholder="">
      </div>
      <label>{{ trans('monitoring.buffer_tank.current_state') }}</label>
      <div class="form-label-group">
        <input v-model="formFields.current_state" type="text" name="current_state" class="form-control" placeholder="">
      </div>
      <label>{{ trans('monitoring.buffer_tank.date_of_repair') }}</label>
      <div class="form-label-group">
        <datetime
            type="date"
            v-model="formFields.date_of_repair"
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
        <input type="hidden" name="date_of_repair"
               v-bind:value="formatDate(formFields.date_of_repair)"
               class="form-control" placeholder="">
      </div>
      <label>{{ trans('monitoring.buffer_tank.type_of_repair') }}</label>
      <div class="form-label-group">
        <input v-model="formFields.type_of_repair" type="text" name="type_of_repair" class="form-control" placeholder="">
      </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button type="submit" :disabled="!formFields.model" class="btn btn-success">
        {{ trans('app.save') }}
      </button>
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
import {Datetime} from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
import moment from "moment"

Vue.use(Datetime)

export default {
  name: "agzu-form",
  props: [
    'agzu',
    'validationParams'
  ],
  data: function () {
    return {
      gus: {},
      formFields: {
        gu_id: null,
        model: null,
        method_of_measurement: null,
        number_of_connected_wells: null,
        date_of_exploitation: null,
        current_state: null,
        date_of_repair: null,
        type_of_repair: null,
      }
    }
  },
  beforeCreate: function () {

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

    if (this.agzu) {
      this.formFields = {
        gu_id: this.agzu.gu_id,
        model: this.agzu.model,
        method_of_measurement: this.agzu.method_of_measurement,
        number_of_connected_wells: this.agzu.number_of_connected_wells,
        date_of_exploitation: this.agzu.date_of_exploitation,
        current_state: this.agzu.current_state,
        date_of_repair: this.agzu.date_of_repair,
        type_of_repair: this.agzu.type_of_repair,
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
