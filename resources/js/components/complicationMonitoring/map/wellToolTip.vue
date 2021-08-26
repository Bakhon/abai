<template>
  <div className="params_block" v-if="well">
    <p>
      {{ well.name }}
    </p>
    <p>
      {{ trans('app.date') }} : {{ getValueOrNoData(well.last_omgngdu.date) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.daily_fluid_production') }} :
      {{ getValueOrNoData(well.last_omgngdu.daily_fluid_production) }} {{ trans('measurements.m3/day') }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.daily_oil_production') }} :
      {{ getValueOrNoData(well.last_omgngdu.daily_oil_production) }} {{ trans('measurements.m3/day') }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.daily_water_production') }} :
      {{ getValueOrNoData(well.last_omgngdu.daily_water_production) }} {{ trans('measurements.m3/day') }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.bsw') }} : {{ getValueOrNoData(well.last_omgngdu.bsw) }}
      {{ trans('measurements.percent') }}</p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.pressure') }} :
      {{ getValueOrNoData(well.last_omgngdu.pressure) }} {{ trans('measurements.pressure_bar') }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.temperature') }} :
      {{ getValueOrNoData(well.last_omgngdu.temperature) }} {{ trans('measurements.celsius') }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.gas_factor') }} :
      {{ getValueOrNoData(well.last_omgngdu.gas_factor) }} {{ trans('measurements.m3/m3') }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.sg_oil') }} :
      {{ getValueOrNoData(well.last_omgngdu.sg_oil) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.sg_gas') }} :
      {{ getValueOrNoData(well.last_omgngdu.sg_gas) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.sg_water') }} :
      {{ getValueOrNoData(well.last_omgngdu.sg_water) }}
    </p>
  </div>
</template>

<script>
import getValueOrNoData from '~/mixins/getValueOrNoData';

export default {
  name: "wellToolTip",
  props: {
    well: Object,
  },
  mixins: [getValueOrNoData]
}
</script>