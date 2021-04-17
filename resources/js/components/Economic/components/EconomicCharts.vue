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

    <div class="mt-3 w-100">
      <h5 class="subtitle text-wrap">
        {{ title }}
      </h5>

      <chart1-component
          v-if="activeTab === 0"
          :data="charts.chart1"/>

      <chart2-component
          v-else-if="activeTab === 1"
          :data="charts.chart2"/>

      <chart3-component
          v-else-if="activeTab === 2"
          :data="charts.chart3"/>

      <chart4-component
          v-else-if="activeTab === 3"
          :data="charts.chart4"/>
      />
    </div>
  </div>
</template>

<script>
import EconomicChartButton from "./EconomicChartButton";

export default {
  name: "EconomicCharts",
  components: {
    EconomicChartButton
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

</style>