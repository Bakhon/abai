<template>
  <div>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.css' rel='stylesheet'/>

    <subtitle font-size="18" class="mb-3 text-white" style="line-height: 26px">
      {{ trans('economic_reference.table_well_overview_map') }}
    </subtitle>

    <div class="well-map">
      <div id="map"></div>
    </div>
  </div>
</template>

<script>
import mapboxgl from "mapbox-gl";

import Subtitle from "./Subtitle";

export default {
  name: "TableWellOverviewMap",
  components: {
    Subtitle
  },
  props: {
    scenario: {
      required: true,
      type: Object
    },
    wells: {
      required: true,
      type: Array
    }
  },
  data: () => ({
    map: null,
    viewState: {
      latitude: 43.426262258809,
      longitude: 52.854602599069,
      zoom: 11,
      bearing: 0,
      pitch: 30
    }
  }),
  async mounted() {
    this.initMap()
  },
  methods: {
    initMap() {
      this.map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/satellite-v9?optimize=true',
        center: [this.viewState.longitude, this.viewState.latitude],
        zoom: this.viewState.zoom,
        bearing: this.viewState.bearing,
        pitch: this.viewState.pitch,
        accessToken: process.env.MIX_MAPBOX_TOKEN
      })

      this.map.on('load', () => {
        this.wellPoints.forEach(wellPoint => {
          let marker = document.createElement('div');

          marker.className = 'well-map-circle';

          marker.style.cssText = `background-color: ${wellPoint.color}`;

          new mapboxgl
              .Marker(marker)
              .setLngLat(wellPoint.coordinates)
              .setPopup(new mapboxgl.Popup({closeButton: false}).setText(wellPoint.uwi))
              .addTo(this.map)
        })
      })
    },

    getColor({profitability_12m}) {
      if (profitability_12m === 'profitable') {
        return '#387249'
      }

      return profitability_12m === 'profitless_cat_1'
          ? '#8D2540'
          : '#F7BB2E'
    }
  },
  computed: {
    wellPoints() {
      return this.wells
          .filter(well =>
              +well.dollar_rate === +this.scenario.dollar_rate &&
              +well.oil_price === +this.scenario.oil_price &&
              well.coordinates
          )
          .map(well => {
            let point = well.coordinates.split(',')

            return {
              uwi: well.uwi,
              color: this.getColor(well),
              coordinates: {
                lat: +point[0].replace('(', ''),
                lon: +point[1].replace(')', ''),
              }
            }
          })
    },
  }
}
</script>

<style scoped>
.well-map {
  position: relative;
  height: 550px;
  width: 100%;
}

.well-map >>> .well-map-circle {
  height: 20px;
  width: 20px;
  border-radius: 50%;
  display: inline-block;
}

#map {
  position: absolute;
  bottom: 0;
  left: 0;
  top: 0;
  right: 0;
}
</style>