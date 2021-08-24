<template>
    <table class="table defaultTable ">
        <tr>
            <th rowspan="2">Наружный диаметр обсадной трубы</th>
            <th colspan="2">Толщина стенки</th>
            <th colspan="2">Диапазон варьирования внутреннего диаметра</th>
            <th colspan="2">Наружный диаметр соединительной муфты</th>
            <th rowspan="2">Толщина стенок обсадной трубы</th>
        </tr>
        <tr>
            <th>минимальная</th>
            <th>максимальная</th>
            <th>минимальная</th>
            <th>максимальная</th>
            <th>минимальная</th>
            <th>максимальная</th>
        </tr>
        <tr v-for="i in 20">
            <td>114,3</td>
            <td>5,2</td>
            <td>10,2</td>
            <td>103,9</td>
            <td>93,9</td>
            <td>127,0 (133,0)</td>
            <td>123,8</td>
            <td>5,2; 5,7; 6,4; 7,4; 8,6; 10,2</td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "calculation"
    }
</script>

<style scoped>

</style>