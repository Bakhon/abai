<template>
    <div class="page-wrapper">
        <div class="page-container row">
            <div class="col-12 mt-3 d-flex">
                <div class="header-title col-7">
                    {{headerTitle}}
                </div>
                <div
                        :class="[!isWithKMG ? 'opec-filter-active' : 'opec-filter-disabled','col-2']"
                        @click="exportToExcel()"
                >
<!--                        @click="isWithKMG = !isWithKMG"-->

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
                <table class="main-table col-12" id="dailyReport" style="display:none">
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
                <table class="col-12" id="dailyReport">
                    <tr>
                        <th rowspan="3">№ п/п</th>
                        <th rowspan="3">Предприятия</th>
                        <th colspan="18" class="background-delimeters">ДОБЫЧА, тонн</th>
                        <th colspan="18" class="background-delimeters">СДАЧА, тонн</th>
                    </tr>
                    <tr>
                        <th rowspan="2">
                            План на {{currentYear}} г.
                        </th>
                        <th rowspan="2">
                            План на {{currentMonthName}} месяц
                        </th>
                        <th rowspan="2">
                            План на {{currentMonthName}} месяц <br>
                            с учетом ОПЕК+
                        </th>
                        <th colspan="5" class="background-delimeters">СУТОЧНАЯ</th> <!-- >суточная <-->
                        <th colspan="5" class="background-delimeters">С НАЧАЛА МЕСЯЦА</th> <!-- >с начала месяца <-->
                        <th colspan="5" class="background-delimeters">С НАЧАЛА ГОДА</th> <!-- >с начала года <-->
                        <th rowspan="2">
                            План на {{currentYear}} г.
                        </th>
                        <th rowspan="2">
                            План на {{currentMonthName}} месяц
                        </th>
                        <th rowspan="2">
                            План на {{currentMonthName}} месяц <br>
                            с учетом ОПЕК+
                        </th>
                        <th colspan="5" class="background-delimeters">СУТОЧНАЯ</th> <!-- >суточная <-->
                        <th colspan="5" class="background-delimeters">С НАЧАЛА МЕСЯЦА</th> <!-- >с начала месяца <-->
                        <th colspan="5" class="background-delimeters">С НАЧАЛА ГОДА</th> <!-- >с начала года <-->
                    </tr>
                    <tr>
                        <!-- >суточная <-->
                        <th>План</th>
                        <th>
                            План<br>
                            с учетом ОПЕК+
                        </th>
                        <th>Факт</th>
                        <th>(+,-)</th>
                        <th>
                            (+,-)<br>
                            с учетом ОПЕК+
                        </th>
                        <!-- >суточная <-->
                        <!-- >с начала месяца <-->
                        <th>План</th>
                        <th>
                            План<br>
                            с учетом ОПЕК+
                        </th>
                        <th>Факт</th>
                        <th>(+,-)</th>
                        <th>
                            (+,-)<br>
                            с учетом ОПЕК+
                        </th>
                        <!-- >с начала месяца <-->
                        <!-- >с начала года <-->
                        <th>План</th>
                        <th>
                            План<br>
                            с учетом ОПЕК+
                        </th>
                        <th>Факт</th>
                        <th>(+,-)</th>
                        <th>
                            (+,-)<br>
                            с учетом ОПЕК+
                        </th>
                        <!-- >с начала года <-->
                        <!-- >суточная <-->
                        <th>План</th>
                        <th>
                            План<br>
                            с учетом ОПЕК+
                        </th>
                        <th>Факт</th>
                        <th>(+,-)</th>
                        <th>
                            (+,-)<br>
                            с учетом ОПЕК+
                        </th>
                        <!-- >суточная <-->
                        <!-- >с начала месяца <-->
                        <th>План</th>
                        <th>
                            План<br>
                            с учетом ОПЕК+
                        </th>
                        <th>Факт</th>
                        <th>(+,-)</th>
                        <th>
                            (+,-)<br>
                            с учетом ОПЕК+
                        </th>
                        <!-- >с начала месяца <-->
                        <!-- >с начала года <-->
                        <th>План</th>
                        <th>
                            План<br>
                            с учетом ОПЕК+
                        </th>
                        <th>Факт</th>
                        <th>(+,-)</th>
                        <th>
                            (+,-)<br>
                            с учетом ОПЕК+
                        </th>
                        <!-- >с начала года <-->
                    </tr>
                    <!-- >дзо <-->
                </table>
           </div>
       </div>
   </div>
</template>
<script src="./index.js"></script>

<style scoped lang="scss">
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
   table .main-table {
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