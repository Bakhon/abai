<template>
  <div>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.css' rel='stylesheet'/>

    <div class="well-map">
      <div id="map"></div>
    </div>
  </div>
</template>

<script>
import mapboxgl from "mapbox-gl";

export default {
  name: "ChartWellMap",
  props: {
    wells: {
      required: true,
      type: Array
    }
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
  },
  computed: {
    wellPoints() {
      let points = []

      this.wells.forEach(well => {
        if (!well.coordinates) return

        let point = well.coordinates.split(',')

        let lat = +point[0].replace('(', '')

        let lon = +point[1].replace(')', '')

        if (Math.abs(lat) > 90 || Math.abs(lon) > 180) return;

        points.push({
          uwi: well.uwi,
          color: '#F7BB2E',
          coordinates: {lat: lat, lon: lon}
        })
      })

      return points
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