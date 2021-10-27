<template>
    <table class="table defaultTable rastersParams">
        <tr>
            <th colspan="4">Интервал, м.</th>
            <th colspan="2">Способ бурения</th>
            <th colspan="2">Условный номер КНБК</th>
            <th colspan="2">Осевая нагрузка, ТС.</th>
            <th colspan="2">Скорость вращения ротора, об/мин</th>
            <th colspan="2">Расход бурового раствора, л/с</th>
            <th colspan="2">Скорость выполнения технологической операции, м/ч</th>
            <th colspan="2">Давление на стояке, бар.</th>
        </tr>
        <tr>
            <th colspan="2">Проект</th>
            <th colspan="2">Факт</th>
            <th rowspan="2">Проект</th>
            <th rowspan="2">Факт</th>
            <th rowspan="2">Проект</th>
            <th rowspan="2">Факт</th>
            <th rowspan="2">Проект</th>
            <th rowspan="2">Факт</th>
            <th rowspan="2">Проект</th>
            <th rowspan="2">Факт</th>
            <th rowspan="2">Проект</th>
            <th rowspan="2">Факт</th>
            <th rowspan="2">Проект</th>
            <th rowspan="2">Факт</th>
            <th rowspan="2">Проект</th>
            <th rowspan="2">Факт</th>
        </tr>
        <tr>
            <th>От (верх)</th>
            <th>До (низ)</th>
            <th>От (верх)</th>
            <th>До (низ)</th>
        </tr>
        <tr v-for="i in 10">
            <td v-for="i in 18"></td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "deepening-params"
    }
</script>

<style scoped>

</style>