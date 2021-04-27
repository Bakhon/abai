<template>
  <apexchart
      :options="options"
      :series="chartSeries"
      :height="695"
      type="line"/>
</template>

<script>
const ru = require("apexcharts/dist/locales/ru.json");

import {chartInitMixin} from "../mixins/chartMixin";

export default {
  name: 'Chart1',
  mixins: [chartInitMixin],
  props: {
    title: {
      required: true,
      type: String,
    },
    tooltipText: {
      required: false,
      type: String,
    }
  },
  created() {
    window.economic_reference_chart1_tooltipText = this.tooltipText || ''
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
                ).format(y.toFixed(0)) + ` ${window.economic_reference_chart1_tooltipText}`;
              }
            }
          }
        }
      }
    },
  },
}
</script>

