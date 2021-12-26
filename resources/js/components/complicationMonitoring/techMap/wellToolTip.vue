<template>
  <div className="params_block" v-if="well">
    <p>
      {{ well.name }}
    </p>
    <p>
      {{ trans('app.date') }} : {{ paramValue('date') }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.daily_fluid_production') }} :
      {{ getValueOrNoData(paramValue('daily_fluid_production')) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.daily_oil_production') }} :
      {{ getValueOrNoData(paramValue('daily_oil_production')) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.daily_water_production') }} :
      {{ getValueOrNoData(paramValue('daily_water_production')) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.gas_factor') }} :
      {{ getValueOrNoData(daily_gas_production) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu.fields.gas_factor') }} : {{ getValueOrNoData(paramValue('gas_factor')) }}</p>
    <p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.bsw') }} : {{ getValueOrNoData(paramValue('bsw')) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.pressure') }} :
      {{ getValueOrNoData(paramValue('pressure')) }}
    </p>
    <p>
      {{ trans('monitoring.omgngdu_well.fields.temperature') }} :
      {{ getValueOrNoData(paramValue('temperature_well')) }}
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
  name: "wellToolTip",
  props: {
    well: Object,
  },
  mixins: [getValueOrNoData],
  computed: {
    daily_gas_production() {
      let omgngdu = this.well.last_omgngdu ? this.well.last_omgngdu : this.well.omgngdu;
      return omgngdu.gas_factor * omgngdu.daily_fluid_production * (1 - omgngdu.bsw / 100);
    }
  },
  methods: {
    paramValue(param_name) {
      return this.well.last_omgngdu ? this.well.last_omgngdu[param_name] : this.well.omgngdu[param_name];
    }
  }
}
</script>