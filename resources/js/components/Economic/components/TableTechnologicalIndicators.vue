<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      {{ trans('economic_reference.technological_indicators') }}
    </subtitle>

    <div class="mt-3 text-center border-grey">
      <div class="d-flex bg-header" style="font-weight: 600">
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

      <div v-for="(item, index) in tableData"
           :key="index"
           :class="index % 2 === 0 ? 'bg-light-blue' : 'bg-deep-blue'"
           class="d-flex">
        <div
            :class="item.bold ? 'font-weight-bold' : ''"
            class="py-2 px-3 border-grey text-center flex-300px">
          {{ item.title }}
        </div>

        <div class="py-2 px-3 border-grey text-center flex-150px">
          {{ item.dimension }}
        </div>

        <div v-for="(price, priceIndex) in reverseOilPrices"
             :key="`${index}_${priceIndex}`"
             :style="`flex-basis: ${100 / reverseOilPrices.length}%`"
             class="py-2 px-3 border-grey text-center">
          {{ item.values[priceIndex].toLocaleString() }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "./Subtitle";

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
      let scenarios = this.scenarios.filter(scenario =>
          scenario.dollar_rate === this.scenario.dollar_rate &&
          scenario.coef_cost_WR_payroll === this.scenario.coef_cost_WR_payroll &&
          scenario.coef_Fixed_nopayroll === this.scenario.coef_Fixed_nopayroll
      )

      return this.reverseOilPrices.map(oilPrice => {
        return scenarios
            .filter(scenario => scenario.oil_price === oilPrice)
            .reduce((prev, current) => (+prev.operating_profit_12m_optimize > +current.operating_profit_12m_optimize) ? prev : current)
      })
    },

    tableData() {
      return [
        {
          title: this.trans('economic_reference.oil_production'),
          dimension: `${this.trans('economic_reference.thousand_tons')}/${this.trans('economic_reference.year')}`,
          values: this.filteredData.map(item =>
              (+item.oil.original_value_optimized / 1000).toFixed(2)
          )
        },
        {
          title: this.trans('economic_reference.production_from_gtm'),
          dimension: `${this.trans('economic_reference.thousand_tons')}/${this.trans('economic_reference.year')}`,
          values: this.filteredData.map(item => (+item.gtm_oil / 1000).toFixed(2))
        },
        {
          title: 'в т.ч. от ВНС',
          dimension: `${this.trans('economic_reference.thousand_tons')}/${this.trans('economic_reference.year')}`,
          values: this.filteredData.map(item => '')
        },
        {
          title: 'в т.ч. от ГТМ',
          dimension: `${this.trans('economic_reference.thousand_tons')}/${this.trans('economic_reference.year')}`,
          values: this.filteredData.map(item => '')
        },
        {
          title: this.trans('economic_reference.liquid_production'),
          dimension: `${this.trans('economic_reference.thousand')} ${this.trans('economic_reference.cubic_meter_per_year')}`,
          values: this.filteredData.map(item =>
              (+item.liquid.original_value_optimized / 1000).toFixed(2)
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
          values: this.filteredData.map(item => item.uwi_count.original_value_optimized)
        },
        {
          title: this.trans('economic_reference.shutdown_unprofitable_wells'),
          dimension: this.trans('economic_reference.wells_count_short'),
          values: this.filteredData.map(item => {
            let cat1 = +item.uwi_count_profitless_cat_1.original_value_optimized

            let cat2 = +item.uwi_count_profitless_cat_2.original_value_optimized

            return cat1 + cat2
          })
        },
        {
          title: this.trans('economic_reference.loss_production_due_to_shutdown'),
          dimension: this.trans('economic_reference.thousand_tons'),
          values: this.filteredData.map(item => {
            let cat1 = +item.oil_profitless_cat_1.original_value_optimized

            let cat2 = +item.oil_profitless_cat_2.original_value_optimized

            return ((cat1 + cat2) / 1000).toFixed(2)
          })
        },
        {
          title: this.trans('economic_reference.count_prs'),
          dimension: `${this.trans('economic_reference.rem_short')}/${this.trans('economic_reference.year')}`,
          values: this.filteredData.map(item => +item.prs.original_value_optimized)
        },
        {
          title: 'Количество бригад ПРС',
          dimension: '',
          values: this.filteredData.map(item => '')
        },
        {
          title: 'Количество бригад КРС',
          dimension: `${this.trans('economic_reference.rem_short')}/${this.trans('economic_reference.year')}`,
          values: this.filteredData.map(item => '')
        },
        {
          title: 'Количество ГТМ по видам',
          dimension: this.trans('economic_reference.wells_count_short'),
          values: this.filteredData.map(item => ''),
          bold: true
        },
        {
          title: 'ВНС+ВНС с ГРП',
          dimension: this.trans('economic_reference.wells_count_short'),
          values: this.filteredData.map(item => '')
        },
        {
          title: 'РИР',
          dimension: this.trans('economic_reference.wells_count_short'),
          values: this.filteredData.map(item => '')
        },
        {
          title: 'Углубление',
          dimension: this.trans('economic_reference.wells_count_short'),
          values: this.filteredData.map(item => '')
        },
        {
          title: 'Ввод из бездействия',
          dimension: this.trans('economic_reference.wells_count_short'),
          values: this.filteredData.map(item => '')
        }
      ]
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
</style>