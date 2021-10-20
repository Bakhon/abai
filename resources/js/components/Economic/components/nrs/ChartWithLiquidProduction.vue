<template>
  <div>
    <div class="d-flex justify-content-center pt-2">
      <div class="form-check">
        <input v-model="isStacked"
               id="stacked"
               type="checkbox"
               class="form-check-input cursor-pointer">

        <label class="form-check-label cursor-pointer"
               for="stacked">
          {{ trans(`economic_reference.stacked`) }}
        </label>
      </div>

      <div class="form-check ml-2">
        <input v-model="isScaled"
               id="scaled"
               type="checkbox"
               class="form-check-input cursor-pointer">

        <label class="form-check-label cursor-pointer"
               for="scaled">
          {{ trans(`economic_reference.scaled`) }}
        </label>
      </div>
    </div>

    <apexchart
        :options="chartOptions"
        :series="chartSeries"
        :height="chartHeight"/>
  </div>
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
      if (seriesIndex < this.defaultSeriesLength) {
        return (+value.toFixed(2)).toLocaleString()
      }

      value = this.chartSeries[seriesIndex].tooltipData[dataPointIndex].split('.')

      let liquid = +value[0]

      if (this.chartDimension) {
        liquid /= this.chartDimension
      }

      liquid = (+liquid.toFixed(2)).toLocaleString()

      let waterCut = value.length > 1 ? value[1] : 0

      return `
          ${liquid} ${this.tooltipText},
          ${this.trans('economic_reference.liquid')}: ${waterCut}%
      `
    },

    chartArea(profitability, wells) {
      const name = this.trans(`economic_reference.wells_${profitability}`)

      switch (profitability) {
        case "profitable":
          return {
            name: name,
            type: 'area',
            data: wells[profitability].map(value => {
              value = value ? +value.split('.')[0] : 0

              if (this.chartDimension) {
                value /= this.chartDimension
              }

              return value
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
              value = value ? +value.split('.')[0] : 0

              if (this.isStacked && wells.hasOwnProperty('profitable') && wells.profitable[index]) {
                value += +wells.profitable[index].split('.')[0]
              }

              if (this.chartDimension) {
                value /= this.chartDimension
              }

              return value
            }),
            tooltipData: wells[profitability],
          }
        case "profitless_cat_1":
          return {
            name: name,
            profitability: profitability,
            type: 'area',
            data: wells[profitability].map((value, index) => {
              value = value ? +value.split('.')[0] : 0

              if (this.isStacked) {
                if (wells.hasOwnProperty('profitable') && wells.profitable[index]) {
                  value += +wells.profitable[index].split('.')[0]
                }

                if (wells.hasOwnProperty('profitless_cat_2') && wells.profitless_cat_2[index]) {
                  value += +wells.profitless_cat_2[index].split('.')[0]
                }
              }

              if (this.chartDimension) {
                value /= this.chartDimension
              }

              return value
            }),
            tooltipData: wells[profitability],
          }
      }
    },
  },
  computed: {
    tooltipText() {
      return this.isScaled
          ? this.trans('economic_reference.thousand_tons')
          : this.trans('economic_reference.tons')
    },

    chartDimension() {
      return this.isScaled ? 1000 : null
    }
  }
}
</script>
