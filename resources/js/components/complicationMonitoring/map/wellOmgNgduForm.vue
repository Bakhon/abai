<template>
  <b-row>
    <b-col cols="4" class="mt-10px" v-for="(field, index) in formFields" :key="index">
      <label>{{ field.label }}</label>
      <div class="form-label-group">
        <b-form-input
            type="text"
            v-if="field.type == 'text'"
            v-model="formFields[index].value"
            :name="field.name"
            placeholder=""
        />

        <b-form-checkbox
            v-if="field.type == 'boolean'"
            v-model="formFields[index].value"
            :name="field.name"
            :value="1"
            :unchecked-value="0"
        />

        <template v-if="field.type == 'date'">
          <datetime
              v-model="formFields[index].value"
              type="date"
              input-class="form-control date"
              :format="field.format"
              :phrases="{ok: trans('app.choose'), cancel: trans('app.cancel')}"
              :hour-step="1"
              :minute-step="5"
              :week-start="1"
              use24-hour
              auto
          >
          </datetime>
          <input type="hidden" :name="field.name" :value="formatedDate(formFields[index].value)" />
        </template>

        <input
            v-if="field.type == 'number'"
            type="number"
            :step="field.step"
            :min="validationParamMin(field.name)"
            :max="validationParamMax(field.name)"
            :name="field.name"
            v-model="formFields[index].value"
            class="form-control"
            placeholder=""
        >

        <select
            v-if="field.type == 'select'"
            class="form-control"
            :name="field.name"
            v-model="formFields[index].value" >
          <option v-for="row in selectOptions(field.name)" :value="row.name">{{ row.name }}</option>
        </select>

      </div>
    </b-col>
  </b-row>
</template>

<script>
import moment from "moment";
import Vue from "vue";
import {Datetime} from "vue-datetime";
import 'vue-datetime/dist/vue-datetime.css'

export default {
  name: "wellOmgNgduForm",
  props: {},
  data: function () {
    return {
      formFields: [
        {
          name: 'field',
          type: 'text',
          label: this.trans('monitoring.pipe_passport.field'),
          value: null
        },
        {
          name: 'date',
          type: 'date',
          label: this.trans('app.date'),
          format: {year: 'numeric', month: 'long', day: 'numeric'},
          value: null
        },
        {
          name: 'pressure',
          type: 'number',
          step: 0.01,
          label: this.trans('monitoring.pipe_passport.main_reserved'),
          value: null
        },
        {
          name: 'daily_fluid_production',
          type: 'number',
          step: 0.01,
          label: this.trans('monitoring.omgngdu_well.fields.daily_fluid_production'),
          value: null
        },
        {
          name: 'to',
          type: 'text',
          label: this.trans('monitoring.pipe_passport.to'),
          value: null
        },
        {
          name: 'length',
          type: 'text',
          label: this.trans('monitoring.pipe.fields.length'),
          value: null
        },
        {
          name: 'diameter',
          type: 'text',
          label: this.trans('monitoring.pipe_passport.diameter'),
          value: null
        },
        {
          name: 'thickness',
          type: 'text',
          label: this.trans('monitoring.pipe.fields.thickness'),
          value: null
        },
        {
          name: 'material',
          type: 'text',
          label: this.trans('monitoring.pipe.fields.material'),
          value: null
        },
        {
          name: 'condition',
          type: 'text',
          label: this.trans('monitoring.pipe_passport.condition'),
          value: null
        },
        {
          name: 'gusts',
          type: 'number',
          label: this.trans('monitoring.pipe_passport.gusts'),
          value: null
        },
        {
          name: 'data_sheet',
          type: 'boolean',
          label: this.trans('monitoring.pipe_passport.data_sheet'),
          value: null
        },
        {
          name: 'used',
          type: 'boolean',
          label: this.trans('monitoring.pipe_passport.used'),
          value: null
        },
        {
          name: 'comment',
          type: 'text',
          label: this.trans('monitoring.pipe_passport.comment'),
          value: null
        },
      ],
      ngdu: [],
      cdng: []
    }
  },
}
</script>

<style scoped>

</style>