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
  name: "TableTreeMap",
  props: {
    data: {
      required: true,
      type: Object
    },
  },
  data: () => ({
    chartTrees: []
  }),
  async mounted() {
    await loadScript('/anychart/anychart-core.min.js')

    await loadScript('/anychart/anychart-treemap.min.js')

    this.plotCharts()
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
        let data = []

        this.wells.forEach(well => {
          let value = +well[chart.key]

          if (chart.hasOwnProperty('positive') && value < 0) return

          if (chart.hasOwnProperty('negative') && value >= 0) return

          let color = this.getColor(well)

          data.push({
            name: well.uwi,
            value: Math.abs(value),
            fill: color,
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

    getColor(well) {
      return +well.Operating_profit > 0 ? '#13B062' : '#AB130E'
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
  }
}
</script>

<style scoped>

</style>