<template>
    <div>
        <daily-raport />
        <div class="newWell">
        <div class="well_content">
            <div class="well_body">
                <div class="well_body-header">
                    <div class="well_body-header-title">
                        {{ trans('digital_drilling.daily_raport.DAILY_DRILLING_REPORT') }}
                    </div>
                    <div class="well_body-header-close" @click="closeReport">
                        {{ trans('digital_drilling.default.close') }}
                    </div>
                </div>
                <div class="well_body-content">
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

                            <div class="well_body-form-checkbox">
                                <div class="Ground">
                                    <label for="ground">Новая скважина</label>
                                    <input type="radio" value="new" name="well" id="ground" checked  @change="onChangeWellType($event)">
                                </div>
                                <div class="Marine">
                                    <label for="marine">Существующая</label>
                                    <input type="radio"  value="old" name="well" id="marine" @change="onChangeWellType($event)">
                                </div>
                            </div>
                            <div class="well_body-form-input" v-if="newWell=='new'">
                                <label for="well">{{ trans('digital_drilling.passport.well') }}:</label>
                                <input type="text" placeholder="| Введите скважину" id="well">
                            </div>
                            <div class="well_body-form-coordinates" v-if="newWell=='new'">
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
                            <div class="well_body-form-input" v-if="newWell=='old'">
                                <label for="wellID">{{ trans('digital_drilling.passport.well') }}:</label>
                                <select  id="wellID">
                                    <option value="" disabled selected="selected">Выбор скавжины</option>
                                </select>
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
    </div>
</template>

<script>
    import DailyRaport from './DailyRaport'
    export default {
        name: "DailyReportOpen",
        components: {DailyRaport},
        data(){
            return{
                newWell: "new",
            }
        },
        methods:{
            onChangeWellType(event){
                this.newWell = event.target.value
            },
            closeReport(){
              this.$router.push('/digital-drilling')
            },
        },
    }
</script>

<style scoped>
.coordinates-form{
    max-width: 200px;
}
</style>