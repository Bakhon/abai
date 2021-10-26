<template>
    <div >
        <div class="row content-block m-0 mt-2 mx-2 p-0 rounded-top text-white">
            <div class="col-3">Период:</div>
            <div class="col-6 d-flex justify-content-between">
                <div v-for="period in schedulePeriods"
                     :class="{'active': period.value === activePeriod,
                          'cursor-pointer': period.value !== activePeriod}"
                     @click="changePeriod(period.value)"
                >{{ period.period }}</div>
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
import {globalloadingMutations} from '@store/helpers';

const ru = require("apexcharts/dist/locales/ru.json");
export default {
    components: {apexchart: chart},
    props: {
        well: {},
        isShowEvents: Boolean
    },
    data: function() {
        return {
            title: '',
            chartSeries: [],
            chartPoints: [],
            tmpChartPoints: [],
            labels: [],
            yaxis: [
            {
              seriesName: this.trans('app.liquid'),
              opposite: true,
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
                text: this.trans('app.liquidOil'),
                style: {
                  color: '#000000',
                }
              },
            },
            {
              seriesName: this.trans('app.oil'),
              labels: {
                formatter: function (value) {
                  return value.toFixed(1);
                }
              },
              show: false
            },
            {
              seriesName: this.trans('app.waterCut'),
              opposite: true,
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
                text: this.trans('app.waterCut'),
                style: {
                  color: '#000000',
                }
              },
            },
            {
              seriesName: this.trans('app.ndin'),
              opposite: true,
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
                text: this.trans('app.ndin'),
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
            colors:['rgba(33, 186, 78, 1)', 'rgba(130, 186, 255, 0.7)', 'rgba(72, 81, 95, 1)', 'rgba(255, 0, 0, 1)', 'rgba(230, 230, 0, 1)']
        }
    },
    methods: {
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        randomRgba(min,max){
           let r = this.randomNumber(min,max)
           let g = this.randomNumber(min,max)
           let b = this.randomNumber(min,max)
           return 'rgba('+r+','+g+','+b+',1)'
        },
        randomNumber(min,max)
        {
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
                }
            }).then(({data}) => {
                this.chartSeries = [
                    data.ndin,
                    data.measLiq,
                    data.oil,
                    data.measWaterCut,
                    data.events
                ];

                window.Apex.events = data.events;
                if (data.wellStatuses) {
                    this.chartPoints = [];
                    data.wellStatuses.forEach(status => {
                        this.chartPoints.push({
                            x: status[0],
                            y: 0,
                            marker: {
                                size: 10,
                                fillColor: '#fff'
                            },
                            label: {
                                text: status[2],
                                style: {
                                    color: '#000'
                                }
                            }
                        });
                    });
                }
                this.labels = data.labels;
            }).finally(() => {
                this.SET_LOADING(false);
            });
        },
    },
    mounted() {
        this.getSchuduleData();
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
                    position: 'right',
                },
                chart: {
                    background: 'rgba(255, 255, 255, 1)',
                    foreColor: '#000000',
                    selection: {
                        enabled: true,
                        type: 'x',
                    },
                    toolbar: {
                        offsetY: -10,
                    },
                    locales: [ru],
                    defaultLocale: 'ru',
                },
                xaxis: {
                    type: 'datetime',
                    tickAmount: 10,
                    labels: {
                        format: 'dd-MM-yyyy',
                    }
                },
                yaxis: this.yaxis,
                tooltip: {
                    custom: function({ series, seriesIndex, dataPointIndex, w }) {
                    let colors = w.globals.colors
                    let style_circle = 'width: 10px;height: 10px;border-radius: 50%;display:inline-block;margin-right:3px'
                    let dateItem = ''
                    let events = window.Apex.events
                      console.log(events)
                    let events_hint = events.info[dataPointIndex]
                    return (
                        '<div class="arrow_box" style="padding: 3px">' +
                        "<span style='display: block;background: #ccc'>" + dateItem + "</span>" +
                        "<span style='display: block;'><b><div style='background: "+colors[0]+";"+style_circle+"'></div>" + w.globals.initialSeries[0].name + ":</b> " + w.globals.initialSeries[0].data[dataPointIndex].toFixed(1) + "</span>" +
                        "<span style='display: block;'><b><div style='background: "+colors[1]+";"+style_circle+"'></div>" + w.globals.initialSeries[1].name + ":</b> " + w.globals.initialSeries[1].data[dataPointIndex].toFixed(1) + "</span>" +
                        "<span style='display: block;'><b><div style='background: "+colors[2]+";"+style_circle+"'></div>" + w.globals.initialSeries[2].name + ":</b> " + w.globals.initialSeries[2].data[dataPointIndex].toFixed(1) + "</span>" +
                        "<span style='display: block;'><b><div style='background: "+colors[3]+";"+style_circle+"'></div>" + w.globals.initialSeries[3].name + ":</b> " + w.globals.initialSeries[3].data[dataPointIndex].toFixed(1) + "</span>" +
                        "<span style='display: block;'><div style='background: "+colors[4]+";"+style_circle+"'></div>"
                          + events_hint+
                         "</span>"+
                        "</div>"
                    );

                  }
                },
                annotations: {
                    points: this.chartPoints,
                },
                colors:this.colors,
            }
        },
    },
    watch: {
        isShowEvents: function (value) {
            if (value) {
                this.chartPoints = this.tmpChartPoints;
            } else {
                this.tmpChartPoints = this.chartPoints;
                this.chartPoints = [];
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
</style>
<style>
.apexcharts-legend {
    justify-content: center !important;
}</style>