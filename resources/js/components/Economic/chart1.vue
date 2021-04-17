<template>
  <div>
    <apexchart
        :options="chartOptions"
        :series="series"
        height="350"
        type="line"/>
  </div>
</template>

<script>
var ru = require("apexcharts/dist/locales/ru.json");

import {chartInitMixin} from "./mixins/chartMixin";

export default {
  name: 'mix-chart',
  mixins: [
    chartInitMixin
  ],
  data: () => ({
    chartOptions: {
      chart: {
        stacked: true,
        foreColor: '#FFFFFF',
        locales: [ru],
        defaultLocale: 'ru'
      },
      colors: ['#13B062', '#F7BB2E', '#AB130E'],
      stroke: {
        width: 4,
        curve: 'smooth'
      },
      labels: ['01/01/2020', '02/01/2020', '03/01/2020', '04/01/2020', '05/01/2020', '06/01/2020', '07/01/2020', '08/01/2020', '09/01/2020', '10/01/2020', '11/01/2020'],
      markers: {
        size: 0
      },
      xaxis: {
        type: 'datetime'
      },
      yaxis: {
        labels: {
          formatter: function (value) {
            return Math.round(value);
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
          formatter: function (y) {
            if (typeof y !== "undefined") {
              return new Intl.NumberFormat('en-IN', {maximumSignificantDigits: 3}).format(y.toFixed(0)) + "";
            }
            return y;
          }
        }
      }
    },
  }),
}
</script>

