<template>
  <div>
    <select-technical-well-forecast-kit
        :form="form"
        @change="getWells()"/>

    <div v-if="isMounted" class="h-100 text-center d-flex">
      <div class="flex-50">
        <subtitle font-size="16" class="line-height-18px">
          {{ trans('economic_reference.fact') }}
        </subtitle>

        <apexchart
            v-if="isMounted"
            :options="chartOptions.original"
            :series="chartSeries.original"
            :height="535"/>
      </div>

      <div class="flex-50">
        <subtitle font-size="16" class="line-height-18px">
          {{ trans('economic_reference.proposed_variant') }}
        </subtitle>

        <apexchart
            v-if="isMounted"
            :options="chartOptions.proposed"
            :series="chartSeries.proposed"
            :height="535"/>
      </div>
    </div>
  </div>
</template>

<script>
const ru = require("apexcharts/dist/locales/ru.json");

import {globalloadingMutations} from '@store/helpers';

import chart from "vue-apexcharts";

import Subtitle from "../../components/Subtitle";
import SelectTechnicalWellForecastKit from "../../components/SelectTechnicalWellForecastKit";

export default {
  name: "TableWellDistribution",
  components: {
    apexchart: chart,
    Subtitle,
    SelectTechnicalWellForecastKit
  },
  props: {
    form: {
      required: true,
      type: Object
    }
  },
  data: () => ({
    wells: null,
    proposedWells: null,
    isMounted: false
  }),
  created() {
    this.$emit('updateWide', false)
  },
  computed: {
    url() {
      return this.localeUrl('/economic/analysis/get-wells-by-kit')
    },

    sortedUwis() {
      return {
        original: this.isMounted ? this.wells.map(well => well.uwi) : [],
        proposed: this.isMounted ? this.proposedWells.map(well => well.uwi) : [],
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
    ...globalloadingMutations(['SET_LOADING']),

    async getWells() {
      this.SET_LOADING(true)

      this.isMounted = false

      let keys = [
        'wells',
        'proposedWells',
      ]

      try {
        const {data} = await this.axios.get(this.url, {params: this.form})

        keys.forEach(key => this[key] = data[key])
      } catch (e) {
        keys.forEach(key => this[key] = null)
      }

      setTimeout(() => this.isMounted = true)
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
          defaultLocale: 'ru',
          events: {
            animationEnd: (chartContext, config) => this.SET_LOADING(false)
          }
        },
        markers: {
          size: 1,
          discrete: [
            ...this.getChartMarkers(wellsKey, sortKey, 0, 0),
            ...this.getChartMarkers(wellsKey, sortKey, 1, 1)
          ]
        },
        yaxis: this.chartSeries[sortKey].map((chart, index) => {
          let max = Math.max(...chart.data.map(val => Math.abs(val)))

          return {
            show: true,
            min: -max,
            max: max,
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
        fillColor: this[wellsKey][uwiIndex].is_stopped
            ? '#E31F25'
            : '#009847',
        strokeColor: this[wellsKey][uwiIndex].is_stopped
            ? '#E31F25'
            : '#009847',
        size: +this[wellsKey][uwiIndex].is_stopped
            ? markerSize
            : 0,
        shape: "circle"
      }))
    },

    getChartSeries(wellsKey, sortKey) {
      let series = []

      let oil = []

      let operatingProfit = []

      this.sortedUwis[sortKey].forEach((uwi, uwiIndex) => {
        oil.push(+this[wellsKey][uwiIndex].oil)

        operatingProfit.push(+this[wellsKey][uwiIndex].operating_profit)
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