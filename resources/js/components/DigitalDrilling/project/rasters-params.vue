<template>
    <table class="table defaultTable rastersParams">
        <tr>
            <th rowspan="3">{{ trans('digital_drilling.drilling_fluids.solution_name') }}</th>
            <th colspan="2">{{ trans('digital_drilling.rasters.interval_along_trunk') }}</th>
            <th colspan="14">{{ trans('digital_drilling.drilling_fluids.mud_parameters') }}</th>
        </tr>
        <tr>
            <th colspan="1" rowspan="2">{{ trans('digital_drilling.from') }}</th>
            <th colspan="1" rowspan="2">{{ trans('digital_drilling.to') }}</th>
            <th colspan="1" rowspan="2" class="verticalText"><span>{{ trans('digital_drilling.drilling_fluids.density') }}</span></th>
            <th colspan="1" rowspan="2" class="verticalText"><span>{{ trans('digital_drilling.drilling_fluids.conditional_viscosity') }}</span></th>
            <th colspan="1" rowspan="2" class="verticalText"><span>{{ trans('digital_drilling.rasters.water_loss_30_min') }}</span></th>
            <th colspan="2">{{ trans('digital_drilling.rasters.SNS_100ft') }}</th>
            <th colspan="1" rowspan="2" class="verticalText"><span>{{ trans('digital_drilling.drilling_fluids.crust') }}</span></th>
            <th colspan="3">{{ trans('digital_drilling.rasters.solid_phase_content') }}</th>
            <th colspan="1" rowspan="2">рН</th>
            <th colspan="1" rowspan="2" class="verticalText"><span>{{ trans('digital_drilling.rasters.mineralization_no_more') }}</span></th>
            <th colspan="1" rowspan="2" class="verticalText"><span>{{ trans('digital_drilling.drilling_fluids.plastic_viscosity') }}</span></th>
            <th colspan="1" rowspan="2" class="verticalText"><span>{{ trans('digital_drilling.rasters.dynamic_shear_stress_100ft2') }}</span></th>
            <th colspan="1" rowspan="2" class="verticalText"><span>{{ trans('digital_drilling.drilling_fluids.density_before_weighting') }}</span></th>
        </tr>
        <tr>
            <th colspan="1">1 мин</th>
            <th colspan="1">10 мин</th>
            <th colspan="1" class="verticalText"><span>{{ trans('digital_drilling.rasters.active') }}</span></th>
            <th colspan="1" class="verticalText"><span>{{ trans('digital_drilling.rasters.sand') }}</span></th>
            <th colspan="1" class="verticalText"><span>{{ trans('digital_drilling.all') }}</span></th>
        </tr>
        <tr>
            <td v-for="i in 17">{{i+1}}</td>
        </tr>
        <tr v-for="i in 20">
            <td v-for="i in 17"></td>
        </tr>
    </table>
</template>

<script>
    export default {
        name: "rasters-params"
    }
</script>

<style scoped>

</style>