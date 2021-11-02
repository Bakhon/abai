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

      <div class="form-check ml-2">
        <input v-model="isStacked"
               id="stacked"
               type="checkbox"
               class="form-check-input cursor-pointer">

        <label class="form-check-label cursor-pointer"
               for="stacked">
          {{ trans(`economic_reference.stacked`) }}
        </label>
      </div>
    </div>

    <apexchart
        ref="chart"
        :options="options"
        :series="chartSeries"
        :height="chartHeight"/>
  </div>
</template>

<script>
import chart from "vue-apexcharts";
import {chartInitMixin} from "../../mixins/chartMixin";

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
    currentAnnotation: {
      minY: 0,
      maxY: 0
    },
  }),
  methods: {
    chartClearAnnotations(isVisibleDefaultSeries = false) {
      this.isVisibleDefaultSeries = isVisibleDefaultSeries

      this.$refs.chart.clearAnnotations()
    },

    chartSelection({data}, {xaxis}) {
      this.chartClearAnnotations(false)

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
      let data = [...this.defaultSeries]

      if (this.isVisibleInPause) {
        this.chartKeys.forEach(key => {
          data.push(this.chartArea(key, this.data, this.pausedData))
        })
      }

      if (this.isVisibleInWork) {
        this.chartKeys.forEach(key => {
          data.push(this.chartArea(key, this.data))
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

    options() {
      return {
        ...this.chartOptions,
        ...{
          chart: {
            stacked: false,
            foreColor: '#FFFFFF',
            locales: [ru],
            defaultLocale: 'ru',
            events: {
              selection: (chartContext, params) => this.chartSelection(chartContext, params),
              zoomed: () => this.chartClearAnnotations(true)
            },
            selection: {
              enabled: true,
              type: 'x',
            },
          },
          yaxis: this.isVisibleDefaultSeries
              ? this.chartYaxis
              : {min: 0, title: {text: this.title}},
        }
      }
    }
  },
}
</script>

