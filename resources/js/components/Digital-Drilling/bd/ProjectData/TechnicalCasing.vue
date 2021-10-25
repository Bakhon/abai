<template>
    <table class="table defaultTable">
        <tbody>
        <tr>
            <th colspan="11">{{trans('digital_drilling.technical_casing.elements')}}</th>
            <th colspan="4">{{trans('digital_drilling.technical_casing.column_totals')}}</th>
        </tr>
        <tr>
            <th rowspan="2" class="align-middle">{{trans('digital_drilling.technical_casing.column_name')}}</th>
            <th rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.technical_casing.name_code_standard_size')}}</th>
            <th rowspan="2" colspan="2" class="align-middle">м{{trans('digital_drilling.technical_casing.element_weight')}}</th>
            <th colspan="4">{{trans('digital_drilling.technical_casing.installation_interval')}}</th>
            <th rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.technical_casing.number_of_elements')}}</th>
            <th rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.technical_casing.quantity')}}</th>
            <th rowspan="2" colspan="2" class="align-middle">{{trans('digital_drilling.technical_casing.weight')}}</th>
        </tr>
        <tr>
            <th colspan="2">{{trans('digital_drilling.project')}}</th>
            <th colspan="2">{{trans('digital_drilling.fact')}}</th>
        </tr>
        <tr>
            <th></th>
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
            <td v-for="(n, i) in 15"></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "TechnicalCasing"
    }
</script>

<style scoped>

</style>