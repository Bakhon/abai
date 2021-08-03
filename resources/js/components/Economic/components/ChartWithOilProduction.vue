<template>
  <apexchart
      :options="options"
      :series="chartSeries"
      :height="740"
      type="line"/>
</template>

<script>
const ru = require("apexcharts/dist/locales/ru.json");

import chart from "vue-apexcharts";
import {chartInitMixin} from "../mixins/chartMixin";

export default {
  name: 'ChartWithOilProduction',
  components: {apexchart: chart},
  mixins: [chartInitMixin],
  props: {
    title: {
      required: true,
      type: String,
    },
  },
  computed: {
    options() {
      return {
        ...this.chartOptions, ...{
          tooltip: {
            shared: true,
            intersect: false,
            y: {
              formatter: (y) => this.tooltipFormatter(y)
            }
          }
        }
      }
    },
  },
}
</script>

