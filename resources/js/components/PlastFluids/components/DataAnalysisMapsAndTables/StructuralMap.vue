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
import { getIsohypsumModelCoords } from "../../services/mapService";
import { downloadUserReport } from "../../services/templateService";
import { mapState } from "vuex";

export default {
  name: "StructuralMap",
  components: {
    SmallCatLoader,
  },
  data() {
    return {
      map: null,
      loading: false,
      layers: {},
      mapOptions: {
        doubleClickZoom: false,
        center: [47.78333, 67.76667],
        zoom: 5,
      },
    };
  },
  computed: {
    ...mapState("plastFluidsLocal", ["currentModel"]),
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
        const postData = new FormData();
        postData.append("file_id", image_id);
        const image = await downloadUserReport(postData);
        const blob = new Blob([image.data], {
          type: "image/png",
        });
        const imageUrl = URL.createObjectURL(blob);
        const bounds = [
          [start_latitude, start_longitude],
          [end_latitude, end_longitude],
        ];
        L.imageOverlay(imageUrl, bounds).addTo(this.map);
        const model = await getIsohypsumModelCoords({
          depth_multiplier: 5,
          model_id: id,
        });
        model.isogyps.forEach((layer) => {
          const geoJson = {
            ...layer,
            type: "FeatureCollection",
            features: layer.lines,
          };
          delete geoJson.lines;
          this.layers[geoJson.level_number] = new L.featureGroup();
          L.geoJSON(geoJson, {
            onEachFeature: this.onEachFeature,
            style: {
              weight: 1,
              color: "#000",
              fillOpacity: 1,
            },
          });
          this.layers[geoJson.level_number].addTo(this.map);
        });
        this.addWells(model.wells);
        this.map.on("zoomstart", () => {
          if (this.map.getZoom() >= 13) this.removeTooltips();
        });
        this.map.on("zoomend", () => {
          if (this.map.getZoom() >= 13) this.addTooltips();
        });
        this.map.fitBounds(bounds);
      } catch (error) {
        alert(error);
      } finally {
        this.loading = false;
      }
    },
  },
  methods: {
    addWells(wells) {
      this.layers.wells = new L.featureGroup();
      wells.forEach((well) => {
        const icon = L.divIcon({ className: "well-icon" });
        const wellMarker = L.marker([well.latitude, well.longitude], {
          icon,
          wellName: well.well,
        });
        this.layers.wells.addLayer(wellMarker);
      });
      this.layers.wells.addTo(this.map);
    },
    addTooltips() {
      this.layers.wells.eachLayer((layer) =>
        layer.bindTooltip(layer.options.wellName, {
          permanent: true,
          className: "well-tooltip",
          opacity: 1,
          direction: "top",
        })
      );
    },
    removeTooltips() {
      this.layers.wells.eachLayer((layer) => layer.unbindTooltip());
    },
    clearLayers() {
      for (let key in this.layers) {
        this.layers[key].clearLayers();
      }
      this.layers = {};
      this.map.off();
      this.map.eachLayer((layer) => {
        this.map.removeLayer(layer);
      });
    },
    onEachFeature(feature, layer) {
      layer.bindTooltip(`-${feature.properties.level_depth.toFixed()} м.`, {
        sticky: true,
      });
      this.layers[feature.properties.level_number].addLayer(layer);
    },
    initMap() {
      this.map = L.map("structural-map", this.mapOptions);
    },
  },
  mounted() {
    this.initMap();
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
