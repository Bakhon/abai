<template>
  <div class="row p-3 bg-main1">
    <div class="d-flex">
      <chart-button
          v-for="(tab, index) in tabs"
          :key="index"
          :text="tab"
          :active="activeTab === index"
          :class="index ? 'ml-2' : ''"
          class="col"
          @click.native="activeTab = index"/>
    </div>

    <div
        v-for="(tab, index) in tabs"
        v-show="activeTab === index"
        :key="tab"
        class="mt-3 w-100">
      <h5 class="subtitle text-wrap">
        {{ tab }}
      </h5>

      <chart-with-profitability
          v-if="index === 0"
          :data="charts.profitability"
          :paused-data="charts.pausedProfitability"
          :granularity="granularity"
          :profitability="profitability"
          :title="trans('economic_reference.count_well')"
          class="bg-economic-chart"/>

      <chart-with-oil-production
          v-if="index === 1"
          :data="charts.oilProduction"
          :granularity="granularity"
          :profitability="profitability"
          :title="trans('economic_reference.oil_production')"
          :tooltip-text="trans('economic_reference.thousand_tons')"
          class="bg-economic-chart"/>

      <chart-with-operating-profit-top
          v-else-if="index === 2"
          :data="charts.operatingProfitTop"
          :granularity="granularity"
          :profitability="profitability"
          class="bg-economic-chart"/>

      <chart-with-liquid-production
          v-else-if="index === 3"
          :data="charts.liquidProduction"
          :granularity="granularity"
          :profitability="profitability"
          class="bg-economic-chart"/>
    </div>
  </div>
</template>

<script>
import ChartButton from "./ChartButton";
import ChartWithProfitability from "./ChartWithProfitability";
import ChartWithOilProduction from "./ChartWithOilProduction";
import ChartWithOperatingProfitTop from "./ChartWithOperatingProfitTop";
import ChartWithLiquidProduction from "./ChartWithLiquidProduction";

export default {
  name: "Charts",
  components: {
    ChartButton,
    ChartWithProfitability,
    ChartWithOilProduction,
    ChartWithOperatingProfitTop,
    ChartWithLiquidProduction,
  },
  props: {
    charts: {
      required: true,
      type: Object
    },
    granularity: {
      required: true,
      type: String
    },
    profitability: {
      required: true,
      type: String
    }
  },
  data: () => ({
    activeTab: 0
  }),
  computed: {
    title() {
      return this.tabs[this.activeTab]
    },

    tabs() {
      return [
        this.trans('economic_reference.distribution_wells_by_profitability'),
        this.trans('economic_reference.distribution_oil_production_by_profitability'),
        this.trans('economic_reference.rating_top_10_wells_by_profitability'),
        this.trans('economic_reference.distribution_liquid_production_by_profitability'),
      ]
    },
  }
}
</script>

<style scoped>
.bg-economic-chart {
  background: #2B2E5E;
}
</style>