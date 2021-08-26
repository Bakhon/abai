<template>
  <div className="params_block" v-if="gu">
    <p>
      {{ gu.name }}
    </p>
    <p>
      {{ trans('app.date') }} : {{ getValueOrNoData(gu.last_omgngdu.date) }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.daily_fluid_production') }} :
      {{ getValueOrNoData(gu.last_omgngdu.daily_fluid_production) }} {{ trans('measurements.m3/day') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.daily_oil_production') }} :
      {{ getValueOrNoData(gu.last_omgngdu.daily_oil_production) }} {{ trans('measurements.m3/day') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.daily_water_production') }} :
      {{ getValueOrNoData(gu.last_omgngdu.daily_water_production) }} {{ trans('measurements.m3/day') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.bsw') }} : {{ getValueOrNoData(gu.last_omgngdu.bsw) }}
      {{ trans('measurements.percent') }}</p>
    <p>
      {{ trans('monitoring.gu.fields.pump_discharge_pressure') }} :
      {{ getValueOrNoData(gu.last_omgngdu.pump_discharge_pressure) }} {{ trans('measurements.pressure_bar') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.heater_output_temperature') }} :
      {{ getValueOrNoData(gu.last_omgngdu.heater_output_temperature) }} {{ trans('measurements.celsius') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.daily_gas_production_in_sib') }} :
      {{ getValueOrNoData(gu.last_omgngdu.daily_gas_production_in_sib) }} {{ trans('measurements.st.m3/day') }}
    </p>
    <p>
      {{ trans('monitoring.gu.fields.surge_tank_pressure') }} :
      {{ getValueOrNoData(gu.last_omgngdu.surge_tank_pressure) }} {{ trans('measurements.pressure_bar') }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.sg_oil') }} :
      {{ getValueOrNoData(gu.last_omgngdu.sg_oil) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.sg_gas') }} :
      {{ getValueOrNoData(gu.last_omgngdu.sg_gas) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.sg_water') }} :
      {{ getValueOrNoData(gu.last_omgngdu.sg_water) }}
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
  mixins: [getValueOrNoData]
}
</script>

