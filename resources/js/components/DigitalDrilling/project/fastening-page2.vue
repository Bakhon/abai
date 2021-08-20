<template>
    <table class="table defaultTable rastersParams">
        <tr>
            <th rowspan="3">Номер колонны в порядке спуска</th>
            <th rowspan="3">Название колонны</th>
            <th rowspan="3">Номер части колонны в порядке спуска</th>
            <th rowspan="3">Тип, шифр инструмента для спуска (элеватор, спайдер-элеватор)</th>
            <th colspan="2">Средства смазки и уплотнения резьбовых соединений</th>
            <th rowspan="3">Расход смазки, кг</th>
            <th colspan="2" rowspan="2">Интервал глубины с одинаковой допустимой скоростью спуска труб, м</th>
            <th rowspan="3">Допустимая скорость спуска труб, м/c</th>
            <th rowspan="3">Допустимая глубина спуска труб, м/с спуска труб, м/c</th>
            <th rowspan="3">Периодич-ность долива колонны, м</th>
            <th colspan="3">Промежуточные промывки</th>
        </tr>
        <tr>
            <th colspan="1" rowspan="2">шифр или название</th>
            <th colspan="1" rowspan="2">ГОСТ, ОСТ, МРТУ, ТУ, МУ и т.п. на изготовление</th>
            <th colspan="1" rowspan="2">глубина, м</th>
            <th colspan="1" rowspan="2">продолжительность, мин.</th>
            <th colspan="1" rowspan="2">расход, л/c</th>
        </tr>
        <tr>
            <th colspan="1" rowspan="1">от (верх)</th>
            <th colspan="1" rowspan="1">до (низ)</th>
        </tr>
        <tr>
            <td v-for="i in 15">{{i+1}}</td>
        </tr>
        <tr v-for="i in 20">
            <td v-for="i in 15"></td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "fastening-page2"
    }
</script>

<style scoped>

</style>