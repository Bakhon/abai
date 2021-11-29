<template>
    <div class="main-block">
        <div class="col-12 d-flex header justify-content-between">
            <div class="col-11 p-2">Исторические сведения по добыче нефти</div>
            <div class="col-1 cancel-icon" @click="SET_VISIBLE_INJECTION(false)"></div>
        </div>
        <div class="col-12 p-0 left-block bg-dark">
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
                    <tr v-for="(date,index) in dates" v-if="date.isVisible" :class="getRowColor(date,index)">
                        <td>
                            <label v-if="date.month === null" class="form-check-label" @click="handleYearSelect(date)">{{date.year}}</label>
                            <label v-else class="form-check-label month-name">{{date.month}}</label>
                            <span class="ml-1"></span>
                            <input class="ml-2" type="checkbox" v-model="date.isChecked" @click="handleDateSelect(date,index)">
                        </td>
                        <td>{{formatNumber(date.waterInjection.toFixed(1))}}</td>
                        <td>{{formatNumber(date.dailyWaterInjection.toFixed(1))}}</td>
                        <td>{{formatNumber(date.accumulateWaterInjection)}}</td>
                        <td>{{date.hoursWorked.toFixed(0)}} дн.</td>
                    </tr>
                    <tr>
                        <td rowspan="2">Итого</td>
                        <td>{{ formatNumber(this.getTotalWaterInjection().toFixed(1)) }}</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
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
                'SET_VISIBLE_INJECTION','SET_INJECTION_HISTORICAL_PERIOD','SET_INJECTION_HISTORICAL'
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
                this.SET_INJECTION_HISTORICAL_PERIOD(this.selectedDates);
                this.SET_INJECTION_HISTORICAL(this.injectionHistoricalData);
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
                    let sorted = _.sortBy(filtered, 'date');
                    let isChecked = sorted.length > 0;
                    _.forEach(sorted, (item) => {
                        isChecked = item.isChecked;
                    });
                    if (yearItem.year === moment().year()) {
                        isChecked = true;
                    }
                    summary.isChecked = isChecked;
                    calculated.push(summary);                  
                    calculated = calculated.concat(sorted);                  
                });
                return calculated;
            },
            getSummaryBy(year, template) {
                let filtered = _.filter(this.injectionHistoricalData, (item) => parseInt(item.year) === year);
                let summary = template;
                let dailyWaterInjection =  _.meanBy(filtered, 'dailyWaterInjection');
                if (isNaN(dailyWaterInjection)) {
                    dailyWaterInjection = 0;
                }               
                summary['waterInjection'] = _.sumBy(filtered, 'waterInjection');               
                summary['dailyWaterInjection'] = dailyWaterInjection;
                summary['accumulateWaterInjection'] = 0;
                summary['hoursWorked'] = _.sumBy(filtered, 'hoursWorked');              
                return summary;
            },
            getTotalWaterInjection(){
              let sum = 0;                   
              _.forEach(this.dates, (item) => {                  
                 sum += item.waterInjection;                 
              });                           
              sum = sum / 2; 
              return sum;
            },                     
            formatNumber(num) {
                return new Intl.NumberFormat("ru-RU").format(num);
            },
            getRowColor(item,index) {
                let summary = item.waterInjection + item.dailyWaterInjection + item.accumulateWaterInjection;
                if (item.month === null) {
                    return summary > 0 ? 'row__pink' : 'row__gray';
                }
                if (index % 2 === 0) {
                    return 'row__yellow';
                } else {
                    return 'row__blue';
                }
            }
        },
        mounted() {
            this.fillDates();
            this.dates = this.getHistorical();            
        },
        computed: {
            ...bigdatahistoricalVisibleState(['injectionHistoricalData']),
        },
        watch: {
            "injectionHistoricalData": function() {
                if (!this.isDownloadCompleted) {
                    this.fillDates();
                    this.dates = this.getHistorical();
                    this.isDownloadCompleted = true;
                    let currentYearIndex = _.findIndex(this.dates, {id: 2021,month: null});
                    this.handleDateSelect(this.dates[currentYearIndex],currentYearIndex);
                    this.SET_VISIBLE_INJECTION(false);
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
    .row__gray {
        td {
            background: #656A8A;
            color: #fff;
        }
    }
    .row__pink {
        td {
            background: #636CC3;
            color: #fff;
        }
    }
    .row__yellow {
        td {
            background: #FFFF99;
            color: black;
        }
    }
    .row__blue{
        td {
            background: #CCFFFF;
            color: black;
        }
    }
    .month-name {
        color: black;
    }
</style>