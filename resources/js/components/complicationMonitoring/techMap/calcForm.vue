<template>
  <b-row class="mb-5">
    <b-col cols="12" class="mt-10px">
      <label>{{ trans('app.date') }}</label>
      <div class="form-label-group">
        <datetime
            v-model="date"
            type="date"
            input-class="form-control date"
            :format="{year: 'numeric', month: 'long', day: 'numeric'}"
            :phrases="{ok: trans('app.choose'), cancel: trans('app.cancel')}"
            :minute-step="5"
            :week-start="1"
            auto
            zone='local'
            value-zone='local'
        >
        </datetime>
        <input type="hidden" name="date" :value="date"/>

        <b-form-invalid-feedback
            id="input-live-feedback"
            :state="!($v.date.$dirty && !$v.date.required)">
          {{ trans('validation.required', {attribute: trans('app.date')}) }}
        </b-form-invalid-feedback>
      </div>
    </b-col>

    <b-col cols="12" class="mt-15px">
      <b-alert v-for="(alert, index) in alerts" :key="index" :variant="alert.variant" show dismissible>
        {{ alert.message }}
      </b-alert>
    </b-col>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
      <button type="submit" class="btn btn-success" @click.prevent="submit">{{ trans('monitoring.map.calculate') }}</button>
    </div>
  </b-row>
</template>

<script>
import moment from "moment";
import {required} from "vuelidate/lib/validators";

export default {
  name: "calcForm",
  props: {
    alerts: Array
  },
  data: function () {
    return {
      date: null
    }
  },
  computed: {

  },
  watch: {
    date: () => {
      this.alerts = [];
    }
  },
  methods: {
    formatedDate() {
      if (this.date) {
        return moment.parseZone(this.date).format('YYYY-MM-DD')
      }
      return null
    },
    submit () {
      this.$v.$touch();

      if (!this.$v.$invalid) {
        this.alerts = [];
        this.$emit('submit', this.formatedDate());
      }
    }
  },
  validations() {
    return {
      date: { required }
    }
  },
}
</script>

<style scoped>

</style>