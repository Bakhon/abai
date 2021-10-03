<template>
    <div>
        <InjectionWellsSchedule
            v-if="isScheduleVisible"
            :mainWell="{id: well.id, name: well.wellInfo.uwi}"
             @changeScheduleVisible="isScheduleVisible = !isScheduleVisible; changeColumnsVisible(true)"
        ></InjectionWellsSchedule>
        <div v-else class="main-block w-100 px-2 py-3">
            <div class="d-flex justify-content-between header_info">
                <span class="header_icon ml-1"></span>
                <div class="d-flex justify-content-between">
                    <span class="header_icon-switch mr-1"></span>
                    <span class="underline cursor-pointer header_title px-1" @click="SET_VISIBLE_INJECTION(true),changeColumnsVisible(false),isMeasurementScheduleActive = false">Исторические сведения по добыче нефти</span>
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
                        <table class="table table-striped text-white text-nowrap">
                            <tbody>
                                <tr>
                                    <td>Гор (проект/факт): {{well.category.name_ru}}</td>
                                    <td rowspan="3">Инт.перф: {{well.perfActual.top}}</td>
                                    <td rowspan="2">Г/ф: </td>
                                    <td>Ø экс.к.: </td>
                                    <td>Дата обустройства: </td>
                                </tr>
                                <tr>
                                    <td>Зона/Рнас: {{well.zone.name_ru}}</td>
                                    <td>Вид скважины: {{well.wellType.name_ru}}</td>
                                    <td>Дата в действ.фонд: {{well.expl.dbeg}}</td>
                                </tr>
                                <tr>
                                    <td>Иск. заб.: </td>
                                    <td rowspan="2">ТПН: </td>
                                    <td>ЦДНГ/ГУ/ряд: {{well.gu.name_ru}}</td>
                                    <td>Тип.УО: </td>
                                </tr>
                                <tr>
                                    <td>Факт.заб.: {{well.gdisCurrentValueBhp.value_double}}</td>
                                    <td>НКТ: </td>
                                    <td>Спут./отвод: {{well.tap.tap}}</td>
                                    <td>Экс.г: {{well.expl.dbeg}}</td>
                                </tr>
                                <tr>
                                    <td>Вл.наг: {{well.wellReactInfl.well_influencing}}</td>
                                    <td>Штанги: </td>
                                    <td>ГИС: {{well.gis.gis_date}}</td>
                                    <td>Примечание: {{well.gdisCurrent.note}}</td>
                                    <td>К/Г: </td>
                                </tr>
                                <tr>
                                    <td>ПФП: {{well.treatmentDate.treat_date}}</td>
                                    <td>Тип. СК: </td>
                                    <td>Lх или Ø шкива: </td>
                                    <td></td>
                                    <td>Обр.кл.: </td>
                                </tr>
                                <tr>
                                    <td>Посл. ПРС: {{getFormatedDate(this.well.prsWellWorkover.dbeg)}}</td>
                                    <td>Тип и Ø насоса: </td>
                                    <td>ГРП: {{getFormatedDate(this.well.gtm.dbeg)}}</td>
                                    <td></td>
                                    <td>Доп. оборудования: </td>
                                </tr>
                                <tr>
                                    <td>Посл. Рпл: {{well.gdisCurrentValueRp.value_double}}</td>
                                    <td></td>
                                    <td>Совм.скв.: {{well.category.name_ru}}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Посл. КРС: {{getFormatedDate(this.well.krsWorkover.dbeg)}}</td>
                                    <td>Sк: {{well.treatmentSko.treat_date}}</td>
                                    <td></td>
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
                <div class="historical-container">
                    <div v-if="isMeasurementScheduleActive" v-for="periodItem in historicalData">
                    <div class="row m-0 mt-1">
                        <div class="col-12 center_block d-flex">
                            <div class="col-12">{{periodItem.id}}</div>
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
                                        <tr class="background_light" v-if="periodItem.params.measurementSchedule">
                                            <td v-for="(scheduleItem,key,index) in periodItem.params.measurementSchedule">
                                                {{scheduleItem}}
                                            </td>
                                        </tr>
                                        <tr class="background_light" v-else>
                                            <td v-for="emptyItem in 5">
                                                &nbsp;
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
                                                v-if="periodItem.params.techMode"
                                                v-for="(techModeItem,index) in periodItem.params.techMode"
                                                :class="index % 2 === 0 ? 'header-background_light' : 'header-background_dark'"
                                        >
                                            <td v-if="index < 2">
                                                {{techModeItem.label}}
                                            </td>
                                            <td v-else colspan="2">
                                                {{techModeItem.label}}
                                            </td>
                                            <td v-if="index < 2">
                                                {{techModeItem.value}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-0">
                                <table class="table text-center text-white text-nowrap historical-table">
                                    <thead>
                                        <tr>
                                            <th v-for="dayNumber in getDaysCountInMonth(periodItem.id)">{{dayNumber}}<br>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td
                                                    v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                    v-if="periodItem.params.monthlyData[dayNumber-1]"
                                            >
                                                {{periodItem.params.monthlyData[dayNumber-1].throttle}}
                                            </td>
                                            <td v-else>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td
                                                    v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                    v-if="periodItem.params.monthlyData[dayNumber-1]"
                                            >
                                                {{periodItem.params.monthlyData[dayNumber-1].pressure}}
                                            </td>
                                            <td v-else>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td
                                                    v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                    v-if="periodItem.params.monthlyData[dayNumber-1]"
                                            >
                                                {{periodItem.params.monthlyData[dayNumber-1].status}}
                                            </td>
                                            <td v-else>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td
                                                    v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                    v-if="periodItem.params.monthlyData[dayNumber-1]"
                                            >
                                                {{periodItem.params.monthlyData[dayNumber-1].workHours}}
                                            </td>
                                            <td v-else>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td
                                                    v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                    v-if="periodItem.params.monthlyData[dayNumber-1]"
                                            >
                                                {{periodItem.params.monthlyData[dayNumber-1].gtm}}
                                            </td>
                                            <td v-else>&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mt-1" v-if="periodItem.params.activity.length > 0">
                        <div class="col-3 form-check">
                            <input class="form-check-input" type="checkbox" value="" id="activityCheck" @click="isActivityShown = !isActivityShown">
                            <label class="form-check-label" for="activityCheck">
                                Показать мероприятия
                            </label>
                        </div>
                        <div v-if="isActivityShown && periodItem.params.activity" class="col-9 p-0">
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
                                            v-for="(activity,index) in periodItem.params.activity"
                                            :class="index % 2 === 0 ? 'header-background_light' : 'header-background_dark'"
                                    >
                                        <td>{{index+1}}</td>
                                        <td v-if="activity.dbeg">{{getFormatedDate(activity.dbeg)}}</td>
                                        <td v-else>{{getFormatedDate(activity.dend)}}</td>
                                        <td>{{repairType[activity.repair_type]}}</td>
                                        <td v-if="activity.dbeg">{{activity.work_plan}}</td>
                                        <td v-else>{{activity.work_list}}</td>
                                        <td>{{activity.well_status}}</td>
                                        <td>{{well.category.name_ru}}</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>
                <div class="d-flex justify-content-end bottom-buttons">
                    <div class="p-1 d-flex align-items-center cursor-pointer" @click="nahdleMeasurementSchedule()">
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
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import InjectionWellsSchedule from "./InjectionWellsSchedule";
import moment from "moment";
import {bigdatahistoricalVisibleMutations,bigdatahistoricalVisibleState,globalloadingMutations} from '@store/helpers';

export default {
    components: {InjectionWellsSchedule},
    props: {
        well: {},
        changeColumnsVisible: Function,
    },
    data() {
        return {
            isScheduleVisible: false,
            isActivityShown: false,
            isFreeInfoShown: true,
            historicalInfo: [],
            historicalData: [],
            isMeasurementScheduleActive: false,
            repairType: {
                1: 'КРС',
                3: 'ПРС',
            }
        };
    },
    methods: {
        async nahdleMeasurementSchedule() {
            this.historicalData = this.injectionMeasurementSchedule;
            this.SET_LOADING(true);
            for (let i in this.historicalData) {
                this.historicalData[i].params['activity'] = await this.getActivityByWell(this.historicalData[i].month,this.historicalData[i].year);
            }
            this.historicalData = _.orderBy(this.historicalData, ['date'],['asc']);
            this.SET_LOADING(false);
            this.isMeasurementScheduleActive = true;
        },
        async getActivityByWell(month,year) {
            let queryOptions = {
                'month': moment(month,'MMM').month() + 1,
                'year': year,
            };
            const response = await axios.get(this.localeUrl(`/api/bigdata/wells/get-activity/${this.well.id}`),{params:queryOptions});
            return response.data;
        },
        getDaysCountInMonth(monthYearString) {
            return moment(monthYearString, 'YYYY/MMM').daysInMonth();
        },
        ...bigdatahistoricalVisibleMutations([
            'SET_VISIBLE_INJECTION','SET_INJECTION_HISTORICAL'
        ]),
        assignInfoByDates(data) {
            let summary = [];
            _.forEach(data, (year, key) => {
                _.forEach(year, (month, monthNumber) => {
                    let date = moment(month[0].date, 'YYYY-MM-DD');
                    let daysCount = this.getDaysCountInMonth(date.format('YYYY/MMM'));
                    let monthSummary = {
                        'id': date.format('YYYY/MMM'),
                        'month': date.format('MMM'),
                        'year': date.format('YYYY'),
                        'date': date,
                        'isChecked': false,
                        'isVisible': false,
                        'waterInjection': _.sumBy(month, item => Number(item.liq)),
                        'dailyWaterInjection': _.sumBy(month, item => Number(item.liq)) / daysCount,
                        'accumulateWaterInjection': 0,
                        'hoursWorked': _.sumBy(month, 'workHours'),
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
                            'monthlyData': month
                        }
                    };
                    this.historicalInfo.push(monthSummary);
                });
            });
            this.SET_INJECTION_HISTORICAL(this.historicalInfo);
        },
        getFormatedDate(data) {
            if (data != null && data != '') {
                return moment(data).format('DD/MM/YYYY')
            }
        },
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
    },
    async mounted() {
        this.SET_LOADING(true);
        const response = await axios.get(this.localeUrl(`/api/bigdata/wells/injectionHistory/${this.well.id}`));
        this.assignInfoByDates(response.data);
        this.SET_LOADING(false);
    },
    computed: {
        ...bigdatahistoricalVisibleState(['injectionMeasurementSchedule']),
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
</style>