<template>
    <table class="table defaultTable ">
        <tr>
            <th rowspan="2">{{ trans('digital_drilling.calculation.outside_diameter_casing') }}</th>
            <th colspan="2">{{ trans('digital_drilling.calculation.wall_thickness') }}</th>
            <th colspan="2">{{ trans('digital_drilling.calculation.internal_diameter_variation') }}</th>
            <th colspan="2">{{ trans('digital_drilling.calculation.coupling_outer_diameter') }}</th>
            <th rowspan="2">{{ trans('digital_drilling.calculation.casing_wall_thickness') }}</th>
        </tr>
        <tr>
            <th>{{ trans('digital_drilling.calculation.minimum') }}</th>
            <th>{{ trans('digital_drilling.calculation.maximum') }}</th>
            <th>{{ trans('digital_drilling.calculation.minimum') }}</th>
            <th>{{ trans('digital_drilling.calculation.maximum') }}</th>
            <th>{{ trans('digital_drilling.calculation.minimum') }}</th>
            <th>{{ trans('digital_drilling.calculation.maximum') }}</th>
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