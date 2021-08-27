<template>
    <table class="table defaultTable rastersParams">
        <tbody>
        <tr>
            <th colspan="2">Номинальный наружный диаметр, мм</th>
            <th colspan="2">Глубина установки, м</th>
            <th colspan="2">Длина секции, м</th>
            <th colspan="2">Нарастающая масса, тн.</th>
            <th colspan="2">Марка (группа прочности) материала труб</th>
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
        </tr>
        <tr v-for="i in 15">
            <td v-for="i in 10"></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "fastening-first"
    }
</script>

<style scoped>

</style>