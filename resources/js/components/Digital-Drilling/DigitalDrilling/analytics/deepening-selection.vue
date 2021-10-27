<template>
    <table class="table defaultTable rastersParams">
        <tbody>
        <tr>
            <th colspan="4">Индекс стратиграфического разреза</th>
            <th colspan="2">Отбор керна, м.</th>
            <th colspan="4">Интервал залегания</th>
        </tr>
        <tr>
            <th colspan="2">Проект</th>
            <th colspan="2">Факт</th>
            <th rowspan="2">Проект</th>
            <th rowspan="2">Факт</th>
            <th colspan="2">Проект</th>
            <th colspan="2">Факт</th>
        </tr>
        <tr>
            <th>От (верх)</th>
            <th>До (низ)</th>
            <th>От (верх)</th>
            <th>До (низ)</th>
            <th>От (верх)</th>
            <th>До (низ)</th>
            <th>От (верх)</th>
            <th>До (низ)</th>
        </tr>
        <tr v-for="i in 15">
            <td v-for="i in 10"></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "deepening-selection"
    }
</script>

<style scoped>

</style>