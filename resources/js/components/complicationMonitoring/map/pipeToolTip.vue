<template>
  <div v-if="pipe">
    <p>
      {{ pipe.name }}</p>
    <p>
      {{ trans('app.date') }} : {{ getValOrNoData(pipe[paramKey].date) }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.length') }} : {{ getValOrNoData(pipe[paramKey].length) }}
    </p>
    <p>
      {{ trans('monitoring.units.q_zh') }}, {{ trans('measurements.m3/day') }} :
      {{ getValOrNoData(pipe[paramKey].qliq) }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.bsw') }}, {{ trans('measurements.percent') }} :
      {{ getValOrNoData(pipe[paramKey].wc) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu.fields.gas_factor') }} : {{ getValOrNoData(pipe[paramKey].gazf) }}</p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.pressure_start') }} :
      {{ getValOrNoData(pipe[paramKey].press_start) }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.pressure_end') }} : {{ getValOrNoData(pipe[paramKey].press_end) }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.temperature_start') }} :
      {{ getValOrNoData(pipe[paramKey].temp_start) }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.temperature_end') }} : {{ getValOrNoData(pipe[paramKey].temp_end) }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.mix_speed_avg') }} :
      {{ getValOrNoData(pipe[paramKey].mix_speed_avg) }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.fluid_speed') }} : {{ getValOrNoData(pipe[paramKey].fluid_speed) }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.gaz_speed') }} : {{ getValOrNoData(pipe[paramKey].gaz_speed) }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.flow_type') }} : {{ getValOrNoData(pipe[paramKey].flow_type) }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.press_change') }} :
      {{ getValOrNoData(pipe[paramKey].press_change) }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.height_drop') }} : {{ getValOrNoData(pipe[paramKey].height_drop) }}
    </p>
  </div>
</template>

<script>
export default {
  name: "pipeToolTip",
  props: {
    pipe: Object,
    paramKey: String
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