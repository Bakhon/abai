<template>
    <table class="table defaultTable rastersParams">
        <tr>
            <th rowspan="2">{{ trans('digital_drilling.rasters.interval_number_proportion_drilling_mud') }}</th>
            <th colspan="2">{{ trans('digital_drilling.rasters.interval_along_trunk') }}</th>
            <th rowspan="2">{{ trans('digital_drilling.drilling_fluids.solution_name') }}</th>
            <th rowspan="2">{{ trans('digital_drilling.rasters.density_solution') }}</th>
            <th rowspan="2">{{ trans('digital_drilling.rasters.interval_drilling_yes_no') }}</th>
            <th rowspan="2">{{ trans('digital_drilling.rasters.component_name') }}</th>
            <th rowspan="2">{{ trans('digital_drilling.rasters.density_kg_m3') }}</th>
            <th rowspan="2">{{ trans('digital_drilling.rasters.substance_content_commercial_product') }}</th>
            <th rowspan="2" class="verticalText"><span>{{ trans('digital_drilling.rasters.humidity') }}</span></th>
            <th rowspan="2">{{ trans('digital_drilling.rasters.variety') }}</th>
            <th rowspan="2">{{ trans('digital_drilling.rasters.component_content_in_drilling_fluid') }}</th>
        </tr>
        <tr>
            <th colspan="1">{{ trans('digital_drilling.from') }}</th>
            <th colspan="1">{{ trans('digital_drilling.to') }}</th>
        </tr>
        <tr>
            <td v-for="i in 12">{{i}}</td>
        </tr>
        <tr v-for="i in 20">
            <td v-for="i in 12"></td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "rasters-component"
    }
</script>

<style scoped>

</style>