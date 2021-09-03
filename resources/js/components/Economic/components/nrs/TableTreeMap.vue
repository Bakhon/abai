<template>
  <div class="text-white">
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

import Subtitle from "../Subtitle";

const RU = require("apexcharts/dist/locales/ru.json");

const WELL_KEYS = ['oil', 'liquid', 'Operating_profit']

export default {
  name: "TableTreeMap",
  components: {
    Subtitle,
    apexchart: chart,
  },
  props: {
    data: {
      required: true,
      type: Object
    },
  },
  data: () => ({
    selectedWells: []
  }),
  computed: {
    uwis() {
      return Object.keys(this.data.uwis)
    },

    wells() {
      return this.uwis.map(uwi => {
        let well = {uwi: uwi}

        WELL_KEYS.forEach(key => well[key] = this.data.uwis[uwi][key].sum)

        return well
      })
    },

    sortedWells() {
      return WELL_KEYS.map(key => {
        return {
          key: key,
          wells: this.wells.sort((prev, next) => +next[key] - +prev[key])
        }
      })
    },

    chartSeries() {
      let series = {}

      this.sortedWells.forEach(item => {
        let data = []

        let colors = []

        item.wells.forEach(well => {
          colors.push(this.getColor(well))

          data.push({x: well.uwi, y: +well[item.key]})
        })

        series[item.key] = [{data: data, colors: colors}]
      })

      return series
    },

    charts() {
      return [
        {
          title: this.trans('economic_reference.operating_profit'),
          key: 'Operating_profit'
        },
        {
          title: this.trans('economic_reference.liquid_production'),
          key: 'liquid'
        },
        {
          title: this.trans('economic_reference.oil_production'),
          key: 'oil'
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

      return +well.Operating_profit > 0 ? '#13B062' : '#AB130E'
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