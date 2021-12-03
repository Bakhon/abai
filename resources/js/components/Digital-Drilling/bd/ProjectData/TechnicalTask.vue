<template>
    <div class="DailyDrillingReport">
        <table class="table defaultTable">
            <tbody>
            <tr>
                <th>Месторождение</th>
                <th>№ скважины</th>
                <th class="raport">Полное название технического проекта</th>
                <th></th>
            </tr>
            <tr v-for="i in 30">
                <td>

                </td>
                <td>

                </td>
                <td>
                </td>
                <td>
                    <button class="download" @click="downloadFile(DIGITAL_DRILLING_URL + currentWell.well_id +'/?file_id='+ report.file_id)">
                        Скачать
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import {digitalDrillingState, globalloadingMutations} from '@store/helpers';

    export default {
        name: "TechnicalTask",
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