<template>
  <div class="overflow-auto customScroll" style="height: 550px;">
    <div v-if="loadingTreemap" class="w-100 text-white text-center my-2">
      {{ trans('economic_reference.loading_treemap') }}...
    </div>

    <div v-for="chart in charts"
         :key="chart.title"
         :id="chart.title">
    </div>
  </div>
</template>

<script>
import {treemapMixin} from "../../mixins/treemapMixin";
import {waterCutMixin} from "../../mixins/wellMixin";

export default {
  name: "TableWellTreeMap",
  mixins: [treemapMixin, waterCutMixin],
  props: {
    scenario: {
      required: true,
      type: Object
    },
    scenarios: {
      required: true,
      type: Array
    },
  },
  computed: {
    wells() {
      return this.scenarios
          .find(scenario =>
              +scenario.oil_price === +this.scenario.oil_price &&
              +scenario.dollar_rate === +this.scenario.dollar_rate
          )
          .wells
          .map(well => {
            well[this.waterCutKey] = +this.calcWaterCut(well.liquid, well.oil)

            return well
          })
    },

    selectedWells() {
      return this.scenario.stopped_uwis
    },

    charts() {
      return [
        {
          title: this.trans('economic_reference.operating_profit') + '+',
          key: this.profitabilityKey,
          positive: true,
          hasSubtitle: true,
          isShowCount: true
        },
        {
          title: this.trans('economic_reference.operating_profit') + '-',
          key: this.profitabilityKey,
          negative: true,
          sort: 'asc',
          hasSubtitle: true,
          isShowCount: true
        },
        {
          title: this.trans('economic_reference.liquid_production'),
          key: 'liquid',
          hasSubtitle: true,
        },
        {
          title: this.trans('economic_reference.oil_production'),
          key: 'oil',
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
.customScroll::-webkit-scrollbar {
  width: 10px;
}
</style>