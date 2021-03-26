<template>
  <div>
    <b-form-group
        :label="trans('monitoring.gu.name')"
        label-for="gu-name"
    >
      <b-form-input
          id="gu-name"
          v-model="gu.name"
          required
      ></b-form-input>
    </b-form-group>

    <b-form-group
        :label="trans('monitoring.cdng')"
        label-for="cdng">
      <b-form-select
          id="cdng"
          v-model="gu.cdng_id"
          :options="cdngOptions"
      ></b-form-select>
    </b-form-group>

    <b-form-group :label="trans('monitoring.latitude')" label-for="coord-x">
      <b-form-input
          id="coord-y"
          v-model="gu.lat"
          required
      ></b-form-input>
    </b-form-group>

    <b-form-group :label="trans('monitoring.longitude')" label-for="coord-y">
      <b-form-input
          id="coord-x"
          v-model="gu.lon"
          required
      ></b-form-input>
    </b-form-group>

    <b-form-group :label="trans('monitoring.elevation')" label-for="coord-z">
      <b-form-input
          id="coord-z"
          v-model="gu.elevation"
          required
      ></b-form-input>
    </b-form-group>

    <h5>{{ trans('monitoring.gu.params') }}</h5>
    <div class="params_block">
      <p>{{ trans('monitoring.gu.fields.date') }}: {{ guParams.date }}</p>
      <p>{{ trans('monitoring.gu.fields.daily_fluid_production') }}: {{ guParams.daily_fluid_production + ' ' + trans('measurements.m3/day') }}</p>
      <p>{{ trans('monitoring.gu.fields.daily_oil_production') }}: {{ guParams.daily_oil_production + ' ' + trans('measurements.m3/day') }}</p>
      <p>{{ trans('monitoring.gu.fields.daily_water_production') }}: {{ guParams.daily_water_production + ' ' + trans('measurements.m3/day') }}</p>
      <p>{{ trans('monitoring.gu.fields.bsw') }}: {{ guParams.bsw + trans('measurements.percent')}}</p>
      <p>{{ trans('monitoring.gu.fields.pump_discharge_pressure') }}: {{ guParams.pump_discharge_pressure + ' ' + trans('measurements.pressure_bar') }}</p>
      <p>{{ trans('monitoring.gu.fields.heater_output_temperature') }}: {{ guParams.heater_output_pressure + ' ' + trans('measurements.celsius') }}</p>
    </div>
  </div>
</template>

<script>
import {guMapState} from '@store/helpers';

const blankGuParams = {
  daily_fluid_production: 'N/A ',
  daily_oil_production: 'N/A ',
  heater_output_pressure: 'N/A ',
  pump_discharge_pressure: 'N/A ',
  daily_water_production: 'N/A ',
  bsw: 'N/A ',
  date: 'N/A'
};

export default {
  name: "mapGuForm",
  props: {
    gu: {
      type: Object,
      required: true,
    },
  },
  computed: {
    ...guMapState([
      'guPoints',
      'cdngs'
    ]),
    cdngOptions: function () {
      let options = [];
      this.cdngs.forEach((item) => {
        options.push(
            { value: item.id, text: item.name }
        );
      });

      return options;
    },
    guParams () {
      if (!this.gu.last_omgngdu) {
        return blankGuParams;
      }

      return this.gu.last_omgngdu;
    }
  },
}
</script>

<style scoped lang="scss">
.params_block {
  color: white;
}
</style>