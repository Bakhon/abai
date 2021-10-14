<template>
    <div class="main-block">
        <div class="row">
            <div class="col-12 d-flex header justify-content-between">
                <div class="col-11 p-2">Исторические сведения по добыче нефти</div>
                <div class="col-1 cancel-icon" @click="SET_VISIBLE_PRODUCTION(false)"></div>
            </div>
            <div class="col-12 p-0 left-block">
                <table class="historical-table">
                    <thead>
                        <tr>
                            <th rowspan="2">Год</th>
                            <th colspan="2">Добыча за<br>период</th>
                            <th colspan="3">Ср. сут. показатели за период</th>
                            <th rowspan="2">Отработанное<br>время</th>
                        </tr>
                        <tr>
                            <th>Жидкость<br>(м3)</th>
                            <th>Нефть<br>(т)</th>
                            <th>Дебит<br>жидкости<br>(м3/сут.)</th>
                            <th>Обводненность<br>(%)</th>
                            <th>Дебит нефти<br>(т/сут.)</th>
                        </tr>
                        </thead>
                    <tbody>
                        <tr v-for="(date,index) in dates" v-if="date.isVisible">
                            <td>
                                <label v-if="date.month === null" class="form-check-label" @click="handleYearSelect(date,index)">{{date.year}}</label>
                                <label v-else class="form-check-label">{{date.month}}</label>
                                <span class="ml-1"></span>
                                <input class="ml-2" type="checkbox" v-model="date.isChecked" @click="handleDateSelect(date,index)">
                            </td>
                            <td>{{date.water.toFixed(2)}}</td>
                            <td v-if="date.oil !== null && date.oil > 0">{{date.oil.toFixed(1)}}</td>
                            <td v-else>{{date.oil}}</td>
                            <td>{{date.waterDebit.toFixed(1)}}</td>
                            <td>{{date.waterCut.toFixed(0)}}</td>
                            <td>{{date.oilDebit.toFixed(1)}}</td>
                            <td>{{(date.hoursWorked).toFixed(0)}} дн.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import {bigdatahistoricalVisibleMutations,bigdatahistoricalVisibleState} from '@store/helpers';

export default {
    props: {
        changeColumnsVisible: Function,
    },
    data() {
        return {
            dates: [],
            selectedDates: [],
            monthMapping: {
                1: 'Январь',
                2: 'Февраль',
                3: 'Март',
                4: 'Апрель',
                5: 'Май',
                6: 'Июнь',
                7: 'Июль',
                8: 'Август',
                9: 'Сентябрь',
                10: 'Октябрь',
                11: 'Ноябрь',
                12: 'Декабрь'
            }
        };
    },
    methods: {
        ...bigdatahistoricalVisibleMutations([
            'SET_VISIBLE_PRODUCTION','SET_PRODUCTION_HISTORICAL_PERIOD'
        ]),
        handleYearSelect(date) {
            _.forEach(this.dates, (item) => {
                if (item.month !== null && parseInt(item.year) === date.year) {
                    item.isVisible = !item.isVisible;
                }
            });
        },
        handleDateSelect(date,parentIndex) {
            let filtered = [];
            if (date.id.toString().length === 4) {
                _.forEach(this.dates, (item) => {
                    if (item.month !== null && parseInt(item.year) === date.year) {
                        item.isChecked = !item.isChecked;
                    }
                });
                filtered = _.filter(this.dates, (item) => item.isChecked && item.month !== null);
            } else {
                this.dates[parentIndex].isChecked = !this.dates[parentIndex].isChecked;
                filtered = _.filter(this.dates, (item) => item.isChecked && item.month !== null);
            }
            this.selectedDates = filtered;
            this.SET_PRODUCTION_HISTORICAL_PERIOD(this.selectedDates);
        },
        fillDates() {
            for (let i = 2008; i <= 2021; i++) {
                let obj = {
                    'id': i,
                    'month': null,
                    'year': i,
                    'isChecked': false,
                    'isVisible': true,
                    'water': 0,
                    'oil': 0,
                    'waterDebit': 0,
                    'waterCut': 0,
                    'oilDebit': 0,
                    'hoursWorked': 0,
                    'params': {
                        'techMode': [
                            {
                                'label': 'Жидкость',
                                'value': 0,
                            },
                            {
                                'label': 'Нефть',
                                'value': 0,
                            },
                            {
                                'label': 'Обводненность',
                                'value': 0,
                            },
                            {
                                'label': 'Аном. обв.',
                                'value': 0,
                            },
                            {
                                'label': 'Добыча газа',
                                'value': 0,
                            },
                            {
                                'label': 'Жидкость, м3/сут. (телеметрия)',
                                'value': 0,
                            },
                            {
                                'label': 'Pбуфф.',
                                'value': 0,
                            },
                            {
                                'label': 'Pзатр.',
                                'value': 0,
                            },
                            {
                                'label': 'Pбуфф.\n' +
                                    'до штуцера',
                                'value': 0,
                            },
                            {
                                'label': 'Pбуфф. после\n' + 'штуцера',
                                'value': 0,
                            },
                            {
                                'label': 'Н дин./\n' +
                                    'Pзаб/Pзатр',
                                'value': 0,
                            },
                            {
                                'label': 'Н стат / Рпл / \n' +
                                    'Pзатр',
                                'value': 0,
                            },
                            {
                                'label': 'Рез. ГДМ / Дл.х.при\n' + 'ГДМ/ ЧК при ГДМ',
                                'value': 0,
                            }
                        ],
                    }
                };
                this.dates.push(obj);
            }
        },
        getHistorical() {
            let calculated = [];
            _.forEach(this.dates, (yearItem) => {
                let summary = this.getSummaryBy(yearItem.year,yearItem);
                let filtered = _.filter(this.productionHistoricalData, (item) => parseInt(item.year) === yearItem.year);
                calculated.push(summary);
                calculated = calculated.concat(filtered);
            });
            return calculated;
        },
        getSummaryBy(year, template) {
            let filtered = _.filter(this.productionHistoricalData, (item) => parseInt(item.year) === year);
            let summary = template;
            summary['water'] = _.sumBy(filtered, 'water');
            summary['oil'] = _.sumBy(filtered, 'oil');
            summary['waterDebit'] = _.sumBy(filtered, 'waterDebit');
            summary['waterCut'] = _.meanBy(filtered, 'waterCut');
            summary['oilDebit'] = _.sumBy(filtered, 'oilDebit');
            summary['hoursWorked'] = _.sumBy(filtered, 'hoursWorked');
            return summary;
        },
    },
    mounted() {
        this.fillDates();
        this.dates = this.getHistorical();
    },
    computed: {
        ...bigdatahistoricalVisibleState(['productionHistoricalData']),
    }
}
</script>
<style scoped lang="scss">
.main-block {
    margin-left: 30px;
    height: 100%;
    min-width: 610px;
    max-width: 610px;
    color: white;
    font-size: 14px;
}
.header {
    background: #293688;
    max-width: 630px;
}
.cancel-icon {
    background: url(/img/bd/cancel-icon.svg) no-repeat;
    margin-left: 20px;
    margin-top: 15px;
}
.historical-table {
    text-align: center;
    border: 2px solid #293688;
    width: 630px;

    tbody {
        height: 680px;
        display: block;
        overflow-y:scroll;
    }
    thead, tbody tr {
        display: table;
        table-layout:fixed;
        width: 100%;
    }
    th {
        background: #37408B;
        border: 1px solid rgba(161, 164, 222, 0.3);
        border-top: none;
        padding: 5px;
    }
    td {
        padding: 5px;
        background: #4D5092;
        border: 1px solid #A1A4DE;
        height: 49px;
        span {
            border-left: 1px solid #A1A4DE;
            padding-top: 17px;
            padding-bottom: 17px
        }
        label {
            min-width: 40px;
        }
    }
}
.left-block {
    height: 810px;
}
</style>