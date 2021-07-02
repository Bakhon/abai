<template>
    <div class="page-wrapper">
        <div class="page-container row">
            <div class="col-12 mt-2 d-flex">
                <div class="header-title col-9">
                    <transition name="fade">
                        <div v-if="buttonName === viewType.production">
                            Оперативная суточная информация по добыче нефти и конденсата АО НК "КазМунайГаз", тонн
                        </div>
                    </transition>
                    <transition name="fade">
                        <div v-if="buttonName !== viewType.production">
                            Оперативная суточная информация по сдачи нефти и конденсата АО НК "КазМунайГаз", тонн
                        </div>
                    </transition>
                </div>
                <div
                        class="opec-filter-disabled col-1 mt-2"
                        @click="switchView()"
                >
                    {{buttonName}}
                </div>
                <div
                        :class="[isOpecActive ? 'opec-filter-active' : 'opec-filter-disabled','col-1 mt-2']"
                        @click="isOpecActive = !isOpecActive"
                >
                    С учетом ОПЕК+
                </div>
            </div>
            <div class="col-12 mt-2">
                <table class="col-12">
                    <tr>
                        <th rowspan="2">№ п/п</th>
                        <th rowspan="2">Предприятия</th>
                        <th rowspan="2">
                            План на {{currentYear}} г.
                        </th>
                        <th :class="!isOpecActive ? '' : 'hide-block'"rowspan="2">
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
                            v-for="item in summary"
                            class="background-dark"
                    >
                        <td>{{item.number}}</td>
                        <td>{{item.dzo}}</td>
                        <td
                                v-for="(key, keyIndex) in Object.keys(item)"
                                v-if="keyIndex > 1"
                                :class="isColumnHidden(keyIndex) ? 'hide-block' : ''"
                        >
                            {{getFormattedNumber(item[key])}}
                        </td>
                    </tr>
                    <!-- >саммари <-->
                    <!-- >дзо <-->
                    <tr
                            v-for="(item, index) in production"
                            :class="getRowClass(index)"
                    >
                        <td>{{item.number}}</td>
                        <td>{{item.dzo}}</td>
                        <td
                            v-for="(key, keyIndex) in Object.keys(item)"
                            v-if="keyIndex > 1"
                            :class="isColumnHidden(keyIndex) ? 'hide-block' : ''"
                        >
                            {{getFormattedNumber(item[key])}}
                        </td>
                    </tr>
                    <!-- >дзо <-->
               </table>
           </div>
       </div>

   </div>
</template>

<script>
import moment from "moment";

export default {
   data: function () {
       return {
           currentYear: moment().year(),
           currentMonthName: moment().format('MMMM'),
           template: {
               'number': 1,
               'dzo': 'АО “Ознемунайгаз” (нефть) (100%)',
               'yearlyPlan': 1200300,
               'monthlyPlan': 200000,
               'monthlyPlanOpec': 210000,
               'planByDay': 20000,
               'planOpecByDay': 18000,
               'factByDay': 21000,
               'differenceByDay': 1000,
               'differenceOpecByDay': 3000,
               'planByMonth': 20000,
               'planOpecByMonth': 18000,
               'factByMonth': 21000,
               'differenceByMonth': 1000,
               'differenceOpecByMonth': 3000,
               'planByYear': 200000,
               'planOpecByYear': 180000,
               'factByYear': 210000,
               'differenceByYear': 10000,
               'differenceOpecByYear': 30000,
           },
           production: [],
           summary: [
               {
                   'number': 1,
                   'dzo': 'Всего добыча нефти и конденсата с учетом доли участия АО НК "КазМунайГаз"',
                   'yearlyPlan': 1200300,
                   'monthlyPlan': 200000,
                   'monthlyPlanOpec': 210000,
                   'planByDay': 20000,
                   'planOpecByDay': 18000,
                   'factByDay': 21000,
                   'differenceByDay': 1000,
                   'differenceOpecByDay': 3000,
                   'planByMonth': 20000,
                   'planOpecByMonth': 18000,
                   'factByMonth': 21000,
                   'differenceByMonth': 1000,
                   'differenceOpecByMonth': 3000,
                   'planByYear': 200000,
                   'planOpecByYear': 180000,
                   'factByYear': 210000,
                   'differenceByYear': 10000,
                   'differenceOpecByYear': 30000,
               },
               {
                   'number': '',
                   'dzo': 'в т.ч.: газовый конденсат',
                   'yearlyPlan': 1200300,
                   'monthlyPlan': 200000,
                   'monthlyPlanOpec': 210000,
                   'planByDay': 20000,
                   'planOpecByDay': 18000,
                   'factByDay': 21000,
                   'differenceByDay': 1000,
                   'differenceOpecByDay': 3000,
                   'planByMonth': 20000,
                   'planOpecByMonth': 18000,
                   'factByMonth': 21000,
                   'differenceByMonth': 1000,
                   'differenceOpecByMonth': 3000,
                   'planByYear': 200000,
                   'planOpecByYear': 180000,
                   'factByYear': 210000,
                   'differenceByYear': 10000,
                   'differenceOpecByYear': 30000,
               }
           ],
           opecColumns: [4,6,9,11,14,16,19],
           isOpecActive: false,
           buttonName: 'Добыча',
           viewType: {
               'production': 'Добыча',
               'delivery': 'Сдача'
           }
       }
   },
   methods: {
       getRowClass(index) {
           if (index % 2 === 0) {
               return 'background-light';
           } else {
               return 'background-dark';
           }
       },
       getFormattedNumber(num) {
           return (new Intl.NumberFormat("ru-RU").format(Math.round(num)))
       },
       isColumnHidden(index) {
           return this.opecColumns.includes(index);
       },
       switchOpecFilter() {
            this.isOpecActive = !this.isOpecActive;
       },
       switchView() {
            if (this.buttonName === this.viewType.production) {
                this.buttonName = this.viewType.delivery;
            } else {
                this.buttonName = this.viewType.production;
            }
       },
   },
   mounted() {
       for (let i=2; i<19; i++) {
           let emptyCompany = _.cloneDeep(this.template);
           emptyCompany.number = i;
           if (i === 9) {
               emptyCompany.differenceByDay = -1000;
           }
           if (i === 12) {
               emptyCompany.differenceByDay = 3000;
           }
           this.production.push(emptyCompany);
       }
   }
}
</script>

<style scoped lang="scss">
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
   .fade-enter-active, .fade-leave-active {
       transition: opacity .5s;
   }
   .fade-enter, .fade-leave-to {
       opacity: 0;
   }
   table {
       table-layout: fixed;
       border-collapse: collapse;
       tr {
           &:nth-child(2) {
               th  {
                   height: 50px;
               }
           }
           &:nth-child(3), &:nth-child(4) {
               background: #3D4473;
               border-bottom: 2px solid #272953;
               td {
                   border-right: 2px solid #272953;
               }
           }
       }
       th {
           font-style: normal;
           font-weight: bold;
           font-size: 13px;
           background: #353EA1;
           padding: 5px;
           border: 2px solid #272953;
           width: 10%;
           &:first-child {
               width: 2%;
           }
           &:nth-child(3),&:nth-child(4),&:nth-child(5) {
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
           }
           &:nth-child(3),&:nth-child(4),&:nth-child(5) {
               width: 5%;
           }
       }
   }
</style>