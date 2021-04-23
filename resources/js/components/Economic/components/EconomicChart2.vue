<template>
  <apexchart
      :options="options"
      :series="chartSeries"
      :height="695"
      type="line"/>
</template>

<script>
import {economicChartInitMixin} from "../mixins/economicChartMixin";

export default {
  name: 'EconomicChart2',
  mixins: [economicChartInitMixin],
  computed: {
    options() {
      return {
        ...this.chartOptions, ...{
          yaxis: {
            labels: {
              formatter: function (value) {
                return Math.round(value);
              }
            },
            title: {
              text: 'Добыча нефти',
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
                    : new Intl.NumberFormat('en-IN', {maximumSignificantDigits: 3}).format(y.toFixed(0)) + " тыс. тонн";
              }
            }
          }
        }
      }
    },
  },
}
</script>
