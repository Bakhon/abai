<template>
  <apexchart
      :options="options"
      :series="chartSeries"
      height="350"
      type="line"/>
</template>

<script>
const ru = require("apexcharts/dist/locales/ru.json");

import {chartInitMixin} from "./mixins/chartMixin";

export default {
  name: 'chart1',
  mixins: [
    chartInitMixin
  ],
  computed: {
    options() {
      return {
        ...this.chartOptions, ...{
          yaxis: {
            labels: {
              formatter(val) {
                return Math.round(val);
              }
            },
            title: {
              text: 'Количество скважин',
            },
            min: 0
          },
          tooltip: {
            shared: true,
            intersect: false,
            y: {
              formatter(y) {
                return y === undefined
                    ? y
                    : new Intl.NumberFormat('en-IN', {maximumSignificantDigits: 3}).format(y.toFixed(0)) + "";
              }
            }
          }
        }
      }
    },
  },
}
</script>

