<template>
    <table class="table defaultTable rastersParams">
        <tr>
            <th rowspan="3">Номер колонны в порядке спуска</th>
            <th rowspan="3">Номер раздельно спускаемой части колонны в порядке спуска</th>
            <th rowspan="3">Номер равнопроч-ной секции труб в раздельно спускаемой части колонны (снизу-вверх)</th>
            <th rowspan="2" colspan="2">Интервал установки расвнопрочной секции по стволу, м</th>
            <th rowspan="3">Длина секции по стволу, м</th>
            <th rowspan="3">Масса секции (в воздухе), т</th>
            <th rowspan="3">Масса секции (в воздухе), т</th>
            <th colspan="4" rowspan="1">Характеристика обсадной трубы</th>
            <th colspan="3" rowspan="1">Коэффициенты запаса прочности при</th>
        </tr>
        <tr>
            <th colspan="1" rowspan="2">Номинальный наружный диаметр, мм</th>
            <th colspan="1" rowspan="2">Код типа соединения труб</th>
            <th colspan="1" rowspan="2">Марка (группа прочности материала)</th>
            <th colspan="1" rowspan="2">толщина стенки мм</th>
            <th colspan="2" rowspan="1">избыточном давлении</th>
            <th colspan="1" rowspan="2">Растяжении</th>
        </tr>
        <tr>
            <th colspan="1" rowspan="1">от(верх)</th>
            <th colspan="1" rowspan="1">до(низ)</th>
            <th colspan="1">наружном</th>
            <th colspan="1">внутреннем</th>
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
        name: "fastening"
    }
</script>

<style scoped>

</style>