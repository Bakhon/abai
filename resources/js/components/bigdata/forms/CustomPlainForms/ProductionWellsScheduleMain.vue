<template>
    <div>
        <ProductionWellsSchedule
            v-if="isScheduleVisible"
            :mainWell="{id: well.id, name: well.wellInfo.uwi}"
             @changeScheduleVisible="isScheduleVisible = !isScheduleVisible; changeColumnsVisible(true)"
        ></ProductionWellsSchedule>
        <div v-else class="main-block w-100 px-2 py-3">
            <div class="d-flex justify-content-between header_info">
                <span class="header_icon ml-1"></span>
                <div class="d-flex justify-content-between">
                    <span class="header_icon-switch mr-1"></span>
                    <span class="underline cursor-pointer header_title px-1" @click="SET_VISIBLE_INJECTION(true),changeColumnsVisible(false)">Исторические сведения по добыче нефти</span>
                </div>
            </div>
            <div class="d-flex mt-1">
                <div class="col-12 center_block d-flex justify-content-between">
                    <div class="col-11">Сводная информация</div>
                    <div class="col-1 d-flex rounded" @click="isFreeInfoShown = !isFreeInfoShown">
                        <div class="col-2 splitter"></div>
                        <div :class="[isFreeInfoShown ? 'arrow-expand' : 'arrow-cut-down','col-10']"></div>
                    </div>
                </div>
            </div>
            <div class="d-flex mt-1">
                <div :class="[!isFreeInfoShown ? 'd-none' : '','col-12 p-0']">
                    <table class="table table-striped text-white text-nowrap free-inform-table">
                        <tbody>
                            <tr>
                                <td>Гор: {{freeInfo.gor}}</td>
                                <td>Отб.забоя: {{freeInfo.otbSlaughter}}</td>
                                <td>Иск. Забой: {{freeInfo.iskSlaughter}}</td>
                                <td>ГИС: {{freeInfo.GIS}}</td>
                                <td>Примечание: {{freeInfo.comment}}</td>
                            </tr>
                            <tr>
                                <td>Вид скважины: {{freeInfo.wellType}}</td>
                                <td>Рпласта: {{freeInfo.plastRadius}}</td>
                                <td>Ø экс.колонны: {{freeInfo.diamaterColumn}}</td>
                                <td>Посл.ПФП: {{freeInfo.pfp}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td rowspan="2">Вл.скв:	{{freeInfo.vlWell}}</td>
                                <td>КШД тип/Ø: {{freeInfo.kshd}}</td>
                                <td>НКТ: {{freeInfo.nkt}}</td>
                                <td>Посл.СКО: {{freeInfo.sko}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Инт.перф: {{freeInfo.intPerf}}</td>
                                <td>Штанги: {{freeInfo.rod}}</td>
                                <td>Тип к/г: {{freeInfo.type}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Дата ввода в экспл.: {{freeInfo.entryDate}}</td>
                                <td>Н.р: {{freeInfo.nr}}</td>
                                <td>Дата посл. КРС: {{freeInfo.krsDate}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Qмакс.прием: {{freeInfo.qMaxReceive}}</td>
                                <td>БКНС/ГУ/ряд: {{freeInfo.bkns}}</td>
                                <td>Дата посл. ПРС: {{freeInfo.prsDate}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>ГРП: {{freeInfo.grp}}</td>
                                <td>Компенсация: {{freeInfo.compensation}}</td>
                                <td>Доп. оборудования: {{freeInfo.additionalEquipment}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex mt-1">
                <div class="col-12 center_block d-flex">
                    <div class="col-12">График замеров</div>
                </div>
            </div>
            <div v-for="periodItem in historicalData" class="historical-container">
                <div class="row m-0 mt-1">
                    <div class="col-12 center_block d-flex">
                        <div class="col-12">{{periodItem.measurementSchedule.title}}</div>
                    </div>
                    <div class="col-12 p-0 d-flex historical-info">
                        <div class="p-0">
                            <table class="table text-center text-white text-nowrap historical-table">
                                <thead>
                                    <tr>
                                        <th>Год /<br>Месяц</th>
                                        <th>По</th>
                                        <th>L</th>
                                        <th>Ø<br>штуцера</th>
                                        <th>Вид<br>агента</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="background_light">
                                        <td v-for="(scheduleItem,key,index) in periodItem.measurementSchedule">
                                            {{scheduleItem}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td v-for="emptyItem in 5">
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr class="background_dark">
                                        <td v-for="emptyItem in 5">
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr class="background_light">
                                        <td v-for="emptyItem in 5">
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr class="background_dark">
                                        <td v-for="emptyItem in 5">
                                            &nbsp;
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-0">
                            <table class="table text-center text-white text-nowrap historical-table">
                                <thead>
                                    <tr>
                                        <th>Показатель</th>
                                        <th>Тех. <br>Режим</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                            v-for="(techModeItem,index) in periodItem.techMode"
                                            :class="index % 2 === 0 ? 'header-background_light' : 'header-background_dark'"
                                    >
                                        <td v-if="techModeItem.value">
                                            {{techModeItem.label}}
                                        </td>
                                        <td v-else colspan="2">
                                            {{techModeItem.label}}
                                        </td>
                                        <td v-if="techModeItem.value">
                                            {{techModeItem.value}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-0" id="monthly-parent">
                            <table class="table text-center text-white text-nowrap historical-table" id="monthly-info">
                                <thead>
                                    <tr>
                                        <th v-for="dayNumber in getDaysCountInMonth(periodItem.measurementSchedule.title)">{{dayNumber}}<br>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(dayData,index) in periodItem.monthlyData" :class="index % 2 === 0 ? 'background_light' : 'background_dark'">
                                        <td
                                                v-for="dayNumber in getDaysCountInMonth(periodItem.measurementSchedule.title)"
                                                v-if="dayData.injectivity[dayNumber-1]"
                                        >
                                            {{dayData.injectivity[dayNumber-1]}}
                                        </td>
                                        <td
                                                v-for="dayNumber in getDaysCountInMonth(periodItem.measurementSchedule.title)"
                                                v-if="dayData.injectionPressure[dayNumber-1]"
                                        >
                                            {{dayData.injectionPressure[dayNumber-1]}}
                                        </td>
                                        <td
                                                v-for="dayNumber in getDaysCountInMonth(periodItem.measurementSchedule.title)"
                                                v-if="dayData.wellCondition[dayNumber-1]"
                                        >
                                            {{dayData.wellCondition[dayNumber-1]}}
                                        </td>
                                        <td
                                                v-for="dayNumber in getDaysCountInMonth(periodItem.measurementSchedule.title)"
                                                v-if="dayData.processedTime[dayNumber-1]"
                                        >
                                            {{dayData.processedTime[dayNumber-1]}}
                                        </td>
                                        <td
                                                v-for="dayNumber in getDaysCountInMonth(periodItem.measurementSchedule.title)"
                                                v-if="dayData.gtm[dayNumber-1]"
                                        >
                                            {{dayData.gtm[dayNumber-1]}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="d-flex mt-1">
                    <div class="col-3 form-check">
                        <input class="form-check-input" type="checkbox" value="" id="activityCheck" @click="isActivityShown = !isActivityShown">
                        <label class="form-check-label" for="activityCheck">
                            Показать мероприятия
                        </label>
                    </div>
                    <div v-if="isActivityShown" class="col-9 p-0">
                        <table class="table text-center text-white text-nowrap historical-table">
                            <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Дата</th>
                                    <th>Тип<br>мероприятия</th>
                                    <th>Доп. информация</th>
                                    <th>Состояние</th>
                                    <th>Категория<br>скважины</th>
                                    <th>Способ<br>эксплуатации</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                        v-for="(activity,index) in periodItem.activity"
                                        :class="index % 2 === 0 ? 'header-background_light' : 'header-background_dark'"
                                >
                                    <td>{{index+1}}</td>
                                    <td>{{activity.date}}</td>
                                    <td>{{activity.explanation}}</td>
                                    <td>{{activity.additionalInfo}}</td>
                                    <td>{{activity.condition}}</td>
                                    <td>{{activity.category}}</td>
                                    <td>{{activity.operationWay}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end bottom-buttons">
                <div class="p-1 d-flex align-items-center">
                    <img class="pr-1" src="/img/icons/repeat.svg" alt="">
                    Сформировать
                </div>
                <div class="p-1 ml-2 d-flex align-items-center">
                    <img class="pr-1" src="/img/icons/help.svg" alt="">
                    Легенда
                </div>
                <div class="p-1 ml-2 d-flex align-items-center">
                    <img class="pr-1" src="/img/icons/chart.svg" alt="">
                    <a class="text-white cursor-pointer"
                       @click="isScheduleVisible = !isScheduleVisible; changeColumnsVisible(false)">Показать график</a>
                </div>
                <div class="p-1 ml-2 d-flex align-items-center">
                    <img class="pr-1" src="/img/icons/page_excel.svg" alt="">
                    Скачать в MS-Excel
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ProductionWellsSchedule from "./ProductionWellsSchedule";
import moment from "moment";
export default {
    components: {ProductionWellsSchedule},
    props: {
        well: {},
        changeColumnsVisible: Function
    },
    data() {
        return {
            isScheduleVisible: false,
            freeInfo: {
                'gor': 'Ю4',
                'otbSlaughter': 888.07,
                'iskSlaughter': 888.07,
                'GIS': 'ГИС в открытом стволе/25.01.2021',
                'comment': '',
                'wellType': 'Вертикальная',
                'diamaterColumn': '',
                'plastRadius': '',
                'pfp': '',
                'vlWell': '',
                'kshd': '/',
                'nkt': '25.03.2021/76/73/766,88',
                'sko': '',
                'intPerf': '846-848,5',
                'rod': '05.04.2021/96/19/768',
                'type': 'Заводская',
                'entryDate': '',
                'nr': 5.43,
                'krsDate': '24.03.2021-25.03.2021/Освоение',
                'qMaxReceive': '',
                'bkns': '/ГУ-45/15-18',
                'prsDate': '04.04.2021',
                'grp': '',
                'compensation': '',
                'additionalEquipment': ''
            },
            historicalData: [
                {
                    'measurementSchedule': {
                            'title':'2021/январь',
                            'po':'Воронки НКТ',
                            'l':1200,
                            'union':5,
                            'agentType':'Вода морская',
                    },
                    'techMode': [
                        {
                            'label': 'Приемистость',
                            'value': 240,
                        },
                        {
                            'label': 'Давление закачки',
                            'value': 125,
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
                    'monthlyData': [
                        {
                            'injectivity': [1],
                            'injectionPressure': [2],
                            'wellCondition': [3],
                            'processedTime': [4],
                            'gtm': ['Начало ГТМ']
                        },
                        {
                            'injectivity': [11],
                            'injectionPressure': [22],
                            'wellCondition': [33],
                            'processedTime': [44],
                            'gtm': ['Начало ГТМ 2']
                        },
                        {
                            'injectivity': [11],
                            'injectionPressure': [22],
                            'wellCondition': [33],
                            'processedTime': [44],
                            'gtm': ['Начало ГТМ 2']
                        },
                        {
                            'injectivity': [11],
                            'injectionPressure': [22],
                            'wellCondition': [33],
                            'processedTime': [44],
                            'gtm': ['Начало ГТМ 2']
                        },
                        {
                            'injectivity': [11],
                            'injectionPressure': [22],
                            'wellCondition': [33],
                            'processedTime': [44],
                            'gtm': ['Начало ГТМ 2']
                        },
                    ],
                    'activity': [
                        {
                            'date': '07.08.2021 10:00',
                            'explanation': 'Текущие исследования ГДИС',
                            'additionalInfo': '',
                            'condition': 'В работе',
                            'category': 'Нефтяная',
                            'operationWay': 'ШГН'
                        },
                        {
                            'date': '08.08.2021 10:00',
                            'explanation': 'Запрос скважины',
                            'additionalInfo': '',
                            'condition': 'В работе',
                            'category': 'Нефтяная',
                            'operationWay': 'ШГН'
                        },
                        {
                            'date': '09.08.2021 12:00',
                            'explanation': 'Простой',
                            'additionalInfo': '',
                            'condition': 'В работе',
                            'category': 'Нефтяная',
                            'operationWay': 'ШГН'
                        }
                    ]
                },
            ],
            isActivityShown: false,
            isFreeInfoShown: true
        };
    },
    methods: {
        getDaysCountInMonth(monthYearString) {
            return moment(monthYearString, 'YYYY/MMM').daysInMonth();
        },
    }
}
</script>
<style scoped lang="scss">
.main-block {
    background-color: rgba(54, 59, 104, 1);
    color: #fff
}
.content-block {
    background-color: rgba(39, 41, 83, 1);
}
.underline {
    text-decoration: underline;
}

.small-fixed-block {
    height: 300px;
    overflow-y: auto;
}

.red-col {
    background-color: rgba(239, 83, 80, 0.7) !important;
}

.table {
    border: 1px solid rgba(69,77,125,1);

    th {
        border: 1px solid #454D7D;
        background-color: #333975;
        font-size: 0.9rem;
        font-weight: 700;
        padding: 0.3rem !important;
    }

    td {
        font-size: 0.8rem;
        padding: 0.3rem !important;
        border: 1px solid #545580;
    }

    td.red-col {
        padding: 0.5rem !important;
    }
}

.content-block-scrollable {
    height: 70vh;
    overflow-y: scroll;
}
.header_info {
    background: #323370;
    border: 1px solid #545580;
}
.header_icon {
    background: url(/img/bd/production-wells-title-icon.svg) no-repeat;
    width: 20px;
    margin-top: 5px;
}
.header_icon-switch {
    background: url(/img/bd/production-wells-switch.svg) no-repeat;
    width: 20px;
    margin-top: 5px;
}
.header_title {
    font-size: 16px;
    font-weight: 600;
    color: #D6D6E2;
}
.center_block {
    background: #323370;
    border: 1px solid #545580;
}
.arrow-expand {
    background: url(/img/bd/arrow-expand.svg) no-repeat;
    margin-left: 20px;
    margin-top: 7px;
}
.arrow-cut-down {
    background: url(/img/bd/arrow-cut-down.svg) no-repeat;
    margin-left: 20px;
    margin-top: 7px;
}
.border_transparent {
    border-left: 2px solid transparent;
}
.splitter {
    border-right: 1px solid #0F1430;
}
.background_dark {
    background: #2B2E5E;
}
.background_light {
    background: #333767;
}
.header-background_dark {
    background: #2C397E;
}
.header-background_light {
    background: #343F7D;
}
.historical-info {
    overflow-y: auto;
}
.historical-container {
    height: 320px;
    overflow-y: auto;
}
.bottom-buttons div {
    background: #293688;
    border: 1px solid #3366FF;
    border-radius: 5px;
}
.free-inform-table {
    td:first-child,td:nth-child(2),td:nth-child(5) {
        width: 150px;
    }
    td {
        width: 250px;
    }
}
</style>