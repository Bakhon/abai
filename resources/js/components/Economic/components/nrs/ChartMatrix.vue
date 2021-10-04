<template>
  <div>
    <h5 class="m-0">
      {{ trans('economic_reference.well') }}: {{ uwi }}
    </h5>

    <apexchart
        ref="chart"
        :options="chartOptions"
        :series="chartSeries"
        :height="400"
        style="color: #000"/>
  </div>
</template>

<script>
import chart from "vue-apexcharts";

const RU = require("apexcharts/dist/locales/ru.json");
const COLORS = [
  '#008A1F',
  '#D6091D',
  '#2309D6',
  '#000000',
  '#23CBD6',
]

export default {
  name: "ChartMatrix",
  components: {apexchart: chart},
  props: {
    uwi: {
      required: true,
      type: String
    },
    well: {
      required: true,
      type: Object
    },
    dates: {
      required: true,
      type: Array
    }
  },
  computed: {
    chartSeries() {
      let series = []

      this.wellKeys.forEach(key => {
        series.push({name: key.name, type: key.chartType, data: []})
      })

      this.dates.forEach(date => {
        this.wellKeys.forEach((key, keyIndex) => {
          let value = this.well[key.prop].hasOwnProperty(date)
              ? +this.well[key.prop][date]
              : 0

          if (key.isNegative && value > 0) {
            value = -value
          }

          if (key.dimension) {
            value = (value / key.dimension).toFixed(2)
          }

          series[keyIndex].data.push(+value)
        })
      })

      return series
    },

    chartOptions() {
      return {
        labels: this.dates,
        stroke: {
          width: 4,
          curve: 'smooth'
        },
        colors: COLORS,
        chart: {
          stacked: false,
          foreColor: '#FFFFFF',
          locales: [RU],
          defaultLocale: 'ru'
        },
        markers: {
          size: 0
        },
        plotOptions: {
          bar: {
            columnWidth: '50%'
          }
        },
        xaxis: {
          type: 'date'
        },
        yaxis: this.yaxis,
        tooltip: {
          shared: true,
          intersect: false,
          y: {
            formatter: (y) => y
          }
        },
      }
    },

    wellKeys() {
      return [
        {
          prop: 'NetBack_bf_pr_exp',
          name: this.trans('economic_reference.Revenue'),
          dimension: 1000,
          chartType: 'column',
        },
        {
          prop: 'Overall_expenditures',
          name: this.trans('economic_reference.costs'),
          dimension: 1000,
          chartType: 'column',
          isNegative: true
        },
        {
          prop: 'Operating_profit',
          name: this.trans('economic_reference.operating_profit'),
          dimension: 1000,
          chartType: 'area'
        },
        {
          prop: 'oil',
          name: this.trans('economic_reference.oil_production'),
          chartType: 'line',
        },
        {
          prop: 'liquid',
          name: this.trans('economic_reference.liquid_production'),
          chartType: 'line',
        }
      ]
    },

    yaxis() {
      return this.chartSeries.map((item, index) => {
        return {
          seriesName: index < 3 ? this.chartSeries[0].name : this.chartSeries[index].name,
          show: index === 0,
        }
      })
    }
  }
}
</script>

<style scoped>

</style>