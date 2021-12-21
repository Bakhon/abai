<template>
    <div>
        <div class="row content-block m-0 mt-2 mx-2 p-0 rounded-top text-white">
            <div class="col-3">Период:</div>
            <div class="col-6 d-flex justify-content-between">
                <div v-for="period in schedulePeriods"
                     :class="{'active': period.value === activePeriod,
                          'cursor-pointer': period.value !== activePeriod}"
                     @click="changePeriod(period.value)"
                >{{ period.period }}
                </div>
            </div>
            <div class="col-3"></div>
        </div>
        <div class="content-block m-2 p-2 rounded-bottom">
            <apexchart
                    ref="chart"
                    :options="chartOptions"
                    :series="chartSeries"
                    :height="500"
                    type="line"/>
        </div>
    </div>
</template>
<script>
    import chart from "vue-apexcharts";
    import moment from "moment";
    import {globalloadingMutations} from '@store/helpers';

    const ru = require("apexcharts/dist/locales/ru.json");
    export default {
        components: {apexchart: chart},
        props: {
            well: {},
            isShowEvents: Boolean,
            scheduleData: {}
        },
        data: function () {
            return {
                title: '',
                maximumTick: {
                    'hdin': 0,
                    'liqPressure': 0,
                    'liq': 0
                },
                chartSeries: [],
                labels: [],
                yaxis: [                 
                    {
                        seriesName: this.trans('prototype_bd.liquidInjection'),
                        opposite: true,
                        min: 0,
                        max: 0,
                        axisTicks: {
                            show: true,
                        },
                        axisBorder: {
                            show: true,
                            color: 'rgba(69, 77, 125, 1)'
                        },
                        labels: {
                            style: {
                                colors: '#000000',
                            },
                            formatter: function (value) {
                                return value.toFixed(1);
                            }
                        },
                        title: {
                            text: this.trans('prototype_bd.liquidInjection'),
                            style: {
                                color: '#000000',
                            }
                        },
                    },
                    {
                        seriesName: this.trans('prototype_bd.liquidPressure'),
                        opposite: true,
                        min: 0,
                        max: 0,
                        axisTicks: {
                            show: true,
                        },
                        axisBorder: {
                            show: true,
                            color: 'rgba(69, 77, 125, 1)'
                        },
                        labels: {
                            style: {
                                colors: '#000000',
                            },
                            formatter: function (value) {
                                return value.toFixed(1);
                            }
                        },
                        title: {
                            text: this.trans('prototype_bd.liquidPressure'),
                            style: {
                                color: '#000000',
                            }
                        },
                    },
                    {
                        seriesName: this.trans('well_card_graph.events'),
                        opposite: true,
                        min: 0,
                        max: 70,
                        axisTicks: {
                            show: true,
                        },
                        axisBorder: {
                            show: true,
                            color: 'rgba(69, 77, 125, 1)'
                        },
                        title: {
                            text: this.trans('well_card_graph.events')
                        },
                        show: false
                    }
                ],
                schedulePeriods: [
                    {
                        period: "1 " + this.trans('bd.week'),
                        value: 7,
                    },
                    {
                        period: "1 " + this.trans('bd.month'),
                        value: 30,
                    },
                    {
                        period: "3 " + this.trans('bd.month_1'),
                        value: 90,
                    },
                    {
                        period: "6 " + this.trans('bd.month_2'),
                        value: 183,
                    },
                    {
                        period: "1 " + this.trans('bd.year'),
                        value: 365,
                    },
                    {
                        period: this.trans('bd.all_1'),
                        value: 0,
                    },
                ],
                activePeriod: 90,
                colors: ['rgba(255, 0, 0, 1)','rgba(33, 186, 78, 1)', 'rgba(130, 186, 255, 0.7)'],
            }
        },
        methods: {
            ...globalloadingMutations([
                'SET_LOADING'
            ]),
            changePeriod(value) {
                this.activePeriod = value;
                this.getSchuduleData();
            },
            getSchuduleData() {
                this.SET_LOADING(true);
                this.axios.get(this.localeUrl('api/bigdata/wells/production-wells-schedule-data'), {
                    params: {
                        wellId: this.well.id,
                        period: this.activePeriod,
                        type: 'Нагнетательная'
                    }
                }).then(({data}) => {
                    this.chartSeries = [                  
                        data.liquidInjection,
                        data.liquidPressure,
                        data.events
                    ];
                    this.labels = data.labels;
                }).finally(() => {
                    this.SET_LOADING(false);
                });
            },
        },
        mounted() {
            this.chartSeries = this.scheduleData.data;            
            this.labels = this.scheduleData.labels;
            this.title = this.well.name;
        },
        computed: {
            chartOptions() {
                return {
                    title: {
                        text: 'График эксплутации скважины ' + this.title
                    },
                    labels: this.labels,
                    stroke: {
                        width: 1.5,
                        curve: 'smooth'
                    },
                    legend: {
                        position: 'bottom',
                    },
                    chart: {
                        background: 'rgba(255, 255, 255, 1)',
                        foreColor: '#000000',
                        selection: {
                            enabled: false,
                            type: 'x',
                        },
                        toolbar: {
                            offsetY: -10,
                        },
                        locales: [ru],
                        defaultLocale: 'ru',
                        animations: {
                            enabled: false,
                        },
                        dataLabels: {
                            enabled: false
                        },
                    },
                    markers: {
                        size: [0,0,4],
                        strokeWidth: 0,
                        hover: {
                            sizeOffset: 0
                        }
                    },
                    xaxis: {
                        tooltip: {
                            enabled: false
                        },
                        type: 'datetime',
                        labels: {
                            format: 'dd-MM-yyyy',
                        }
                    },
                    yaxis: this.yaxis,
                    tooltip: {
                        custom: ({series, seriesIndex, dataPointIndex, w}) => {
                            let colors = w.globals.colors
                            let style_circle = 'width: 10px;height: 10px;border-radius: 50%;display:inline-block;margin-right:3px'
                            let dateItem = moment(w.globals.initialConfig.labels[dataPointIndex]).format("DD.MM.YYYY");
                            let events = this.chartSeries[2].info[dataPointIndex];
                            if (events && seriesIndex === 2) {
                                let activity = '<div class="arrow_box" style="padding: 3px;line-height: 1rem;">' +
                                    "<span style='display: block;background: #ccc; fontSize: 10px'>" + dateItem + "</span>" +
                                    "<span style='display: block;'><div style='background: " + colors[2] + ";" + style_circle + "'></div>" + events + "</span>" + "</div>";
                                return activity;
                            }
                            return (
                                '<div class="arrow_box" style="padding: 3px;line-height: 1rem;">' +
                                "<span style='display: block;background: #ccc; fontSize: 10px'>" + dateItem + "</span>" +
                                "<span style='display: block;'><b><div style='background: " + colors[0] + ";" + style_circle + "'></div>" + w.globals.initialSeries[0].name + ":</b> " + w.globals.initialSeries[0].data[dataPointIndex].toFixed(1) + "</span>" +
                                "<span style='display: block;'><b><div style='background: " + colors[1] + ";" + style_circle + "'></div>" + w.globals.initialSeries[1].name + ":</b> " + w.globals.initialSeries[1].data[dataPointIndex].toFixed(1) + "</span>" +
                                "</div>");

                        }
                    },
                    colors: this.colors,
                }
            },
        },
        watch: {
            isShowEvents: function (value) {
                this.$refs.chart.toggleSeries('Мероприятия');
            },
            chartSeries: function () {
                if (this.chartSeries.length > 2) {
                    this.maximumTick.liq = _.maxBy(this.chartSeries[0].data, function(o) {
                        return parseFloat(o);
                    });
                    this.maximumTick.liqPressure = _.maxBy(this.chartSeries[1].data, function(o) {
                        return parseFloat(o);
                    });

                    this.maximumTick.liq = Math.round(parseFloat(this.maximumTick.liq) + (parseFloat(this.maximumTick.liq) * 0.1));
                    this.maximumTick.liqPressure = Math.round(parseFloat(this.maximumTick.liqPressure) + (parseFloat(this.maximumTick.liqPressure) * 0.1));
                    this.yaxis[0].max = this.maximumTick.liq;
                    this.yaxis[1].max = this.maximumTick.liqPressure;
                }
            }
        }
    }
</script>
<style scoped>

    ::-webkit-scrollbar {
        height: 10px;
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background: #40467E;
    }

    ::-webkit-scrollbar-thumb {
        background: #656A8A;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #656A8A;
    }

    ::-webkit-scrollbar-corner {
        background: #20274F;
    }

    .content-block {
        background-color: rgba(39, 41, 83, 1);
        line-height: 2rem;
    }

    .content-block-scrollable {
        height: 70vh;
        overflow-y: scroll;
    }

    .active {
        border-bottom: 2px solid rgba(46, 80, 233, 1);
    }
    .apexcharts-legend {
        justify-content: center !important;
    }
</style>