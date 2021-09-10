<template>
    <div class="page-wrapper">
        <div class="d-flex p-3">
            <div class="col-4 d-flex justify-content-start">
                <div class="col-6">Динамика добычи нефти</div>
                <select
                        class="form-select col-6"
                        @change="selectedDzo = $event.target.value"
                >
                    <option v-for="company in dzoCompanies" :value="company.ticker">{{company.name}}</option>
                </select>
            </div>
            <div class="col-2"></div>
            <div class="col-6 d-flex justify-content-end">
                <select
                        class="form-select col-2"
                        v-model="selectedDate.format('MMMM')"
                        @change="selectedDate = $event.target.value"
                >
                    <option v-for="month in monthes" :value="month.name">{{month.name}}</option>
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
                        <td>{{summaryMonthlyPlan}}</td>
                        <td>{{summaryMonthlyFact}}</td>
                        <td>{{summaryMonthlyPlan - summaryMonthlyFact}}</td>
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
                        <td>{{day.planDay}}</td>
                        <td>{{day.factDay}}</td>
                        <td>{{day.planDay - day.factDay}}</td>
                        <td>{{day.planMonth}}</td>
                        <td>{{day.factMonth}}</td>
                        <td>{{day.planMonth - day.factMonth}}</td>
                        <td>{{day.planYear}}</td>
                        <td>{{day.factYear}}</td>
                        <td>{{day.planYear - day.factYear}}</td>
                    </tr>
                    <tr class="summary-table">
                        <td>{{selectedDate.format('MMMM')}}</td>
                        <td>{{summaryPlan}}</td>
                        <td>{{summaryFact}}</td>
                        <td>{{summaryPlan - summaryFact}}</td>
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

export default {
    data: function () {
        return {
            selectedDate: moment(),
            selectedDzo: 'ММГ',
            dzoCompanies: [
                {
                    ticker: 'ЭМГ',
                    name: 'АО "Эмбамунайгаз"'
                },
                {
                    ticker: 'КОА',
                    name: 'ТОО "Казахойл Актобе"'
                },
                {
                    ticker: 'КТМ',
                    name: 'ТОО "Казахтуркмунай"'
                },
                {
                    ticker: 'КБМ',
                    name: 'АО "КАРАЖАНБАСМУНАЙ"'
                },
                {
                    ticker: 'КГМ',
                    name: 'ТОО СП "КАЗГЕРМУНАЙ"'
                },
                {
                    ticker: 'ММГ',
                    name: 'АО "Мангистаумунайгаз"'
                },
                {
                    ticker: 'ОМГ',
                    name: 'АО "ОзенМунайГаз"'
                },
                {
                    ticker: 'УО',
                    name: 'ТОО "Урихтау Оперейтинг"'
                },
            ],
            monthes: [],
            tableData: []
        };
    },
    mounted() {
        this.fillMonthes();
        this.fillTableData();
    },
    methods: {
        fillMonthes() {
            for (let i = 0; i < 12; i++) {
                let date = moment().month(i);
                this.monthes.push(
                    {
                        'name': date.format('MMMM'),
                        'dateStart': date.startOf('day').startOf('month').startOf('day'),
                        'dateEnd': date.endOf('month').endOf('day'),
                    }
                );
            }
        },

        fillTableData() {
            for (let i = 1; i <= this.selectedDate.clone().endOf('month').date(); i++) {
                let date = this.selectedDate.clone().date(i).format('DD.MM.YYYY');
                this.tableData.push(
                    {
                        'date': date,
                        'planDay': 0,
                        'factDay': 0,
                        'planMonth': 0,
                        'factMonth': 0,
                        'planYear': 0,
                        'factYear': 0
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
            return moment().month();
        },
        summaryPlan() {
            return 0;
        },
        summaryFact() {
            return 0;
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
</style>