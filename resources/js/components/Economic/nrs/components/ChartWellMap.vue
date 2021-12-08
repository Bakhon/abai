<template>
  <div>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.css' rel='stylesheet'/>

    <subtitle v-if="wells.length" class="text-white text-wrap">
      {{ trans('economic_reference.total') }}
      {{ wellsByDates[currentDate].length }}
      {{ trans('economic_reference.wells_count').toLocaleLowerCase() }}
    </subtitle>

    <div class="d-flex align-items-center white-placeholder mt-2">
      <datetime
          v-model="form.interval_start"
          :placeholder="trans('economic_reference.interval_start')"
          input-class="bg-main4 text-white form-control border-0"
          class="mr-2 flex-grow-1"
          auto
          @input="form.interval_end = maxIntervalEnd"
      />

      <datetime
          v-model="form.interval_end"
          :min-datetime="form.interval_start"
          :max-datetime="maxIntervalEnd"
          :placeholder="trans('economic_reference.interval_end')"
          input-class="bg-main4 text-white form-control border-0"
          class="mr-2 flex-grow-1"
          auto
      />

      <i class="fas fa-search cursor-pointer mr-2"
         @click="getWells"></i>
    </div>

    <div v-if="wells.length" class="mt-2 d-flex">
      <button
          v-for="(date, index) in formattedDates"
          :key="date"
          :class="[
              dates[index] === currentDate ? 'bg-blue' : 'bg-grey',
              index ? 'ml-2' : ''
              ]"
          class="btn text-white"
          @click="updateDate(dates[index])">
        {{ date }}
      </button>
    </div>

    <div class="mt-2 well-map">
      <div id="map"></div>
    </div>
  </div>
</template>

<script>
import mapboxgl from "mapbox-gl";

import {globalloadingMutations} from '@store/helpers';

import Subtitle from "../../components/Subtitle";

export default {
  name: "ChartWellMap",
  components: {
    Subtitle
  },
  props: {
    orgForm: {
      required: true,
      type: Object
    }
  },
  data: () => ({
    form: {
      interval_start: null,
      interval_end: null,
    },
    wells: [],
    currentDate: null,
    map: null,
  }),
  async created() {
    this.form.interval_start = this.orgForm.interval_start

    this.form.interval_end = this.maxIntervalEnd

    this.getWells()
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getWells() {
      this.SET_LOADING(true)

      try {
        const {data} = await this.axios.get(this.url, {params: {...this.orgForm, ...this.form}})

        this.wells = data

        this.currentDate = this.dates[0]

        this.initMap()
      } catch (e) {
        console.log(e)
      }

      this.SET_LOADING(false)
    },

    getColor(profitability) {
      if (profitability === 'profitable') {
        return '#387249'
      }

      return profitability === 'profitless_cat_2'
          ? '#F7BB2E'
          : '#8D2540'
    },

    getMapSource(profitability) {
      return {
        type: 'geojson',
        data: {
          type: 'FeatureCollection',
          features: this.wellsByProfitability[profitability].map(well => ({
            type: 'Feature',
            geometry: {
              type: 'Point',
              coordinates: [well.coordinates.lon, well.coordinates.lat]
            },
            properties: {
              description: `<strong>${well.uwi}</strong>`
            },
          })),
        }
      }
    },

    initMap() {
      this.map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/dark-v9',
        zoom: 8,
        accessToken: process.env.MIX_MAPBOX_TOKEN,
        center: this.wellsByProfitability[this.wellsProfitability[0]][0].coordinates,
      })

      this.map.on('load', () => this.plotMap())
    },

    plotMap() {
      const popup = new mapboxgl.Popup({
        closeButton: false,
        closeOnClick: false
      })

      this.wellsProfitability.forEach(profitability => {
        let color = this.getColor(profitability)

        this.map.addSource(profitability, this.getMapSource(profitability))

        this.map.addLayer(
            {
              'id': `${profitability}-heat`,
              'type': 'heatmap',
              'source': profitability,
              'maxzoom': 12,
              'paint': {
                'heatmap-color': [
                  'interpolate',
                  ['linear'],
                  ['heatmap-density'],
                  0, 'rgba(33,102,172,0)',
                  0.2, color,
                  0.4, color,
                  0.6, color,
                  0.8, color,
                  1, color
                ],
                'heatmap-radius': {
                  stops: [
                    [10, 15],
                    [15, 20]
                  ]
                },
                'heatmap-opacity': {
                  default: 1,
                  stops: [
                    [11, 1],
                    [12, 0]
                  ]
                }
              }
            },
            'waterway-label'
        )

        this.map.addLayer({
              'id': `${profitability}-point`,
              'type': 'circle',
              'source': profitability,
              'minzoom': 11,
              'paint': {
                'circle-color': color,
                'circle-radius': 6,
                'circle-stroke-width': 2,
                'circle-stroke-color': '#ffffff'
              }
            },
            'waterway-label'
        )

        this.map.on('mouseenter', `${profitability}-point`, (e) => {
          this.map.getCanvas().style.cursor = 'pointer'

          let coordinates = e.features[0].geometry.coordinates.slice()

          while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
            coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360
          }

          popup
              .setLngLat(coordinates)
              .setHTML(e.features[0].properties.description)
              .addTo(this.map)
        })

        this.map.on('mouseleave', profitability, () => {
          this.map.getCanvas().style.cursor = ''

          popup.remove()
        })
      })
    },

    updateDate(date) {
      if (this.currentDate === date) return

      this.currentDate = date

      this.wellsProfitability.forEach(profitability => {
        this.map.getSource(profitability).setData(this.getMapSource(profitability).data)
      })
    },
  },
  computed: {
    url() {
      return this.localeUrl('/economic/nrs/get-wells-map')
    },

    maxIntervalEnd() {
      if (!this.form.interval_start) {
        return null
      }

      let date = new Date(this.form.interval_start)

      date.setDate(date.getDate() + 6)

      return date.toISOString()
    },

    wellsByDates() {
      let wellsByDate = {}

      this.wells.forEach(well => {
        if (!well.coordinates || !well.profitability) return

        let point = well.coordinates.split(',')

        let lat = +point[0].replace('(', '')

        let lon = +point[1].replace(')', '')

        if (Math.abs(lat) > 90 || Math.abs(lon) > 180) return;

        if (!wellsByDate.hasOwnProperty(well.dt)) {
          wellsByDate[well.dt] = {}
        }

        if (!wellsByDate[well.dt].hasOwnProperty(well.profitability)) {
          wellsByDate[well.dt][well.profitability] = []
        }

        wellsByDate[well.dt][well.profitability].push({
          uwi: well.uwi,
          coordinates: {lat: lat, lon: lon}
        })
      })

      return wellsByDate
    },

    wellsByProfitability() {
      return this.wellsByDates[this.currentDate] || []
    },

    wellsProfitability() {
      return Object.keys(this.wellsByProfitability)
    },

    dates() {
      return Object.keys(this.wellsByDates)
    },

    formattedDates() {
      return this.dates.map(date => {
        return (new Date(date)).toLocaleDateString('ru', {
          day: '2-digit',
          month: 'short',
          year: 'numeric',
        })
      })
    },
  }
}
</script>

<style scoped>
.well-map {
  position: relative;
  height: 460px;
  width: 100%;
}

.well-map >>> .mapboxgl-popup {
  max-width: 400px;
  font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
}

.bg-blue {
  background: #2E50E9;
}

.bg-grey {
  background: #656A8A;
}

#map {
  position: absolute;
  bottom: 0;
  left: 0;
  top: 0;
  right: 0;
}

.white-placeholder >>> *::placeholder {
  color: #fff;
}

.cursor-pointer {
  cursor: pointer;
}
</style>