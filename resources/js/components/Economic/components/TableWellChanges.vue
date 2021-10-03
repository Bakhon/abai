<template>
  <div>
    <subtitle font-size="16" style="line-height: 18px">
      {{ trans('economic_reference.table_well_changes') }}
    </subtitle>

    <div id="table-well-changes" class="mt-2 overflow-auto customScroll d-flex">
      <div v-for="(chunk, index) in tableDataChunks"
           :key="index">
        <div :style="`width: ${columnWidth}px`"
             class="text-center border-grey d-flex bg-header">
          <div class="text-center border-grey flex-100px">
            {{ trans('economic_reference.well_short') }}
          </div>

          <div v-for="price in oilPrices"
               :key="`${index}_${price}`"
               class="text-center border-grey flex-30px">
            {{ (+price).toLocaleString() }}$
          </div>

          <div class="text-center border-grey flex-30px"></div>
        </div>

        <div v-for="uwi in chunk" :key="uwi" class="d-flex">
          <div class="text-center border-grey flex-100px">
            {{ uwi }}
          </div>

          <div v-for="price in oilPrices"
               :key="`${uwi}_${price}_profitability_12m`"
               :style="`background: ${getColor(tableData[uwi].oilPrices[+price])}`"
               class="border-grey flex-30px">
          </div>

          <div class="border-grey flex-30px position-relative d-flex align-items-center justify-content-center">
            <input v-model="tableData[uwi].isShutdown"
                   type="checkbox"
                   class="form-check-input m-0 flex-30px"
                   @change="toggleWell(uwi, tableData[uwi])">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "./Subtitle";

const WELL_KEYS = [
  'Revenue_total_12m',
  'Revenue_local_12m',
  'Revenue_export_12m',
  'oil_12m',
  'liquid_12m',
  'prs_12m',
  'days_worked_12m',
  'production_export_12m',
  'production_local_12m',
  'Fixed_noWRpayroll_expenditures_12m',
  'Operating_profit_12m',
  'Overall_expenditures_12m',
  'Overall_expenditures_full_12m',
  'Fixed_nopayroll_expenditures_12m',
  'Fixed_payroll_expenditures_12m',
  'profitability_12m'
]

const WELL_SUM_KEYS = [
  'oil',
  'liquid',
  'Revenue_total',
  'prs'
]

const WELL_VALUE_KEYS = [
  'original_value',
  'original_value_optimized'
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
    oilPrices: {
      required: true,
      type: Array,
    },
    data: {
      required: true,
      type: Array
    },
  },
  methods: {
    getColor({profitability_12m}) {
      if (profitability_12m === 'profitable') {
        return '#387249'
      }

      return profitability_12m === 'profitless_cat_1'
          ? '#8D2540'
          : '#F7BB2E'
    },

    toggleWell(uwi, well) {
      let oilPrice = +this.scenario.oil_price

      let sumValues = {}

      WELL_SUM_KEYS.forEach(key => {
        sumValues[key] = +well.oilPrices[oilPrice][`${key}_12m`]
      })

      let overallExpendituresScenario =
          +this.scenario.coef_Fixed_nopayroll * +well.oilPrices[oilPrice].Fixed_nopayroll_expenditures_12m +
          +this.scenario.coef_cost_WR_payroll * +well.oilPrices[oilPrice].Fixed_payroll_expenditures_12m

      sumValues.Operating_profit = +well.oilPrices[oilPrice].Operating_profit_12m + overallExpendituresScenario

      sumValues.Overall_expenditures = +well.oilPrices[oilPrice].Overall_expenditures_12m - overallExpendituresScenario

      sumValues.Overall_expenditures_full = +well.oilPrices[oilPrice].Overall_expenditures_full_12m - overallExpendituresScenario

      let sumKeys = Object.keys(sumValues)

      if (well.isShutdown) {
        this.scenario.uwi_stop.push(uwi)

        sumKeys.forEach(key => sumValues[key] = -sumValues[key])
      } else {
        let index = this.scenario.uwi_stop.findIndex(well => well === uwi)

        if (index !== -1) {
          this.scenario.uwi_stop.splice(index, 1)
        }
      }

      WELL_VALUE_KEYS.forEach(valueKey => {
        sumKeys.forEach(sumKey => {
          this.scenario[sumKey][valueKey] = +this.scenario[sumKey][valueKey] + sumValues[sumKey]
        })
      })
    }
  },
  computed: {
    filteredData() {
      return this.data.filter(x => +x.dollar_rate === +this.scenario.dollar_rate)
    },

    tableData() {
      let wells = {}

      this.filteredData.forEach(well => {
        if (!wells.hasOwnProperty(well.uwi)) {
          wells[well.uwi] = {
            oilPrices: {},
            cat1: 0,
            cat2: 0,
            profitable: 0,
            isShutdown: this.scenario.uwi_stop.includes(well.uwi)
          }
        }

        wells[well.uwi].oilPrices[well.oil_price] = {}

        WELL_KEYS.forEach(key => {
          wells[well.uwi].oilPrices[well.oil_price][key] = well[key]
        })

        switch (well.profitability_12m) {
          case 'profitable':
            wells[well.uwi].profitable += 1
            break
          case 'profitless_cat_1':
            wells[well.uwi].cat1 += 1
            break
          case 'profitless_cat_2':
            wells[well.uwi].cat2 += 1
            break
        }
      })

      return wells
    },

    tableDataKeys() {
      let wells = this.tableData

      return Object.keys(wells).sort(function (prev, next) {
        return (wells[next].cat1 - wells[prev].cat1)
            || (wells[next].cat2 - wells[prev].cat2)
            || (wells[prev].profitable - wells[next].profitable)
      })
    },

    tableDataChunks() {
      let result = [];

      let keys = this.tableDataKeys

      let length = keys.length

      for (let i = 0; i < Math.ceil(length / this.chunkStep); i += 1) {
        result.push(keys.splice(0, this.chunkStep))
      }

      return result
    },

    chunkStep() {
      return 20
    },

    columnWidth() {
      return 130 + this.oilPrices.length * 30
    }
  },
}
</script>

<style scoped>
.border-grey {
  border: 1px solid #454D7D
}

.bg-header {
  background: #333975;
}

.flex-100px {
  flex: 0 0 100px;
}

.flex-30px {
  flex: 0 0 30px;
}
</style>