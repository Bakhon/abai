<template>
  <apexchart
      :options="options"
      :series="chartSeries"
      :height="695"
      type="line"/>
</template>

<script>
const ru = require("apexcharts/dist/locales/ru.json");

import {economicChartInitMixin} from "../mixins/economicChartMixin";

export default {
  name: 'EconomicChart1',
  mixins: [economicChartInitMixin],
  props: {
    title: {
      required: false,
      type: String,
      default: () => 'Количество скважин'
    },
    tooltipText: {
      required: false,
      type: String
    }
  },
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
              text: this.title,
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

                return new Intl.NumberFormat(
                    'en-IN',
                    {maximumSignificantDigits: 3}
                ).format(y.toFixed(0)) + this.tooltipText;
              }
            }
          }
        }
      }
    },
  },
}
</script>

