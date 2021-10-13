<template>
  <div>
    <apexchart
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
  '#EF798A',
  '#F7A9A8',
  '#613F75',
  '#E5C3D1',
  '#988B8E',
  '#47E5BC',
  '#81E4DA',
  '#AECFDF',
  '#ACBDBA',
  '#D6E5E3',
  '#FEEA00',
  '#567568',
  '#FCA311',
  '#14213D',
  '#2081C3',
  '#63D2FF',
]

export default {
  name: "ChartMatrixTotal",
  components: {apexchart: chart},
  props: {
    dates: {
      required: true,
      type: Array
    },
    wellSum: {
      required: true,
      type: Array
    },
    wellKeys: {
      required: true,
      type: Array
    },
    prsSum: {
      required: true,
      type: Array
    },
    prsKeys: {
      required: true,
      type: Array
    },
    dateOffset: {
      required: true,
      type: Number
    }
  },
  computed: {
    chartSeries() {
      let series = []

      let wellKeysCount = this.wellKeys.length

      this.wellKeys.forEach(key => {
        series.push({name: key.name, type: key.chartType, data: []})
      })

      this.prsKeys.forEach(key => {
        series.push({name: key.name, type: key.chartType, data: []})
      })

      this.dates.forEach((date, dateIndex) => {
        this.wellKeys.forEach((key, keyIndex) => {
          series[keyIndex].data.push(
              +this.wellSum[keyIndex][dateIndex + this.dateOffset].value
          )
        })

        this.prsKeys.forEach((key, keyIndex) => {
          series[wellKeysCount + keyIndex].data.push(
              +this.prsSum[keyIndex][dateIndex + this.dateOffset].value
          )
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
  }
}
</script>

<style scoped>

</style>