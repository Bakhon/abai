<template>
    <daily-raport v-if="isReport"
                  :report="report"
                  :user="currentUser.username"
                  :isEdit="isEdit"
                  :show="is_open"
                  :fixedStyle="true"
                  @changeReport="changeReport"
                  @closeReport="isReport=false"
    />
    <div class="DailyDrillingReport" v-else>
        <div class="report-modal">
            <div class="report_content">
                <div class="report_content_header">
                    <div class="report_content_header-btn">
                        <div class="btn-tech" @click="getReportsByWell" :class="{active: importFiles}">Импортированные</div>
                        <div class="btn-tech" @click="getFormReports" :class="{active: !importFiles}">Форма ввода</div>
                    </div>
                </div>
                <div class="report_content-inner">
                    <div class="report_content_body">
                        <div v-if="importFiles">
                            <table class="table defaultTable">
                                <tbody>
                                <tr>
                                    <th>{{ trans('digital_drilling.default.daily_report_number') }}</th>
                                    <th>{{ trans('digital_drilling.inclino.date') }}</th>
                                    <th class="raport">{{ trans('digital_drilling.default.daily_report') }}</th>
                                    <th></th>
                                </tr>
                                <tr v-for="report in reports" v-if="reports.length>0">
                                    <td>
                                        №{{ report.document_num }}
                                    </td>
                                    <td>
                                        {{ report.document_date }}
                                    </td>
                                    <td>
                                        {{ report.document_name}}
                                    </td>
                                    <td>
                                        <a :href="DIGITAL_DRILLING_URL + currentWell.well_id + '/?file_id=' + report.file_id" target="_blank" class="download" style="color: #ffffff; text-decoration: none;">
                                            Скачать
                                        </a>
                                    </td>
                                </tr>
                                <tr v-if="reports.length==0">
                                    <td colspan="3">
                                        no result
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else>
                            <table class="table defaultTable">
                                <tbody>
                                <tr>
                                    <th>{{ trans('digital_drilling.default.daily_report_number') }}</th>
                                    <th>{{ trans('digital_drilling.inclino.date') }}</th>
                                    <th></th>
                                </tr>
                                <tr v-for="report in reports" v-if="reports.length>0">
                                    <td>
                                        №{{ report.report_num }}
                                    </td>
                                    <td>
                                        {{ report.date }}
                                    </td>
                                    <td class="report-actions">
                                        <div class="report-actions-inner">
                                            <div class="download" @click="openReport(report.id)">
                                                Открыть
                                            </div>
                                            <div class="download delete" @click="deleteReport(report)" v-if="userCanDelete">
                                                Удалить
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="reports.length==0">
                                    <td colspan="3">
                                        no result
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="catalog-add" v-if="reportModalDelete">
            <div class="catalog-add-inner">
                <div class="catalog-add-form">
                    <div class="catalog-add-header">
                        <div class="catalog-add-title">
                           Отчет
                        </div>
                        <div class="catalog-add-close" @click="reportModalDelete=false">
                            Закрыть
                        </div>
                    </div>
                    <div class="catalog-add-content">
                        <span class="text-center">
                            Вы точно хотите удалить? </span>
                        <button @click="deleteReportFrom">Удалить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {digitalDrillingState, globalloadingMutations} from '@store/helpers';

    export default {
        name: "DailyDrillingReport",
        data(){
            return{
                reports: [],
                DIGITAL_DRILLING_URL: process.env.MIX_DIGITAL_DRILLING_URL+ '/digital_drilling/api/excel_loader/',
                importFiles: true,
                isReport: false,
                report: {},
                isEdit: false,
                is_open: true,
                reportModalDelete: false,
                currentReport: {},
            }
        },
        computed: {
            ...digitalDrillingState([
                'currentWell',
                'currentUser',
                'userCanDelete'
            ]),
        },
        mounted() {
            this.getReportsByWell()
        },
        watch: {
            currentWell: function (val) {
                this.getReportsByWell()
            }
        },
        methods:{
            deleteReportFrom(){
                this.axios.delete(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/report/' +
                    this.currentReport.id).then((response) => {
                    this.$bvToast.toast("Отчет удален успешно!!!", {
                        title: "Отчет",
                        variant: 'success',
                        solid: true,
                        toaster: "b-toaster-top-center",
                        autoHideDelay: 8000,
                    });
                }).catch((e)=>{
                    console.log(e)
                });
                this.reportModalDelete = false
            },
            deleteReport(report){
                this.currentReport = report
                this.reportModalDelete = true
            },
            openReport(id){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/report/'+id).then((response) => {
                    if (response) {
                        this.report = response.data
                        this.isReport = true
                    } else {
                        console.log("No data");
                    }
                })
                    .catch((error) => {
                        console.log(error)
                        this.showToast('', 'No result', 'danger');
                    })
            },
            changeReport(data){
                this.isEdit = true
                this.is_open = false
                this.report = data
            },
            downloadFile(){
            },
            ...globalloadingMutations([
                'SET_LOADING'
            ]),
            async getReportsByWell(){
                this.importFiles = true
                this.SET_LOADING(true);
                try{
                    await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL+ '/digital_drilling/api/excel_loader/' +
                        this.currentWell.well_id).then((response) => {
                        let data = response.data;
                        if (data) {
                            this.reports = data;
                        } else {
                            console.log('No data');
                        }
                    });
                }
                catch (e) {
                    console.log(e)
                }
                this.SET_LOADING(false);
            },
            async getFormReports(){
                this.importFiles = false
                this.SET_LOADING(true);
                try{
                    await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL+ '/digital_drilling/daily_report/reports/' +
                        this.currentWell.well_id).then((response) => {
                        let data = response.data;
                        if (data) {
                            this.reports = data;
                        } else {
                            console.log('No data');
                        }
                    });
                }
                catch (e) {
                    console.log(e)
                }
                this.SET_LOADING(false);
            },
        }
    }
</script>

<style scoped>
.DailyDrillingReport{
    width: 100%;
    height: 100%;
    background: #272953;
}
    .DailyDrillingReport .raport{
        min-width: 700px;
    }
    .DailyDrillingReport .download{
        background: #205AA3;
        border: 1px solid #454FA1;
        box-shadow: 0px 4px 3px rgba(0, 0, 0, 0.25);
        border-radius: 4px;
        width: 160px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        cursor: pointer;
    }
    .report-actions{
        max-width: 150px;
    }
    .report-actions-inner{
        display: flex;
        align-items: center;
    }
    .report-actions-inner .delete{
        background: rgba(237, 85, 100, 0.4);
        border: 0.5px solid #ED5564;
    }
.report-actions-inner .delete:hover{
    background: #C63E4B;
}

.report_content{
    background: #272953;
    box-shadow: 0px 7px 7px rgba(0, 0, 0, 0.25);
    padding: 15px;
    border: 1px solid #656A8A;
}
.report_content-inner{
    border: 10px solid rgba(69, 77, 125, 0.702);
    padding: 6px;
}
.report_content_body{
    max-height: 100%;
    height: auto;
    overflow-y: scroll;
    overflow-x: hidden;

}
.digital_drilling .report_content_body::-webkit-scrollbar-thumb{
    background: #656A8A;
    border-radius: 10px;
}
.digital_drilling .report_content_body::-webkit-scrollbar{
    width:4px;
}

.report_content_header{
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.report_content_header-btn{
    display: flex;
}
.btn-tech{
    margin-right: 5px;
    background: #31335F;
    min-width: 150px;
    padding: 6px 15px 2px;
    text-align: center;
    cursor: pointer;
    border-radius: 10px 10px 0 0;
    color: #8389AF;
    align-self:end;
    user-select: none;
}
.btn-tech.active{
    font-weight: bold;
    padding: 10px 20px;
    background: rgba(69, 77, 125, 0.702);
    color: #ffffff;
}
.characteristic_header span{
    font-family: Harmonia Sans Pro Cyr;
    font-style: normal;
    font-weight: bold;
    font-size: 16px;
    line-height: 19px;

    color: #FFFFFF;
}
button{
    color: #FFFFFF;
}
    .catalog-add-content{
        display: flex;
        flex-direction: column;
    }
    .catalog-add-content button{
        margin-top: 20px;
    }
</style>