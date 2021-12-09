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
import Subtitle from "../../components/Subtitle";

import {profitabilityMapMixin} from "../../mixins/mapMixin";

export default {
  name: "TableWellOverviewMap",
  components: {
    Subtitle
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
  },
  async mounted() {
    this.initMap()
  },
  methods: {
    plotMap() {
      this.initPopup()

      this.wellsProfitability.forEach(profitability => {
        let color = this.getColor(profitability)

        this.map.addSource(profitability, this.getMapSource(this.scenarioWells.active[profitability]))

        this.addHeatLayer(profitability, color)

        this.addPointLayer(profitability, color)

        this.map.on('mouseenter', `${profitability}-point`, (event) => this.showPopup(event))

        this.map.on('mouseleave', profitability, () => this.hidePopup())
      })

      this.plotStoppedWells()
    },

    plotStoppedWells() {
      if (!this.scenarioWells.stopped.length) {
        return this.removeMapSource('stoppedWells')
      }

      let color = this.getColor(null, true)

      let sourceId = 'stoppedWells'

      this.map.addSource(sourceId, this.getMapSource(this.scenarioWells.stopped))

      this.addHeatLayer(sourceId, color)

      this.addPointLayer(sourceId, color)

      this.map.on('mouseenter', `${sourceId}-point`, (event) => this.showPopup(event))

      this.map.on('mouseleave', sourceId, () => this.hidePopup())
    },

    updateMap() {
      this.wellsProfitability.forEach(profitability => {
        let source = this.map.getSource(profitability)

        source
            ? source.setData(this.getMapSource(this.scenarioWells.active[profitability]).data)
            : this.addMapSource(this.scenarioWells.active[profitability])
      })

      this.plotStoppedWells()

      this.totalProfitability
          .filter(profitability => !this.wellsProfitability.includes(profitability))
          .forEach(profitability => this.removeMapSource(profitability))
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
      return Object.keys(this.scenarioWells.active)
    }
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