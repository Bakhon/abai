<template>
  <apexchart
      :options="chartOptions"
      :series="chartSeries"
      :height="575"/>
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

      let liquid = value.split('.')

      let res = `${liquid[0]} ${this.trans('economic_reference.thousand_tons')}`

      return liquid.length > 1
          ? res + `, ${this.trans('economic_reference.liquid')}: ${liquid[1]}%`
          : res
    },

    chartArea(profitability, wells) {
      const name = this.trans(`economic_reference.wells_${profitability}`)

      switch (profitability) {
        case "profitable":
          return {
            name: name,
            type: 'area',
            data: wells[profitability].map(value => {
              return +value.split('.')[0]
            }),
            tooltipData: wells[profitability],
          }
        case "profitless":
        case "profitless_cat_2":
          return {
            name: name,
            profitability: profitability,
            type: 'area',
            data: wells[profitability].map((value, index) => {
              return +value.split('.')[0] + +wells.profitable[index].split('.')[0]
            }),
            tooltipData: wells[profitability],
          }
        case "profitless_cat_1":
          return {
            name: name,
            profitability: profitability,
            type: 'area',
            data: wells[profitability].map((value, index) => {
              return +value.split('.')[0]
                  + +wells.profitable[index].split('.')[0]
                  + +wells.profitless_cat_2[index].split('.')[0]
            }),
            tooltipData: wells[profitability],
          }
      }
    },
  }
}
</script>
