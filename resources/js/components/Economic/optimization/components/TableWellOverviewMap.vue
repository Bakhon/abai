<template>
  <div>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.css' rel='stylesheet'/>

    <div class="d-flex mb-1">
      <subtitle font-size="16" class="mb-0 text-white" style="line-height: 18px">
        {{ trans('economic_reference.table_well_overview_map') }}
      </subtitle>

      <profitability-checkboxes
          :visible-form="visibleForm"
          class="ml-3 flex-grow-1"
          @update="plotMap()"/>
    </div>

    <div :key="isFullscreen"
         :style="`height: ${mapHeight}px`"
         class="mt-2 well-map">
      <div id="map"></div>
    </div>
  </div>
</template>

<script>
import Subtitle from "../../components/Subtitle";

import {profitabilityMapMixin} from "../../mixins/mapMixin";

export default {
  name: "TableWellOverviewMap",
  components: {
    Subtitle,
  },
  mixins: [profitabilityMapMixin],
  props: {
    scenario: {
      required: true,
      type: Object
    },
    scenarios: {
      required: true,
      type: Array
    },
    isFullscreen: {
      required: false,
      type: Boolean
    }
  },
  data: () => ({
    visibleForm: {
      profitable: true,
      profitless: true,
      conditionallyProfitable: true
    },
  }),
  async mounted() {
    this.initMap(this.scenarioWells.active[this.wellsProfitability[0]][0].coordinates)
  },
  methods: {
    plotMap() {
      this.initPopup()

      this.wellsProfitability.forEach(profitability => {
        this.addMapSource(
            profitability,
            this.scenarioWells.active[profitability],
            this.getColor(profitability)
        )
      })

      this.plotStoppedWells()

      this.totalProfitability
          .filter(profitability => !this.wellsProfitability.includes(profitability))
          .forEach(profitability => this.removeMapSource(profitability))
    },

    plotStoppedWells() {
      if (!this.scenarioWells.stopped.length) {
        return this.removeMapSource('stoppedWells')
      }

      this.addMapSource(
          'stoppedWells',
          this.scenarioWells.stopped,
          this.getColor(null, true)
      )
    },

    addMapSource(sourceId, wells, color) {
      let source = this.map.getSource(sourceId)

      if (source) {
        return source.setData(this.getMapSource(wells).data)
      }

      this.map.addSource(sourceId, this.getMapSource(wells))

      this.addPointLayer(sourceId, color)

      this.map.on('mouseenter', `${sourceId}-point`, (event) => this.showPopup(event))

      this.map.on('mouseleave', sourceId, () => this.hidePopup())
    },
  },
  computed: {
    scenarioWells() {
      let activeWells = {}

      let stoppedWells = []

      this.scenarios
          .find(scenario =>
              +scenario.dollar_rate === +this.scenario.dollar_rate &&
              +scenario.oil_price === +this.scenario.oil_price
          )
          .wells
          .forEach(well => {
            if (!!!well.coordinates) return

            let point = well.coordinates.split(',')

            let lat = +point[0].replace('(', '')

            let lon = +point[1].replace(')', '')

            if (Math.abs(lat) > 90 || Math.abs(lon) > 180) return

            if (this.scenario.stopped_uwis.includes(well.uwi)) {
              return stoppedWells.push({
                uwi: well.uwi,
                coordinates: {lat: lat, lon: lon}
              })
            }

            if (!activeWells.hasOwnProperty(well.profitability)) {
              activeWells[well.profitability] = []
            }

            activeWells[well.profitability].push({
              uwi: well.uwi,
              coordinates: {lat: lat, lon: lon}
            })
          })

      return {
        active: activeWells,
        stopped: stoppedWells
      }
    },

    wellsProfitability() {
      return Object
          .keys(this.scenarioWells.active)
          .filter(key => this.visibleProfitability.includes(key))
    },

    mapHeight() {
      return this.isFullscreen ? 660 : 500
    }
  },
  watch: {
    scenario: {
      handler(val) {
        this.plotMap()
      },
      deep: true
    },
    isFullscreen: {
      handler() {
        this.$nextTick(() => {
          this.initMap(this.scenarioWells.active[this.wellsProfitability[0]][0].coordinates)
        })
      },
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

.well-map >>> .mapboxgl-popup {
  max-width: 400px;
  font-size: 12px;
}

#map {
  position: absolute;
  bottom: 0;
  left: 0;
  top: 0;
  right: 0;
}
</style>