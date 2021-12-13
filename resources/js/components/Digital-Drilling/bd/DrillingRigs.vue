<template>
    <div class="h-100">
        <div class="h-100">
            <div class="resultsBlock">
                <ul>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">14</span>
                                <span>{{ trans('digital_drilling.default.well') }}</span>
                            </p>
                            <p class="title green">{{ trans('digital_drilling.default.in_drilling') }}</p>
                            <p class="percent">
                                <img src="/img/digital-drilling/triangle.svg" alt="" class="mr-1"><span>5,2%</span> vs 23.03.2021
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">506</span>
                                <span>{{ trans('digital_drilling.default.well') }}</span>
                            </p>
                            <p class="title yellow">{{ trans('digital_drilling.default.drilled') }}</p>
                            <p class="percent"><img src="/img/digital-drilling/triangle.svg" alt="" class="mr-1"><span>1,4%</span> vs 23.03.2021</p>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">0</span>
                                <span>{{ trans('digital_drilling.default.well') }}</span>
                            </p>
                            <p class="title red">{{ trans('digital_drilling.default.in_mastering') }}</p>
                            <p class="percent"><span>0,0%</span> vs 23.03.2021</p>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">520</span>
                                <span>{{ trans('digital_drilling.default.well') }}</span>
                            </p>
                            <p class="title">{{ trans('digital_drilling.default.Total') }}</p>
                            <p class="percent"><img src="/img/digital-drilling/triangle.svg" alt="" class="mr-1"><span>1,4%</span> vs 23.03.2021</p>
                        </div>
                    </li>
                    <li>
                        <div class="analyticsBlock">
                            <p class="num"><span>1230</span>{{ trans('digital_drilling.default.meters') }}</p>
                            <p class="name"><img src="/img/digital-drilling/drilling-day.svg" alt=""><span>{{ trans('digital_drilling.default.drilled_per_day') }}</span></p>
                        </div>
                    </li>
                    <li>
                        <div class="analyticsBlock">
                            <p class="num"><span>14251</span>{{ trans('digital_drilling.default.meters') }}</p>
                            <p class="name"><img src="/img/digital-drilling/drilling-all.svg" alt=""><span>{{ trans('digital_drilling.default.total_drilled') }}</span></p>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="contentBlock defaultScroll">
                <div class="contentBlock__map">
                    <div class="contentBlock__map-header">
                        <div class="contentBlock__map-search">
                            <div class="contentBlock__map-search-title">
                                <img src="/img/digital-drilling/icon-map.png" alt="">
                                <div class="title">{{trans("digital_drilling.default.drilling_rigs")}}</div>
                            </div>
                           <div class="contentBlock__filter">
                               <div class="all-graph" @click="allGraphModal=true">
                                   <img src="/img/digital-drilling/all-graph.svg" alt="">
                                   <span>{{ trans('digital_drilling.default.GENERAL_DRILLING_SCHEDULE') }}</span>
                               </div>
                               <div class="contentBlock__map-search-block">
                                   <button class="filter-btn" @click="resetFilter">
                                       <img src="/img/digital-drilling/reset-filter.svg" alt="">
                                       Сбросить фильтрацию
                                   </button>
                                   <button class="filter-btn" @click="filter=!filter">Подбор БУ</button>
                                   <button class="full"><img src="/img/digital-drilling/button2.svg" alt=""></button>
                               </div>
                           </div>
                        </div>
                    </div>
                    <div class="rigs__content defaultScroll">
                        <table class="table defaultTable">
                            <tbody>
                                <tr>
                                    <th>{{trans("digital_drilling.default.company_name")}}</th>
                                    <th>{{trans("digital_drilling.default.drilling_rig_name")}}</th>
                                    <th>{{trans("digital_drilling.default.companyman")}}</th>
                                    <th>{{trans("digital_drilling.default.load_capacity_kN")}}</th>
                                    <th>{{trans("digital_drilling.default.nominal_drilling_depth")}}</th>
                                    <th>
                                        {{trans("digital_drilling.default.rig_up_duration")}}<br>
                                        сут.
                                    </th>
                                    <th>
                                        {{trans("digital_drilling.default.rig_duration")}}<br>
                                        сут.
                                    </th>
                                    <th>Технические характеристики</th>
                                    <th>{{trans("digital_drilling.default.schedule_planning")}}</th>
                                    <th>{{trans("digital_drilling.default.rig_movement_scheme")}}</th>
                                </tr>
                                <tr v-for="rig in rigs">
                                    <td class="w-250">{{rig.company}}</td>
                                    <td class="w-150">
                                        <div class="text-center mb-2">{{rig.name_ru}}</div>
                                    </td>

                                    <td>{{rig.superintendent}}</td>
                                    <td>{{rig.load_capacity}}</td>
                                    <td>{{rig.nominal_drilling_depth}}</td>
                                    <td>{{rig.installation_time}}</td>
                                    <td>{{rig.dismantling_time}}</td>
                                    <td class="w-150">
                                        <div class="text-center mb-2">
                                        </div>
                                        <button class="characteristic" @click="openCharacteristicModal(rig.id)">
                                            {{trans("digital_drilling.default.technical_description")}}
                                        </button>
                                    </td>
                                    <td class="w-150">
                                        <div class="text-center mb-2">
                                        </div>
                                        <button class="characteristic" @click="openCharacteristicGraphModal">
                                            {{trans("digital_drilling.default.schedule")}}
                                            <img src="/img/digital-drilling/install-graph.svg" alt="">
                                        </button>
                                    </td>
                                    <td class="w-150">
                                        <div class="text-center mb-2">
                                        </div>
                                        <button class="characteristic" @click="openCharacteristicSchemeModal">
                                            {{trans("digital_drilling.default.scheme")}}
                                            <img src="/img/digital-drilling/install-cheme.svg" alt="">
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="characteristic__modal" v-if="characteristicModal">
            <div class="characteristic_content">
                <div class="characteristic_header">
                    <div class="header-btn">
                        <div class="btn-tech" @click="sensor=false" :class="{active: !sensor}">{{trans("digital_drilling.default.technical_description")}}</div>
                        <div class="btn-tech" @click="sensor=true" :class="{active: sensor}">{{trans("digital_drilling.default.sensor")}}</div>
                    </div>
                    <div class="characteristic_header-close" @click="closeCharacteristicModal">
                        {{trans("digital_drilling.default.close")}}
                    </div>
                </div>
                <div class="characteristic_content-inner">
                    <div class="characteristic_body">
                        <div v-if="!sensor">
                            <table class="table defaultTable modalTable">
                                <tbody>
                                <tr>
                                    <th>{{trans("digital_drilling.default.r_name")}}</th>
                                    <th>{{trans("digital_drilling.default.r_value")}}</th>
                                </tr>
                                <tr v-for="info in technicalDescription.general">
                                    <td>{{info.parameter}}</td>
                                    <td>{{info.value}}</td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="table defaultTable modalTable">
                                <tbody>
                                <tr>
                                    <th>{{trans("digital_drilling.default.parameters")}}</th>
                                    <th>{{trans("digital_drilling.default.measurement_unit")}}</th>
                                    <th class="w-150">{{trans("digital_drilling.default.r_value")}}</th>
                                </tr>
                                <tr v-for="tech in technicalDescription.tech_parameter">
                                    <td>{{tech.parameter}}</td>
                                    <td>{{tech.unit}}</td>
                                    <td>{{tech.value}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else>
                            <table class="table defaultTable modalTable">
                                <tbody>
                                <tr>
                                    <th>{{trans("digital_drilling.default.r_name")}}</th>
                                    <th>{{trans("digital_drilling.default.status")}}</th>
                                </tr>
                                <tr v-for="info in technicalDescription.sensor">
                                    <td>{{info.parameter}}</td>
                                    <td class="text-center fs-16">
                                        <span v-if="info.value">+</span>
                                        <span v-else>-</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="modalTable-title">
                                Измеряемые параметры во время бурения
                            </div>
                            <table class="table defaultTable modalTable">
                                <tbody>
                                <tr>
                                    <th>{{trans("digital_drilling.default.r_name")}}</th>
                                    <th>{{trans("digital_drilling.default.status")}}</th>
                                </tr>
                                <tr v-for="info in technicalDescription.measuring_parameter">
                                    <td>{{info.parameter}}</td>
                                    <td class="text-center fs-16">
                                        <span v-if="info.value">+</span>
                                        <span v-else>-</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="modalTable-title">
                                Наличие ГТИ или ДЭЛ
                            </div>
                            <table class="table defaultTable modalTable">
                                <tbody>
                                <tr>
                                    <th>{{trans("digital_drilling.default.r_name")}}</th>
                                    <th>{{trans("digital_drilling.default.status")}}</th>
                                </tr>
                                <tr v-for="info in technicalDescription.equipment">
                                    <td>{{info.parameter}}</td>
                                    <td class="text-center fs-16">
                                        <span v-if="info.value">+</span>
                                        <span v-else>-</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="characteristic__modal graph" v-if="characteristicGraph">
            <div class="characteristic_content">
                <div class="characteristic_header">
                    <span>{{trans("digital_drilling.default.drilling_rig_moving_schedule")}} ZJ-40 (ТОО СПБ “КазМунайГаз-Бурение)</span>
                    <div class="characteristic_header-close" @click="openCharacteristicGraphModal">
                        {{trans("digital_drilling.default.close")}}
                    </div>
                </div>
                <div class="characteristic_body defaultScroll">
                    <img src="/img/digital-drilling/scheme.png" alt="">
                </div>
                <button class="btn__ok" @click="openCharacteristicGraphModal">
                    Ok
                </button>
            </div>
        </div>
        <div class="characteristic__modal scheme" v-if="characteristicScheme">
            <div class="characteristic_content">
                <div class="characteristic_header">
                    <span>{{trans("digital_drilling.default.drilling_rig_moving_scheme")}} ZJ-40 (ТОО СПБ “КазМунайГаз-Бурение)</span>
                    <div class="characteristic_header-close" @click="openCharacteristicSchemeModal">
                        {{trans("digital_drilling.default.close")}}
                    </div>
                </div>
                <div class="characteristic_body ScrollRig">
                    <div class="map__content">
                        <MglMap
                                container="map-test"
                                :center.sync="center"
                                :accessToken="accessToken"
                                :mapStyle="mapStyle"
                                :zoom="zoom"
                                class="mglMap"
                        >
                            <MglMarker
                                    :coordinates.sync="center"
                                    color='green'
                            />
                        </MglMap>
                    </div>
                    <button class="btn__ok" @click="openCharacteristicSchemeModal">
                        Ok
                    </button>
                </div>
            </div>
        </div>
        <div class="all-graph-modal" v-if="allGraphModal">
            <img src="/img/digital-drilling/all-graph.png" alt="" @click="allGraphModal = false">
        </div>
        <div class="newWell" v-if="filter">
            <div class="well_content">
                <div class="well_body">
                    <div class="well_body-header">
                        <div class="well_body-header-title">
                            Фильтр по поиску буровой установки
                        </div>
                        <div class="well_body-header-close" @click="filter=false">
                            {{ trans('digital_drilling.default.close') }}
                        </div>
                    </div>
                    <div class="well_body-content">
                        <div class="well_body-inner">
                            <div class="well_body-form">
                                <div class="well_body-form-input">
                                    <label for="DZO">Компания:</label>
                                    <input type="text" class="select" v-model="form.company">
                                </div>
                                <div class="well_body-form-input">
                                    <label for="field">Грузоподъёмность:</label>
                                    <div class="range">
                                        <div class="from">
                                            <label for="">От</label>
                                            <input type="number" v-model="form.carrying_capacity.from">
                                        </div>
                                        <div class="to">
                                            <label for="">до</label>
                                            <input type="number" v-model="form.carrying_capacity.to">
                                        </div>
                                    </div>
                                </div>
                                <div class="well_body-form-input">
                                    <label for="field">Номинальная глубина бурения::</label>
                                       <div class="range">
                                           <div class="from">
                                               <label for="">От</label>
                                               <input type="number" v-model="form.nominal_drilling.from">
                                           </div>
                                           <div class="to">
                                               <label for="">до</label>
                                               <input type="number" v-model="form.nominal_drilling.to">
                                           </div>
                                       </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="well-create" @click="filterRig">
                        Применить
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        MglMap,
        MglMarker,
        MglGeojsonLayer
    } from 'vue-mapbox'

    export default {
        name: "DrillingRigs",
        components:{ MglMap, MglMarker, MglGeojsonLayer},
        data(){
            return{
                allGraphModal: false,
                accessToken: process.env.MIX_MAPBOX_TOKEN,
                mapStyle: 'mapbox://styles/mapbox/satellite-v9?optimize=true',
                center: [52.1108, 43.68999],
                zoom: 9,
                characteristicModal: false,
                sensor: false,
                characteristicGraph: false,
                characteristicScheme: false,
                filter: false,
                rigs: [],
                technicalDescription: {},
                operatingCosts: [
                    {
                        year: '2016 г.',
                        item: 8228564
                    },
                    {
                        year: '2017 г.',
                        item: 8785866
                    },
                    {
                        year: '2018 г.',
                        item: 7947803
                    },
                    {
                        year: '2019 г.',
                        item: 14397692
                    },
                    {
                        year: '2020 г.',
                        item: 15093826
                    },
                    {
                        year: '2021 г.',
                        item: 10325881
                    },
                ],
                form:{
                    company: '',
                    carrying_capacity: {
                        from: 0,
                        to: ''
                    },
                    nominal_drilling: {
                        from: 0,
                        to: ''
                    }
                }
            }
        },
        mounted(){
            this.getRigs('')
        },
        methods:{
            resetFilter(){
                this.form = {
                    company: '',
                    carrying_capacity: {
                        from: 0,
                        to: ''
                    },
                    nominal_drilling: {
                        from: 0,
                        to: ''
                    }
                }
                this.getRigs('')
            },
            async filterRig(){
                let query = 'company=' + this.form.company
                if (this.form.carrying_capacity.to) {
                    query = query + '&load_capacity=' + this.form.carrying_capacity.from + ',' +this.form.carrying_capacity.to
                }else{
                    query = query + '&load_capacity=' + this.form.carrying_capacity.from
                }
                if (this.form.nominal_drilling.to) {
                    query = query + '&nominal_drilling_depth=' + this.form.nominal_drilling.from + ',' +this.form.nominal_drilling.to
                }else{
                    query = query + '&nominal_drilling_depth=' + this.form.nominal_drilling.from
                }
                this.getRigs(query)
                this.filter = false
            },
            async getRigs(query){
                await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/rigs?'+query).then((response) => {
                    let data = response.data;
                    if (data) {
                        this.rigs = data;
                    } else {
                        console.log('No data');
                    }
                }).catch((er)=>{
                    console.log(er)
                });
            },
            async getRigsCharacteristics(id){
                await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/daily_report/search/rig/'+id).then((response) => {
                    let data = response.data;
                    if (data) {
                        this.technicalDescription = data;
                    } else {
                        console.log('No data');
                    }
                }).catch((er)=>{
                    console.log(er)
                });
            },
            closeCharacteristicModal(){
                this.characteristicModal = false
            },
            openCharacteristicModal(id){
                this.getRigsCharacteristics(id)
                document.body.overflow = 'hidden'
                this.characteristicModal = true
            },
            openCharacteristicGraphModal(){
                if (this.characteristicGraph){
                    this.characteristicGraph = false
                } else{
                    document.body.overflow = 'hidden'
                    this.characteristicGraph = true
                }
            },
            openCharacteristicSchemeModal(){
                if (this.characteristicScheme){
                    this.characteristicScheme = false
                } else{
                    document.body.overflow = 'hidden'
                    this.characteristicScheme = true
                }
            },
        }
    }
</script>

<style scoped>
    .modalTable-title{
        font-size: 16px;
        font-weight: bold;
        margin: 15px 0 0;
    }
    .well_content{
        min-height: 300px;
    }
    .w-150{
        width: 180px!important;
    }
    .w-250{
        width: 220px!important;
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
        max-width: 700px;
        margin: 60px auto;
        height: 80vh;
        background: #272953;
        box-shadow: 0px 7px 7px rgba(0, 0, 0, 0.25);
        border-radius: 10px;
        padding: 15px;
        border: 1px solid #656A8A;
    }
    .characteristic__modal.graph,
    .characteristic__modal.scheme{
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .characteristic__modal.graph .characteristic_content,
    .characteristic__modal.scheme .characteristic_content{
        max-width: 90%;
        width: 90%;
        height: auto;
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

    .ml-10{
        padding: 0 0 0 18px!important;
    }
    .rigs__content{
        background-color: #272953;
        width: 100%;
        height: calc(100% - 50px);
        padding: 0 4px 0;
        position: relative;
        overflow-x: hidden;
        overflow-y: scroll;

    }
    .modalTable td{
        padding: 15px!important;
    }
    .characteristic__modal td{
        padding: 10px 5px!important;
    }
    .characteristic{
        background: #205AA3;
        border: 0.5px solid #454FA1;
        box-shadow: 0px 4px 3px rgba(0, 0, 0, 0.25);
        border-radius: 10px;
        padding: 5px;
        display: flex;
        align-items: center;
        margin: 0 auto;
    }
    .characteristic img{
        margin-left: 5px;
    }
    .characteristic__modal.scheme .characteristic_body{
        height: calc(100vh - 200px);
    }
    .map__content{
        height: calc(100% - 80px);
    }
    .btn__ok{
        border: 0;
        background: #464A8A;
        border-radius: 6px;
        width: 170px;
        height: 26px;
        font-weight: 600;
        font-size: 12px;
        line-height: 14px;

        color: #FFFFFF;
        margin: 25px auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .contentBlock{
        height: calc(100% - 130px);
    }
    button{
        color: #FFFFFF;
    }
</style>