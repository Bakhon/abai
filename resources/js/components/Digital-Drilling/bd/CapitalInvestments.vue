<template>
    <div class="CapitalInvestments">
        <table class="table defaultTable">
            <tbody>
                <tr>
                    <th rowspan="4" class="account">БКП / Account</th>
                    <th rowspan="4" class="project">Проект / Project</th>
                    <th rowspan="2" colspan="2">Отчет / Reporting</th>
                    <th rowspan="2">План 2020 / Plan of 2020 year</th>
                    <th></th>
                </tr>
                <tr>
                    <th>2019 г. / year</th>
                </tr>
                <tr>
                    <th>2018 г. / year</th>
                    <th>2019 г. / year</th>
                    <th rowspan="2">Оценка / Expected</th>
                    <th rowspan="2">Утв. План / Appr. Рlan</th>
                </tr>
                <tr>
                    <th>Факт / Actual</th>
                    <th>Оценка / Expected</th>
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
        name: "CapitalInvestments"
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
        padding: 10px 0!important;
    }
    .CapitalInvestments .account{
        width: 120px;
    }
    .CapitalInvestments .project{
        width: 700px;
    }

</style>