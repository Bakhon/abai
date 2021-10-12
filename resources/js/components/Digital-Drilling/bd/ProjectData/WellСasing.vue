<template>
    <table class="table defaultTable">
        <tbody>
        <tr>
            <th rowspan="3" colspan="2" class="align-middle">{{trans('digital_drilling.well_casing.column_number')}}</th>
            <th rowspan="3" colspan="2">{{trans('digital_drilling.well_casing.number_of_the_separately')}}</th>
            <th rowspan="3" colspan="2" class="align-middle">{{trans('digital_drilling.well_casing.equal_strength_pipe')}}</th>
            <th colspan="4" class="align-middle">{{trans('digital_drilling.well_casing.installation_interval')}}</th>
            <th rowspan="3" colspan="2" class="align-middle">{{trans('digital_drilling.well_casing.section_length')}}</th>
            <th rowspan="3" colspan="2" class="align-middle">{{trans('digital_drilling.well_casing.section_weight')}}</th>
            <th rowspan="3" colspan="2" class="align-middle">{{trans('digital_drilling.well_casing.growing_mass')}}</th>
            <th colspan="8" class="align-middle">{{trans('digital_drilling.well_casing.casing_pipe_characteristic')}}</th>
            <th colspan="6" class="align-middle" >{{trans('digital_drilling.well_casing.safety_factors_at')}}</th>
        </tr>
        <tr>
            <th rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.from')}}</th>
            <th rowspan="2" colspan="2"></th>
            <th rowspan="2" colspan="2">{{trans('digital_drilling.well_casing.nominal_outer_diameter')}}</th>
            <th rowspan="2" colspan="2">{{trans('digital_drilling.well_casing.code_pipe')}}</th>
            <th rowspan="2" colspan="2">{{trans('digital_drilling.well_casing.mark')}}</th>
            <th rowspan="2" colspan="2">{{trans('digital_drilling.well_casing.wall_thickness')}}м</th>
            <th colspan="4">{{trans('digital_drilling.well_casing.overpressure')}}</th>
            <th rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.well_casing.stretching')}}</th>
        </tr>
        <tr>
            <th colspan="2">{{trans('digital_drilling.well_casing.outwardly')}}</th>
            <th colspan="2">{{trans('digital_drilling.well_casing.internal')}}</th>
        </tr>
        <tr>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
        </tr>
        <tr v-for="(n, i) in 10">
            <td v-for="(n, i) in 30"></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "WellСasing"
    }
</script>

<style scoped>
th, td{
    padding: 0.53rem;
    font-size: 12px!important;
}
</style>