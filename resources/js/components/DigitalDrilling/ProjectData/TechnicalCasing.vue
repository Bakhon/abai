<template>
    <table class="table defaultTable">
        <tbody>
        <tr>
            <th colspan="11">Элементы технологической оснастки колонны</th>
            <th colspan="4">Суммарные на колонну</th>
        </tr>
        <tr>
            <th rowspan="2" class="align-middle">Название колонны</th>
            <th rowspan="2" colspan="2" class="align-middle">наименование, шифр, типоразмер</th>
            <th rowspan="2" colspan="2" class="align-middle">масса элемента, кг</th>
            <th colspan="4">интервал установки, м (по стволу)</th>
            <th rowspan="2" colspan="2" class="align-middle">количество элементов на интервале</th>
            <th rowspan="2" colspan="2" class="align-middle">количество, шт.</th>
            <th rowspan="2" colspan="2" class="align-middle">масса, кг</th>
        </tr>
        <tr>
            <th colspan="2">Проект</th>
            <th colspan="2">Факт</th>
        </tr>
        <tr>
            <th></th>
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
        <tr v-for="(n, i) in 10">
            <td v-for="(n, i) in 15"></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "TechnicalCasing"
    }
</script>

<style scoped>

</style>