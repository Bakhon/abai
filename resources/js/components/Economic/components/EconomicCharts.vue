<template>
  <div class="row p-3 mt-3 bg-main1">
    <div class="d-flex">
      <economic-chart-button
          v-for="(tab, index) in tabs"
          :key="index"
          :text="tab"
          :active="activeTab === index"
          class="col-2 mr-2"
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
          class="bg-economic-chart"/>

      <chart2 v-else-if="index === 1" :data="charts.chart2"/>

      <chart3 v-else-if="index === 2" :data="charts.chart3"/>

      <chart4 v-else-if="index === 3" :data="charts.chart4"/>
      />
    </div>
  </div>
</template>

<script>
import EconomicChartButton from "./EconomicChartButton";

import chart1 from "../chart1";
import chart2 from "../chart2";
import chart3 from "../chart3";
import chart4 from "../chart4";

export default {
  name: "EconomicCharts",
  components: {
    EconomicChartButton,
    chart1,
    chart2,
    chart3,
    chart4,
  },
  props: {
    charts: {
      required: true,
      type: Object
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