<template>
    <table class="table defaultTable">
        <tbody>
        <tr>
            <th rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.well_design.column_number')}}</th>
            <th rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.well_design.column_name')}}</th>
            <th colspan="4" class="align-middle">{{trans('digital_drilling.well_design.bore_spacing')}}</th>
            <th colspan="2">{{trans('digital_drilling.well_design.nominal_diameter')}}</th>
            <th colspan="2">{{trans('digital_drilling.well_design.wellhead_distance')}}</th>
            <th colspan="2">{{trans('digital_drilling.well_design.number_of_separately')}}</th>
            <th rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.well_design.vug_coefficient')}}</th>
        </tr>
        <tr>
            <th colspan="2">{{trans('digital_drilling.project')}}</th>
            <th colspan="2">{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
        </tr>
        <tr>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.from')}}</th>
            <th>{{trans('digital_drilling.to')}}</th>
            <th>{{trans('digital_drilling.from')}}</th>
            <th>{{trans('digital_drilling.to')}}</th>

            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>

            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
        </tr>
        <tr v-for="(n, i) in 10">
            <td v-for="(n, i) in 16"></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "WellDesign"
    }
</script>

<style scoped>

</style>