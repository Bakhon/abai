<template>
  <div>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.css' rel='stylesheet'/>

    <subtitle v-if="wells.length" class="text-white text-wrap">
      {{ trans('economic_reference.total') }}
      {{ filteredWells[currentDate].length }}
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
              filteredDates[index] === currentDate ? 'bg-blue' : 'bg-grey',
              index ? 'ml-2' : ''
              ]"
          class="btn text-white"
          @click="updateDate(filteredDates[index])">
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

import Subtitle from "../Subtitle";

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

    getColor({profitability}) {
      if (profitability === 'profitable') {
        return '#387249'
      }

      return profitability === 'profitless_cat_1'
          ? '#8D2540'
          : '#F7BB2E'
    },

    getId({uwi}) {
      return `well-map-circle-${uwi}`
    },

    async getWells() {
      this.SET_LOADING(true);

      try {
        const {data} = await this.axios.get(this.url, {params: {...this.orgForm, ...this.form}})

        this.wells = data

        this.plotMap()
      } catch (e) {
        console.log(e)
      }

      this.SET_LOADING(false);
    },

    plotMap() {
      this.currentDate = this.filteredDates[0]

      this.map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/satellite-v9?optimize=true',
        center: this.filteredWells[this.currentDate][0].coordinates,
        zoom: 11,
        bearing: 0,
        pitch: 30,
        accessToken: process.env.MIX_MAPBOX_TOKEN
      })

      this.map.on('load', () => {
        this.filteredWells[this.currentDate].forEach(well => {
          let marker = document.createElement('div');

          marker.id = this.getId(well)

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

    updateDate(date) {
      if (this.currentDate === date) return

      this.currentDate = date

      this.filteredWells[this.currentDate].forEach(well => {
        let marker = document.getElementById(this.getId(well))

        if (!marker) return

        marker.style.backgroundColor = well.color;
      })
    }
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

    filteredWells() {
      let points = {}

      this.wells.forEach(well => {
        if (!well.coordinates) return

        let point = well.coordinates.split(',')

        let lat = +point[0].replace('(', '')

        let lon = +point[1].replace(')', '')

        if (Math.abs(lat) > 90 || Math.abs(lon) > 180) return;

        if (!points.hasOwnProperty(well.dt)) {
          points[well.dt] = []
        }

        points[well.dt].push({
          uwi: well.uwi,
          color: this.getColor(well),
          coordinates: {lat: lat, lon: lon}
        })
      })

      return points
    },

    filteredDates() {
      return Object.keys(this.filteredWells)
    },

    formattedDates() {
      return this.filteredDates.map(date => {
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
  height: 475px;
  width: 100%;
}

.well-map >>> .well-map-circle {
  height: 20px;
  width: 20px;
  border-radius: 50%;
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