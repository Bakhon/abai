<template>
    <div class="contentBlock__map">
        <div class="contentBlock__map-header">
            <div class="contentBlock__map-search">
                <div class="contentBlock__map-search-title">
                    <img src="/img/digital-drilling/icon-map.png" alt="">
                    <div class="title">ДЗО, месторождение</div>
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
                        <img src="/img/digital-drilling/menu3.svg" alt="">
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
    </div>
</template>

<script>
    import {globalloadingMutations} from '@store/helpers';

    import {
        MglMap,
        MglMarker
    } from 'vue-mapbox'
    export default {
        name: "DigitalMap",
        components:{ MglMap, MglMarker},
        data() {
            return {
                accessToken: process.env.MIX_MAPBOX_TOKEN,
                mapStyle: 'mapbox://styles/mapbox/satellite-v9?optimize=true',
                center: [54.0, 47.0],
                zoom: 5,
                coordinates: []
            }
        },
        mounted(){
            this.getCoordinates()
        },
        methods:{
             async getCoordinates(){
                    this.SET_LOADING(true);
                    try{
                        await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/map/').then((response) => {
                            let data = response.data;
                            if (data) {
                                this.coordinates = data.slice(0, 20);
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
            ...globalloadingMutations([
                'SET_LOADING'
            ]),
        }
    }
</script>

<style scoped>

</style>