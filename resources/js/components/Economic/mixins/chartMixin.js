const ru = require("apexcharts/dist/locales/ru.json");

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
        isVisibleDefaultSeries: true
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
                        max: Math.max(...this.oilPrices)
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
                series.push({
                    name: this.trans(`economic_reference.wells_${key}`),
                    type: 'area',
                    data: this.data[key]
                })
            })

            return series
        },

        chartKeys() {
            return this.isProfitabilityFull
                ? ['profitable', 'profitless_cat_2', 'profitless_cat_1']
                : ['profitable', 'profitless']
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
                    ...this.colorsInWork,
                    ...this.colorsInPause,
                ],
                chart: {
                    stacked: true,
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
                                : (y) => this.tooltipFormatter(y)
                        }
                    })
                }
            }
        },

        chartYaxis() {
            return this.chartSeries.map((item, index) => {
                return {
                    min: 0,
                    max: index === 1 && index < this.defaultSeries.length
                        ? this.defaultSeries[index].max * 1.3
                        : undefined,
                    show: index === 0 || index === this.defaultSeriesLength,
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
                ? ['#13B062', '#F7BB2E', '#AB130E']
                : ['#13B062', '#AB130E']
        },

        colorsInPause() {
            return this.isProfitabilityFull
                ? ['#0E7D45', '#C49525', '#780D0A']
                : ['#0E7D45', '#780D0A']
        },
    },
    methods: {
        tooltipFormatter(y) {
            if (y === undefined || y === null) {
                return y
            }

            return new Intl.NumberFormat(
                'en-IN',
                {maximumSignificantDigits: 4}
            ).format(y.toFixed(2)) + ` ${this.tooltipText || ''}`;
        },
    }
}