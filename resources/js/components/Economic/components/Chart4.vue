<template>
  <apexchart
      :options="options"
      :series="chartSeries"
      :height="745"
      type="line"/>
</template>

<script>
import {chartInitMixin} from "../mixins/chartMixin";

export default {
  name: 'Chart4',
  mixins: [chartInitMixin],
  created() {
    window.economic_reference_thousand_tons = this.trans('economic_reference.thousand_tons')
    window.economic_reference_liquid = this.trans('economic_reference.liquid')
  },
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
                console.log(this)

                if (y === undefined) {
                  return y
                }

                let liquid = y.toString().split('.');

                let res = `${liquid[0]} ${window.economic_reference_thousand_tons}`

                return liquid.length > 1
                    ? res + `, ${window.economic_reference_liquid}:  ${liquid[1]}%`
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
