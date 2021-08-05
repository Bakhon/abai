<template>
  <b-row class="mb-5">
    <b-col cols="4" lg="3" class="mt-10px" v-for="(field, param) in formFields" :key="param">
      <label>{{ trans(field.label) }}</label>
      <div class="form-label-group">
        <b-form-input
            type="text"
            v-if="field.type == 'text'"
            v-model="formFields[param].value"
            :name="field.name"
            placeholder=""
        />

        <b-form-checkbox
            v-if="field.type == 'boolean'"
            v-model="formFields[param].value"
            :name="param"
            :value="1"
            :unchecked-value="0"
        />

        <template v-if="field.type == 'date'">
          <datetime
              v-model="date"
              type="date"
              input-class="form-control date"
              :format="field.format"
              :phrases="{ok: trans('app.choose'), cancel: trans('app.cancel')}"
              :hour-step="1"
              :minute-step="5"
              :week-start="1"
              use24-hour
              auto
              @input="onDateInput(field, param)"
          >
          </datetime>
          <input type="hidden" :name="param" :value="formFields[param].value" />
        </template>

        <input
            v-if="field.type == 'number'"
            type="number"
            :step="field.step"
            :min="validationParamMin(field.name)"
            :max="validationParamMax(field.name)"
            :name="param"
            v-model="formFields[param].value"
            class="form-control"
            placeholder=""
            @input="_.isUndefined(field.input) ? null : $emit(field.input);"
            :readonly="!_.isUndefined(field.readonly) && field.readonly"
        >

        <select
            v-if="field.type == 'select'"
            class="form-control"
            :name="param"
            v-model="formFields[param].value" >
          <option v-for="option in selectOptions(param)" :value="option.name">{{ option.name }}</option>
        </select>

        <b-form-invalid-feedback
            v-if="!_.isUndefined(field.required) && field.required"
            id="input-live-feedback"
            :state="!($v.formFields[param].$dirty && $v.formFields[param].$invalid)">
          {{ trans('validation.required', {attribute: trans(field.label)}) }}
        </b-form-invalid-feedback>
      </div>
    </b-col>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
      <button type="submit" class="btn btn-success" @click="submit">{{ trans('app.save') }}</button>
    </div>
  </b-row>
</template>

<script>

import moment from "moment";
import Vue from "vue";
import {Datetime} from "vue-datetime";
import 'vue-datetime/dist/vue-datetime.css'
import {required} from "vuelidate/lib/validators";

Vue.use(Datetime)

export default {
  name: "EditForm",
  props: {
    formObject: Object,
    validationParams: Object,
    formFields: Object
  },
  data: function () {
    return {
      date: null
    }
  },
  computed: {
    _() {
      return _;
    },
    test() {
      return this.$v;
    }
  },
  methods: {
    validationParamMax (field) {
      return _.isUndefined(this.validationParams[field]) ? null : this.validationParams[field].max;
    },
    validationParamMin (field) {
      return _.isUndefined(this.validationParams[field]) ? null : this.validationParams[field].min;
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
    onDateInput(field, param) {
      this.formFields[param].value = this.formatedDate(this.date);
      this.$emit(field.input);
    },
    submit () {
      this.$v.$touch();

      if (!this.$v.$invalid) {
        this.$emit('submit');
      }
    }
  },
  validations() {
    let validationParams = {
      formFields: {}
    };

    for (let field in this.formFields) {
      console.log('field', field);
      console.log('this.formFields[field]', this.formFields[field]);
      if (!_.isUndefined(this.formFields[field].required) && this.formFields[field].required) {
        validationParams.formFields[field] = {value: {required}};
      }
    }
    console.log('validationParams', validationParams);

    return validationParams;
  },
}
</script>

<style scoped>

</style>