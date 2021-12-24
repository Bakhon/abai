<template>
  <div class="overflow-auto customScroll" :style="`height: ${chartHeight}`">
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
    isFullscreen: {
      required: false,
      type: Boolean
    }
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

    chartHeight() {
      return this.isFullscreen ? '700px' : '550px'
    }
  },
}
</script>

<style scoped>
.customScroll::-webkit-scrollbar {
  width: 10px;
}
</style>