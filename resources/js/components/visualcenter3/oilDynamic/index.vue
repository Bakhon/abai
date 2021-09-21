<template>
    <div class="page-wrapper">
        <div class="row p-3">
            <div class="col-12">
                Динамика суточной добычи нефти и конденсата, тонн
            </div>
            <div class="col-3 p-3">
                <select
                        class="form-select dropdown_list"
                        @change="handleDzo($event.target.value)"
                >
                    <option v-for="company in dzoCompanies" :value="company.id">{{company.name}}</option>
                </select>
            </div>
            <div class="col-3 p-3">
                <select
                        class="form-select dropdown_list"
                        v-model="selectedMonth"
                        @change="handleMonth($event.target.value)"
                >
                    <option v-for="month in monthes" :value="month.id">{{month.name}}</option>
                </select>
            </div>
        </div>
        <div class="row p-3">
            <daily-chart class="col-10" :chartData="dailyProductionChart"></daily-chart>
            <div class="col-1 p-3 info-block">
                <div class="inform-buttons">
                    Отклонение<br>
                    <span>
                        {{getFormattedNumber(summaryFact - summaryPlan)}}
                    </span>
                </div>
            </div>
            <div class="col-1 p-3 info-block">
                <div class="inform-buttons">
                    Выполнение<br>
                    <span>
                        {{summaryExecution.toFixed(1)}}%
                    </span>
                </div>
            </div>

        </div>
        <div class="d-flex p-3">
            <table class="col-8 dynamic-table">
                <thead>
                <tr>
                    <th rowspan="2">Дата</th>
                    <th colspan="3">Суточная</th>
                    <th colspan="3">С начала месяца</th>
                    <th colspan="3">С начала года</th>
                </tr>
                <tr>
                    <th>План</th>
                    <th>Факт</th>
                    <th>Отклонение</th>
                    <th>План</th>
                    <th>Факт</th>
                    <th>Отклонение</th>
                    <th>План</th>
                    <th>Факт</th>
                    <th>Отклонение</th>
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
            <div class="col-4 row">
                <chart class="col-12" :name="dailyChartName" :chartData="dailyChart"></chart>
                <chart class="col-12" :name="yearlyChartName" :chartData="yearlyChart"></chart>
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
            dailyChartName: 'Динамика суточной добычи нефти',
            yearlyChartName: 'Динамика накопленной добычи нефти с начала года',
            selectedMonth: moment().month() + 1,
            selectedDzo: {
                id: 1,
                ticker: 'ЭМГ',
                name: 'АО "Эмбамунайгаз"'
            },
            dzoCompanies: [
                {
                    id: 1,
                    ticker: 'ЭМГ',
                    name: 'АО "Эмбамунайгаз"',
                },
                {
                    id: 2,
                    ticker: 'КОА',
                    name: 'ТОО "Казахойл Актобе"',
                },
                {
                    id: 3,
                    ticker: 'КТМ',
                    name: 'ТОО "Казахтуркмунай"',
                },
                {
                    id: 4,
                    ticker: 'КБМ',
                    name: 'АО "КАРАЖАНБАСМУНАЙ"',
                },
                {
                    id: 5,
                    ticker: 'КГМ',
                    name: 'ТОО СП "КАЗГЕРМУНАЙ"',
                },
                {
                    id: 6,
                    ticker: 'ММГ',
                    name: 'АО "Мангистаумунайгаз"',
                },
                {
                    id: 7,
                    ticker: 'ОМГ',
                    name: 'АО "ОзенМунайГаз"',
                },
                {
                    id: 8,
                    ticker: 'ОМГ',
                    name: 'АО "ОзенМунайГаз" Конденсат',
                },
                {
                    id: 9,
                    ticker: 'УО',
                    name: 'ТОО "Урихтау Оперейтинг"',
                },
                {
                    id: 10,
                    ticker: 'АГ',
                    name: 'ТОО "Амангельды Газ"',
                },
                {
                    id: 11,
                    ticker: 'ПКИ',
                    name: 'АО "ПетроКазахстан Инк."',
                },
                {
                    id: 12,
                    ticker: 'ПКК',
                    name: 'АО "ПетроКазахстан Кумколь Ресорсиз"',
                },
                {
                    id: 13,
                    ticker: 'ТП',
                    name: 'АО "Тургай-Петролеум"',
                },
                {
                    id: 14,
                    ticker: 'КПО',
                    name: 'Карачаганак Петролеум Оперейтинг б.в.',
                },
                {
                    id: 15,
                    ticker: 'НКО',
                    name: 'Норт Каспиан Оперейтинг Компани',
                },
                {
                    id: 16,
                    ticker: 'НККМГ',
                    name: 'НК КМГ (консолид.)',
                },
                ,
                {
                    id: 17,
                    ticker: 'НККМГОП',
                    name: 'Опер. активы НК КМГ (консолид.)',
                },
            ],
            monthes: [],
            tableData: [],
            summaryData: [],
            chartDataTemplate: {
                series: [
                    {
                        'name': 'Факт',
                        'type': 'line',
                        'data': []
                    },
                    {
                        'name': 'План',
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
            }
        };
    },
    async mounted() {
        this.fillMonthes();
        this.updateDailyView();
    },
    methods: {
        async getDaily() {
            let uri = this.localeUrl("/oil-dynamic-daily");
            let queryOptions = {
                'month': this.selectedMonth
            };
            const response = await axios.get(uri,{params:queryOptions});
            if (response.status !== 200) {
                return {};
            }
            return response.data;
        },

        async updateDailyView() {
            this.SET_LOADING(true);
            this.summaryData = await this.getDaily();
            this.tableData = this.summaryData[this.selectedDzo.ticker];
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
            this.tableData = this.summaryData[this.selectedDzo.ticker];
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
    text-align: center;
    color: #9ea4c9;
    border: none;
    width: 100%;
}
.inform-buttons {
    background-color: #333975;
    text-align: center;
    padding-top: 15px;
    height: 100%;
    span {
        font-size: 26px;
    }
}
.info-block {
    margin-top: -40px;
}
</style>