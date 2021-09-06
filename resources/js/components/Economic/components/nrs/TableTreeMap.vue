<template>
  <div>
    <div v-for="chart in charts"
         :key="chart.title"
         :id="chart.title">
    </div>
  </div>
</template>

<script>
import {treemapMixin} from "../../mixins/treemapMixin";

export default {
  name: "TableTreeMap",
  mixins: [treemapMixin],
  props: {
    data: {
      required: true,
      type: Object
    },
  },
  computed: {
    uwis() {
      return Object.keys(this.data.uwis)
    },

    wells() {
      return this.uwis.map(uwi => {
        let well = {uwi: uwi}

        this.charts.forEach(chart => well[chart.key] = this.data.uwis[uwi][chart.key].sum)

        return well
      })
    },

    chartSeries() {
      let series = {}

      this.charts.forEach(chart => {
        let wells = []

        this.wells.forEach(well => {
          let value = +well[chart.key]

          if (chart.hasOwnProperty('positive') && value < 0) return

          if (chart.hasOwnProperty('negative') && value >= 0) return

          let color = this.getColor(well, 'Operating_profit')

          wells.push({
            name: well.uwi,
            value: Math.abs(value),
            fill: color,
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
          title: this.trans('economic_reference.operating_profit') + '+',
          key: 'Operating_profit',
          positive: true
        },
        {
          title: this.trans('economic_reference.operating_profit') + '-',
          key: 'Operating_profit',
          negative: true
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
  }
}
</script>

<style scoped>

</style>