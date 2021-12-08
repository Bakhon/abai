<template>
    <div class="h-100">
        <div class="p-3 p-4 d-flex flex-column align-items-center h-100 text-white">
            <div class="form-group row w-100">
                <label for="dataSelect" class="col-sm-4 col-form-label">{{ trans('map_constructor.select_data') }}</label>
                <div class="col-sm-8">
                    <select class="form-control" id="dataSelect">
                        <option value="kno" disabled>{{ trans('map_constructor.select_kno') }}</option>
                        <option value="kto">{{ trans('map_constructor.select_kto') }}</option>
                    </select>
                </div>
            </div>
            <div class="col w-100 mb-1">
                <div class="form-group row mb-1">
                    <label for="dzoFilter" class="col-sm-4 col-form-label mb-1">
                      {{ trans('map_constructor.dzo') }}:
                    </label>
                    <div class="col-sm-8">
                        <select class="form-control" id="dzoFilter"
                                v-model="selectedDzo"
                                @change="getGeoList('field', $event.target.value)"
                        >
                            <option v-for="dzo in dzoList" :value="dzo.id">{{ dzo.name_ru }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-1" v-if="fieldList.length > 0">
                    <label for="fieldFilter" class="col-sm-4 col-form-label mb-1">
                      {{ trans('map_constructor.field') }}:
                    </label>
                    <div class="col-sm-8">
                        <select class="form-control" id="fieldFilter"
                                v-model="selectedField"
                                @change="getGeoList('horizon', $event.target.value)"
                        >
                            <option v-for="field in fieldList" :value="field.id">{{ field.name_ru }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-1" v-if="horizonList.length > 0">
                    <label for="horizonFilter" class="col-sm-4 col-form-label mb-1">
                      {{ trans('map_constructor.horizon') }}:
                    </label>
                    <div class="col-sm-8">
                        <select class="form-control" id="horizonFilter" v-model="selectedHorizon">
                            <option v-for="horizon in horizonList" :value="horizon.id">
                              [{{ horizon.id }}] {{ horizon.name_ru }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
          <div class="mt-3 d-flex flex-row-reverse w-100">
            <button type="button" class="btn btn-secondary" @click="$emit('close')"> {{ trans('map_constructor.cancel') }}</button>
            <button type="button" class="btn btn-primary mr-1" @click="buildMapSpecificHandler"> {{ trans('map_constructor.build') }}</button>
          </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            geoList: Object,
            getGeoList: Function,
            buildMapSpecific: Function,
        },
        data() {
            return {
                dateBuildMap : null,
                selectedDzo: null,
                selectedField: null,
                selectedHorizon: null,
            }
        },
        computed: {
            dzoList() {
                return this.geoList.dzoList;
            },
            fieldList() {
                return this.geoList.fieldList;
            },
            horizonList() {
                return this.geoList.horizonList;
            },
        },
        methods: {
            buildMapSpecificHandler() {
                this.buildMapSpecific({
                    selectedDzo: this.selectedDzo,
                    selectedField: this.selectedField,
                    selectedHorizon: this.selectedHorizon,
                });
            }
        }
    }
</script>
