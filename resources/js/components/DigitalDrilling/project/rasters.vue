<template>
    <table class="table defaultTable ">
        <tbody>
        <tr>
            <th>Стратиграфия</th>
            <th>Литология</th>
            <th>Пластовое давление</th>
            <th>Поровое давление</th>
            <th>Гидроразрыв пород</th>
            <th>Горное давление</th>
        </tr>
        <tr v-for="i in 20">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "rasters"
    }
</script>

<style scoped>

</style>