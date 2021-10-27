<template>
    <table class="table defaultTable rastersParams">
        <tr>
            <th rowspan="2" colspan="2">Интервал, м.</th>
            <th rowspan="2">Вид Технологической операции</th>
            <th rowspan="2" colspan="2">Давление на стояке в конце <br>интервала, кгс/см2</th>
            <th colspan="10">Потери давлений (кгс/см2) в интервалах:</th>
        </tr>
        <tr>
            <th colspan="2">Долото</th>
            <th colspan="2">ВЗД + Телеметрия</th>
            <th colspan="2">Бурильная колонна</th>
            <th colspan="2">Кольцевое пространство</th>
            <th colspan="2">Обвязк буровой установки</th>
        </tr>
        <tr>
            <th>От (верх)</th>
            <th>До (низ)</th>
            <th>Бурение, проработка, промывка</th>
            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>
            <th>Проект</th>
            <th>Факт</th>
        </tr>
        <tr v-for="i in 10">
            <td v-for="i in 10"></td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "deepening-gidro"
    }
</script>

<style scoped>
    .dropdown-toggle, .dropdown-menu{
        width: calc(100% + 20px)!important;
    }
</style>