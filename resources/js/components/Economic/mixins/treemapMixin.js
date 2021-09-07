export async function loadScript(path) {
    return new Promise((resolve) => {
        let script = document.createElement('script')

        script.onload = () => resolve()

        script.async = true

        script.src = path

        document.head.appendChild(script)
    })
}

export const SELECTED_COLOR = "#8125B0"

export const treemapMixin = {
    data: () => ({
        chartTrees: []
    }),
    computed: {
        charts() {
            return []
        }
    },
    async mounted() {
        await loadScript('/anychart/anychart-core.min.js')

        await loadScript('/anychart/anychart-treemap.min.js')

        this.plotCharts()
    },
    methods: {
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

                treemap.hovered().fill(SELECTED_COLOR)

                treemap.selected().fill(SELECTED_COLOR)

                treemap.draw()
            })
        },

        getColor(well, key) {
            return +well[key] > 0 ? '#13B062' : '#AB130E'
        },

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
    }
}