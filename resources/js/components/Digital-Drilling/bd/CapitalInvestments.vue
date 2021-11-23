<template>
    <div class="CapitalInvestments">
        <table class="table defaultTable">
            <tbody>
            <tr>
                <th rowspan="2" >БКП / Account</th>
                <th rowspan="2" >Проект / Project</th>
                <th>Факт / Actual</th>
                <th>Факт / Actual</th>
                <th>Оценка / Expected</th>
                <th>Утв. План / Appr. Рlan</th>
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
            </tr>
            <tr v-for="i in 15">
                <td v-for="i in 6"></td>
            </tr>
            </tbody>
        </table>
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
                    { year: '2021 г.'},
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