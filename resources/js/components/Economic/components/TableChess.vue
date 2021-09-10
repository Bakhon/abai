<template>
  <div class="text-white">
    <subtitle font-size="18" style="line-height: 26px">
      <div>{{ trans('economic_reference.table_chess_title') }}</div>
    </subtitle>

    <div class="mt-3 border-grey bg-header">
      <div class="px-3 py-1 border-grey"
           style="font-size: 16px; line-height: 20px; font-weight: 600">
        {{ trans('economic_reference.table_chess_subtitle') }}
      </div>

      <div v-for="(row, index) in tableData"
           :key="index"
           :class="row.styleClass"
           class="d-flex">
        <div class="px-3 py-1 border-grey text-center flex-300px">
          {{ row.title }}
        </div>

        <div class="px-3 py-1 border-grey text-center flex-120px">
          {{ row.pp2020 }}
        </div>

        <div v-if="row.subtitle"
             class="px-3 py-1 border-grey bg-dark-blue text-center flex-grow-1">
          {{ row.subtitle }}
        </div>

        <div v-else
             v-for="column in row.columns"
             :key="`${index}_${column.value}`"
             :style="`flex: 1 1 ${100 / row.columns.length}%; background: ${column.color}`"
             class="px-3 py-1 border-grey text-center">
          {{ (+column.value).toLocaleString() }}
          {{ row.columnDimension }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "./Subtitle";

export default {
  name: "TableChess",
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
    wells: {
      required: true,
      type: Array
    },
    oilPrices: {
      required: true,
      type: Array
    },
  },
  computed: {
    reverseOilPrices() {
      return [...this.oilPrices].reverse()
    },

    scenariosByOilPrice() {
      let scenarios = this.scenarios.filter(scenario =>
          scenario.dollar_rate === this.scenario.dollar_rate &&
          scenario.coef_cost_WR_payroll === this.scenario.coef_cost_WR_payroll &&
          scenario.coef_Fixed_nopayroll === this.scenario.coef_Fixed_nopayroll
      )

      return this.reverseOilPrices.map(oilPrice => {
        return scenarios
            .filter(scenario => scenario.oil_price === oilPrice)
            .reduce((prev, current) => (+prev.Operating_profit_scenario > +current.Operating_profit_scenario) ? prev : current)
      })
    },

    wellsByOilPrice() {
      let wells = this.wells.filter(well => +well.dollar_rate === +this.scenario.dollar_rate)

      return this.reverseOilPrices.map(oilPrice => wells.filter(well => +well.oil_price === +oilPrice))
    },

    tableData() {
      let oilProduction = [
        {
          title: '',
          pp2020: '',
          subtitle: this.trans('economic_reference.production_program_at_oil_price'),
        },
        {
          title: `${this.trans('economic_reference.course')}
                  ${+this.scenario.dollar_rate}
                  ${this.trans('economic_reference.tenge')} / $`,
          pp2020: this.trans('economic_reference.pp_2020'),
          columns: this.reverseOilPrices.map(oilPrice => {
            return {
              value: oilPrice,
              color: ''
            }
          }),
          columnDimension: this.trans('economic_reference.dollar_per_bar'),
          styleClass: 'bg-light-blue'
        },
        {
          title: `${this.trans('economic_reference.production')},
                  ${this.trans('economic_reference.thousand_tons')}`,
          pp2020: '',
          columns: this.reverseOilPrices.map((price, index) => {
            return {
              value: (this.scenariosByOilPrice[index].oil.original_value_optimized / 1000).toFixed(2),
              color: ''
            }
          })
        },
      ]

      let revenueTotal = this.reverseOilPrices.map((oilPrice, oilPriceIndex) => {
        let stoppedWells = this.scenariosByOilPrice[oilPriceIndex].uwi_stop

        return {
          title: `${+oilPrice} ${this.trans('economic_reference.dollar_per_bar')}`,
          pp2020: '',
          columns: this.reverseOilPrices.map((price, priceIndex) => {
            let revenue = 0

            this.wellsByOilPrice[priceIndex].forEach(well => {
              if (stoppedWells.includes(well.uwi)) return

              revenue += well.Revenue_total_12m
            })


            return {
              value: (revenue / 1000000).toFixed(2),
              color: this.getColor(oilPrice, oilPriceIndex, price, priceIndex)
            }
          })
        }
      })

      let overallExpenditures = this.reverseOilPrices.map((oilPrice, oilPriceIndex) => {
        let stoppedWells = this.scenariosByOilPrice[oilPriceIndex].uwi_stop

        let stoppedWellsExpenditures = this.scenariosByOilPrice[oilPriceIndex].Overall_expenditures_full_scenario

        this.wellsByOilPrice[oilPriceIndex].forEach(well => {
          if (stoppedWells.includes(well.uwi)) return

          stoppedWellsExpenditures -= well.Overall_expenditures_full_12m
        })

        return {
          title: `${+oilPrice} ${this.trans('economic_reference.dollar_per_bar')}`,
          pp2020: '',
          columns: this.reverseOilPrices.map((price, priceIndex) => {
            let expenditures = stoppedWellsExpenditures

            this.wellsByOilPrice[priceIndex].forEach(well => {
              if (stoppedWells.includes(well.uwi)) return

              expenditures += well.Overall_expenditures_full_12m
            })

            return {
              value: (expenditures / 1000000).toFixed(2),
              color: this.getColor(oilPrice, oilPriceIndex, price, priceIndex)
            }
          })
        }
      })

      let operatingProfit = this.reverseOilPrices.map((oilPrice, oilPriceIndex) => {
        let revenue = revenueTotal[oilPriceIndex]

        let expenditures = overallExpenditures[oilPriceIndex]

        return {
          title: `${+oilPrice} ${this.trans('economic_reference.dollar_per_bar')}`,
          pp2020: '',
          columns: this.reverseOilPrices.map((price, priceIndex) => {
            let operatingProfit = revenue.columns[priceIndex].value - expenditures.columns[priceIndex].value

            return {
              value: (operatingProfit).toFixed(2),
              color: this.getColorOperatingProfit(oilPriceIndex, priceIndex, operatingProfit)
            }
          })
        }
      })

      return [
        ...oilProduction,
        ...[{
          title: '',
          pp2020: '',
          subtitle: `${this.trans('economic_reference.income')}, ${this.trans('economic_reference.million_tenge')}`,
          styleClass: 'bg-deep-blue'
        }],
        ...revenueTotal,
        ...[{
          title: '',
          pp2020: '',
          subtitle: `${this.trans('economic_reference.costs')}, ${this.trans('economic_reference.million_tenge')}`,
          styleClass: 'bg-deep-blue'
        }],
        ...overallExpenditures,
        ...[{
          title: '',
          pp2020: '',
          subtitle: `${this.trans('economic_reference.operating_profit')}, ${this.trans('economic_reference.million_tenge')}`,
          styleClass: 'bg-deep-blue'
        }],
        ...operatingProfit
      ]
    }
  },
  methods: {
    getColor(scenarioPrice, scenarioIndex, currentPrice, currentIndex) {
      if (scenarioPrice === currentPrice) {
        return '#106B4B'
      }

      let diff = Math.abs(scenarioIndex - currentIndex)

      switch (diff) {
        case 1:
          return '#BDA74D'
        case 2:
          return '#AC7550'
        default:
          return scenarioPrice % 2 === 0 ? '#505585' : '#272953'
      }
    },

    getColorOperatingProfit(scenarioIndex, currentIndex, operatingProfit) {
      if (scenarioIndex === currentIndex) {
        return '#106B4B'
      }

      if (operatingProfit > 0 || currentIndex - scenarioIndex > 0) {
        return '#4A9B7E'
      }

      if (operatingProfit > -25000) {
        return '#BDA74D'
      }

      if (operatingProfit > -50000) {
        return '#AC7550'
      }

      return '#682041'
    },
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

.bg-dark-blue {
  background: #1A2370;
}

.bg-light-blue {
  background: #505585;
}

.bg-deep-blue {
  background: #272953;
}

.flex-120px {
  flex: 0 0 120px;
}

.flex-300px {
  flex: 0 0 300px;
}

.height-31px {
  height: 31px;
}
</style>