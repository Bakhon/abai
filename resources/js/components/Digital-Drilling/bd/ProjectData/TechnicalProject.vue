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
            <tr v-for="project in projects" v-if="projects.length>0">
                <td>
                    {{ currentWell.field_name }}
                </td>
                <td>
                    {{ currentWell.well_num }}
                </td>
                <td>
                    {{ project.document_name}}
                </td>
                <td>
                    <a class="download" :href="DIGITAL_DRILLING_FILE_URL + '/?file_id='+ project.file_id" target="_blank">Скачать</a>
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
                projects: [],
                DIGITAL_DRILLING_URL: process.env.MIX_DIGITAL_DRILLING_URL+ '/digital_drilling/api/tech_projects/',
                DIGITAL_DRILLING_FILE_URL: 'http://172.20.103.203:8089/get/',
            }
        },
        computed: {
            ...digitalDrillingState([
                'currentWell'
            ]),
        },
        mounted(){
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
                    await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL+ '/digital_drilling/api/tech_projects/' +
                        this.currentWell.well_id).then((response) => {
                        let data = response.data;
                        if (data) {
                            this.projects = data;
                            console.log(data)
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
        color: #FFFFFF!important;
        text-decoration: none;
    }

</style>