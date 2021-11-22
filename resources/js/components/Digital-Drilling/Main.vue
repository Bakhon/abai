<template>
    <div class="main__component">
        <div class="main__component-header">
            <div class="main__component-header-content">
                <div class="main__component-back">
                    <img src="/img/digital-drilling/back-icon.png" alt="">
                    <img src="/img/digital-drilling/reboot-icon.png" alt="">
                </div>
                <div class="main__component-filters">
                    <dropdown title="ДЗО" :options="dzo" :current="currentDZO" class="dropdown__area" @updateList="getField"/>
                    <dropdown title="Месторождение" :options="fields" :current="currentField" class="dropdown__area"
                              :search="true"
                              :cancelFilter="true"
                              @cancelFilterItem="cancelField"
                              @updateList="getWELL"
                              @search="filterField"/>
                    <div class="search-well">
                        <img src="/img/digital-drilling/search.png" alt="">
                        <input type="text" placeholder="Введите номер скважины" v-model="query" @input="filterWell">
                        <button class="search" @click="filterWell">
                            Поиск
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="main__component-body defaultScroll">
            <div class="filter-result" v-if="filter">
                <div class="filter-head">
                    <span v-if="!error">Результаты поиска скважин</span>
                    <span v-else>Введите номер скважины</span>

                </div>
                <table class="table defaultTable" v-if="!error">
                    <thead>
                    <tr>
                        <th> ДЗО</th>
                        <th> Месторождение</th>
                        <th> Скважина</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in well" @click="changeCurrentWell(item)">
                        <td>{{currentDZO.name}}</td>
                        <td>{{item.field_name}}</td>
                        <td>{{item.well_num}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <component v-bind:is="page.component" v-if="!filter"/>
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
    import {digitalDrillingActions, digitalDrillingState, globalloadingMutations} from '@store/helpers';
    import Dropdown from './components/dropdown'
    export default {
        name: "Main",
        components: {Dropdown},
        props: ['page'],
        data(){
            return{
                filter: false,
                query: '',
                dzo: [],
                fields: [],
                well: [],
                currentDZO: {
                    name: ''
                },
                currentField: {
                    name: ''
                },
                currentWellItem: {
                    name: ''
                },
                error: false
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
            ...globalloadingMutations([
                'SET_LOADING'
            ]),
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
            async filterWell(){
                this.filter = true
                let url = '/digital_drilling/api/search/wellnum/'+this.currentDZO.id+'/'
                if (this.query) {
                    this.error = false
                    if (this.currentField.id) {
                       url = '/digital_drilling/api/search/'+this.currentDZO.id+'/'+this.currentField.id+'?q='+this.query
                    }else{
                       url ='/digital_drilling/api/search/wellnum/'+this.currentDZO.id+'/'+this.query
                    }
                }else{
                    if (this.currentField.id) {
                        url ='/digital_drilling/api/search/'+this.currentDZO.id+'/'+this.currentField.id
                    }
                }
                this.SET_LOADING(true);
                await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + url).then((response) => {
                    let data = response.data;
                    if (data) {
                        this.well = data;
                    } else {
                        console.log('No data');
                    }
                });
                this.SET_LOADING(false);
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
                    this.filterWell()
                }
                await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/search/'+this.currentDZO.id).then((response) => {
                    let data = response.data;
                    if (data) {
                        this.fields = data;
                    } else {
                        console.log('No data');
                    }
                });

            },
            getWELL(item){
                if (item!=''){
                    this.currentField = item
                    this.filterWell()
                }
            },
            cancelField(){
                this.currentField = {
                    id: '',
                    name: ''
                }
                this.filterWell()
            },
            changeCurrentWell(item){
                this.query = item.well_num
                this.filter = false
                this.currentWellItem = item
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
    .search-well{
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #1F2142;
        border: 1px solid #454FA1;
        font-size: 14px;
        line-height: 1;
        color: #FFFFFF;
        width: 260px;
        min-width: 200px;
        height: 23px;
        padding: 0 10px;
        cursor: pointer;
    }
    .search-well img{
        width: 16px;
        height: 16px;
        margin-right: 10px;
    }
    .search-well input{
        height: 80%;
        font-size: 14px;
        background-color: transparent;
        width: 70%;
        border: 0;
    }
    .search-well input::placeholder{
        color: #9EA4C9;
    }

    .search-well input:focus{
        outline: none;
    }
    .search-well button{
        border: 0;
        height: 80%;
        background: #3366FF;
        border-radius: 2px;
        color: #FFFFFF;
        font-size: 12px;
        line-height: 1;
        padding: 0 6px;
        margin-left: 10px;
        font-weight: bold;
    }
    .filter-result{
        width: 100%;
        min-height: 100%;
        background: #272953;
    }
    .filter-head{
        width: 100%;
        padding: 7px 10px;
        font-size: 14px;
        line-height: 17px;
        background: #323370;
        margin-bottom: 5px;
    }
    .filter-result table tr:hover{
        background: #3A53B2;
        cursor: pointer;
    }
    .filter-result table td{
        padding: 7px;
        font-size: 12px;
        line-height: 12px;
        text-align: center;
    }
</style>