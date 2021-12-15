<template>
    <div class="page-wrapper h-100">
        <div class="page-container row">
            <div class="col-12 mt-3 header">
                <div class="header-title">
                    Оперативная суточная информация по добыче нефти и конденсата АО НК "КазМунайГаз"
                </div>
                <div class="img-download" @click="handleExcelDownload()"></div>
            </div>
            <div class="col-3 mt-3 d-flex">
                <div :class="[menu.daily ? 'period-button_selected' : 'period-button','col-5 cursor-pointer']" @click="switchView('daily')">Суточная</div>
                <div :class="[menu.monthly ? 'period-button_selected' : 'period-button','col-5 ml-2 cursor-pointer']" @click="switchView('monthly')">С начала месяца</div>
                <div :class="[menu.yearly ? 'period-button_selected' : 'period-button','col-5 ml-2 cursor-pointer']" @click="switchView('yearly')">За {{previousMonth}} мес.</div>
            </div>
            <div class="col-12 mt-3">
                <table v-if="menu.daily" class="daily-table">
                    <thead>
                        <tr>
                            <th rowspan="2" class="p-2">№<br>п/п</th>
                            <th rowspan="2" class="p-2">Предприятия</th>
                            <th rowspan="2" class="p-2">Доля<br>КМГ</th>
                            <th colspan="3" class="p-2">СУТОЧНАЯ</th>
                            <th rowspan="2" colspan="2" class="p-2">Причины отклонений</th>
                        </tr>
                        <tr>
                            <th>План</th>
                            <th>Факт</th>
                            <th>(+,-)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(dzo, index) in productionByPeriods.daily" :class="getColorBy(index)">
                            <td v-if="dzo.orderId === 2" rowspan="2" class="p-2">{{ dzo['id'] }}</td>
                            <td v-else-if="dzo.orderId === 3" class="condensate_padding text-left">{{ dzo['name'] }}</td>
                            <td v-else class="p-2">{{ dzo['id'] }}</td>
                            <td v-if="dzo.orderId !== 3" class="p-2">{{ dzo['name'] }}</td>
                            <td v-if="dzo.orderId === 2" rowspan="2" class="p-2">{{ dzo['part'] }}</td>
                            <td v-else-if="dzo.orderId === 3" class="p-2 text-right">{{ getFormattedNumber(dzo['plan']) }}</td>
                            <td v-else class="p-2">{{ dzo['part'] }}</td>
                            <td v-if="dzo.orderId !== 3" class="p-2 text-right">{{ getFormattedNumber(dzo['plan']) }}</td>
                            <td class="p-2 text-right">{{ getFormattedNumber(dzo['fact']) }}</td>
                            <td v-if="dzo['plan'] - dzo['fact'] < 0" class="color__red p-2 text-right">{{ getFormattedNumber(dzo['plan'] - dzo['fact']) }}</td>
                            <td class="p-2 text-right" v-else>{{ getFormattedNumber(dzo['plan'] - dzo['fact']) }}</td>
                            <td v-if="dzo['reasons'].length > 0" colspan="2" class="p-2">
                                <div v-for="(reason, index) in dzo['reasons']" class="text-left">
                                    <span>{{ reason[0] }}</span>
                                    <span v-if="reason[1] !== null">, потери - {{ reason[1] }} т.</span>
                                    <span v-if="dzo['reasons'].length - 1 !== index"><br></span>
                                </div>
                            </td>
                            <td v-else colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
                <table v-if="menu.monthly" class="monthly-table">
                    <thead>
                    <tr>
                        <th rowspan="3" class="p-2">№<br>п/п</th>
                        <th rowspan="3" class="p-2">Предприятия</th>
                        <th rowspan="3" class="p-2">Доля<br>КМГ</th>
                        <th rowspan="3" class="p-2">План на<br>{{previousMonthName}}</th>
                        <th rowspan="2" colspan="3" class="p-2">С НАЧАЛА МЕСЯЦА на<br>{{currentDate}}</th>
                        <th rowspan="3" class="p-2">Причины отклонений</th>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <th>План</th>
                        <th>Факт</th>
                        <th>(+,-)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(dzo, index) in productionByPeriods.monthly" :class="getColorBy(index)">
                        <td v-if="dzo.orderId === 2" rowspan="2" class="p-2">{{ dzo['id'] }}</td>
                        <td v-else-if="dzo.orderId === 3" class="condensate_padding text-left">{{ dzo['name'] }}</td>
                        <td v-else class="p-2">{{ dzo['id'] }}</td>
                        <td v-if="dzo.orderId !== 3" class="p-2">{{ dzo['name'] }}</td>
                        <td v-if="dzo.orderId === 2" rowspan="2" class="p-2">{{ dzo['part'] }}</td>
                        <td v-else-if="dzo.orderId === 3" class="p-2 text-right">{{ getFormattedNumber(dzo['monthlyPlan']) }}</td>
                        <td v-else class="p-2">{{ dzo['part'] }}</td>
                        <td v-if="dzo.orderId !== 3" class="p-2 text-right">{{ getFormattedNumber(dzo['monthlyPlan']) }}</td>
                        <td class="p-2 text-right">{{ getFormattedNumber(dzo['plan']) }}</td>
                        <td class="p-2 text-right">{{ getFormattedNumber(dzo['fact']) }}</td>
                        <td v-if="dzo['plan'] - dzo['fact'] < 0" class="color__red p-2 text-right">{{ getFormattedNumber(dzo['plan'] - dzo['fact']) }}</td>
                        <td class="p-2 text-right" v-else>{{ getFormattedNumber(dzo['plan'] - dzo['fact']) }}</td>
                        <td v-if="dzo['reasons'].length > 0" colspan="2" class="p-2">
                            <div v-for="(reason, index) in dzo['reasons']" class="text-left">
                                <span>{{ reason[0] }}</span>
                                <span v-if="reason[1] !== null">, потери - {{ reason[1] }} т.</span>
                                <span v-if="dzo['reasons'].length - 1 !== index"><br></span>
                            </div>
                        </td>
                        <td v-else colspan="2"></td>
                    </tr>
                    </tbody>
                </table>
                <table v-if="menu.yearly" class="monthly-table">
                    <thead>
                        <tr>
                            <th rowspan="2" class="p-2">№<br>п/п</th>
                            <th rowspan="2" class="p-2">Предприятия</th>
                            <th rowspan="2" class="p-2">Доля<br>КМГ</th>
                            <th rowspan="2" class="p-2">Доля<br>КМГ</th>
                            <th colspan="3" class="p-2">За {{previousMonth}} мес.</th>
                            <th rowspan="2" class="p-2">Причины отклонений</th>
                        </tr>
                        <tr>
                            <th>План</th>
                            <th>Факт</th>
                            <th>(+,-)</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(dzo, index) in productionByPeriods.yearly" :class="getColorBy(index)">
                        <td v-if="dzo.orderId === 2" rowspan="2" class="p-2">{{ dzo['id'] }}</td>
                        <td v-else-if="dzo.orderId === 3" class="condensate_padding text-left">{{ dzo['name'] }}</td>
                        <td v-else class="p-2">{{ dzo['id'] }}</td>
                        <td v-if="dzo.orderId !== 3" class="p-2">{{ dzo['name'] }}</td>
                        <td v-if="dzo.orderId === 2" rowspan="2" class="p-2">{{ dzo['part'] }}</td>
                        <td v-else-if="dzo.orderId === 3" class="p-2 text-right">{{ getFormattedNumber(dzo['yearlyPlan']) }}</td>
                        <td v-else class="p-2">{{ dzo['part'] }}</td>
                        <td v-if="dzo.orderId !== 3" class="p-2 text-right">{{ getFormattedNumber(dzo['yearlyPlan']) }}</td>
                        <td class="p-2 text-right">{{ getFormattedNumber(dzo['plan']) }}</td>
                        <td class="p-2 text-right">{{ getFormattedNumber(dzo['fact']) }}</td>
                        <td v-if="dzo['plan'] - dzo['fact'] < 0" class="color__red p-2 text-right">{{ getFormattedNumber(dzo['plan'] - dzo['fact']) }}</td>
                        <td class="p-2 text-right" v-else>{{ getFormattedNumber(dzo['plan'] - dzo['fact']) }}</td>
                        <td v-if="dzo['reasons'].length > 0" colspan="2" class="p-2">
                            <div v-for="(reason, index) in dzo['reasons']" class="text-left">
                                <span>{{ reason[0] }}</span>
                                <span v-if="reason[1] !== null">, потери - {{ reason[1] }} т.</span>
                                <span v-if="dzo['reasons'].length - 1 !== index"><br></span>
                            </div>
                        </td>
                        <td v-else colspan="2"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
       </div>
   </div>
</template>
<script src="./index.js"></script>

<style scoped lang="scss">
.header {
    justify-content: center;
    display: flex;
}
.img-download {
    background: url(/img/visualcenter3/download.png) no-repeat;
    height: 25px;
    width: 25px;
    position: absolute;
    right: 60px;
}
.header-title {
    font-style: normal;
    font-weight: bold;
    font-size: 20px;
    line-height: 24px;
}

.page-container {
   flex-wrap: wrap;
   margin: 0 !important;
}
.page-wrapper {
   font-family: HarmoniaSansProCyr-Regular, Harmonia-sans;
   position: relative;
   min-height: calc(100vh - 88px);
   background: #272953;
   color: white;
   text-align: center;
}
.period-button {
    background: #333975;
    color: #9EA4C9;
    border-radius: 7px;
}
.period-button_selected {
    background: #2e50e9;
    color: white;
    border-radius: 7px;
}
.cursor-pointer {
    cursor: pointer;
}
.daily-table {
    width: 100%;
    border-collapse: collapse;
    text-align: right;
    tr:nth-child(1)  {
        th:nth-child(4) {
            width: 200px;
        }
        th:nth-child(2) {
            width: 400px;
        }
        &:last-child {
            width: 800px;
        }
    }
    th {
        text-align: center;
        background-color: #353ea1;
        border: 1px solid black;
    }
    td {
        border: 1px solid black !important;
        text-align: right;
        &:first-child,&:nth-child(3) {
            text-align: center;
        }
        &:nth-child(2) {
            text-align: left;
        }
    }
}
.color__red {
    color: red;
}
.condensate_padding {
    padding: 0.5rem 0.5rem 0.5rem 141px;
}
.monthly-table {
    width: 100%;
    border-collapse: collapse;
    text-align: right;
    tr:nth-child(1)  {
        th:nth-child(5) {
            width: 200px;
        }
        th:nth-child(2) {
            width: 400px;
        }
    }
    tr:first-child th:last-child {
        width: 800px;
    }
    th {
        text-align: center;
        background-color: #353ea1;
        border: 1px solid black;

    }
    td {
        border: 1px solid black !important;
        text-align: right;
        &:first-child,&:nth-child(3) {
            text-align: center;
        }
        &:nth-child(2) {
            text-align: left;
        }
    }
}
.dzo-row__light {
    background: #fff;
    color: #000;
}
.dzo-row__dark {
    background: #e6e6e6;
    color: #000;
}
</style>