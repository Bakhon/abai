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

    chartSeries() {
      let series = {}

      this.charts.forEach(chart => {
        let wells = []

        this.filteredData.forEach(well => {
          let value = +well[chart.key]

          if (chart.hasOwnProperty('positive') && value < 0) return

          if (chart.hasOwnProperty('negative') && value >= 0) return

          let color = this.getColor(well, 'Operating_profit_12m')

          wells.push({
            name: well.uwi,
            value: Math.abs(value),
            fill: this.scenario.uwi_stop.includes(well.uwi) ? SELECTED_COLOR : color,
            fillOriginal: color
          })
        })

        series[chart.title] = wells
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
          key: 'liquid_12m',
          hasSubtitle: true,
        },
        {
          title: this.trans('economic_reference.oil_production'),
          key: 'oil_12m',
          hasSubtitle: true,
        },
      ]
    },
  },
}
</script>

<style scoped>

</style>