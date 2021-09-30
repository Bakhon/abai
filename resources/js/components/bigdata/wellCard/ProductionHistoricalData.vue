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
                        <tr v-for="(date,index) in dates">
                            <td>
                                <label v-if="!date.month" class="form-check-label" @click="handleYearClick(date,index)">{{date.year}}</label>
                                <label v-else class="form-check-label">{{date.name}}</label>
                                <span class="ml-1"></span>
                                <input class="ml-2" type="checkbox" v-model="date.isChecked" @click="handleDateSelect(date)">
                            </td>
                            <td>{{date.water}}</td>
                            <td>{{date.oil}}</td>
                            <td>{{date.waterDebit}}</td>
                            <td>{{date.waterCut}}</td>
                            <td>{{date.oilDebit}}</td>
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
        handleYearClick(date,parentIndex) {
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
            }
        },
        handleDateSelect(date) {
            let ids = [date.id];
            if (date.months) {
                ids = _.map(date.months, 'id');
            }
            if (!date.isChecked) {
                this.selectedDates.push(ids);
            } else {
                for (let i in ids) {
                    let index = this.selectedDates.findIndex(item => item === ids[i]);
                    this.selectedDates.splice(index, 1);
                }
            }
        },
        arrayMerge(parentArray, childArray, i) {
            return parentArray.slice(0, i).concat(childArray, parentArray.slice(i));
        },
        fillDates() {
            for (let i = 2008; i <= 2021; i++) {
                let obj = {
                    'id': i,
                    'year': i,
                    'isChecked': false,
                    'water': 0,
                    'oil': 0,
                    'waterDebit': 0,
                    'waterCut': 0,
                    'oilDebit': 0,
                    'hoursWorked': '0 часов',
                    'months': []
                };
                for (let y = 1; y <=12; y++) {
                    obj.months.push({
                        'name': this.monthMapping[y],
                        'id': y + '.' + i,
                        'month': y,
                        'year': i,
                        'isChecked': false,
                        'water': 0,
                        'oil': 0,
                        'waterDebit': 0,
                        'waterCut': 0,
                        'oilDebit': 0,
                        'hoursWorked': '0 часов',
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
}
</style>