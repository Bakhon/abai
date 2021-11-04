<template>
    <div class="contentBlock__map">
        <div class="contentBlock__map-header">
            <div class="contentBlock__map-search">
                <div class="contentBlock__map-search-title">
                    <img src="/img/digital-drilling/icon-map.png" alt="">
                    <div class="title">{{trans('digital_drilling.window_head.DZO')}}, {{trans('digital_drilling.window_head.field')}}</div>
                </div>
                <div class="contentBlock__map-search-block">
                    <div class="contentBlock__map-search-input">
                        <img src="/img/digital-drilling/search.png" alt="">
                        <input type="text" :placeholder="trans('digital_drilling.window_head.search')">
                        <button>{{trans('digital_drilling.window_head.search')}}</button>
                    </div>
                    <button class="full"><img src="/img/digital-drilling/button2.svg" alt=""></button>
                </div>
            </div>
        </div>
        <div class="map__content">
            <div class="map-filter">
                <dropdown title="ДЗО" :options="dzo" class="dropdown__area" @updateList="getField"/>
                <dropdown title="Месторождение" :options="fields" class="dropdown__area"
                          :search="false"
                          @search="filterField"
                          @updateList="updateField"
                />
                <dropdown title="Статус" :options="wellStatus" class="dropdown__area" @updateList="filterMap"/>
            </div>
            <MglMap
                    :accessToken="accessToken"
                    :mapStyle="mapStyle"
                    :center="center"
                    :zoom="zoom"
            >
                <MglMarker
                        v-for="(coordinate, i)  in coordinates"
                        :coordinates="[coordinate.X, coordinate.Y]"
                        :key="i"
                >
                    <div slot="marker">
                        <img src="/img/digital-drilling/drilling-map-icon.svg" alt="" v-if="coordinate.Status == 'В бурении'">
                        <img src="/img/digital-drilling/drilling-well-icon.svg" alt="" v-else>
                    </div>
                </MglMarker>
            </MglMap>
        </div>
        <div class="contentBlock__map-bottom">
            <div class="contentBlock__map-bottom-content">
                <img src="/img/digital-drilling/exploration.png" alt="">
                <img src="/img/digital-drilling/production.png" alt="">
                <div class="name">{{trans('digital_drilling.home.exploration_production')}}</div>
            </div>
        </div>
    </div>
</template>

<script>
    import {globalloadingMutations} from '@store/helpers';
    import Dropdown from '../components/dropdownMapFilter'

    import {
        MglMap,
        MglMarker
    } from 'vue-mapbox'
    export default {
        name: "DigitalMap",
        components:{ MglMap, MglMarker, Dropdown},
        data() {
            return {
                accessToken: process.env.MIX_MAPBOX_TOKEN,
                mapStyle: 'mapbox://styles/mapbox/satellite-v9?optimize=true',
                center: [46.5861065487464, 54.1278133495231],
                zoom: 11,
                coordinates: [],
                dzo: [],
                fields: [],
                query: '',
                currentDZO: null,
                currentField: null,
                currentStatus: 'drilling',
                wellStatus:[
                    {
                        id: "",
                        name: 'Все скважины'
                    },
                    {
                        id: "drilling",
                        name: 'В бурении'
                    },
                    {
                        id: "not_drilling",
                        name: 'Пробуренные'
                    }
                ]
            }
        },
        mounted(){
            this.getDZO()
        },
        methods:{
             async getCoordinates(){
                    this.SET_LOADING(true);
                    try{
                        await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/map/' + this.currentField.id + "/" + this.query).then((response) => {
                            let data = response.data;
                            if (data) {
                                this.coordinates = data;
                                console.log(this.center)
                                this.center = [this.coordinates[0].X, this.coordinates[0].Y]
                                console.log(this.center)
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
            updateField(item){
                this.currentField = item
                this.getCoordinates()
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
                        this.filterMap('')
                    } else {
                        console.log('No data');
                    }
                });

            },
            filterMap(item){
                 this.query = ''
                 if (item != ''){
                     this.query = '?status=' + item.id
                 }
                this.getCoordinates()
            },
            ...globalloadingMutations([
                'SET_LOADING'
            ]),
        }
    }
</script>

<style scoped>

</style>