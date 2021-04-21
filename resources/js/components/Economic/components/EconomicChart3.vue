<template>
  <apexchart
      :options="options"
      :series="chartSeries"
      :height="645"
      type="bar"/>
</template>

<script>
import {chartInitMixin} from "../mixins/chartMixin";

export default {
  name: 'EconomicChart3',
  mixins: [chartInitMixin],
  computed: {
    chartSeries() {
      return [
        {
          name: 'Топ 10 нерентабельных скважин',
          data: this.data.Operating_profit.slice(0, 10)
        },
        {
          name: 'Топ 10 рентабельных скважин',
          data: this.data.Operating_profit.slice(10)
        }
      ];
    },

    options() {
      return {
        ...this.chartOptions, ...{
          plotOptions: {
            bar: {
              horizontal: true,
              barHeight: '30%',
              borderRadius: 7,
              radiusOnLastStackedBar: false
            },
          },
          chart: {
            type: 'bar',
            height: 440,
            stacked: true,
            foreColor: '#FFFFFF'
          },
          colors: ['#AB130E', '#13B062'],
          dataLabels: {
            enabled: false
          },
          stroke: {
            show: true,
            colors: ['transparent']
          },
          xaxis: {
            categories: this.data.uwi,
          },
          fill: {
            opacity: 1
          },
        }
      }
    }
  },
}
</script>
