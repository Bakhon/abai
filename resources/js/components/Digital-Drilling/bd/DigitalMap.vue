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
    import {
        MglMap,
        MglMarker,
        MglGeojsonLayer
    } from 'vue-mapbox'
    export default {
        name: "DigitalMap",
        components:{ MglMap, MglMarker, MglGeojsonLayer},
        data() {
            return {
                accessToken: process.env.MIX_MAPBOX_TOKEN,
                mapStyle: 'mapbox://styles/mapbox/satellite-v9?optimize=true',
                center: [52.1108, 43.68999],
                zoom: 9,
            }
        }
    }
</script>

<style scoped>

</style>