<template>
    <div class="p-4 d-flex flex-column align-items-center h-100" style="background-color: #333975">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="checkIsolines" v-model="isolinesData.show">
            <label class="form-check-label" for="checkIsolines">
                {{ trans('map_constructor.show_isolines') }}
            </label>
        </div>
        <div class="d-col text-white mt-2">
            <div>{{ trans('map_constructor.min_value') }}: {{ isolinesData.bounds[0] }}</div>
            <div>{{ trans('map_constructor.max_value') }}: {{ isolinesData.bounds[1].toFixed(2) }}</div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-9">
                <select id="inputState" class="form-control" v-model="isolinesData.selectedFilterType">
                    <option selected value="0">{{ trans('map_constructor.isolines_count') }}</option>
                    <option value="1">{{ trans('map_constructor.interval') }}</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <input type="number" class="form-control" id="inputZip" v-model="isolinesData.selectedFilterValue">
            </div>
        </div>
        <div class="mt-3 d-flex flex-row-reverse w-100">
            <button type="button" class="btn btn-secondary" @click="$emit('close')"> {{ trans('map_constructor.cancel') }}</button>
            <button type="button" class="btn btn-primary mr-1" @click="save(isolinesData)"> {{ trans('map_constructor.save') }}</button>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        isolinesData: Object,
        visible: false,
        save: Function,
    },
    data: function () {
        return {
            showIsolines: true,
        }
    },
    methods: {
        ctxMenuAction(action) {
            this.$emit('ctxChildrenMenuAction', {
                action: action,
            })
        },
    }
}
</script>