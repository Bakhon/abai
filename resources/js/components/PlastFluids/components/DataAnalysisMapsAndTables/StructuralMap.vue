<template>
  <div class="structure-map">
    <div id="structural-map"></div>
    <div class="legends-holder" v-if="isDataReady">
      <p>{{ legends[Object.keys(legends)[0]].depthLevel.toFixed() }} м.</p>
      <img
        @click.stop="isLegendsOpen = !isLegendsOpen"
        src="/img/PlastFluids/hslBar.jpg"
        alt="map legends"
      />
      <p>{{ legends[Object.keys(legends)[19]].depthLevel.toFixed() }} м.</p>
      <div
        class="legends"
        v-show="isLegendsOpen"
        v-click-outside="closeLegends"
      >
        <div
          class="legend"
          v-for="(legend, key) in legends"
          :key="key"
          :style="'background-color:' + legend.color"
        >
          <p>{{ legend.depthLevel.toFixed() }} метров</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import L from "leaflet";
import "leaflet/dist/leaflet.css";
import { getIsohypsumModelCoords } from "../../services/mapService";

export default {
  name: "StructuralMap",
  data() {
    return {
      map: null,
      layers: {},
      legends: {},
      levelCount: 20,
      model: 4,
      isDataReady: false,
      isLegendsOpen: false,
      mapOptions: {
        doubleClickZoom: false,
        center: [47.78333, 67.76667],
        zoom: 5,
      },
      maxPolygonLayer: {
        layerId: -1,
        layerLength: 0,
      },
    };
  },
  methods: {
    closeLegends() {
      this.isLegendsOpen = false;
    },
    generateHsl(length) {
      let palette = [];
      for (let i = length; i >= 1; i--) {
        palette.push(360 / i);
      }
      return palette;
    },
    onEachFeature(feature, layer) {
      this.layers[feature.properties.level_number].addLayer(layer);
    },
    async initMap() {
      this.map = L.map("structural-map", this.mapOptions);
      const model = await getIsohypsumModelCoords({
        levels_count: this.levelCount,
        model_id: this.model,
      });
      let colors = this.generateHsl(model.length);
      model.forEach((layer, index) => {
        const geoJson = {
          ...layer,
          type: "FeatureCollection",
          features: layer.lines,
        };
        delete geoJson.lines;
        const strokeColor = `hsl(${colors[index]}, 50%, 50%)`;
        this.layers[geoJson.level_number] = new L.featureGroup();
        this.legends[geoJson.level_number] = {
          color: strokeColor,
          depthLevel: geoJson.level_depth,
        };
        L.geoJSON(geoJson, {
          onEachFeature: this.onEachFeature,
          style: {
            weight: 1,
            fillColor: strokeColor,
            color: strokeColor,
            fillOpacity: 1,
          },
        });
        this.layers[geoJson.level_number].addTo(this.map);
        if (this.maxPolygonLayer.layerLength < geoJson.features.length) {
          this.maxPolygonLayer.layerId = geoJson.level_number;
          this.maxPolygonLayer.layerLength = geoJson.features.length;
        }
      });
      if (Object.keys(this.legends).length) this.isDataReady = true;
      this.map.fitBounds(this.layers[this.maxPolygonLayer.layerId].getBounds());
    },
  },
  mounted() {
    this.initMap();
  },
};
</script>

<style scoped>
.structure-map {
  display: flex;
  width: 100%;
  height: 100%;
  position: relative;
}

.legends-holder {
  position: absolute;
  right: 0;
  width: 50px;
  height: 100%;
  display: flex;
  flex-flow: column;
  align-items: center;
}

.legends-holder > img {
  height: calc(100% - 65px);
  cursor: pointer;
}

.legends-holder > p {
  height: 21px;
  margin: 0;
  color: darkred;
}

.legends {
  position: absolute;
  top: 21px;
  right: calc(100% + 5px);
  width: 150px;
  height: calc(100% - 65px);
  overflow: auto;
}

.legend {
  width: 100%;
  height: 20px;
  text-align: center;
}

.legend > p {
  margin: 0;
  font-size: 12px;
}

#structural-map {
  width: 100%;
  height: 100%;
  background: #c4c4c4;
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
