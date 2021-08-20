<template>
    <table class="table defaultTable rastersParams">
        <tr>
            <th rowspan="2">Номер колонны в порядке спуска</th>
            <th rowspan="2">Название колонны</th>
            <th rowspan="2">Номер части колонны в порядке спуска</th>
            <th rowspan="2">Номер ступени (снизу-вверх)</th>
            <th colspan="8">Характеристика жидкости (раствора)</th>
        </tr>
        <tr>
            <th colspan="1">Тип или название</th>
            <th colspan="1">Объем порции, м3</th>
            <th colspan="1">Плотность, кг/м3</th>
            <th class="verticalText"><span>Пластическая вязкость, сПз</span></th>
            <th class="verticalText"><span>Динамическое напряжение сдвига, мгс/см2</span></th>
            <th class="verticalText"><span>Время начала схватывания, мин.</span></th>
            <th class="verticalText"><span>Время ОЗЦ, час</span></th>
            <th class="verticalText"><span>Производительность при затворении, л/сек.</span></th>
        </tr>
        <tr>
            <td v-for="i in 12">{{i+1}}</td>
        </tr>
        <tr v-for="i in 20">
            <td v-for="i in 12"></td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "fastening-page5"
    }
</script>

<style scoped>

</style>