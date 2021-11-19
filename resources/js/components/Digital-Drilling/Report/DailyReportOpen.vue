<template>
    <div>
        <daily-raport v-if="created" :report="report"/>
        <div class="newWell" v-if="!created">
        <div class="well_content">
            <div class="well_body">
                <div class="well_body-header">
                    <div class="well_body-header-title">
                        {{ trans('digital_drilling.daily_raport.DAILY_DRILLING_REPORT') }}
                    </div>
                    <a class="well_body-header-close" :href="this.localeUrl('/digital-drilling')">
                        {{ trans('digital_drilling.default.close') }}
                    </a>
                </div>
                <div class="well_body-content">
                    <div class="well_body-inner">
                        <div class="well_body-form">
                            <div class="well_body-form-input">
                                <label for="DZO">{{ trans('digital_drilling.default.name_subsidiaries_affiliates') }}</label>
                                <select name="" id="DZO" v-model="currentDZO" @change="getField">
                                    <option value="" disabled selected="selected">
                                        {{ trans('digital_drilling.default.selection_subsidiaries_affiliates') }}
                                    </option>
                                    <option :value="item.id" v-for="item in dzo">{{item.name}}</option>
                                </select>
                            </div>
                            <div class="well_body-form-input">
                                <label for="field">{{ trans('digital_drilling.default.field') }}:</label>
                                <select  id="field" v-model="currentField" @change="getWELL">
                                    <option value="" disabled selected="selected">{{ trans('digital_drilling.default.field_selection') }}</option>
                                    <option :value="item.id" v-for="item in fields">{{item.name}}</option>
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
                                <input type="text" placeholder="| Введите скважину" id="well" class="new">
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
                                <select  id="wellID" v-model="currentWell">
                                    <option value="" disabled selected="selected">Выбор скавжины</option>
                                    <option :value="item.well_id" v-for="item in well">{{item.well_num}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="well-create" @click="create">
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
                dzo: [],
                fields: [],
                well: {},
                currentDZO: '',
                currentField: '',
                currentWell: '',
                created: false,
                report: {},
            }
        },
        mounted(){
            this.getDZO()
        },
        methods:{
            create(){
                this.getDailyReport()
            },
            getDailyReport(){
                this.axios.post(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/empty_report',
                    {
                        "well": this.currentWell,
                        "geo": this.currentField,
                        "org": this.currentDZO
                    }).then((response) => {
                    if (response.data) {
                        this.report = response.data
                        this.created = true
                    } else {
                        console.log("No data");
                    }
                })
                    .catch((error) => console.log(error))
            },
            onChangeWellType(event){
                this.newWell = event.target.value
            },
            getDZO(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/search').then((response) => {
                    let data = response.data;
                    if (data) {
                        this.dzo = data;
                        this.currentDZO = data[0].id;
                        this.getField()
                    } else {
                        console.log('No data');
                    }
                });

            },
            async getField(){
                await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/search/'+this.currentDZO).then((response) => {
                    let data = response.data;
                    if (data) {
                        this.fields = data;
                        this.currentField = data[0].id;
                        this.getWELL('')
                    } else {
                        console.log('No data');
                    }
                });

            },
            getWELL(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/search/'+this.currentDZO+'/'+this.currentField).then((response) => {
                    let data = response.data;
                    if (data) {
                        this.well = data;
                    } else {
                        console.log('No data');
                    }
                });

            },
        },
    }
</script>

<style scoped>
    .coordinates-form{
        max-width: 200px;
    }
    .well_content{
        min-height: 300px;
    }
    .Marine{
        width: 160px;
    }

</style>