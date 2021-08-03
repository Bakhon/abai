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
        :options="options"
        :series="chartSeries"
        :height="710"
        type="line"/>
  </div>
</template>

<script>
import {GRANULARITY_DAY} from "./SelectGranularity";
import chart from "vue-apexcharts";
import {chartInitMixin} from "../mixins/chartMixin";

const ru = require("apexcharts/dist/locales/ru.json");

export default {
  name: 'ChartWithProfitability',
  components: {apexchart: chart},
  mixins: [chartInitMixin],
  props: {
    title: {
      required: true,
      type: String,
    },
    pausedData: {
      required: true,
      type: Object
    },
  },
  data: () => ({
    isVisibleInWork: true,
    isVisibleInPause: false,
    currentAnnotation: {
      isVisible: false,
      minY: 0,
      maxY: 0
    },
  }),
  methods: {
    chartClearAnnotations(isVisible = false) {
      this.currentAnnotation.isVisible = isVisible

      this.$refs.chart.clearAnnotations()
    },

    chartSelection({data}, {xaxis}) {
      this.chartClearAnnotations(true)

      let min = Math.ceil(xaxis.min)
      let max = Math.floor(xaxis.max)

      let minIndex = data.twoDSeriesX.findIndex(x => x >= min)
      let maxIndex = data.twoDSeriesX.map(x => x <= max).lastIndexOf(true);

      this.currentAnnotation.minY = 0
      this.currentAnnotation.maxY = 0

      if (this.isVisibleInWork) {
        this.addAnnotations(this.data, minIndex, maxIndex, data.twoDSeriesX)
      }

      if (this.isVisibleInPause) {
        this.addAnnotations(this.pausedData, minIndex, maxIndex, data.twoDSeriesX)
      }
    },

    addAnnotations(data, minIndex, maxIndex, twoDSeriesX) {
      this.chartKeys.forEach(key => {
        this.currentAnnotation.minY += data[key][minIndex]
        this.currentAnnotation.maxY += data[key][maxIndex]

        this.$refs.chart.addPointAnnotation({
          x: twoDSeriesX[minIndex],
          y: this.currentAnnotation.minY,
          marker: {size: 8},
        }, false)

        let diff = data[key][maxIndex] - data[key][minIndex]
        let diffPercent = +(Math.round(10000 * diff / data[key][minIndex]) / 100).toFixed(2)

        this.$refs.chart.addPointAnnotation({
          x: twoDSeriesX[maxIndex],
          y: this.currentAnnotation.maxY,
          marker: {size: 8},
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
                top: 5,
                bottom: 5,
              }
            }
          },
        }, false)
      })
    }
  },
  computed: {
    chartSeries() {
      let data = this.currentAnnotation.isVisible
          ? []
          : [{
            name: this.trans('economic_reference.oil_price'),
            type: 'line',
            data: this.oilPrices
          }]

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

      return data
    },

    chartSeriesName() {
      const name = this.trans(`economic_reference.wells_${this.chartKeys[0]}`)

      return this.isVisibleInWork
          ? name
          : `${name} ${this.trans(`economic_reference.in_pause`).toLowerCase()}`
    },

    chartColors() {
      let colors = this.currentAnnotation.isVisible
          ? []
          : [this.colorOilPrice]

      if (this.isVisibleInWork) {
        colors = [...colors, ...this.colorsInWork]
      }

      if (this.isVisibleInPause) {
        colors = [...colors, ...this.colorsInPause]
      }

      return colors
    },

    options() {
      return {
        ...this.chartOptions, ...{
          labels: this.data.hasOwnProperty('dt') ? this.data.dt : [],
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
          xaxis: {
            type: this.granularity === GRANULARITY_DAY
                ? 'datetime'
                : 'date'
          },
          yaxis: this.currentAnnotation.isVisible
              ? {min: 0, title: {text: this.title}}
              : this.chartYaxis,
        }
      }
    },
  },
}
</script>

