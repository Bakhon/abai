<template>
    <div class="page-wrapper">
        <div class="page-container row">
            <div class="col-12 mt-3 header">
                <transition name="bounce">
                    <div v-if="isTypeTimerActive" class="img-play"></div>
                </transition>
                <transition name="bounce">
                    <div v-if="!isTypeTimerActive" class="img-pause"></div>
                </transition>
                <div class="header-title">
                    {{headerTitle}}
                </div>
                <transition name="fade" mode="out-in">
                    <div v-if="isOpecActive" class="title-opec ml-2">
                        ОПЕК+
                    </div>
                </transition>
                <div class="img-download" @click="exportToExcel()"></div>
            </div>
            <div class="col-12 mt-3" @click="switchTimers()">
                <div class="reason-box" id="decreaseReason">{{decreaseReason}}</div>
                <table class="main-table col-12">
                    <tr>
                        <th rowspan="2">№ п/п</th>
                        <th rowspan="2">Предприятия</th>
                        <th rowspan="2">
                            План на {{currentYear}} г.
                        </th>
                        <th :class="!isOpecActive ? '' : 'hide-block'" rowspan="2">
                            План на {{currentMonthName}} месяц
                        </th>
                        <th :class="isOpecActive ? '' : 'hide-block'" rowspan="2">
                            План на {{currentMonthName}} месяц <br>
                            с учетом ОПЕК+
                        </th>
                        <th colspan="3" class="background-delimeters">СУТОЧНАЯ</th> <!-- >суточная <-->
                        <th colspan="3" class="background-delimeters">С НАЧАЛА МЕСЯЦА</th> <!-- >с начала месяца <-->
                        <th colspan="3" class="background-delimeters">С НАЧАЛА ГОДА</th> <!-- >с начала года <-->
                    </tr>
                    <tr>
                        <th :class="!isOpecActive ? '' : 'hide-block'">План</th>
                        <th :class="isOpecActive ? '' : 'hide-block'">
                            План<br>
                            с учетом ОПЕК+
                        </th>
                        <th>Факт</th>
                        <th :class="!isOpecActive ? '' : 'hide-block'">(+,-)</th>
                        <th :class="isOpecActive ? '' : 'hide-block'">
                            (+,-)<br>
                            с учетом ОПЕК+
                        </th>
                        <th :class="!isOpecActive ? '' : 'hide-block'">План</th>
                        <th :class="isOpecActive ? '' : 'hide-block'">
                            План<br>
                            с учетом ОПЕК+
                        </th>
                        <th>Факт</th>
                        <th :class="!isOpecActive ? '' : 'hide-block'">(+,-)</th>
                        <th :class="isOpecActive ? '' : 'hide-block'">
                            (+,-)<br>
                            с учетом ОПЕК+
                        </th>
                        <th :class="!isOpecActive ? '' : 'hide-block'">План</th>
                        <th :class="isOpecActive ? '' : 'hide-block'">
                            План<br>
                            с учетом ОПЕК+
                        </th>
                        <th>Факт</th>
                        <th :class="!isOpecActive ? '' : 'hide-block'">(+,-)</th>
                        <th :class="isOpecActive ? '' : 'hide-block'">
                            (+,-)<br>
                            с учетом ОПЕК+
                        </th>
                    </tr>
                    <tr
                            v-for="(item,index) in tableOutput.participationByKMG"
                            class="background-dark"
                    >
                        <td>{{item.number}}</td>
                        <td :class="index === 1 ? 'summary-header_text-align' : ''">{{item.dzo}}</td>
                        <td >{{getFormattedNumber(item.yearlyPlan)}}</td>
                        <td v-if="!isOpecActive">{{getFormattedNumber(item.monthlyPlan)}}</td>
                        <td v-else>{{getFormattedNumber(item.monthlyPlanOpec)}}</td>
                        <td v-if="!isOpecActive">{{getFormattedNumber(item.planByDay)}}</td>
                        <td v-else>{{getFormattedNumber(item.planOpecByDay)}}</td>
                        <td>{{getFormattedNumber(item.factByDay)}}</td>
                        <td
                                v-if="!isOpecActive"
                                :class="getColorBy(item.differenceByDay)"
                        >
                            {{getFormattedNumber(item.differenceByDay)}}
                        </td>
                        <td
                                v-else
                                :class="getColorBy(item.differenceOpecByDay)"
                        >
                            {{getFormattedNumber(item.differenceOpecByDay)}}
                        </td>

                        <td v-if="!isOpecActive">{{getFormattedNumber(item.planByMonth)}}</td>
                        <td v-else>{{getFormattedNumber(item.planOpecByMonth)}}</td>
                        <td>{{getFormattedNumber(item.factByMonth)}}</td>
                        <td
                                v-if="!isOpecActive"
                                :class="getColorBy(item.differenceByMonth)"
                        >
                            {{getFormattedNumber(item.differenceByMonth)}}
                        </td>
                        <td
                                v-else
                                :class="getColorBy(item.differenceOpecByMonth)"
                        >
                            {{getFormattedNumber(item.differenceOpecByMonth)}}
                        </td>

                        <td v-if="!isOpecActive">{{getFormattedNumber(item.planByYear)}}</td>
                        <td v-else>{{getFormattedNumber(item.planOpecByYear)}}</td>
                        <td>{{getFormattedNumber(item.factByYear)}}</td>
                        <td
                                v-if="!isOpecActive"
                                :class="getColorBy(item.differenceByYear)"
                        >
                            {{getFormattedNumber(item.differenceByYear)}}
                        </td>
                        <td
                                v-else
                                :class="getColorBy(item.differenceOpecByYear)"
                        >
                            {{getFormattedNumber(item.differenceOpecByYear)}}
                        </td>
                    </tr>
                    <tr
                            v-for="(item, index) in tableOutput.participationByDzo"
                            :class="getRowClass(index)"
                    >
                        <td v-if="index !== 1">{{item.number}}</td>
                        <td v-else></td>
                        <td :class="[1,13,14,15].includes(index) ? 'troubled-companies-padding' : ''">
                            {{companiesNameMapping.withParticipation[item.dzo]}}
                        </td>
                        <td>{{getFormattedNumber(item.yearlyPlan)}}</td>

                        <td v-if="!isOpecActive">{{getFormattedNumber(item.monthlyPlan)}}</td>
                        <td v-else>{{getFormattedNumber(item.monthlyPlanOpec)}}</td>

                        <td v-if="!isOpecActive">{{getFormattedNumber(item.planByDay)}}</td>
                        <td v-else>{{getFormattedNumber(item.planOpecByDay)}}</td>
                        <td>{{getFormattedNumber(item.factByDay)}}</td>
                        <td
                                v-if="!isOpecActive"
                                :class="getColorBy(item.differenceByDay)"
                                @mouseover="mouseOver($event,item.reason)"
                                @mouseleave="mouseLeave"
                        >
                            {{getFormattedNumber(item.differenceByDay)}}
                        </td>
                        <td
                                v-else
                                :class="getColorBy(item.differenceOpecByDay)"
                        >
                            {{getFormattedNumber(item.differenceOpecByDay)}}
                        </td>

                        <td v-if="!isOpecActive">{{getFormattedNumber(item.planByMonth)}}</td>
                        <td v-else>{{getFormattedNumber(item.planOpecByMonth)}}</td>
                        <td>{{getFormattedNumber(item.factByMonth)}}</td>
                        <td
                                v-if="!isOpecActive"
                                :class="getColorBy(item.differenceByMonth)"
                        >
                            {{getFormattedNumber(item.differenceByMonth)}}
                        </td>
                        <td
                                v-else
                                :class="getColorBy(item.differenceOpecByMonth)"
                        >
                            {{getFormattedNumber(item.differenceOpecByMonth)}}
                        </td>

                        <td v-if="!isOpecActive">{{getFormattedNumber(item.planByYear)}}</td>
                        <td v-else>{{getFormattedNumber(item.planOpecByYear)}}</td>
                        <td>{{getFormattedNumber(item.factByYear)}}</td>
                        <td
                                v-if="!isOpecActive"
                                :class="getColorBy(item.differenceByYear)"
                        >
                            {{getFormattedNumber(item.differenceByYear)}}
                        </td>
                        <td
                                v-else
                                :class="getColorBy(item.differenceOpecByYear)"
                        >
                            {{getFormattedNumber(item.differenceOpecByYear)}}
                        </td>
                    </tr>
                    <tr class="empty-row">
                        <td></td>
                    </tr>
                    <tr
                            v-for="(item,index) in tableOutput.byKMG"
                            :class="index > 0 ? 'background-dark hide-block' :'background-dark'"
                    >
                        <td>{{item.number}}</td>
                        <td>{{item.dzo}}</td>
                        <td >{{getFormattedNumber(item.yearlyPlan)}}</td>

                        <td v-if="!isOpecActive">{{getFormattedNumber(item.monthlyPlan)}}</td>
                        <td v-else>{{getFormattedNumber(item.monthlyPlanOpec)}}</td>

                        <td v-if="!isOpecActive">{{getFormattedNumber(item.planByDay)}}</td>
                        <td v-else>{{getFormattedNumber(item.planOpecByDay)}}</td>
                        <td>{{getFormattedNumber(item.factByDay)}}</td>
                        <td
                                v-if="!isOpecActive"
                                :class="getColorBy(item.differenceByDay)"
                        >
                            {{getFormattedNumber(item.differenceByDay)}}
                        </td>
                        <td
                                v-else
                                :class="getColorBy(item.differenceOpecByDay)"
                        >
                            {{getFormattedNumber(item.differenceOpecByDay)}}
                        </td>

                        <td v-if="!isOpecActive">{{getFormattedNumber(item.planByMonth)}}</td>
                        <td v-else>{{getFormattedNumber(item.planOpecByMonth)}}</td>
                        <td>{{getFormattedNumber(item.factByMonth)}}</td>
                        <td
                                v-if="!isOpecActive"
                                :class="getColorBy(item.differenceByMonth)"
                        >
                            {{getFormattedNumber(item.differenceByMonth)}}
                        </td>
                        <td
                                v-else
                                :class="getColorBy(item.differenceOpecByMonth)"
                        >
                            {{getFormattedNumber(item.differenceOpecByMonth)}}
                        </td>

                        <td v-if="!isOpecActive">{{getFormattedNumber(item.planByYear)}}</td>
                        <td v-else>{{getFormattedNumber(item.planOpecByYear)}}</td>
                        <td>{{getFormattedNumber(item.factByYear)}}</td>
                        <td
                                v-if="!isOpecActive"
                                :class="getColorBy(item.differenceByYear)"
                        >
                            {{getFormattedNumber(item.differenceByYear)}}
                        </td>
                        <td
                                v-else
                                :class="getColorBy(item.differenceOpecByYear)"
                        >
                            {{getFormattedNumber(item.differenceOpecByYear)}}
                        </td>
                    </tr>
                    <tr
                            v-for="(item, index) in tableOutput.byDzo"
                            :class="getRowClass(index)"
                    >
                        <td v-if="index !== 1">{{item.number}}</td>
                        <td v-else></td>
                        <td
                                :class="index === 1 ? 'troubled-companies-padding' : ''"
                        >
                            {{companiesNameMapping.summaryByDzo[item.dzo]}}
                        </td>
                        <td >{{getFormattedNumber(item.yearlyPlan)}}</td>

                        <td v-if="!isOpecActive">{{getFormattedNumber(item.monthlyPlan)}}</td>
                        <td v-else>{{getFormattedNumber(item.monthlyPlanOpec)}}</td>

                        <td v-if="!isOpecActive">{{getFormattedNumber(item.planByDay)}}</td>
                        <td v-else>{{getFormattedNumber(item.planOpecByDay)}}</td>
                        <td>{{getFormattedNumber(item.factByDay)}}</td>
                        <td
                                v-if="!isOpecActive"
                                :class="getColorBy(item.differenceByDay)"
                        >
                            {{getFormattedNumber(item.differenceByDay)}}
                        </td>
                        <td
                                v-else
                                :class="getColorBy(item.differenceOpecByDay)"
                        >
                            {{getFormattedNumber(item.differenceOpecByDay)}}
                        </td>

                        <td v-if="!isOpecActive">{{getFormattedNumber(item.planByMonth)}}</td>
                        <td v-else>{{getFormattedNumber(item.planOpecByMonth)}}</td>
                        <td>{{getFormattedNumber(item.factByMonth)}}</td>
                        <td
                                v-if="!isOpecActive"
                                :class="getColorBy(item.differenceByMonth)"
                        >
                            {{getFormattedNumber(item.differenceByMonth)}}
                        </td>
                        <td
                                v-else
                                :class="getColorBy(item.differenceOpecByMonth)"
                        >
                            {{getFormattedNumber(item.differenceOpecByMonth)}}
                        </td>

                        <td v-if="!isOpecActive">{{getFormattedNumber(item.planByYear)}}</td>
                        <td v-else>{{getFormattedNumber(item.planOpecByYear)}}</td>
                        <td>{{getFormattedNumber(item.factByYear)}}</td>
                        <td
                                v-if="!isOpecActive"
                                :class="getColorBy(item.differenceByYear)"
                        >
                            {{getFormattedNumber(item.differenceByYear)}}
                        </td>
                        <td
                                v-else
                                :class="getColorBy(item.differenceOpecByYear)"
                        >
                            {{getFormattedNumber(item.differenceOpecByYear)}}
                        </td>
                    </tr>
                </table>
                <table class="col-12" id="exportReport" style="display:none">
                    <tr>
                        <th colspan="20" style="font-family: arial; font-size: 16px; font-weight: bold; text-align: center">Оперативная суточная информация по добыче, сдаче нефти и газового конденсата АО НК "КазМунайГаз"</th>
                    </tr>
                    <tr style="font-family: Arial; font-size: 13px; font-style: italic;">
                        <th></th>
                        <th>по состоянию на:</th>
                        <th>{{currentDate}}</th>
                    </tr>
                    <tr style="font-family: Arial; font-size: 13px;">
                        <th style="border: 1px solid black" rowspan="3">№ п/п</th>
                        <th style="border: 1px solid black; width: 300px" rowspan="3">Предприятия</th>
                        <th style="border: 1px solid black" colspan="18" class="background-delimeters">ДОБЫЧА, тонн</th>
                        <th style="border: 1px solid black" colspan="18" class="background-delimeters">СДАЧА, тонн</th>
                    </tr>
                    <tr style="font-family: Arial; font-size: 13px;">
                        <th style="border: 1px solid black" rowspan="2">
                            План на {{currentYear}} г.
                        </th>
                        <th style="border: 1px solid black" rowspan="2">
                            План на {{currentMonthName}} месяц
                        </th>
                        <th style="border: 1px solid black" rowspan="2">
                            План на {{currentMonthName}} месяц <br>
                            с учетом ОПЕК+
                        </th>
                        <th style="border: 1px solid black" colspan="5" class="background-delimeters">СУТОЧНАЯ</th> <!-- >суточная <-->
                        <th style="border: 1px solid black" colspan="5" class="background-delimeters">С НАЧАЛА МЕСЯЦА</th> <!-- >с начала месяца <-->
                        <th style="border: 1px solid black" colspan="5" class="background-delimeters">С НАЧАЛА ГОДА</th> <!-- >с начала года <-->
                        <th style="border: 1px solid black" rowspan="2">
                            План на {{currentYear}} г.
                        </th>
                        <th style="border: 1px solid black" rowspan="2">
                            План на {{currentMonthName}} месяц
                        </th>
                        <th style="border: 1px solid black" rowspan="2">
                            План на {{currentMonthName}} месяц <br>
                            с учетом ОПЕК+
                        </th>
                        <th style="border: 1px solid black" colspan="5" class="background-delimeters">СУТОЧНАЯ</th> <!-- >суточная <-->
                        <th style="border: 1px solid black" colspan="5" class="background-delimeters">С НАЧАЛА МЕСЯЦА</th> <!-- >с начала месяца <-->
                        <th style="border: 1px solid black" colspan="5" class="background-delimeters">С НАЧАЛА ГОДА</th> <!-- >с начала года <-->
                    </tr>
                    <tr style="font-family: Arial; font-size: 13px;">
                        <th style="border: 1px solid black" >План</th>
                        <th style="border: 1px solid black" >
                            План<br>
                            с учетом ОПЕК+
                        </th>
                        <th style="border: 1px solid black" >Факт</th>
                        <th style="border: 1px solid black" >(+,-)</th>
                        <th style="border: 1px solid black" >
                            (+,-)<br>
                            с учетом ОПЕК+
                        </th>
                        <th style="border: 1px solid black" >План</th>
                        <th style="border: 1px solid black" >
                            План<br>
                            с учетом ОПЕК+
                        </th>
                        <th style="border: 1px solid black" >Факт</th>
                        <th style="border: 1px solid black" >(+,-)</th>
                        <th style="border: 1px solid black" >
                            (+,-)<br>
                            с учетом ОПЕК+
                        </th>
                        <th style="border: 1px solid black" >План</th>
                        <th style="border: 1px solid black" >
                            План<br>
                            с учетом ОПЕК+
                        </th>
                        <th style="border: 1px solid black" >Факт</th>
                        <th style="border: 1px solid black" >(+,-)</th>
                        <th style="border: 1px solid black" >
                            (+,-)<br>
                            с учетом ОПЕК+
                        </th>
                        <th style="border: 1px solid black" >План</th>
                        <th style="border: 1px solid black" >
                            План<br>
                            с учетом ОПЕК+
                        </th>
                        <th style="border: 1px solid black" >Факт</th>
                        <th style="border: 1px solid black" >(+,-)</th>
                        <th style="border: 1px solid black" >
                            (+,-)<br>
                            с учетом ОПЕК+
                        </th>
                        <th style="border: 1px solid black" >План</th>
                        <th style="border: 1px solid black" >
                            План<br>
                            с учетом ОПЕК+
                        </th>
                        <th style="border: 1px solid black" >Факт</th>
                        <th style="border: 1px solid black" >(+,-)</th>
                        <th style="border: 1px solid black" >
                            (+,-)<br>
                            с учетом ОПЕК+
                        </th>
                        <th style="border: 1px solid black" >План</th>
                        <th style="border: 1px solid black" >
                            План<br>
                            с учетом ОПЕК+
                        </th>
                        <th style="border: 1px solid black" >Факт</th>
                        <th style="border: 1px solid black" >(+,-)</th>
                        <th style="border: 1px solid black" >
                            (+,-)<br>
                            с учетом ОПЕК+
                        </th>
                    </tr>
                    <tr
                            v-for="(item, index) in summaryForExport.byKMG"
                            :style="getStyleForSummary(index,true)"
                    >
                        <td v-if="index !== 3" style="text-align: center">{{item.number}}</td>
                        <td v-else></td>
                        <td v-if="[3,15,16,17].includes(index)" style="text-align: left">
                            &emsp;&emsp;{{companiesNameMapping.withParticipation[item.dzo]}}
                        </td>
                        <td v-else style="text-align: left">
                            {{companiesNameMapping.withParticipation[item.dzo]}}
                        </td>
                        <td>{{getFormattedNumber(item.yearlyPlan)}}</td>
                        <td>{{getFormattedNumber(item.monthlyPlan)}}</td>
                        <td>{{getFormattedNumber(item.monthlyPlanOpec)}}</td>
                        <td>{{getFormattedNumber(item.planByDay)}}</td>
                        <td>{{getFormattedNumber(item.planOpecByDay)}}</td>
                        <td>{{getFormattedNumber(item.factByDay)}}</td>
                        <td :style="getStyleByDifference(item.differenceByDay)">
                            {{getFormattedNumber(item.differenceByDay)}}
                        </td>
                        <td :style="getStyleByDifference(item.differenceOpecByDay)">
                            {{getFormattedNumber(item.differenceOpecByDay)}}
                        </td>
                        <td>{{getFormattedNumber(item.planByMonth)}}</td>
                        <td>{{getFormattedNumber(item.planOpecByMonth)}}</td>
                        <td>{{getFormattedNumber(item.factByMonth)}}</td>
                        <td :style="getStyleByDifference(item.differenceByMonth)">
                            {{getFormattedNumber(item.differenceByMonth)}}
                        </td>
                        <td :style="getStyleByDifference(item.differenceOpecByMonth)">
                            {{getFormattedNumber(item.differenceOpecByMonth)}}
                        </td>
                        <td>{{getFormattedNumber(item.planByYear)}}</td>
                        <td>{{getFormattedNumber(item.planOpecByYear)}}</td>
                        <td>{{getFormattedNumber(item.factByYear)}}</td>
                        <td :style="getStyleByDifference(item.differenceByYear)">
                            {{getFormattedNumber(item.differenceByYear)}}
                        </td>
                        <td :style="getStyleByDifference(item.differenceOpecByYear)">
                            {{getFormattedNumber(item.differenceOpecByYear)}}
                        </td>
                        <td>{{getFormattedNumber(item.deliveryYearlyPlan)}}</td>
                        <td>{{getFormattedNumber(item.deliveryMonthlyPlan)}}</td>
                        <td>{{getFormattedNumber(item.deliveryMonthlyPlanOpec)}}</td>
                        <td>{{getFormattedNumber(item.deliveryPlanByDay)}}</td>
                        <td>{{getFormattedNumber(item.deliveryPlanOpecByDay)}}</td>
                        <td>{{getFormattedNumber(item.deliveryFactByDay)}}</td>
                        <td :style="getStyleByDifference(item.deliveryDifferenceByDay)">
                            {{getFormattedNumber(item.deliveryDifferenceByDay)}}
                        </td>
                        <td :style="getStyleByDifference(item.deliveryDifferenceOpecByDay)">
                            {{getFormattedNumber(item.deliveryDifferenceOpecByDay)}}
                        </td>
                        <td>{{getFormattedNumber(item.deliveryPlanByMonth)}}</td>
                        <td>{{getFormattedNumber(item.deliveryPlanOpecByMonth)}}</td>
                        <td>{{getFormattedNumber(item.deliveryFactByMonth)}}</td>
                        <td :style="getStyleByDifference(item.deliveryDifferenceByMonth)">
                            {{getFormattedNumber(item.deliveryDifferenceByMonth)}}
                        </td>
                        <td :style="getStyleByDifference(item.deliveryDifferenceOpecByMonth)">
                            {{getFormattedNumber(item.deliveryDifferenceOpecByMonth)}}
                        </td>
                        <td>{{getFormattedNumber(item.deliveryPlanByYear)}}</td>
                        <td>{{getFormattedNumber(item.deliveryPlanOpecByYear)}}</td>
                        <td>{{getFormattedNumber(item.deliveryFactByYear)}}</td>
                        <td :style="getStyleByDifference(item.deliveryDifferenceByYear)">
                            {{getFormattedNumber(item.deliveryDifferenceByYear)}}
                        </td>
                        <td :style="getStyleByDifference(item.deliveryDifferenceOpecByYear)">
                            {{getFormattedNumber(item.deliveryDifferenceOpecByYear)}}
                        </td>
                    </tr>
                    <tr class="row-divider">
                    </tr>
                    <tr
                            v-for="(item, index) in summaryForExport.byDzo"
                            :style="getStyleForSummary(index, false)"
                    >
                        <td v-if="index !== 3" style="text-align: center">{{item.number}}</td>
                        <td v-else></td>
                        <td v-if="index === 3" style="text-align: left">
                            &emsp;&emsp;{{companiesNameMapping.summaryByDzo[item.dzo]}}
                        </td>
                        <td v-else style="text-align: left">
                            {{companiesNameMapping.summaryByDzo[item.dzo]}}
                        </td>
                        <td>{{getFormattedNumber(item.yearlyPlan)}}</td>
                        <td>{{getFormattedNumber(item.monthlyPlan)}}</td>
                        <td>{{getFormattedNumber(item.monthlyPlanOpec)}}</td>
                        <td>{{getFormattedNumber(item.planByDay)}}</td>
                        <td>{{getFormattedNumber(item.planOpecByDay)}}</td>
                        <td>{{getFormattedNumber(item.factByDay)}}</td>
                        <td :style="getStyleByDifference(item.differenceByDay)">
                            {{getFormattedNumber(item.differenceByDay)}}
                        </td>
                        <td :style="getStyleByDifference(item.differenceOpecByDay)">
                            {{getFormattedNumber(item.differenceOpecByDay)}}
                        </td>
                        <td>{{getFormattedNumber(item.planByMonth)}}</td>
                        <td>{{getFormattedNumber(item.planOpecByMonth)}}</td>
                        <td>{{getFormattedNumber(item.factByMonth)}}</td>
                        <td :style="getStyleByDifference(item.differenceByMonth)">
                            {{getFormattedNumber(item.differenceByMonth)}}
                        </td>
                        <td :style="getStyleByDifference(item.differenceOpecByMonth)">
                            {{getFormattedNumber(item.differenceOpecByMonth)}}
                        </td>
                        <td>{{getFormattedNumber(item.planByYear)}}</td>
                        <td>{{getFormattedNumber(item.planOpecByYear)}}</td>
                        <td>{{getFormattedNumber(item.factByYear)}}</td>
                        <td :style="getStyleByDifference(item.differenceByYear)">
                            {{getFormattedNumber(item.differenceByYear)}}
                        </td>
                        <td :style="getStyleByDifference(item.differenceOpecByYear)">
                            {{getFormattedNumber(item.differenceOpecByYear)}}
                        </td>
                        <td>{{getFormattedNumber(item.deliveryYearlyPlan)}}</td>
                        <td>{{getFormattedNumber(item.deliveryMonthlyPlan)}}</td>
                        <td>{{getFormattedNumber(item.deliveryMonthlyPlanOpec)}}</td>
                        <td>{{getFormattedNumber(item.deliveryPlanByDay)}}</td>
                        <td>{{getFormattedNumber(item.deliveryPlanOpecByDay)}}</td>
                        <td>{{getFormattedNumber(item.deliveryFactByDay)}}</td>
                        <td :style="getStyleByDifference(item.deliveryDifferenceByDay)">
                            {{getFormattedNumber(item.deliveryDifferenceByDay)}}
                        </td>
                        <td :style="getStyleByDifference(item.deliveryDifferenceOpecByDay)">
                            {{getFormattedNumber(item.deliveryDifferenceOpecByDay)}}
                        </td>
                        <td>{{getFormattedNumber(item.deliveryPlanByMonth)}}</td>
                        <td>{{getFormattedNumber(item.deliveryPlanOpecByMonth)}}</td>
                        <td>{{getFormattedNumber(item.deliveryFactByMonth)}}</td>
                        <td :style="getStyleByDifference(item.deliveryDifferenceByMonth)">
                            {{getFormattedNumber(item.deliveryDifferenceByMonth)}}
                        </td>
                        <td :style="getStyleByDifference(item.deliveryDifferenceOpecByMonth)">
                            {{getFormattedNumber(item.deliveryDifferenceOpecByMonth)}}
                        </td>
                        <td>{{getFormattedNumber(item.deliveryPlanByYear)}}</td>
                        <td>{{getFormattedNumber(item.deliveryPlanOpecByYear)}}</td>
                        <td>{{getFormattedNumber(item.deliveryFactByYear)}}</td>
                        <td :style="getStyleByDifference(item.deliveryDifferenceByYear)">
                            {{getFormattedNumber(item.deliveryDifferenceByYear)}}
                        </td>
                        <td :style="getStyleByDifference(item.deliveryDifferenceOpecByYear)">
                            {{getFormattedNumber(item.deliveryDifferenceOpecByYear)}}
                        </td>
                    </tr>
                </table>
           </div>
       </div>
   </div>
</template>
<script src="./index.js"></script>

<style scoped lang="scss">
    .bounce-enter-active {
        animation: bounce-in .5s;
    }
    .bounce-leave-active {
        animation: bounce-in .5s reverse;
    }
    @keyframes bounce-in {
        0% {
            transform: scale(0);
        }
        50% {
            transform: scale(1.5);
        }
        100% {
            transform: scale(1);
        }
    }
    .img-play {
        background: url(/img/visualcenter3/play.png) no-repeat;
        height: 25px;
        width: 25px;
        position: absolute;
        left: 60px;
    }
    .img-pause {
        background: url(/img/visualcenter3/pause.png) no-repeat;
        height: 25px;
        width: 25px;
        position: absolute;
        left: 90px;
    }
    .reason-box {
        position: absolute;
        width: 400px;
        background: white;
        color: black;
        padding: 5px;
        border-radius: 10px;
        display: none;
    }
    .slide-fade-enter-active {
        transition: all .5s ease;
    }
    .slide-fade-leave-active {
        transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to {
        transform: translateX(10px);
        opacity: 0;
    }
    .title-opec {
        background: #3366FF;
        border-radius: 10px;
        line-height: 24px;
        font-weight: 700;
        padding: 2px 5px;
    }
    .header {
        justify-content: center;
        display: flex;
    }
    .summary-header_text-align {
        text-align: right !important;
    }
    .troubled-companies-padding {
        padding-left: 2%;
    }
    .empty-row {
        border-bottom: 21px solid #272953;
    }
    .row-divider {
        border-bottom: 20px solid white;
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
    .hide-block {
        display:none;
    }
   .background-light {
       background: #4C537E;
   }
   .color_green {
       color: #00b353;
   }
   .color_red {
       color: #E31E24;
   }
   .background-dark {
       background: #272953;
   }
   .background-delimeters {
       background: #3D4473;
   }
   .page-container {
       flex-wrap: wrap;
       margin: 0 !important;
   }
   .page-wrapper {
       font-family: HarmoniaSansProCyr-Regular, Harmonia-sans;
       position: relative;
       min-height: 872px;
       background: #272953;
       color: white;
       text-align: center;
   }
   .main-table {
       table-layout: fixed;
       border-collapse: collapse;
       position: static;
       tr {
           &:nth-child(2) {
               th {
                   height: 40px;
               }
           }
           &:nth-child(3), &:nth-child(4), &:nth-child(23) {
               background: #333975;
           }
       }
       tr:hover {
           background: #2d3486;
           td:not(:nth-child(2)) {
               font-size: 20px;
           }
       }
       th {
           font-style: normal;
           font-weight: bold;
           font-size: 13px;
           background: #353EA1;
           width: 10%;
           border: 1px solid #272953;
           &:first-child {
               width: 2%;
           }
           &:nth-child(3), &:nth-child(4), &:nth-child(5) {
               width: 5%;
           }
       }
       td {
           text-align: right;
           font-size: 13px;
           font-family: Bold;
           width: 10%;
           border-right: 1px solid #696e96;
           padding-right: 5px;
           &:first-child {
               width: 2%;
               text-align: center;
           }
           &:nth-child(2) {
               font-family: HarmoniaSansProCyr-Regular, Harmonia-sans;
               text-align: left;
               padding-left: 5px;
           }
           &:nth-child(3), &:nth-child(4), &:nth-child(5) {
               width: 5%;
           }
       }
   }
</style>