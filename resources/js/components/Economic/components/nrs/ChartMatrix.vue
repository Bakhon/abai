<template>
  <div>
    <h4 class="m-0">
      {{ trans('economic_reference.well') }}: {{ uwi }}
    </h4>

    <apexchart
        ref="chart"
        :options="chartOptions"
        :series="chartSeries"
        :height="400"
        type="line"
        style="color: #000"/>
  </div>
</template>

<script>
import chart from "vue-apexcharts";

const RU = require("apexcharts/dist/locales/ru.json");
const COLORS = [
  '#B629FE',
  '#FC35B0',
  '#79B44E',
  '#A3480E',
  '#374AB4',
  '#82BAFF',
  '#FFC607',
  '#A9A9A9',
  '#F37F31',
  '#436DB0',
  '#81B9FE',
  '#374AB4',
  '#436B2A',
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
        series.push({name: key.name, type: 'line', data: [],})
      })

      this.dates.forEach(date => {
        this.wellKeys.forEach((key, keyIndex) => {
          let value = this.well[key.prop].hasOwnProperty(date)
              ? +this.well[key.prop][date]
              : 0

          if (key.dimension) {
            value = (value / key.dimension).toFixed(2)
          }

          series[keyIndex].data.push(value)
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
          dimension: 1000
        },
        {
          prop: 'Overall_expenditures',
          name: this.trans('economic_reference.costs'),
          dimension: 1000
        },
        {
          prop: 'Operating_profit',
          name: this.trans('economic_reference.operating_profit'),
          dimension: 1000
        },
        {
          prop: 'oil',
          name: this.trans('economic_reference.oil_production'),
        },
        {
          prop: 'liquid',
          name: this.trans('economic_reference.liquid_production'),
        }
      ]
    },
  }
}
</script>

<style scoped>

</style>