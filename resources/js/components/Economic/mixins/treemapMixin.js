import {formatValueMixin} from "./formatMixin";
import {waterCutMixin} from "./wellMixin";

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
    mixins: [
        formatValueMixin,
        waterCutMixin
    ],
    data: () => ({
        chartTrees: [],
        loadingTreemap: true
    }),
    computed: {
        wells() {
            return []
        },

        profitabilityKey() {
            return 'Operating_profit'
        },

        waterCutKey() {
            return 'water_cut'
        },

        charts() {
            return []
        },

        chartsSum() {
            let sum = {}

            this.charts.forEach(chart => {
                sum[chart.title] = {
                    profitable: 0,
                    profitless: 0,
                    profitableCount: 0,
                    profitlessCount: 0,
                }
            })

            this.wells.forEach(well => {
                let sumKey = +well[this.profitabilityKey] > 0 ? 'profitable' : 'profitless'

                this.charts.forEach(chart => {
                    let value = +well[chart.key]

                    if (chart.hasOwnProperty('positive') && value <= 0) return

                    if (chart.hasOwnProperty('negative') && value > 0) return

                    sum[chart.title][sumKey] += value

                    sum[chart.title][`${sumKey}Count`] += 1
                })
            })

            let chartWaterCut = this.charts.find(chart => chart.key === this.waterCutKey)

            if (chartWaterCut && chartWaterCut.hasSubtitle) {
                let chartLiquid = this.charts.find(chart => chart.key === 'liquid')

                let chartOil = this.charts.find(chart => chart.key === 'oil')

                sum[chartWaterCut.title].profitable = this.calcWaterCut(
                    sum[chartLiquid.title].profitable,
                    sum[chartOil.title].profitable
                )

                sum[chartWaterCut.title].profitless = this.calcWaterCut(
                    sum[chartLiquid.title].profitless,
                    sum[chartOil.title].profitless
                )
            }

            return sum
        },

        chartSeries() {
            let series = {}

            this.charts.forEach(chart => series[chart.title] = [])

            this.wells.forEach(well => {
                this.charts.forEach(chart => {
                    let value = +well[chart.key]

                    if (chart.hasOwnProperty('positive') && value <= 0) return

                    if (chart.hasOwnProperty('negative') && value > 0) return

                    let color = this.getColor(well)

                    series[chart.title].push({
                        name: well.uwi,
                        value: Math.abs(value),
                        fill: this.selectedWells.includes(well.uwi) ? SELECTED_COLOR : color,
                        fillOriginal: color
                    })
                })
            })

            return series
        },
    },
    async mounted() {
        await loadScript('/anychart/anychart-core.min.js')

        await loadScript('/anychart/anychart-treemap.min.js')

        this.plotCharts()
    },
    methods: {
        plotCharts() {
            this.loadingTreemap = true

            this.charts.forEach((chart, index) => {
                this.chartTrees[index] = anychart.data.tree([{
                    children: this.chartSeries[chart.title]
                }], "as-tree")

                let treemap = anychart.treeMap(this.chartTrees[index])

                treemap.title().useHtml(true);

                treemap.title(this.getChartTitle(chart));

                treemap.listen("pointDblClick", (event) => this.selectPoint(event, index))

                treemap.labels().useHtml(true);

                treemap.labels().format(function () {
                    return `<span style="color: #fff; font-weight: bold"> ${this.name} </span>`
                });

                treemap.tooltip().format(function () {
                    return `${this.value.toLocaleString()}`
                });

                treemap.container(chart.title)

                treemap.hovered().fill(SELECTED_COLOR)

                treemap.selected().fill(SELECTED_COLOR)

                if (chart.sort) {
                    treemap.sort(chart.sort)
                }

                treemap.draw()

                treemap.listenOnce('chartDraw', () => this.loadingTreemap = false);
            })
        },

        getColor(well) {
            return +well[this.profitabilityKey] > 0 ? '#13B062' : '#AB130E'
        },

        getChartSubtitle({title, isShowCount, hasSubtitle, hasPercent, dimension, dimensionTitle}) {
            if (!hasSubtitle || !this.chartsSum[title]) {
                return ''
            }

            let name = ''

            let subTitles = ['profitable', 'profitless']

            subTitles.forEach(profitability => {
                let text = this.trans(`economic_reference.${profitability}`)

                if (isShowCount) {
                    profitability += 'Count'
                }

                let value = this.localeValue(
                    +this.chartsSum[title][profitability],
                    dimension,
                    false,
                    0
                )

                if (this.chartsSum[title][profitability]) {
                    name += `<br> ${text}: ${value} `

                    if (dimensionTitle) {
                        name += dimensionTitle
                    }
                }
            })

            return name
        },

        getChartTitle(chart) {
            let subtitle = this.getChartSubtitle(chart)

            let title = `<div style="font-size: 20px"> ${chart.title} </div>`

            if (subtitle) {
                title += `<div style="font-size: 16px">${subtitle}</div>`
            }

            return title
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