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
    },
    computed: {
        isProfitabilityFull() {
            return this.profitability === PROFITABILITY_FULL
        },

        chartSeries() {
            return this.isProfitabilityFull
                ? [
                    {
                        name: this.trans('economic_reference.wells_profitable'),
                        type: 'area',
                        data: this.data.profitable
                    },
                    {
                        name: this.trans('economic_reference.wells_profitless_cat_2'),
                        type: 'area',
                        data: this.data.profitless_cat_2
                    }, {
                        name: this.trans('economic_reference.wells_profitless_cat_1'),
                        type: 'area',
                        data: this.data.profitless_cat_1
                    }
                ]
                : [
                    {
                        name: this.trans('economic_reference.wells_profitable'),
                        type: 'area',
                        data: this.data.profitable
                    },
                    {
                        name: this.trans('economic_reference.wells_profitless_cat_1'),
                        type: 'area',
                        data: this.data.profitless
                    },
                ]
        },

        chartOptions() {
            return {
                labels: this.data.hasOwnProperty('dt') ? this.data.dt : [],
                stroke: {
                    width: 4,
                    curve: 'smooth'
                },
                colors: this.isProfitabilityFull
                    ? ['#13B062', '#F7BB2E', '#AB130E']
                    : ['#13B062', '#AB130E'],
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
            }
        },
    },
}