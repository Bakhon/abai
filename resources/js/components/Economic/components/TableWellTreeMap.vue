<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      {{ trans('economic_reference.table_well_treemap') }}
    </subtitle>

    <apexchart
        :options="chartOptions"
        :series="chartSeries"
        type="treemap"
        style="color: #000"/>
  </div>
</template>

<script>
import chart from "vue-apexcharts";

import Subtitle from "./Subtitle";

const ru = require("apexcharts/dist/locales/ru.json");

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
          locales: [ru],
          defaultLocale: 'ru',
          events: {
            dataPointSelection: (event, chartContext, config) => this.selectPoint(config)
          }
        },
      }
    },

    chartSeries() {
      return [
        {
          data: this.filteredData.map(well => {
            return {
              x: well.uwi,
              y: well.Operating_profit_12m,
            }
          })
        }
      ]
    },
  },
  methods: {
    selectPoint({seriesIndex, dataPointIndex}) {
      let uwi = this.chartSeries[seriesIndex].data[dataPointIndex].x

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