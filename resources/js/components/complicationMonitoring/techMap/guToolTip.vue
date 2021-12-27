<template>
  <div className="params_block" v-if="gu">
    <p>
      {{ gu.name }}
    </p>
    <p>
      {{ trans('app.date') }} : {{ paramValue('date') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.daily_fluid_production') }} :
      {{ getValueOrNoData(paramValue('daily_fluid_production')) }} {{ trans('measurements.m3/day') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.daily_oil_production') }} :
      {{ getValueOrNoData(paramValue('daily_oil_production')) }} {{ trans('measurements.m3/day') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.daily_water_production') }} :
      {{ getValueOrNoData(paramValue('daily_water_production')) }} {{ trans('measurements.m3/day') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.bsw') }} : {{ getValueOrNoData(paramValue('bsw')) }}
      {{ trans('measurements.percent') }}</p>
    <p>
      {{ trans('monitoring.gu.fields.pump_discharge_pressure') }} :
      {{ getValueOrNoData(paramValue('pump_discharge_pressure')) }} {{ trans('measurements.pressure_bar') }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu.fields.heater_inlet_temperature') }} :
      {{ getValueOrNoData(paramValue('heater_inlet_temperature')) }} {{ trans('measurements.celsius') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.heater_output_temperature') }} :
      {{ getValueOrNoData(paramValue('heater_output_temperature')) }} {{ trans('measurements.celsius') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.daily_gas_production_in_sib') }} :
      {{ getValueOrNoData(paramValue('daily_gas_production_in_sib')) }} {{ trans('measurements.st.m3/day') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.surge_tank_pressure') }} :
      {{ getValueOrNoData(paramValue('surge_tank_pressure')) }} {{ trans('measurements.pressure_bar') }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.sg_oil') }} :
      {{ getValueOrNoData(paramValue('sg_oil')) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.sg_gas') }} :
      {{ getValueOrNoData(paramValue('sg_gas')) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.sg_water') }} :
      {{ getValueOrNoData(paramValue('sg_water')) }}
    </p>
  </div>
</template>

<script>
import getValueOrNoData from '~/mixins/getValueOrNoData';

export default {
  name: "guToolTip",
  props: {
    gu: Object,
  },
  mixins: [getValueOrNoData],
  methods: {
    paramValue(param_name) {
      return this.gu.last_omgngdu ? this.gu.last_omgngdu[param_name] : this.gu.omgngdu[param_name];
    }
  }
}
</script>

