<template>
  <div class="gu-map">
    <div class="gu-map__controls">
      <h1>{{ trans('monitoring.map.title') }}</h1>
      <div v-if="guPoints" class="d-flex">
        <v-select
            v-model="gu"
            @input="centerTo"
            :options="guPoints"
            :reduce="option => option.id"
            label="name"
            :placeholder="trans('monitoring.map.select_gu')"
        >
        </v-select>
      </div>
    </div>

    <div class="legend">
      <b-button v-b-toggle.legend variant="main2">Легенда</b-button>
      <b-collapse id="legend" class="mt-2">
        <b-card class="bg-main1 text-light">
          <div class="legend-item">
            <div class="icon-box bg-well-icon"></div>
            <span>Скважина</span>
          </div>
          <div class="legend-item">
            <div class="icon-box bg-zu-icon"></div>
            <span>ЗУ</span>
          </div>
          <div class="legend-item">
            <div class="icon-box bg-gu-icon"></div>
            <span>ГУ</span>
          </div>
          <div class="legend-item">
            <div class="color-box" :style="{backgroundColor: getColorByBetweenPoints('zu-gu')}"></div>
            <span>Труба ЗУ - ГУ</span>
          </div>
          <div class="legend-item">
            <div class="color-box" :style="{backgroundColor: getColorByBetweenPoints('well-zu')}"></div>
            <span>Труба Скважина - ЗУ</span>
          </div>
          <div class="legend-item">
            <div class="color-box" :style="{backgroundColor: getColorByBetweenPoints('fl-zu')}"></div>
            <span>Труба ФЛ - ЗУ</span>
          </div>
          <div class="legend-item">
            <div class="color-box" :style="{backgroundColor: getColorByBetweenPoints('fl-koll')}"></div>
            <span>Труба ФЛ - Коллектор</span>
          </div>
          <div class="legend-item">
            <div class="color-box" :style="{backgroundColor: getColorByBetweenPoints('gu-koll')}"></div>
            <span>Труба ГУ - Коллектор</span>
          </div>
          <div class="legend-item">
            <div class="color-box" :style="{backgroundColor: getColorByBetweenPoints('mgu-koll')}"></div>
            <span>Труба МГУ - Коллектор</span>
          </div>
          <div class="legend-item">
            <div class="color-box" :style="{backgroundColor: getColorByBetweenPoints('koll-bg')}"></div>
            <span>Труба Коллектор - БГ</span>
          </div>
          <div class="legend-item">
            <div class="color-box" :style="{backgroundColor: getColorByBetweenPoints('os-st')}"></div>
            <span>Труба ОС - СТ</span>
          </div>
          <div class="legend-item">
            <div class="color-box" :style="{backgroundColor: getColorByBetweenPoints('bg')}"></div>
            <span>Труба БГ</span>
          </div>
          <div class="legend-item">
            <div class="color-box" :style="{backgroundColor: getColorByBetweenPoints('bg-gu')}"></div>
            <span>Труба БГ - ГУ</span>
          </div>
          <div class="legend-item">
            <div class="color-box" :style="{backgroundColor: getColorByBetweenPoints('koll-koll')}"></div>
            <span>Труба Коллектор - Коллектор</span>
          </div>
          <div class="legend-item">
            <div class="color-box" :style="{backgroundColor: getColorByBetweenPoints('st-koll')}"></div>
            <span>Труба СТ - Коллектор</span>
          </div>
          <div class="legend-item">
            <div class="color-box" :style="{backgroundColor: getColorByBetweenPoints('spt-koll')}"></div>
            <span>Труба СПТ - Коллектор</span>
          </div>

        </b-card>
      </b-collapse>
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
        :title="modalTitle">

      <map-gu-form :gu="objectData" v-if="editMode == 'gu'"></map-gu-form>
      <map-zu-form :zu="objectData" v-if="editMode == 'zu'"></map-zu-form>
      <map-well-form :well="objectData" v-if="editMode == 'well'"></map-well-form>
      <map-pipe-form :pipe="pipeObject" v-if="editMode == 'pipe' && pipeObject"></map-pipe-form>

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
import pipeColors from '~/json/pipe_colors.json'
import axios from "axios";


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
      formType: 'create',
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
      pipes: [],
      mapColorsMode: 'default'
    };
  },
  created() {
    this.initMap();
  },
  computed: {
    ...guMapState([
      'zuPoints',
      'wellPoints',
      'guPoints',
      'guPointsIndexes',
      'mapCenter',
      'ngdus',
      'cdngs'
    ]),
    modalTitle() {
      let transCode = 'monitoring.' + this.editMode + '.' + this.formType + '_title';
      return this.trans(transCode);
    },
    okBtntext() {
      return this.formType == 'create' ? this.trans('app.create') : this.trans('app.update')
    }
  },
  methods: {
    ...guMapMutations([]),
    ...guMapActions([
      'getMapData',
      'storeGu',
      'storeZu',
      'storeWell',
      'updateGu',
      'updateZu',
      'updateWell',
      'deleteGu',
      'deleteZu',
      'deleteWell',
      'getElevationByCoords'
    ]),
    async initMap() {
      this.pipes = await this.getMapData(this.gu);

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
        getTooltip: ({object}) => {
          if (object) {
            if (object.cdng_id && object.last_omgngdu) {
              let guParams = object.last_omgngdu;
              guParams.daily_water_production = (guParams.daily_fluid_production * guParams.bsw) / 100;
              guParams.name = object.name;

              return {
                html: this.getGuTooltipHtml(guParams)
              }
            }

            return object.name;
          }
        },
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
    getGuTooltipHtml(guParams) {
      return '<div class="params_block">' +
          '<p>' + guParams.name + '</p>' +
          '<p>' + this.trans('monitoring.gu.fields.date') + ': ' + guParams.date + '</p>' +
          '<p>' + this.trans('monitoring.gu.fields.daily_fluid_production') + ': ' + guParams.daily_fluid_production + ' ' + this.trans('measurements.m3/day') + '</p>' +
          '<p>' + this.trans('monitoring.gu.fields.daily_oil_production') + ': ' + guParams.daily_oil_production + ' ' + this.trans('measurements.m3/day') + '</p>' +
          '<p>' + this.trans('monitoring.gu.fields.daily_water_production') + ': ' + guParams.daily_water_production + ' ' + this.trans('measurements.m3/day') + '</p>' +
          '<p>' + this.trans('monitoring.gu.fields.bsw') + ': ' + guParams.bsw + this.trans('measurements.percent') + '</p>' +
          '<p>' + this.trans('monitoring.gu.fields.pump_discharge_pressure') + ': ' + guParams.pump_discharge_pressure + ' ' + this.trans('measurements.pressure_bar') + '</p>' +
          '<p>' + this.trans('monitoring.gu.fields.heater_output_temperature') + ': ' + guParams.heater_output_pressure + ' ' + this.trans('measurements.celsius') + '</p>' +
          '</div>';
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
    async mapClickHandle(e) {
      let elevation = await this.getElevationByCoords({
        lon: e.lngLat.lng,
        lat: e.lngLat.lat
      });

      if (this.editMode && this.editMode != 'pipe') {
        this.objectData.lon = e.lngLat.lng;
        this.objectData.lat = e.lngLat.lat;
        this.objectData.elevation = elevation;

        if (this.editMode == 'gu') {
          this.objectData.omgngdu = [];
        }

        this.$bvModal.show('object-modal');
      } else if (this.editMode == 'pipe' && this.pipeObject) {
        this.pipeObject.coords.push({
          lat: e.lngLat.lat,
          lon: e.lngLat.lng,
          elevation,
          h_distance: 0,
          m_distance: 0
        });
        this.renderPipe();
      }
    },
    handleContextmenu(event) {
      this.clickedObject = null;
      this.$refs.contextMenu.showMenu(event);
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
        getPosition: (d) => [
          parseFloat(d.lon.toString().replace(',', '.')),
          parseFloat(d.lat.toString().replace(',', '.'))
        ],
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
        getPath: d => {
          let path_coords = [];
          d.coords.forEach(coord => {
            path_coords.push([coord.lon, coord.lat]);
          });
          return path_coords;
        },
        getColor: d => pipeColors[this.mapColorsMode][d.between_points],
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
    addMapLayer(layerId) {
      this.updateLayers();

      let deck = this.deck;
      if (this.map.getLayer(layerId)) {
        this.map.removeLayer(layerId);
      }

      this.map.addLayer(new MapboxLayer({id: layerId, deck}));
      this.deck.setProps({layers: this.layers});
    },
    updateLayers() {
      let tempLayers = [];
      this.layers.forEach((layer) => {
        tempLayers.push(layer);
      });

      this.layers = tempLayers;

      this.deck.setProps({layers: this.layers});
    },
    onEdit(option) {
      if (option.editMode == 'pipe') {
        this.pipeObject = option.mapObject.object;
      }

      this.objectData = option.mapObject.object;
      this.objectData.index = option.mapObject.index;
      this.$bvModal.show('object-modal');
    },
    onCreate(option) {
      //pipe start point
      if (option.editMode == 'pipe') {
        this.pipeObject = {
          id: null,
          between_points: option.mapObject.type == 'zu' ? 'zu-gu' : 'well-zu',
          name: '',
          coords: [],
        };

        if (option.mapObject.type == 'zu') {
          this.pipeObject.zu_id = option.mapObject.object.id;
        }

        if (option.mapObject.type == 'well') {
          this.pipeObject.well_id = option.mapObject.object.id;
        }

        option.lngLat = {
          lng: parseFloat(option.mapObject.object.lon),
          lat: parseFloat(option.mapObject.object.lat)
        };
      }

      this.mapClickHandle(option);
    },
    onDelete(option) {
      if (option.editMode == 'pipe') {
        this.pipeObject = option.mapObject.object;
      }

      this.objectData = option.mapObject.object;
      this.objectData.index = option.mapObject.index;

      let title = this.trans('app.delete_confirm') + ' ' + this.getObjectName(this.editMode) + '?';
      this.confirmDelete(title);
    },
    optionClicked(option) {
      this.editMode = option.editMode;
      this.formType = option.type;

      let method = 'on' + option.type.charAt(0).toUpperCase() + option.type.slice(1);
      this[method](option);
    },
    getColorByBetweenPoints(between_points) {
      return this.colorArrayToRgb(pipeColors[this.mapColorsMode][between_points])
    },
    colorArrayToRgb(colorArr) {
      return 'rgb(' + colorArr[0] + ', ' + colorArr[1] + ', ' + colorArr[2] + ')';
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
      if (this.pipeObject) {
        let layerId = 'path-layer-temp';
        let layerIndex = this.layers.findIndex(layer => layer.id == layerId);

        if (layerIndex != -1) {
          this.layers.splice(layerIndex, 1);
        }

        if (this.map.getLayer(layerId)) {
          this.map.removeLayer(layerId);
        }
        this.updateLayers();
      }

      this.resetForm();
      this.$bvModal.hide('object-modal');
    },
    handlerFormSubmit() {
      let method = (this.pipeObject != null && this.pipeObject.id)
      || (this.objectData != null && this.objectData.id) ? 'edit' : 'add';

      method += this.editMode.charAt(0).toUpperCase() + this.editMode.slice(1);
      this[method]();
    },
    async addGu() {
      let gu = await this.storeGu(this.objectData);
      let layerId = 'icon-layer-gu';
      this.gu = gu;
      this.$bvModal.hide('object-modal');

      this.layerRedraw(layerId, 'gu', this.guPoints);
      this.centerTo(gu);
      this.resetForm();

      let $message = this.trans('monitoring.gu.gu') + ' ' + this.trans('app.added');
      this.showToast($message, this.trans('app.success'), 'success');
    },
    async addZu() {
      let zu = await this.storeZu(this.objectData);
      let layerId = 'icon-layer-zu';
      this.$bvModal.hide('object-modal');

      this.layerRedraw(layerId, 'zu', this.zuPoints);
      this.centerTo(zu);
      this.resetForm();

      let $message = this.trans('monitoring.zu.zu') + ' ' + this.trans('app.added');
      this.showToast($message, this.trans('app.success'), 'success');
    },
    async addWell() {
      let well = await this.storeWell(this.objectData);
      let layerId = 'icon-layer-well';
      this.$bvModal.hide('object-modal');

      this.layerRedraw(layerId, 'well', this.wellPoints);
      this.centerTo(well);
      this.resetForm();

      let $message = this.trans('monitoring.well.added');
      this.showToast($message, this.trans('app.success'), 'success');
    },
    async addPipe() {
      await this.storePipe();
      this.$bvModal.hide('object-modal');
      this.resetForm();
      this.removeTempPipeLayer();
      this.layerRedraw('path-layer', 'pipe', this.pipes);

      let $message = this.trans('monitoring.pipe.pipe') + ' ' + this.trans('app.added');
      this.showToast($message, this.trans('app.success'), 'success');
    },
    async storePipe() {
      return this.axios.post(this.localeUrl("/gu-map/pipe"), {pipe: this.pipeObject}).then((response) => {
        if (response.data.status == 'success') {
          this.pipes.push(response.data.pipe);
        } else {
          let $message = 'Error update Pipe in DB';
          this.showToast($message, this.trans('app.error'), 'danger');
        }
      });
    },
    async editGu() {
      this.gu = await this.updateGu(this.objectData);
      this.$bvModal.hide('object-modal');
      let layerId = 'icon-layer-gu';


      this.layerRedraw(layerId, 'gu', this.guPoints);
      this.centerTo(this.gu);
      this.resetForm();

      let $message = this.trans('monitoring.gu.gu') + ' ' + this.trans('app.updated');
      this.showToast($message, this.trans('app.success'), 'success');
    },
    async editZu() {
      let zu = await this.updateZu(this.objectData);
      let layerId = 'icon-layer-zu';
      this.$bvModal.hide('object-modal');

      this.layerRedraw(layerId, 'zu', this.zuPoints);
      this.centerTo(zu);
      this.resetForm();

      let $message = this.trans('monitoring.zu.zu') + ' ' + this.trans('app.updated');
      this.showToast($message, this.trans('app.success'), 'success');
    },
    async editWell() {
      let well = await this.updateWell(this.objectData);
      let layerId = 'icon-layer-well';
      this.$bvModal.hide('object-modal');

      this.layerRedraw(layerId, 'well', this.wellPoints);
      this.centerTo(well);
      this.resetForm();

      let $message = this.trans('monitoring.well.updated');
      this.showToast($message, this.trans('app.success'), 'success');
    },
    async editPipe() {
      await this.updatePipe();
      this.$bvModal.hide('object-modal');

      this.layerRedraw('path-layer', 'pipe', this.pipes);
      this.resetForm();

      let $message = this.trans('monitoring.pipe.updated');
      this.showToast($message, this.trans('app.success'), 'success');
    },
    async updatePipe() {
      return this.axios.put(this.localeUrl("/gu-map/pipe/" + this.pipeObject.id), {pipe: this.pipeObject}).then((response) => {
        if (response.data.status == 'success') {
          let pipeIndex = this.pipes.findIndex((pipeItem) => {
            return pipeItem.id == this.pipeObject.id;
          });
          this.$set(this.pipes, pipeIndex, response.data.pipe);
        } else {
          let $message = 'error update Pipe in DB';
          this.showToast($message, this.trans('app.error'), 'danger');
        }
      });
    },
    async removeGu() {
      let result = await this.deleteGu(this.objectData);
      if (result == 'success') {
        this.gu = null;

        let layerId = 'icon-layer-gu';
        this.resetForm();
        this.layerRedraw(layerId, 'gu', this.guPoints);

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
        this.layerRedraw(layerId, 'zu', this.zuPoints);

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
        this.layerRedraw(layerId, 'well', this.wellPoints);

        let $message = this.trans('monitoring.well.deleted');
        this.showToast($message, this.trans('app.success'), 'success');
      } else {
        let $message = this.trans('monitoring.well.deleting_error');
        this.showToast($message, this.trans('app.error'), 'danger');
      }
    },
    async removePipe() {
      let result = await this.deletePipe();

      if (result == 'success') {
        this.layerRedraw('path-layer', 'pipe', this.pipes);
        this.resetForm();

        let $message = this.trans('monitoring.pipe.deleted');
        this.showToast($message, this.trans('app.success'), 'success');
      } else {
        let $message = this.trans('monitoring.pipe.deleting_error');
        this.showToast($message, this.trans('app.error'), 'danger');
      }
    },
    async deletePipe() {
      return this.axios.delete(this.localeUrl("/gu-map/pipe/" + this.pipeObject.id))
          .then((response) => {
            if (response.data.status == 'success') {
              this.pipes.splice(this.pipeObject.index, 1);
              return response.data.status;
            } else {
              let $message = this.trans('Error in delete Pipe');
              this.showToast($message, this.trans('app.error'), 'danger');
            }
          });
    },
    layerRedraw(layerId, type, data) {
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
            if (value) {
              let method = 'remove' + this.editMode.charAt(0).toUpperCase() + this.editMode.slice(1);
              this[method]();
            } else {
              this.resetForm();
            }
          })
          .catch(err => {
            // An error occurred
          })
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

    async mapObjectClickHandle(info) {
      this.clickedObject = info;

      if (this.editMode == 'pipe') {

        //pipe end point
        if ((info.type == 'zu' || info.type == 'gu') && this.pipeObject) {
          let elevation = await this.getElevationByCoords({
            lat: info.coordinate[1],
            lon: info.coordinate[0],
          });

          this.pipeObject.coords.push({
            lat: info.coordinate[1],
            lon: info.coordinate[0],
            elevation,
            h_distance: 0,
            m_distance: 0
          });

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
          return this.trans('monitoring.gu.gu')
          break;

        case 'zu':
          return this.trans('monitoring.zu.zu')
          break;

        case 'well':
          return this.trans('monitoring.well_vinit')
          break;

        case 'pipe':
          return this.trans('monitoring.pipe.pipe')
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
    z-index: 20;
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

  .legend {
    position: relative;
    z-index: 10;
    max-width: 275px;
    padding: 15px 0 0 15px;

    .btn {
      width: 100%;
      border: 1px solid rgba(60, 60, 60, .26);
      border-radius: 5px;
      height: 40px;
    }

    .legend-item {
      display: flex;
      margin-bottom: 15px;

      .color-box {
        width: 20px;
        height: 20px;
      }

      span {
        margin-left: 15px;
      }

      &:last-child {
        margin-bottom: 0px;
      }
    }
  }

  .icon-box {
    width: 25px;
    height: 25px;
    background-size: 20px;
    background-position: 50% 50%;
    padding: 5px;
    background-color: white;
    background-repeat: no-repeat;
  }

  .bg-well-icon {
    background-image: url("/img/icons/well.png");
  }

  .bg-zu-icon {
    background-image: url("/img/icons/barrel.png");
    background-size: contain;
  }

  .bg-gu-icon {
    background-image: url("/img/icons/barrel.png");
    width: 30px;
    height: 30px;
    background-size: contain;
  }
}
</style>
