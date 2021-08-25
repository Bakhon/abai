<template>
    <table class="table defaultTable rastersParams">
        <tr>
            <th colspan="1">Номер колонны в порядке спуска</th>
            <th colspan="1">Название колонны</th>
            <th colspan="1">Номер колонны в порядке спуска</th>
            <th colspan="1">Номер ступени (снизу-вверх)</th>
            <th colspan="1">Тип или название жидкости для цементирования</th>
            <th colspan="1">Название компонента</th>
            <th colspan="1" class="verticalText"><span>Пластическая вязкость, сПз</span></th>
            <th colspan="1" class="verticalText"><span>Пластическая вязкость, сПз</span></th>
            <th colspan="1">Сорт</th>
            <th colspan="1">ГОСТ, ОСТ, МРТУ, ТУ, МУ и т.п. на изготовление</th>
            <th colspan="1">Норма расхода компонента кг/м3</th>
        </tr>
        <tr>
            <td v-for="i in 11">{{i+1}}</td>
        </tr>
        <tr v-for="i in 20">
            <td v-for="i in 11"></td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "fastening-page6"
    }
</script>

<style scoped>

</style>