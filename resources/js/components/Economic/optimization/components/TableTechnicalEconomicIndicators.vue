<template>
  <div>
    <subtitle font-size="16" style="line-height: 18px">
      {{ trans('economic_reference.technical_economic_indicators') }}
      “{{ org.name }}”
    </subtitle>

    <div class="mt-2 text-center border-grey">
      <div class="d-flex bg-header" style="padding-right: 10px">
        <div class="p-3 border-grey d-flex align-items-center flex-80px">
          {{ trans('economic_reference.item_number') }}
        </div>

        <div class="p-3 border-grey d-flex align-items-center justify-content-start flex-320px">
          {{ trans('economic_reference.nomination') }}
        </div>

        <div class="p-3 border-grey d-flex align-items-center justify-content-start flex-150px">
          {{ trans('economic_reference.unit_of_measurement_short') }}
        </div>

        <div class="border-grey flex-200px d-flex flex-column">
          <div class="p-3 text-left">
            {{ trans('economic_reference.approved_budget') }}
          </div>

          <div class="flex-grow-1 d-flex align-items-center">
            <div v-for="(budget, index) in approvedBudget"
                 :key="index"
                 :class="index % 2 === 1 ? 'border-grey-left' : ''"
                 class="p-2 flex-grow-1 text-left">
              {{ localeValue(+budget) }}
              {{ trans('economic_reference.dollar_per_bar') }}
            </div>
          </div>
        </div>

        <div class="border-grey flex-grow-1">
          <div class="p-3 text-left">
            {{ trans('economic_reference.when_changing_macro_indicators') }}
          </div>

          <div class="d-flex">
            <div class="p-2 flex-grow-1 line-height-14px text-left" style="white-space: pre-line"
            > {{ localeValue(+baseScenario.oil_price) }} {{ trans('economic_reference.dollar_per_bar') }}
              {{ trans('economic_reference.basic').toLocaleLowerCase() }}
            </div>

            <div v-for="(price, index) in reverseOilPrices"
                 :key="index"
                 :class="index % 2 === 0 ? 'border-grey-left' : ''"
                 class="p-2 flex-grow-1 d-flex align-items-center justify-content-start">
              {{ localeValue(+price) }}
              {{ trans('economic_reference.dollar_per_bar') }}
            </div>
          </div>
        </div>
      </div>

      <div :style="`overflow-y: scroll; overflow-x: hidden; height: ${tableHeight}`"
           class="customScroll">
        <div v-for="(item, itemIndex) in tableData"
             :key="itemIndex"
             :style="`background: ${item.color}`"
             class="d-flex">
          <div class="py-2 px-3 border-grey border-top-0 d-flex align-items-center justify-content-center flex-80px">
            {{ item.index }}
          </div>

          <div
              class="py-2 px-3 border-grey border-top-0 border-left-0 d-flex align-items-center justify-content-start flex-320px">
            {{ item.title }}
          </div>

          <div
              class="py-2 px-3 border-grey border-top-0 border-left-0 d-flex align-items-center justify-content-start flex-150px">
            {{ item.dimension }}
          </div>

          <div class="d-flex flex-200px">
            <div v-for="(budget, index) in item.approvedBudget"
                 :key="index"
                 class="py-2 px-3 border-grey border-top-0 border-left-0 flex-grow-1 text-right">
              {{ budget.value ? localeValue(+budget.value) : '' }}
            </div>
          </div>

          <div class="d-flex flex-grow-1">
            <div v-for="(value, index) in item.values"
                 :key="index"
                 class="py-2 px-3 border-grey border-top-0 border-left-0 text-right"
                 style="flex: 1 0 100px; white-space: pre-line"
            >{{ typeof value === 'string' ? value : localeValue(+value) }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {formatValueMixin} from "../../mixins/formatMixin";

import Subtitle from "../../components/Subtitle";

export default {
  name: "TableTechnicalEconomicIndicators",
  components: {
    Subtitle
  },
  mixins: [
    formatValueMixin
  ],
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
    isFullscreen: {
      required: false,
      type: Boolean
    },
    manufacturingProgram: {
      required: false,
      type: Object,
      default: null
    }
  },
  methods: {
    costPriceValue(index = null, scenario = null) {
      if (scenario === null) {
        scenario = this.oilPriceScenarios[index]
      }

      let denominator = +scenario.production_local_optimize + +scenario.production_export_optimize

      return denominator ?
          +scenario.Overall_expenditures_full_optimize / denominator
          : 0
    },

    oilSaleValue(index = null, scenario = null) {
      if (scenario === null) {
        scenario = this.oilPriceScenarios[index]
      }

      return +scenario.production_export_optimize + +scenario.production_local_optimize
    },

    oilSalePriceExportValue(index = null, scenario = null) {
      if (scenario === null) {
        scenario = this.oilPriceScenarios[index]
      }

      let denominator = +scenario.production_export_optimize * +this.scenario.dollar_rate

      return denominator
          ? 1000 * (+scenario.Revenue_export_optimize / (denominator * +this.scenario.Barrel_ratio_export_scenario))
          : 0
    },

    oilSalePriceLocalValue(index = null, scenario = null) {
      if (scenario === null) {
        scenario = this.oilPriceScenarios[index]
      }

      return +scenario.production_local_optimize
          ? +scenario.Revenue_local_optimize / +scenario.production_local_optimize
          : 0
    },

    oilSalePriceValue(index = null, scenario = null) {
      if (scenario === null) {
        scenario = this.oilPriceScenarios[index]
      }

      let oilSaleValue = this.oilSaleValue(index, scenario)

      return oilSaleValue
          ? +scenario.Revenue_total_optimize / oilSaleValue
          : 0
    },
  },
  computed: {
    tableData() {
      return [
        {
          index: '1',
          title: `${this.trans('economic_reference.course')} KZT/USD`,
          dimension: this.trans('economic_reference.tenge'),
          values: [
            ...[this.baseScenario.dollar_rate],
            ...this.reverseOilPrices.map(() => this.scenario.dollar_rate)
          ],
          approvedBudget: this.approvedBudget.map(budget => ({
            budget: budget,
            value: this.manufacturingProgram ? this.manufacturingProgram.dollar_rate : ''
          })),
          color: '#151E70',
        },
        {
          index: '2',
          title: this.trans('economic_reference.oil_production'),
          dimension: this.trans('economic_reference.thousand_tons'),
          values: [
            ...[+this.baseScenario.oil_optimize / 1000],
            ...this.reverseOilPrices.map((oilPrice, index) =>
                +this.oilPriceScenarios[index].oil_optimize / 1000
            )
          ],
          approvedBudget: this.approvedBudget.map(budget => ({
            budget: budget,
            value: this.manufacturingProgram ? this.manufacturingProgram.oil : ''
          })),
          color: '#AC7550',
        },
        {
          index: '3',
          title: this.trans('economic_reference.count_prs'),
          dimension: this.trans('economic_reference.units'),
          values: [
            ...[+this.baseScenario.prs_optimize],
            ...this.reverseOilPrices.map((oilPrice, index) =>
                +this.oilPriceScenarios[index].prs_optimize
            )
          ],
          approvedBudget: this.approvedBudget.map(budget => ({
            budget: budget,
            value: this.manufacturingProgram
                ? this.manufacturingProgram.prs
                : ''
          })),
          color: '#313560',
        },
        {
          index: '4',
          title: this.trans('economic_reference.liquid_production'),
          dimension: this.trans('economic_reference.thousand_tons'),
          values: [
            ...[+this.baseScenario.liquid_optimize / 1000],
            ...this.reverseOilPrices.map((oilPrice, index) =>
                +this.oilPriceScenarios[index].liquid_optimize / 1000
            )
          ],
          approvedBudget: this.approvedBudgetMap,
          color: '#272953',
        },
        {
          index: '5',
          title: this.trans('economic_reference.total_oil_sales'),
          dimension: this.trans('economic_reference.thousand_tons'),
          values: [
            ...[this.oilSaleValue(null, this.baseScenario) / 1000],
            ...this.reverseOilPrices.map((oilPrice, index) => this.oilSaleValue(index) / 1000)
          ],
          approvedBudget: this.approvedBudget.map(budget => ({
            budget: budget,
            value: this.manufacturingProgram
                ? this.manufacturingProgram.oil_sale
                : ''
          })),
          color: '#AC7550',
        },
        {
          index: '5.1',
          title: this.trans('economic_reference.export'),
          dimension: this.trans('economic_reference.thousand_tons'),
          values: [
            ...[+this.baseScenario.production_export_optimize / 1000],
            ...this.reverseOilPrices.map((oilPrice, index) =>
                +this.oilPriceScenarios[index].production_export_optimize / 1000
            )
          ],
          approvedBudget: this.approvedBudget.map(budget => ({
            budget: budget,
            value: this.manufacturingProgram
                ? this.manufacturingProgram.oil_sale_export
                : ''
          })),
          color: '#313560',
        },
        {
          index: '5.2',
          title: this.trans('economic_reference.home_market'),
          dimension: this.trans('economic_reference.thousand_tons'),
          values: [
            ...[+this.baseScenario.production_local_optimize / 1000],
            ...this.reverseOilPrices.map((oilPrice, index) =>
                +this.oilPriceScenarios[index].production_local_optimize / 1000
            )
          ],
          approvedBudget: this.approvedBudget.map(budget => ({
            budget: budget,
            value: this.manufacturingProgram
                ? this.manufacturingProgram.oil_sale_local
                : ''
          })),
          color: '#272953',
        },
        {
          index: '6',
          title: this.trans('economic_reference.oil_sale_prices'),
          dimension: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge_per_ton')}
          `,
          values: [
            ...[this.oilSalePriceValue(null, this.baseScenario) / 1000],
            ...this.reverseOilPrices.map((oilPrice, index) => this.oilSalePriceValue(index) / 1000)
          ],
          approvedBudget: this.approvedBudget.map(budget => ({
            budget: budget,
            value: this.manufacturingProgram
                ? (+this.manufacturingProgram.revenue / +this.manufacturingProgram.oil_sale)
                : ''
          })),
          color: '#313560',
        },
        {
          index: '6.1',
          title: this.trans('economic_reference.export'),
          dimension: `$ / bbl`,
          values: [
            ...[this.oilSalePriceExportValue(null, this.baseScenario) / 1000],
            ...this.reverseOilPrices.map((oilPrice, index) => this.oilSalePriceExportValue(index) / 1000)
          ],
          approvedBudget: this.approvedBudgetMap,
          color: '#272953',
        },
        {
          index: '6.2',
          title: this.trans('economic_reference.home_market'),
          dimension: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge_per_ton')}
          `,
          values: [
            ...[this.oilSalePriceLocalValue(null, this.baseScenario) / 1000],
            ...this.reverseOilPrices.map((oilPrice, index) => this.oilSalePriceLocalValue(index) / 1000)
          ],
          approvedBudget: this.approvedBudgetMap,
          color: '#313560',
        },
        {
          index: '7',
          title: this.trans('economic_reference.well_stock'),
          dimension: this.trans('economic_reference.well_short').toLocaleLowerCase(),
          values: [
            ...[this.baseScenario.uwi_count_optimize],
            ...this.reverseOilPrices.map((oilPrice, index) => +this.oilPriceScenarios[index].uwi_count_optimize)
          ],
          approvedBudget: this.approvedBudget.map(budget => ({
            budget: budget,
            value: this.manufacturingProgram
                ? this.manufacturingProgram.wells
                : ''
          })),
          color: '#AC7550',
        },
        {
          index: '7.1',
          title: this.trans('economic_reference.shutdown_percentage'),
          dimension: '%',
          values: [
            ...[`${this.trans('economic_reference.cat_1')}: 0%\n${this.trans('economic_reference.cat_2')}: 0%`],
            ...this.reverseOilPrices.map((oilPrice, index) =>
                `${this.trans('economic_reference.cat_1')}: ${this.oilPriceScenarios[index].percent_stop_cat_1 * 100}%\n` +
                `${this.trans('economic_reference.cat_2')}: ${this.oilPriceScenarios[index].percent_stop_cat_2 * 100}%`,
            )
          ],
          approvedBudget: this.approvedBudgetMap,
          color: '#313560',
        },
        {
          index: '7.2',
          title: this.trans('economic_reference.count_shutdown_wells'),
          dimension: this.trans('economic_reference.well_short').toLocaleLowerCase(),
          values: [
            ...[+this.baseScenario.uwi_count - +this.baseScenario.uwi_count_optimize],
            ...this.reverseOilPrices.map((oilPrice, index) =>
                +this.oilPriceScenarios[index].uwi_count - +this.oilPriceScenarios[index].uwi_count_optimize
            )
          ],
          approvedBudget: this.approvedBudgetMap,
          color: '#272953',
        },
        {
          index: '8',
          title: this.trans('economic_reference.income'),
          dimension: `
            ${this.trans('economic_reference.billion')}
            ${this.trans('economic_reference.tenge')}
          `,
          values: [
            ...[this.localeValue(this.baseScenario.Revenue_total_optimize, 1000000000)],
            ...this.reverseOilPrices.map((oilPrice, index) =>
                this.localeValue(this.oilPriceScenarios[index].Revenue_total_optimize, 1000000000)
            )
          ],
          approvedBudget: this.approvedBudget.map(budget => ({
            budget: budget,
            value: this.manufacturingProgram
                ? (+this.manufacturingProgram.revenue / 1000)
                : ''
          })),
          color: '#106B4B',
        },
        {
          index: '9',
          title: this.trans('economic_reference.costs'),
          dimension: `
            ${this.trans('economic_reference.billion')}
            ${this.trans('economic_reference.tenge')}
          `,
          values: [
            ...[this.localeValue(this.baseScenario.Overall_expenditures_full_optimize, 1000000000)],
            ...this.reverseOilPrices.map((oilPrice, index) =>
                this.localeValue(this.oilPriceScenarios[index].Overall_expenditures_full_optimize, 1000000000)
            )
          ],
          approvedBudget: this.approvedBudget.map(budget => ({
            budget: budget,
            value: this.manufacturingProgram
                ? (+this.manufacturingProgram.expenditures / 1000)
                : ''
          })),
          color: '#106B4B',
        },
        {
          index: '10',
          title: this.trans('economic_reference.cost_price'),
          dimension: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge_per_ton')}
          `,
          values: [
            ...[this.costPriceValue(null, this.baseScenario) / 1000],
            ...this.reverseOilPrices.map((oilPrice, index) => this.costPriceValue(index) / 1000)
          ],
          approvedBudget: this.approvedBudget.map(budget => ({
            budget: budget,
            value: this.manufacturingProgram ?
                (+this.manufacturingProgram.expenditures / +this.manufacturingProgram.oil_sale)
                : ''
          })),
          color: '#106B4B',
        },
        {
          index: '11',
          title: this.trans('economic_reference.operating_profit'),
          dimension: `
            ${this.trans('economic_reference.billion')}
            ${this.trans('economic_reference.tenge')}
          `,
          values: [
            ...[this.localeValue(this.baseScenario.Operating_profit_optimize, 1000000000)],
            ...this.reverseOilPrices.map((oilPrice, index) =>
                this.localeValue(this.oilPriceScenarios[index].Operating_profit_optimize, 1000000000)
            )
          ],
          approvedBudget: this.approvedBudget.map(budget => ({
            budget: budget,
            value: this.manufacturingProgram
                ? (+this.manufacturingProgram.operating_profit / 1000)
                : ''
          })),
          color: '#106B4B',
        },
      ]
    },

    approvedBudget() {
      return this.manufacturingProgram
          ? [this.manufacturingProgram.oil_price]
          : [60, 50]
    },

    approvedBudgetMap() {
      return this.approvedBudget.map(budget => ({budget: budget, value: ''}))
    },

    oilPriceScenarios() {
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

    reverseOilPrices() {
      return [...this.oilPrices].reverse()
    },

    baseScenario() {
      return this.scenarios
          .find(scenario =>
              +scenario.oil_price === +this.reverseOilPrices[0] &&
              +scenario.dollar_rate === +this.scenario.dollar_rate
          )
          .variants
          .find(variant =>
              +variant.coef_cost_WR_payroll === +this.scenario.coef_cost_WR_payroll &&
              +variant.coef_Fixed_nopayroll === +this.scenario.coef_Fixed_nopayroll &&
              +variant.percent_stop_cat_1 === 0 &&
              +variant.percent_stop_cat_2 === 0
          )
    },

    tableHeight() {
      return this.isFullscreen ? '555px' : '405px'
    }
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

.flex-200px {
  flex: 0 0 200px;
}

.flex-320px {
  flex: 0 0 320px;
}

.line-height-14px {
  line-height: 14px;
}

.customScroll::-webkit-scrollbar {
  width: 10px;
}
</style>