<template>
  <div class="h-100 text-center d-flex">
    <div class="flex-50">
      <subtitle font-size="16" class="line-height-18px">
        Факт
      </subtitle>

      <apexchart
          :options="chartOptions.original"
          :series="chartSeries.original"
          :height="535"/>
    </div>

    <div class="flex-50">
      <subtitle font-size="16" class="line-height-18px">
        Предлагаемый вариант
      </subtitle>

      <apexchart
          :options="chartOptions.proposed"
          :series="chartSeries.proposed"
          :height="535"/>
    </div>
  </div>
</template>

<script>
import chart from "vue-apexcharts";
import Subtitle from "../Subtitle";

const ru = require("apexcharts/dist/locales/ru.json");

export default {
  name: "TableWellDistribution",
  components: {
    apexchart: chart,
    Subtitle
  },
  props: {
    wells: {
      required: true,
      type: Array
    },
    proposedWells: {
      required: true,
      type: Array
    }
  },
  created() {
    this.$emit('updateWide', false)
  },
  computed: {
    sortedUwis() {
      return {
        original: Object.keys(this.wells),
        proposed: Object.keys(this.proposedWells),
      }
    },

    chartSeries() {
      return {
        original: this.getChartSeries('wells', 'original'),
        proposed: this.getChartSeries('proposedWells', 'proposed'),
      }
    },

    chartOptions() {
      return {
        original: this.getChartOptions('wells', 'original'),
        proposed: this.getChartOptions('proposedWells', 'proposed'),
      }
    },
  },
  methods: {
    sortUwis(wellsKey) {
      if (!this[wellsKey]) {
        return []
      }

      return Object.keys(this[wellsKey]).sort((prev, next) =>
          +this[wellsKey][prev].operating_profit - +this[wellsKey][next].operating_profit
      )
    },

    getChartOptions(wellsKey, sortKey) {
      return {
        labels: this.sortedUwis[sortKey],
        stroke: {
          width: 4,
          curve: 'smooth'
        },
        chart: {
          foreColor: '#FFFFFF',
          locales: [ru],
          defaultLocale: 'ru'
        },
        markers: {
          size: 1,
          discrete: [
            ...this.getChartMarkers(wellsKey, sortKey, 0, 0),
            ...this.getChartMarkers(wellsKey, sortKey, 1, 1)
          ]
        },
        yaxis: this.chartSeries[sortKey].map((chart, index) => {
          return {
            show: true,
            opposite: !!index,
            title: {
              text: chart.name
            },
            labels: {
              formatter: (value) => {
                if (chart.dimension) {
                  value /= chart.dimension
                }

                return +value.toFixed(2)
              }
            },
          }
        }),
        tooltip: {
          shared: true,
          intersect: false,
          y: this.chartSeries[sortKey].map((chart) => {
            return {
              formatter: (value) => {
                if (chart.dimension) {
                  value /= chart.dimension
                }

                return `${(+value.toFixed(2)).toLocaleString()} ${chart.dimensionTitle}`
              }
            }
          })
        },
      }
    },

    getChartMarkers(wellsKey, sortKey, seriesIndex, markerSize) {
      return this.sortedUwis[sortKey].map((uwi, uwiIndex) => ({
        seriesIndex: seriesIndex,
        dataPointIndex: uwiIndex,
        fillColor: this[wellsKey][uwiIndex].is_changed === -1
            ? '#E31F25'
            : '#009847',
        strokeColor: this[wellsKey][uwiIndex].is_changed === -1
            ? '#E31F25'
            : '#009847',
        size: this[wellsKey][uwiIndex].is_changed
            ? markerSize
            : 0,
        shape: "circle"
      }))
    },

    getChartSeries(wellsKey, sortKey) {
      let series = []

      let oil = []

      let operatingProfit = []

      this.sortedUwis[sortKey].forEach(uwi => {
        oil.push(+this[wellsKey][uwi].oil)

        operatingProfit.push(+this[wellsKey][uwi].operating_profit)
      })

      series.push(
          {
            name: this.trans('economic_reference.oil_production'),
            type: 'area',
            color: '#5697D9',
            data: oil,
            dimensionTitle: this.trans('economic_reference.tons'),
          },
          {
            name: this.trans('economic_reference.operating_profit'),
            type: 'line',
            color: '#009847',
            data: operatingProfit,
            dimension: 1000000,
            dimensionTitle: `
              ${this.trans('economic_reference.million')}.
              ${this.trans('economic_reference.tenge')}
            `,
          },
      )

      return series
    },
  },
}
</script>

<style scoped>
.line-height-18px {
  line-height: 18px;
}

.flex-50 {
  flex: 0 0 50%;
}
</style>