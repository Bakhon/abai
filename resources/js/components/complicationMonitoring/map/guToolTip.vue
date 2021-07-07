<template>
  <div className="params_block" v-if="gu">
    <p>
      {{ gu.name }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.date') }} : {{ getValOrNoData(gu.last_omgngdu.date) }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.daily_fluid_production') }} :
      {{ getValOrNoData(gu.last_omgngdu.daily_fluid_production) }} {{ trans('measurements.m3/day') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.daily_oil_production') }} :
      {{ getValOrNoData(gu.last_omgngdu.daily_oil_production) }} {{ trans('measurements.m3/day') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.daily_water_production') }} :
      {{ getValOrNoData(gu.last_omgngdu.daily_water_production) }} {{ trans('measurements.m3/day') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.bsw') }} : {{ getValOrNoData(gu.last_omgngdu.bsw) }}
      {{ trans('measurements.percent') }}</p>
    <p>
      {{ trans('monitoring.gu.fields.pump_discharge_pressure') }} :
      {{ getValOrNoData(gu.last_omgngdu.pump_discharge_pressure) }} {{ trans('measurements.pressure_bar') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.heater_output_temperature') }} :
      {{ getValOrNoData(gu.last_omgngdu.heater_output_temperature) }} {{ trans('measurements.celsius') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.daily_gas_production_in_sib') }} :
      {{ getValOrNoData(gu.last_omgngdu.daily_gas_production_in_sib) }} {{ trans('measurements.st.m3/day') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.surge_tank_pressure') }} :
      {{ getValOrNoData(gu.last_omgngdu.surge_tank_pressure) }} {{ trans('measurements.pressure_bar') }}
    </p>
  </div>
</template>

<script>
export default {
  name: "guToolTip",
  props: {
    gu: Object,
  },
  methods: {
    getValOrNoData(param) {
      return (typeof param == 'undefined' || !param) ? this.trans('monitoring.no_data') : param;
    },
  }
}
</script>

<style scoped>

</style>