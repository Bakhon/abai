<template>
  <div class="main-page-map">
    <div class="map-header">
      <p>{{ trans("plast_fluids.oil_map") }}</p>
      <div class="map-header-toolbar">
        <div class="toolbar-search">
          <div class="input-holder">
            <label for="main-page-map-search"
              ><img
                src="/img/PlastFluids/main-page-search.svg"
                alt="search for provinces"
            /></label>
            <div class="break"></div>
            <input type="text" id="main-page-map-search" :placeholder="trans('plast_fluids.search')" />
          </div>
          <button class="toolbar-search-button">
            {{ trans("plast_fluids.search") }}
          </button>
        </div>
        <img src="/img/PlastFluids/box-icon.svg" alt="" />
        <img src="/img/PlastFluids/openModal.svg" alt="open map fullscreen" />
      </div>
    </div>
    <div class="satelite-holder">
      <button
        v-if="zoomLevel !== 'global'"
        @click="zoomToFeature({ target: 'previous' })"
      >
        {{ trans("plast_fluids.back") }}
      </button>
      <button>
        <img src="/img/PlastFluids/satelite.svg" alt="" />
        <span>{{ trans("plast_fluids.satelite") }}</span>
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
  getInitialMapNGP,
  getMapDataByField,
  getMapGeoJSONCoords,
} from "../services/mapService";
import RK from "../plugins/rk_border";

export default {
  name: "OilMapKz",
  data() {
    return {
      map: null,
      rk: null,
      prevZoomLevel: [],
      zoomLevel: "global",
      prevBounds: [],
      provinces: [],
      provinceChilds: {},
      currentProvinceChild: {},
      provinceChildsLayers: {},
      fields: new L.featureGroup(),
      colorPalette: [
        "#5970A8",
        "#804C6B",
        "#895D5D",
        "#487B65",
        "#938364",
        "#045a8d",
        "#023858",
      ],
      mapOptions: {
        dragging: false,
        doubleClickZoom: false,
        boxZoom: false,
        zoomControl: false,
        center: [47.78333, 67.76667],
        zoom: 5,
      },
      tooltipOptions: {
        permanent: true,
        direction: "center",
        className: "tooltip",
      },
    };
  },
  computed: {
    ...mapState("plastFluids", [
      "subsoils",
      "subsoilFields",
      "currentSubsoilField",
    ]),
    isGlobalZoom() {
      return this.zoomLevel === "global";
    },
  },
  watch: {
    currentSubsoilField: {
      handler(value) {
        if (value[0] && Object.values(this.fields._layers)) {
          this.setField();
        }
      },
      deep: true,
    },
  },
  methods: {
    ...mapActions("plastFluids", [
      "UPDATE_CURRENT_SUBSOIL",
      "UPDATE_CURRENT_SUBSOIL_FIELD",
      "GET_SUBSOIL_FIELD_COUNTERS",
    ]),
    async updateSubsoilField(e) {
      if (this.zoomLevel !== "FLD") return;
      let field;
      const subsoil = this.subsoils.find((subsoil) => {
        field = subsoil.fields.find(
          (field) => field.field_id === e.target.feature.properties.id
        );
        return field;
      });
      await this.UPDATE_CURRENT_SUBSOIL(subsoil);
      await this.UPDATE_CURRENT_SUBSOIL_FIELD(field);
    },
    setField() {
      const foundLayer = Object.values(this.fields._layers).find(
        (layer) =>
          layer.feature.properties.id === this.currentSubsoilField[0].field_id
      );
      if (foundLayer) {
        this.map.flyToBounds(foundLayer.getBounds(), {
          animate: true,
          duration: 0.5,
          easeLinearity: 1.0,
        });
        const foundLayerParent = this.provinceChilds[
          foundLayer.feature.properties.parent_id
        ];
        const foundLayerProvince = this.provinceChildsLayers[
          foundLayerParent.feature.properties.parent_id
        ];
        this.zoomLevel = "FLD";
        this.prevZoomLevel = ["global", "NGP", "NGR"];
        this.prevBounds = [
          this.rk.getBounds(),
          foundLayerProvince.getBounds(),
          foundLayerParent.getBounds(),
        ];
      }
    },
    bounds(prevZoomLevel, newBounds, prevBounds) {
      this.map.fitBounds(newBounds);
      this.zoomLevel =
        prevZoomLevel === "global"
          ? "NGP"
          : prevZoomLevel === "NGP"
          ? "NGR"
          : prevZoomLevel === "NGR"
          ? "FLD"
          : "";
      this.prevZoomLevel.push(prevZoomLevel);
      this.prevBounds.push(prevBounds);
    },
    zoomToFeature({ target }) {
      this.map.scrollWheelZoom.disable();
      if (target === "previous") {
        this.map.fitBounds(this.prevBounds.pop());
        this.zoomLevel = this.prevZoomLevel.pop();
        this.zoomLevel === "NGR" ? this.map.scrollWheelZoom.enable() : "";
        return;
      }
      const provinceBounds = this.provinceChildsLayers[
        target.feature.properties.parent_id
      ]?.getBounds();
      switch (this.zoomLevel) {
        case "global":
          this.bounds(this.zoomLevel, provinceBounds, this.rk.getBounds());
          break;
        case "NGP":
          this.bounds(this.zoomLevel, target.getBounds(), provinceBounds);
          this.currentProvinceChild = target.feature.properties.id;
          this.map.scrollWheelZoom.enable();
          break;
        case "NGR":
        case "FLD":
          if (target.feature.properties.type === "FLD") {
            this.bounds(
              this.zoomLevel,
              target.getBounds(),
              this.provinceChilds[
                target.feature.properties.parent_id
              ].getBounds()
            );
          } else {
            this.map.fitBounds(target.getBounds());
          }
          break;
      }
      if (
        this.zoomLevel === "FLD" &&
        target.feature.properties.type === "NGR"
      ) {
        this.map.fitBounds(this.prevBounds.pop());
        this.zoomLevel = this.prevZoomLevel.pop();
      }
    },
    onEachFeature(feature, layer) {
      if (feature.properties.type === "NGR") {
        this.provinceChildsLayers[feature.properties.parent_id].addLayer(layer);
        this.provinceChilds[feature.properties.id] = layer;
      }
      if (feature.properties.type === "FLD") {
        this.fields.addLayer(layer);
        layer.on({
          click: this.updateSubsoilField,
        });
      }
      layer.on({
        click: this.zoomToFeature,
      });
    },
    getTooltipStyles() {
      const styles = [
        "display: flex",
        "align-items: center",
        `white-space: ${this.isGlobalZoom ? "normal" : "nowrap"}`,
        `width: ${this.isGlobalZoom ? "145px" : "auto"}`,
        `font-size: ${this.isGlobalZoom ? "10px" : "16px"}`,
      ];
      return styles.join(";");
    },
    getTooltipIconStyles() {
      const styles = [
        "margin-right: 5px",
        `width: ${this.isGlobalZoom ? "7px" : "20px"}`,
        `height: ${this.isGlobalZoom ? "7px" : "20px"}`,
        "background-color: #374DBD",
        "border: 1px solid #7581C5",
        "border-radius: 25px",
      ];
      return styles.join(";");
    },
    toggleTooltipStyles() {
      this.fields.eachLayer((layer) => layer.unbindTooltip());

      for (let key in this.provinceChilds) {
        this.provinceChilds[key].unbindTooltip().bindTooltip(
          `<div style='${this.getTooltipStyles()}'>
              <div style='${this.getTooltipIconStyles()}'></div>
              <p style='margin: 0;'>${
                this.provinceChilds[key].feature.properties[
                  "name_" + this.currentLang
                ]
              }</p>
            </div>`,
          this.tooltipOptions
        );
      }
      if (this.zoomLevel === "NGR") {
        for (let key in this.provinceChilds) {
          this.provinceChilds[key].unbindTooltip();
        }

        this.fields.eachLayer((layer) => {
          if (
            layer.feature.properties.parent_id === this.currentProvinceChild
          ) {
            layer.bindTooltip(
              layer.feature.properties["name_" + this.currentLang],
              this.tooltipOptions
            );
          }
        });
      }
    },
    getProvinceChilds() {
      return Promise.all(
        this.provinces.map(async (province, index) => {
          const provinceChildren = await getMapDataByField(province.id);
          let getChildrenCoordsPayload = new FormData();
          provinceChildren.forEach((child) =>
            getChildrenCoordsPayload.append("geo_array", child.id)
          );
          let coords = {};
          this.provinceChildsLayers[province.id] = new L.featureGroup();
          coords = await getMapGeoJSONCoords(getChildrenCoordsPayload);
          L.geoJson(coords, {
            onEachFeature: this.onEachFeature,
            style: {
              fillColor: this.colorPalette[index],
              weight: 1,
              opacity: 1,
              color: "#2B2E5E",
              dashArray: "5",
              fillOpacity: 0.7,
            },
          }).addTo(this.map);
        })
      );
    },
    async getFields() {
      const blankPayload = new FormData();
      blankPayload.append("geo_array", "None");
      const response = await getMapGeoJSONCoords(blankPayload);

      const tempFields = [];
      response.features.forEach((feature) => {
        if (feature.properties.type === "FLD") {
          tempFields.push(feature);
        }
      });

      L.geoJson(tempFields, {
        onEachFeature: this.onEachFeature,
        style: {
          fill: true,
          weight: 1,
          fillColor: "#374DBD",
          color: "#2B2E5E",
          fillOpacity: 1,
        },
      }).addTo(this.map);
    },
    async initMap() {
      this.map = L.map("map", this.mapOptions);
      this.rk = L.geoJson(RK, {
        style: {
          color: "#43487A",
          fillOpacity: 1,
        },
      });
      this.rk.addTo(this.map);
      this.provinces = await getInitialMapNGP();

      await this.getProvinceChilds();
      await this.getFields();

      this.toggleTooltipStyles();
      this.map.on("zoomstart", () => {
        this.toggleTooltipStyles();
      });
      if (this.currentSubsoilField[0]) this.setField();
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

<style lang="scss" scoped src="./OilMapKzStyles.scss"></style>
