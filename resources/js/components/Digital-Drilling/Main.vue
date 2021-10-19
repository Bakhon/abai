<template>
    <div class="main__component">
        <div class="main__component-header">
            <div class="main__component-header-content">
                <div class="main__component-back">
                    <img src="/img/digital-drilling/back-icon.png" alt="">
                    <img src="/img/digital-drilling/reboot-icon.png" alt="">
                </div>
                <div class="main__component-filters">
                    <dropdown title="ДЗО" :options="dzo" class="dropdown__area" @updateList="getField"/>
                    <dropdown title="Месторождение" :options="fields" class="dropdown__area"
                              :search="true"
                              @updateList="getWELL"
                              @search="filterField"/>
                    <dropdown title="Сважина" :options="well" class="dropdown__area"
                              :search="true"
                              @updateList="changeCurrentWell"
                              @search="filterWell"/>
                </div>
            </div>
        </div>
        <div class="main__component-body defaultScroll">
            <component v-bind:is="page.component" />
            <div class="filter__not">
                <div class="filter__not-background">
                    <img src="/img/digital-drilling/toFilter.svg" alt="" class="notFilter">
                    <div class="text">
                        Выберите  скважину с помощью фильтра
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import {digitalDrillingActions, digitalDrillingState} from '@store/helpers';
    import Dropdown from './components/dropdown'
    export default {
        name: "Main",
        components: {Dropdown},
        props: ['page'],
        data(){
            return{
                dzo: [],
                fields: [],
                well: [],
                currentDZO: null,
                currentField: null,
            }
        },
        mounted(){
            this.getDZO()
        },
        computed:{
            ...digitalDrillingState([
                'currentWell'
            ]),
        },
        methods: {
            async filterField(query){
                await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/search/'+this.currentDZO.id+'?q='+query).then((response) => {
                    let data = response.data;
                    if (data) {
                        this.fields = data;
                        if (data.length>0){
                            this.currentField = data[0].id;
                        }

                    } else {
                        console.log('No data');
                    }
                });
            },
            filterWell(query){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/search/'+this.currentDZO.id+'/'+this.currentField.id+'?q='+query).then((response) => {
                    let data = response.data;
                    if (data) {
                        this.well = data;
                    } else {
                        console.log('No data');
                    }
                });
            },
            getDZO(){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/search').then((response) => {
                    let data = response.data;
                    if (data) {
                        this.dzo = data;
                        this.currentDZO = data[0];
                        this.getField('')
                    } else {
                        console.log('No data');
                    }
                });

            },
            async getField(item){
                if (item!=''){
                    this.currentDZO = item
                }
                await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/search/'+this.currentDZO.id).then((response) => {
                    let data = response.data;
                    if (data) {
                        this.fields = data;
                        this.currentField = data[0];
                        this.getWELL('')
                    } else {
                        console.log('No data');
                    }
                });

            },
            getWELL(item){
                if (item!=''){
                    this.currentField = item
                }
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/search/'+this.currentDZO.id+'/'+this.currentField.id).then((response) => {
                    let data = response.data;
                    if (data) {
                        this.well = data;
                    } else {
                        console.log('No data');
                    }
                });

            },
            changeCurrentWell(item){
                this.changeCurrentWellValue(item)
            },
            ...digitalDrillingActions([
                'changeCurrentWellValue'
            ]),
        },
    }
</script>

<style scoped>
    .main__component{
        width: 100%;
        height: 100%;
        border: 6px solid #20274F;
        border-top: 0;
    }
    .main__component-header{
        background: #20274F;
        width: 100%;
        padding: 6px 0;
    }
    .main__component-header-content{
        background: #323370;
        border: 1px solid #545580;
        height: 31px;
        width: 100%;
        display: flex;
        align-items: center;
        padding: 0 6px 0 15px;
    }
    .main__component-back img{
        margin-right: 14px;
        cursor: pointer;
    }
    .main__component-filters{
        height: 100%;
        display: flex;
        align-items: center;
        margin-left: auto;
    }
    .main__component-filters .dropdown__area{
        margin-left: 6px;
    }
    .main__component-body{
        position: relative;
        width: 100%;
        height: calc(100% - 43px);
        padding: 5px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    .filter__not.active{
        display: block;
    }
    .filter__not{
        display: none;
        top: 0;
        left: 0;
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 15;
    }
    .filter__not-background{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .filter__not-background .text{
        margin-top: 30px;
        font-weight: bold;
        font-size: 22px;
        line-height: 26px;
        text-align: center;

        color: #FFFFFF;
        text-align: center;
    }

</style>