<template>
    <table class="table defaultTable rastersParams">
        <tbody>
        <tr>
            <th></th>
            <th>MD (м)</th>
            <th>CL (м)</th>
            <th>Inc (*)</th>
            <th>Azi (*)</th>
            <th>TVD (м)</th>
            <th>TVDSS (м)</th>
            <th>NS (м)</th>
            <th>EW (м)</th>
            <th>V.Sec (м)</th>
            <th>Dogleg (м)</th>
            <th>T.Face (м)</th>
            <th>Build (м)</th>
            <th>Turn (*/30м)</th>
            <th>Section Type</th>
            <th>Target</th>
        </tr>
        <tr v-for="i in 16">
            <td>{{ i+1 }}</td>
            <td>3946</td>
            <td>3946</td>
            <td>3946</td>
            <td>3946</td>
            <td>3946</td>
            <td>3946</td>
            <td>210</td>
            <td>3946</td>
            <td>3946</td>
            <td>3946</td>
            <td>3946</td>
            <td>0,00</td>
            <td>0,00</td>
            <td>Inc Azi MD</td>
            <td></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "deepening"
    }
</script>

<style scoped>

</style>