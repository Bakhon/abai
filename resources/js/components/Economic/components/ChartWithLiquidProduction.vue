<template>
  <apexchart
      :options="chartOptions"
      :series="chartSeries"
      :height="740"
      type="line"/>
</template>

<script>
import chart from "vue-apexcharts";
import {chartInitMixin} from "../mixins/chartMixin";

export default {
  name: 'ChartWithLiquidProduction',
  mixins: [chartInitMixin],
  components: {apexchart: chart},
  created() {
    window.economic_reference_thousand_tons = this.trans('economic_reference.thousand_tons')
    window.economic_reference_liquid = this.trans('economic_reference.liquid')
  },
  methods: {
    tooltipFormatter(y) {
      if (y === undefined || y === null) {
        return y
      }

      let liquid = y.toString().split('.');

      let res = `${liquid[0]} ${window.economic_reference_thousand_tons}`

      return liquid.length > 1
          ? res + `, ${window.economic_reference_liquid}:  ${liquid[1]}%`
          : res
    },
  }
}
</script>
