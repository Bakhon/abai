<template>
  <apexchart
      :options="chartOptions"
      :series="chartSeries"
      :height="555"/>
</template>

<script>
const ru = require("apexcharts/dist/locales/ru.json");

import chart from "vue-apexcharts";
import {chartInitMixin} from "../../mixins/chartMixin";

export default {
  name: 'ChartWithOilProduction',
  components: {apexchart: chart},
  mixins: [chartInitMixin],
  props: {
    title: {
      required: true,
      type: String,
    },
  }
}
</script>

