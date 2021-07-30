<template>
    <table class="table defaultTable">
        <tbody>
        <tr>
            <th colspan="4" class="align-middle">Интервал по вертикали, м</th>
            <th colspan="2">Азимут, (градус)</th>
            <th colspan="4" class="align-middle">Зенитный угол, град.</th>
            <th colspan="4" class="align-middle">Горизонтальное отклонение, м</th>
            <th colspan="4" class="align-middle">Горизонтальное отклонение, м</th>
        </tr>
        <tr>
            <th colspan="2">Проект</th>
            <th colspan="2">Факт</th>
            <th>Проект</th>
            <th>Факт</th>
            <th colspan="2">Проект</th>
            <th colspan="2">Факт</th>
            <th colspan="2">Проект</th>
            <th colspan="2">Факт</th>
            <th colspan="2">Проект</th>
            <th colspan="2">Факт</th>
        </tr>
        <tr>
            <th>от (верх)</th>
            <th>до (низ)</th>
            <th>от (верх)</th>
            <th>до (низ)</th>

            <th></th>
            <th></th>

            <th>в начале интервала</th>
            <th>в конце интервала</th>
            <th>в начале интервала</th>
            <th>в конце интервала</th>

            <th>общее</th>
            <th>за интервал</th>
            <th>общее</th>
            <th>за интервал</th>
            <th>интервала</th>
            <th>общая</th>
            <th>интервала</th>
            <th>общая</th>
        </tr>
        <tr v-for="(n, i) in 10">
            <td v-for="(n, i) in 18"></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "BarrelProfile"
    }
</script>

<style scoped>

</style>