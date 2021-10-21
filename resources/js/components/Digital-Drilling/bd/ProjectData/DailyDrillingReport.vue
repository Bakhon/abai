<template>
    <div class="DailyDrillingReport">
        <table class="table defaultTable">
            <tbody>
                <tr>
                    <th>№ суточного рапорта</th>
                    <th>Дата</th>
                    <th class="raport">Суточный рапорт</th>
                    <th></th>
                </tr>
                <tr v-for="report in reports" v-if="reports.length>0">
                    <td>
                        {{ report.file_id }}
                    </td>
                    <td>
                        {{ report.document_date }}
                    </td>
                    <td>
                        {{ report.document_name}}
                    </td>
                    <td>
                        <button class="download" @click="downloadFile(DIGITAL_DRILLING_URL + currentWell.id +'/?file_id='+ report.file_id)">
                            Скачать
                        </button>
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
</template>

<script>
    import {digitalDrillingState, globalloadingMutations} from '@store/helpers';

    export default {
        name: "DailyDrillingReport",
        data(){
            return{
                reports: [],
                DIGITAL_DRILLING_URL: process.env.MIX_DIGITAL_DRILLING_URL+ '/digital_drilling/api/excel_loader/',
            }
        },
        computed: {
            ...digitalDrillingState([
                'currentWell'
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
            downloadFile(link){
                window.location.href = link;
            },
            ...globalloadingMutations([
                'SET_LOADING'
            ]),
            async getReportsByWell(){
                this.SET_LOADING(true);
                try{
                    await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL+ '/digital_drilling/api/excel_loader/' +
                        this.currentWell.id).then((response) => {
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
            }
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
    }

</style>