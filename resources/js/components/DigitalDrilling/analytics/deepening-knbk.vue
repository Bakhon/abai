<template>
    <table class="table defaultTable rastersParams">
        <tbody>
        <tr>
            <th colspan="2">Индекс горной породы</th>
            <th colspan="2">Плотность горной породы, кг/м3</th>
            <th colspan="2">Угол падения пласта, град.</th>
            <th colspan="2">Коэффицент кавернозности</th>
            <th colspan="2">КНБК (каталог)</th>
            <th colspan="2">Механическая скорость бурения, м/ч (факт.)</th>
        </tr>
        <tr class="blue">
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
        <tr v-for="i in 10">
            <td v-for="i in 12"></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "deepening-knbk"
    }
</script>

<style scoped>

</style>