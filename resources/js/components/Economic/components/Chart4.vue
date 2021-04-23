<template>
  <apexchart
      :options="options"
      :series="chartSeries"
      :height="695"
      type="line"/>
</template>

<script>
import {chartInitMixin} from "../mixins/chartMixin";

export default {
  name: 'Chart4',
  mixins: [chartInitMixin],
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
              text: this.trans('economic_reference.liquid_production'),
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

                let res = `${liquid[0]} ${this.trans('economic_reference.thousand_tons')}`

                return liquid.length > 1
                    ? res + `, ${this.trans('economic_reference.liquid')}:  ${liquid[1]}%`
                    : res
              }
            }
          }
        }
      }
    },
  },
}
</script>
