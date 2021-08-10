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
            :min="validationParamMin(param)"
            :max="validationParamMax(param)"
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
            @change="_.isUndefined(field.change) ? null : $emit(field.change);"
            v-model="formFields[param].value" >
          <option v-for="option in selectOptions(formFields[param].optionsName)" :value="option.id">{{ option.name }}</option>
        </select>

        <b-form-invalid-feedback
            v-if="!_.isUndefined(field.required) && field.required"
            id="input-live-feedback"
            :state="!isRequiredValid(param)">
          {{ trans('validation.required', {attribute: trans(field.label)}) }}
        </b-form-invalid-feedback>

        <b-form-invalid-feedback
            v-if="!_.isNull(validationParamMax(param))"
            id="input-live-feedback"
            :state="!isMaxValueValid(param)">
          {{ trans('validation.max.numeric', {attribute: trans(field.label), max: validationParamMax(param)}) }}
        </b-form-invalid-feedback>

        <b-form-invalid-feedback
            v-if="!_.isNull(validationParamMin(param))"
            id="input-live-feedback"
            :state="!isMinValueValid(param)">
          {{ trans('validation.min.numeric', {attribute: trans(field.label), min: validationParamMin(param)}) }}
        </b-form-invalid-feedback>
      </div>
    </b-col>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
      <button type="submit" class="btn btn-success" @click.prevent="submit">{{ trans('app.save') }}</button>
    </div>
  </b-row>
</template>

<script>

import moment from "moment";
import Vue from "vue";
import {Datetime} from "vue-datetime";
import 'vue-datetime/dist/vue-datetime.css'
import {required, maxValue, minValue} from "vuelidate/lib/validators";

Vue.use(Datetime)

export default {
  name: "EditForm",
  props: {
    formObject: Object,
    validationParams: Object,
    formFields: Object,
    selectsOptions: Object
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
    test () {
      return this.$v;
    }
  },
  watch: {
    formFields: {
      deep: true,
      handler(val){
        console.log('formFields changed ', val);
        if (!_.isUndefined(this.formFields.date)) {
          this.date = this.formFields.date.value;
        }
      }
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
      return this.selectsOptions[field];
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
    },
    isRequiredValid (param) {
      return (this.$v.formFields[param].value.$dirty && !this.$v.formFields[param].value.required);
    },
    isMaxValueValid (param) {
      return (this.$v.formFields[param].value.$dirty && !this.$v.formFields[param].value.maxValue);
    },
    isMinValueValid (param) {
      return (this.$v.formFields[param].value.$dirty && !this.$v.formFields[param].value.minValue);
    }
  },
  validations() {
    let validationParams = {
      formFields: {}
    };

    for (let field in this.formFields) {
      validationParams.formFields[field] = {value: {}};

      if (!_.isUndefined(this.formFields[field].required) && this.formFields[field].required) {
        validationParams.formFields[field].value = {required};
      }

      if (!_.isNull(this.validationParamMax(field))) {
        validationParams.formFields[field].value.maxValue = maxValue(this.validationParamMax(field));
      }

      if (!_.isNull(this.validationParamMin(field))) {
        validationParams.formFields[field].value.minValue = minValue(this.validationParamMin(field));
      }
    }

    return validationParams;
  },
}
</script>

<style scoped>

</style>