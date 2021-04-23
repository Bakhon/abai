const ru = require("apexcharts/dist/locales/ru.json");

import {GRANULARITY_DAY} from "../components/SelectGranularity";

export const chartInitMixin = {
    props: {
        data: {
            required: true,
            type: Object
        },
        granularity: {
            required: true,
            type: String
        }
    },
    computed: {
        chartSeries() {
            return [
                {
                    name: 'Рентабельные скважины',
                    type: 'area',
                    data: this.data.profitable
                }, {
                    name: 'Условно-рентабельные скважины',
                    type: 'area',
                    data: this.data.profitless_cat_2
                }, {
                    name: 'Нерентабельные скважины',
                    type: 'area',
                    data: this.data.profitless_cat_1
                }
            ]
        },

        chartOptions() {
            return {
                labels: this.data.hasOwnProperty('dt') ? this.data.dt : [],
                stroke: {
                    width: 4,
                    curve: 'smooth'
                },
                colors: ['#13B062', '#F7BB2E', '#AB130E'],
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