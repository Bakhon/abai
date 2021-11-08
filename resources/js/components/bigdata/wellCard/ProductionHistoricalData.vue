<template>
    <div class="main-block">
            <div class="col-12 d-flex header justify-content-between">
                <div class="col-11 p-2">Исторические сведения по добыче нефти</div>
                <div class="col-1 cancel-icon" @click="SET_VISIBLE_PRODUCTION(false)"></div>
            </div>
            <div class="col-12 p-0 left-block bg-dark">
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
                            <td>{{getFormattedNumber(date.water.toFixed(2))}}</td>
                            <td v-if="date.oil !== null && date.oil > 0">{{getFormattedNumber(date.oil.toFixed(1))}}</td>
                            <td v-else>{{getFormattedNumber(date.oil)}}</td>
                            <td>{{getFormattedNumber(date.waterDebit.toFixed(1))}}</td>
                            <td>{{getFormattedNumber(date.waterCut.toFixed(0))}}</td>
                            <td>{{getFormattedNumber(date.oilDebit.toFixed(1))}}</td>
                            <td>{{(date.hoursWorked).toFixed(0)}} дн.</td>
                        </tr>
                    </tbody>
                </table>
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
            isDownloadCompleted: false
        };
    },
    methods: {
        ...bigdatahistoricalVisibleMutations([
            'SET_VISIBLE_PRODUCTION','SET_PRODUCTION_HISTORICAL_PERIOD','SET_PRODUCTION_HISTORICAL'
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
                filtered = _.filter(this.dates, (item) => item.isChecked && item.month !== null);
            }
            this.selectedDates = filtered;
            this.SET_PRODUCTION_HISTORICAL_PERIOD(this.selectedDates);
            this.SET_PRODUCTION_HISTORICAL(this.productionHistoricalData);
        },
        fillDates() {
            this.dates = [];
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
                let sorted = _.sortBy(filtered, 'date');
                let isChecked = true;
                _.forEach(sorted, (item) => {
                    isChecked = item.isChecked;
                });
                summary.isChecked = isChecked;
                calculated.push(summary);
                calculated = calculated.concat(sorted);
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
            if (!summary['waterCut']) {
                summary['waterCut'] = 0;
            }
            summary['oilDebit'] = _.sumBy(filtered, 'oilDebit');
            summary['hoursWorked'] = _.sumBy(filtered, 'hoursWorked');
            return summary;
        },
        getFormattedNumber(num) {
            return new Intl.NumberFormat("ru-RU").format(num);
        }
    },
    mounted() {
        this.fillDates();
        this.dates = this.getHistorical();
    },
    computed: {
        ...bigdatahistoricalVisibleState(['productionHistoricalData']),
    },
    watch: {
        "productionHistoricalData": function() {
            if (!this.isDownloadCompleted) {
                this.fillDates();
                this.dates = this.getHistorical();
                this.isDownloadCompleted = true;
                let currentYearIndex = _.findIndex(this.dates, {id: 2021,month: null});
                this.handleDateSelect(this.dates[currentYearIndex],currentYearIndex);
                this.SET_VISIBLE_PRODUCTION(false);
            }
        }
    }
}
</script>
<style scoped lang="scss">
.main-block {
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
    background-position: center;
    cursor: pointer;
}
.historical-table {
    text-align: center;
    border: 1px solid #293688;

    
    thead {
        position: sticky;
        top: 0;
        z-index: 444;
    }
    thead, tbody tr {
        display: table;
        table-layout:fixed;
        width: 100%;
    }
    th {
        background: #a5abde;
        border: 1px solid #030647;
        border-top: none;
        padding: 2px;
        font-size: 12px;
        color: #030647;
    }
    td {
         padding: 2px;
        background: #bbbfe2;
        border: 1px solid #030647;
        border-top: none;
        color: #030647;
        overflow: hidden;
        span {
            border-left: 1px solid #030647;
            padding-top: 17px;
            padding-bottom: 17px
        }
        label {
            min-width: 40px;
            min-width: 40px;
            color: #030647;
        }
    }
     
}
.left-block {
    height: calc(100% - 36px);
    overflow-y: auto;
     &::-webkit-scrollbar {
        width: 7px;
    }
    &::-webkit-scrollbar-thumb {
        background: #656a8a;
        border-radius: 10px;
    }
}
</style>