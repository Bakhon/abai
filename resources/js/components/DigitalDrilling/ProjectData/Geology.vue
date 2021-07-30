<template>
    <table class="table defaultTable">
        <tbody>
        <tr>
            <th colspan="4">Глубина залегания, м</th>
            <th colspan="4">Стратиграфическое подразделение</th>
            <th colspan="4">Элементы залегания (падения) пластов по подошве</th>
            <th rowspan="2" colspan="2" class="align-middle">Коэффициент кавернозности в интервале</th>
        </tr>
        <tr>
            <th colspan="2">Проект</th>
            <th colspan="2">Факт</th>
            <th colspan="2">Проект</th>
            <th colspan="2">Факт</th>
            <th colspan="2">Проект</th>
            <th colspan="2">Факт</th>
        </tr>
        <tr>
            <th>от (верх)</th>
            <th>до (низ)</th>
            <th>от (верх)</th>
            <th>до (низ)</th>
            <th>от (верх)</th>
            <th>до (низ)</th>
            <th>от (верх)</th>
            <th>до (низ)</th>
            <th>от (верх)</th>
            <th>до (низ)</th>
            <th>от (верх)</th>
            <th>до (низ)</th>
            <th>Проект</th>
            <th>Факт</th>
        </tr>
            <tr v-for="(n, i) in 10">
                <td v-for="(n, i) in 14"></td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "Geology"
    }
</script>

<style scoped>
</style>