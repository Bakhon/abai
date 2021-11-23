<template>
    <div class="CapitalInvestments">
       <div class="row">
           <div class="col-sm-6 pr-0">
               <table class="table defaultTable">
                   <tbody>
                   <tr>
                       <th colspan="6">
                           Fact
                       </th>
                   </tr>
                   <tr>
                       <th rowspan="4" >БКП / Account</th>
                       <th rowspan="4" >Проект / Project</th>
                       <th rowspan="2" colspan="2">Отчет / Reporting</th>
                       <th rowspan="2">
                           <select name="" id="">
                               <option value="" v-for="year in years">
                                   {{year.year}}
                               </option>
                           </select>
                       </th>
                       <th></th>
                   </tr>
                   <tr>
                       <th>
                           <select name="" id="">
                               <option value="" v-for="year in years">
                                   {{year.year}}
                               </option>
                           </select>
                       </th>
                   </tr>
                   <tr>
                       <th>
                           <select name="" id="">
                               <option value="" v-for="year in years">
                                   {{year.year}}
                               </option>
                           </select>
                       </th>
                       <th>
                           <select name="" id="">
                               <option value="" v-for="year in years">
                                   {{year.year}}
                               </option>
                           </select>
                       </th>
                       <th rowspan="2">Оценка / Expected</th>
                       <th rowspan="2">Утв. План / Appr. Рlan</th>
                   </tr>
                   <tr>
                       <th>Факт / Actual</th>
                       <th>Факт / Actual</th>
                   </tr>
                   <tr v-for="i in 15">
                       <td v-for="i in 6"></td>
                   </tr>
                   </tbody>
               </table>
           </div>
           <div class="col-sm-6 pl-0">
               <table class="table defaultTable">
                   <tbody>
                   <tr>
                       <th colspan="6">
                           Project
                       </th>
                   </tr>
                   <tr>
                       <th rowspan="4" >БКП / Account</th>
                       <th rowspan="4" >Проект / Project</th>
                       <th rowspan="2" colspan="2">Отчет / Reporting</th>
                       <th rowspan="2">
                           <select name="" id="">
                               <option value="" v-for="year in years">
                                   {{year.year}}
                               </option>
                           </select>
                       </th>
                       <th></th>
                   </tr>
                   <tr>
                       <th>
                           <select name="" id="">
                               <option value="" v-for="year in years">
                                   {{year.year}}
                               </option>
                           </select>
                       </th>
                   </tr>
                   <tr>
                       <th>
                           <select name="" id="">
                               <option value="" v-for="year in years">
                                   {{year.year}}
                               </option>
                           </select>
                       </th>
                       <th>
                           <select name="" id="">
                               <option value="" v-for="year in years">
                                   {{year.year}}
                               </option>
                           </select>
                       </th>
                       <th rowspan="2">Оценка / Expected</th>
                       <th rowspan="2">Утв. План / Appr. Рlan</th>
                   </tr>
                   <tr>
                       <th>Факт / Actual</th>
                       <th>Факт / Actual</th>
                   </tr>
                   <tr v-for="i in 15">
                       <td v-for="i in 6"></td>
                   </tr>
                   </tbody>
               </table>
           </div>
       </div>
    </div>
</template>

<script>
    export default {
        name: "CapitalInvestments",
        data(){
            return{
                years: [
                    { year: '2015 г.'},
                    { year: '2016 г.'},
                    { year: '2017 г.'},
                    { year: '2018 г.'},
                    { year: '2019 г.'},
                    { year: '2020 г.'},
                ],
            }
        },
    }
</script>

<style scoped>
    .CapitalInvestments{
        width: 100%;
        height: 100%;
        background: #272953;
    }
    th{
        vertical-align: middle;
        padding: 10px 3px!important;
        font-size: 12px;

    }
    .CapitalInvestments .account{
        width: 120px;
    }
    .CapitalInvestments .project{
        width: 700px;
    }
    select{
        width: 100%;
        color: #FFFFFF;
        background: #334296;
        border: 0.5px solid #454FA1;
        border-radius: 4px;
        padding: 5px;
    }
    select:focus{
        outline: none;
    }

</style>