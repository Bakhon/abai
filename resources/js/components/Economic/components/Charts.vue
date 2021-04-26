<template>
  <div class="row p-3 mt-3 bg-main1">
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

      <chart1
          v-if="index === 0"
          :data="charts.chart1"
          :granularity="granularity"
          :profitability="profitability"
          :title="trans('economic_reference.count_well')"
          class="bg-economic-chart"/>

      <chart1
          v-if="index === 1"
          :data="charts.chart2"
          :granularity="granularity"
          :profitability="profitability"
          :title="trans('economic_reference.oil_production')"
          :tooltip-text="trans('economic_reference.thousand_tons')"
          class="bg-economic-chart"/>

      <chart3
          v-else-if="index === 2"
          :data="charts.chart3"
          :granularity="granularity"
          :profitability="profitability"
          class="bg-economic-chart"/>

      <chart4
          v-else-if="index === 3"
          :data="charts.chart4"
          :granularity="granularity"
          :profitability="profitability"
          class="bg-economic-chart"/>

      <chart1
          v-else-if="index === 4"
          :data="charts.chart5"
          :granularity="granularity"
          :profitability="profitability"
          :title="trans('economic_reference.count_well')"
          class="bg-economic-chart"/>
    </div>
  </div>
</template>

<script>
import ChartButton from "./ChartButton";

import Chart1 from "./Chart1";
import Chart3 from "./Chart3";
import Chart4 from "./Chart4";

export default {
  name: "Charts",
  components: {
    ChartButton,
    Chart1,
    Chart3,
    Chart4,
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
        this.trans('economic_reference.distribution_pause_wells_by_profitability'),
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