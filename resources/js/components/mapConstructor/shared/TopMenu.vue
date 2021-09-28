<template>
    <div class="top-menu">
        <div class="col-lg-3 pl-0 pr-1">
            <b-dropdown block class="w-100 map-dropdown" ref="dropdown">
                <template slot="button-content">
                    <i class="far fa-file mr-2"></i>
                    <span>{{ trans('map_constructor.file') }}</span>
                </template>
                <b-dropdown-item href="#">
                  {{ trans('map_constructor.new') }}
                </b-dropdown-item>
                <label for="file-upload" class="dropdown-item">
                  {{ trans('map_constructor.open') }}
                  <input type="file" name="myfile" id="file-upload"/>
                </label>

                <b-dropdown-item href="#">
                  {{ trans('map_constructor.save') }}
                </b-dropdown-item>
                <label for="import" class="dropdown-item">
                  {{ trans('map_constructor.import') }}
                  <input type="file" @change="importFile" name="import" id="import"/>
                </label>
                <b-dropdown-item data-toggle="modal" data-target="#exportModal">
                  {{ trans('map_constructor.export') }}
                </b-dropdown-item>
                <b-dropdown-item data-toggle="modal" data-target="#printerModal">
                  {{ trans('map_constructor.print') }}
                </b-dropdown-item>
            </b-dropdown>
        </div>
        <div class="col-lg-3 px-1">
            <b-dropdown block class=" w-100 map-dropdown">
                <template slot="button-content">
                    <i class="far fa-map mr-2"></i>
                    <span>{{ trans('map_constructor.map') }}</span>
                </template>
                <b-dropdown-item data-toggle="modal" data-target="#buildMapSpecificModal">{{ trans('map_constructor.build_current') }}</b-dropdown-item>
                <b-dropdown-item data-toggle="modal" data-target="#buildMapSpecificModal">{{ trans('map_constructor.build_accumulated') }}</b-dropdown-item>
                <b-dropdown-item data-toggle="modal" data-target="#buildMapModal">{{ trans('map_constructor.build_map') }}</b-dropdown-item>
                <b-dropdown-item href="#">{{ trans('map_constructor.calculator') }}</b-dropdown-item>
            </b-dropdown>
        </div>
        <div class="col-lg-3 px-1">
            <b-dropdown block class=" w-100 map-dropdown">
                <template slot="button-content">
                    <i class="fas fa-bars mr-2"></i>
                    <span>{{ trans('map_constructor.additionally') }}</span>
                </template>
                <b-dropdown-item href="#">{{ trans('map_constructor.voronov_diagram') }}</b-dropdown-item>
                <b-dropdown-item href="#">{{ trans('map_constructor.streamlines') }}</b-dropdown-item>
                <b-dropdown-item href="#">{{ trans('map_constructor.inventory_calculation') }}</b-dropdown-item>
                <b-dropdown-item href="#">{{ trans('map_constructor.waterflooding_elements') }}</b-dropdown-item>
            </b-dropdown>
        </div>
        <div class="col-lg-3 pl-1 pr-0">
            <div class="map-dropdown" data-toggle="modal" data-target="#reportModal">
                <div class="dropdown-toggle">
                    <i class="fas fa-file-invoice mr-2"></i>
                    <span class="text-white">{{ trans('map_constructor.report') }}</span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        methods: {
            importFile(event) {
                this.$refs.dropdown.hide(true);
                if (typeof event.target.files[0] != "undefined") {
                    this.$emit('importFile', event.target.files[0]);
                }
            },
        },
        mounted() {
        }
    }
</script>
