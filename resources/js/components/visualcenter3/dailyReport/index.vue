<template>
    <div class="page-wrapper">
        <div class="page-container row">
            <div class="col-12 mt-3 d-flex">
                <div class="header-title col-7">
                    {{headerTitle}}
                </div>
                <div class="img-download" @click="exportToExcel()"></div>
                <div
                        :class="[!isWithKMG ? 'opec-filter-active' : 'opec-filter-disabled','col-2']"
                        @click="isWithKMG = !isWithKMG"
                >
                    Без доли участия КМГ
                </div>
                <div
                        :class="[isProduction ? 'opec-filter-active' : 'opec-filter-disabled','col-1']"
                        @click="[isProduction = !isProduction,isWithKMG = false]"
                >
                    {{buttonName}}
                </div>
                <div
                        :class="[isOpecActive ? 'opec-filter-active' : 'opec-filter-disabled','col-1']"
                        @click="isOpecActive = !isOpecActive"
                >
                    С учетом ОПЕК+
                </div>
            </div>
            <div class="col-12 mt-3">
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
                        <!-- >суточная <-->
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
                        <!-- >суточная <-->
                        <!-- >с начала месяца <-->
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
                        <!-- >с начала месяца <-->
                        <!-- >с начала года <-->
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
                        <!-- >с начала года <-->
                    </tr>
                    <!-- >саммари <-->
                    <tr
                            v-for="(item,index) in tableOutput.byKMG"
                            :class="!isWithKMG && index > 0 ? 'background-dark hide-block' :'background-dark'"
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
                    <!-- >саммари <-->
                    <!-- >дзо <-->
                    <tr
                            v-for="(item, index) in tableOutput.byDzo"
                            :class="getRowClass(index)"
                    >
                        <td v-if="index !== 1">{{item.number}}</td>
                        <td v-else></td>
                        <td
                                v-if="!isWithKMG"
                                :class="index === 1 ? 'text-center' : ''"
                        >
                            {{companiesNameMapping.summaryByDzo[item.dzo]}}
                        </td>
                        <td
                                v-else
                                :class="[index === 1 ? 'text-center' : '',[6,7,8].includes(index) ? 'padding_left' : '']"
                        >
                            {{companiesNameMapping.withParticipation[item.dzo]}}
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
                    <!-- >дзо <-->
               </table>

<!--                todo-->
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
                        <th style="border: 1px solid black" rowspan="3">Предприятия</th>
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
                        <!-- >суточная <-->
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
                        <!-- >суточная <-->
                        <!-- >с начала месяца <-->
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
                        <!-- >с начала месяца <-->
                        <!-- >с начала года <-->
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
                        <!-- >с начала года <-->
                        <!-- >суточная <-->
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
                        <!-- >суточная <-->
                        <!-- >с начала месяца <-->
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
                        <!-- >с начала месяца <-->
                        <!-- >с начала года <-->
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
                        <!-- >с начала года <-->
                    </tr>
                    <!-- >дзо <-->
                    <tr
                            v-for="(item, index) in summaryForExport.byKMG"
                            :style="getStyleForSummary(index,true)"
                    >
                        <td v-if="index !== 1">{{item.number}}</td>
                        <td v-else></td>
                        <td :class="index === 1 ? 'text-center' : ''">
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

                        <!--                        delivery-->
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
                    <!--  byDZO                  -->
                    <tr
                            v-for="(item, index) in summaryForExport.byDzo"
                            :style="getStyleForSummary(index, false)"
                    >
                        <td v-if="index !== 1">{{item.number}}</td>
                        <td v-else></td>
                        <td :class="index === 1 ? 'text-center' : ''">
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

                        <!--                        delivery-->
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
    .row-divider {
        border-bottom: 20px solid white;
    }
    .img-download {
        background: url(/img/visualcenter3/download.png) no-repeat;
        height: 25px;
        width: 25px;
    }
    .padding_left {
        padding-left: 50px;
    }
    .header-title {
        font-style: normal;
        font-weight: bold;
        font-size: 20px;
        line-height: 24px;
    }
    .opec-filter-active {
        line-height: 24px;
        margin-left: auto;
        border-radius: 10px;
        background: #3366FF;
    }
    .opec-filter-disabled {
        line-height: 24px;
        margin-left: auto;
        border-radius: 10px;
        background: #4C537E;
    }
    div.opec-filter-disabled:hover {
        -webkit-box-shadow: 2px 1px 33px 4px rgba(28,37,247,0.78);
        box-shadow: 2px 1px 33px 4px rgba(28,37,247,0.78);
    }
    div.opec-filter-active:hover {
        -webkit-box-shadow: 2px 1px 33px 4px rgba(28,37,247,0.78);
        box-shadow: 2px 1px 33px 4px rgba(28,37,247,0.78);
    }
    .hide-block {
        display:none;
    }
   .background-light {
       background: #4C537E;
   }
   .color_green {
       color: #009846;
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
   .text-center {
       text-align: center;
   }
   .main-table {
       table-layout: fixed;
       border-collapse: collapse;
       tr {
           &:nth-child(2) {
               th {
                   height: 50px;
               }
           }
           &:nth-child(3), &:nth-child(4) {
               background: #333975;
           }
       }
       th {
           font-style: normal;
           font-weight: bold;
           font-size: 13px;
           background: #353EA1;
           padding: 5px;
           width: 10%;
           &:first-child {
               width: 2%;
           }
           &:nth-child(3), &:nth-child(4), &:nth-child(5) {
               width: 5%;
           }
       }
       td {
           font-size: 14px;
           font-family: Bold;
           padding: 7px;
           width: 10%;
           &:first-child {
               width: 2%;
           }
           &:nth-child(2) {
               font-family: HarmoniaSansProCyr-Regular, Harmonia-sans;
               text-align: left;
           }
           &:nth-child(3), &:nth-child(4), &:nth-child(5) {
               width: 5%;
           }
       }
   }
</style>