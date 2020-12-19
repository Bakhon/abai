<template>
    <div class="gu-map">
        <div v-if="gus">
            <v-select
                v-model="gu"
                @input="initMap"
                :options="gus"
                :reduce="option => option.id"
                label="name"
                placeholder="Выберите ГУ"
                style="margin: 0 0 20px; width: 300px"
            >
            </v-select>
        </div>
        <div v-if="zuPipes.length > 0 || wellPipes.length > 0" class="gu-map__map" style="height: 500px">
            <link
                href="https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css"
                rel="stylesheet"
            />
            <MglMap :accessToken="accessToken" :mapStyle="mapStyle" :center="center" :zoom="13">
                <MglGeojsonLayer
                    v-for="(pipe, index) in zuPipes"
                    :key="`zu_pipe_${index}`"
                    :sourceId="`zu_pipe_${pipe.id}`"
                    :source="getJsonSource(pipe.coordinates)"
                    :layerId="`zu_pipe_${pipe.id}`"
                    :layer="getZuJsonLayer(pipe)"
                />
                <MglGeojsonLayer
                    v-for="(pipe, index) in wellPipes"
                    :key="`well_pipe_${index}`"
                    :sourceId="`well_pipe_${pipe.id}`"
                    :source="getJsonSource(pipe.coordinates)"
                    :layerId="`well_pipe_${pipe.id}`"
                    :layer="getWellJsonLayer(pipe)"
                />
                <MglMarker
                    v-for="(zuPoint, index) in zuPoints"
                    :key="`zu_point_${index}`"
                    :coordinates="zuPoint.coords"
                    color="blue">
                    <div slot="marker" style="width: 20px; height: 20px; background: url(/img/icons/zu.svg) no-repeat; background-size: contain"></div>
                </MglMarker>
                <MglMarker
                    v-for="(wellPoint, index) in wellPoints"
                    :key="`well_point_${index}`"
                    :coordinates="wellPoint.coords"
                    color="green">
                    <div slot="marker" style="width: 25px; height: 25px; background: url(/img/icons/well.svg) no-repeat; background-size: contain"></div>
                </MglMarker>
                <MglMarker
                    v-if="guPoint"
                    :coordinates="guPoint.coords"
                    color="green">
                    <div slot="marker" style="width: 30px; height: 30px; background: url(/img/icons/zu.svg) no-repeat; background-size: contain"></div>
                </MglMarker>
            </MglMap>
        </div>
    </div>
</template>

<script>
import Mapbox from "mapbox-gl";
import {MglMap, MglGeojsonLayer, MglMarker, MglPopup} from "vue-mapbox";
import vSelect from "vue-select";

export default {
    name: "gu-map",
    components: {
        MglMap,
        MglGeojsonLayer,
        MglMarker,
        MglPopup,
        vSelect
    },
    props: [
        'gus'
    ],
    data() {
        return {
            gu: null,
            zuPipes: [],
            wellPipes: [],
            zuPoints: [],
            wellPoints: [],
            guPoint: null,
            center: [],
            accessToken: 'pk.eyJ1IjoibWFja2V5c2kiLCJhIjoiY2sxZ2JwdzF1MDk4eDNubDhraHNxNTluaCJ9.5VnpUHKLM0rdx1pYjpNYPw', // your access token. Needed if you using Mapbox maps
            mapStyle: 'mapbox://styles/mapbox/streets-v11'
        };
    },
    created() {
        // We need to set mapbox-gl library here in order to use it in template
        this.mapbox = Mapbox;
    },
    methods: {
        initMap() {
            this.zuPipes = []
            this.wellPipes = []
            this.zuPoints = []
            this.wellPoints = []
            this.guPoint = null
            this.axios.get("/ru/gu-map/pipes", {params: {gu: this.gu}}).then((response) => {
                this.zuPipes = response.data.zuPipes
                this.wellPipes = response.data.wellPipes
                this.zuPoints = response.data.zuPoints
                this.wellPoints = response.data.wellPoints
                this.guPoint = response.data.guPoint
                this.center = response.data.center
            });
        },
        getZuJsonLayer(pipe) {
            return {
                'id': 'zu_pipe_' + pipe.id,
                'type': 'line',
                'source': 'zu_pipe_' + pipe.id,
                'layout': {
                    'line-join': 'round',
                    'line-cap': 'round'
                },
                'paint': {
                    'line-color': '#ff0000',
                    'line-width': 1
                }
            }
        },
        getWellJsonLayer(pipe) {
            return {
                'id': 'well_pipe_' + pipe.id,
                'type': 'line',
                'source': 'well_pipe_' + pipe.id,
                'layout': {
                    'line-join': 'round',
                    'line-cap': 'round'
                },
                'paint': {
                    'line-color': '#00ff00',
                    'line-width': 1
                }
            }
        },
        getJsonSource(coords) {
            return {
                'type': 'geojson',
                'data': {
                    'type': 'Feature',
                    'properties': {},
                    'geometry': {
                        'type': 'LineString',
                        'coordinates': coords
                    }
                }
            };
        }
    }
}
</script>
<style>
    h1{
        color: #fff;
    }
</style>
