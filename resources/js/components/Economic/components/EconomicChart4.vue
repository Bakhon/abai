<template>
  <apexchart
      :options="options"
      :series="chartSeries"
      :height="645"
      type="line"/>
</template>

<script>
import {economicChartInitMixin} from "../mixins/economicChartMixin";

export default {
  name: 'EconomicChart4',
  mixins: [economicChartInitMixin],
  computed: {
    options() {
      return {
        ...this.chartOptions, ...{
          yaxis: {
            labels: {
              formatter(value) {
                return Math.floor(value);
              }
            },
            title: {
              text: 'Добыча жидкости',
            },
            min: 0
          },
          tooltip: {
            shared: true,
            intersect: false,
            y: {
              formatter(y) {
                if (y === undefined) {
                  return y
                }

                let liquid = y.toString().split('.');

                return liquid.length > 1
                    ? `${liquid[0]} тыс. тонн, обв: ${liquid[1]}%`
                    : `${liquid[0]} тыс. тонн`
              }
            }
          }
        }
      }
    },
  },
}
</script>
