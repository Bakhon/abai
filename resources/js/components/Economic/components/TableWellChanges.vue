<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      {{ trans('economic_reference.table_well_changes') }}
    </subtitle>

    <div id="table-well-changes" class="mt-3 overflow-auto customScroll d-flex">
      <div v-for="(chunk, index) in tableDataChunks"
           :key="index">
        <div
            :style="`width: ${columnWidth}px`"
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
  'Operating_profit_12m',
  'Fixed_nopayroll_expenditures_12m',
  'Fixed_payroll_expenditures_12m',
  'oil_12m',
  'liquid_12m',
  'Revenue_total_12m',
  'Overall_expenditures_12m',
  'Overall_expenditures_full_12m',
  'profitability_12m'
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
    selectedWells: {
      required: true,
      type: Array
    }
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

      let oil = +well.oilPrices[oilPrice].oil_12m

      let liquid = +well.oilPrices[oilPrice].liquid_12m

      let revenueTotal = +well.oilPrices[oilPrice].Revenue_total_12m

      let overallExpendituresScenario =
          +this.scenario.coef_Fixed_nopayroll * +well.oilPrices[oilPrice].Fixed_nopayroll_expenditures_12m +
          +this.scenario.coef_cost_WR_payroll * +well.oilPrices[oilPrice].Fixed_payroll_expenditures_12m

      let operatingProfit = +well.oilPrices[oilPrice].Operating_profit_12m + overallExpendituresScenario

      let overallExpenditures = +well.oilPrices[oilPrice].Overall_expenditures_12m - overallExpendituresScenario

      let overallExpendituresFull = +well.oilPrices[oilPrice].Overall_expenditures_full_12m - overallExpendituresScenario

      if (well.isShutdown) {
        this.selectedWells.push(uwi)

        oil = -oil

        liquid = -liquid

        revenueTotal = -revenueTotal

        operatingProfit = -operatingProfit

        overallExpenditures = -overallExpenditures

        overallExpendituresFull = -overallExpendituresFull
      } else {
        let index = this.selectedWells.findIndex(well => well === uwi)

        if (index !== -1) {
          this.selectedWells.splice(index, 1)
        }
      }

      WELL_VALUE_KEYS.forEach(key => {
        this.scenario.oil[key] = +this.scenario.oil[key] + oil

        this.scenario.liquid[key] = +this.scenario.liquid[key] + liquid

        this.scenario.Revenue_total[key] = +this.scenario.Revenue_total[key] + revenueTotal

        this.scenario.Operating_profit[key] = +this.scenario.Operating_profit[key] + operatingProfit

        this.scenario.Overall_expenditures[key] = +this.scenario.Overall_expenditures[key] + overallExpenditures

        this.scenario.Overall_expenditures_full[key] = +this.scenario.Overall_expenditures_full[key] + overallExpendituresFull
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
            isShutdown: this.selectedWells.includes(well.uwi)
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
      return 25
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