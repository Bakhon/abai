<template>
    <table class="table defaultTable rastersParams">
        <tr>
            <th rowspan="3" class="verticalText"><span>{{ trans('digital_drilling.deepening.conditional_BHA_number') }}</span></th>
            <th colspan="11">{{ trans('digital_drilling.deepening.BHA_ELEMENTS') }}</th>
        </tr>
        <tr>
            <th rowspan="2" class="verticalText"><span>{{ trans('digital_drilling.deepening.No_in_order') }}</span></th>
            <th rowspan="2">{{ trans('digital_drilling.deepening.size_short_name_BHA_element') }}</th>
            <th rowspan="2">{{ trans('digital_drilling.deepening.distance_from_installation_site') }}</th>
            <th colspan="5">{{ trans('digital_drilling.deepening.technical_specifications') }}</th>
            <th rowspan="2">{{ trans('digital_drilling.deepening.BHA_total_length') }}</th>
            <th rowspan="2">{{ trans('digital_drilling.deepening.BHA_total_mass') }}</th>
            <th rowspan="2">{{ trans('digital_drilling.deepening.Note') }}</th>
        </tr>
        <tr>
            <th colspan="1">{{ trans('digital_drilling.deepening.outside_diameter') }}</th>
            <th colspan="1">{{ trans('digital_drilling.deepening.diameter_flow_area') }}</th>
            <th colspan="1">{{ trans('digital_drilling.deepening.length_m') }}</th>
            <th colspan="1">{{ trans('digital_drilling.deepening.weight_kg') }}</th>
            <th colspan="1">{{ trans('digital_drilling.deepening.skew_angle_degrees') }}</th>
        </tr>
        <tr>
            <td v-for="i in 12">{{i+1}}</td>
        </tr>
        <tr v-for="i in 20">
            <td v-for="i in 12"></td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "deepening"
    }
</script>

<style scoped>

</style>