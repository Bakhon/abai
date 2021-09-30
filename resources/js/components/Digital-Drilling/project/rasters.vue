<template>
    <table class="table defaultTable ">
        <tbody>
        <tr>
            <th>{{ trans('digital_drilling.rasters.stratigraphy') }}</th>
            <th>{{ trans('digital_drilling.rasters.lithology') }}</th>
            <th>{{ trans('digital_drilling.rasters.reservoir_pressure') }}</th>
            <th>{{ trans('digital_drilling.rasters.pore_pressure') }}</th>
            <th>{{ trans('digital_drilling.rasters.hydraulic_fracturing_rocks') }}</th>
            <th>{{ trans('digital_drilling.rasters.rock_pressure') }}</th>
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