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
                    'oil': 0,
                    'waterCut': 110,
                    'liq': 0
                },
                chartSeries: [],
                labels: [],
                yaxis: [
                    {
                        seriesName: this.trans('app.ndin'),
                        opposite: true,
                        min: 0,
                        max: 0,
                        reversed: true,
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
                                return value ? value.toFixed(1) : "";
                            }
                        },
                        title: {
                            text: this.trans('app.ndin'),
                            style: {
                                color: '#000000',
                            }
                        },
                    },
                    {
                        seriesName: this.trans('prototype_bd.liquid'),
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
                                return value ? value.toFixed(1) : "";
                            }
                        },
                        title: {
                            text: this.trans('prototype_bd.liquid'),
                            style: {
                                color: '#000000',
                            }
                        },
                    },
                    {
                        seriesName: this.trans('prototype_bd.oil'),
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
                            formatter: function (value) {
                                return value ? value.toFixed(1) : "";
                            }
                        },
                        title: {
                            text: this.trans('prototype_bd.oil'),
                            style: {
                                color: '#000000',
                            }
                        },
                    },
                    {
                        seriesName: this.trans('app.waterCut'),
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
                                return value ? value.toFixed(1) : "";
                            }
                        },
                        title: {
                            text: this.trans('app.waterCut'),
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
                colors: ['rgba(255, 0, 0, 1)', 'rgba(130, 186, 255, 0.7)', 'rgba(72, 81, 95, 1)', 'rgba(33, 186, 78, 1)', 'rgba(230, 230, 0, 1)'],
            }
        },
        methods: {
            ...globalloadingMutations([
                'SET_LOADING'
            ]),
            randomRgba(min, max) {
                let r = this.randomNumber(min, max)
                let g = this.randomNumber(min, max)
                let b = this.randomNumber(min, max)
                return 'rgba(' + r + ',' + g + ',' + b + ',1)'
            },
            randomNumber(min, max) {
                return Math.floor(Math.random() * (max - min + 1)) + min
            },
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
                        type: 'Нефтяная'
                    }
                }).then(({data}) => {
                    this.chartSeries = [
                        data.ndin,
                        data.measLiq,
                        data.oil,
                        data.measWaterCut,
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
                        text: this.title
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
                        size: [0,0,0,0,4],
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
                            let events = this.chartSeries[4].info[dataPointIndex];
                            if (events && seriesIndex === 4) {
                                let output = '';
                                if (events !== null) {
                                    let formatted = events.slice(1,-1).slice(1,-1);
                                    formatted = formatted.replace(/(['"])?([a-z0-9A-Z_]+)(['"])?:/g, '"$2": ');
                                    let parsed = JSON.parse(formatted);
                                    output = parsed.name_type + '<br>';
                                    for (let i in parsed.parameters) {
                                        output = output + ' - ' + parsed.parameters[i].name + ' : ' + parsed.parameters[i].value + ', <br>';
                                    }
                                }
                                let activity = '<div class="arrow_box" style="padding: 3px;line-height: 1rem;">' +
                                    "<span style='display: block;background: #ccc; fontSize: 10px'>" + dateItem + "</span>" +
                                    "<span style='display: block;'><div style='background: " + colors[4] + ";" + style_circle + "'></div>" + output + "</span>" + "</div>";
                                return activity;
                            }

                            return (
                                '<div class="arrow_box" style="padding: 3px;line-height: 1rem;">' +
                                "<span style='display: block;background: #ccc; fontSize: 10px'>" + dateItem + "</span>" +
                                "<span style='display: block;'><b><div style='background: " + colors[0] + ";" + style_circle + "'></div>" + w.globals.initialSeries[0].name + ":</b> " + w.globals.initialSeries[0].data[dataPointIndex].toFixed(1) + "</span>" +
                                "<span style='display: block;'><b><div style='background: " + colors[1] + ";" + style_circle + "'></div>" + w.globals.initialSeries[1].name + ":</b> " + w.globals.initialSeries[1].data[dataPointIndex].toFixed(1) + "</span>" +
                                "<span style='display: block;'><b><div style='background: " + colors[2] + ";" + style_circle + "'></div>" + w.globals.initialSeries[2].name + ":</b> " + w.globals.initialSeries[2].data[dataPointIndex].toFixed(1) + "</span>" +
                                "<span style='display: block;'><b><div style='background: " + colors[3] + ";" + style_circle + "'></div>" + w.globals.initialSeries[3].name + ":</b> " + w.globals.initialSeries[3].data[dataPointIndex].toFixed(1) + "</span>" +
                                "</div>"
                            );

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
                    this.maximumTick.hdin = _.maxBy(this.chartSeries[0].data, function(o) {
                        return parseFloat(o);
                    });
                    this.maximumTick.liq = _.maxBy(this.chartSeries[1].data, function(o) {
                        return parseFloat(o);
                    });
                    this.maximumTick.oil = _.maxBy(this.chartSeries[2].data, function(o) {
                        return parseFloat(o);
                    });

                    this.maximumTick.hdin = Math.round(parseFloat(this.maximumTick.hdin) + (parseFloat(this.maximumTick.hdin) * 0.1));
                    this.maximumTick.oil = Math.round(parseFloat(this.maximumTick.oil) + (parseFloat(this.maximumTick.oil) * 0.1));
                    this.yaxis[0].max = this.maximumTick.hdin;
                    this.yaxis[1].max = this.maximumTick.liq;
                    this.yaxis[2].max = this.maximumTick.oil*3;
                    this.yaxis[3].max = this.maximumTick.waterCut;
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