<template>
    <div>
        <div class="d-flex justify-content-begin align-items-center text-white p-1">
            <img class="arrow-back pr-3" src="/img/icons/arrow.svg" @click.stop="$emit('changeScheduleVisible')">
            <div>График оперативной информации</div>
        </div>
        <div class="main-block pb-2">
            <div class="d-flex justify-content-between align-items-center text-white p-2">
                <div class="d-flex">
                    <div>
                        <div class="input-border">
                            <img class="pr-1" src="/img/icons/search.svg" alt="">
                            <input class="search-input" type="text" placeholder="Поиск скважины" />
                        </div>
                    </div>
                    <div class="d-flex align-items-center pl-3">
                        <div>Скважина: {{ well.wellInfo.uwi }}</div>
                        <img src="/img/icons/close.svg" alt="">
                    </div>
                    <div class="d-flex align-items-center pl-3">
                        <img class="pr-1" src="/img/icons/page_to_form.svg" alt="">
                        <div>Cформировать</div>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="d-flex align-items-center">
                        <input type="checkbox">
                        <div class="pl-1">Показывать события</div>
                    </div>
                    <div class="d-flex align-items-center pl-3">
                        <input type="checkbox">
                        <div class="pl-1">Показывать всю историю</div>
                    </div>
                </div>
            </div>
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
            <div class="content-block content-block-scrollable m-2 p-2 rounded-bottom">
                <apexchart
                    ref="chart"
                    :options="chartOptions"
                    :series="chartSeries"
                    :height="745"
                    type="line"/>
            </div>
        </div>
    </div>
</template>
<script>
import chart from "vue-apexcharts";
import {globalloadingMutations} from '@store/helpers';

export default {
    components: {apexchart: chart},
    props: {
        well: {}
    },
    data: () => ({
        currentAnnotation: {
            minY: 0,
            maxY: 0
        },
        chartSeries: [
            {
                name: "Жидкость",
                type: "area",
                data: [100, 800, 900, 1400, 1200, 2100, 2900,
                    100, 800, 900, 1400, 1200, 2100, 2900,
                    100, 800, 900, 1400, 1200, 2100, 2900,
                    100, 800, 900, 1400, 1200, 2100, 2900],
            },
            {
                name: "Нефть",
                type: "area",
                data: [50, 300, 400, 300, 200, 500, 550,
                    50, 300, 400, 300, 200, 500, 550,
                    50, 300, 400, 300, 200, 500, 550,
                    50, 300, 400, 300, 200, 500, 550],
            },
            {
                name: "Обводненность",
                type: "area",
                data: [800, 700, 700, 1000, 450, 2000, 1400,
                    800, 700, 700, 1000, 450, 2000, 1400,
                    800, 700, 700, 1000, 450, 2000, 1400,
                    800, 700, 700, 1000, 450, 2000, 1400],
            },
            {
                name: "Н дин",
                type: "area",
                data: [500, 900, 400, 400, 800, 1800, 1500,
                    500, 900, 400, 400, 800, 1800, 1500,
                    500, 900, 400, 400, 800, 1800, 1500,
                    500, 900, 400, 400, 800, 1800, 1500],
            },
        ],
        chartPoints: [],
        labels: ["22 Март", "29 Март", "5 Апрель", "12 Апрель", "19 Апрель","26 Апрель", "3 Май",
            "10 Май", "17 Май", "24 Май", "31 Май", "7 Июнь", "14 Июнь", "14 Июль",
            "22 Март", "29 Март", "5 Апрель", "12 Апрель", "19 Апрель","26 Апрель", "3 Май",
            "10 Май", "17 Май", "24 Май", "31 Май", "7 Июнь", "14 Июнь", "14 Июль"],
        schedulePeriods: [
            {
                period: "1 неделя",
                value: 7,
            },
            {
                period: "1 месяц",
                value: 30,
            },
            {
                period: "3 месяца",
                value: 90,
            },
            {
                period: "6 месяцев",
                value: 183,
            },
            {
                period: "1 год",
                value: 365,
            },
            {
                period: "Все",
                value: 0,
            },
        ],
        activePeriod: 90,
    }),
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
                }
            }).then(({data}) => {
                this.chartSeries = [
                    data.oil,
                    data.measLiq,
                    data.measWaterCut,
                ];
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
        }
    },
    mounted() {
        this.getSchuduleData();
    },
    computed: {
        chartOptions() {
            return {
                labels: this.labels,
                stroke: {
                    width: 4,
                    curve: 'smooth'
                },
                legend: {
                    position: 'right',
                },
                chart: {
                    stacked: true,
                    foreColor: '#FFFFFF',
                    selection: {
                        enabled: true,
                        type: 'x',
                    },
                    toolbar: {
                        offsetY: -10,
                    }
                },
                markers: {
                    size: 0
                },
                xaxis: {
                    tickAmount: 10,
                },
                yaxis: {
                    opposite: true,
                    labels: {
                        formatter(val) {
                            return Math.round(val);
                        },
                    },
                    title: {
                        text: this.title,
                    },
                    min: 0
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                },
                annotations: {
                    points: this.chartPoints,
                },
            }
        },
    },
}
</script>
<style scoped>
.main-block {
    background-color: rgba(51, 57, 117, 0.33);
}

.input-border {
    background-color: rgba(51, 57, 117, 1);
    border: 0.4px solid #656A8A;
    border-radius: 2px;
}

.input-border input {
    background-color: rgba(51, 57, 117, 1);
    border: none;
}

.content-block {
    background-color: rgba(39, 41, 83, 1);
    line-height: 2rem;
}

.content-block-scrollable {
    height: 70vh;
    overflow-y: scroll;
}

.arrow-back {
    transform: rotate(90deg);
}

.active {
    border-bottom: 2px solid rgba(46, 80, 233, 1);
}
</style>
<style>

.apexcharts-legend {
    justify-content: center !important;
}
</style>