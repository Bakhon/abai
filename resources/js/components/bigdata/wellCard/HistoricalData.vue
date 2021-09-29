<template>
    <div class="main-block">
        <div class="row">
            <div class="col-12 d-flex header justify-content-between">
                <div class="col-11 p-2">Исторические сведения по добыче нефти</div>
                <div class="col-1 cancel-icon" @click="SET_VISIBLE_INJECTION(true)"></div>
            </div>
            <div class="col-12 p-0">
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
                        <tr v-for="(date,index) in dates">
                            <td>
                                <label v-if="!date.month" class="form-check-label">{{date.year}}</label>
                                <label v-else class="form-check-label">{{date.name}}</label>
                                <span class="ml-1"></span>
                                <input class="ml-2" type="checkbox" :value="date.isChecked" @click="handleDateSelect(date,index)">
                            </td>
                            <td>{{date.waterInjection}}</td>
                            <td>{{date.dailyWaterInjection}}</td>
                            <td>{{date.accumulateWaterInjection}}</td>
                            <td>{{date.hoursWorked}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import {bigdatahistoricalVisibleMutations} from '@store/helpers';

export default {
    props: {
        mainWell: {},
        changeColumnsVisible: Function,
    },
    data() {
        return {
            selectedWell: {},
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
            'SET_VISIBLE_INJECTION'
        ]),
        handleDateSelect(date,parentIndex) {
            let fullDate = {year: date.year, month: undefined};
            if (date.month) {
                fullDate['month'] = date.month;
            }
            let index = this.selectedDates.findIndex(item => item.year === fullDate.year && item.month === fullDate.month);
            if (index !== -1) {
                this.selectedDates.splice(index, 1);
                if (date.months) {
                    this.dates = _.filter(this.dates, (item) => (!item.month && item.year === date.year) || item.year !== date.year);
                }
            } else {
                if (date.months) {
                    this.dates = this.arrayMerge(this.dates,date.months,parentIndex+1);
                }
                this.selectedDates.push(fullDate);
            }
        },
        arrayMerge(parentArray, childArray, i) {
            return parentArray.slice(0, i).concat(childArray, parentArray.slice(i));
        },
        fillDates() {
            for (let i = 2008; i <= 2021; i++) {
                let obj = {
                    'year': i,
                    'isChecked': false,
                    'waterInjection': 0,
                    'dailyWaterInjection': 0,
                    'accumulateWaterInjection': 0,
                    'hoursWorked': '0 дней 0 часов',
                    'months': []
                };
                for (let y = 1; y <=12; y++) {
                    obj.months.push({
                        'name': this.monthMapping[y],
                        'month': y,
                        'year': i,
                        'isChecked': false,
                        'waterInjection': 0,
                        'dailyWaterInjection': 0,
                        'accumulateWaterInjection': 0,
                        'hoursWorked': '0 дней 0 часов',
                    });
                }
                this.dates.push(obj);
            }
        }
    },
    mounted() {
        this.selectedWell = this.mainWell;
        this.fillDates();
    }
}
</script>
<style scoped lang="scss">
.main-block {
    margin-left: 30px;
    margin-top: 7px;
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
    width: 100%;
    text-align: center;
    border: 2px solid #293688;
    thead tr {
        display: block;
    }
    th {
        background: #37408B;
        border: 1px solid rgba(161, 164, 222, 0.3);
        border-top: none;
        padding: 5px;
        min-width: 127px;
    }
    tbody {
        display:block;
        width: 100%;
        overflow: auto;
        height: 725px;
    }
    td {
        padding: 5px;
        background: #4D5092;
        border: 1px solid #A1A4DE;
        min-width: 127px;
        span {
            border-left: 1px solid #A1A4DE;
            padding-top: 10px;
            padding-bottom: 10px
        }
        label {
            min-width: 61px;
        }
    }
}

</style>