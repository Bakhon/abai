<template>
    <div class="digitalDrillingWindow">
        <div class="table">
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th>{{ trans('digital_drilling.structure.casing_type') }}</th>
                    <th>{{ trans('digital_drilling.structure.column_view') }}</th>
                    <th>{{ trans('digital_drilling.structure.column_running_interval_from') }}</th>
                    <th>{{ trans('digital_drilling.structure.column_running_interval_up') }}</th>
                    <th>{{ trans('digital_drilling.structure.side_barrel') }}</th>
                    <th>{{ trans('digital_drilling.structure.number_pipes') }}</th>
                    <th>{{ trans('digital_drilling.structure.poured_cement_volume') }}</th>
                    <th>{{ trans('digital_drilling.structure.cement_lifting_height') }}</th>
                    <th>{{ trans('digital_drilling.structure.packer_from') }}</th>
                    <th>{{ trans('digital_drilling.structure.packer_to') }}</th>
                    <th>{{ trans('digital_drilling.structure.column_running_depth') }}</th>
                    <th>{{ trans('digital_drilling.structure.packer') }}</th>
                </tr>
                <tr v-for="i in 20">
                    <td v-for="i in 12"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: "structure"
    }
</script>

<style scoped>

</style>