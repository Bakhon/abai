<template>
  <div class="gu-map">
    <div class="gu-map__controls">
      <h1>{{ trans('monitoring.map.title') }}</h1>
      <div v-if="gus" class="d-flex">
        <v-select
            v-model="gu"
            @input="centerTo"
            :options="gus"
            :reduce="option => option.id"
            label="name"
            :placeholder="trans('monitoring.map.select_gu')"
        >
        </v-select>
        <v-select
            v-model="editMode"
            :options="editOptions"
            :reduce="option => option.code"
            label="name"
            class="ml-2 w-space-nowrap minw-fit-c"
            placeholder="Режим редактирования"
        >
        </v-select>
      </div>
    </div>
    <div id="map"></div>

    <b-modal
        header-bg-variant="main4"
        body-bg-variant="main1"
        header-text-variant="light"
        footer-bg-variant="main4"
        centered
        id="add-object-modal"
        :title="addObjectModalTitle">

      <map-gu-form :gu="addObjectform" :cdngs="cdngs" v-if="editMode == 'gu'"></map-gu-form>
      <map-zu-form :zu="addObjectform" :gus="gus" v-if="editMode == 'zu'"></map-zu-form>
      <map-well-form :well="addObjectform" :zus="zuPoints" v-if="editMode == 'well'"></map-well-form>
      <map-pipe-form :pipe="newPipe" :zus="zuPoints" :gus="gus" v-if="editMode == 'pipe' && newPipe"></map-pipe-form>

      <template #modal-footer>
        <div class="w-100">
          <b-button
              variant="secondary"
              class="float-right ml-3"
              @click="cancelAddObject()"
          >
            Отмена
          </b-button>
          <b-button
              variant="primary"
              class="float-right"
              @click="addMapObject"
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
import mapGuForm from "./mapGuForm";
import mapZuForm from "./mapZuForm";
import mapWellForm from "./mapWellForm";
import mapPipeForm from "./mapPipeForm";

export default {
  name: "gu-map",
  components: {
    vSelect,
    'map-gu-form': mapGuForm,
    'map-zu-form': mapZuForm,
    'map-well-form': mapWellForm,
    'map-pipe-form': mapPipeForm
  },
  props: {
    gus: {
      type: Array,
      required: true,
    },
    cdngs: {
      type: Array,
      required: true,
    }
  },
  data() {
    return {
      addObjectform: {
        id: null,
        name: '',
        lat: null,
        lon: null
      },
      editOptions: [
        {
          name: 'ГУ редактор',
          code: 'gu'
        },
        {
          name: 'ЗУ редактор',
          code: 'zu'
        },
        {
          name: 'Редактор скважин',
          code: 'well'
        },
        {
          name: 'Редактор трубопровода',
          code: 'pipe'
        },
      ],
      isHovering: false,
      newPipe: null,
      gu: null,
      pipeLayerId: 1,
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
      map: null,
      deck: null,
      editMode: null,
      viewState: {
        latitude: null,
        longitude: null,
        zoom: null,
        bearing: null,
        pitch: null
      },
      firstCentered: false,
      guPointsIndexes: [],
      layers: [],
    };
  },
  created() {
    this.initMap();
  },
  computed: {
    addObjectModalTitle() {
      switch (this.editMode) {
        case 'gu':
          return "Новый ГУ"
          break;

        case 'zu':
          return "Новый ЗУ"
          break;

        case 'well':
          return "Новая скважина"
          break;

        case 'pipe':
          return "Новый трубопровод"
          break;

        default:
          return ""
          break;
      }
    }
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
    resetForm() {
      this.addObjectform = {
        id: null,
        name: '',
        lat: null,
        lon: null
      }
    },
    cancelAddObject() {
      this.resetForm();

      if (this.newPipe) {
        let layerIndex = this.layers.findIndex(layer => layer.id == 'path-layer-' + this.pipeLayerId);

        if (layerIndex != -1) {
          this.layers.splice(layerIndex, 1);
        }

        this.updateLayers();
        if (this.map.getLayer('path-layer-' + this.pipeLayerId)) {
          this.map.removeLayer('path-layer-' + this.pipeLayerId);
        }

        this.deck.setProps({layers: this.layers});
        this.$bvModal.hide('add-object-modal');
        this.newPipe = null;

      }
    },
    storeGu() {
      return this.axios.post(this.localeUrl("/gu-map/storegu"), {gu: this.addObjectform}).then((response) => {
        if (response.data.status == 'success') {
          return response.data.gu;
        } else {
          console.log('error save Gu in DB');
        }
      });
    },
    storeZu() {
      return this.axios.post(this.localeUrl("/gu-map/storezu"), {zu: this.addObjectform}).then((response) => {
        if (response.data.status == 'success') {
          return response.data.zu;
        } else {
          console.log('error save Zu in DB');
        }
      });
    },
    storeWell() {
      return this.axios.post(this.localeUrl("/gu-map/storewell"), {well: this.addObjectform}).then((response) => {
        if (response.data.status == 'success') {
          return response.data.well;
        } else {
          console.log('error save Well in DB');
        }
      });
    },
    storePipe() {
      return this.axios.post(this.localeUrl("/gu-map/storepipe"), {pipe: this.newPipe}).then((response) => {
        if (response.data.status == 'success') {
          return response.data.pipe;
        } else {
          console.log('error save Pipe in DB');
        }
      });
    },
    updateLayers() {
      let tempLayers = [];
      this.layers.forEach((layer) => {
        tempLayers.push(layer);
      });

      this.layers = tempLayers;
    },
    addMapObject() {
      let method = 'add' + this.editMode.charAt(0).toUpperCase() + this.editMode.slice(1);
      this[method]();
    },
    async addGu() {
      let gu = await this.storeGu();
      this.guPoints.push(gu);
      this.guPointsIndexes.push(gu.id);
      this.gus.push(gu);
      this.gu = gu;
      this.$bvModal.hide('add-object-modal');
      this.resetForm();
      this.updateLayers();

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
            getPosition: d => [parseFloat(d.lon), parseFloat(d.lat)],
            sizeUnits: 'meters',
            getSize: d => 2,
            onClick: (info, event) => {

            }
          })
      );

      let deck = this.deck;
      this.map.addLayer(new MapboxLayer({id: 'icon-layer-gu_' + gu.id, deck}));
      this.deck.setProps({layers: this.layers});
      this.centerTo(gu);
    },
    async addZu() {
      let zu = await this.storeZu();
      this.zuPoints.push(zu);
      this.$bvModal.hide('add-object-modal');
      this.resetForm();
      this.updateLayers();

      this.layers.push(
          new IconLayer({
            id: 'icon-layer-zu_' + zu.id,
            data: [zu],
            pickable: true,
            iconAtlas: '/img/icons/barrel.png',
            iconMapping: {
              marker: {x: 0, y: 0, width: 24, height: 36, mask: true}
            },
            getIcon: d => 'marker',
            sizeScale: 20,
            getPosition: (d) => [parseFloat(d.lon), parseFloat(d.lat)],
            sizeUnits: 'meters',
            getSize: d => 2,
            onClick: (info, event) => {

            },
          })
      );

      let deck = this.deck;
      this.map.addLayer(new MapboxLayer({id: 'icon-layer-zu_' + zu.id, deck}));
      this.deck.setProps({layers: this.layers});
      this.centerTo(zu);
    },
    async addWell() {
      let well = await this.storeWell();
      this.wellPoints.push(well);
      this.$bvModal.hide('add-object-modal');
      this.resetForm();
      this.updateLayers();

      this.layers.push(
          new IconLayer({
            id: 'icon-layer-well_' + well.id,
            data: [well],
            pickable: true,
            iconAtlas: '/img/icons/well.png',
            iconMapping: {
              marker: {x: 0, y: 0, width: 52, height: 48, mask: true}
            },
            getIcon: d => 'marker',
            sizeScale: 20,
            getPosition: d => [parseFloat(d.lon), parseFloat(d.lat)],
            sizeUnits: 'meters',
            getSize: d => 2,
            onClick: (info, event) => {

            },
          })
      );

      let deck = this.deck;
      this.map.addLayer(new MapboxLayer({id: 'icon-layer-well_' + well.id, deck}));
      this.deck.setProps({layers: this.layers});
      this.centerTo(well);
    },
    async addPipe() {
      let pipe = await this.storePipe();
      this.pipes.push(pipe);
      this.$bvModal.hide('add-object-modal');
      this.newPipe = null;
      this.pipeLayerId++;
    },
    prepareLayers() {
      let pipesLayer = new PathLayer({
        id: 'path-layer',
        data: this.pipes,
        pickable: true,
        widthScale: 2,
        widthMinPixels: 1,
        autoHighlight: true,
        getPath: d => d.coordinates,
        getColor: d => this.colorToRGBArray(d.color),
        getWidth: d => 3,
        onClick: (info, event) => {

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
        getPosition: (d) => [parseFloat(d.lon), parseFloat(d.lat)],
        sizeUnits: 'meters',
        getSize: d => 2,
        onClick: (info, event) => {
          this.mapObjectClickHandle('gu', info);
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
        getPosition: (d) => [parseFloat(d.lon), parseFloat(d.lat)],
        sizeUnits: 'meters',
        getSize: d => 2,
        onClick: (info, event) => {
          this.mapObjectClickHandle('zu', info);
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
        getPosition: d => [parseFloat(d.lon), parseFloat(d.lat)],
        sizeUnits: 'meters',
        getSize: d => 2,
        onClick: (info, event) => {
          this.mapObjectClickHandle('well', info);
        },
      });

      this.layers = [
        pipesLayer,
        guPointsLayer,
        zuPointsLayer,
        wellPointsLayer,
      ];
    },
    indexingGuPoints() {
      this.guPoints.forEach((gu, index) => {
        this.guPointsIndexes[index] = gu.id;
      });
    },
    centerTo(point = null) {
      if (point == null) {
        return false;
      }

      if (!(typeof point === 'object')) {
        let index = this.guPointsIndexes.indexOf(point);
        point = this.guPoints[index];
      }

      this.deck.setProps({
        initialViewState: {
          longitude: parseFloat(point.lon),
          latitude: parseFloat(point.lat),
          zoom: 15,
          bearing: 0,
          pitch: 30
        }
      })

      //added to fix a bug with deck.gl on first click to gu select
      if (!this.firstCentered) {
        this.deck.setProps({
          initialViewState: {
            longitude: parseFloat(point.lon),
            latitude: parseFloat(point.lat),
            zoom: 15,
            bearing: 0,
            pitch: 30
          }
        })
        this.firstCentered = true
      }

      this.map.jumpTo({
        center: [parseFloat(point.lon), parseFloat(point.lat)],
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

        this.map.on('click', (e) => {
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
          onHover: ({object}) => (this.isHovering = Boolean(object)),
          getCursor: ({isDragging}) => (isDragging ? 'grabbing' : (this.isHovering ? 'pointer' : 'grab')),
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
      if (this.editMode && this.editMode != 'pipe') {
        this.addObjectform.lon = e.lngLat.lng
        this.addObjectform.lat = e.lngLat.lat;

        this.$bvModal.show('add-object-modal');
      } else if (this.editMode == 'pipe' && this.newPipe) {
        this.newPipe.coordinates.push([e.lngLat.lng, e.lngLat.lat]);
        this.renderPipe();
      }
    },
    mapObjectClickHandle(type, info) {
      if (this.editMode == 'pipe') {

        //start point
        if ((type == 'zu' || type == 'well') && !this.newPipe) {
          this.newPipe = {
            id: null,
            type: type == 'zu' ? 'GuZu' : 'ZuWell',
            name: '',
            coordinates: [info.coordinate],
          };

          if (type == 'zu') {
            this.newPipe.zu_id = info.object.id;
            this.newPipe.color = [255, 0, 0];
          }

          if (type == 'well') {
            this.newPipe.well_id = info.object.id;
            this.newPipe.color = [0, 255, 0];
          }

          //end point
        } else if ((type == 'zu' || type == 'gu') && this.newPipe) {
          this.newPipe.coordinates.push(info.coordinate);

          if (type == 'gu') {
            this.newPipe.gu_id = info.object.id;
          }

          if (type == 'zu') {
            this.newPipe.zu_id = info.object.id;
            this.newPipe.gu_id = info.object.gu_id;
          }

          this.renderPipe();
          this.$bvModal.show('add-object-modal');
        }

      }
    },
    renderPipe() {
      let layerIndex = this.layers.findIndex(layer => layer.id == 'path-layer-' + this.pipeLayerId);

      if (layerIndex != -1) {
        this.layers.splice(layerIndex, 1);
      }

      this.updateLayers();

      this.layers.push(new PathLayer({
        id: 'path-layer-' + this.pipeLayerId,
        data: [this.newPipe],
        pickable: true,
        widthScale: 2,
        widthMinPixels: 1,
        autoHighlight: true,
        getPath: d => d.coordinates,
        getColor: d => this.colorToRGBArray(d.color),
        getWidth: d => 3,
        onClick: (info, event) => {

        },
        parameters: {
          depthTest: false
        }
      }));

      let deck = this.deck;
      if (this.map.getLayer('path-layer-' + this.pipeLayerId)) {
        this.map.removeLayer('path-layer-' + this.pipeLayerId);
      }
      this.map.addLayer(new MapboxLayer({id: 'path-layer-' + this.pipeLayerId, deck}));
      this.deck.setProps({layers: this.layers});
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

    .v-select {
      min-width: 260px;
    }

    .vs__dropdown-toggle {
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

  .mapboxgl-canvas {
    width: 100% !important;
  }

}
</style>
