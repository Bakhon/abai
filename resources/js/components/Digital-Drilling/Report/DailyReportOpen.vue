<template>
    <div>
        <daily-raport v-if="created" :report="report" :user="user.username" :isEdit="isEdit" :show="is_open"
                      @changeReport="changeReport"
                      @closeReport="closeReport"
        />
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
                                <label for="field">{{ trans('digital_drilling.default.field') }}</label>
                                <select  id="field" v-model="currentField" @change="getWELL">
                                    <option value="" disabled selected="selected">{{ trans('digital_drilling.default.field_selection') }}</option>
                                    <option :value="item.id" v-for="item in fields">{{item.name}}</option>
                                </select>
                            </div>

                            <div class="well_body-form-checkbox">
                                <div class="Ground">
                                    <label for="ground">?????????? ????????????????</label>
                                    <input type="radio" value="new" name="well" id="ground" checked  @change="onChangeWellType($event)">
                                </div>
                                <div class="Marine">
                                    <label for="marine">????????????????????????</label>
                                    <input type="radio"  value="old" name="well" id="marine" @change="onChangeWellType($event)">
                                </div>
                            </div>
                            <div class="well_body-form-input" v-if="newWell=='new'">
                                <label for="well">{{ trans('digital_drilling.passport.well') }}:</label>
                                <input type="text" placeholder="| ?????????????? ????????????????" id="well" class="new"
                                       v-model="newWellNumber"
                                       :class="{error: error && newWellNumber==''}"
                                >
                            </div>
                            <div class="well_body-form-coordinates" v-if="newWell=='new'">
                                <div class="coordinates-title">
                                    {{ trans('digital_drilling.default.wellhead_coordinates') }}
                                </div>
                                <div class="coordinates-form">
                                    <div class="coordinates-form-input">
                                        <label for="mouthX">x</label>
                                        <input type="text" id="mouthX" placeholder="| x"
                                               v-model="whcx"
                                               :class="{error: error && whcx==null}"
                                        >
                                    </div>
                                    <div class="coordinates-form-input">
                                        <label for="mouthY">y</label>
                                        <input type="text" id="mouthY" placeholder="| y"
                                               v-model="whcy"
                                               :class="{error: error && whcy==null}"
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="well_body-form-input" v-if="newWell=='old'">
                                <label for="wellID">{{ trans('digital_drilling.passport.well') }}:</label>
                                <dropdown title="??????????????" :options="well" class="dropdown__area"
                                          :search="true"
                                          :report="true"
                                          :current="currentWell"
                                          @updateList="changeCurrentWell"
                                          @search="filterWell"/>
                            </div>
                            <div class="well_body-form-input last" v-if="newWell=='old'">
                                <label>?????????????????????????? ??????????:</label>
                                <div class="dropdown__area-edit">
                                    <input type="checkbox" v-model="is_open">
                                    <select name="" id="" v-model="dateOpen" class="date" :disabled="!is_open" :class="{error: is_open && error && dateOpen==''}">
                                        <option :value="report.id" v-for="report in reportData">???{{report.report_num}}, {{report.date}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="well-create" @click="create">
                    <span v-if="!is_open">{{ trans('digital_drilling.default.create') }}</span>
                    <span v-else>??????????????</span>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
    import DailyRaport from './DailyRaport'
    import Dropdown from '../components/dropdown'
    import moment from "moment";
    export default {
        name: "DailyReportOpen",
        components: {DailyRaport, Dropdown},
        props: ['user'],
        data(){
            return{
                newWell: "new",
                dzo: [],
                fields: [],
                well: {},
                newWellNumber: '',
                whcx: null,
                whcy: null,
                currentDZO: '',
                currentField: '',
                currentWell: '',
                created: false,
                report: {},
                error: false,
                isEdit: false,
                is_open: false,
                dateOpen: '',
                reportData: [],
            }
        },
        mounted(){
            this.getDZO()
        },
        methods:{
            closeReport(){
                this.created = false
            },
            create(){
                this.getDailyReport()
            },
            changeCurrentWell(item){
                this.currentWell = item
                this.getReportData(this.currentWell.well_id)
            },
            changeReport(data){
                this.isEdit = true
                this.is_open = false
                this.report = data
            },
            getReportData(id){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/reports/'+id).then((response) => {
                    let data = response.data;
                    if (data) {
                        this.reportData = data;
                    } else {
                        console.log('No data');
                    }
                });
            },
            getDailyReport(){
                if (!this.is_open){
                    if (this.newWell == 'new'){
                        if (this.newWellNumber!= '' && this.whcx != null && this.whcy != null){
                            this.error = false
                            this.axios.post(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/empty_report',
                                {
                                    "is_new_well": true,
                                    "uwi": this.newWellNumber,
                                    "geo": this.currentField,
                                    "org": this.currentDZO,
                                    "whcx": this.whcx,
                                    "whcy": this.whcy
                                }).then((response) => {
                                if (response.data) {
                                    this.report = response.data
                                    this.report.report_daily.author = this.user.username
                                    this.created = true
                                } else {
                                    console.log("No data");
                                }
                            })
                                .catch((error) => {
                                    if (error.response.data){
                                        this.$bvToast.toast(error.response.data.error_message, {
                                            title: "??????????",
                                            variant: 'danger',
                                            solid: true,
                                            toaster: "b-toaster-top-center",
                                            autoHideDelay: 8000,
                                        });
                                    }
                                })
                        }else{
                            this.error = true
                        }
                    }
                    else{
                        this.axios.post(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/empty_report',
                            {
                                "is_new_well": this.currentWell.is_new_well,
                                "well": this.currentWell.well_id,
                                "geo": this.currentField,
                                "org": this.currentDZO
                            }).then((response) => {
                            if (response.data) {
                                this.report = response.data
                                this.report.report_daily.author = this.user.username
                                this.created = true
                            } else {
                                console.log("No data");
                            }
                        })
                            .catch((error) => {
                                if (error.response.data){
                                    this.$bvToast.toast(error.response.data.error_message, {
                                        title: "??????????",
                                        variant: 'danger',
                                        solid: true,
                                        toaster: "b-toaster-top-center",
                                        autoHideDelay: 8000,
                                    });
                                }
                            })
                    }
                }else{
                    if (this.dateOpen == ''){
                        this.error = true
                    }else{
                        this.error = false
                        this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/report/'+this.dateOpen).then((response) => {
                            if (response) {
                                this.report = response.data
                                this.created = true
                            } else {
                                console.log("No data");
                            }
                        })
                            .catch((error) => {
                                console.log(error)
                                this.showToast('', 'No result', 'danger');
                            })
                    }
                }

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
            filterWell(query){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/digital_drill/search/'+this.currentDZO+'/'+this.currentField+'?q='+query).then((response) => {
                    let data = response.data;
                    if (data) {
                        this.well = data;
                    } else {
                        console.log('No data');
                    }
                });
            },
            getWELL(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/digital_drill/search/'+this.currentDZO+'/'+this.currentField).then((response) => {
                    let data = response.data;
                    if (data) {
                        this.well = data;
                        this.currentWell = data[0]
                        this.getReportData(this.currentWell.well_id)
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
    .dropdown__area{
        margin-left: 10px;
    }
    .error{
        border: 1px solid red!important;
    }
    label{
        margin-bottom: 0;
    }
    .dropdown__area-edit{
        width: 194px!important;
        display: flex;
        align-items: center;
        margin-left: 10px;
    }
    .well_body-form-input.last{
        display: flex;
        align-items: center;
        margin-top: 15px;
    }
    .date{
        background: #334296!important;
        border: 0.5px solid #454FA1;
        box-sizing: border-box;
        border-radius: 4px;
        width: 224px;
        height: 28px;
        margin-left: 10px;
    }

</style>