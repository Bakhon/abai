<template>
  <div class="structure-map">
    <SmallCatLoader v-show="loading" :loading="loading" />
    <div v-show="!loading" id="structural-map"></div>
  </div>
</template>

<script>
import L from "leaflet";
import "leaflet/dist/leaflet.css";
import SmallCatLoader from "../SmallCatLoader.vue";
import { getModelIsohypses, getModelWells } from "../../services/mapService";
import { downloadUserReport } from "../../services/templateService";
import { mapState, mapMutations } from "vuex";
import { eventBus } from "../../eventBus";

export default {
  name: "StructuralMap",
  components: {
    SmallCatLoader,
  },
  data() {
    return {
      map: null,
      loading: false,
      isohyps: {},
      wells: new L.featureGroup(),
      currentModelImage: null,
      currentModelBounds: null,
      imageOverlay: null,
      mapOptions: {
        doubleClickZoom: false,
        center: [47.78333, 67.76667],
        zoom: 5,
        attributionControl: false,
      },
    };
  },
  computed: {
    ...mapState("plastFluidsLocal", [
      "currentModel",
      "depthMultiplier",
      "isIsohypsShown",
      "isTileLayerShown",
    ]),
  },
  watch: {
    async currentModel(value) {
      try {
        const {
          id,
          start_latitude,
          end_latitude,
          start_longitude,
          end_longitude,
          image_id,
        } = value;
        this.loading = true;
        this.clearLayers();
        this.SET_MAX_DEPTH_MULTIPLIER(value.levels_count * 10);
        const postData = new FormData();
        postData.append("file_id", image_id);
        const image = await downloadUserReport(postData);
        const blob = new Blob([image.data], {
          type: "image/png",
        });
        this.currentModelImage = URL.createObjectURL(blob);
        this.currentModelBounds = [
          [start_latitude, start_longitude],
          [end_latitude, end_longitude],
        ];
        this.imageOverlay = L.imageOverlay(
          this.currentModelImage,
          this.currentModelBounds
        );
        const model = await getModelIsohypses({
          depth_multiplier: this.depthMultiplier,
          model_id: id,
        });
        this.addIsohypsLayers(model.isogyps);
        this.isTileLayerShown ? this.addTileLayer() : "";
        this.isIsohypsShown ? this.addIsohypsOnMap() : "";
        this.map.fitBounds(this.currentModelBounds);
      } catch (error) {
        alert(error);
      } finally {
        this.loading = false;
      }

      try {
        const wells = await getModelWells({ model_id: value.id });
        this.addWells(wells);
        this.map.on("zoomstart", () => {
          if (this.map.getZoom() >= 13) this.removeTooltips();
        });
        this.map.on("zoomend", () => {
          if (this.map.getZoom() >= 13) this.addTooltips();
        });
      } catch (error) {
        alert("ошибка при получении скважин");
      }
    },
  },
  methods: {
    ...mapMutations("plastFluidsLocal", ["SET_MAX_DEPTH_MULTIPLIER"]),
    addIsohypsLayers(isohyps) {
      for (let key in this.isohyps) {
        this.isohyps[key].clearLayers();
      }
      this.isohyps = {};
      isohyps.forEach((layer) => {
        const geoJson = {
          ...layer,
          type: "FeatureCollection",
          features: layer.lines,
        };
        delete geoJson.lines;
        this.isohyps[geoJson.level_number] = new L.featureGroup();
        L.geoJSON(geoJson, {
          onEachFeature: this.onEachFeature,
          style: {
            weight: 1,
            color: "#000",
            fillOpacity: 1,
          },
        });
      });
    },
    addIsohypsOnMap() {
      for (let key in this.isohyps) {
        this.isohyps[key].addTo(this.map);
      }
    },
    removeIsohyps() {
      for (let key in this.isohyps) {
        this.isohyps[key].remove();
      }
    },
    addTileLayer() {
      this.imageOverlay.addTo(this.map);
    },
    removeTileLayer() {
      this.imageOverlay.remove();
    },
    addWells(wells) {
      wells.forEach((well) => {
        const icon = L.divIcon({ className: "well-icon" });
        const wellMarker = L.marker([well.latitude, well.longitude], {
          icon,
          wellName: well.well,
        });
        this.wells.addLayer(wellMarker);
      });
      this.wells.addTo(this.map);
    },
    addTooltips() {
      this.wells.eachLayer((layer) =>
        layer.bindTooltip(layer.options.wellName, {
          permanent: true,
          className: "well-tooltip",
          opacity: 1,
          direction: "top",
        })
      );
    },
    removeTooltips() {
      this.wells.eachLayer((layer) => layer.unbindTooltip());
    },
    async handleMapChanges(data) {
      const { isTileLayerShown, depthMultiplier } = data;
      if (isTileLayerShown !== "remain")
        isTileLayerShown ? this.addTileLayer() : this.removeTileLayer();
      if (depthMultiplier !== "remain") await this.refreshModel();
      this.isIsohypsShown ? this.addIsohypsOnMap() : this.removeIsohyps();
    },
    async refreshModel() {
      const model = await getModelIsohypses({
        depth_multiplier: this.depthMultiplier,
        model_id: this.currentModel.id,
      });
      this.addIsohypsLayers(model.isogyps);
    },
    clearLayers() {
      for (let key in this.isohyps) {
        this.isohyps[key].clearLayers();
      }
      this.isohyps = {};
      this.wells.clearLayers();
      this.map.off();
      this.map.eachLayer((layer) => {
        this.map.removeLayer(layer);
      });
    },
    onEachFeature(feature, layer) {
      layer.bindTooltip(`-${feature.properties.level_depth.toFixed()} м.`, {
        sticky: true,
      });
      this.isohyps[feature.properties.level_number].addLayer(layer);
    },
    initMap() {
      this.map = L.map("structural-map", this.mapOptions);
    },
  },
  mounted() {
    this.initMap();
    eventBus.$on("apply-map-changes", (data) => this.handleMapChanges(data));
  },
  beforeDestroy() {
    if (this.map) {
      this.map.remove();
    }
  },
};
</script>

<style scoped>
.structure-map {
  display: flex;
  width: 100%;
  height: 100%;
  position: relative;
  background-color: #fff;
}

#structural-map {
  width: 100%;
  height: 100%;
  background: #fff;
}

#structural-map::v-deep .well-icon {
  width: 10px;
  height: 10px;
  background: radial-gradient(
    45.25% 44.82% at 50% 50%,
    #ffffff 0%,
    #ffffff 13.19%,
    #ffec08 100%
  );
  border: 1px solid #9e9e9e;
  border-radius: 50%;
}

#structural-map::v-deep .well-tooltip {
  text-decoration: underline;
  color: #333333;
  font-size: 16px;
  padding: 0;
  background-color: unset;
  border: none;
  box-shadow: none;
}

#structural-map::v-deep .leaflet-tooltip-left:before,
#structural-map::v-deep .leaflet-tooltip-right:before,
#structural-map::v-deep .leaflet-tooltip-top:before,
#structural-map::v-deep .leaflet-tooltip-bottom:before {
  display: none;
}

::-webkit-scrollbar {
  width: 4px;
}

::-webkit-scrollbar-track {
  background: #464646;
}

::-webkit-scrollbar-thumb {
  background: #656a8a;
}
</style>
