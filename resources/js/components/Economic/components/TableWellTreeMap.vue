<template>
  <div>
    <div v-for="chart in charts" :key="chart.key">
      <subtitle font-size="18" style="line-height: 26px">
        {{ chart.title }}
      </subtitle>

      <apexchart
          :options="chartOptions"
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

    chartColors() {
      return this.filteredData.map(well => {
        if (this.selectedWells.includes(well.uwi)) {
          return '#8125B0'
        }

        return +well.Operating_profit_12m > 0 ? '#13B062' : '#AB130E'
      })
    },

    chartOptions() {
      return {
        legend: {
          show: false
        },
        colors: this.chartColors,
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
            dataPointSelection: (event, chartContext, config) => this.selectPoint(config)
          }
        },
      }
    },

    chartSeries() {
      let series = {}

      WELL_KEYS.forEach(key => series[key] = [{data: []}])

      this.filteredData.forEach(well => {
        WELL_KEYS.forEach(key => {
          series[key][0].data.push({x: well.uwi, y: well[key]})
        })
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
    selectPoint({seriesIndex, dataPointIndex}) {
      let uwi = this.chartSeries.oil_12m[seriesIndex].data[dataPointIndex].x

      let index = this.selectedWells.findIndex(well => well === uwi)

      index === -1
          ? this.selectedWells.push(uwi)
          : this.selectedWells.splice(index, 1);
    }
  }
}
</script>

<style scoped>

</style>