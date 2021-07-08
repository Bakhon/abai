<template>
  <div>
    <div class="d-flex justify-content-center pt-2">
      <div class="form-check">
        <input v-model="isVisibleInWork"
               id="in-work"
               type="checkbox"
               class="form-check-input cursor-pointer">

        <label class="form-check-label cursor-pointer"
               for="in-work">
          {{ trans(`economic_reference.in_work`) }}
        </label>
      </div>

      <div class="form-check ml-2">
        <input v-model="isVisibleInPause"
               id="in-pause"
               type="checkbox"
               class="form-check-input cursor-pointer">

        <label class="form-check-label cursor-pointer"
               for="in-pause">
          {{ trans(`economic_reference.in_pause`) }}
        </label>
      </div>
    </div>

    <apexchart
        ref="chart"
        :options="chartOptions"
        :series="chartSeries"
        :height="745"
        type="line"/>
  </div>
</template>

<script>
import {GRANULARITY_DAY} from "./SelectGranularity";

const ru = require("apexcharts/dist/locales/ru.json");

import chart from "vue-apexcharts";
import {chartInitMixin} from "../mixins/chartMixin";

export default {
  name: 'ChartWithProfitability',
  components: {apexchart: chart},
  mixins: [chartInitMixin],
  props: {
    title: {
      required: true,
      type: String,
    },
    tooltipText: {
      required: false,
      type: String,
    },
    pausedData: {
      required: true,
      type: Object
    }
  },
  data: () => ({
    isVisibleInWork: true,
    isVisibleInPause: false,
    selectionPoints: []
  }),
  methods: {
    tooltipFormatter(y) {
      if (y === undefined) {
        return y
      }

      return new Intl.NumberFormat(
          'en-IN',
          {maximumSignificantDigits: 3}
      ).format(y.toFixed(0)) + ` ${this.tooltipText || ''}`;
    },

    chartClearAnnotations() {
      this.selectionPoints = []

      if (this.$refs['chart']) {
        this.$refs['chart'].clearAnnotations()
      }
    },

    chartSelection({data}, {xaxis}) {
      this.chartClearAnnotations()

      let min = Math.ceil(xaxis.min)
      let max = Math.floor(xaxis.max)

      let minIndex = data.twoDSeriesX.findIndex(x => x >= min)
      let maxIndex = data.twoDSeriesX.map(x => x <= max).lastIndexOf(true);

      let currentMinY = 0
      let currentMaxY = 0

      this.chartKeys.forEach(key => {
        currentMinY += this.data[key][minIndex]
        currentMaxY += this.data[key][maxIndex]

        this.$refs.chart.addPointAnnotation({
          x: data.twoDSeriesX[minIndex],
          y: currentMinY,
        })

        let pointData = []

        let pointStep = Math.floor((this.data[key][maxIndex] - this.data[key][minIndex]) / (maxIndex - minIndex))

        this.data[key].forEach((value, index) => {
          if (index === minIndex) {
            return pointData.push(this.data[key][minIndex])
          }

          if (index === maxIndex) {
            return pointData.push(this.data[key][maxIndex])
          }

          if (index < minIndex || index > maxIndex) {
            return pointData.push(0)
          }

          pointData.push(this.data[key][minIndex] + pointStep * (index - minIndex))
        })

        this.selectionPoints.push(pointData)

        let diff = this.data[key][maxIndex] - this.data[key][minIndex]
        let diffPercent = +(Math.round(10000 * diff / this.data[key][minIndex]) / 100).toFixed(2)

        this.$refs.chart.addPointAnnotation({
          x: data.twoDSeriesX[maxIndex],
          y: currentMaxY,
          label: {
            text: `${diff < 0 ? '' : '+'}${diff} (${diffPercent} %)`,
            style: {
              background: '#fff',
              color: diff < 0 ? '#AB130E' : '#13B062',
              fontSize: '14px',
              fontWeight: 600,
              padding: {
                left: 10,
                right: 10,
                top: 10,
                bottom: 10,
              }
            }
          },
        })
      })
    },
  },
  computed: {
    chartKeys() {
      return this.isProfitabilityFull
          ? ['profitable', 'profitless_cat_2', 'profitless_cat_1']
          : ['profitable', 'profitless']
    },

    chartSeries() {
      let data = []

      if (this.isVisibleInWork) {
        this.chartKeys.forEach(key => {
          data.push({
            name: this.trans(`economic_reference.wells_${key}`),
            type: 'area',
            data: this.data[key]
          })
        })
      }

      if (this.isVisibleInPause) {
        this.chartKeys.forEach(key => {
          data.push({
            name: `${this.trans(`economic_reference.wells_${key}`)} ${this.trans(`economic_reference.in_pause`).toLowerCase()}`,
            type: 'area',
            data: this.pausedData[key]
          })
        })
      }

      this.selectionPoints.forEach(pointData=>{
        data.push({
          type: 'line',
          data: pointData
        })
      })

      return data
    },

    chartColors() {
      const colorsInWork = this.isProfitabilityFull
          ? ['#13B062', '#F7BB2E', '#AB130E', '#DC7DE8']
          : ['#13B062', '#AB130E']

      const colorsInPause = this.isProfitabilityFull
          ? ['#0E7D45', '#C49525', '#780D0A']
          : ['#0E7D45', '#780D0A']

      let colors = []

      if (this.isVisibleInWork) {
        colors = [...colors, ...colorsInWork]
      }

      if (this.isVisibleInPause) {
        colors = [...colors, ...colorsInPause]
      }

      return colors
    },

    chartOptions() {
      return {
        labels: this.data.hasOwnProperty('dt') ? this.data.dt : [],
        stroke: {
          width: 4,
          curve: 'smooth'
        },
        colors: this.chartColors,
        chart: {
          stacked: true,
          foreColor: '#FFFFFF',
          locales: [ru],
          defaultLocale: 'ru',
          events: {
            selection: (chartContext, params) => this.chartSelection(chartContext, params),
            zoomed: () => this.chartClearAnnotations()
          },
          selection: {
            enabled: true,
            type: 'x',
          },
        },
        markers: {
          size: 0
        },
        xaxis: {
          type: this.granularity === GRANULARITY_DAY
              ? 'datetime'
              : 'date'
        },
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
            formatter: (y) => this.tooltipFormatter(y)
          }
        }
      }
    },
  },
}
</script>

