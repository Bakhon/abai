<template>
  <div class="row p-3 mt-3 bg-main1">
    <div class="d-flex">
      <economic-chart-button
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

      <economic-chart1
          v-if="index === 0"
          :data="charts.chart1"
          :granularity="granularity"
          class="bg-economic-chart"/>

      <economic-chart1
          v-if="index === 1"
          :data="charts.chart2"
          :granularity="granularity"
          title="Добыча нефти"
          tooltip-text="тыс. тонн"
          class="bg-economic-chart"/>

      <economic-chart3
          v-else-if="index === 2"
          :data="charts.chart3"
          :granularity="granularity"
          class="bg-economic-chart"/>

      <economic-chart4
          v-else-if="index === 3"
          :data="charts.chart4"
          :granularity="granularity"
          class="bg-economic-chart"/>

      <economic-chart1
          v-else-if="index === 4"
          :data="charts.chart5"
          :granularity="granularity"
          class="bg-economic-chart"/>
    </div>
  </div>
</template>

<script>
import EconomicChartButton from "./EconomicChartButton";

import EconomicChart1 from "./EconomicChart1";
import EconomicChart3 from "./EconomicChart3";
import EconomicChart4 from "./EconomicChart4";

export default {
  name: "EconomicCharts",
  components: {
    EconomicChartButton,
    EconomicChart1,
    EconomicChart3,
    EconomicChart4,
  },
  props: {
    charts: {
      required: true,
      type: Object
    },
    granularity: {
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
        'Распределение скважин по типу рентабельности',
        'Распределение добычи нефти по типу рентабельности скважин',
        'Рейтинг ТОП 10 прибыльных и убыточных скважин',
        'Распределение добычи жидкости по типу рентабельности скважин',
        'Распределение скважин в простое по типу рентабельности',
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