<template>
  <div className="params_block" v-if="well">
    <p>
      {{ well.name }}
    </p>
    <p>
      {{ trans('app.date') }} : {{ well.last_omgngdu.date }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.daily_fluid_production') }} :
      {{ getValueOrNoData(well.last_omgngdu.daily_fluid_production) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.daily_oil_production') }} :
      {{ getValueOrNoData(well.last_omgngdu.daily_oil_production) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.daily_water_production') }} :
      {{ getValueOrNoData(well.last_omgngdu.daily_water_production) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.gas_factor') }} :
      {{ getValueOrNoData(daily_gas_production) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu.fields.gas_factor') }} : {{ getValueOrNoData(well.last_omgngdu.gas_factor) }}</p>
    <p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.bsw') }} : {{ getValueOrNoData(well.last_omgngdu.bsw) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.pressure') }} :
      {{ getValueOrNoData(well.last_omgngdu.pressure) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.temperature') }} :
      {{ getValueOrNoData(well.last_omgngdu.temperature_well) }}
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
  mixins: [getValueOrNoData],
  computed: {
    daily_gas_production() {
      let omgngdu = this.well.last_omgngdu;
      return omgngdu.gas_factor * omgngdu.daily_fluid_production * (1 - omgngdu.bsw / 100);
    }
  }
}
</script>