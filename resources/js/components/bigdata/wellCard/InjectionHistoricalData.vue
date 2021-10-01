<template>
    <div class="main-block">
        <div class="row">
            <div class="col-12 d-flex header justify-content-between">
                <div class="col-11 p-2">Исторические сведения по добыче нефти</div>
                <div class="col-1 cancel-icon" @click="SET_VISIBLE_INJECTION(false)"></div>
            </div>
            <div class="col-12 p-0 left-block">
                <table class="historical-table">
                    <thead>
                        <tr>
                            <th>Год</th>
                            <th>Закачка воды<br>за период, м3</th>
                            <th>Среднесуточнаяя<br>закачка воды за<br>период, м3/сут.</th>
                            <th>Накопленная<br>закачка воды за<br>период, м3/сут.</th>
                            <th>Отработанное<br>время</th>
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
                            <td>{{date.waterInjection.toFixed(2)}}</td>
                            <td>{{date.dailyWaterInjection.toFixed(2)}}</td>
                            <td>{{date.accumulateWaterInjection}}</td>
                            <td>{{(date.hoursWorked*24).toFixed(0)}} часов</td>
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
            },
        };
    },
    methods: {
        ...bigdatahistoricalVisibleMutations([
            'SET_VISIBLE_INJECTION','SET_INJECTION_HISTORICAL_PERIOD'
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
            this.SET_INJECTION_HISTORICAL_PERIOD(this.selectedDates);
        },
        fillDates() {
            for (let i = 2008; i <= 2021; i++) {
                let obj = {
                    'id': i,
                    'month': null,
                    'year': i,
                    'isChecked': false,
                    'isVisible': true,
                    'waterInjection': 0,
                    'dailyWaterInjection': 0,
                    'accumulateWaterInjection': 0,
                    'hoursWorked': 0,
                    'params': {
                        'techMode': [
                            {
                                'label': 'Приемистость',
                                'value': 0,
                            },
                            {
                                'label': 'Давление закачки',
                                'value': 0,
                            },
                            {
                                'label': 'Состояние скважины',
                            },
                            {
                                'label': 'Обработанное время',
                            },
                            {
                                'label': 'ГТМ',
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
                let filtered = _.filter(this.injectionHistoricalData, (item) => parseInt(item.year) === yearItem.year);
                calculated.push(summary);
                calculated = calculated.concat(filtered);
            });
            return calculated;
        },
        getSummaryBy(year, template) {
            let filtered = _.filter(this.injectionHistoricalData, (item) => parseInt(item.year) === year);
            let summary = template;
            summary['waterInjection'] = _.sumBy(filtered, 'waterInjection');
            summary['dailyWaterInjection'] = _.sumBy(filtered, 'dailyWaterInjection');
            summary['accumulateWaterInjection'] = _.sumBy(filtered, 'accumulateWaterInjection');
            summary['hoursWorked'] = _.sumBy(filtered, 'hoursWorked');
            return summary;
        }
    },
    mounted() {
        this.fillDates();
        this.dates = this.getHistorical();
    },
    computed: {
        ...bigdatahistoricalVisibleState(['injectionHistoricalData']),
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
}
.cancel-icon {
    background: url(/img/bd/cancel-icon.svg) no-repeat;
    margin-left: 20px;
    margin-top: 15px;
}
.historical-table {
    text-align: center;
    border: 2px solid #293688;
    width: 100%;
    th {
        background: #37408B;
        border: 1px solid rgba(161, 164, 222, 0.3);
        border-top: none;
        padding: 5px;
    }
    tbody {
        height: 725px;
    }
    td {
        padding: 5px;
        background: #4D5092;
        border: 1px solid #A1A4DE;
        span {
            border-left: 1px solid #A1A4DE;
            padding-top: 17px;
            padding-bottom: 17px
        }
        label {
            min-width: 61px;
        }
    }
}
.left-block {
    overflow-y: scroll;
    height: 810px;
}
</style>