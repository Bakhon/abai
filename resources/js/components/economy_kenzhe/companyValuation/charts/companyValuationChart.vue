<template>
  <div class="chart-border_color mt-3">
    <div>
      <div class="col px-2 container-col_color" v-if="isDisplay">
        <apexchart
          type="line"
          height="255"
          :options="chartOptions.chartOptions"
          :series="chartOptions.series"
        ></apexchart>
      </div>
    </div>
  </div>
</template>
<script>
import chartSettings from "./chart_settings/all.json";
import VueApexCharts from "vue-apexcharts";

export default {
  components: {
    apexchart: VueApexCharts,
  },
  props: ["chartOptionsData"],
  data: function () {
    return {
      chartSettings: chartSettings,
      chartOptions: {},
      series: {},
      isDisplay: false,
    };
  },
  async created() {
    await this.showChart();
  },
  methods: {
    showChart() {
      this.chartOptions = this.chartOptionsData;
      this.chartOptionsData.chartOptions = Object.assign(
        this.chartOptionsData.chartOptions,
        this.chartSettings.chartOptions
      );
      this.isDisplay = true;
    },
  },
};
</script>
