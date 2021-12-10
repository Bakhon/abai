<template>
  <div v-if="pipe">
    <p>
      {{ pipe.name }}</p>
    <p>
      {{ trans('app.date') }} : {{ pipe[paramKey].date }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.length') }} : {{ getValueOrNoData(pipe[paramKey].length) }}
    </p>
    <p>
      {{ trans('monitoring.units.q_zh') }}, {{ trans('measurements.m3/day') }} :
      {{ getValueOrNoData(pipe[paramKey].qliq) }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.bsw') }}:
      {{ getValueOrNoData(pipe[paramKey].bsw) }} {{ trans('measurements.percent') }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu.fields.gas_factor') }} : {{ getValueOrNoData(pipe[paramKey].gazf) }}</p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.pressure_start') }} :
      {{ getValueOrNoData(pipe[paramKey].press_start * 1.01325) }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.pressure_end') }} : {{ getValueOrNoData(pipe[paramKey].press_end  * 1.01325) }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.temperature_start') }} :
      {{ getValueOrNoData(pipe[paramKey].temperature_start) }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.temperature_end') }} : {{ getValueOrNoData(pipe[paramKey].temperature_end) }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.mix_speed_avg') }} :
      {{ getValueOrNoData(pipe[paramKey].mix_speed_avg) }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.fluid_speed') }} : {{ getValueOrNoData(pipe[paramKey].fluid_speed) }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.gaz_speed') }} : {{ getValueOrNoData(pipe[paramKey].gaz_speed) }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.flow_type') }} : {{ pipe[paramKey].flow_type }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.press_change') }} :
      {{ getValueOrNoData(pipe[paramKey].press_change) }}
    </p>
    <p>
      {{ trans('monitoring.hydro_calculation.fields.height_drop') }} : {{ getValueOrNoData(pipe[paramKey].height_drop) }}
    </p>
  </div>
</template>

<script>
import getValueOrNoData from '~/mixins/getValueOrNoData';

export default {
  name: "pipeToolTip",
  props: {
    pipe: Object,
    paramKey: String
  },
  mixins: [getValueOrNoData]
}
</script>

