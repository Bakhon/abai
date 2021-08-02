<template>
    <table class="table defaultTable">
        <tbody>
        <tr>
            <th rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.drilling_fluids.solution_name')}}</th>
            <th rowspan="2" colspan="4" class="align-middle">И{{trans('digital_drilling.drilling_fluids.wellbore_interval')}}</th>
            <th colspan="2"></th>
            <th colspan="24">{{trans('digital_drilling.drilling_fluids.mud_parameters')}}</th>
        </tr>
        <tr>
            <th rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.drilling_fluids.density')}}</th>
            <th rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.drilling_fluids.conditional_viscosity')}}</th>
            <th rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.drilling_fluids.fluid_loss')}}</th>
            <th colspan="4">{{trans('digital_drilling.drilling_fluids.CHC')}}</th>
            <th rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.drilling_fluids.crust')}}</th>
            <th colspan="6">{{trans('digital_drilling.drilling_fluids.CHC')}}</th>
            <th rowspan="2" colspan="2" class="align-middle">pH</th>
            <th rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.drilling_fluids.plastic_viscosity')}}</th>
            <th rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.drilling_fluids.dynamic_tension')}}</th>
            <th rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.drilling_fluids.density_before_weighting')}}</th>

        </tr>
        <tr>
            <th rowspan="2" class="align-middle">{{trans('digital_drilling.project')}}</th>
            <th rowspan="2" class="align-middle">{{trans('digital_drilling.fact')}}</th>
            <th colspan="2">{{trans('digital_drilling.project')}}</th>
            <th colspan="2">{{trans('digital_drilling.fact')}}</th>
            <th colspan="2">{{trans('digital_drilling.project')}}</th>
            <th colspan="2">{{trans('digital_drilling.fact')}}
            <th colspan="2">{{trans('digital_drilling.project')}}</th>
            <th colspan="2">{{trans('digital_drilling.fact')}}</th>
            <th colspan="2">{{trans('digital_drilling.all')}}</th>
        </tr>
        <tr>
            <th>{{trans('digital_drilling.from')}}</th>
            <th>{{trans('digital_drilling.to')}}</th>
            <th>{{trans('digital_drilling.from')}}</th>
            <th>{{trans('digital_drilling.to')}}</th>

            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>

            <th>1 {{trans('digital_drilling.min')}}</th>
            <th>10 {{trans('digital_drilling.min')}}</th>
            <th>1 {{trans('digital_drilling.min')}}</th>
            <th>10 {{trans('digital_drilling.min')}}</th>

            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>

            <th>1 {{trans('digital_drilling.min')}}</th>
            <th>10 {{trans('digital_drilling.min')}}</th>
            <th>1 {{trans('digital_drilling.min')}}</th>
            <th>10 {{trans('digital_drilling.min')}}</th>
            <th>1 {{trans('digital_drilling.min')}}</th>
            <th>10 {{trans('digital_drilling.min')}}</th>

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
            <td v-for="(n, i) in 32"></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "DrillingFluids"
    }
</script>

<style scoped>

</style>