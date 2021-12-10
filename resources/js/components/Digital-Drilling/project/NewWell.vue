<template>
    <div class="newWell">
        <div class="well_content">
            <div class="well_body">
                <div class="well_body-header">
                    <div class="well_body-header-title">
                        {{ trans('digital_drilling.default.new_well') }}
                    </div>
                    <div class="well_body-header-close" @click="closeNewWell">
                        {{ trans('digital_drilling.default.close') }}
                    </div>
                </div>
                <div class="well_body-content">
                    <div class="well_body-content-title">
                        <span>Скважина 1</span>
                    </div>
                    <div class="well_body-inner">
                        <div class="well_body-form">
                            <div class="well_body-form-input">
                                <label for="DZO">{{ trans('digital_drilling.default.name_subsidiaries_affiliates') }}</label>
                                <select name="" id="DZO">
                                    <option value="" disabled selected="selected">
                                        {{ trans('digital_drilling.default.selection_subsidiaries_affiliates') }}
                                    </option>
                                </select>
                            </div>
                            <div class="well_body-form-input">
                                <label for="field">{{ trans('digital_drilling.default.field') }}:</label>
                                <select  id="field">
                                    <option value="" disabled selected="selected">{{ trans('digital_drilling.default.field_selection') }}</option>
                                </select>
                            </div>
                            <div class="well_body-form-input">
                                <label for="well">{{ trans('digital_drilling.passport.well') }}:</label>
                                <input type="text" :placeholder="trans('digital_drilling.default.enter_the_well')" id="well">
                            </div>
                            <div class="well_body-form-checkbox">
                                <div class="Ground">
                                    <label for="ground">{{ trans('digital_drilling.default.onshore') }}</label>
                                    <input type="checkbox" id="ground">
                                </div>
                                <div class="Marine">
                                    <label for="marine">{{ trans('digital_drilling.default.offshore') }}</label>
                                    <input type="checkbox" id="marine">
                                </div>
                            </div>
                            <div class="well_body-form-input">
                                <label for="height">{{ trans('digital_drilling.default.elevation_sea_level') }}</label>
                                <input type="text" :placeholder="trans('digital_drilling.default.height')" id="height">
                                <span class="input-size">м.</span>
                            </div>
                            <div class="well_body-form-input">
                                <label for="sheight">{{ trans('digital_drilling.default.height_rotary_table') }}</label>
                                <input type="text" :placeholder="trans('digital_drilling.default.height')" id="sheight">
                                <span class="input-size">м.</span>
                            </div>
                            <div class="well_body-form-coordinates">
                                <div class="coordinates-title">
                                    {{ trans('digital_drilling.default.wellhead_coordinates') }}
                                </div>
                                <div class="coordinates-form">
                                    <div class="coordinates-form-input">
                                        <label for="mouthX">x</label>
                                        <input type="text" id="mouthX" placeholder="| x">
                                    </div>
                                    <div class="coordinates-form-input">
                                        <label for="mouthY">y</label>
                                        <input type="text" id="mouthY" placeholder="| y">
                                    </div>
                                </div>
                            </div>
                            <div class="well_body-form-coordinates">
                                <div class="coordinates-title">
                                    {{ trans('digital_drilling.default.bottomhole_coordinates') }}
                                </div>
                                <div class="coordinates-form">
                                    <div class="coordinates-form-input">
                                        <label for="downholeX">x</label>
                                        <input type="text" id="downholeX" placeholder="| x">
                                    </div>
                                    <div class="coordinates-form-input">
                                        <label for="downholeY">y</label>
                                        <input type="text" id="downholeY" placeholder="| y">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="well-create">
                    {{ trans('digital_drilling.default.create') }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NewWell",
        methods:{
            closeNewWell(){
                this.$emit('closeNewWell')
            },
        },
    }
</script>

<style scoped>

</style>