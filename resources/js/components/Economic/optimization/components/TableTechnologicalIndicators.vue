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

      <div class="customScroll d-flex flex-column"
           style="overflow-y: scroll; height: 465px">
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
  },
  computed: {
    reverseOilPrices() {
      return [...this.oilPrices].reverse()
    },

    filteredData() {
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
          dimension: `${this.trans('economic_reference.thousand_tons')}/${this.trans('economic_reference.year')}`,
          values: this.filteredData.map(item =>
              (+item.oil_optimize / 1000).toFixed(2)
          )
        }
      ]

      let gtms = Object.keys(this.gtms)

      let gtmsCount = gtms.length

      if (gtmsCount) {
        let gtmsOil = gtms.map(gtmId => {
          return {
            title: this.gtms[gtmId].name,
            dimension: `${this.trans('economic_reference.thousand_tons')}/${this.trans('economic_reference.year')}`,
            values: this.filteredData.map(item => {
              let oil = this.gtms[gtmId].oil_total[item.oil_price] || 0

              return (+oil / 1000).toFixed(2)
            })
          }
        })

        rows.push(
            {
              title: this.trans('economic_reference.production_from_gtm'),
              dimension: `${this.trans('economic_reference.thousand_tons')}/${this.trans('economic_reference.year')}`,
              values: this.filteredData.map(item => (+item.gtm_oil / 1000).toFixed(2))
            },
            ...gtmsOil
        )
      }

      rows.push(...[
        {
          title: this.trans('economic_reference.liquid_production'),
          dimension: `${this.trans('economic_reference.thousand')} ${this.trans('economic_reference.cubic_meter_per_year')}`,
          values: this.filteredData.map(item =>
              (+item.liquid_optimize / 1000).toFixed(2)
          )
        },
        {
          title: this.trans('economic_reference.injection_volume'),
          dimension: `${this.trans('economic_reference.thousand')} ${this.trans('economic_reference.cubic_meter_per_year')}`,
          values: this.filteredData.map(item => '')
        },
        {
          title: this.trans('economic_reference.active_well_stock'),
          dimension: this.trans('economic_reference.wells_count_short'),
          values: this.filteredData.map(item => item.uwi_count_optimize)
        },
        {
          title: this.trans('economic_reference.shutdown_unprofitable_wells'),
          dimension: this.trans('economic_reference.wells_count_short'),
          values: this.filteredData.map(item => {
            let cat1 = +item.uwi_count_profitless_cat_1_optimize

            let cat2 = +item.uwi_count_profitless_cat_2_optimize

            return cat1 + cat2
          })
        },
        {
          title: this.trans('economic_reference.loss_production_due_to_shutdown'),
          dimension: this.trans('economic_reference.thousand_tons'),
          values: this.filteredData.map(item => {
            let cat1 = +item.oil_profitless_cat_1_optimize

            let cat2 = +item.oil_profitless_cat_2_optimize

            return ((cat1 + cat2) / 1000).toFixed(2)
          })
        },
        {
          title: this.trans('economic_reference.count_prs'),
          dimension: `${this.trans('economic_reference.rem_short')}/${this.trans('economic_reference.year')}`,
          values: this.filteredData.map(item => +item.prs_optimize)
        },
        {
          title: this.trans('economic_reference.number_prs_brigades'),
          dimension: '',
          values: this.filteredData.map(item => '')
        },
        {
          title: this.trans('economic_reference.number_krs_brigades'),
          dimension: `${this.trans('economic_reference.rem_short')}/${this.trans('economic_reference.year')}`,
          values: this.filteredData.map(item => '')
        },
      ])

      if (gtms.length) {
        let gtmsAmount = gtms.map(gtmId => {
          return {
            title: this.gtms[gtmId].name,
            dimension: this.trans('economic_reference.wells_count_short'),
            values: this.filteredData.map(item => this.gtms[gtmId].amount[item.oil_price] || 0)
          }
        })

        rows.push(
            {
              title: this.trans('economic_reference.number_gtms_by_type'),
              dimension: this.trans('economic_reference.wells_count_short'),
              values: this.filteredData.map(item => {
                let gtmsCount = 0

                if (item.gtms) {
                  for (const [month, gtms] of Object.entries(JSON.parse(item.gtms))) {
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
      let data = {}

      this.filteredData.forEach(item => {
        if (!item.gtms) return

        for (const [month, gtms] of Object.entries(JSON.parse(item.gtms))) {
          gtms.forEach(gtm => {
            let name = `GTM_${gtm.id}`

            if (!data.hasOwnProperty(gtm.id)) {
              data[gtm.id] = {name: name, amount: {}, oil_total: {}}
            }

            if (!data[gtm.id].amount.hasOwnProperty(item.oil_price)) {
              data[gtm.id].amount[item.oil_price] = 0
            }

            if (!data[gtm.id].oil_total.hasOwnProperty(item.oil_price)) {
              data[gtm.id].oil_total[item.oil_price] = 0
            }

            data[gtm.id].amount[item.oil_price] += gtm.amount

            data[gtm.id].oil_total[item.oil_price] += gtm.oil_total * gtm.amount
          })
        }
      })

      return data
    },
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