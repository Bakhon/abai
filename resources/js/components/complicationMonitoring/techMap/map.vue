<template>
  <div class="tech-map">
    <div class="tech-map__controls">
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

      <div class="tech-map__filters mt-15px">
        <v-select
            v-model="activeFilter"
            :options="mapFilters"
            :reduce="option => option.key"
            label="name"
            @input="filterChanged"
            :placeholder="trans('monitoring.map.select_filter')"
        >
        </v-select>
      </div>

      <div class="tech-map__datetime-picker mt-15px" v-show="activeFilter">
        <datetime
            type="date"
            v-model="selectedDate"
            input-class="form-control date"
            value-zone="Asia/Almaty"
            zone="Asia/Almaty"
            :format="{ year: 'numeric', month: 'long', day: 'numeric' }"
            :phrases="{ok: trans('app.choose'), cancel: trans('app.cancel')}"
            :week-start="1"
            @input="applyFilter"
            auto
        >
        </datetime>
      </div>

      <div class="tech-map__filter_input mt-15px" v-if="activeFilter == 'pressure' || activeFilter == 'temperature'">
        <b-form-input
            v-model="referentValue"
            @input="mapRedraw"
            type="number"
            :placeholder="trans('monitoring.map.referent_value')"></b-form-input>
      </div>
    </div>

    <map-legend :variant="mapColorsMode"/>

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

      <object-form
          v-if="editMode != 'pipe' && editMode"
          ref="objectForm"
          :object="objectData"
          :editMode="editMode"
      />

      <map-pipe-form
          v-if="editMode == 'pipe' && pipeObject"
          ref="pipeForm"
          :pipe="pipeObject"
      />

      <template #modal-footer>
        <div class="w-100">
          <b-button
              variant="secondary"
              class="float-right ml-3"
              @click="cancelAddObject()"
          >
            {{ trans('app.cancel') }}
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

    <b-modal
        size="xl"
        header-bg-variant="main4"
        body-bg-variant="main1"
        header-text-variant="light"
        footer-bg-variant="main4"
        centered
        id="pipe-calc-modal"
        modal-class="long-modal"
        :title="trans('monitoring.pipe.detail-data') + ' ' + (selectedPipe ? selectedPipe.name : '')"
        :ok-only="true"
        @hide="resetSelectedObjects()"
    >
      <pipe-long-info
          :pipe="selectedPipe"
          :referentValue="parseInt(referentValue)"
          :activeFilter="activeFilter"

      />
    </b-modal>

    <b-modal
        size="xl"
        header-bg-variant="main4"
        body-bg-variant="main1"
        header-text-variant="light"
        footer-bg-variant="main4"
        centered
        id="omg-ngdu-form"
        modal-class="long-modal"
        :title="omgNgduFormModalTitle"
        :ok-only="true"
        @hide="resetSelectedObjects()"
    >
      <wellOmgNgduForm v-if="selectedWell" :well="selectedWell" />
      <guOmgNgduForm v-if="selectedGu" :gu="selectedGu" />
      <zuOmgNgduForm v-if="selectedZu" :zu="selectedZu" />
    </b-modal>

    <div v-show="false">
      <gu-tool-tip ref="guToolTip" :gu="objectHovered" />
      <well-tool-tip ref="wellToolTip" :well="objectHovered" />
      <pipe-tool-tip ref="pipeToolTip"  :pipe="pipeHovered" :paramKey="pipeHoveredParameter" />
    </div>
  </div>
</template>

<script>
import mapboxgl from "mapbox-gl";
import {Deck} from '@deck.gl/core';
import {PathLayer, IconLayer} from '@deck.gl/layers';
import {MapboxLayer} from '@deck.gl/mapbox';
import vSelect from "vue-select";
import mapLegend from "./mapLegend";
import objectForm from "./objectForm";
import mapPipeForm from "./mapPipeForm";
import {guMapState, guMapMutations, guMapActions, globalloadingMutations} from '@store/helpers';
import mapContextMenu from "./mapContextMenu";
import pipeColors from '~/json/pipe_colors.json'
import axios from "axios";
import moment from "moment";
import guToolTip from "./guToolTip";
import pipeToolTip from "./pipeToolTip";
import wellToolTip from "./wellToolTip";
import pipeLongInfo from "./pipeLongInfo";
import wellOmgNgduForm from "./wellOmgNgduForm";
import guOmgNgduForm from "./guOmgNgduForm"
import zuOmgNgduForm from "./zuOmgNgduForm"
import turfLength from '@turf/length';
import { lineString as turfLineString} from "@turf/helpers";

export default {
  name: "tech-map",
  components: {
    vSelect,
    mapPipeForm,
    mapContextMenu,
    objectForm,
    guToolTip,
    pipeToolTip,
    wellToolTip,
    mapLegend,
    pipeLongInfo,
    wellOmgNgduForm,
    guOmgNgduForm,
    zuOmgNgduForm
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
      isPipeEnd: false,
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
      mapColorsMode: 'default',
      selectedDate: moment().format('YYYY-MM-DD'),
      activeFilter: null,
      mapFilters: [
        {
          name: this.trans('monitoring.map.filters.speed-flow-filter'),
          key: 'speedFlow'
        },
        {
          name: this.trans('monitoring.map.filters.pressure'),
          key: 'pressure'
        },
        {
          name: this.trans('monitoring.map.filters.temperature'),
          key: 'temperature'
        },
      ],
      referentValue: 10,
      objectHovered: null,
      pipeHovered: null,
      pipeHoveredParameter: null,
      selectedPipe: null,
      selectedWell: null,
      selectedGu: null,
      selectedZu: null
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
    },
    omgNgduFormModalTitle () {
      switch (true) {
        case this.selectedWell != null:
          return this.trans('monitoring.well.enter-omg-ngdu-data');
          break;

        case this.selectedGu != null:
          return this.trans('monitoring.gu.enter-omg-ngdu-data');
          break;

        case this.selectedZu != null:
          return this.trans('monitoring.zu.enter-omg-ngdu-data');
          break;
      }
    }
  },
  methods: {
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
      'getElevationByCoords',
      'getHydroReverseCalc'
    ]),
    ...globalloadingMutations([
      'SET_LOADING'
    ]),
    resetSelectedObjects() {
      this.selectedPipe = null;
      this.selectedWell = null;
      this.selectedGu = null;
      this.selectedZu = null;
    },
    async initMap() {
      this.SET_LOADING(true);
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
        getTooltip:  ({object}) => {
          if (object) {
            if (object.last_omgngdu && object.last_omgngdu.well_id) {
              return {
                html: this.getObjectTooltipHtml(object, 'wellToolTip')
              }
            }

            if (object.cdng_id && object.last_omgngdu) {
              return {
                html: this.getObjectTooltipHtml(object, 'guToolTip')
              }
            }

            let paramKey = this.getPipeCalcKey(object);
            if (paramKey) {
              return {
                html: this.getPipeTooltipHtml(object, paramKey)
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

        this.SET_LOADING(false);
      });
    },
    getPipeCalcKey (pipe) {
      let keys = [
          'last_hydro_calc',
          'last_reverse_calc',
          'hydro_calc',
          'reverse_calc'
      ];

      for (let key of keys) {
        if (pipe[key]) {
          return key;
        }
      }

      return null;
    },
    getObjectTooltipHtml(object, type){
      this.objectHovered = object;

      return this.$refs[type].$el.outerHTML;
    },
    getPipeTooltipHtml(pipe, paramKey) {
      this.pipeHovered = pipe;
      this.pipeHoveredParameter = paramKey;

      return this.$refs.pipeToolTip.$el.outerHTML;
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

        let lastCoords = this.pipeObject.coords[this.pipeObject.coords.length - 1];

        let lastCoordsLonLat = [
          lastCoords.lon,
          lastCoords.lat
        ];

        let currentCoordsLonLat = [
          e.lngLat.lng,
          e.lngLat.lat
        ];

        let distance = this.calculateDistance(lastCoordsLonLat, currentCoordsLonLat) + lastCoords.m_distance;

        if (!this.isPipeEnd) {
          this.pipeObject.coords.push({
            lat: e.lngLat.lat,
            lon: e.lngLat.lng,
            elevation,
            h_distance: distance,
            m_distance: distance
          });

          this.renderPipe();
        }
      }
    },
    calculateDistance(lastCoords, currentCoords) {
      let line = turfLineString([lastCoords ,currentCoords]);
      return turfLength(line, {units: 'kilometers'}) * 1000;
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
        getColor: d => this.getPipeColor(d),
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
    getPipeColor(pipe) {
      if (this.activeFilter) {
        switch (this.activeFilter) {
          case "speedFlow":
            return this.getColorByFlowSpeed(pipe);
          case "pressure":
            return this.getColorByPressure(pipe);
          case "temperature":
            return this.getColorByTemperature(pipe);
        }
      }

      return pipeColors[this.mapColorsMode][pipe.between_points]
    },
    getColorByFlowSpeed(pipe) {
      let speed_flow = pipe.reverse_calc ? pipe.reverse_calc : (pipe.hydro_calc ? pipe.hydro_calc : null);
      switch (true) {
        case speed_flow == null:
          return pipeColors[this.mapColorsMode].no_data;
          break;

        case speed_flow.fluid_speed < 0.5:
          return pipeColors[this.mapColorsMode].danger;
          break;

        case speed_flow.fluid_speed >= 0.5 && speed_flow.fluid_speed < 0.9:
          return pipeColors[this.mapColorsMode].warning;
          break;

        case speed_flow.fluid_speed > 0.9:
          return pipeColors[this.mapColorsMode].good;
          break;
      }
    },
    getColorByPressure(pipe) {
      let pressure = pipe.hydro_calc ? pipe.hydro_calc : null;
      switch (true) {
        case pressure == null:
          return pipeColors[this.mapColorsMode].no_data;

        case pressure.press_start >= this.referentValue || pressure.press_end >= this.referentValue:
          return pipeColors[this.mapColorsMode].danger;

        default:
          return pipeColors[this.mapColorsMode].good;
      }
    },
    getColorByTemperature(pipe) {
      let temperature = pipe.hydro_calc ? pipe.hydro_calc.temperature_end : null;
      switch (true) {
        case temperature == null:
          return pipeColors[this.mapColorsMode].no_data;

        case temperature <= this.referentValue:
          return pipeColors[this.mapColorsMode].danger;

        default:
          return pipeColors[this.mapColorsMode].good;
      }
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
    onRedirect(option) {
      let url = this.localeUrl("/monitor/" + option.mapObject.object.id);
      window.location.href = url;
    },
    onCreate(option) {
      //pipe start point
      if (option.editMode == 'pipe') {
        this.startNewPipe(option);
      } else {
        this.mapClickHandle(option);
      }
    },
    startNewPipe (option) {
      this.pipeObject = {
        id: null,
        between_points: option.mapObject.type == 'zu' ? 'zu-gu' : 'well-zu',
        name: '',
        coords: [],
        start_point: option.mapObject.object.name
      };

      if (option.mapObject.type == 'zu') {
        this.pipeObject.zu_id = option.mapObject.object.id;
      }

      if (option.mapObject.type == 'well') {
        this.pipeObject.well_id = option.mapObject.object.id;
      }

      this.pipeObject.coords.push({
        lat: option.mapObject.object.lat,
        lon: option.mapObject.object.lon,
        elevation: option.mapObject.object.elevation,
        h_distance: 0,
        m_distance: 0
      });

      this.renderPipe();
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
    onShowDetailInfo(option) {
      this.selectedPipe = option.mapObject.object;
      this.$bvModal.show('pipe-calc-modal');
    },
    onShowOmgNgduWellForm(option) {
      this.selectedWell = option.mapObject.object;
      this.$bvModal.show('omg-ngdu-form');
    },
    onShowOmgNgduGuForm(option) {
      this.selectedGu = option.mapObject.object;
      this.$bvModal.show('omg-ngdu-form');
    },
    onShowOmgNgduZuForm(option) {
      this.selectedZu = option.mapObject.object;
      this.$bvModal.show('omg-ngdu-form');
    },
    optionClicked(option) {
      this.editMode = option.editMode;
      this.formType = option.type;

      let method = 'on' + option.type.charAt(0).toUpperCase() + option.type.slice(1);
      this[method](option);
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
      this.editMode = null;

      this.objectData = {
        id: null,
        name: '',
        lat: null,
        lon: null
      }

      this.pipeObject = null;
      this.isPipeEnd = false;
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
      if (this.isInvalid()) {
        return false;
      }

      let method = (this.pipeObject != null && this.pipeObject.id)
      || (this.objectData != null && this.objectData.id) ? 'edit' : 'add';

      method += this.editMode.charAt(0).toUpperCase() + this.editMode.slice(1);
      this[method]();
    },
    isInvalid () {
      let form = this.editMode == 'pipe' ? 'pipeForm' : 'objectForm';
      return this.$refs[form].validate();
    },
    async addGu() {
      this.SET_LOADING(true);
      let result = await this.storeGu(this.objectData);
      this.SET_LOADING(false);
      let message = '';

      if (result.status == 'success') {
        let layerId = 'icon-layer-gu';
        this.gu = result.gu;
        this.$bvModal.hide('object-modal');

        this.layerRedraw(layerId, 'gu', this.guPoints);
        this.centerTo(this.gu);
        this.resetForm();

        message = this.trans('monitoring.gu.gu') + ' ' + this.trans('app.added');
      } else {
        message = result.message;
      }

      let variant = result.status == 'success' ? 'success' : 'danger';
      this.showToast(message, this.trans('app.' + result.status), variant);
    },
    async addZu() {
      this.SET_LOADING(true);
      let result = await this.storeZu(this.objectData);
      this.SET_LOADING(false);
      let message = '';

      if (result.status == 'success') {
        let layerId = 'icon-layer-zu';
        this.$bvModal.hide('object-modal');

        this.layerRedraw(layerId, 'zu', this.zuPoints);
        this.centerTo(result.zu);
        this.resetForm();
        message = this.trans('monitoring.zu.zu') + ' ' + this.trans('app.added');
      } else {
        message = result.message;
      }

      let variant = result.status == 'success' ? 'success' : 'danger';
      this.showToast(message, this.trans('app.' + result.status), variant);
    },
    async addWell() {
      this.SET_LOADING(true);
      let result = await this.storeWell(this.objectData);
      this.SET_LOADING(false);
      let message = '';

      if (result.status == 'success') {
        let layerId = 'icon-layer-well';
        this.$bvModal.hide('object-modal');

        this.layerRedraw(layerId, 'well', this.wellPoints);
        this.centerTo(result.well);
        this.resetForm();
        message = this.trans('monitoring.well.added');
      } else {
        message = result.message;
      }

      let variant = result.status == 'success' ? 'success' : 'danger';
      this.showToast(message, this.trans('app.' + result.status), variant);
    },
    async addPipe() {
      this.SET_LOADING(true);
      let result = await this.storePipe();
      this.SET_LOADING(false);
      let message = '';

      if (result.status == 'success') {
        this.$bvModal.hide('object-modal');
        this.resetForm();
        this.removeTempPipeLayer();
        this.layerRedraw('path-layer', 'pipe', this.pipes);
        message = this.trans('monitoring.pipe.pipe') + ' ' + this.trans('app.added');
      } else {
        message = result.message;
      }

      let variant = result.status == 'success' ? 'success' : 'danger';
      this.showToast(message, this.trans('app.' + result.status), variant);
    },
    async storePipe() {
      this.SET_LOADING(true);
      return this.axios.post(this.localeUrl("/tech-map/pipe"), {pipe: this.pipeObject}).then((response) => {
        if (response.data.status == 'success') {
          this.pipes.push(response.data.pipe);
        }

        this.SET_LOADING(false);

        return response.data;
      });
    },
    async editGu() {
      this.SET_LOADING(true);
      let result = await this.updateGu(this.objectData);
      this.SET_LOADING(false);
      let message = '';

      if (result.status == 'success') {
        this.gu = result.gu;
        this.$bvModal.hide('object-modal');
        let layerId = 'icon-layer-gu';

        this.layerRedraw(layerId, 'gu', this.guPoints);
        this.centerTo(this.gu);
        this.resetForm();

        message = this.trans('monitoring.gu.gu') + ' ' + this.trans('app.updated');
      } else {
        message = result.message;
      }

      let variant = result.status == 'success' ? 'success' : 'danger';
      this.showToast(message, this.trans('app.' + result.status), variant);
    },
    async editZu() {
      this.SET_LOADING(true);
      let result = await this.updateZu(this.objectData);
      this.SET_LOADING(false);
      let message = '';

      if (result.status == 'success') {
        let layerId = 'icon-layer-zu';
        this.$bvModal.hide('object-modal');

        this.layerRedraw(layerId, 'zu', this.zuPoints);
        this.centerTo(this.objectData);
        this.resetForm();

        message = this.trans('monitoring.zu.zu') + ' ' + this.trans('app.updated');
      } else {
        message = result.message;
      }

      let variant = result.status == 'success' ? 'success' : 'danger';
      this.showToast(message, this.trans('app.' + result.status), variant);
    },
    async editWell() {
      this.SET_LOADING(true);
      let result = await this.updateWell(this.objectData);
      this.SET_LOADING(false);
      let message = '';

      if (result.status == 'success') {
        let layerId = 'icon-layer-well';
        this.$bvModal.hide('object-modal');

        this.layerRedraw(layerId, 'well', this.wellPoints);
        this.centerTo(this.objectData);
        this.resetForm();

        message = this.trans('monitoring.well.updated');
      } else {
        message = result.message;
      }

      let variant = result.status == 'success' ? 'success' : 'danger';
      this.showToast(message, this.trans('app.' + result.status), variant);
    },
    async editPipe() {
      this.SET_LOADING(true);
      let result = await this.updatePipe();
      this.SET_LOADING(false);
      let message = '';

      if (result.status == 'success') {
        this.$bvModal.hide('object-modal');
        this.layerRedraw('path-layer', 'pipe', this.pipes);
        this.resetForm();

        message = this.trans('monitoring.pipe.updated');
      } else {
        message = result.message;
      }

      let variant = result.status == 'success' ? 'success' : 'danger';
      this.showToast(message, this.trans('app.' + result.status), variant);
    },
    async updatePipe() {
      this.SET_LOADING(true);
      return this.axios.put(this.localeUrl("/tech-map/pipe/" + this.pipeObject.id), {pipe: this.pipeObject}).then((response) => {
        if (response.data.status == 'success') {
          let pipeIndex = this.pipes.findIndex((pipeItem) => {
            return pipeItem.id == this.pipeObject.id;
          });
          this.$set(this.pipes, pipeIndex, response.data.pipe);
        }

        this.SET_LOADING(false);
        return response.data;
      });
    },
    async removeGu() {
      this.SET_LOADING(true);
      let result = await this.deleteGu(this.objectData);
      this.SET_LOADING(false);
      let message = '';

      if (result.status == 'success') {
        this.gu = null;

        let layerId = 'icon-layer-gu';
        this.resetForm();
        this.layerRedraw(layerId, 'gu', this.guPoints);

        message = this.trans('monitoring.gu.deleted');
      } else {
        message = result.message;
      }

      let variant = result.status == 'success' ? 'success' : 'danger';
      this.showToast(message, this.trans('app.' + result.status), variant);
    },
    async removeZu() {
      this.SET_LOADING(true);
      let result = await this.deleteZu(this.objectData);
      this.SET_LOADING(false);
      let message = '';

      if (result.status == 'success') {
        let layerId = 'icon-layer-zu';

        this.resetForm();
        this.layerRedraw(layerId, 'zu', this.zuPoints);

        message = this.trans('monitoring.zu.deleted');
      } else {
        message = result.message;
      }

      let variant = result.status == 'success' ? 'success' : 'danger';
      this.showToast(message, this.trans('app.' + result.status), variant);
    },
    async removeWell() {
      this.SET_LOADING(true);
      let result = await this.deleteWell(this.objectData);
      this.SET_LOADING(false);
      let message = '';

      if (result.status == 'success') {
        let layerId = 'icon-layer-well';

        this.resetForm();
        this.layerRedraw(layerId, 'well', this.wellPoints);

        message = this.trans('monitoring.well.deleted');
      } else {
        message = result.message;
      }

      let variant = result.status == 'success' ? 'success' : 'danger';
      this.showToast(message, this.trans('app.' + result.status), variant);
    },
    async removePipe() {
      this.SET_LOADING(true);
      let result = await this.deletePipe();
      this.SET_LOADING(false);
      let message = '';

      if (result.status == 'success') {
        this.layerRedraw('path-layer', 'pipe', this.pipes);
        this.resetForm();

        message = this.trans('monitoring.pipe.deleted');
      } else {
        message = result.message;
      }

      let variant = result.status == 'success' ? 'success' : 'danger';
      this.showToast(message, this.trans('app.' + result.status), variant);
    },
    async deletePipe() {
      this.SET_LOADING(true);
      return this.axios.delete(this.localeUrl("/tech-map/pipe/" + this.pipeObject.id))
          .then((response) => {
            if (response.data.status == 'success') {
              this.pipes.splice(this.pipeObject.index, 1);
            }

            this.SET_LOADING(false);
            return response.data;
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
        this.isPipeEnd = true;
        if ((info.type == 'zu' || info.type == 'gu') && this.pipeObject) {
          let lastCoords = this.pipeObject.coords[this.pipeObject.coords.length - 1];

          let lastCoordsLonLat = [
            lastCoords.lon,
            lastCoords.lat
          ];

          let currentCoordsLonLat = [
            info.object.lon,
            info.object.lat
          ];

          let distance = this.calculateDistance(lastCoordsLonLat, currentCoordsLonLat) + lastCoords.m_distance;

          this.pipeObject.coords.push({
            lat: info.object.lat,
            lon: info.object.lon,
            elevation: info.object.elevation,
            h_distance: distance,
            m_distance: distance
          });

          if (info.type == 'gu') {
            this.pipeObject.gu_id = info.object.id;
          }

          if (info.type == 'zu') {
            this.pipeObject.zu_id = info.object.id;
            this.pipeObject.gu_id = info.object.gu_id;
          }

          this.pipeObject.end_point =  info.object.name;
          this.pipeObject.ngdu_id = info.object.ngdu_id;
          this.pipeObject.name = this.pipeObject.start_point + '-' + this.pipeObject.end_point;

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
    formatDate(date) {
      if (!date) return null
      return moment.parseZone(date).format('YYYY-MM-DD')
    },
    async applyFilter() {
      switch (this.activeFilter) {
        case 'speedFlow':
        case 'pressure':
        case 'temperature':
          this.SET_LOADING(true);
          this.pipes = await this.getHydroReverseCalc(this.formatDate(this.selectedDate));
          this.mapRedraw();
          this.SET_LOADING(false);
          break;

        default:
          this.mapColorsMode = 'default';
          return false;
      }
    },
    async filterChanged() {
      this.mapColorsMode = this.activeFilter;

      switch (this.activeFilter) {
        case 'pressure':
          this.referentValue = 10;
          break;

        case 'temperature':
          this.referentValue = 30;
          break;

        case null:
          this.mapColorsMode = 'default';
          break;
      }

      this.mapRedraw();
    },
    mapRedraw() {
      this.layerRedraw('path-layer', 'pipe', this.pipes);
      this.layerRedraw('icon-layer-well', 'well', this.wellPoints);
      this.layerRedraw('icon-layer-zu', 'zu', this.zuPoints);
      this.layerRedraw('icon-layer-gu', 'gu', this.guPoints);
    }
  }
}
</script>

<style>
.long-modal .modal-dialog {
  max-width: calc(100vw - 114px);
  left: 28.5px;
}
</style>

<style lang="scss" scoped>
h1 {
  color: #fff;
}

.tech-map {
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

  &__datetime-picker, &__filter_input {
    min-width: 260px;
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
