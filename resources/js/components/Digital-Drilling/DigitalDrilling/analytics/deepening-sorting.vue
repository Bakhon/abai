<template>
    <table class="table defaultTable rastersParams">
        <tr>
            <th rowspan="2" colspan="2">Интервал, м.</th>
            <th rowspan="3">Вид Технологической операции</th>
            <th rowspan="2" colspan="2">Наименьшая скорость восходящего потока в открытом стволе, м/</th>
            <th colspan="2">Потери давлений (кгс/см2) в интервалах:</th>
            <th rowspan="2" colspan="2">Схема промывки долота (центральная, периферийная, комбинированная)</th>
            <th colspan="4">Гидро-мониторные насадки</th>
            <th rowspan="2" colspan="2">Скорость истечения, м/с</th>
            <th rowspan="2" colspan="2">Мощность срабатываемая на долоте, квт.</th>
        </tr>
        <tr>
            <th colspan="2">Удельный расход, л/c.см2</th>
            <th colspan="2">Количество, шт</th>
            <th colspan="2">Диаметр, мм</th>
        </tr>
        <tr>
            <th>От (верх)</th>
            <th>До (низ)</th>
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
        <tr v-for="i in 5">
            <td v-for="i in 17"></td>
        </tr>
        <tr>
            <th colspan="17">Резервный вариант</th>
        </tr>
        <tr v-for="i in 10">
            <td v-for="i in 17"></td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "deepening-sorting"
    }
</script>

<style scoped>

</style>