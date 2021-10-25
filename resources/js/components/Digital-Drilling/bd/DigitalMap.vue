<template>
    <div class="contentBlock__map">
        <div class="contentBlock__map-header">
            <div class="contentBlock__map-search">
                <div class="contentBlock__map-search-title">
                    <img src="/img/digital-drilling/icon-map.png" alt="">
                    <div class="title">ДЗО, месторождение</div>
                </div>
                <div class="all-graph" @click="allGraphModal=true">
                    <img src="/img/digital-drilling/all-graph.svg" alt="">
                    <span>ОБЩИЙ ГРАФИК БУРЕНИЯ</span>
                </div>
                <div class="contentBlock__map-search-block">
                    <div class="contentBlock__map-search-input">
                        <img src="/img/digital-drilling/search.png" alt="">
                        <input type="text" placeholder="Поиск">
                        <button>Поиск</button>
                    </div>
                    <button class="full"><img src="/img/digital-drilling/button2.svg" alt=""></button>
                </div>
            </div>
        </div>
        <div class="map__content">
            <div class="map-filter">
                <dropdown title="ДЗО" :options="dzo" class="dropdown__area" @updateList="getField"/>
                <dropdown title="Месторождение" :options="fields" class="dropdown__area"
                          :search="true"
                          @search="filterField"
                          @updateList="updateField"
                />
            </div>
            <MglMap
                    :accessToken="accessToken"
                    :mapStyle="mapStyle"
                    :center="center"
                    :zoom="zoom"
            >
                <MglMarker
                        v-for="(coordinate, i)  in coordinates"
                        :coordinates="[coordinate.Y, coordinate.X]"
                        :key="i"
                >
                    <div slot="marker">
                        <img src="/img/digital-drilling/drilling-map-icon.svg" alt="">
                    </div>
                </MglMarker>
            </MglMap>
        </div>
        <div class="contentBlock__map-bottom">
            <div class="contentBlock__map-bottom-content">
                <img src="/img/digital-drilling/exploration.png" alt="">
                <img src="/img/digital-drilling/production.png" alt="">
                <div class="name">Разведка и Добыча</div>
            </div>
        </div>
        <div class="all-graph-modal" v-if="allGraphModal">
            <img src="/img/digital-drilling/all-graph.png" alt="" @click="allGraphModal = false">
        </div>
    </div>
</template>

<script>
    import {globalloadingMutations} from '@store/helpers';
    import Dropdown from '../components/dropdown'

    import {
        MglMap,
        MglMarker
    } from 'vue-mapbox'
    export default {
        name: "DigitalMap",
        components:{ MglMap, MglMarker, Dropdown},
        data() {
            return {
                allGraphModal: false,
                accessToken: process.env.MIX_MAPBOX_TOKEN,
                mapStyle: 'mapbox://styles/mapbox/satellite-v9?optimize=true',
                center: [54.1278133495231, 46.5861065487464],
                zoom: 11,
                coordinates: [],
                dzo: [],
                fields: [],
                currentDZO: null,
                currentField: null,
            }
        },
        mounted(){
            this.getDZO()
        },
        methods:{
             async getCoordinates(){
                    this.SET_LOADING(true);
                    try{
                        await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/map/' + this.currentField.id + "/").then((response) => {
                            let data = response.data;
                            if (data) {
                                this.coordinates = data;
                                this.center = [this.coordinates[0].Y, this.coordinates[0].X]
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
                        this.getCoordinates()
                    } else {
                        console.log('No data');
                    }
                });

            },
            ...globalloadingMutations([
                'SET_LOADING'
            ]),
        }
    }
</script>

<style scoped>

</style>