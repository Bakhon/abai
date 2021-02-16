<template>
  <div class="gu-map">
    <div class="gu-map__controls">
      <h1>{{ trans('monitoring.map.title') }}</h1>
      <div v-if="gus" class="d-flex">
        <v-select
            v-model="gu"
            @input="centerToGu"
            :options="gus"
            :reduce="option => option.id"
            label="name"
            :placeholder="trans('monitoring.map.select_gu')"
        >
        </v-select>
        <b-form-checkbox v-model="guEditMode" name="add-gu" class="ml-2" switch>+ ГУ</b-form-checkbox>
      </div>
    </div>
    <div id="map" ></div>

    <b-modal
        header-bg-variant="main4"
        body-bg-variant="main1"
        header-text-variant="light"
        footer-bg-variant="main4"
        centered
        id="gu-modal"
        title="Новый ГУ">
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

      <b-form-group
          label="ЦДНГ"
          label-for="cdng">
        <b-form-select
            id="cdng"
            v-model="formGu.cdng_id"
            :options="cdngOptions"
        ></b-form-select>
      </b-form-group>

      <b-form-group label="Широта" label-for="coord-x">
        <b-form-input
            id="coord-y"
            v-model="formGu.lat"
            required
        ></b-form-input>
      </b-form-group>

        <b-form-group label="Долгота" label-for="coord-y">
          <b-form-input
              id="coord-x"
              v-model="formGu.lon"
              required
          ></b-form-input>
        </b-form-group>

      <template #modal-footer="{ cancel }">
        <div class="w-100">
          <b-button
              variant="secondary"
              class="float-right"
              @click="cancel()"
          >
            Отмена
          </b-button>
          <b-button
              variant="primary"
              class="float-right"
              @click="addGu"
          >
            Добавить
          </b-button>
        </div>
      </template>
    </b-modal>
  </div>
</template>

<script>
import mapboxgl from "mapbox-gl";
import {Deck} from '@deck.gl/core';
import {PathLayer, IconLayer} from '@deck.gl/layers';
import {MapboxLayer} from '@deck.gl/mapbox';
import vSelect from "vue-select";

export default {
  name: "gu-map",
  components: {
    vSelect
  },
  props: {
    gus: Array,
    cdngs: Array
  },
  data() {
    return {
      formGu: {
        id: null,
        name: '',
        lat: null,
        lon: null,
        cdng_id: null
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
      guEditMode: false,
      viewState: {
        latitude: null,
        longitude: null,
        zoom: null,
        bearing: null,
        pitch: null
      },
      firstCentered: false,
      guPointsIndexes: [],
      zuPointsLayer: null,
      pipesLayer: null,
      guPointsLayer: null,
      wellPointsLayer: null,
      layers: [],
    };
  },
  created() {
    this.initMap();
  },
  computed: {
    cdngOptions: function () {
      let options = [];
      this.cdngs.forEach((item) => {
        options.push(
          { value: item.id, text: item.name }
        );
      });

      return options;
    },
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
    resetGuForm () {
      this.formGu = {
        id: null,
            name: '',
            lat: null,
            lon: null,
            cdng_id: null
      }
    },
    storeGu (){
      return this.axios.post(this.localeUrl("/gu-map/storegu"), {gu: this.formGu}).then((response) => {
        if (response.data.status == 'success') {
          let gu = response.data.gu;
          gu.coords = [gu.lon, gu.lat];
          return gu;
        } else {
          console.log('error save Gu in DB');
        }
      });
    },
    async addGu () {
      let gu = await this.storeGu();

      this.guPoints.push(gu);
      this.guPointsIndexes.push(gu.id);
      this.gus.push(gu);
      this.gu = gu;
      this.$bvModal.hide('gu-modal');
      this.resetGuForm();

      //dirty hack for update layers array but other solutions doesn't work, don't know why yet
      let tempLayers = [];
      this.layers.forEach((layer) => {
        tempLayers.push(layer);
      });

      this.layers = tempLayers;
      //end hack

      this.layers.push(
          new IconLayer({
            id: 'icon-layer-gu_' + gu.id,
            data: [gu],
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
              console.log('icon-layer-gu_' + gu.id, event)
            }
          })
      );

      let deck = this.deck;
      this.map.addLayer(new MapboxLayer({id: 'icon-layer-gu_' + gu.id, deck}));
      this.deck.setProps({layers: this.layers});
      this.centerToGu(gu);
    },
    prepareLayers () {
      let pipesLayer = new PathLayer({
        id: 'path-layer',
        data: this.pipes,
        pickable: true,
        widthScale: 2,
        widthMinPixels: 1,
        autoHighlight: true,
        getPath: d => d.path,
        getColor: d => this.colorToRGBArray(d.color),
        getWidth: d => 3,
        onClick: (info, event) => {
          console.log('path-layer', event, info)
        },
        parameters: {
          depthTest: false
        }
      });

      let guPointsLayer = new IconLayer({
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
        onClick: (info, event) => {
          console.log('onClick icon-layer-gu', event, info)
        }
      });

      let zuPointsLayer = new IconLayer({
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
        onClick: (info, event) => {
          console.log('icon-layer-zu', event, info)
        },
      });

      let wellPointsLayer = new IconLayer({
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
        onClick: (info, event) => {
          console.log('icon-layer-well', event, info)
        },
      });

      this.layers = [
        pipesLayer,
        guPointsLayer,
        zuPointsLayer,
        wellPointsLayer,
      ];
    },
    indexingGuPoints(){
      this.guPoints.forEach((gu, index) => {
        this.guPointsIndexes[index] = gu.id;
      });
    },
    centerToGu(guPoint = null) {
      if (guPoint == null) {
        return false;
      }

      if (!(typeof guPoint === 'object')) {
        let index = this.guPointsIndexes.indexOf(guPoint);
        guPoint = this.guPoints[index];
      }

      this.deck.setProps({
        initialViewState: {
          longitude: parseFloat(guPoint.lon),
          latitude: parseFloat(guPoint.lat),
          zoom: 15,
          bearing: 0,
          pitch: 30
        }
      })

      //added to fix a bug with deck.gl on first click to gu select
      if (!this.firstCentered) {
        this.deck.setProps({
          initialViewState: {
            longitude: parseFloat(guPoint.lon),
            latitude: parseFloat(guPoint.lat),
            zoom: 15,
            bearing: 0,
            pitch: 30
          }
        })
        this.firstCentered = true
      }

      this.map.jumpTo({
        center: [parseFloat(guPoint.lon), parseFloat(guPoint.lat)],
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
        this.pipes = response.data.pipes;
        this.zuPoints = response.data.zuPoints;
        this.wellPoints = response.data.wellPoints;
        this.guPoints = response.data.guPoints;
        this.guCenters = response.data.guCenters;

        this.indexingGuPoints();

        this.viewState = {
          latitude: response.data.center[1],
          longitude: response.data.center[0],
          zoom: 11,
          bearing: 0,
          pitch: 30
        };

        let map = this.map = new mapboxgl.Map({
          container: 'map',
          style: this.mapStyle,
          interactive: false,
          center: [this.viewState.longitude, this.viewState.latitude],
          zoom: this.viewState.zoom,
          bearing: this.viewState.bearing,
          pitch: this.viewState.pitch,
          accessToken: this.accessToken
        });

        this.map.on('click',  (e) => {
          this.mapClickHandle(e);
        });

        this.prepareLayers();

        let deck = this.deck = new Deck({
          gl: map.painter.context.gl,
          initialViewState: this.viewState,
          controller: true,
          onViewStateChange: ({viewState}) => {
            this.map.jumpTo({
              center: [viewState.longitude, viewState.latitude],
              zoom: viewState.zoom,
              bearing: viewState.bearing,
              pitch: viewState.pitch
            });
          },
          getTooltip: ({object}) => object && object.name,
          layers: this.layers,
        });

        // wait for map to be ready
        this.map.on('load', () => {
          // add to mapbox
          this.map.addLayer(new MapboxLayer({id: 'path-layer', deck}));
          this.map.addLayer(new MapboxLayer({id: 'icon-layer-gu', deck}));
          this.map.addLayer(new MapboxLayer({id: 'icon-layer-zu', deck}));
          this.map.addLayer(new MapboxLayer({id: 'icon-layer-well', deck}));

          // update the layers
          this.deck.setProps({
            layers: this.layers
          });
        });
      });
    },
    mapClickHandle(e) {
      if (this.guEditMode) {
        this.formGu = {
          id: null,
          name: '',
          lon: e.lngLat.lng,
          lat: e.lngLat.lat
        }
        this.$bvModal.show('gu-modal');
      }
    }
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
