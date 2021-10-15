<template>
    <table class="table defaultTable rastersParams">
        <tr>
            <th rowspan="2">Название колонны</th>
            <th colspan="2">Глубина установки муфты для ступенчатого цементирования, м</th>
            <th rowspan="2">Название порции тампонажного раствора</th>
            <th colspan="2">Объем порции, м3</th>
            <th colspan="2">ПВ, сПз</th>
            <th colspan="2">Водоотдача, см3/30мин</th>
            <th colspan="2">ДНС</th>
            <th colspan="2">Время начала схватывания, мин.</th>
            <th colspan="2">Время ОЗЦ</th>
        </tr>
        <tr>
            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>
        </tr>
        <tr>
            <td rowspan="5"></td>
            <td rowspan="5"></td>
            <td rowspan="5"></td>
        </tr>
        <tr>
            <td class="blueTd">Буферный</td>
            <td v-for="i in 10"></td>
        </tr>
        <tr>
            <td class="blueTd">Тампонажный 1</td>
            <td v-for="i in 12"></td>
        </tr>
        <tr>
            <td class="blueTd">Тампонажный 2</td>
            <td v-for="i in 12" ></td>
        </tr>
        <tr>
            <td class="blueTd">Продавочный</td>
            <td v-for="i in 12"></td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "fastening-second"
    }
</script>

<style scoped>

</style>