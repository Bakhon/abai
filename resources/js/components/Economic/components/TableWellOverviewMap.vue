<template>
  <div>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.css' rel='stylesheet'/>

    <subtitle font-size="16" class="mb-2 text-white" style="line-height: 18px">
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
    },
  },
  data: () => ({
    map: null,
  }),
  async mounted() {
    this.initMap()
  },
  methods: {
    initMap() {
      this.map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/satellite-v9?optimize=true',
        center: this.wellPoints[0].coordinates,
        zoom: 11,
        bearing: 0,
        pitch: 30,
        accessToken: process.env.MIX_MAPBOX_TOKEN
      })

      this.map.on('load', () => {
        this.wellPoints.forEach(well => {
          let marker = document.createElement('div');

          marker.id = this.getMarkerId(well)

          marker.style.backgroundColor = well.color;

          marker.className = 'well-map-circle';

          new mapboxgl
              .Marker(marker)
              .setLngLat(well.coordinates)
              .setPopup(new mapboxgl.Popup({closeButton: false}).setText(well.uwi))
              .addTo(this.map)
        })
      })
    },

    updateMap() {
      this.wellPoints.forEach(well => {
        let marker = document.getElementById(this.getMarkerId(well))

        if (!marker) return

        marker.style.backgroundColor = well.color;
      })
    },

    getColor({uwi, profitability_12m}) {
      if (this.scenario.uwi_stop.includes(uwi)) {
        return '#8125B0'
      }

      if (profitability_12m === 'profitable') {
        return '#387249'
      }

      return profitability_12m === 'profitless_cat_1'
          ? '#8D2540'
          : '#F7BB2E'
    },

    getMarkerId({uwi}) {
      return `well-map-circle-${uwi}`
    },
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
  },
  watch: {
    scenario: {
      handler(val) {
        this.updateMap()
      },
      deep: true
    }
  }
}
</script>

<style scoped>
.well-map {
  position: relative;
  height: 510px;
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