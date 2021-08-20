<template>
    <table class="table defaultTable rastersParams">
        <tr>
            <th rowspan="3" class="verticalText"><span>Номер колонны в порядке спуска</span></th>
            <th rowspan="3" class="verticalText"><span>Номер  части колонны в порядке спуска</span></th>
            <th rowspan="3" class="verticalText"><span>Номер ступени цементирования (снизу-вверх)</span></th>
            <th rowspan="3">Наименование технологической операции</th>
            <th rowspan="3">Тип или название жидкости</th>
            <th rowspan="3">Тип (шифр) агрегата или бурового насоса</th>
            <th rowspan="3">Назначение агрегата или бурового насоса</th>
            <th rowspan="3" class="verticalText"><span>Количество агрегатов (буровых насосов),работающих на одном режиме</span></th>
            <th colspan="6">Режим работы агрегатов (буровых) насосов</th>
            <th colspan="2" rowspan="2">Время выполнения технологической операции, мин</th>
        </tr>
        <tr>
            <th class="verticalText" rowspan="2"><span>диаметр цилиндровых втулок, мм</span></th>
            <th class="verticalText" rowspan="2"><span>скорость агрегата или число двойных ходов бурового насоса</span></th>
            <th class="verticalText" rowspan="2"><span>суммарная производительность агрегатов (бурового насосов), л/с</span></th>
            <th colspan="2">давление, кгс/см2</th>
            <th class="verticalText" rowspan="2">объем порции на данном режиме<span></span></th>
        </tr>
        <tr>
            <th class="verticalText"><span>допустимое для агрегатов (буровых  насосов)</span></th>
            <th class="verticalText"><span>на устье скважины в конце операции</span></th>
            <th class="verticalText"><span>в данном режиме</span></th>
            <th class="verticalText"><span>нарастающее от начала затворения до момента «стоп»</span></th>
        </tr>
        <tr>
            <td v-for="i in 16">{{i+1}}</td>
        </tr>
        <tr v-for="i in 20">
            <td v-for="i in 16"></td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "fastening-page7"
    }
</script>

<style scoped>

</style>