<template>
    <div class="page-wrapper">
        <div class="d-flex p-3">
            <div class="col-4 d-flex justify-content-start">
                <div class="col-6">Динамика добычи нефти</div>
                <select
                        class="form-select col-6"
                        @change="handleDzo($event.target.value)"
                >
                    <option v-for="company in dzoCompanies" :value="company.id">{{company.name}}</option>
                </select>
            </div>
            <div class="col-2"></div>
            <div class="col-6 d-flex justify-content-end">
                <select
                        class="form-select col-2"
                        v-model="selectedMonth"
                        @change="handleMonth($event.target.value)"
                >
                    <option v-for="month in monthes" :value="month.id">{{month.name}}</option>
                </select>
                <div class="col-2">(тонн)</div>
            </div>
        </div>
        <div class="d-flex justify-content-end p-3">
            <table class="col-6 month-summary-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>План</th>
                        <th>Факт</th>
                        <th>Отклонение</th>
                        <th>Выполнение</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{monthsPassed}} мес.</td>
                        <td>{{getFormattedNumber(yearlyData.planYear)}}</td>
                        <td>{{getFormattedNumber(yearlyData.factYear)}}</td>
                        <td :class="yearlyData.factYear - yearlyData.planYear < 0 ? 'color__red' : 'color__green'">{{getFormattedNumber(yearlyData.factYear - yearlyData.planYear)}}</td>
                        <td>{{summaryMonthlyExecution}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex p-3">
            <table class="col-8 dynamic-table">
                <thead>
                <tr>
                    <th></th>
                    <th colspan="3">Суточная</th>
                    <th colspan="3">С начала месяца</th>
                    <th colspan="3">С начала года</th>
                </tr>
                <tr>
                    <th></th>
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
                    <tr class="summary-table">
                        <td>{{selectedDate}}</td>
                        <td>{{getFormattedNumber(summaryPlan)}}</td>
                        <td>{{getFormattedNumber(summaryFact)}}</td>
                        <td :class="summaryFact - summaryPlan < 0 ? 'color__red' : 'color__green'">{{getFormattedNumber(summaryFact - summaryPlan)}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import {globalloadingMutations} from '@store/helpers';

export default {
    data: function () {
        return {
            selectedDate: moment().format('MMMM'),
            selectedMonth: moment().month() + 1,
            selectedDzo: {
                id: 1,
                ticker: 'ЭМГ',
                name: 'АО "Эмбамунайгаз"',
                factName: 'oil_production_fact',
                planName: 'plan_oil'
            },
            dzoCompanies: [
                {
                    id: 1,
                    ticker: 'ЭМГ',
                    name: 'АО "Эмбамунайгаз"',
                    factName: 'oil_production_fact',
                    planName: 'plan_oil'
                },
                {
                    id: 2,
                    ticker: 'КОА',
                    name: 'ТОО "Казахойл Актобе"',
                    factName: 'oil_production_fact',
                    planName: 'plan_oil'
                },
                {
                    id: 3,
                    ticker: 'КТМ',
                    name: 'ТОО "Казахтуркмунай"',
                    factName: 'oil_production_fact',
                    planName: 'plan_oil'
                },
                {
                    id: 4,
                    ticker: 'КБМ',
                    name: 'АО "КАРАЖАНБАСМУНАЙ"',
                    factName: 'oil_production_fact',
                    planName: 'plan_oil'
                },
                {
                    id: 5,
                    ticker: 'КГМ',
                    name: 'ТОО СП "КАЗГЕРМУНАЙ"',
                    factName: 'oil_production_fact',
                    planName: 'plan_oil'
                },
                {
                    id: 6,
                    ticker: 'ММГ',
                    name: 'АО "Мангистаумунайгаз"',
                    factName: 'oil_production_fact',
                    planName: 'plan_oil'
                },
                {
                    id: 7,
                    ticker: 'ОМГ',
                    name: 'АО "ОзенМунайГаз"',
                    factName: 'oil_production_fact',
                    planName: 'plan_oil'
                },
                {
                    id: 8,
                    ticker: 'ОМГ',
                    name: 'АО "ОзенМунайГаз" Конденсат',
                    planName: 'plan_kondensat',
                    factName: 'condensate_production_fact'
                },
                {
                    id: 9,
                    ticker: 'УО',
                    name: 'ТОО "Урихтау Оперейтинг"',
                    factName: 'oil_production_fact',
                    planName: 'plan_oil'
                },
                {
                    id: 10,
                    ticker: 'АГ',
                    name: 'ТОО "Амангельды Газ"',
                    planName: 'plan_kondensat',
                    factName: 'condensate_production_fact'
                },
                {
                    id: 11,
                    ticker: 'ПКИ',
                    name: 'АО "ПетроКазахстан Инк."',
                    planName: 'plan_oil',
                    factName: 'oil_production_fact'
                },
            ],
            monthes: [],
            tableData: [],
            summaryData: [],
            yearlyData: {}
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
                'dzo': this.selectedDzo.ticker,
                'month': this.selectedMonth,
                'planField': this.selectedDzo.planName,
                'factField': this.selectedDzo.factName,
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
            console.log(this.summaryData);
            this.tableData = this.summaryData.tableData;
            this.yearlyData = this.summaryData.yearlyData;
            this.SET_LOADING(false);
        },

        async handleMonth(value) {
            this.selectedMonth = value;
            this.updateDailyView();
        },

        async handleDzo(value) {
            let filteredDzo = _.filter(_.cloneDeep(this.dzoCompanies), (dzo) => dzo.id == value);
            this.selectedDzo = filteredDzo[0];
            this.updateDailyView();
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
        summaryMonthlyPlan() {
            return 0;
        },
        summaryMonthlyFact() {
            return 0;
        },
        summaryMonthlyExecution() {
            return 0;
        },
        monthsPassed() {
            return this.selectedMonth - 1;
        },
        summaryPlan() {
            return _.sumBy(this.tableData, 'planDay');
        },
        summaryFact() {
            return _.sumBy(this.tableData, 'factDay');
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
    tr:first-child, tr:nth-child(2) {
        th:first-child {
            background: inherit;
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
        border-right: 1px solid #696e96;
    }
    background: #333975;
}
.color__red {
    color: #E31E24;
}
.color__green {
    color: #00b353;
}
</style>