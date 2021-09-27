<template>
  <div>
    <b-form-group
        :label="fieldNameTrans"
        label-for="object-name"
    >
      <b-form-input
          id="object-name"
          v-model="object.name"
          required
      ></b-form-input>

      <b-form-invalid-feedback id="input-live-feedback" :state="!($v.object.name.$dirty && !$v.object.name.required)">
        {{ trans('validation.required', {attribute: fieldNameTrans}) }}
      </b-form-invalid-feedback>
    </b-form-group>

    <b-form-group
        :label="trans('monitoring.ngdu')"
        label-for="ngdus">
      <b-form-select
          id="ngdus"
          v-model="object.ngdu_id"
          :options="ngduOptions"
      ></b-form-select>

      <b-form-invalid-feedback id="input-live-feedback"
                               :state="!($v.object.ngdu_id.$dirty && !$v.object.ngdu_id.required)">
        {{ trans('validation.required', {attribute: trans('monitoring.ngdu')}) }}
      </b-form-invalid-feedback>
    </b-form-group>

    <b-form-group
        v-if="editMode == 'gu'"
        :label="trans('monitoring.cdng')"
        label-for="cdng">
      <b-form-select
          id="cdng"
          v-model="object.cdng_id"
          :options="cdngOptions"
          @input="onSelectCdng"
      ></b-form-select>

      <b-form-invalid-feedback id="input-live-feedback"
                               :state="!($v.object.cdng_id.$dirty && !$v.object.cdng_id.required)">
        {{ trans('validation.required', {attribute: trans('monitoring.cdng')}) }}
      </b-form-invalid-feedback>
    </b-form-group>

    <b-form-group
        v-if="editMode != 'gu'"
        :label="trans('monitoring.gu.gu')"
        label-for="gus">
      <b-form-select
          id="gus"
          v-model="object.gu_id"
          :options="guOptions"
          @input="onSelectGu"
      ></b-form-select>

      <b-form-invalid-feedback id="input-live-feedback" :state="!($v.object.gu_id.$dirty && !$v.object.gu_id.required)">
        {{ trans('validation.required', {attribute: trans('monitoring.gu.gu')}) }}
      </b-form-invalid-feedback>
    </b-form-group>

    <b-form-group
        v-if="editMode == 'well'"
        :label="trans('monitoring.zu.zu')"
        label-for="zus">
      <b-form-select
          id="zus"
          v-model="object.zu_id"
          :options="zuOptions"
          @input="onSelectZu"
      ></b-form-select>

      <b-form-invalid-feedback id="input-live-feedback" :state="!($v.object.zu_id.$dirty && !$v.object.zu_id.required)">
        {{ trans('validation.required', {attribute: trans('monitoring.zu.zu')}) }}
      </b-form-invalid-feedback>
    </b-form-group>

    <b-form-group :label="trans('monitoring.latitude')" label-for="coord-x">
      <b-form-input
          id="coord-y"
          v-model="object.lat"
          required
      ></b-form-input>

      <b-form-invalid-feedback id="input-live-feedback" :state="!($v.object.lat.$dirty && !$v.object.lat.required)">
        {{ trans('validation.required', {attribute: trans('monitoring.latitude')}) }}
      </b-form-invalid-feedback>
    </b-form-group>

    <b-form-group :label="trans('monitoring.longitude')" label-for="coord-y">
      <b-form-input
          id="coord-x"
          v-model="object.lon"
          required
      ></b-form-input>

      <b-form-invalid-feedback id="input-live-feedback" :state="!($v.object.lon.$dirty && !$v.object.lon.required)">
        {{ trans('validation.required', {attribute: trans('monitoring.longitude')}) }}
      </b-form-invalid-feedback>
    </b-form-group>

    <b-form-group :label="trans('monitoring.elevation')" label-for="coord-z">
      <b-form-input
          id="coord-z"
          v-model="object.elevation"
          required
      ></b-form-input>

      <b-form-invalid-feedback id="input-live-feedback"
                               :state="!($v.object.elevation.$dirty && !$v.object.elevation.required)">
        {{ trans('validation.required', {attribute: trans('monitoring.elevation')}) }}
      </b-form-invalid-feedback>
    </b-form-group>

    <template v-if="object.id && editMode == 'gu'">
      <h5>{{ trans('monitoring.gu.params') }}</h5>
      <div class="color-white">
        <p>{{ trans('monitoring.gu.fields.date') }}: {{ guParams.date }}</p>
        <p>{{ trans('monitoring.gu.fields.daily_fluid_production') }}:
          {{ guParams.daily_fluid_production.toFixed(2) + ' ' + trans('measurements.m3/day') }}</p>
        <p>{{ trans('monitoring.gu.fields.daily_oil_production') }}:
          {{ guParams.daily_oil_production.toFixed(2) + ' ' + trans('measurements.m3/day') }}</p>
        <p>{{ trans('monitoring.gu.fields.daily_water_production') }}:
          {{ guParams.daily_water_production.toFixed(2) + ' ' + trans('measurements.m3/day') }}</p>
        <p>{{ trans('monitoring.gu.fields.bsw') }}: {{ guParams.bsw + trans('measurements.percent') }}</p>
        <p>{{ trans('monitoring.gu.fields.pump_discharge_pressure') }}:
          {{ guParams.pump_discharge_pressure.toFixed(2) + ' ' + trans('measurements.pressure_bar') }}</p>
        <p>{{ trans('monitoring.gu.fields.heater_output_temperature') }}:
          {{ guParams.heater_output_temperature.toFixed(2) + ' ' + trans('measurements.celsius') }}</p>
        <p>{{ trans('monitoring.gu.fields.daily_gas_production_in_sib') }}: {{ guParams.daily_gas_production_in_sib.toFixed(2) }}
          {{ trans('measurements.st.m3/day') }}</p>
        <p>{{ trans('monitoring.gu.fields.surge_tank_pressure') }}: {{ guParams.surge_tank_pressure.toFixed(2) }}
          {{ trans('measurements.pressure_bar') }}</p>
      </div>
    </template>
  </div>
</template>

<script>
import {guMapState} from '@store/helpers';
import {required} from "vuelidate/lib/validators";

const blankGuParams = {
  daily_fluid_production: 'N/A ',
  daily_oil_production: 'N/A ',
  heater_output_temperature: 'N/A ',
  pump_discharge_pressure: 'N/A ',
  daily_water_production: 'N/A ',
  bsw: 'N/A ',
  date: 'N/A'
};

export default {
  name: "objectForm",
  props: {
    object: {
      type: Object,
      required: true,
    },
    editMode: String
  },
  data: function () {
    return {
      validationParams:
          {
            object: {
              ngdu_id: {
                required
              },
              name: {
                required
              },
              lat: {
                required
              },
              lon: {
                required
              },
              elevation: {
                required
              },
            }
          }
    }
  },
  computed: {
    ...guMapState([
      'guPoints',
      'zuPoints',
      'cdngs',
      'ngdus'
    ]),
    zuOptions: function () {
      let options = [];

      this.zuPoints.forEach((item) => {
        if (!item.gu_id) {
          return;
        }

        if (_.isUndefined(this.object.gu_id) ||
            item.gu_id == this.object.gu_id
        ) {
          options.push(
              {value: item.id, text: item.name}
          );
        }
      });

      return options;
    },
    guOptions: function () {
      let options = [];
      this.guPoints.forEach((item) => {
        if (_.isUndefined(this.object.ngdu_id) ||
            item.ngdu_id == this.object.ngdu_id
        ) {
          options.push(
              {value: item.id, text: item.name}
          );
        }
      });

      return options;
    },
    ngduOptions: function () {
      let options = [];
      this.ngdus.forEach((item) => {
        options.push(
            {value: item.id, text: item.name}
        );
      });

      return options;
    },
    cdngOptions: function () {
      let options = [];
      this.cdngs.forEach((item) => {
        if (_.isUndefined(this.object.ngdu_id) ||
            item.ngdu_id == this.object.ngdu_id
        ) {
          options.push(
              {value: item.id, text: item.name}
          );
        }
      });

      return options;
    },
    fieldNameTrans() {
      switch (this.editMode) {
        case "gu":
          return this.trans('monitoring.gu.name');
        case "zu":
          return this.trans('monitoring.zu.name');
        case "well":
          return this.trans('monitoring.well.name');
      }
    },
    guParams() {
      if (!this.object.last_omgngdu) {
        return blankGuParams;
      }

      return this.object.last_omgngdu;
    },
  },
  validations() {
    switch (this.editMode) {
      case "gu":
        this.validationParams.object.cdng_id = {required};
        break;
      case "zu":
        this.validationParams.object.gu_id = {required};
        break;
      case "well":
        this.validationParams.object.gu_id = {required};
        this.validationParams.object.zu_id = {required};
        break;
    }

    return this.validationParams;
  },
  methods: {
    validate() {
      this.$v.$touch();

      return this.$v.$invalid;
    },
    onSelectCdng() {
      if (!_.isUndefined(this.object.cdng_id)) {
        this.object.ngdu_id = this.cdngs.find((cdng) => {
          return cdng.id == this.object.cdng_id;
        }).ngdu_id;
      }
    },
    onSelectGu() {
      if (!_.isUndefined(this.object.gu_id)) {
        let gu =  this.guPoints.find((guPoint) => {
          return guPoint.id == this.object.gu_id;
        });

        this.object.ngdu_id = gu.ngdu_id;
        this.object.cdng_id = gu.cdng_id;
      }
    },
    onSelectZu() {
      if (!_.isUndefined(this.object.zu_id)) {
        let zu =  this.zuPoints.find((zuPoint) => {
          return zuPoint.id == this.object.zu_id;
        });

        this.object.gu_id = zu.gu_id;
        this.onSelectGu();
      }
    },
  }
}
</script>