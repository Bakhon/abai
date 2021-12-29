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
                                            <div class="download danger" @click="getRegistryData(report.id)" v-if="userCanDelete">
                                                Реестр
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
        <div class="delete-modal catalog-add" v-if="reportModalDelete">
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
                        <br>
                        <button @click="deleteReportFrom">Удалить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="characteristic__modal" v-if="registryModal">
            <div class="characteristic_content">
                <div class="characteristic_header">
                    <div class="header-btn">
                        <div class="btn-tech active">Изменения</div>
                    </div>
                    <div class="characteristic_header-close" @click="registryModal=false">
                        {{trans("digital_drilling.default.close")}}
                    </div>
                </div>
                <div class="characteristic_content-inner">
                    <div class="characteristic_body">
                        <div>
                            <table class="table defaultTable">
                                <thead>
                                    <tr>
                                        <th>Автор</th>
                                        <th>Дата</th>
                                        <th>Таблица</th>
                                        <th>Поля</th>
                                        <th>Был</th>
                                        <th>Изменен</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, i) in registryData" :key="data.id">
                                        <td>{{data.author}}</td>
                                        <td>{{data.date}}</td>
                                        <td>{{data.table_name}}</td>
                                        <td>{{data.column_name}}</td>
                                        <td>{{data.value_from}}</td>
                                        <td>{{data.value_to}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
                registryModal: false,
                registryData: [],
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
                    this.getFormReports()
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
            getRegistryData(id){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/report/'+id + '/changes/').then((response) => {
                    if (response) {
                        this.registryData = response.data
                        this.registryModal = true
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
.characteristic__modal{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    z-index: 20000;
    background: rgba(0, 0, 0, 0.5);
}
.characteristic_content{
    max-width: 900px;
    width: 90%;
    margin: 120px auto 0;
    height: 70vh;
    background: #272953;
    box-shadow: 0px 7px 7px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
    padding: 15px 15px 80px 15px;
    border: 1px solid #656A8A;
}
.characteristic_content-inner{
    height: calc(100% - 40px);
    border: 10px solid rgba(69, 77, 125, 0.702);
    padding: 6px;
}
.characteristic_content .characteristic_body{
    max-height: 100%;
    height: auto;
    overflow-y: scroll;
    overflow-x: hidden;
    padding: 0;
}
.digital_drilling .characteristic_body::-webkit-scrollbar-thumb{
    background: #656A8A;
    border-radius: 10px;
}
.digital_drilling .characteristic_body::-webkit-scrollbar{
    width:4px;
}

.characteristic_header{
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.header-btn{
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
.characteristic_header-close{
    background: #656A8A;
    border-radius: 10px;
    padding:0 15px;
    font-weight: bold;
    font-size: 16px;
    height: 26px;
    cursor: pointer;
}

.modalTable td{
    padding: 15px!important;
}
.characteristic__modal td{
    padding: 10px 5px!important;
}
.catalog-add{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    z-index: 20000;
    background: rgba(0, 0, 0, 0.5);
}
.catalog-add-inner{
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.catalog-add-form{
    min-width: 300px;
    width: max-content;
    min-height: 200px;
    height: auto;
    background: #272953;
    border: 2px solid #656A8A;
    border-radius: 8px;
    padding: 20px 14px;
}
.catalog-add-header{
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 30px;
    font-weight: bold;
    font-size: 18px;
    line-height: 22px;
    color: #FFFFFF;
}
.catalog-add-title{
}
.catalog-add-close{
    flex: 0 0 90px;
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #656A8A;
    border-radius: 6px;
    font-size: 16px;
    line-height: 19px;
    cursor: pointer;
}
.catalog-add-content input{
    display: block;
    width: 100%;
    margin-bottom: 30px;
    background: #1F2142;
    border: 1px solid #454FA1;
    border-radius: 4px;
    padding: 7px;
}
.catalog-add-content input.error{
    border-color: red;
}
.catalog-add-content input:focus{
    outline: none;
}
.catalog-add-content.flex{
    display: flex;
}
.catalog-add-content.flex .catalog-add-close{
    background-color: rgba(101, 106, 138, 1);;
}
.catalog-add-content.flex button{
    width: 45%;
    padding: 0!important;
    height: 30px!important;
}

.catalog-add-content button{
    background: rgba(46, 80, 233, 0.5);
    border: 0;
    margin: 0 auto;
    display: block;
    padding: 8px 40px;
    border-radius: 6px;
}
</style>