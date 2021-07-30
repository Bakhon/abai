<template>
    <table class="table defaultTable">
        <tbody>
        <tr>
            <th rowspan="2" colspan="2" class="align-middle">Название (тип) раствора</th>
            <th rowspan="2" colspan="4" class="align-middle">Интервал по стволу, м</th>
            <th colspan="2"></th>
            <th colspan="24">Параметры бурового раствора</th>
        </tr>
        <tr>
            <th rowspan="2" colspan="2" class="align-middle">плотность, кг/м3</th>
            <th rowspan="2" colspan="2" class="align-middle">условная вязкость, сек</th>
            <th rowspan="2" colspan="2" class="align-middle">водоотдача см 3/30 мин</th>
            <th colspan="4">СНС, фунт/ 100фут2</th>
            <th rowspan="2" colspan="2" class="align-middle">Корка, мм</th>
            <th colspan="6">СНС, фунт/ 100фут2</th>
            <th rowspan="2" colspan="2" class="align-middle">pH</th>
            <th rowspan="2" colspan="2" class="align-middle">пластическая вязкость, сантипуазах</th>
            <th rowspan="2" colspan="2" class="align-middle">динамическое наприяжение сдвига, фунт/ 100фут2</th>
            <th rowspan="2" colspan="2" class="align-middle">плотность до утяжеления, кг/м3</th>

        </tr>
        <tr>
            <th rowspan="2" class="align-middle">Проект</th>
            <th rowspan="2" class="align-middle">Факт</th>
            <th colspan="2">Проект</th>
            <th colspan="2">Факт</th>
            <th colspan="2">Проект</th>
            <th colspan="2">Факт
            <th colspan="2">Проект</th>
            <th colspan="2">Факт</th>
            <th colspan="2">Всего</th>
        </tr>
        <tr>
            <th>от (верх)</th>
            <th>до (низ)</th>
            <th>от (верх)</th>
            <th>до (низ)</th>

            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>

            <th>1 мин</th>
            <th>10 мин</th>
            <th>1 мин</th>
            <th>10 мин</th>

            <th>Проект</th>
            <th>Факт</th>

            <th>1 мин</th>
            <th>10 мин</th>
            <th>1 мин</th>
            <th>10 мин</th>
            <th>1 мин</th>
            <th>10 мин</th>

            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>
        </tr>
        <tr v-for="(n, i) in 10">
            <td v-for="(n, i) in 32"></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "DrillingFluids"
    }
</script>

<style scoped>

</style>