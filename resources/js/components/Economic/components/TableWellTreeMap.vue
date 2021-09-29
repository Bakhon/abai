<template>
  <div>
    <div v-if="loadingTreemap" class="text-white">
      {{ trans('economic_reference.loading_treemap') }}...
    </div>

    <div v-for="chart in charts"
         :key="chart.title"
         :id="chart.title">
    </div>
  </div>
</template>

<script>
import {treemapMixin} from "../mixins/treemapMixin";
import {waterCutMixin} from "../mixins/wellMixin";

export default {
  name: "TableWellTreeMap",
  mixins: [treemapMixin, waterCutMixin],
  props: {
    scenario: {
      required: true,
      type: Object
    },
    data: {
      required: true,
      type: Array
    },
  },
  computed: {
    wells() {
      return this.data
          .filter(well =>
              +well.dollar_rate === +this.scenario.dollar_rate &&
              +well.oil_price === +this.scenario.oil_price
          )
          .map(well => {
            well[this.waterCutKey] = +this.calcWaterCut(well.liquid_12m, well.oil_12m)

            return well
          })
    },

    selectedWells() {
      return this.scenario.uwi_stop
    },

    profitabilityKey() {
      return 'Operating_profit_12m'
    },

    waterCutKey() {
      return 'water_cut_12m'
    },

    charts() {
      return [
        {
          title: this.trans('economic_reference.operating_profit') + '-',
          key: this.profitabilityKey,
          negative: true
        },
        {
          title: this.trans('economic_reference.operating_profit') + '+',
          key: this.profitabilityKey,
          positive: true
        },
        {
          title: this.trans('economic_reference.liquid_production'),
          key: 'liquid_12m',
          hasSubtitle: true,
        },
        {
          title: this.trans('economic_reference.oil_production'),
          key: 'oil_12m',
          hasSubtitle: true,
        },
        {
          title: this.trans('economic_reference.water_cut'),
          key: this.waterCutKey,
          hasSubtitle: true,
        },
      ]
    },
  },
}
</script>

<style scoped>

</style>