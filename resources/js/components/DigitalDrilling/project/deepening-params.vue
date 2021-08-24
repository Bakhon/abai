<template>
    <table class="table defaultTable rastersParams">
        <tr>
            <th colspan="2">Интервал, м</th>
            <th rowspan="2">Вид технологической операции (бурение, отбор керна, расширка, проработка)</th>
            <th rowspan="2">Способ бурения</th>
            <th rowspan="2">Условный номер КНБК</th>
            <th colspan="3">Режим бурения</th>
            <th rowspan="2">Скорость выполнения технологической операции, м/час</th>
        </tr>
        <tr>
            <th colspan="1">от (верх)</th>
            <th colspan="1">до (низ)</th>
            <th colspan="1">осевая нагрузка, тс</th>
            <th colspan="1">скорость вращения, об/мин</th>
            <th colspan="1">расход бурового раствора, л/с</th>
        </tr>
        <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>6</td>
            <td>7</td>
            <td>8</td>
            <td>9</td>
        </tr>
        <tr v-for="i in 20">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "deepening-params"
    }
</script>

<style scoped>

</style>