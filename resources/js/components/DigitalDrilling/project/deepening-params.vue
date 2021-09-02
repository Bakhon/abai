<template>
    <table class="table defaultTable rastersParams">
        <tr>
            <th colspan="2">{{ trans('digital_drilling.deepening.interval_m') }}</th>
            <th rowspan="2">{{ trans('digital_drilling.deepening.type_of_technological_operation') }}</th>
            <th rowspan="2">{{ trans('digital_drilling.deepening.drilling_method') }}</th>
            <th rowspan="2">{{ trans('digital_drilling.deepening.conditional_BHA_number') }}</th>
            <th colspan="3">{{ trans('digital_drilling.deepening.drilling_mode') }}</th>
            <th rowspan="2">{{ trans('digital_drilling.deepening.technological_operation_speed') }}</th>
        </tr>
        <tr>
            <th colspan="1">{{ trans('digital_drilling.from') }}</th>
            <th colspan="1">{{ trans('digital_drilling.to') }}</th>
            <th colspan="1">{{ trans('digital_drilling.deepening.axial_load_tf') }}</th>
            <th colspan="1">{{ trans('digital_drilling.deepening.rotation_speed_rpm') }}</th>
            <th colspan="1">{{ trans('digital_drilling.deepening.drilling_mud_flow_rate') }}</th>
        </tr>
        <tr>
            <td v-for="i in 9">{{i}}</td>
        </tr>
        <tr v-for="i in 20">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "deepening-params"
    }
</script>

<style scoped>

</style>