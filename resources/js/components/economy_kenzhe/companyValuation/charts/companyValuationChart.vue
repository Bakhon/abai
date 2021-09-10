<template>
  <div class="chart-border_color mt-3">
    <div>
      <div class="col px-2 container-col_color" v-if="show">
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
      show: false,
    };
  },
  async created() {
    await this.downloadJson();
  },
  methods: {
    downloadJson() {
      console.log(this.chartOptionsData);
      this.chartOptions = this.chartOptionsData;
      this.chartOptionsData.chartOptions = Object.assign(
        this.chartOptionsData.chartOptions,
        this.chartSettings.chartOptions
      );
      this.show = true;
    },
  },
};
</script>
