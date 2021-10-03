<template>
  <div class="main-page-map">
    <div class="map-header">
      <p>Карта размещений нефтегазоносных провинций и областей</p>
      <div class="map-header-toolbar">
        <div class="toolbar-search">
          <div class="input-holder">
            <label for="main-page-map-search"
              ><img
                src="/img/PlastFluids/main-page-search.svg"
                alt="search for provinces"
            /></label>
            <div class="break"></div>
            <input type="text" id="main-page-map-search" placeholder="Поиск" />
          </div>
          <button class="toolbar-search-button">
            Поиск
          </button>
        </div>
        <img src="/img/PlastFluids/box-icon.svg" alt="" />
        <img src="/img/PlastFluids/openModal.svg" alt="open map fullscreen" />
      </div>
    </div>
    <div class="satelite-holder">
      <button v-if="currentScreen > 0" @click="currentScreen--">
        Назад
      </button>
      <button @click="addScale">
        <img src="/img/PlastFluids/satelite.svg" alt="" />
        <span>Спутник</span>
      </button>
    </div>
    <div id="map"></div>
  </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import L from "leaflet";
import "leaflet/dist/leaflet.css";
import {
  getInitialMapNPG,
  getMapDataByField,
  getMapGeoJSONCoords,
} from "../services/mapService";
import RK from "../plugins/rk_border";

export default {
  name: "OilMapKz",
  data() {
    return {
      map: null,
      province: undefined,
      currentProvince: undefined,
      currentScreen: 0,
      mapSettings: {
        scrollWheelZoom: false,
        dragging: false,
        doubleClickZoom: false,
        boxZoom: false,
        zoomControl: false,
        center: [47.78333, 67.76667],
        zoom: 5,
      },
    };
  },
  computed: {
    ...mapState("plastFluids", ["subsoils", "subsoilFields"]),
  },
  methods: {
    ...mapActions("plastFluids", [
      "UPDATE_CURRENT_SUBSOIL",
      "UPDATE_CURRENT_SUBSOIL_FIELD",
      "GET_SUBSOIL_FIELD_COUNTERS",
    ]),
    setSubsoilField() {
      const foundSubsoil = this.subsoils.find(
        (subsoil) => subsoil.owner_short_name === "КОА"
      );
      this.UPDATE_CURRENT_SUBSOIL(foundSubsoil).then((res) => {
        const foundField = this.subsoilFields.find(
          (field) => field.field_name === "Кожасай"
        );
        this.UPDATE_CURRENT_SUBSOIL_FIELD(foundField).then(() =>
          this.GET_SUBSOIL_FIELD_COUNTERS()
        );
      });
    },
    addScale() {
      // const baseLayers = {
      //   Mapbox: mapbox,
      //   OpenStreetMap: osm,
      // };

      // const overlays = {
      //   Marker: marker,
      //   Roads: roadsLayer,
      // };
      const littleton = L.marker([50, 45]).bindPopup("This is Littleton, CO."),
        denver = L.marker([56, 51]).bindPopup("This is Denver, CO."),
        aurora = L.marker([76, 54]).bindPopup("This is Aurora, CO."),
        golden = L.marker([86, 49]).bindPopup("This is Golden, CO.");
      var cities = L.layerGroup([littleton, denver, aurora, golden]);
      L.Util.setOptions(this.map, { zoom: 13 });
      if (this.map.zoom instanceof L.Handler) {
        this.map.zoom.enable();
      }
      // L.control.layers(baseLayers, overlays).addTo(this.map);
      L.control.scale().addTo(this.map);
    },
    async initMap() {
      const payload = new FormData();
      payload.append("geo_array", "1400");
      payload.append("geo_array", "1662");
      const response = await getMapGeoJSONCoords(payload);
      this.map = L.map("map", this.mapSettings);
      L.geoJson(RK, { style: { color: "#2D89DA", opacity: 0.5 } }).addTo(
        this.map
      );
      L.geoJson(response, {
        style: { fillColor: "#43487A", color: "#5c6090", fillOpacity: 1 },
      }).addTo(this.map);
    },
  },
  mounted() {
    this.$nextTick(() => this.initMap());
  },
  beforeDestroy() {
    if (this.map) {
      this.map.remove();
    }
  },
};
</script>

<style lang="scss" scoped src="./OilMapKzStyles.scss"></style>
