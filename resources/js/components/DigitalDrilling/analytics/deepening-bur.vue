<template>
    <table class="table defaultTable rastersParams">
        <tbody>
        <tr>
            <th rowspan="3">Наименование секции ОК (диаметр, мм.)</th>
            <th colspan="4">Интервал бурения, м.</th>
            <th colspan="2">Название (тип) раствора</th>
            <th colspan="4">Параметры бурового растрова</th>
        </tr>
        <tr>
            <th colspan="2">Проект</th>
            <th colspan="2">Факт</th>
            <th rowspan="2">Проект</th>
            <th rowspan="2">Факт</th>
            <th rowspan="2"></th>
            <th rowspan="2"></th>
            <th rowspan="2"></th>
            <th rowspan="2"></th>
        </tr>
        <tr>
            <th>От (верх)</th>
            <th>До (низ)</th>
            <th>От (верх)</th>
            <th>До (низ)</th>
        </tr>
        <tr>
            <td class="blueTd">Направления</td>
            <td v-for="i in 10"></td>
        </tr>
        <tr>
            <td class="blueTd">Кондуктор</td>
            <td v-for="i in 10"></td>
        </tr>
        <tr>
            <td class="blueTd">Промежуточная колонна</td>
            <td v-for="i in 10"></td>
        </tr>
        <tr>
            <td class="blueTd">Эксплуатационная колонна</td>
            <td v-for="i in 10"></td>
        </tr>
        <tr>
            <td class="blueTd">Потойная колонна/хвостовик</td>
            <td v-for="i in 10"></td>
        </tr>
        </tbody>
    </table>
</template>
<script>
    export default {
        name: "deepening-bur"
    }
</script>