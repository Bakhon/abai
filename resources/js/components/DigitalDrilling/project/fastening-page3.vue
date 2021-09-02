<template>
    <table class="table defaultTable rastersParams">
        <tr>
            <th rowspan="2">Номер колонны в порядке спуска</th>
            <th rowspan="2">Название колонны</th>
            <th rowspan="2">Номер раздельно спускаемой части колонны в порядке спуска</th>
            <th rowspan="2">Натяжение эксплуатационной колонны, тс</th>
            <th colspan="2">Плотность жидкости для опрессовки, кг/м3</th>
            <th colspan="3">Давление на устье скважины при опресссовке, МПа</th>
            <th rowspan="2">Глубина установки пакера, м</th>
            <th rowspan="2">Давление на устье скважины при оперссовке труб ниже пакера, МПа</th>
            <th rowspan="2">Номер равнопрочной секции труб в раздельно спускаемой части</th>
            <th rowspan="2">Давление опрессовки труб равнопрочной секции на поверхности, МПа</th>
        </tr>
        <tr>
            <th colspan="1">раздельно спускаемой части</th>
            <th colspan="1">Цементного кольца</th>
            <th colspan="1">Раздельно спускаемой части</th>
            <th colspan="1">Цементного кольца</th>
            <th colspan="1">Части колонны ниже муфты для 2х ступ. цементирования</th>
        </tr>
        <tr>
            <td v-for="i in 13">{{i+1}}</td>
        </tr>
        <tr v-for="i in 20">
            <td v-for="i in 13"></td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "fastening-page3"
    }
</script>

<style scoped>

</style>