<template>
  <div>
    <div v-for="chart in charts"
         :key="chart.title"
         :id="chart.title">
    </div>
  </div>
</template>

<script>
async function loadScript(path) {
  return new Promise((resolve) => {
    let script = document.createElement('script')

    script.onload = () => resolve()

    script.async = true

    script.src = path

    document.head.appendChild(script)
  })
}

const SELECTED_COLOR = "#8125B0"

export default {
  name: "TableWellTreeMap",
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
    chartTrees: []
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

      this.charts.forEach(chart => {
        let data = []

        this.filteredData.forEach(well => {
          let value = +well[chart.key]

          if (chart.hasOwnProperty('positive') && value < 0) return

          if (chart.hasOwnProperty('negative') && value >= 0) return

          let color = this.getColor(well)

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

    stoppedWells() {
      return JSON.parse(this.scenario.uwi_stop)
    }
  },
  async mounted() {
    await loadScript('/anychart/anychart-core.min.js')

    await loadScript('/anychart/anychart-treemap.min.js')

    this.plotCharts()
  },
  methods: {
    selectPoint(event, index) {
      let well = this.chartTrees[index].getChildAt(0).getChildAt(event.pointIndex - 1)

      let currentColor = well.get('fill')

      let originalColor = well.get('fillOriginal')

      let newColor = currentColor === originalColor ? SELECTED_COLOR : originalColor

      well.set('fill', newColor)

      this.chartTrees.forEach((tree, treeIndex) => {
        if (index === treeIndex) return

        let item = tree.search('name', well.get('name'))

        if (!item) return

        item.set("fill", newColor)
      })
    },

    selectStoppedWells() {
      let wells = JSON.parse(this.scenario.uwi_stop)

      wells.forEach(well => {
        this.chartTrees.forEach(tree => {
          let item = tree.search('name', well)

          if (!item) return

          item.set("fill", SELECTED_COLOR)
        })
      })
    },

    getColor(well) {
      return +well.Operating_profit_12m > 0 ? '#13B062' : '#AB130E'
    },

    plotCharts() {
      this.charts.forEach((chart, index) => {
        this.chartTrees[index] = anychart.data.tree([{
          name: chart.title,
          children: this.chartSeries[chart.title]
        }], "as-tree")

        let treemap = anychart.treeMap(this.chartTrees[index])

        treemap.listen("pointDblClick", (event) => this.selectPoint(event, index))

        treemap.labels().useHtml(true);

        treemap.labels().format(function () {
          return `<span style="color: #fff; font-weight: bold"> ${this.name} </span>`
        });

        treemap.container(chart.title)

        treemap.hovered().fill('')

        treemap.selected().fill('')

        treemap.draw()
      })
    },
  },
  watch: {
    'scenario.percent_stop_cat_1'(newVal) {
      this.selectStoppedWells()
    },

    'scenario.percent_stop_cat_2'(newVal) {
      this.selectStoppedWells()
    },
  }
}
</script>

<style scoped>

</style>