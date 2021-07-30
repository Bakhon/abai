<template>
    <table class="table defaultTable">
        <tbody>
        <tr>
            <th rowspan="3" colspan="2" class="align-middle">Номер колон-ны в рядке спуска</th>
            <th rowspan="3" colspan="2">Номер раздельно спускаемой части колонны в порядке спуска</th>
            <th rowspan="3" colspan="2" class="align-middle">Номер равнопрочной секции труб в раздельно спускаемой части колонны (снизу-вверх)</th>
            <th colspan="4" class="align-middle">Интервал установки равнопрочной секции по стволу, м</th>
            <th rowspan="3" colspan="2" class="align-middle">Длина секции по стволу, м</th>
            <th rowspan="3" colspan="2" class="align-middle">Масса секции (в воздухе), т</th>
            <th rowspan="3" colspan="2" class="align-middle">Нарастающая масса (в воздухе), т</th>
            <th colspan="8" class="align-middle">Характеристика обсадной трубы</th>
            <th colspan="6" class="align-middle" >Коэфициенты запаса прочности при</th>
        </tr>
        <tr>
            <th rowspan="2" colspan="2" class="align-middle">от (верх)</th>
            <th rowspan="2" colspan="2"></th>
            <th rowspan="2" colspan="2">номинальный наружный диаметр, мм</th>
            <th rowspan="2" colspan="2">код тип соединения труб</th>
            <th rowspan="2" colspan="2">марка (группа прочности материала)</th>
            <th rowspan="2" colspan="2">толщина стенки мм</th>
            <th colspan="4">избыточном давлений</th>
            <th rowspan="2" colspan="2" class="align-middle">растяжении</th>
        </tr>
        <tr>
            <th colspan="2">наружном</th>
            <th colspan="2">внутреннем</th>
        </tr>
        <tr>
            <th>проект</th>
            <th>факт</th>
            <th>проект</th>
            <th>факт</th>
            <th>проект</th>
            <th>факт</th>
            <th>проект</th>
            <th>факт</th>
            <th>проект</th>
            <th>факт</th>
            <th>проект</th>
            <th>факт</th>
            <th>проект</th>
            <th>факт</th>
            <th>проект</th>
            <th>факт</th>
            <th>проект</th>
            <th>факт</th>
            <th>проект</th>
            <th>факт</th>
            <th>проект</th>
            <th>факт</th>
            <th>проект</th>
            <th>факт</th>
            <th>проект</th>
            <th>факт</th>
            <th>проект</th>
            <th>факт</th>
            <th>проект</th>
            <th>факт</th>
        </tr>
        <tr v-for="(n, i) in 10">
            <td v-for="(n, i) in 30"></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "WellСasing"
    }
</script>

<style scoped>

</style>