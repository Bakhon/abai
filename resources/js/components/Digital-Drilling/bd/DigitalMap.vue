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
                    <button class="full" @click="cardFullPage"><img src="/img/digital-drilling/button2.svg" alt=""></button>
                </div>
            </div>
        </div>
        <div class="map__content">
            <div id="distance" class="distance-container"></div>
            <div class="map-filter">
                <dropdown title="ДЗО" :options="dzo" class="dropdown__area" @updateList="getField"/>
                <dropdown title="Месторождение" :options="fields" class="dropdown__area"
                          :search="false"
                          @search="filterField"
                          @updateList="updateField"
                />
                <dropdown title="Статус" :options="wellStatus" class="dropdown__area" @updateList="filterMap"/>
                <div class="dropdown__area" v-if="geojson.features.length>0">
                    <button @click="clearDistance" class="clear">Clear</button>
                </div>
            </div>
            <MglMap
                    :accessToken="accessToken"
                    :mapStyle="mapStyle"
                    :center="center"
                    :zoom="zoom"
                    @load="loadMap"
                    @click="mapClick"
            >

                <MglMarker
                        v-for="(coordinate, i)  in coordinates"
                        :coordinates="[coordinate.X, coordinate.Y]"
                        :key="i"
                >
                    <div slot="marker">
                       <div class="marker">
                           <img src="/img/digital-drilling/drilling-map-icon.svg" alt="" v-if="coordinate.Status == 'В бурении'">
                           <img src="/img/digital-drilling/drilling-well-icon.svg" alt="" v-else>
                           <div class="field-name">{{coordinate.field}}</div>
                       </div>
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
    import * as turf from '@turf/turf'
    import {
        MglMap,
        MglMarker,
        MglPopup
    } from 'vue-mapbox'
    export default {
        name: "DigitalMap",
        components:{ MglMap, MglMarker, MglPopup, Dropdown},
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
                ],
                map: null,
                geojson: {
                    'type': 'FeatureCollection',
                    'features': []
                },
                linestring: {
                    'type': 'Feature',
                    'geometry': {
                        'type': 'LineString',
                        'coordinates': []
                    }
                },
            }
        },
        mounted(){
            this.getDZO()
        },
        methods:{
            loadMap(event){
                let map = event.map
                map.addSource('geojson', {
                    'type': 'geojson',
                    'data': this.geojson
                });
                map.addLayer({
                    id: 'measure-points',
                    type: 'circle',
                    source: 'geojson',
                    paint: {
                        'circle-radius': 5,
                        'circle-color': '#000'
                    },
                    filter: ['in', '$type', 'Point']
                });
                map.addLayer({
                    id: 'measure-lines',
                    type: 'line',
                    source: 'geojson',
                    layout: {
                        'line-cap': 'round',
                        'line-join': 'round'
                    },
                    paint: {
                        'line-color': '#000',
                        'line-width': 2.5
                    },
                    filter: ['in', '$type', 'LineString']
                });

                this.map = map
            },
            mapClick(e){
                this.distanceContainer = document.getElementById('distance')
                let map = e.map
                const features = map.queryRenderedFeatures(e.mapboxEvent.point, {
                    layers: ['measure-points']
                });
                if (this.geojson.features.length > 1) this.geojson.features.pop();
                this.distanceContainer.innerHTML = '';
                if (features.length) {
                    const id = features[0].properties.id;
                    this.geojson.features = this.geojson.features.filter(
                        (point) => point.properties.id !== id
                    );
                } else {
                    const point = {
                        'type': 'Feature',
                        'geometry': {
                            'type': 'Point',
                            'coordinates': [e.mapboxEvent.lngLat.lng, e.mapboxEvent.lngLat.lat]
                        },
                        'properties': {
                            'id': String(new Date().getTime())
                        }
                    };

                    this.geojson.features.push(point);
                }
                if (this.geojson.features.length > 1) {
                    this.linestring.geometry.coordinates = this.geojson.features.map(
                        (point) => point.geometry.coordinates
                    );

                    this.geojson.features.push(this.linestring);
                    const value = document.createElement('pre');
                    value.style.color = '#FFFFFF'
                    value.style.fontWeight = 'bold'
                    value.style.paddingLeft = '10px'
                    value.style.paddingRight = '10px'
                    const distance = turf.length(this.linestring);
                    value.textContent = `Общее расстояние: ${distance.toLocaleString()}km`;
                    this.distanceContainer.appendChild(value);
                }

                map.getSource('geojson').setData(this.geojson);
            },
            clearDistance(){
                this.distanceContainer = document.getElementById('distance')
                this.distanceContainer.removeChild(this.distanceContainer.firstChild);
                this.geojson - null
                this.linestring = null
                this.geojson = {
                    'type': 'FeatureCollection',
                        'features': []
                },
                this.linestring = {
                    'type': 'Feature',
                    'geometry': {
                    'type': 'LineString',
                        'coordinates': []
                    }
                }
                this.map.getSource('geojson').setData(this.geojson);

            },
            mousemoveMap(event){
                let map = event.map
                const features = map.queryRenderedFeatures(e.point, {
                    layers: ['measure-points']
                });
                map.getCanvas().style.cursor = features.length
                    ? 'pointer'
                    : 'crosshair';
            },
            cardFullPage(){
                this.$emit('cardFullPage')
            },
             async getCoordinates(){
                    this.SET_LOADING(true);
                    try{
                        await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/map/' + this.currentField.id + "/" + this.query).then((response) => {
                            let data = response.data;
                            if (data) {
                                this.coordinates = data;
                                this.center = [this.coordinates[0].X, this.coordinates[0].Y]
                                this.zoom = 13
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
    .marker{
       position: relative;
        cursor: pointer;
        z-index: 10;
    }
    .marker:hover{
        z-index: 2000;
    }
    .field-name{
        display: block;
        z-index: 2000;

    }
    .field-name{
        position: absolute;
        top: 0;
        left: 110%;
        background: #1F2142;
        border: 0.5px solid #454FA1;
        color: #ffffff;
        padding: 5px;
        display: none;
    }
    .mapboxgl-marker:hover .field-name{
        display: block;
        z-index: 2000;

    }
    .mapboxgl-marker:hover{
        z-index: 2000;
    }
    .distance-container{
        position: absolute;
        top: 0;
        left: 40%;
        color: #ffffff;
        z-index: 5000000;
        background-color: #0c2e5a;
    }
</style>