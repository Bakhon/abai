<template>
    <div class="page-wrapper">
        <div class="row pl-3 mr-0">
            <div class="col-11 title pb-2">
                {{ trans('visualcenter.oilCondensateDynamic') }}
            </div>
            <div class="col-1 mt-2 text-left">
                <label
                        @mouseover="isHoverActive = true"
                        @mouseout="isHoverActive = false"
                        class="switch"
                >
                    <input type="checkbox" class="form-check-input" v-model="isCorrectedFactActive" @change="updateDailyView">
                    <span class="slider round"></span>
                </label>
                <span v-show="isHoverActive" class="hovered-tooltip">
                    <span v-if="isCorrectedFactActive">{{ trans('visualcenter.withoutCorrectedFact') }}</span>
                    <span v-else>{{ trans('visualcenter.withCorrectedFact') }}</span>

                </span>
            </div>
            <div class="col-4 p-0 ml-3">
                <select
                        class="form-select dropdown_list text-left"
                        @change="handleDzo($event.target.value)"
                >
                    <option v-for="company in dzoCompanies" :value="company.id">{{company.name}}</option>
                </select>
            </div>
            <div class="col-4">
                <select
                        class="form-select dropdown_list text-center"
                        v-model="selectedMonth"
                        @change="handleMonth($event.target.value)"
                >
                    <option v-for="month in monthes" :value="month.id">{{month.name}}</option>
                </select>
            </div>
        </div>
        <div class="d-flex px-3 pt-3 daily-chart">
            <daily-chart class="col-8 pr-0" :chartData="dailyProductionChart"></daily-chart>
            <div class="col-2 py-3 info-block ml-3 mb-1">
                <div class="inform-buttons">
                    {{ trans('visualcenter.deviation') }}<br>
                    <div class="d-flex justify-content-center">
                        <span :class="[summaryFact - summaryPlan < 0 ? 'fall-indicator-production-data' : 'growth-indicator-production-data','triangle']"></span>
                        <span class="pl-2">{{getFormattedNumber(summaryFact - summaryPlan)}}</span>
                    </div>
                </div>
            </div>
            <div class="col-2 py-3 info-block mb-1">
                <div class="inform-buttons">
                    {{ trans('visualcenter.execution') }}<br>
                    <div class="d-flex justify-content-center">
                        <span :class="[summaryExecution < 100 ? 'triangle fall-indicator-production-data' : 'triangle growth-indicator-production-data','triangle']"></span>
                        <span class="pl-2">{{summaryExecution.toFixed(1)}}% </span>
                    </div>
                </div>
            </div>

        </div>
        <div class="d-flex pl-3">
            <table class="col-8 dynamic-table">
                <thead>
                <tr>
                    <th rowspan="2">{{ trans('visualcenter.date') }}</th>
                    <th colspan="3">{{ trans('visualcenter.daily') }}</th>
                    <th colspan="3">{{ trans('visualcenter.monthBegin') }}</th>
                    <th colspan="3">{{ trans('visualcenter.yearBegin') }}</th>
                </tr>
                <tr>
                    <th>{{ trans('visualcenter.Plan') }}</th>
                    <th>{{ trans('visualcenter.Fact') }}</th>
                    <th>{{ trans('visualcenter.deviation') }}</th>
                    <th>{{ trans('visualcenter.Plan') }}</th>
                    <th>{{ trans('visualcenter.Fact') }}</th>
                    <th>{{ trans('visualcenter.deviation') }}</th>
                    <th>{{ trans('visualcenter.Plan') }}</th>
                    <th>{{ trans('visualcenter.Fact') }}</th>
                    <th>{{ trans('visualcenter.deviation') }}</th>
                </tr>
                </thead>
                <tbody>
                    <tr
                            v-for="(day, index) in tableData"
                            :class="getRowClass(index)"
                    >
                        <td>{{day.date}}</td>
                        <td>{{getFormattedNumber(day.planDay)}}</td>
                        <td>{{getFormattedNumber(day.factDay)}}</td>
                        <td :class="day.factDay - day.planDay < 0 ? 'color__red' : 'color__green'">{{getFormattedNumber(day.factDay - day.planDay)}}</td>
                        <td>{{getFormattedNumber(day.planMonth)}}</td>
                        <td>{{getFormattedNumber(day.factMonth)}}</td>
                        <td :class="day.factMonth - day.planMonth < 0 ? 'color__red' : 'color__green'">{{getFormattedNumber(day.factMonth - day.planMonth)}}</td>
                        <td>{{getFormattedNumber(day.planYear)}}</td>
                        <td>{{getFormattedNumber(day.factYear)}}</td>
                        <td :class="day.factYear - day.planYear < 0 ? 'color__red' : 'color__green'">{{getFormattedNumber(day.factYear - day.planYear)}}</td>
                    </tr>
                </tbody>
            </table>
            <div class="col-4 row m-0 px-0">
                <chart class="col-12" :name="dailyChartName" :chartData="dailyChart" :is-daily="true"></chart>
                <chart class="col-12" :name="yearlyChartName" :chartData="yearlyChart" :is-daily="false"></chart>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import {globalloadingMutations} from '@store/helpers';
import Vue from "vue";
Vue.component('chart', require('./chart.vue').default);
Vue.component('daily-chart', require('./dailyChart.vue').default);

export default {
    data: function () {
        return {
            dailyChartName: this.trans('visualcenter.oilDynamicDaily') + ' (' + this.trans('visualcenter.chemistryMetricTon') + ')',
            yearlyChartName: this.trans('visualcenter.accumulatedOilDynamicYearly') + ' (' + this.trans('visualcenter.dzoThousandTon') + ')',
            selectedMonth: moment().month() + 1,
            selectedDzo: {
                id: 17,
                ticker: '??????????',
                name: this.trans('visualcenter.nkKmg'),
            },
            dzoCompanies: [
                {
                    id: 17,
                    ticker: '??????????',
                    name: this.trans('visualcenter.nkKmg'),
                },
                {
                    id: 18,
                    ticker: '??????????????',
                    name: this.trans('visualcenter.nkKmgOperating'),
                },
                {
                    id: 7,
                    ticker: '??????',
                    name: this.trans('visualcenter.omg'),
                },
                {
                    id: 8,
                    ticker: '????????',
                    name: this.trans('visualcenter.consolidatedDzoNameMappingWithoutKMG.OMGK') + ' (' + this.trans('visualcenter.condensate') + ')',
                },
                {
                    id: 6,
                    ticker: '??????',
                    name: this.trans('visualcenter.mmg'),
                },
                {
                    id: 1,
                    ticker: '??????',
                    name: this.trans('visualcenter.emg'),
                },
                {
                    id: 4,
                    ticker: '??????',
                    name: this.trans('visualcenter.kbm'),
                },
                {
                    id: 5,
                    ticker: '??????',
                    name: this.trans('visualcenter.kgm'),
                },
                {
                    id: 3,
                    ticker: '??????',
                    name: this.trans('visualcenter.ktm'),
                },
                {
                    id: 2,
                    ticker: '??????',
                    name: this.trans('visualcenter.koa'),
                },
                {
                    id: 9,
                    ticker: '????',
                    name: this.trans('visualcenter.consolidatedDzoNameMappingWithoutKMG.YO'),
                },
                {
                    id: 16,
                    ticker: '??????',
                    name: this.trans('visualcenter.tsho'),
                },
                {
                    id: 15,
                    ticker: '??????',
                    name: this.trans('visualcenter.nko'),
                },
                {
                    id: 14,
                    ticker: '??????',
                    name: this.trans('visualcenter.kpo'),
                },
                {
                    id: 11,
                    ticker: '??????',
                    name: this.trans('visualcenter.pki'),
                },
                {
                    id: 12,
                    ticker: '??????',
                    name: this.trans('visualcenter.pkk'),
                },
                {
                    id: 13,
                    ticker: '????',
                    name: this.trans('visualcenter.tp'),
                },
                {
                    id: 10,
                    ticker: '????',
                    name: this.trans('visualcenter.consolidatedDzoNameMappingWithoutKMG.AG'),
                }
            ],
            monthes: [],
            tableData: [],
            summaryData: [],
            chartDataTemplate: {
                series: [
                    {
                        'name': '????????',
                        'type': 'line',
                        'data': []
                    },
                    {
                        'name': '????????',
                        'type': 'line',
                        'data': []
                    },
                ],
                labels: []
            },
            dailyProductionChartTemplate: {
                series: [],
                labels: [
                    this.trans("visualcenter.Plan"),
                    this.trans("visualcenter.Fact"),
                ]
            },
            isCorrectedFactActive: true,
            isHoverActive: false
        };
    },
    async mounted() {
        if (moment().date() === 1) {
            this.selectedMonth = this.selectedMonth - 1;
        }
        this.fillMonthes();
        this.updateDailyView();
    },
    methods: {
        async getDaily() {
            let uri = this.localeUrl("/oil-dynamic-daily");
            let queryOptions = {
                'month': this.selectedMonth,
                'type' : this.selectedDzo.ticker,
                'isCorrectedFactActive': this.isCorrectedFactActive
            };
            const response = await axios.get(uri,{params:queryOptions});
            if (response.status !== 200) {
                return {};
            }
            return response.data;
        },

        async updateDailyView() {
            this.SET_LOADING(true);
            this.tableData = await this.getDaily();
            this.SET_LOADING(false);
        },

        async handleMonth(value) {
            this.selectedMonth = value;
            this.updateDailyView();
        },

        async handleDzo(value) {
            this.SET_LOADING(true);
            let filteredDzo = _.filter(_.cloneDeep(this.dzoCompanies), (dzo) => dzo.id == value);
            this.selectedDzo = filteredDzo[0];
            this.updateDailyView();
            this.SET_LOADING(false);
        },

        fillMonthes() {
            for (let i = 0; i < this.selectedMonth; i++) {
                let date = moment().month(i);
                this.monthes.push(
                    {
                        'name': date.format('MMMM'),
                        'id': date.month() + 1
                    }
                );
            }
        },

        getRowClass(index) {
            if (index % 2 === 0) {
                return 'background__light';
            } else {
                return 'background__dark';
            }
        },

        ...globalloadingMutations([
            'SET_LOADING'
        ]),

        getFormattedNumber(num) {
            return (new Intl.NumberFormat("ru-RU").format(Math.round(num)))
        },
    },
    computed: {
        summaryPlan() {
            return _.sumBy(this.tableData, 'planDay');
        },
        summaryFact() {
            return _.sumBy(this.tableData, 'factDay');
        },
        summaryExecution() {
            return this.summaryFact / this.summaryPlan * 100;
        },
        dailyChart() {
            let chartData = _.cloneDeep(this.chartDataTemplate);
            _.forEach(this.tableData, (dayData) => {
                chartData.series[0].data.push(parseInt(dayData['factDay']));
                chartData.series[1].data.push(parseInt(dayData['planDay']));
                chartData.labels.push(dayData['date']);
            });
            return chartData;
        },
        yearlyChart() {
            let chartData = _.cloneDeep(this.chartDataTemplate);
            _.forEach(this.tableData, (dayData) => {
                chartData.series[0].data.push(parseInt(dayData['factYear']));
                chartData.series[1].data.push(parseInt(dayData['planYear']));
                chartData.labels.push(dayData['date']);
            });
            return chartData;
        },
        dailyProductionChart() {
            let chartData = _.cloneDeep(this.dailyProductionChartTemplate);
            chartData.series.push(this.summaryPlan,this.summaryFact);
            return chartData;
        }
    }
}
</script>

<style scoped lang="scss">
.page-wrapper {
    font-family: HarmoniaSansProCyr-Regular, Harmonia-sans;
    position: relative;
    min-height: calc(100vh - 78px);
    background: #272953;
    color: white;
    text-align: center;
    font-size: 16px;
}
.dynamic-table {
    width: 100%;
    tr:last-child {
        th {
            width: 115px;
        }
    }
    th {
        background: #2E50E9;
        border: 1px solid #272953;
    }
    td {
        border-right: 1px solid #696e96;
        &:not(:first-child) {
            font-weight: bold;
        }
    }
}
.month-summary-table {
    width: 100%;
    table-layout: fixed;
    tr:first-child, tr:nth-child(2) {
        th:first-child {
            background: inherit;
        }
    }
    th {
        background: #2E50E9;
        border-right: 1px solid #272953;
    }
    td {
        border: 1px solid #696e96 !important;
    }
}
.background__dark {
    background: #e6e6e6;
    color: black;
}
.background__light {
    background: white;
    color: black;
}
.summary-table {
    td {
        border: 1px solid #696e96 !important;
    }
    background: #333975;
}
.summary-execution {
    td {
        border: 1px solid #696e96 !important;
    }
    background: #333975;
    td:first-child {
        background: #272953;
        border: unset !important;
    }
}
.color__red {
    color: #E31E24;
}
.color__green {
    color: #00b353;
}
.dropdown_list {
    background-color: #333975;
    height: 40px;
    color: #9ea4c9;
    border: none;
    width: 100%;
}
.inform-buttons {
    background-color: #333975;
    text-align: center;
    height: 100%;
    font-size: 26px;
    border-radius: 10px;
    span {
        font-family: "Bold";
        font-size: 34px;
        font-weight: 550;
        &:last-child {
            font-size: 45px;
        }
    }
}
.info-block {
    margin-top: -20px;
}
.title {
    font-size: 20px;
    font-weight: bold;
}
.triangle {
    border: 16px solid transparent;
    margin-top: 30px;
}
.growth-indicator-production-data {
    border-top: 16px solid #009846;
}
.fall-indicator-production-data {
    border-top: 16px solid #e31e24;
}
.daily-chart {
    margin-bottom: -5px;
}
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked + .slider {
    background-color: #2196F3;
}

input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
.hovered-tooltip {
    background: #272953;
    z-index: 1000;
    position: absolute;
    margin-left: -200px;
    margin-top: 40px;
    border: 1px solid #575975;
    border-radius: 5px;
    padding: 5px;
    text-align: center;
}
</style>