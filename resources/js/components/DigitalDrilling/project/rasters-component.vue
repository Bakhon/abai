<template>
    <table class="table defaultTable rastersParams">
        <tr>
            <th rowspan="2">Номер интервала с одинаковым долевым составом бурового раствора</th>
            <th colspan="2">Интервал (по стволу), м</th>
            <th rowspan="2">Название (тип) раствора</th>
            <th rowspan="2">Плотность раствора, кг/м3</th>
            <th rowspan="2">Смена раствора для бурения интервала (да, нет)</th>
            <th rowspan="2">Название компонента</th>
            <th rowspan="2">Плотность кг/м3</th>
            <th rowspan="2">Содержание вещества в товарном продукте (жидкости), %</th>
            <th rowspan="2" class="verticalText"><span>Влажность, %</span></th>
            <th rowspan="2">Сорт</th>
            <th rowspan="2">Содержание компонента в буровом растворе, кг/м3</th>
        </tr>
        <tr>
            <th colspan="1">От (верх)</th>
            <th colspan="1">До (низ)</th>
        </tr>
        <tr>
            <td v-for="i in 12">{{i}}</td>
        </tr>
        <tr v-for="i in 20">
            <td v-for="i in 12"></td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "rasters-component"
    }
</script>

<style scoped>

</style>