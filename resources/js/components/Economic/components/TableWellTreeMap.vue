<template>
  <div>
    <div v-for="chart in charts"
         :key="chart.title"
         :id="chart.title">
    </div>
  </div>
</template>

<script>
import {SELECTED_COLOR, treemapMixin} from "../mixins/treemapMixin";

export default {
  name: "TableWellTreeMap",
  mixins: [treemapMixin],
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
  computed: {
    filteredData() {
      return this.data.filter(x =>
          +x.dollar_rate === +this.scenario.dollar_rate &&
          +x.oil_price === +this.scenario.oil_price
      )
    },

    stoppedWells() {
      return JSON.parse(this.scenario.uwi_stop)
    },

    chartSeries() {
      let series = {}

      this.charts.forEach(chart => {
        let data = []

        this.filteredData.forEach(well => {
          let value = +well[chart.key]

          if (chart.hasOwnProperty('positive') && value < 0) return

          if (chart.hasOwnProperty('negative') && value >= 0) return

          let color = this.getColor(well, 'Operating_profit_12m')

          data.push({
            name: well.uwi,
            value: Math.abs(value),
            fill: this.stoppedWells.includes(well.uwi) ? SELECTED_COLOR : color,
            fillOriginal: color
          })
        })

        series[chart.title] = data
      })

      return series
    },

    charts() {
      return [
        {
          title: this.trans('economic_reference.operating_profit') + '-',
          key: 'Operating_profit_12m',
          negative: true
        },
        {
          title: this.trans('economic_reference.operating_profit') + '+',
          key: 'Operating_profit_12m',
          positive: true
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
    },
  },
}
</script>

<style scoped>

</style>