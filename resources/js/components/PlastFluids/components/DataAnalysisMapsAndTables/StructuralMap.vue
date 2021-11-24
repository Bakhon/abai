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
import {
  getModelIsohypses,
  getModelWells,
  getModelWellsProperties,
} from "../../services/mapService";
import { convertToFormData } from "../../helpers";
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
      allWellLayers: new L.featureGroup(),
      deepWellLayers: new L.featureGroup(),
      recombinedWellLayers: new L.featureGroup(),
      wells: [],
      wellsProperties: [],
      allWells: [],
      deepWells: [],
      recombinedWells: [],
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
    ...mapState("plastFluids", [
      "currentSubsoilField",
      "currentSubsoilHorizon",
    ]),
    ...mapState("plastFluidsLocal", [
      "currentBlocks",
      "currentModel",
      "depthMultiplier",
      "isIsohypsShown",
      "isTileLayerShown",
      "selectedWellsType",
      "selectedFluidProperty",
    ]),
  },
  watch: {
    async currentModel(value) {
      if (value.id) {
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
          this.getWellsProperties();
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
          this.wells = await getModelWells({ model_id: value.id });
          this.setAllWells();
          this.SET_SELECTED_WELLS_TYPE(["all"]);
        } catch (error) {
          alert("ошибка при получении скважин");
        }
      } else {
        this.map.setZoom(5);
        this.clearLayers();
      }
    },
    allWells(wells) {
      this.deepWells = wells.filter((well) => well.deep === 1);
      this.recombinedWells = wells.filter(
        (well) => well.recombined === 1 && well.deep === 0
      );
      this.handleWells();
    },
    async selectedWellsType() {
      this.removeWells();
      this.addWellsOnMap();
      this.closeWellNameTooltips();
      this.openWellNameTooltips();
    },
    selectedFluidProperty(property) {
      property.length
        ? this.addFluidProperty(property[0])
        : this.removeFluidProperty();
    },
    currentSubsoilField() {
      this.SET_CURRENT_MODEL({});
    },
    async currentSubsoilHorizon(value) {
      const horizonIDs = value.map((horizon) => horizon.horizon_id);
      if (horizonIDs.includes(this.currentModel.horizon_id)) {
        await this.getWellsProperties();
        this.setAllWells();
      } else {
        this.SET_CURRENT_MODEL({});
      }
    },
    async currentBlocks() {
      await this.getWellsProperties();
      this.setAllWells();
    },
  },
  methods: {
    ...mapMutations("plastFluidsLocal", [
      "SET_CURRENT_MODEL",
      "SET_MAX_DEPTH_MULTIPLIER",
      "SET_SELECTED_WELLS_TYPE",
    ]),
    setAllWells() {
      this.allWells = this.wells.map((well) => {
        let wellProperty = this.wellsProperties.find(
          (wellProperty) => well.well_id === wellProperty.well_id
        );
        wellProperty =
          wellProperty && wellProperty.well_id
            ? {
                isSampleTaken: true,
                ...wellProperty,
              }
            : { isSampleTaken: false };
        return { ...wellProperty, ...well };
      });
    },
    async getWellsProperties() {
      let horizonIDs = "None";
      let blockIDs = "None";
      if (this.currentSubsoilHorizon.length)
        horizonIDs = this.currentSubsoilHorizon.map(
          (horizon) => horizon.horizon_id
        );

      if (this.currentBlocks.length)
        blockIDs = this.currentBlocks.map((block) => block.block_id);
      const postData = convertToFormData({
        field_id: this.currentSubsoilField[0].field_id,
        horizons: horizonIDs,
        blocks: blockIDs,
      });
      this.wellsProperties = await getModelWellsProperties(postData);
    },
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
    getWellIconClassNames(filterSample) {
      return `well-icon ${
        filterSample === "all"
          ? "common-well"
          : filterSample === "deep"
          ? "deep-well"
          : "recombined-well"
      }`;
    },
    addWellsLayers(wells, filterSample) {
      wells.forEach((well) => {
        const icon = L.divIcon({
          className: this.getWellIconClassNames(filterSample),
        });
        const wellMarker = L.marker([well.latitude, well.longitude], {
          icon,
          ...well,
        });
        this[filterSample + "WellLayers"].addLayer(wellMarker);
      });
    },
    handleWells() {
      this.clearWellLayers();
      this.removeWellNameTooltips();
      this.map.off("zoomstart", this.closeWellNameTooltips);
      this.map.off("zoomend", this.openWellNameTooltips);
      ["all", "deep", "recombined"].forEach((type) => {
        this.addWellsLayers(this[type + "Wells"], type);
      });
      this.addWellNameTooltips();
      this.closeWellNameTooltips();
      this.openWellNameTooltips();
      this.map.on("zoomstart", this.closeWellNameTooltips);
      this.map.on("zoomend", this.openWellNameTooltips);
    },
    addWellsOnMap() {
      this.selectedWellsType.forEach((type) =>
        this[type + "WellLayers"].addTo(this.map)
      );
    },
    removeWells() {
      ["all", "deep", "recombined"].forEach((type) =>
        !this.selectedWellsType.includes(type)
          ? this[type + "WellLayers"].remove()
          : ""
      );
    },
    addWellNameTooltips() {
      ["all", "deep", "recombined"].forEach((type) =>
        this[type + "WellLayers"].eachLayer((layer) =>
          layer.bindTooltip(layer.options.well, {
            permanent: true,
            className: "well-tooltip",
            opacity: 1,
            direction: "top",
          })
        )
      );
    },
    removeWellNameTooltips() {
      ["all", "deep", "recombined"].forEach((type) =>
        this[type + "WellLayers"].eachLayer((layer) => layer.unbindTooltip())
      );
    },
    openWellNameTooltips() {
      if (this.map.getZoom() >= 13)
        this.selectedWellsType.forEach((type) =>
          this[type + "WellLayers"].eachLayer((layer) => layer.openTooltip())
        );
    },
    closeWellNameTooltips() {
      this.selectedWellsType.forEach((type) =>
        this[type + "WellLayers"].eachLayer((layer) => layer.closeTooltip())
      );
    },
    getProperty(options, property) {
      if (options[property]) {
        return options[property].toFixed(
          property === "reservoir_fluid_viscosity" ? 1 : 0
        );
      } else {
        return (
          options["min_" + property].toFixed(
            property === "reservoir_fluid_viscosity" ? 1 : 0
          ) +
          " - " +
          options["max_" + property].toFixed(
            property === "reservoir_fluid_viscosity" ? 1 : 0
          )
        );
      }
    },
    addFluidProperty(property) {
      ["all", "deep", "recombined"].forEach((type) =>
        this[type + "WellLayers"].eachLayer((layer) => {
          if (layer.options.isSampleTaken) {
            const div = document.createElement("div");
            const wellTitle = document.createElement("p");
            const wellProperty = document.createElement("p");
            wellTitle.appendChild(document.createTextNode(layer.options.well));
            wellProperty.appendChild(
              document.createTextNode(
                `${this.trans(
                  `plast_fluids.structural_map_${property}`
                )}: ${this.getProperty(layer.options, property)}`
              )
            );
            div.append(wellTitle, wellProperty);
            layer.setTooltipContent(div);
          }
        })
      );
    },
    removeFluidProperty() {
      ["all", "deep", "recombined"].forEach((type) => {
        this[type + "WellLayers"].eachLayer((layer) => {
          if (layer.options.isSampleTaken) {
            layer.setTooltipContent(layer.options.well);
          }
        });
      });
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
    clearWellLayers() {
      this.allWellLayers.clearLayers();
      this.deepWellLayers.clearLayers();
      this.recombinedWellLayers.clearLayers();
    },
    clearLayers() {
      for (let key in this.isohyps) {
        this.isohyps[key].clearLayers();
      }
      this.isohyps = {};
      this.clearWellLayers();
      this.wells = [];
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
  border: 1px solid #9e9e9e;
  border-radius: 50%;
}

#structural-map::v-deep .common-well {
  z-index: 100 !important;
  background: radial-gradient(
    45.25% 44.82% at 50% 50%,
    #ffffff 0%,
    #ffffff 13.19%,
    #ffec08 100%
  );
}

#structural-map::v-deep .deep-well {
  background: radial-gradient(
    45.25% 44.82% at 50% 50%,
    #ffffff 0%,
    #ffffff 13.19%,
    red 100%
  );
}

#structural-map::v-deep .recombined-well {
  background: radial-gradient(
    45.25% 44.82% at 50% 50%,
    #ffffff 0%,
    #ffffff 13.19%,
    blue 100%
  );
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

#structural-map::v-deep .well-tooltip > div > p {
  margin: 0;
}

#structural-map::v-deep .well-tooltip > div > p:nth-of-type(1) {
  text-align: center;
}

#structural-map::v-deep .well-tooltip > div > p:nth-of-type(2) {
  font-size: 14px;
}

#structural-map::v-deep .well-property-tooltip {
  color: #333333;
  font-size: 12px;
  padding: 5px;
  background-color: #fff;
  border: 1px solid #333333;
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
