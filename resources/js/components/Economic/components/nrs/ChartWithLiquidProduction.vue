<template>
  <apexchart
      :options="chartOptions"
      :series="chartSeries"
      :height="740"
      type="line"/>
</template>

<script>
import chart from "vue-apexcharts";
import {chartInitMixin} from "../../mixins/chartMixin";

export default {
  name: 'ChartWithLiquidProduction',
  mixins: [chartInitMixin],
  components: {apexchart: chart},
  methods: {
    tooltipFormatter(value, {dataPointIndex, seriesIndex}) {
      value = this.chartSeries[seriesIndex].tooltipData[dataPointIndex]

      let liquid = value.toString().split('.');

      let res = `${liquid[0]} ${this.trans('economic_reference.thousand_tons')}`

      return liquid.length > 1
          ? res + `, ${this.trans('economic_reference.liquid')}: ${liquid[1]}%`
          : res
    },
  }
}
</script>
