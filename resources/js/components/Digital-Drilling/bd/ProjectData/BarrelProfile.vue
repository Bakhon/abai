<template>
    <table class="table defaultTable">
        <tbody>
        <tr>
            <th colspan="4" class="align-middle">{{trans('digital_drilling.barrel_profile.vertical_spacing')}}</th>
            <th colspan="2">{{trans('digital_drilling.barrel_profile.azimuth')}}</th>
            <th colspan="4" class="align-middle">{{trans('digital_drilling.barrel_profile.zenith_angle')}}</th>
            <th colspan="4" class="align-middle">{{trans('digital_drilling.barrel_profile.horizontal_deflection')}}</th>
            <th colspan="4" class="align-middle">{{trans('digital_drilling.barrel_profile.horizontal_deflection')}}</th>
        </tr>
        <tr>
            <th colspan="2">{{trans('digital_drilling.project')}}</th>
            <th colspan="2">{{trans('digital_drilling.fact')}}</th>
            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}кт</th>
            <th colspan="2">{{trans('digital_drilling.project')}}</th>
            <th colspan="2">{{trans('digital_drilling.fact')}}</th>
            <th colspan="2">{{trans('digital_drilling.project')}}</th>
            <th colspan="2">{{trans('digital_drilling.fact')}}</th>
            <th colspan="2">{{trans('digital_drilling.project')}}</th>
            <th colspan="2">{{trans('digital_drilling.fact')}}</th>
        </tr>
        <tr>
            <th>{{trans('digital_drilling.from')}}</th>
            <th>{{trans('digital_drilling.to')}}</th>
            <th>{{trans('digital_drilling.from')}}</th>
            <th>{{trans('digital_drilling.to')}}</th>

            <th></th>
            <th></th>

            <th>{{trans('digital_drilling.barrel_profile.beginning_interval')}}</th>
            <th>{{trans('digital_drilling.barrel_profile.finishing_interval')}}</th>
            <th>{{trans('digital_drilling.barrel_profile.beginning_interval')}}</th>
            <th>{{trans('digital_drilling.barrel_profile.finishing_interval')}}</th>

            <th>{{trans('digital_drilling.barrel_profile.general')}}</th>
            <th>{{trans('digital_drilling.barrel_profile.interval')}}</th>
            <th>{{trans('digital_drilling.barrel_profile.general')}}</th>
            <th>{{trans('digital_drilling.barrel_profile.interval')}}</th>
            <th>{{trans('digital_drilling.barrel_profile.intervals')}}</th>
            <th>{{trans('digital_drilling.barrel_profile.generals')}}</th>
            <th>{{trans('digital_drilling.barrel_profile.intervals')}}</th>
            <th>{{trans('digital_drilling.barrel_profile.generals')}}</th>
        </tr>
        <tr v-for="(n, i) in 10">
            <td v-for="(n, i) in 18"></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "BarrelProfile"
    }
</script>

<style scoped>

</style>