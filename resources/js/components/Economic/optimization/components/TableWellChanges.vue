<template>
  <div>
    <subtitle font-size="16" style="line-height: 18px">
      {{ trans('economic_reference.table_well_changes') }}
    </subtitle>

    <div v-if="wells"
         id="table-well-changes"
         class="mt-2 overflow-auto customScroll d-flex">
      <div v-for="(chunk, chunkIndex) in chunks"
           :key="chunkIndex">
        <div :style="`width: ${columnWidth}px`"
             class="text-center border-grey d-flex bg-header">
          <div class="text-center border-grey flex-150px">
            {{ trans('economic_reference.well_short') }}
          </div>

          <div v-for="price in oilPrices"
               :key="`${chunkIndex}_${price}`"
               class="text-center border-grey flex-30px">
            {{ (+price).toLocaleString() }}$
          </div>

          <div class="text-center border-grey flex-30px"></div>
        </div>

        <div v-for="(uwi, uwiIndex) in chunk"
             :key="uwi"
             class="d-flex">
          <div class="text-center border-grey flex-150px text-truncate">
            {{ `${chunkIndex * chunkStep + uwiIndex + 1}. ${uwi}` }}
          </div>

          <div v-for="price in oilPrices"
               :key="`${uwi}_${price}_profitability`"
               :style="`background: ${getColor(wells[uwi].oilPrices[+price])}`"
               class="border-grey flex-30px">
          </div>

          <div class="border-grey flex-30px position-relative d-flex align-items-center justify-content-center">
            <input v-model="wells[uwi].isShutdown"
                   type="checkbox"
                   class="form-check-input m-0 flex-30px"
                   @change="toggleWell(uwi, wells[uwi])">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

import Subtitle from "../../components/Subtitle";

const WELL_SUM_KEYS = [
  'oil',
  'liquid',
  'Revenue_total',
  'prs'
]

export default {
  name: "TableWellChanges",
  components: {
    Subtitle
  },
  props: {
    scenario: {
      required: true,
      type: Object
    },
    scenarios: {
      required: true,
      type: Array
    },
    oilPrices: {
      required: true,
      type: Array,
    },
    isFullscreen: {
      required: false,
      type: Boolean
    }
  },
  data: () => ({
    dollarRate: 0,
    wells: null,
  }),
  created() {
    this.dollarRate = +this.scenario.dollar_rate
  },
  mounted() {
    this.SET_LOADING(true)

    setTimeout(() => {
      this.setWells()

      this.SET_LOADING(false)
    })
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

    toggleWell(uwi, well) {
      let oilPrice = +this.scenario.oil_price

      let sumValues = {}

      WELL_SUM_KEYS.forEach(key => {
        sumValues[key] = +well.oilPrices[oilPrice][`${key}`]
      })

      let overallExpendituresScenario =
          +this.scenario.coef_Fixed_nopayroll * +well.oilPrices[oilPrice].Fixed_nopayroll_expenditures +
          +this.scenario.coef_cost_WR_payroll * +well.oilPrices[oilPrice].Fixed_payroll_expenditures

      sumValues.Operating_profit = +well.oilPrices[oilPrice].Operating_profit + overallExpendituresScenario

      sumValues.Overall_expenditures = +well.oilPrices[oilPrice].Overall_expenditures - overallExpendituresScenario

      sumValues.Overall_expenditures_full = +well.oilPrices[oilPrice].Overall_expenditures_full - overallExpendituresScenario

      let sumKeys = Object.keys(sumValues)

      if (well.isShutdown) {
        this.scenario.stopped_uwis.push(uwi)

        sumKeys.forEach(key => sumValues[key] = -sumValues[key])
      } else {
        let index = this.scenario.stopped_uwis.findIndex(well => well === uwi)

        if (index !== -1) {
          this.scenario.stopped_uwis.splice(index, 1)
        }
      }

      sumKeys.forEach(key => {
        this.scenario[key] = +this.scenario[key] + sumValues[key]

        this.scenario[`${key}_optimize`] = +this.scenario[`${key}_optimize`] + sumValues[key]
      })
    },

    setWells() {
      let wells = {}

      this.scenarios.forEach(scenario => {
        if (+scenario.dollar_rate !== this.dollarRate) return

        scenario.wells.forEach(well => {
          if (!wells.hasOwnProperty(well.uwi)) {
            wells[well.uwi] = {
              oilPrices: {},
              profitlessCat1: 0,
              profitlessCat2: 0,
              profitable: 0,
              isShutdown: this.scenario.stopped_uwis.includes(well.uwi)
            }
          }

          wells[well.uwi].oilPrices[scenario.oil_price] = {...well}

          switch (well.profitability) {
            case 'profitable':
              wells[well.uwi].profitable += 1
              break
            case 'profitless_cat_1':
              wells[well.uwi].profitlessCat1 += 1
              break
            case 'profitless_cat_2':
              wells[well.uwi].profitlessCat2 += 1
              break
          }
        })
      })

      this.wells = wells
    }
  },
  computed: {
    sortedUwis() {
      let wells = this.wells

      return Object.keys(wells).sort(function (prev, next) {
        return (wells[next].profitlessCat1 - wells[prev].profitlessCat1)
            || (wells[next].profitlessCat2 - wells[prev].profitlessCat2)
            || (wells[prev].profitable - wells[next].profitable)
      })
    },

    chunks() {
      let result = [];

      let keys = this.sortedUwis

      let length = keys.length

      for (let i = 0; i < Math.ceil(length / this.chunkStep); i += 1) {
        result.push(keys.splice(0, this.chunkStep))
      }

      return result
    },

    chunkStep() {
      return this.isFullscreen ? 27 : 21
    },

    columnWidth() {
      return 180 + this.oilPrices.length * 30
    },
  },
  watch: {
    scenario: {
      handler(scenario) {
        this.SET_LOADING(true)

        setTimeout(() => {
          if (+scenario.dollar_rate !== this.dollarRate) {
            this.dollarRate = +scenario.dollar_rate

            this.setWells()
          } else {
            Object.keys(this.wells).forEach(uwi => {
              this.wells[uwi].isShutdown = scenario.stopped_uwis.includes(uwi)
            })
          }

          this.SET_LOADING(false)
        })
      },
      deep: true
    }
  }
}
</script>

<style scoped>
.border-grey {
  border: 1px solid #454D7D
}

.bg-header {
  background: #333975;
}

.flex-150px {
  flex: 0 0 150px;
}

.flex-30px {
  flex: 0 0 30px;
}
</style>