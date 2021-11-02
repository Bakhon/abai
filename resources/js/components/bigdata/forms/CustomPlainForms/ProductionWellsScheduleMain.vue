<template>
        <ProductionWellsSchedule
            v-if="isScheduleVisible"
            :mainWell="{id: well.id, name: well.wellInfo.uwi}"
             @changeScheduleVisible="isScheduleVisible = !isScheduleVisible; changeColumnsVisible(true)"
        ></ProductionWellsSchedule>
        <div v-else class="main-block w-100 px-2 py-3">
            <div class="d-flex mt-1">
                <div class="historical-block-head">
                    <div class="head_title">Сводная информация</div>
                    <div class="head_icon" @click="isFreeInfoShown = !isFreeInfoShown">
                        <div class="col-2 splitter"></div>
                        <div :class="[isFreeInfoShown ? 'arrow-expand' : 'arrow-cut-down']"></div>
                    </div>
                    <span class="historical_button" @click="SET_VISIBLE_PRODUCTION(true),changeColumnsVisible(false),isMeasurementScheduleActive = false">Исторические сведения по добыче нефти</span>
                </div>
            </div>
            <div class="d-flex mt-1">
                <div :class="[!isFreeInfoShown ? 'd-none' : '','col-12 p-0 svod-table-container']">
                    <table class="table  free-inform-table svod-table ">
                        <tbody>
                            <tr>
                                <td>Гор: {{well.category.name_ru}}</td>
                                <td>Отб.забоя: </td>
                                <td>Иск. Забой: </td>
                                <td>ГИС: {{well.gis.gis_date}}</td>
                                <td>Примечание: {{well.gdisCurrent.note}}</td>
                            </tr>
                            <tr>
                                <td>Вид скважины: {{well.wellType.name_ru}}</td>
                                <td>Рпласта: </td>
                                <td>Ø экс.колонны: </td>
                                <td>Посл.ПФП: {{well.treatmentDate.treat_date}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td rowspan="2">Вл.скв:	{{well.wellReactInfl.well_influencing}}</td>
                                <td>КШД тип/Ø: </td>
                                <td>НКТ: </td>
                                <td>Посл.СКО: {{well.treatmentSko.treat_date}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Инт.перф: {{well.perfActual.top}}</td>
                                <td>Штанги: </td>
                                <td>Тип к/г: </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Дата ввода в экспл.: {{well.expl.dbeg}}</td>
                                <td>Н.р:</td>
                                <td>Дата посл. КРС: {{getFormatedDate(this.well.krsWorkover.dbeg)}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Qмакс.прием: </td>
                                <td>БКНС/ГУ/ряд: {{well.gu.name_ru}}</td>
                                <td>Дата посл. ПРС: {{getFormatedDate(this.well.prsWellWorkover.dbeg)}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>ГРП: {{getFormatedDate(this.well.gtm.dbeg)}}</td>
                                <td>Компенсация: </td>
                                <td>Доп. оборудования: </td>
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
                    <div class="row ">
                        <div class="col-12 center_block d-flex">
                            <div class="col-12">{{periodItem.id}}</div>
                        </div>
                        <div class="historical-info-parent">
                            <div class="historical-info">
                                <div class="daily-table bd-table-first">
                                    <table class="table text-center text-white  historical-table">
                                        <thead>
                                        <tr>
                                            <th>СЭ</th>
                                            <th>ø нас.</th>
                                            <th>L НКТ</th>
                                            <th>L</th>
                                            <th>N</th>
                                            <th>Показатель</th>
                                            <th>Тех. <br>Режим</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr
                                                v-if="periodItem.params.techMode"
                                                v-for="(techModeItem,index) in periodItem.params.techMode"
                                                :class="index % 2 === 0 ? 'header-background_light' : 'header-background_dark'"
                                                v-show="!techModeItem.isHide"
                                        >
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>
                                                {{techModeItem.label}}
                                            </td>
                                            <td>
                                                {{techModeItem.value.toFixed(0)}}
                                            </td>
                                        </tr>
                                        <tr class="header-background_dark">
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td colspan="2"  class="drop_down_link">
                                                <a href="#" class="link-secondary" v-show="periodItem.params.techMode[5].isHide" @click="toggleRowVisibility(periodItem.id)">Показать поля</a>
                                                <a href="#" class="link-secondary" v-show="!periodItem.params.techMode[5].isHide" @click="toggleRowVisibility(periodItem.id)">Скрыть поля</a>
                                            </td>
                                        </tr>
                                        <tr class="header-background_light">
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td colspan="2">Мероприятия</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="bd-table-second">
                                    <table class="table text-center text-white text-nowrap historical-table">
                                        <thead>
                                        <tr>
                                            <th
                                                    v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                    :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                            >
                                                &nbsp;<br>{{dayNumber}}
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="getColorByCell(periodItem.params.monthlyData[dayNumber-1].liq,
                                                            periodItem.params.techMode[0],
                                                            dayNumber,periodItem.params.activity)"
                                                >
                                                    {{periodItem.params.monthlyData[dayNumber-1].liq.toFixed(1)}}
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    {{periodItem.params.monthlyData[dayNumber-1].liqCut.toFixed(1)}}
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                            <tr>
                                            <tr>
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    {{periodItem.params.monthlyData[dayNumber-1].oil.toFixed(1)}}
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    {{periodItem.params.monthlyData[dayNumber-1].hdin.toFixed(1)}}
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >{{periodItem.params.monthlyData[dayNumber-1].workHours}} 
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td v-for="dayNumber in getDaysCountInMonth(periodItem.id)"> &nbsp; </td>
                                            </tr>
                                            <tr>
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                &nbsp;   
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    {{periodItem.params.monthlyData[dayNumber-1].gas.toFixed(1)}}
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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

           <div class="mt-2 d-flex justify-content-end bottom-buttons">
                <div class="p-1 d-flex align-items-center cursor-pointer" @click="nahdleMeasurementSchedule(),SET_VISIBLE_PRODUCTION(false)">
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
         
</template>
<script>
import ProductionWellsSchedule from "./ProductionWellsSchedule";
import moment from "moment";
import {bigdatahistoricalVisibleMutations,bigdatahistoricalVisibleState,globalloadingMutations} from '@store/helpers';

export default {
    components: {ProductionWellsSchedule},
    props: {
        well: {},
        changeColumnsVisible: Function
    },
    data() {
        return {
            isScheduleVisible: false,
            historicalData: [],
            isMeasurementScheduleActive: false,
            isActivityShown: false,
            isFreeInfoShown: false,
            historicalInfo: [],
            repairType: {
                1: 'КРС',
                3: 'ПРС',
            },
            isRowsHide: true
        };
    },
    methods: {
        getFormatedDate(data) {
            if (data != null && data != '') {
                return moment(data).format('DD/MM/YYYY')
            }
        },
        async nahdleMeasurementSchedule() {
            this.historicalData = this.productionMeasurementSchedule;
            this.SET_LOADING(true);
            for (let i in this.historicalData) {
                this.historicalData[i].params['activity'] = [];
            }
            this.historicalData = _.orderBy(this.historicalData, ['date'],['asc']);
            this.SET_LOADING(false);
            this.isMeasurementScheduleActive = true;
        },
        async getActivityByWell(month,year) {
            let queryOptions = {
                'month': moment(month,'MMM').month() + 1,
                'year': year
            };
            const response = await axios.get(this.localeUrl(`/api/bigdata/wells/get-activity/${this.well.id}`),{params:queryOptions});
            return response.data;
        },
        getDaysCountInMonth(monthYearString) {
            return moment(monthYearString, 'YYYY/MMM').daysInMonth();
        },
        ...bigdatahistoricalVisibleMutations([
            'SET_VISIBLE_PRODUCTION','SET_PRODUCTION_HISTORICAL'
        ]),
        assignInfoByDates(data) {
            let summary = [];
            _.forEach(data, (year, key) => {
                _.forEach(year, (month, monthNumber) => {
                    let date = moment(month[0].date, 'YYYY-MM-DD');
                    let daysCount = this.getDaysCountInMonth(date.format('YYYY/MMM'));
                    let workHours = _.sumBy(month, 'workHours') / 24;
                    if (workHours === 0) {
                        workHours = 1;
                    }
                    let monthSummary = {
                        'id': date.format('YYYY/MMM'),
                        'month': date.format('MMM'),
                        'year': date.format('YYYY'),
                        'date': date,
                        'isChecked': false,
                        'isVisible': false,
                        'water': _.sumBy(month, item => Number(item.liq)),
                        'oil': _.sumBy(month, 'oil'),
                        'oilDebit': _.sumBy(month, 'oil') / workHours,
                        'waterDebit': _.sumBy(month, item => Number(item.liq)) / workHours,
                        'waterCut': _.sumBy(month, 'liqCut') / month.length,
                        'hoursWorked': _.sumBy(month, 'workHours') / 24,
                        'gas': _.sumBy(month, 'gas'),
                        'params': {
                            'techMode': [
                                {
                                    'label': 'Жидкость',
                                    'value': _.sumBy(month, item => Number(item.liq)) / month.length,
                                    'isHide': !this.isRowsHide
                                },
                                {
                                    'label': 'Обводненность',
                                    'value': _.sumBy(month, 'liqCut') / month.length,
                                    'isHide': !this.isRowsHide
                                },
                                {
                                    'label': 'Нефть',
                                    'value': _.sumBy(month, 'oil') / month.length,
                                    'isHide': !this.isRowsHide
                                },
                                {
                                    'label': 'Обв. с учетом доли ост. св. воды, %',
                                    'value': 0,
                                    'isHide': !this.isRowsHide
                                },
                                {
                                    'label': 'Нефть. с учетом доли ост. св. воды, %',
                                    'value': 0,
                                    'isHide': !this.isRowsHide
                                },
                                {
                                    'label': 'Обв. не конд.пробы, %',
                                    'value': 0,
                                    'isHide': this.isRowsHide
                                },
                                {
                                    'label': 'Н дин.',
                                    'value': 0,
                                    'isHide': this.isRowsHide
                                },
                                {
                                    'label': 'Закючение ГДИС.',
                                    'value': 0,
                                    'isHide': this.isRowsHide
                                },
                                {
                                    'label': 'Причина простоя',
                                    'value': 0,
                                    'isHide': this.isRowsHide
                                },
                                {
                                    'label': 'Отработанное время',
                                    'value': 24,
                                    'isHide': this.isRowsHide
                                },
                                {
                                    'label': 'Жидкость м3/сут(телеметрия)',
                                    'value': 0,
                                    'isHide': this.isRowsHide
                                },
                                {
                                    'label': 'Обводненность, %(телеметрия)',
                                    'value': 0,
                                    'isHide': this.isRowsHide
                                },
                                {
                                    'label': 'Нефть, т/сут(телеметрия)',
                                    'value': 0,
                                    'isHide': this.isRowsHide
                                },
                                {
                                    'label': 'Газ.м3/сут(телеметрия)',
                                    'value': 0,
                                    'isHide': this.isRowsHide
                                },
                                {
                                    'label': 'Газовый фактор, м3/т(телеметрия)',
                                    'value': 0,
                                    'isHide': this.isRowsHide
                                },
                                {
                                    'label': 'Температура жидкости,%(телеметрия)',
                                    'value': 0,
                                    'isHide': this.isRowsHide
                                },
                                {
                                    'label': 'Добыча газа',
                                    'value': 0,
                                    'isHide': this.isRowsHide
                                },
                                {
                                    'label': 'Газовый фактор',
                                    'value': 0,
                                    'isHide': this.isRowsHide
                                }
                            ],
                            'monthlyData': month
                        }
                    };
                    this.historicalInfo.push(monthSummary);
                });
            });
            this.SET_PRODUCTION_HISTORICAL(this.historicalInfo);
        },
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        getColorByCell(currentValue,techMode,dayNumber,activity) {
            if (this.isWellStopped(dayNumber,activity)) {
                return 'background__red';
            }
            if (techMode && this.isTechModeBigger(currentValue,techMode)) {
                return 'background__yellow';
            }
            return '';
        },
        isWellStopped(dayNumber,activity) {
            let startDay = 0;
            let endDay = 0;
            if (activity.length > 0) {
                _.forEach(activity, (dayActivity) => {
                     if (dayActivity.dbeg) {
                         startDay = moment(dayActivity.dbeg).date();
                     }
                     if (dayActivity.dend) {
                         endDay = moment(dayActivity.dend).date();
                     }
                });
            }
            return dayNumber >= startDay && dayNumber <= endDay;
        },
        isTechModeBigger(currentValue, techMode) {
            return currentValue < Math.round(techMode.value);
        },
        toggleRowVisibility(id){
            this.isRowsHide = !this.isRowsHide
            var key = _.findKey(this.historicalInfo, function(o) { return o.id == id; });

            for (let i = 5; i < this.historicalInfo[key].params.techMode.length; i++) {
                this.historicalInfo[key].params.techMode[i].isHide = this.isRowsHide
            }

        }
    },
    async mounted() {
        this.SET_LOADING(true);
        const response = await axios.get(this.localeUrl(`/api/bigdata/wells/productionHistory/${this.well.id}`));
        this.assignInfoByDates(response.data);
        this.SET_LOADING(false);
    },
    computed: {
        ...bigdatahistoricalVisibleState(['productionMeasurementSchedule']),
    }
}
</script>
<style scoped lang="scss">
.drop_down_link{
    background: #2E50E9;
}
::-webkit-scrollbar {
  height: 4px;
  width: 4px;
}

.main-block {
    background-color: rgba(54, 59, 104, 1);
    color: #fff;
    // height: 780px;
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
.table.free-inform-table.svod-table tr {
    background: #CCFFFF;
}
.table.free-inform-table.svod-table tr:nth-child(even) {
    background: #FFFF99;
}


.red-col {
    background-color: rgba(239, 83, 80, 0.7) !important;
}

.table {
    border: 1px solid rgba(69,77,125,1);

    th {
        border: 1px solid #454D7D;
        background-color: #333975;
        font-size: 11px;
        font-weight: 700;
        padding: 0.3rem !important;
        height: 37px;
        vertical-align: middle;
    }
    th:nth-child(6) {
        font-size: 13px;
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
    background: url(/img/bd/arrow-up.svg) no-repeat;
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    background-position: center;
}
.historical-block-head {
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #272953;
    width: 100%;
}
.head_title {
    font-weight: bold;
    font-size: 12px;
    padding-left: 9px;
}
.historical_button{
    color: #D6D6E2;
    font-weight: bold;
    font-size: 12px;
    background-size: 20px;
    padding: 6px 17px 6px 40px;
    background-image: url('/img/bd/historical_icon.svg');
    background-color: #363B68;    background-repeat: no-repeat;
    background-position: 10px 7px;
    &:hover {
        cursor: pointer;
        background-color: #121227;
    }
}
.head_icon {
    width: 50px;
    height: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #2B3384;
    border-radius: 5px 5px 0px 0px;
    position: relative;
    bottom: 0;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    &:hover {
         background-color: #121227;
         cursor: pointer;
    }
}
.arrow-cut-down {
    background: url(/img/bd/arrow-down.svg) no-repeat;
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    background-position: center;
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
    background: #656A8A;
}
.header-background_light {
        background: #2C397E;
    background: #656A8A;
}
.header-background_dark td:nth-child(6), .header-background_light td:nth-child(6) {
    background: #636CC3;
    &.drop_down_link {
        background: #2E50E9;
        a {
            color:#fff
        }
    }
}
.historical-info {
    position: relative;
    padding-left: 450px;
}
.historical-info-parent {
    width: 810px;
    overflow-y: auto;
    margin: 0 15px;
    padding: 0 15px 0px 15px;
    background: #656A8A;
    table {
        margin-bottom: 0!important;
    }
    &::-webkit-scrollbar-track {
        background: #272953;
        height: 6px;
        width: 6px;
    }
    &::-webkit-scrollbar-thumb {
       background: #2E50E9;
       border-radius: 10px;
    }
}
.historical-container .center_block {
    background: #656A8A;
}
.historical-container > div {
    margin-bottom: 5px;
}
.min_history_table .historical-info-parent {
    width: 1030px;
}
.small_history_table .historical-info-parent {
    width:  1284px;
    /* overflow: hidden; */
}
.historical-container {
    // height: 610px;
    overflow: hidden;
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
.background__yellow {
    background-color: #E19821;
}
.background__red {
    background-color: #E94580 !important;
}
.daily-table.bd-table-first {
    width: 450px;
    position: absolute;
    left: 0;
}
</style>