<template>
    <div class="digitalDrillingWindow">
        <div class="row">
            <div class="col-sm-12">
                <table class="table defaultTable">
                    <tr>
                        <th colspan="2">{{ trans('digital_drilling.complications.drilling_interval') }}</th>
                        <th>{{ trans('digital_drilling.complications.stratigraphic_subdivision_index') }}</th>
                        <th colspan="2">{{ trans('digital_drilling.complications.driving_distance_m') }}</th>
                        <th colspan="2">{{ trans('digital_drilling.complications.dolt_size_m') }}</th>
                        <th colspan="2">{{ trans('digital_drilling.complications.specific_gravity') }}</th>
                        <th colspan="2">{{ trans('digital_drilling.complications.complication_type') }}</th>
                        <th>{{ trans('digital_drilling.complications.characteristics_actual_complication') }}</th>
                    </tr>
                    <tr>
                        <th>{{ trans('digital_drilling.project') }}</th>
                        <th>{{ trans('digital_drilling.fact') }}</th>
                        <th></th>
                        <th>{{ trans('digital_drilling.project') }}</th>
                        <th>{{ trans('digital_drilling.fact') }}</th>
                        <th>{{ trans('digital_drilling.project') }}</th>
                        <th>{{ trans('digital_drilling.fact') }}</th>
                        <th>{{ trans('digital_drilling.project') }}</th>
                        <th>{{ trans('digital_drilling.fact') }}</th>
                        <th>{{ trans('digital_drilling.project') }}</th>
                        <th>{{ trans('digital_drilling.fact') }}</th>
                        <th></th>
                    </tr>
                    <tr v-for="i in 15">
                        <td v-for="i in 12"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "complications"
    }
</script>

<style scoped>

</style>