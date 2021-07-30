<template>
    <table class="table defaultTable">
        <tbody>
        <tr>
            <th rowspan="2" colspan="2" class="align-middle">Номер колонны в порядке спуска</th>
            <th rowspan="2" colspan="2" class="align-middle">Название колонны или открытый ствол</th>
            <th colspan="4" class="align-middle">Интервал по стволу скважины, м</th>
            <th colspan="2">Номинальный диаметр ствола сважины, мм</th>
            <th colspan="2">Расстояние от устья скважины до уровня подъема тампонажного раствора за колонной, м</th>
            <th colspan="2">Количество  раздельно спускаемых частей колонны, шт.</th>
            <th rowspan="2" colspan="2" class="align-middle">Коэффициент кавернозности в интервале</th>
        </tr>
        <tr>
            <th colspan="2">Проект</th>
            <th colspan="2">Факт</th>
            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>
        </tr>
        <tr>
            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>
            <th>от (верх)</th>
            <th>до (низ)</th>
            <th>от (верх)</th>
            <th>до (низ)</th>

            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>

            <th>Проект</th>
            <th>Факт</th>
        </tr>
        <tr v-for="(n, i) in 10">
            <td v-for="(n, i) in 16"></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "WellDesign"
    }
</script>

<style scoped>

</style>