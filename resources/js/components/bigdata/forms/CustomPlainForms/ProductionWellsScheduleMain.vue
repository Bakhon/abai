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
                        <div class="col-12 center_block d-flex justify-content-between">
                            <div class="col-12">{{periodItem.id}}</div>
                            <div class="head_icon" @click="periodItem.isExpanded = !periodItem.isExpanded">
                                <div
                                        :class="[periodItem.isExpanded ? 'arrow-cut-down' : 'arrow-expand']"
                                ></div>
                            </div>
                        </div>
                        <div class="historical-info-parent">
                            <div v-show="periodItem.isExpanded" class="historical-info">
                                <div :class="[periodItem.isHorizontalExpanded ? 'daily-table_width__450': 'daily-table_width__250','bd-table-first']">
                                    <table class="table text-center text-white  historical-table">
                                        <thead>
                                        <tr>
                                            <th v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">СЭ</th>
                                            <th v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">ø нас.</th>
                                            <th v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">L НКТ</th>
                                            <th v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">L</th>
                                            <th v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">N</th>
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
                                                <td v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">&nbsp;</td>
                                                <td v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">&nbsp;</td>
                                                <td v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">&nbsp;</td>
                                                <td v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">&nbsp;</td>
                                                <td v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">&nbsp;</td>
                                                <td
                                                        v-if="!techModeItem.disabledForDzo.includes(selectedDzo)"
                                                        class="background__light"
                                                >
                                                    {{techModeItem.label}}
                                                </td>
                                                <td v-if="!techModeItem.disabledForDzo.includes(selectedDzo)">
                                                    {{techModeItem.value}}
                                                </td>
                                            </tr>
                                            <tr class="header-background_dark">
                                                <td v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">&nbsp;</td>
                                                <td v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">&nbsp;</td>
                                                <td v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">&nbsp;</td>
                                                <td v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">&nbsp;</td>
                                                <td v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">&nbsp;</td>
                                                <td colspan="2"  class="drop_down_link">
                                                    <a href="#" class="link-secondary" v-show="periodItem.params.techMode[5].isHide" @click="toggleRowVisibility(periodItem.params.techMode)">Показать поля</a>
                                                    <a href="#" class="link-secondary" v-show="!periodItem.params.techMode[5].isHide" @click="toggleRowVisibility(periodItem.params.techMode)">Скрыть поля</a>
                                                </td>
                                            </tr>
                                        <tr class="header-background_light">
                                            <td v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">&nbsp;</td>
                                            <td v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">&nbsp;</td>
                                            <td v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">&nbsp;</td>
                                            <td v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">&nbsp;</td>
                                            <td v-if="periodItem.isHorizontalExpanded && !summaryDisabledByDzo.includes(selectedDzo)">&nbsp;</td>
                                            <td class="background__light" colspan="2">Мероприятия</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div v-if="!summaryDisabledByDzo.includes(selectedDzo)" class="table-arrow">
                                        <div
                                                :class="[periodItem.isHorizontalExpanded ? 'arrow-right' : 'arrow-left','cursor-pointer']"
                                                @click="periodItem.isHorizontalExpanded = !periodItem.isHorizontalExpanded"
                                        >
                                        </div>
                                    </div>
                                </div>
                                <div :class="[periodItem.isHorizontalExpanded || !summaryDisabledByDzo.includes(selectedDzo) ? 'days-table_left__450' : 'days-table_left__250','bd-table-second']">
                                    <table class="table text-center text-white text-nowrap historical-table days-decomposition">
                                        <thead>
                                            <tr>
                                                <th
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    {{dayNumber}}
                                                </th>
                                                <th>Средние <br>(по методике)</th>
                                                <th>Суммарные <br>(по методике)</th>
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
                                                    {{formatNumber(periodItem.params.monthlyData[dayNumber-1].liq.toFixed(1))}}
                                                </td>
                                                <td v-else>
                                                    &nbsp;
                                                </td>
                                                <td>-</td>
                                                <td>{{formatNumber(periodItem.params.techMode[0].value.toFixed(1))}}</td>
                                            </tr>
                                            <tr>
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="getColorByCell(periodItem.params.monthlyData[dayNumber-1].liqCut,
                                                                periodItem.params.techMode[1],
                                                                dayNumber,periodItem.params.activity)"
                                                >
                                                    {{periodItem.params.monthlyData[dayNumber-1].liqCut.toFixed(1)}}
                                                </td>
                                                <td v-else>
                                                    &nbsp;
                                                </td>
                                                <td>{{periodItem.params.techMode[1].value.toFixed(1)}}</td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="getColorByCell(periodItem.params.monthlyData[dayNumber-1].oil,
                                                                periodItem.params.techMode[2],
                                                                dayNumber,periodItem.params.activity)"
                                                >
                                                    {{formatNumber(periodItem.params.monthlyData[dayNumber-1].oil.toFixed(1))}}
                                                </td>
                                                <td v-else>
                                                    &nbsp;
                                                </td>
                                                <td>-</td>
                                                <td>{{formatNumber(periodItem.params.techMode[2].value.toFixed(1))}}</td>
                                            </tr>
                                            <tr v-if="summaryDisabledByDzo.includes(selectedDzo) && !periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="getColorByCell(periodItem.params.monthlyData[dayNumber-1].hdin,
                                                                periodItem.params.techMode[6],
                                                                dayNumber,periodItem.params.activity)"
                                                >
                                                    {{formatNumber(periodItem.params.monthlyData[dayNumber-1].hdin.toFixed(1))}}
                                                </td>
                                                <td v-else>
                                                    &nbsp;
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr v-else>
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>
                                                    &nbsp;
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr v-if="summaryDisabledByDzo.includes(selectedDzo) && !periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    {{periodItem.params.monthlyData[dayNumber-1].workHours}}
                                                </td>
                                                <td v-else>
                                                    &nbsp;
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr v-else>
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>

                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr v-if="summaryDisabledByDzo.includes(selectedDzo) && !periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="getColorByCell(periodItem.params.monthlyData[dayNumber-1].gas,
                                                                periodItem.params.techMode[16],
                                                                dayNumber,periodItem.params.activity)"
                                                >
                                                    {{formatNumber(periodItem.params.monthlyData[dayNumber-1].gas.toFixed(1))}}
                                                </td>
                                                <td v-else>
                                                    &nbsp;
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr v-else>
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>

                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>

                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>
                                                    &nbsp;
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>
                                                    &nbsp;
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>
                                                    &nbsp;
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>
                                                    &nbsp;
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>
                                                    &nbsp;
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>
                                                    &nbsp;
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td v-for="dayNumber in getDaysCountInMonth(periodItem.id)"> &nbsp; </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>
                                                    &nbsp;
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>
                                                    &nbsp;
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>
                                                    &nbsp;
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>
                                                    &nbsp;
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr v-show="!periodItem.params.techMode[5].isHide">
                                                <td
                                                        v-for="dayNumber in getDaysCountInMonth(periodItem.id)"
                                                        v-if="periodItem.params.monthlyData[dayNumber-1]"
                                                        :class="isWellStopped(dayNumber,periodItem.params.activity) ? 'background__red' : ''"
                                                >
                                                    &nbsp;
                                                </td>
                                                <td v-else>
                                                    &nbsp;
                                                </td>
                                                <td></td>
                                                <td></td>
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
        changeColumnsVisible: Function,
        selectedDzo: null
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
            isRowsHide: true,
            summaryDisabledByDzo: ["KGM"],
            techMode: [],
            techModeMapping: {
                'liquid': 0,
                'oil': 2,
                'wcut': 1
            }
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
                        'isExpanded': true,
                        'isHorizontalExpanded': true,
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
                                    'value': '-',
                                    'isHide': !this.isRowsHide,
                                    'disabledForDzo': []
                                },
                                {
                                    'label': 'Обводненность',
                                    'value': '-',
                                    'isHide': !this.isRowsHide,
                                    'disabledForDzo': []
                                },
                                {
                                    'label': 'Нефть',
                                    'value': '-',
                                    'isHide': !this.isRowsHide,
                                    'disabledForDzo': []
                                },
                                {
                                    'label': 'Обв. с учетом доли ост. св. воды, %',
                                    'value': '-',
                                    'isHide': !this.isRowsHide,
                                    'disabledForDzo': ["KGM"]
                                },
                                {
                                    'label': 'Нефть. с учетом доли ост. св. воды, %',
                                    'value': '-',
                                    'isHide': !this.isRowsHide,
                                    'disabledForDzo': ["KGM"]
                                },
                                {
                                    'label': 'Обв. не конд.пробы, %',
                                    'value': '-',
                                    'isHide': this.isRowsHide,
                                    'disabledForDzo': ["KGM"]
                                },
                                {
                                    'label': 'Н дин.',
                                    'value': '-',
                                    'isHide': this.isRowsHide,
                                    'disabledForDzo': []
                                },
                                {
                                    'label': 'Закючение ГДИС.',
                                    'value': '-',
                                    'isHide': this.isRowsHide,
                                    'disabledForDzo': ["KGM"]
                                },
                                {
                                    'label': 'Причина простоя',
                                    'value': '-',
                                    'isHide': this.isRowsHide,
                                    'disabledForDzo': ["KGM"]
                                },
                                {
                                    'label': 'Отработанное время',
                                    'value': '-',
                                    'isHide': this.isRowsHide,
                                    'disabledForDzo': []
                                },
                                {
                                    'label': 'Жидкость м3/сут(телеметрия)',
                                    'value': '-',
                                    'isHide': this.isRowsHide,
                                    'disabledForDzo': ["KGM"]
                                },
                                {
                                    'label': 'Обводненность, %(телеметрия)',
                                    'value': '-',
                                    'isHide': this.isRowsHide,
                                    'disabledForDzo': ["KGM"]
                                },
                                {
                                    'label': 'Нефть, т/сут(телеметрия)',
                                    'value': '-',
                                    'isHide': this.isRowsHide,
                                    'disabledForDzo': ["KGM"]
                                },
                                {
                                    'label': 'Газ.м3/сут(телеметрия)',
                                    'value': '-',
                                    'isHide': this.isRowsHide,
                                    'disabledForDzo': ["KGM"]
                                },
                                {
                                    'label': 'Газовый фактор, м3/т(телеметрия)',
                                    'value': '-',
                                    'isHide': this.isRowsHide,
                                    'disabledForDzo': ["KGM"]
                                },
                                {
                                    'label': 'Температура жидкости,%(телеметрия)',
                                    'value': '-',
                                    'isHide': this.isRowsHide,
                                    'disabledForDzo': ["KGM"]
                                },
                                {
                                    'label': 'Добыча газа',
                                    'value': '-',
                                    'isHide': this.isRowsHide,
                                    'disabledForDzo': []
                                },
                                {
                                    'label': 'Газовый фактор',
                                    'value': '-',
                                    'isHide': this.isRowsHide,
                                    'disabledForDzo': []
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
        toggleRowVisibility(items){
            for (let i = 5; i < items.length; i++) {
                items[i].isHide = !items[i].isHide;
            }
        },
        formatNumber(num) {
            return new Intl.NumberFormat("ru-RU").format(num);
        },
        async getProductionTechMode() {
            let dates = [];
            for (let i in this.historicalData) {
                dates.push(moment(this.historicalData[i]['id'],'YYYY/MMM').format('YYYY-MM-DD'));
            }
            let queryOptions = {
                'year': _.map(this.historicalData, 'year'),
                'dates': dates
            };
            const response = await axios.get(this.localeUrl(`/api/bigdata/wells/production/techmode/${this.well.id}`),{params:queryOptions});
            return response.data;
        },
        async updateByTechMode() {
            this.SET_LOADING(true);
            if (this.historicalData.length > 0) {
                this.techMode = await this.getProductionTechMode();
            }
            for (let i in this.historicalData) {
                let techModeItem = this.techMode.find(o => o.dbeg === this.historicalData[i].date.format("YYYY-MM-DD"));
                for (let y in techModeItem) {
                    if (!isNaN(this.techModeMapping[y])) {
                        this.historicalData[i].params['techMode'][this.techModeMapping[y]].value = techModeItem[y];
                    }
                }
            }
            this.SET_LOADING(false);
        }
    },
    async mounted() {
        let uri = `/api/bigdata/wells/productionHistory/${this.well.id}`;
        this.SET_LOADING(true);
        const response = await axios.get(this.localeUrl(uri));
        this.assignInfoByDates(response.data);
        this.nahdleMeasurementSchedule();
        this.SET_LOADING(false);
    },
    computed: {
        ...bigdatahistoricalVisibleState(['productionMeasurementSchedule']),
    },
    watch: {
        "productionMeasurementSchedule": async function(data) {
            this.nahdleMeasurementSchedule();
            this.updateByTechMode();
        }
    }
}
</script>
<style scoped lang="scss">
.drop_down_link{
    background: #2E50E9;
    a {
        color: #fff;
    }
}
::-webkit-scrollbar {
  height: 7px;
  width: 7px;
}

.main-block {
    background-color: rgba(54, 59, 104, 1);
    color: #fff;
    
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
        height: 43px;
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

}
.historical-info {
    position: relative;
    width: 100%;
}
.historical-info-parent {
    margin: 0 15px;
    padding: 0 15px 0px 15px;
    background: #656A8A;
    width: 100%;
    table {
        margin-bottom: 0!important;
    }
    
}
.historical-container .center_block {
    background: #656A8A;
}
.historical-container > div {
    margin-bottom: 5px;
}

.historical-container {
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
.bd-table-first {
    position: relative;
}
.daily-table_width__450 {
    width: 450px;
}
.daily-table_width__250 {
    width: 276px;
}
.table-arrow {
    background: #8F95BA;
    border-radius: 5px 0px 0px 5px;
    width: 13px;
    height: 50px;
    position: absolute;
    left: -13px;
    top: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transform: translateY(-50%);
    &.hide {
            transform: translateY(-50%) rotate(180deg);
    }
}
.bd-table-second {
    overflow-y: hidden;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    overflow-x: auto;
    &::-webkit-scrollbar-track {
        background: #272953;
    }
    &::-webkit-scrollbar-thumb {
       background: #2E50E9;
       border-radius: 10px;
    }
}
.days-table_left__450 {
    left: 450px;
}
.days-table_left__250 {
    left: 276px;
}
.days-decomposition {
    th {
        height: 43px;
        vertical-align: middle;
    }
    tr {
        td:last-child, td:nth-last-child(2) {
            background: #636CC3;
        }
    }
}
.background__light {
    background: #636CC3;
}
.arrow-left {
    background: url(/img/bd/arrow-well-left.svg) no-repeat;
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    background-position: center;
}
.arrow-right {
    background: url(/img/bd/arrow-well-right.svg) no-repeat;
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    background-position: center;
}
</style>