<template>
    <table class="table defaultTable">
        <tbody>
        <tr>
            <th v-for="(n, i) in 12" ></th>
        </tr>
        <tr v-for="(n, i) in 10">
            <td v-for="(n, i) in 12"></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "TechnicalTask"
    }
</script>

<style scoped>

</style>