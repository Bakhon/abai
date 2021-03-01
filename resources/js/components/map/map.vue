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
      </div>
    </div>
    <div id="map"></div>

    <map-context-menu
        v-model="clickedObject"
        @option-clicked="optionClicked"
        ref="contextMenu"
    ></map-context-menu>


    <b-modal
        header-bg-variant="main4"
        body-bg-variant="main1"
        header-text-variant="light"
        footer-bg-variant="main4"
        centered
        id="object-modal"
        :title="addObjectModalTitle">

      <map-gu-form :gu="objectData" :cdngs="cdngs" v-if="editMode == 'gu'"></map-gu-form>
      <map-zu-form :zu="objectData" :gus="gus" v-if="editMode == 'zu'"></map-zu-form>
      <map-well-form :well="objectData" :zus="zuPoints" v-if="editMode == 'well'"></map-well-form>
      <map-pipe-form :pipe="pipeObject" :zus="zuPoints" :gus="gus"
                     v-if="editMode == 'pipe' && pipeObject"></map-pipe-form>

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
              @click="handlerFormSubmit"
          >
            {{ okBtntext }}
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
import {guMapState, guMapMutations, guMapActions} from '@store/helpers';
import mapContextMenu from "./mapContextMenu";


export default {
  name: "gu-map",
  components: {
    vSelect,
    'map-gu-form': mapGuForm,
    'map-zu-form': mapZuForm,
    'map-well-form': mapWellForm,
    'map-pipe-form': mapPipeForm,
    'map-context-menu': mapContextMenu
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
      showContextMenu: false,
      clickedObject: null,
      objectData: {
        id: null,
        name: '',
        lat: null,
        lon: null
      },
      layersIds: [],
      formType: 'add',
      isHovering: false,
      pipeObject: null,
      gu: null,
      mapBoxToken: process.env.MIX_MAPBOX_TOKEN,
      mapStyle: 'mapbox://styles/mapbox/satellite-v9?optimize=true',
      contextmenu: false,
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
      layers: [],
    };
  },
  created() {
    this.initMap();
  },
  computed: {
    ...guMapState([
      'pipes',
      'zuPoints',
      'wellPoints',
      'guPoints',
      'guCenters',
      'guPointsIndexes',
      'mapCenter'
    ]),
    addObjectModalTitle() {
      switch (this.editMode) {
        case 'gu':
          return this.formType == 'add' ? this.trans('monitoring.gus.create_title') : this.trans('monitoring.gus.edit_title')
          break;

        case 'zu':
          return this.formType == 'add' ? this.trans('monitoring.zus.create_title') : this.trans('monitoring.zus.edit_title')
          break;

        case 'well':
          return this.formType == 'add' ? this.trans('monitoring.well.create_title') : this.trans('monitoring.well.edit_title')
          break;

        case 'pipe':
          return this.formType == 'add' ? this.trans('monitoring.pipe.create_title') : this.trans('monitoring.pipe.edit_title')
          break;

        default:
          return ""
          break;
      }
    },
    okBtntext() {
      return this.formType == 'add' ? this.trans('app.create') : this.trans('app.update')
    }
  },
  methods: {
    ...guMapMutations([]),
    ...guMapActions([
      'getPipes',
      'storeGu',
      'storeZu',
      'storeWell',
      'storePipe',
      'updateGu',
      'updateZu',
      'updateWell',
      'updatePipe',
      'deleteGu',
      'deleteZu',
      'deleteWell',
      'deletePipe'
    ]),
    handleContextmenu(event) {
      this.clickedObject = null;
      this.$refs.contextMenu.showMenu(event);
    },
    optionClicked(option) {
      this.editMode = option.editMode;

      if (option.type == 'add') {

        //pipe start point
        if (option.editMode == 'pipe') {
          this.pipeObject = {
            id: null,
            type: option.mapObject.type == 'zu' ? 'GuZu' : 'ZuWell',
            name: '',
            coordinates: [],
          };

          if (option.mapObject.type == 'zu') {
            this.pipeObject.zu_id = option.mapObject.object.id;
            this.pipeObject.color = [255, 0, 0];
          }

          if (option.mapObject.type == 'well') {
            this.pipeObject.well_id = option.mapObject.object.id;
            this.pipeObject.color = [0, 255, 0];
          }


          option.lngLat = {
            lng: parseFloat(option.mapObject.object.lon),
            lat: parseFloat(option.mapObject.object.lat),
          };
        }

        this.mapClickHandle(option);
      }

      if (option.type == 'edit') {
        if (option.editMode == 'pipe') {
          this.pipeObject = option.mapObject.object;
        }

        this.objectData = option.mapObject.object;
        this.objectData.index = option.mapObject.index;
        this.$bvModal.show('object-modal');
      }

      if (option.type == 'delete') {
        if (option.editMode == 'pipe') {
          this.pipeObject = option.mapObject.object;
        }

        this.objectData = option.mapObject.object;
        this.objectData.index = option.mapObject.index;

        let title = this.trans('app.delete_confirm') + this.getObjectName(this.editMode) + '?';
        this.confirmDelete(title);
      }

      this.formType = option.type;
    },
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
      this.objectData = {
        id: null,
        name: '',
        lat: null,
        lon: null
      }

      this.editMode = null;
      this.pipeObject = null;
    },
    cancelAddObject() {
      this.resetForm();

      if (this.pipeObject) {
        let layerIndex = this.layers.findIndex(layer => layer.id == 'path-layer-' + this.pipeLayerId);

        if (layerIndex != -1) {
          this.layers.splice(layerIndex, 1);
        }

        this.updateLayers();
        if (this.map.getLayer('path-layer-' + this.pipeLayerId)) {
          this.map.removeLayer('path-layer-' + this.pipeLayerId);
        }

        this.deck.setProps({layers: this.layers});
        this.pipeObject = null;
      }

      this.editMode = null;
      this.$bvModal.hide('object-modal');
    },
    updateLayers() {
      let tempLayers = [];
      this.layers.forEach((layer) => {
        tempLayers.push(layer);
      });

      this.layers = tempLayers;

      this.deck.setProps({layers: this.layers});
    },
    addMapLayer(layerId) {
      this.updateLayers();

      let deck = this.deck;
      if (this.map.getLayer(layerId)) {
        this.map.removeLayer(layerId);
      }

      this.map.addLayer(new MapboxLayer({id: layerId, deck}));
      this.deck.setProps({layers: this.layers});
    },
    handlerFormSubmit() {
      let method = (this.pipeObject != null && this.pipeObject.id)
      || (this.objectData != null && this.objectData.id) ? 'edit' : 'add';

      method += this.editMode.charAt(0).toUpperCase() + this.editMode.slice(1);
      this[method]();
    },
    createIconLayer(layerId, data, type) {
      let iconAtlas = type == 'zu' || type == 'gu' ? '/img/icons/barrel.png' : '/img/icons/well.png';
      let name = this.getObjectName(type);
      let marker = this.getObjectMarker(type);

      return new IconLayer({
        id: layerId,
        data,
        pickable: true,
        iconAtlas,
        iconMapping: {
          marker
        },
        getIcon: d => 'marker',
        sizeScale: type == 'gu' ? 30 : 20,
        getPosition: (d) => [parseFloat(d.lon), parseFloat(d.lat)],
        sizeUnits: 'meters',
        getSize: d => 2,
        onClick: (info) => {
          info.type = type;
          info.name = name;
          this.mapObjectClickHandle(info);
        },
      })
    },
    createPipeLayer(layerId, data) {
      return new PathLayer({
        id: layerId,
        data,
        pickable: true,
        widthScale: 2,
        widthMinPixels: 1,
        autoHighlight: true,
        getPath: d => d.coordinates,
        getColor: d => this.colorToRGBArray(d.color),
        getWidth: d => 3,
        onClick: (info) => {
          info.type = 'pipe';
          info.name = 'Трубопровод';
          this.mapObjectClickHandle(info);
        },
        parameters: {
          depthTest: false
        }
      });
    },
    async addGu() {
      let gu = await this.storeGu(this.objectData);
      let layerId = 'icon-layer-gu';
      this.gus.push(gu);
      this.gu = gu;
      this.$bvModal.hide('object-modal');

      this.layerReDraw(layerId, 'gu', this.guPoints);
      this.centerTo(gu);
      this.resetForm();

      let $message = this.trans('monitoring.gu') + ' ' + this.trans('app.added');
      this.showToast($message, this.trans('app.success'), 'success');
    },
    async addZu() {
      let zu = await this.storeZu(this.objectData);
      let layerId = 'icon-layer-zu';
      this.$bvModal.hide('object-modal');

      this.layerReDraw(layerId, 'zu', this.zuPoints);
      this.centerTo(zu);
      this.resetForm();

      let $message = this.trans('monitoring.zu') + ' ' + this.trans('app.added');
      this.showToast($message, this.trans('app.success'), 'success');
    },
    async addWell() {
      let well = await this.storeWell(this.objectData);
      let layerId = 'icon-layer-well';
      this.$bvModal.hide('object-modal');

      this.layerReDraw(layerId, 'well', this.wellPoints);
      this.centerTo(well);
      this.resetForm();

      let $message = this.trans('monitoring.well.added');
      this.showToast($message, this.trans('app.success'), 'success');
    },
    async addPipe() {
      await this.storePipe(this.pipeObject);
      this.$bvModal.hide('object-modal');
      this.resetForm();
      this.removeTempPipeLayer();
      this.layerReDraw('path-layer', 'pipe', this.pipes);

      let $message = this.trans('monitoring.pipe') + ' ' + this.trans('app.added');
      this.showToast($message, this.trans('app.success'), 'success');
    },
    async editGu() {
      let gu = await this.updateGu(this.objectData);

      let guIndex = this.gus.findIndex((guPoint) => {
        return guPoint.id == gu.id;
      });

      this.$set(this.gus, guIndex, gu);
      this.gu = gu;
      this.$bvModal.hide('object-modal');
      let layerId = 'icon-layer-gu';


      this.layerReDraw(layerId, 'gu', this.guPoints);
      this.centerTo(gu);
      this.resetForm();

      let $message = this.trans('monitoring.gu') + ' ' + this.trans('app.updated');
      this.showToast($message, this.trans('app.success'), 'success');
    },
    async editZu() {
      let zu = await this.updateZu(this.objectData);
      let layerId = 'icon-layer-zu';
      this.$bvModal.hide('object-modal');

      this.layerReDraw(layerId, 'zu', this.zuPoints);
      this.centerTo(zu);
      this.resetForm();

      let $message = this.trans('monitoring.zu') + ' ' + this.trans('app.updated');
      this.showToast($message, this.trans('app.success'), 'success');
    },
    async editWell() {
      let well = await this.updateWell(this.objectData);
      let layerId = 'icon-layer-well';
      this.$bvModal.hide('object-modal');

      this.layerReDraw(layerId, 'well', this.wellPoints);
      this.centerTo(well);
      this.resetForm();

      let $message = this.trans('monitoring.well.updated');
      this.showToast($message, this.trans('app.success'), 'success');
    },
    async editPipe() {
      await this.updatePipe(this.pipeObject);
      this.$bvModal.hide('object-modal');

      this.layerReDraw('path-layer', 'pipe', this.pipes);
      this.resetForm();

      let $message = this.trans('monitoring.pipe.updated');
      this.showToast($message, this.trans('app.success'), 'success');
    },
    async removeGu() {
      let result = await this.deleteGu(this.objectData);
      if (result == 'success') {
        let guIndex = this.gus.findIndex((guPoint) => {
          return guPoint.id == this.objectData.id;
        });

        this.gu = null;
        this.gus.splice(guIndex, 1);

        let layerId = 'icon-layer-gu';
        this.resetForm();
        this.layerReDraw(layerId, 'gu', this.guPoints);

        let $message = this.trans('monitoring.gu.deleted');
        this.showToast($message, this.trans('app.success'), 'success');
      } else {
        let $message = this.trans('monitoring.gu.deleting_error');
        this.showToast($message, this.trans('app.error'), 'danger');
      }
    },
    async removeZu() {
      let result = await this.deleteZu(this.objectData);
      if (result == 'success') {
        let layerId = 'icon-layer-zu';

        this.resetForm();
        this.layerReDraw(layerId, 'zu', this.zuPoints);

        let $message = this.trans('monitoring.zu.deleted');
        this.showToast($message, this.trans('app.success'), 'success');
      } else {
        let $message = this.trans('monitoring.zu.deleting_error');
        this.showToast($message, this.trans('app.error'), 'danger');
      }
    },
    async removeWell() {
      let result = await this.deleteWell(this.objectData);
      if (result == 'success') {
        let layerId = 'icon-layer-well';

        this.resetForm();
        this.layerReDraw(layerId, 'well', this.wellPoints);

        let $message = this.trans('monitoring.well.deleted');
        this.showToast($message, this.trans('app.success'), 'success');
      } else {
        let $message = this.trans('monitoring.well.deleting_error');
        this.showToast($message, this.trans('app.error'), 'danger');
      }
    },
    async removePipe() {
      this.pipeObject.type = typeof this.pipeObject.well_id != 'undefined' && this.pipeObject.well_id ? 'ZuWell' : 'GuZu';
      let result = await this.deletePipe(this.pipeObject);

      if (result == 'success') {
        this.layerReDraw('path-layer', 'pipe', this.pipes);
        this.resetForm();

        let $message = this.trans('monitoring.pipe.deleted');
        this.showToast($message, this.trans('app.success'), 'success');
      } else {
        let $message = this.trans('monitoring.pipe.deleting_error');
        this.showToast($message, this.trans('app.error'), 'danger');
      }
    },
    layerReDraw(layerId, type, data) {
      let layerIndex = this.layers.findIndex((layer) => {
        return layer.id == layerId;
      });

      this.layers.splice(layerIndex, 1);
      this.updateLayers();

      if (type != 'pipe') {
        this.layers.push(this.createIconLayer(layerId, data, type));
      } else {
        this.layers.push(this.createPipeLayer(layerId, data));
      }

      this.addMapLayer(layerId);
    },
    confirmDelete(message) {
      this.$bvModal.msgBoxConfirm(message, {
        title: this.trans('app.delete_titie'),
        headerBgVariant: 'danger',
        okTitle: this.trans('app.delete'),
        cancelTitle: this.trans('app.cancel'),
      })
          .then(value => {
            let method = 'remove' + this.editMode.charAt(0).toUpperCase() + this.editMode.slice(1);
            this[method]();
          })
          .catch(err => {
            // An error occurred
          })
    },
    prepareLayers() {
      let pipesLayer = this.createPipeLayer('path-layer', this.pipes);
      let guPointsLayer = this.createIconLayer('icon-layer-gu', this.guPoints, 'gu');
      let zuPointsLayer = this.createIconLayer('icon-layer-zu', this.zuPoints, 'zu');
      let wellPointsLayer = this.createIconLayer('icon-layer-well', this.wellPoints, 'well')

      this.layersIds = [
        'path-layer',
        'icon-layer-gu',
        'icon-layer-zu',
        'icon-layer-well'
      ];

      this.layers = [
        pipesLayer,
        guPointsLayer,
        zuPointsLayer,
        wellPointsLayer,
      ];
    },
    centerTo(point = null) {
      if (point == null) {
        return false;
      }

      //if point is id of gu
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
    async initMap() {
      await this.getPipes(this.gu);

      this.viewState = {
        latitude: this.mapCenter.latitude,
        longitude: this.mapCenter.longitude,
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
        accessToken: this.mapBoxToken
      });

      this.map.on('click', (e) => {
        this.mapClickHandle(e);
      });

      map.on('contextmenu', (e) => {
        this.handleContextmenu(e);
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
        this.layersIds.forEach((layerId) => {
          this.map.addLayer(new MapboxLayer({id: layerId, deck}));
        })

        // update the layers
        this.deck.setProps({
          layers: this.layers
        });
      });
    },
    mapClickHandle(e) {
      if (this.editMode && this.editMode != 'pipe') {
        this.objectData.lon = e.lngLat.lng;
        this.objectData.lat = e.lngLat.lat;

        this.$bvModal.show('object-modal');
      } else if (this.editMode == 'pipe' && this.pipeObject) {
        this.pipeObject.coordinates.push([e.lngLat.lng, e.lngLat.lat]);
        this.renderPipe();
      }
    },
    mapObjectClickHandle(info) {
      this.clickedObject = info;

      if (this.editMode == 'pipe') {
        //pipe end point
        if ((info.type == 'zu' || info.type == 'gu') && this.pipeObject) {
          this.pipeObject.coordinates.push(info.coordinate);

          if (info.type == 'gu') {
            this.pipeObject.gu_id = info.object.id;
          }

          if (info.type == 'zu') {
            this.pipeObject.zu_id = info.object.id;
            this.pipeObject.gu_id = info.object.gu_id;
          }

          this.renderPipe();
          this.$bvModal.show('object-modal');
        }
      }
    },
    renderPipe() {
      let layerId = 'path-layer-temp';
      let layerIndex = this.layers.findIndex(layer => layer.id == layerId);

      if (layerIndex != -1) {
        this.layers.splice(layerIndex, 1);
      }

      this.layers.push(this.createPipeLayer(layerId, [this.pipeObject]));
      this.addMapLayer(layerId);
    },
    removeTempPipeLayer() {
      let layerId = 'path-layer-temp';
      let layerIndex = this.layers.findIndex(layer => layer.id == layerId);

      if (layerIndex != -1) {
        this.layers.splice(layerIndex, 1);
      }

      this.updateLayers();

      let deck = this.deck;
      if (this.map.getLayer(layerId)) {
        this.map.removeLayer(layerId);
      }
    },
    getObjectName(type) {
      switch (type) {
        case 'gu':
          return this.trans('monitoring.gu')
          break;

        case 'zu':
          return this.trans('monitoring.zu')
          break;

        case 'well':
          return this.trans('monitoring.well_vinit')
          break;

        case 'pipe':
          return this.trans('monitoring.pipe')
          break;

        default:
          return ""
          break;
      }
    },
    getObjectMarker(type) {
      switch (type) {
        case 'gu':
          return {x: 0, y: 0, width: 24, height: 36, mask: true}
          break;

        case 'zu':
          return {x: 0, y: 0, width: 24, height: 36, mask: true}
          break;

        case 'well':
          return {x: 0, y: 0, width: 52, height: 48, mask: true}
          break;

        default:
          return {}
          break;
      }
    },
    showToast(message, title, variant) {
      this.$bvToast.toast(message, {
        title: title,
        variant: variant,
        solid: true
      });
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
