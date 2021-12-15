const ru = require("apexcharts/dist/locales/ru.json");

const PROFITLESS_PROFITABILITIES = [
    'profitless',
    'profitless_cat_1',
    'profitless_cat_2',
]

import {GRANULARITY_DAY} from "../components/SelectGranularity";
import {PROFITABILITY_FULL} from "../nrs/components/SelectProfitability";

export const chartInitMixin = {
    props: {
        data: {
            required: true,
            type: Object
        },
        granularity: {
            required: true,
            type: String
        },
        profitability: {
            required: true,
            type: String
        },
        oilPrices: {
            required: true,
            type: Array
        },
        dollarRates: {
            required: true,
            type: Array
        },
        form: {
            required: true,
            type: Object
        }
    },
    data: () => ({
        isVisibleDefaultSeries: true,
        isVisibleInWork: true,
        isVisibleInPause: false,
        isStacked: true,
    }),
    computed: {
        isProfitabilityFull() {
            return this.profitability === PROFITABILITY_FULL
        },

        defaultSeries() {
            let series = []

            if (this.isVisibleDefaultSeries) {
                series.push(
                    {
                        name: this.trans('economic_reference.course_prices'),
                        type: 'line',
                        data: this.dollarRates,
                        defaultColor: '#B629FE'
                    },
                    {
                        name: this.trans('economic_reference.oil_price'),
                        type: 'line',
                        data: this.oilPrices,
                        defaultColor: '#FC35B0',
                    }
                )
            }

            return series
        },

        defaultColors() {
            return this.defaultSeries.map(x => x.defaultColor)
        },

        defaultSeriesLength() {
            return this.defaultSeries.length
        },

        chartSeries() {
            let series = [...this.defaultSeries]

            this.chartKeys.forEach(key => {
                series.push(this.chartArea(key, this.data))
            })

            return series
        },

        chartKeys() {
            return this.isProfitabilityFull
                ? ['profitable', 'profitless_cat_2', 'profitless_cat_1'].reverse()
                : ['profitable', 'profitless'].reverse()
        },

        chartOptions() {
            return {
                labels: this.data.hasOwnProperty('dt')
                    ? this.data.dt
                    : [],
                stroke: {
                    width: 4,
                    curve: 'smooth'
                },
                colors: [
                    ...this.defaultColors,
                    ...(this.isVisibleInPause ? this.colorsInPause : this.colorsInWork),
                    ...this.colorsInWork,
                ],
                chart: {
                    stacked: false,
                    foreColor: '#FFFFFF',
                    locales: [ru],
                    defaultLocale: 'ru'
                },
                markers: {
                    size: 0
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%'
                    }
                },
                xaxis: {
                    type: this.granularity === GRANULARITY_DAY
                        ? 'datetime'
                        : 'date'
                },
                yaxis: this.chartYaxis,
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: (y, config) => this.tooltipFormatter(y, config)
                    }
                },
                fill: {
                    opacity: 0.9,
                }
            }
        },

        chartYaxis() {
            return this.chartSeries.map((chart, index) => {
                return {
                    min: 0,
                    show: index <= 1 || index === this.defaultSeriesLength,
                    showAlways: index === this.defaultSeriesLength,
                    opposite: index < this.defaultSeriesLength && this.defaultSeriesLength,
                    seriesName: index < this.defaultSeriesLength
                        ? this.defaultSeries[index].name
                        : this.chartSeriesName,
                    title: {
                        text: index < this.defaultSeriesLength
                            ? this.defaultSeries[index].name
                            : this.title,
                    },
                    labels: {
                        formatter: (value) => this.labelsFormatter(value)
                    },
                }
            })
        },

        chartSeriesName() {
            return this.trans(`economic_reference.wells_${this.chartKeys[0]}`)
        },

        colorsInWork() {
            return this.isProfitabilityFull
                ? ['#13B062', '#F7BB2E', '#AB130E'].reverse()
                : ['#13B062', '#AB130E'].reverse()
        },

        colorsInPause() {
            return this.isProfitabilityFull
                ? ['#0E7D45', '#C49525', '#780D0A'].reverse()
                : ['#0E7D45', '#780D0A'].reverse()
        },

        chartHeight() {
            return this.form.isFullScreen ? 680 : 560
        },

        tooltipText() {
            return ''
        },
    },
    methods: {
        tooltipFormatter(value, {dataPointIndex, seriesIndex}) {
            let tooltipText = ''

            if (seriesIndex >= this.defaultSeriesLength) {
                value = this.chartSeries[seriesIndex].tooltipData[dataPointIndex]

                tooltipText = this.tooltipText
            }

            if (value && +value.toFixed(2) !== 0) {
                value = +value.toFixed(2)
            }

            return `${value.toLocaleString()} ${tooltipText}`
        },

        labelsFormatter(value) {
            return (+value.toFixed(0)).toLocaleString()
        },

        chartArea(
            profitability,
            wells,
            pausedWells = null,
            chartType = 'area'
        ) {
            let name = this.trans(`economic_reference.wells_${profitability}`)

            if (pausedWells) {
                name += ` ${this.trans('economic_reference.in_pause').toLowerCase()}`

                if (!this.isVisibleInWork) {
                    wells = pausedWells

                    pausedWells = null
                }
            }

            switch (profitability) {
                case "profitable":
                    return {
                        name: name,
                        type: chartType,
                        data: pausedWells
                            ? pausedWells[profitability].map((value, index) => {
                                if (!this.isStacked) {
                                    return value
                                }

                                if (wells.hasOwnProperty('profitable') && wells.profitable[index]) {
                                    value += wells.profitable[index]
                                }

                                PROFITLESS_PROFITABILITIES.forEach(profitless => {
                                    if (wells.hasOwnProperty(profitless)) {
                                        value += (wells[profitless][index] || 0)
                                    }
                                })

                                return value
                            })
                            : wells[profitability],
                        tooltipData: pausedWells
                            ? pausedWells[profitability]
                            : wells[profitability],
                    }
                case "profitless":
                case "profitless_cat_2":
                    return {
                        name: name,
                        profitability: profitability,
                        type: chartType,
                        data: pausedWells
                            ? pausedWells[profitability].map((value, index) => {
                                if (!this.isStacked) {
                                    return value
                                }

                                if (wells.hasOwnProperty('profitable') && wells.profitable[index]) {
                                    value += wells.profitable[index]
                                }

                                if (pausedWells.hasOwnProperty('profitable') && pausedWells.profitable[index]) {
                                    value += pausedWells.profitable[index]
                                }

                                PROFITLESS_PROFITABILITIES.forEach(profitless => {
                                    if (wells.hasOwnProperty(profitless)) {
                                        value += (wells[profitless][index] || 0)
                                    }
                                })

                                return value
                            })
                            : wells[profitability].map((value, index) => {
                                if (!this.isStacked) {
                                    return value
                                }

                                if (wells.hasOwnProperty('profitable') && wells.profitable[index]) {
                                    value += wells.profitable[index]

                                }

                                return value
                            }),
                        tooltipData: pausedWells
                            ? pausedWells[profitability]
                            : wells[profitability],
                    }
                case "profitless_cat_1":
                    return {
                        name: name,
                        profitability: profitability,
                        type: chartType,
                        data: pausedWells
                            ? pausedWells[profitability].map((value, index) => {
                                if (!this.isStacked) {
                                    return value
                                }

                                if (wells.hasOwnProperty('profitable') && wells.profitable[index]) {
                                    value += wells.profitable[index]
                                }

                                if (pausedWells.hasOwnProperty('profitable') && pausedWells.profitable[index]) {
                                    value += pausedWells.profitable[index]
                                }

                                if (pausedWells.hasOwnProperty('profitless_cat_2') && pausedWells.profitless_cat_2[index]) {
                                    value += pausedWells.profitless_cat_2[index]
                                }

                                PROFITLESS_PROFITABILITIES.forEach(profitless => {
                                    if (wells.hasOwnProperty(profitless)) {
                                        value += (wells[profitless][index] || 0)
                                    }
                                })

                                return value
                            })
                            : wells[profitability].map((value, index) => {
                                if (!this.isStacked) {
                                    return value
                                }

                                if (wells.hasOwnProperty('profitable') && wells.profitable[index]) {
                                    value += wells.profitable[index]
                                }

                                if (wells.hasOwnProperty('profitless_cat_2') && wells.profitless_cat_2[index]) {
                                    value += wells.profitless_cat_2[index]
                                }

                                return value
                            }),
                        tooltipData: pausedWells
                            ? pausedWells[profitability]
                            : wells[profitability],
                    }
            }
        },
    }
}