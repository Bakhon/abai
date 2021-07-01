<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row mb-5">
    <div class="col-xs-12 col-sm-4 col-md-4 mt-10px" v-for="(field, index) in formFields" :key="index">
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
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
      <button type="submit" class="btn btn-success">{{ trans('app.save') }}</button>
    </div>
  </div>
</template>

<script>

import moment from "moment";
import Vue from "vue";
import {Datetime} from "vue-datetime";
import 'vue-datetime/dist/vue-datetime.css'

Vue.use(Datetime)

export default {
  name: "pipe-passport-form",
  props: {
    pipe: Object,
    validationParams: Array
  },
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
          name: 'installation_date',
          type: 'date',
          label: this.trans('monitoring.pipe_passport.installation_date'),
          format: {year: 'numeric', month: 'long', day: 'numeric'},
          value: null
        },
        {
          name: 'ngdu',
          type: 'select',
          label: this.trans('monitoring.ngdu'),
          value: null
        },
        {
          name: 'cdng',
          type: 'select',
          label: this.trans('monitoring.cdng'),
          value: null
        },
        {
          name: 'gu',
          type: 'text',
          label: this.trans('monitoring.gu.gu'),
          value: null
        },
        {
          name: 'name',
          type: 'text',
          label: this.trans('monitoring.pipe_passport.name'),
          value: null
        },
        {
          name: 'main_reserved',
          type: 'text',
          label: this.trans('monitoring.pipe_passport.main_reserved'),
          value: null
        },
        {
          name: 'from',
          type: 'text',
          label: this.trans('monitoring.pipe_passport.from'),
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
  beforeCreate: function () {

    this.axios.get(this.localeUrl("/getngdu")).then((response) => {
      let data = response.data;
      if (data) {
        this.ngdu = data.data;
      } else {
        console.log('No data');
      }
    });

    this.axios.get(this.localeUrl("/getcdng")).then((response) => {
      let data = response.data;
      if (data) {
        this.cdng = data.data;
      } else {
        console.log('No data');
      }
    });

  },
  mounted() {
    if (this.pipe) {
      for (let [key, value] of Object.entries(this.pipe)) {

        let formFieldsIndex = this.formFields.findIndex(field => field.name == key);

        if (formFieldsIndex !== -1) {
          if (key == 'installation_date') {
            this.formFields[formFieldsIndex].value = this.formatedDate(value);
          } else {
            this.formFields[formFieldsIndex].value = value;
          }
        }

      }
    }
  },
  methods: {
    validationParamMax (field) {
      return typeof this.validationParams[field] == 'undefined' ? null : this.validationParams[field].max;
    },
    validationParamMin (field) {
      return typeof this.validationParams[field] == 'undefined' ? null : this.validationParams[field].min;
    },
    formatedDate(date) {
      if (date) {
        return moment.parseZone(date).format('YYYY-MM-DD')
      }
      return null
    },
    selectOptions(field) {
      return this[field];
    },
  }
}
</script>

<style scoped>

</style>