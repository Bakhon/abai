<template>
  <div>
    <div v-for="chart in charts" :key="chart.key">
      <subtitle font-size="18" style="line-height: 26px">
        {{ chart.title }}
      </subtitle>

      <apexchart
          :options="chartOptions(chart.key)"
          :series="chartSeries[chart.key]"
          type="treemap"
          style="color: #000"/>
    </div>
  </div>
</template>

<script>
import chart from "vue-apexcharts";

import Subtitle from "./Subtitle";

const RU = require("apexcharts/dist/locales/ru.json");

const WELL_KEYS = ['oil_12m', 'liquid_12m', 'Operating_profit_12m']

export default {
  name: "TableWellTreeMap",
  components: {
    Subtitle,
    apexchart: chart,
  },
  props: {
    scenario: {
      required: true,
      type: Object
    },
    data: {
      required: true,
      type: Array
    },
  },
  data: () => ({
    selectedWells: []
  }),
  computed: {
    filteredData() {
      return this.data.filter(x =>
          +x.dollar_rate === +this.scenario.dollar_rate &&
          +x.oil_price === +this.scenario.oil_price
      )
    },


    chartSeries() {
      let series = {}

      WELL_KEYS.forEach(key => {
        let data = []

        let colors = []

        this.filteredData.sort((prev, next) => +next[key] - +prev[key]).forEach(well => {
          let value = +well[key]

          colors.push(this.getColor(well))

          data.push({x: well.uwi, y: value})
        })

        series[key] = [{data: data, colors: colors}]
      })

      return series
    },

    charts() {
      return [
        {
          title: this.trans('economic_reference.operating_profit'),
          key: 'Operating_profit_12m'
        },
        {
          title: this.trans('economic_reference.liquid_production'),
          key: 'liquid_12m'
        },
        {
          title: this.trans('economic_reference.oil_production'),
          key: 'oil_12m'
        },
      ]
    }
  },
  methods: {
    selectPoint(key, {seriesIndex, dataPointIndex}) {
      let uwi = this.chartSeries[key][seriesIndex].data[dataPointIndex].x

      let index = this.selectedWells.findIndex(well => well === uwi)

      index === -1
          ? this.selectedWells.push(uwi)
          : this.selectedWells.splice(index, 1);
    },

    getColor(well) {
      if (this.selectedWells.includes(well.uwi)) {
        return '#8125B0'
      }

      return +well.Operating_profit_12m > 0 ? '#13B062' : '#AB130E'
    },

    chartOptions(key) {
      return {
        legend: {
          show: false
        },
        colors: this.chartSeries[key][0].colors,
        plotOptions: {
          treemap: {
            distributed: true,
            enableShades: false,
          }
        },
        chart: {
          foreColor: '#FFFFFF',
          locales: [RU],
          defaultLocale: 'ru',
          events: {
            dataPointSelection: (event, chartContext, config) => this.selectPoint(key, config)
          }
        },
      }
    },
  }
}
</script>

<style scoped>

</style>