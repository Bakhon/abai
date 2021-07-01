<template>
    <div class="page-wrapper">
        <div class="page-container row">
            <div class="col-12 header-title mt-2">
                Добыча нефти и конденсата, тонн
            </div>
            <div class="col-10 mt-2 p-0">
                <table>
                    <tr>
                        <th rowspan="2">№ п/п</th>
                        <th rowspan="2">Предприятия</th>
                        <th rowspan="2">
                            План<br>
                            на {{currentYear}} г.
                        </th>
                        <th rowspan="2">
                            План<br>
                            на {{currentMonthName}} месяц
                        </th>
                        <th rowspan="2">
                            План на {{currentMonthName}} месяц <br>
                            с учетом ОПЕК+
                        </th>
                        <th colspan="5" class="background-delimeters">СУТОЧНАЯ</th> <!-- >суточная <-->
                        <th colspan="5" class="background-delimeters">С НАЧАЛА МЕСЯЦА</th> <!-- >с начала месяца <-->
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
                        >
                            {{getFormattedNumber(item[key])}}
                        </td>
                    </tr>
                    <!-- >дзо <-->
               </table>
           </div>
           <div class="col-2 mt-2">
               <div class="visualization-header pt-1">
                   Визуализация
               </div>
               <div class="d-flex visualization-percent">
                   <span class="col-3">0%</span>
                   <span class="col-3">30%</span>
                   <span class="col-3">80%</span>
                   <span class="col-3">100%</span>
               </div>
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
               }
           ]
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
   },
   mounted() {
       for (let i=2; i<21; i++) {
           let emptyCompany = _.cloneDeep(this.template);
           emptyCompany.number = i;
           this.production.push(emptyCompany);
       }
   }
}
</script>

<style scoped lang="scss">
   .visualization-header {
       border: 2px solid #272953;
       background: #3D4473;
       min-height: 52px;
       font-style: normal;
       font-weight: bold;
       font-size: 14px;
   }
   .visualization-percent {
       border: 2px solid #272953;
       min-height: 37px;
       background: #4C537E;
       span {
           padding-top: 6px;
       }
   }
   .background-light {
       background: #3D4473;
   }
   .background-dark {
       background: #272953;
   }
   .background-delimeters {
       background: #4C537E;
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
   .header-title {
       font-style: normal;
       font-weight: bold;
       font-size: 20px;
       line-height: 24px;
   }
   table {
       min-width: 1530px;
       tr {
           &:nth-child(3), &:nth-child(4) {
               background: #575975;
               border-bottom: 2px solid #272953;
           }
       }
       th {
           font-style: normal;
           font-weight: bold;
           font-size: 14px;
           background: #3D4473;
           padding: 5px;
           border: 2px solid #272953;
       }
       td {
           border-right: 2px solid #3D4473;
           font-size: 15px;
           font-family: Bold;
           min-width: 70px;
           padding: 7px;
           &:first-child {
               min-width: 50px;
           }
           &:nth-child(2) {
               font-family: HarmoniaSansProCyr-Regular, Harmonia-sans;
               max-width: 250px;
           }
       }
   }
</style>