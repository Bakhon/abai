<template>
    <table class="table defaultTable rastersParams">
        <tr>
            <th rowspan="3" class="verticalText"><span>Условный номер КНБК</span></th>
            <th colspan="11">ЭЛЕМЕНТЫ КНБК (до бурильных труб)</th>
        </tr>
        <tr>
            <th rowspan="2" class="verticalText"><span>№ по порядку</span></th>
            <th rowspan="2">Типоразмер, шифр или краткое название элемента КНБК (код по IADC)</th>
            <th rowspan="2">Расстояние от забоя до места установки</th>
            <th colspan="5">Техническая характеристика</th>
            <th rowspan="2">Суммарная длина КНБК, м</th>
            <th rowspan="2">Суммарная масса КНБК, т</th>
            <th rowspan="2">Примечание</th>
        </tr>
        <tr>
            <th colspan="1">Наружный диаметр, мм</th>
            <th colspan="1">Диаметр проходного сечения, мм</th>
            <th colspan="1">Длина, м</th>
            <th colspan="1">Масса, кг</th>
            <th colspan="1">Угол перекоса осей отклонителя, град.</th>
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
        name: "deepening"
    }
</script>

<style scoped>

</style>