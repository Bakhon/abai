const ru = require("apexcharts/dist/locales/ru.json");

const PROFITLESS_PROFITABILITIES = [
    'profitless',
    'profitless_cat_1',
    'profitless_cat_2',
]

import {GRANULARITY_DAY} from "../components/SelectGranularity";
import {PROFITABILITY_FULL} from "../components/SelectProfitability";

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
        tooltipText: {
            required: false,
            type: String,
        },
    },
    data: () => ({
        isVisibleDefaultSeries: true,
        isVisibleInWork: true,
        isVisibleInPause: false,
    }),
    computed: {
        isProfitabilityFull() {
            return this.profitability === PROFITABILITY_FULL
        },

        defaultSeries() {
            return this.isVisibleDefaultSeries ?
                [
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
                ]
                : []
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
                    y: this.chartSeries.map((item, index) => {
                        return {
                            formatter: index < this.defaultSeriesLength
                                ? (y) => y
                                : (y, config) => this.tooltipFormatter(y, config)
                        }
                    })
                },
                fill: {
                    opacity: 0.9,
                }
            }
        },

        chartYaxis() {
            return this.chartSeries.map((item, index) => {
                return {
                    min: 0,
                    show: index <= 1 || index === this.defaultSeriesLength,
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
                        formatter: (val) => Math.round(val)
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
    },
    methods: {
        tooltipFormatter(value, {dataPointIndex, seriesIndex}) {
            value = this.chartSeries[seriesIndex].tooltipData[dataPointIndex]

            return new Intl.NumberFormat(
                'en-IN',
                {maximumSignificantDigits: 4}
            ).format(value.toFixed(2)) + ` ${this.tooltipText || ''}`;
        },

        chartArea(profitability, wells, pausedWells = null) {
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
                        type: 'area',
                        data: pausedWells
                            ? pausedWells[profitability].map((value, index) => {
                                let sum = value + wells.profitable[index]

                                PROFITLESS_PROFITABILITIES.forEach(profitless => {
                                    if (wells.hasOwnProperty(profitless)) {
                                        sum += wells[profitless][index]
                                    }
                                })

                                return sum
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
                        type: 'area',
                        data: pausedWells
                            ? pausedWells[profitability].map((value, index) => {
                                let sum = value
                                    + wells.profitable[index]
                                    + pausedWells.profitable[index]

                                PROFITLESS_PROFITABILITIES.forEach(profitless => {
                                    if (wells.hasOwnProperty(profitless)) {
                                        sum += wells[profitless][index]
                                    }
                                })

                                return sum
                            })
                            : wells[profitability].map((value, index) => {
                                return value + wells.profitable[index]
                            }),
                        tooltipData: pausedWells
                            ? pausedWells[profitability]
                            : wells[profitability],
                    }
                case "profitless_cat_1":
                    return {
                        name: name,
                        profitability: profitability,
                        type: 'area',
                        data: pausedWells
                            ? pausedWells[profitability].map((value, index) => {
                                let sum = value
                                    + wells.profitable[index]
                                    + pausedWells.profitable[index]
                                    + pausedWells.profitless_cat_2[index]

                                PROFITLESS_PROFITABILITIES.forEach(profitless => {
                                    if (wells.hasOwnProperty(profitless)) {
                                        sum += wells[profitless][index]
                                    }
                                })

                                return sum
                            })
                            : wells[profitability].map((value, index) => {
                                return value
                                    + wells.profitable[index]
                                    + wells.profitless_cat_2[index]
                            }),
                        tooltipData: pausedWells
                            ? pausedWells[profitability]
                            : wells[profitability],
                    }
            }
        },
    }
}