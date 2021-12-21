<template>
  <div>
    <subtitle font-size="16" style="line-height: 18px">
      {{ trans('economic_reference.technological_indicators') }}
    </subtitle>

    <div class="mt-2 text-center border-grey">
      <div class="d-flex bg-header" style="padding-right: 10px">
        <div class="py-2 px-3 border-grey text-center flex-300px">
          {{ trans('economic_reference.indicators') }}
        </div>

        <div class="py-2 px-3 border-grey text-center flex-150px">
          {{ trans('economic_reference.unit_of_measurement_short') }}
        </div>

        <div v-for="price in reverseOilPrices"
             :key="price"
             :style="`flex-basis: ${100 / reverseOilPrices.length}%`"
             class="py-2 px-3 border-grey text-center">
          {{ (+price).toLocaleString() }}{{ trans('economic_reference.dollar_per_bar') }}
        </div>
      </div>

      <div :style="`overflow-y: scroll; height: ${tableHeight}`"
           class="customScroll d-flex flex-column">
        <div v-for="(item, index) in tableData"
             :key="index"
             :class="index % 2 === 0 ? 'bg-light-blue' : 'bg-deep-blue'"
             class="flex-grow-1 d-flex">
          <div
              :class="item.bold ? 'font-weight-bold' : ''"
              class="py-2 px-3 border-grey text-center flex-300px d-flex align-items-center justify-content-center">
            {{ item.title }}
          </div>

          <div class="py-2 px-3 border-grey text-center flex-150px d-flex align-items-center justify-content-center">
            {{ item.dimension }}
          </div>

          <div v-for="(price, priceIndex) in reverseOilPrices"
               :key="`${index}_${priceIndex}`"
               :style="`flex-basis: ${100 / reverseOilPrices.length}%`"
               class="py-2 px-3 border-grey text-center d-flex align-items-center justify-content-center">
            {{ item.values[priceIndex] ? (+item.values[priceIndex]).toLocaleString() : '' }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "../../components/Subtitle";

export default {
  name: "TableTechnologicalIndicators",
  components: {
    Subtitle
  },
  props: {
    scenarios: {
      required: true,
      type: Array
    },
    scenario: {
      required: true,
      type: Object
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
  computed: {
    reverseOilPrices() {
      return [...this.oilPrices].reverse()
    },

    scenariosByOilPrice() {
      let scenariosByDollarRate = this.scenarios.filter(scenario =>
          +scenario.dollar_rate === +this.scenario.dollar_rate
      )

      return this.reverseOilPrices.map(oilPrice => {
        let variants = []

        scenariosByDollarRate.forEach(scenario => {
          if (+scenario.oil_price !== +oilPrice) return

          scenario.variants.forEach(variant => {
            if (+variant.coef_cost_WR_payroll !== +this.scenario.coef_cost_WR_payroll) return

            if (+variant.coef_Fixed_nopayroll !== +this.scenario.coef_Fixed_nopayroll) return

            variants.push(variant)
          })
        })

        return variants.reduce((prev, current) =>
            (+prev.Operating_profit_optimize > +current.Operating_profit_optimize) ? prev : current
        )
      })
    },

    tableData() {
      let rows = [
        {
          title: this.trans('economic_reference.oil_production'),
          dimension: `
            ${this.trans('economic_reference.thousand_tons')}/
            ${this.trans('economic_reference.year')}
          `,
          values: this.scenariosByOilPrice.map(scenario =>
              (+scenario.oil_optimize / 1000).toFixed(2)
          )
        }
      ]

      let gtms = Object.keys(this.gtms)

      let gtmsCount = gtms.length

      if (gtmsCount) {
        let gtmsOil = gtms.map(gtmId => ({
          title: this.gtms[gtmId].name,
          dimension: `
              ${this.trans('economic_reference.thousand_tons')}/
              ${this.trans('economic_reference.year')}
            `,
          values: this.scenariosByOilPrice.map(scenario => {
            let oil = this.gtms[gtmId].oil_total[scenario.oil_price] || 0

            return (+oil / 1000).toFixed(2)
          })
        }))

        rows.push(
            {
              title: this.trans('economic_reference.production_from_gtm'),
              dimension: `
                ${this.trans('economic_reference.thousand_tons')}/
                ${this.trans('economic_reference.year')}
              `,
              values: this.scenariosByOilPrice.map(scenario =>
                  (+scenario.gtm_oil / 1000).toFixed(2)
              )
            },
            ...gtmsOil
        )
      }

      rows.push(...[
        {
          title: this.trans('economic_reference.liquid_production'),
          dimension: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.cubic_meter_per_year')}
          `,
          values: this.scenariosByOilPrice.map(scenario =>
              (+scenario.liquid_optimize / 1000).toFixed(2)
          )
        },
        {
          title: this.trans('economic_reference.injection_volume'),
          dimension: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.cubic_meter_per_year')}
          `,
          values: this.scenariosByOilPrice.map(scenario => '')
        },
        {
          title: this.trans('economic_reference.active_well_stock'),
          dimension: this.trans('economic_reference.wells_count_short'),
          values: this.scenariosByOilPrice.map(item => item.uwi_count_optimize)
        },
        {
          title: this.trans('economic_reference.shutdown_unprofitable_wells'),
          dimension: this.trans('economic_reference.wells_count_short'),
          values: this.scenariosByOilPrice.map(scenario => {
            let cat1 = +scenario.uwi_count_profitless_cat_1_optimize

            let cat2 = +scenario.uwi_count_profitless_cat_2_optimize

            return cat1 + cat2
          })
        },
        {
          title: this.trans('economic_reference.loss_production_due_to_shutdown'),
          dimension: this.trans('economic_reference.thousand_tons'),
          values: this.scenariosByOilPrice.map(scenario => {
            let cat1 = +scenario.oil_profitless_cat_1_optimize

            let cat2 = +scenario.oil_profitless_cat_2_optimize

            return ((cat1 + cat2) / 1000).toFixed(2)
          })
        },
        {
          title: this.trans('economic_reference.count_prs'),
          dimension: `
            ${this.trans('economic_reference.rem_short')}/
            ${this.trans('economic_reference.year')}
          `,
          values: this.scenariosByOilPrice.map(scenario => +scenario.prs_optimize)
        },
        {
          title: this.trans('economic_reference.number_prs_brigades'),
          dimension: '',
          values: this.scenariosByOilPrice.map(scenario => '')
        },
        {
          title: this.trans('economic_reference.number_krs_brigades'),
          dimension: `
            ${this.trans('economic_reference.rem_short')}/
            ${this.trans('economic_reference.year')}
          `,
          values: this.scenariosByOilPrice.map(scenario => '')
        },
      ])

      if (gtms.length) {
        let gtmsAmount = gtms.map(gtmId => {
          return {
            title: this.gtms[gtmId].name,
            dimension: this.trans('economic_reference.wells_count_short'),
            values: this.scenariosByOilPrice.map(item =>
                this.gtms[gtmId].amount[item.oil_price] || 0
            )
          }
        })

        rows.push(
            {
              title: this.trans('economic_reference.number_gtms_by_type'),
              dimension: this.trans('economic_reference.wells_count_short'),
              values: this.scenariosByOilPrice.map(scenario => {
                let gtmsCount = 0

                if (scenario.gtms) {
                  for (const [month, gtms] of Object.entries(scenario.gtms)) {
                    gtms.forEach(gtm => gtmsCount += (+gtm.amount))
                  }
                }

                return gtmsCount
              }),
              bold: true
            },
            ...gtmsAmount
        )
      }

      return rows
    },

    gtms() {
      let gtmsByOilPrice = {}

      this.scenariosByOilPrice.forEach(scenario => {
        if (!scenario.gtms) return

        for (const [month, gtms] of Object.entries(scenario.gtms)) {
          gtms.forEach(gtm => {
            if (!gtmsByOilPrice.hasOwnProperty(gtm.id)) {
              gtmsByOilPrice[gtm.id] = {name: gtm.name, amount: {}, oil_total: {}}
            }

            if (!gtmsByOilPrice[gtm.id].amount.hasOwnProperty(scenario.oil_price)) {
              gtmsByOilPrice[gtm.id].amount[scenario.oil_price] = 0
            }

            if (!gtmsByOilPrice[gtm.id].oil_total.hasOwnProperty(scenario.oil_price)) {
              gtmsByOilPrice[gtm.id].oil_total[scenario.oil_price] = 0
            }

            gtmsByOilPrice[gtm.id].amount[scenario.oil_price] += gtm.amount

            gtmsByOilPrice[gtm.id].oil_total[scenario.oil_price] += gtm.oil_total * gtm.amount
          })
        }
      })

      return gtmsByOilPrice
    },

    tableHeight() {
      return this.isFullscreen ? '615px' : '465px'
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

.bg-light-blue {
  background: #313560;
}

.bg-deep-blue {
  background: #272953;
}

.flex-300px {
  flex: 0 0 300px;
}

.flex-150px {
  flex: 0 0 150px;
}

.customScroll::-webkit-scrollbar {
  width: 10px;
}
</style>