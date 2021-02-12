<template>
  <div class="gu-map">
    <div class="gu-map__controls">
      <h1>{{ trans('monitoring.map.title') }}</h1>
      <div v-if="gus">
        <v-select
            v-model="gu"
            @input="centerToGu"
            :options="gus"
            :reduce="option => option.id"
            label="name"
            :placeholder="trans('monitoring.map.select_gu')"
        >
        </v-select>
        <b-button @click="openGuModal">+ ГУ</b-button>
      </div>
    </div>
    <div id="map"></div>
    <canvas id="deck-canvas"></canvas>

    <b-modal id="gu-modal" title="Новый Гу">
      <b-form-group
            label="Имя ГУ"
            label-for="gu-name"
        >
          <b-form-input
              id="gu-name"
              v-model="formGu.name"
              required
          ></b-form-input>
        </b-form-group>

        <b-form-group label="Координаты X" label-for="coord-x">
          <b-form-input
              id="coord-x"
              v-model="formGu.x"
              required
          ></b-form-input>
        </b-form-group>

        <b-form-group label="Координаты y" label-for="coord-y">
          <b-form-input
              id="coord-x"
              v-model="formGu.y"
              required
          ></b-form-input>
        </b-form-group>
    </b-modal>
  </div>
</template>

<script>
import mapboxgl from "mapbox-gl";
import {Deck} from '@deck.gl/core';
import {PathLayer, IconLayer} from '@deck.gl/layers';
import vSelect from "vue-select";

export default {
  name: "gu-map",
  components: {
    vSelect
  },
  props: [
    'gus'
  ],
  data() {
    return {
      formGu: {
        name: '',
        x: '',
        y: '',
      },
      gu: null,
      pipes: [],
      zuPoints: [],
      wellPoints: [],
      guPoints: [],
      centers: [],
      accessToken: 'pk.eyJ1IjoibWFja2V5c2kiLCJhIjoiY2sxZ2JwdzF1MDk4eDNubDhraHNxNTluaCJ9.5VnpUHKLM0rdx1pYjpNYPw', // your access token. Needed if you using Mapbox maps
      mapStyle: 'mapbox://styles/mapbox/satellite-v9?optimize=true',
      pipePopupText: null,
      pipePopupCoords: [0, 0],
      pipePopupShow: false,
      guPoint: null,
      map: null,
      deck: null,
      viewState: {
        latitude: null,
        longitude: null,
        zoom: null,
        bearing: null,
        pitch: null
      },
      firstCentered: false
    };
  },
  created() {
    this.initMap()
  },
  methods: {
    colorToRGBArray(color) {
      if (!color) {
        return [255, 255, 255, 0];
      }
      if (Array.isArray(color)) {
        return color.slice(0, 4);
      }
      const c = rgb(color);
      return [c.r, c.g, c.b, 255];
    },
    onLoadMap(params) {
      this.mapObj = params.map

    },
    openGuModal (gu = null) {
      if (gu) {
        this.formGu = gu;
      } else {
        this.formGu = {
          name: '',
          x: '',
          y: '',
        }
      }
      this.$bvModal.show('gu-modal');
    },
    centerToGu() {
      let center = this.guPoints.find((point) => {
        return point.id === this.gu
      }).coords

      this.deck.setProps({
        initialViewState: {
          longitude: parseFloat(center[0]),
          latitude: parseFloat(center[1]),
          zoom: 15,
          bearing: 0,
          pitch: 30
        }
      })

      //added to fix a bug with deck.gl on first click to gu select
      if (!this.firstCentered) {
        this.deck.setProps({
          initialViewState: {
            longitude: parseFloat(center[0]),
            latitude: parseFloat(center[1]),
            zoom: 15,
            bearing: 0,
            pitch: 30
          }
        })
        this.firstCentered = true
      }

      this.map.jumpTo({
        center: [parseFloat(center[0]), parseFloat(center[1])],
        zoom: 15,
        bearing: 0,
        pitch: 30
      });
    },
    initMap() {
      this.zuPoints = []
      this.wellPoints = []
      this.guPoints = []
      this.axios.get(this.localeUrl("/gu-map/pipes"), {params: {gu: this.gu}}).then((response) => {
        console.log(response);
        this.pipes = response.data.pipes
        this.zuPoints = response.data.zuPoints
        this.wellPoints = response.data.wellPoints
        this.guPoints = response.data.guPoints
        this.guCenters = response.data.guCenters

        this.viewState = {
          latitude: response.data.center[1],
          longitude: response.data.center[0],
          zoom: 11,
          bearing: 0,
          pitch: 30
        };

        this.map = new mapboxgl.Map({
          container: 'map',
          style: this.mapStyle,
          interactive: false,
          center: [this.viewState.longitude, this.viewState.latitude],
          zoom: this.viewState.zoom,
          bearing: this.viewState.bearing,
          pitch: this.viewState.pitch,
          accessToken: this.accessToken,
        });

        this.deck = new Deck({
          canvas: 'deck-canvas',
          initialViewState: this.viewState,
          controller: true,
          onViewStateChange: ({viewState}) => {
            console.log('onViewStateChange');
            console.log('viewState', viewState);
            this.map.jumpTo({
              center: [viewState.longitude, viewState.latitude],
              zoom: viewState.zoom,
              bearing: viewState.bearing,
              pitch: viewState.pitch
            });
          },
          getTooltip: ({object}) => object && object.name,
          layers: [
            new PathLayer({
              id: 'path-layer',
              data: this.pipes,
              pickable: true,
              widthScale: 2,
              widthMinPixels: 1,
              autoHighlight: true,
              getPath: d => d.path,
              getColor: d => this.colorToRGBArray(d.color),
              getWidth: d => 3,
              parameters: {
                depthTest: false
              }
            }),
            new IconLayer({
              id: 'icon-layer-gu',
              data: this.guPoints,
              pickable: true,
              iconAtlas: '/img/icons/barrel.png',
              iconMapping: {
                marker: {x: 0, y: 0, width: 24, height: 36, mask: true}
              },
              getIcon: d => 'marker',
              sizeScale: 30,
              getPosition: d => d.coords,
              sizeUnits: 'meters',
              getSize: d => 2,
              onClick: (event) => {
                console.log(event)
              }
            }),
            new IconLayer({
              id: 'icon-layer-zu',
              data: this.zuPoints,
              pickable: true,
              iconAtlas: '/img/icons/barrel.png',
              iconMapping: {
                marker: {x: 0, y: 0, width: 24, height: 36, mask: true}
              },
              getIcon: d => 'marker',
              sizeScale: 20,
              getPosition: d => d.coords,
              sizeUnits: 'meters',
              getSize: d => 2,
              onClick: (event) => {
                console.log(event)
              }
            }),
            new IconLayer({
              id: 'icon-layer-well',
              data: this.wellPoints,
              pickable: true,
              iconAtlas: '/img/icons/well.png',
              iconMapping: {
                marker: {x: 0, y: 0, width: 52, height: 48, mask: true}
              },
              getIcon: d => 'marker',
              sizeScale: 20,
              getPosition: d => d.coords,
              sizeUnits: 'meters',
              getSize: d => 2,
              onClick: (event) => {
                console.log(event)
              }
            })
          ]
        });


      });
    },
  }
}
</script>
<style lang="scss">
h1 {
  color: #fff;
}

.gu-map {
  position: relative;
  height: calc(100vh - 96px);
  width: 100%;

  &__controls {
    display: inline-block;
    padding: 15px 0 0 15px;
    position: relative;
    z-index: 10;
    width: 100px;

    h1 {
      color: #000;
      font-size: 28px;
    }

    .v-select{
      min-width: 200px;
    }
    .vs__dropdown-toggle{
      padding-bottom: 0;
    }
  }

  #map {
    bottom: 0;
    left: 0;
    position: absolute;
    top: 0;
    right: 0;
  }

  #deckgl-overlay {
    background: rgba(255, 255, 255, 0.4);
    left: 0;
    position: absolute;
    top: 0;
  }

}
</style>
