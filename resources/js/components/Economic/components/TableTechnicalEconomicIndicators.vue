<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      {{ trans('economic_reference.technical_economic_indicators') }}
      “{{ org.name }}”
    </subtitle>

    <div class="mt-3 text-center border-grey">
      <div class="d-flex bg-header">
        <div class="p-3 border-grey d-flex align-items-center flex-80px">
          {{ trans('economic_reference.item_number') }}
        </div>

        <div class="p-3 border-grey d-flex align-items-center justify-content-center flex-320px">
          {{ trans('economic_reference.nomination') }}
        </div>

        <div class="p-3 border-grey d-flex align-items-center justify-content-center flex-150px">
          {{ trans('economic_reference.unit_of_measurement_short') }}
        </div>

        <div class="border-grey flex-320px">
          <div class="p-3">
            {{ trans('economic_reference.approved_budget_2020') }}
          </div>

          <div class="d-flex">
            <div v-for="(budget, index) in budget2020"
                 :key="index"
                 :class="index % 2 === 1 ? 'border-grey-left' : ''"
                 class="p-2 flex-grow-1">
              {{ budget }}
              {{ trans('economic_reference.dollar_per_bar') }}
            </div>
          </div>
        </div>

        <div class="border-grey flex-grow-1">
          <div class="p-3">
            {{ trans('economic_reference.when_changing_macro_indicators') }}
          </div>

          <div class="d-flex">
            <div v-for="(price, index) in reverseOilPrices"
                 :key="index"
                 :class="index % 2 === 1 ? 'border-grey-left' : ''"
                 class="p-2 flex-grow-1">
              {{ (+price).toLocaleString() }}
              {{ trans('economic_reference.dollar_per_bar') }}
            </div>
          </div>
        </div>
      </div>

      <div v-for="(item, itemIndex) in tableData"
           :key="itemIndex"
           :style="`background: ${item.color}`"
           class="d-flex">
        <div class="py-2 px-3 border-grey border-top-0 d-flex align-items-center justify-content-center flex-80px">
          {{ item.index }}
        </div>

        <div
            class="py-2 px-3 border-grey border-top-0 border-left-0 d-flex align-items-center justify-content-center flex-320px">
          {{ item.title }}
        </div>

        <div
            class="py-2 px-3 border-grey border-top-0 border-left-0 d-flex align-items-center justify-content-center flex-150px">
          {{ item.dimension }}
        </div>

        <div class="d-flex flex-320px">
          <div v-for="(budget, index) in item.budget2020"
               :key="index"
               class="py-2 px-3 border-grey border-top-0 border-left-0 flex-grow-1">
            {{ budget.value }}
          </div>
        </div>

        <div class="d-flex flex-grow-1">
          <div v-for="(value, index) in item.values"
               :key="index"
               class="py-2 px-3 border-grey border-top-0 border-left-0"
               style="flex: 1 0 100px; white-space: pre-line"
          >{{ typeof value === 'string' ? value : (+(value).toFixed(2)).toLocaleString() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "./Subtitle";

export default {
  name: "TableTechnicalEconomicIndicators",
  components: {
    Subtitle
  },
  props: {
    org: {
      required: true,
      type: Object
    },
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
  methods: {
    costPriceValue(index) {
      let scenario = this.oilPriceScenarios[index]

      let key = 'original_value_optimized'

      return +scenario.Overall_expenditures[key]
          / (+scenario.production_local[key] + (+scenario.production_export[key]))
    },

    oilSaleValue(index) {
      let scenario = this.oilPriceScenarios[index]

      let key = 'original_value_optimized'

      return +scenario.production_export[key] + (+scenario.production_local[key])
    },

    oilSalePriceExportValue(index) {
      let scenario = this.oilPriceScenarios[index]

      let key = 'original_value_optimized'

      return 1000 * (+scenario.Revenue_export[key] / (+scenario.production_export[key] * (+this.scenario.dollar_rate) * 7.2))
    },

    oilSalePriceLocalValue(index) {
      let scenario = this.oilPriceScenarios[index]

      let key = 'original_value_optimized'

      return +scenario.Revenue_local[key] / +scenario.production_local[key]
    },
  },
  computed: {
    tableData() {
      return [
        {
          index: '',
          title: `${this.trans('economic_reference.course')} KZT/USD`,
          dimension: this.trans('economic_reference.tenge'),
          values: this.reverseOilPrices.map(() => this.scenario.dollar_rate),
          budget2020: this.budget2020Map,
          color: '#151E70',
        },
        {
          index: '1',
          title: this.trans('economic_reference.oil_production'),
          dimension: this.trans('economic_reference.thousand_tons'),
          values: this.reverseOilPrices.map((oilPrice, index) =>
              +this.oilPriceScenarios[index].oil.original_value_optimized / 1000
          ),
          budget2020: this.budget2020Map,
          color: '#AC7550',
        },
        {
          index: '2',
          title: this.trans('economic_reference.total_oil_sales'),
          dimension: this.trans('economic_reference.thousand_tons'),
          values: this.reverseOilPrices.map((oilPrice, index) => this.oilSaleValue(index) / 1000),
          budget2020: this.budget2020Map,
          color: '#AC7550',
        },
        {
          index: '',
          title: this.trans('economic_reference.export'),
          dimension: this.trans('economic_reference.thousand_tons'),
          values: this.reverseOilPrices.map((oilPrice, index) =>
              +this.oilPriceScenarios[index].production_export.original_value_optimized / 1000
          ),
          budget2020: this.budget2020Map,
          color: '#313560',
        },
        {
          index: '',
          title: this.trans('economic_reference.home_market'),
          dimension: this.trans('economic_reference.thousand_tons'),
          values: this.reverseOilPrices.map((oilPrice, index) =>
              +this.oilPriceScenarios[index].production_local.original_value_optimized / 1000
          ),
          budget2020: this.budget2020Map,
          color: '#272953',
        },
        {
          index: '3',
          title: this.trans('economic_reference.oil_sale_prices'),
          dimension: '',
          values: this.reverseOilPrices.map(() => ''),
          budget2020: this.budget2020Map,
          color: '#313560',
        },
        {
          index: '',
          title: this.trans('economic_reference.export'),
          dimension: `$ / bbl`,
          values: this.reverseOilPrices.map((oilPrice, index) => this.oilSalePriceExportValue(index) / 1000),
          budget2020: this.budget2020Map,
          color: '#272953',
        },
        {
          index: '',
          title: this.trans('economic_reference.home_market'),
          dimension: `${this.trans('economic_reference.thousand')} ${this.trans('economic_reference.tenge_per_ton')}`,
          values: this.reverseOilPrices.map((oilPrice, index) => this.oilSalePriceLocalValue(index) / 1000),
          budget2020: this.budget2020Map,
          color: '#313560',
        },
        {
          index: '4',
          title: this.trans('economic_reference.well_stock'),
          dimension: '',
          values: this.reverseOilPrices.map((oilPrice, index) =>
              +this.oilPriceScenarios[index].uwi_count_optimize
          ),
          budget2020: this.budget2020Map,
          color: '#AC7550',
        },
        {
          index: '4.1',
          title: this.trans('economic_reference.shutdown_percentage'),
          dimension: '',
          values: this.reverseOilPrices.map((oilPrice, index) =>
              `${this.trans('economic_reference.cat_1')}: ${this.oilPriceScenarios[index].percent_stop_cat_1 * 100}%\n` +
              `${this.trans('economic_reference.cat_2')}: ${this.oilPriceScenarios[index].percent_stop_cat_2 * 100}%`,
          ),
          budget2020: this.budget2020Map,
          color: '#313560',
        },
        {
          index: '5',
          title: this.trans('economic_reference.number_pp'),
          dimension: '$ / bbl',
          values: this.reverseOilPrices.map(() => ''),
          budget2020: this.budget2020Map,
          color: '#272953',
        },
        {
          index: '6',
          title: this.trans('economic_reference.income'),
          dimension: '$ / bbl',
          values: this.reverseOilPrices.map((oilPrice, index) =>
              +this.oilPriceScenarios[index].Revenue_total.original_value_optimized / 1000000
          ),
          budget2020: this.budget2020Map,
          color: '#106B4B',
        },
        {
          index: '7',
          title: this.trans('economic_reference.total_expenses'),
          dimension: '$ / bbl',
          values: this.reverseOilPrices.map((oilPrice, index) =>
              +this.oilPriceScenarios[index].Overall_expenditures.original_value_optimized / 1000000
          ),
          budget2020: this.budget2020Map,
          color: '#106B4B',
        },
        {
          index: '7.1',
          title: this.trans('economic_reference.cost_price_including'),
          dimension: `${this.trans('economic_reference.thousand')} ${this.trans('economic_reference.tenge_per_ton')}`,
          values: this.reverseOilPrices.map((oilPrice, index) => this.costPriceValue(index) / 1000),
          budget2020: this.budget2020Map,
          color: '#313560'
        },
      ]
    },

    budget2020() {
      return [60, 50]
    },

    budget2020Map() {
      return this.budget2020.map(budget => ({budget: budget, value: ''}))
    },

    oilPriceScenarios() {
      return this.reverseOilPrices.map(oilPrice =>
          this.scenarios
              .filter(scenario =>
                  scenario.oil_price === oilPrice &&
                  scenario.dollar_rate === this.scenario.dollar_rate &&
                  scenario.coef_cost_WR_payroll === this.scenario.coef_cost_WR_payroll &&
                  scenario.coef_Fixed_nopayroll === this.scenario.coef_Fixed_nopayroll
              )
              .reduce((prev, current) => (+prev.operating_profit_12m_optimize > +current.operating_profit_12m_optimize) ? prev : current)
      )
    },

    reverseOilPrices() {
      return [...this.oilPrices].reverse()
    },
  },
}
</script>

<style scoped>
.border-grey {
  border: 1px solid #454D7D
}

.border-grey-left {
  border-left: 1px solid #454D7D
}

.border-left-0 {
  border-left: unset;
}

.border-top-0 {
  border-top: unset;
}

.bg-header {
  background: #333975;
}

.flex-80px {
  flex: 0 0 80px;
}

.flex-150px {
  flex: 0 0 150px;
}

.flex-320px {
  flex: 0 0 320px;
}
</style>