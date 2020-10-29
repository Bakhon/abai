<template>
<div>
  <apexchart type="area" height="180"  :options="chartOptions" :series="series"></apexchart>
</div>
</template>

<script>
var ru = require("apexcharts/dist/locales/ru.json");
import VueApexCharts from 'vue-apexcharts'

Vue.component('apexchart', VueApexCharts)
export default {
  name: 'mix-chart',
  data: function() {
    return {
      chartOptions: {
        chart: {
            stacked: true,
            foreColor: '#FFFFFF',
            locales: [ru],
            defaultLocale: 'ru'
        },
        tooltip: {
          theme: 'dark',
          shared: true,
          intersect: false,
          y: {
            formatter: function(y) {
              if (typeof y !== "undefined") {
                return new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(y.toFixed(0)) + "";
              }
              return y;
            }
          }
        },
        stroke: {
          curve: 'smooth'
        },
        plotOptions: {
          bar: {
            columnWidth: '50%'
          }
        },

		 dataLabels: {
          enabled: false
        },
        labels: [
		],

      },
      series: [{
        name: 'План',
         type: 'area',
        stroke: {
          curve: 'smooth'
        },
        data: []
      }]
    }
  },
  methods: {
    setValue: function(value) {
        this.series = [
            {
                name: 'Фактическая скорость коррозии',
                data: value.value
            }
            ];

        this.chartOptions = {
            labels: value.dt
        };
    }
  },
  created: function() {
    this.$parent.$on('chart4', this.setValue);
  }
}
</script>
