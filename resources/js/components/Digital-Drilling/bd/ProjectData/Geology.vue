<template>
    <table class="table defaultTable">
        <tbody>
        <tr>
            <th colspan="4">{{trans('digital_drilling.geology.depth_of_occurrence')}}</th>
            <th colspan="4">{{trans('digital_drilling.geology.stratigraphic_division')}}</th>
            <th colspan="4">{{trans('digital_drilling.geology.laying_elements')}}</th>
            <th rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.geology.vug_coefficient')}}</th>
        </tr>
        <tr>
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
            <th>{{trans('digital_drilling.from')}}</th>
            <th>{{trans('digital_drilling.to')}}</th>
            <th>{{trans('digital_drilling.from')}}</th>
            <th>{{trans('digital_drilling.to')}}</th>
            <th>{{trans('digital_drilling.from')}}</th>
            <th>{{trans('digital_drilling.to')}}</th>
            <th>{{trans('digital_drilling.from')}}</th>
            <th>{{trans('digital_drilling.to')}}</th>

            <th>{{trans('digital_drilling.project')}}</th>
            <th>{{trans('digital_drilling.fact')}}</th>
        </tr>
            <tr v-for="(n, i) in 10">
                <td v-for="(n, i) in 14"></td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "Geology"
    }
</script>

<style scoped>
</style>