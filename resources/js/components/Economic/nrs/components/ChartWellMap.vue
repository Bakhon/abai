<template>
  <div>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.css' rel='stylesheet'/>

    <subtitle v-if="wells.length" class="text-white text-wrap">
      <span>
        {{ trans('economic_reference.total') }}
        {{ totalWellsCount }}
        {{ trans('economic_reference.wells_count').toLocaleLowerCase() }}.
      </span>

      <span v-for="profitability in wellsProfitability"
            :key="profitability">
        {{ trans(`economic_reference.wells_${profitability}`) }}:
        {{ wellsByProfitability[profitability].length }}.
      </span>
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
          class="btn text-white text-nowrap px-2"
          @click="updateDate(dates[index])">
        {{ date }}
      </button>

      <div class="ml-2">
        <button
            type="button"
            class="btn text-white bg-dark-blue h-100"
            @click="isSlideshow  ? stopSlideshow() : startSlideshow()">
          <i :class="isSlideshow ? 'fa-pause' : 'fa-play'"
             class="fas cursor-pointer"></i>
        </button>
      </div>

      <profitability-checkboxes
          :visible-form="visibleForm"
          class="ml-3 flex-grow-1"
          @update="plotMap()"/>
    </div>

    <div :key="orgForm.isFullScreen"
         :style="`height: ${mapHeight}px`"
         class="mt-2 well-map">
      <div id="map"></div>
    </div>
  </div>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

import {profitabilityMapMixin} from "../../mixins/mapMixin";

import Subtitle from "../../components/Subtitle";

export default {
  name: "ChartWellMap",
  components: {
    Subtitle,
  },
  mixins: [profitabilityMapMixin],
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
    isSlideshow: false,
    interval: null
  }),
  async created() {
    this.form.interval_start = this.orgForm.interval_start

    this.form.interval_end = this.maxIntervalEnd
  },
  mounted() {
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

        this.initMap(this.wellsByProfitability[this.wellsProfitability[0]][0].coordinates)
      } catch (e) {
        console.log(e)
      }

      this.SET_LOADING(false)
    },

    getMapSource(profitability = null) {
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

    plotMap() {
      this.initPopup()

      this.wellsProfitability.forEach(profitability => {
        this.addMapSource(profitability)
      })

      this.totalProfitability
          .filter(profitability => !this.wellsProfitability.includes(profitability))
          .forEach(profitability => this.removeMapSource(profitability))
    },

    addMapSource(profitability) {
      let source = this.map.getSource(profitability)

      if (source) {
        return source.setData(this.getMapSource(profitability).data)
      }

      let color = this.getColor(profitability)

      this.map.addSource(profitability, this.getMapSource(profitability))

      this.addPointLayer(profitability, color)

      this.map.on('mouseenter', `${profitability}-point`, (event) => this.showPopup(event))

      this.map.on('mouseleave', profitability, () => this.hidePopup())
    },

    updateDate(date) {
      if (this.currentDate === date) return

      this.currentDate = date

      this.plotMap()
    },

    removeMapSource(layerId) {
      if (!this.map.getSource(layerId)) return

      this.map
          .removeLayer(`${layerId}-point`)
          .removeSource(layerId)
    },

    stopSlideshow() {
      this.isSlideshow = false

      clearInterval(this.interval)
    },

    startSlideshow() {
      this.isSlideshow = true

      this.updateDate(this.dates[0])

      this.interval = setInterval(() => {
        let currentIndex = this.dates.findIndex(date => date === this.currentDate)

        if (currentIndex === this.dates.length - 1) {
          return this.stopSlideshow()
        }

        this.updateDate(this.dates[currentIndex + 1])
      }, 1000);
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
      return Object
          .keys(this.wellsByProfitability)
          .filter(key => this.visibleProfitability.includes(key))
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

    totalWellsCount() {
      let count = 0

      this.wellsProfitability.forEach(profitability => {
        count += this.wellsByProfitability[profitability].length
      })

      return count
    },

    mapHeight() {
      return this.orgForm.isFullScreen ? 610 : 485
    }
  },
  watch: {
    orgForm: {
      handler() {
        this.$nextTick(() => {
          this.initMap(this.wellsByProfitability[this.wellsProfitability[0]][0].coordinates)
        })
      },
      deep: true
    }
  }
}
</script>

<style scoped>
.well-map {
  position: relative;
  width: 100%;
}

.well-map >>> .mapboxgl-popup {
  max-width: 400px;
  font-size: 12px;
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