<template>
  <div class="chart-border_color mt-3">
    <div>
      <div class="col px-2 container-col_color">
        <apexchart
          type="line"
          height="255"
          :options="chartOptions"
          :series="series"
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
    };
  },
  computed: {
    series() {
      return this.chartOptionsData.series;
    },

    chartOptions() {
      return _.merge(
        this.chartOptionsData.chartOptions,
        this.chartSettings.chartOptions
      );
    },
  },
};
</script>
