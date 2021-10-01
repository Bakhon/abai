<template>
  <div style="height: 535px">
    <subtitle>
      <div class="font-size-16px line-height-18px">
        {{ trans('economic_reference.table_oil_price_options_title') }}
      </div>

      <div class="font-size-16px line-height-18px">
        “{{ org.name }}”
      </div>
    </subtitle>

    <div class="mt-2">
      <div class="text-center border-grey d-flex bg-header">
        <div
            v-for="(item, index) in tableKeys"
            :key="item.value"
            :style="`flex: ${item.flexGrow} 0 ${item.flexWidth}`"
            :class="index ? 'justify-content-center' : ''"
            class="p-3 border-grey d-flex align-items-center line-height-16px"
            style="white-space: normal">
          {{ item.title }}
        </div>
      </div>

      <div v-for="(item, index) in tableData"
           :key="index"
           :style="`background: ${item.color}`"
           class="d-flex">
        <div v-for="(key, keyIndex) in tableKeys"
             :key="key.value"
             :class="keyIndex ? 'text-center justify-content-center' : ''"
             :style="`flex: ${key.flexGrow} 0 ${key.flexWidth}; ${keyIndex ? '' : item.style}`"
             class="border-grey line-height-14px d-flex align-items-center px-3 py-2">
          {{
            typeof item[key.value] === 'string'
                ? item[key.value]
                : (+(item[key.value].toFixed(2))).toLocaleString()
          }}
        </div>
      </div>
    </div>

    <subtitle font-size="16" class="line-height-18px mt-3">
      {{ trans('economic_reference.cat_1_trips') }}: {{ scenario.percent_stop_cat_1 * 100 }}%,
      {{ trans('economic_reference.cat_2_trips') }}: {{ scenario.percent_stop_cat_2 * 100 }}%
    </subtitle>

    <div class="mt-2">
      <div v-for="(item, index) in tableDataOptimized"
           :key="index"
           :style="`background: ${item.color}`"
           class="d-flex">
        <div v-for="(key, keyIndex) in tableKeys"
             :key="key.value"
             :class="[
                 index ? 'px-3 py-2' : 'p-3',
                 keyIndex ? 'text-center justify-content-center' : ''
                 ]"
             :style="`flex: ${key.flexGrow} 0 ${key.flexWidth}; ${keyIndex ? '' : item.style}`"
             class="border-grey line-height-14px d-flex align-items-center">
          {{
            typeof item[key.value] === 'string'
                ? item[key.value]
                : (+(item[key.value].toFixed(2))).toLocaleString()
          }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "./Subtitle";

export default {
  name: "TableOilPriceOptions",
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
  },
  methods: {
    calcPrsPerUwi(prs, uwi_count) {
      return +uwi_count === 0
          ? 0
          : +prs / +uwi_count
    },

    calcLiquid(liquid, oil) {
      return +liquid === 0
          ? 0
          : 100 * (+liquid - (+oil)) / liquid
    },

    calcAvgQn(oil, days_worked) {
      return +days_worked === 0
          ? 0
          : +oil / +days_worked
    },

    calcRevenueTotal(value) {
      return +value / 1000000000
    },

    calcOil(value) {
      return +value / 1000
    },

    calcOverallExpenditures(value) {
      return +value / 1000000000
    },

    calcOperatingProfit(value) {
      return +value / 1000000000
    },
  },
  computed: {
    tableData() {
      return [
        {
          title: `${this.trans('economic_reference.at_export_price')} ${+this.scenario.oil_price}$/bbl`,
          uwiCount: this.trans('economic_reference.units'),
          prsCount: this.trans('economic_reference.units'),
          prsPerUwi: this.trans('economic_reference.units'),
          liquid: '%',
          avgQn: this.trans('economic_reference.tn_per_day'),
          oil: this.trans('economic_reference.thousand_tons'),
          revenueTotal: `${this.trans('economic_reference.billion')} ${this.trans('economic_reference.tenge')}`,
          overallExpenditures: `${this.trans('economic_reference.billion')} ${this.trans('economic_reference.tenge')}`,
          operatingProfit: `${this.trans('economic_reference.billion')} ${this.trans('economic_reference.tenge')}`,
          color: '#151E70',
        },
        {
          title: this.trans('economic_reference.total_wells_including'),
          uwiCount: +this.scenario.uwi_count.original_value,
          prsCount: +this.scenario.prs.original_value,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs.original_value, this.scenario.uwi_count.original_value),
          liquid: this.calcLiquid(this.scenario.liquid.original_value, this.scenario.oil.original_value),
          avgQn: this.calcAvgQn(this.scenario.oil.original_value, this.scenario.days_worked.original_value),
          oil: this.calcOil(this.scenario.oil.original_value),
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total.original_value),
          overallExpenditures: this.calcOverallExpenditures(this.scenario.Overall_expenditures_full.original_value),
          operatingProfit: this.calcOperatingProfit(this.scenario.Operating_profit.original_value),
        },
        {
          title: this.trans('economic_reference.profitable'),
          uwiCount: +this.scenario.uwi_count_profitable.original_value,
          prsCount: +this.scenario.prs_profitable.original_value,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_profitable.original_value, this.scenario.uwi_count_profitable.original_value),
          liquid: this.calcLiquid(this.scenario.liquid_profitable.original_value, this.scenario.oil_profitable.original_value),
          avgQn: this.calcAvgQn(this.scenario.oil_profitable.original_value, this.scenario.days_worked_profitable.original_value),
          oil: this.calcOil(this.scenario.oil_profitable.original_value),
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_profitable.original_value),
          overallExpenditures: this.calcOverallExpenditures(this.scenario.Overall_expenditures_full_profitable.original_value),
          operatingProfit: this.calcOperatingProfit(this.scenario.Operating_profit_profitable.original_value),
        },
        {
          title: this.trans('economic_reference.profitless_all'),
          uwiCount: +this.scenario.uwi_count_profitless_cat_1.original_value +
              +this.scenario.uwi_count_profitless_cat_2.original_value,
          prsCount: +this.scenario.prs_profitless_cat_1.original_value +
              +this.scenario.prs_profitless_cat_2.original_value,
          prsPerUwi: this.calcPrsPerUwi(
              +this.scenario.prs_profitless_cat_1.original_value +
              +this.scenario.prs_profitless_cat_2.original_value,
              +this.scenario.uwi_count_profitless_cat_1.original_value +
              +this.scenario.uwi_count_profitless_cat_2.original_value
          ),
          liquid: this.calcLiquid(
              +this.scenario.liquid_profitless_cat_1.original_value +
              +this.scenario.liquid_profitless_cat_2.original_value,
              +this.scenario.oil_profitless_cat_1.original_value +
              +this.scenario.oil_profitless_cat_2.original_value
          ),
          avgQn: this.calcAvgQn(
              +this.scenario.oil_profitless_cat_1.original_value +
              +this.scenario.oil_profitless_cat_2.original_value,
              +this.scenario.days_worked_profitless_cat_1.original_value +
              +this.scenario.days_worked_profitless_cat_2.original_value
          ),
          oil: this.calcOil(
              +this.scenario.oil_profitless_cat_1.original_value +
              +this.scenario.oil_profitless_cat_2.original_value
          ),
          revenueTotal: this.calcRevenueTotal(
              +this.scenario.Revenue_total_profitless_cat_1.original_value +
              +this.scenario.Revenue_total_profitless_cat_2.original_value
          ),
          overallExpenditures: this.calcOverallExpenditures(
              +this.scenario.Overall_expenditures_full_profitless_cat_1.original_value +
              +this.scenario.Overall_expenditures_full_profitless_cat_2.original_value
          ),
          operatingProfit: this.calcOperatingProfit(
              +this.scenario.Operating_profit_profitless_cat_1.original_value +
              +this.scenario.Operating_profit_profitless_cat_2.original_value
          ),
        },
        {
          title: this.trans('economic_reference.profitless_cat_1'),
          uwiCount: +this.scenario.uwi_count_profitless_cat_1.original_value,
          prsCount: +this.scenario.prs_profitless_cat_1.original_value,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_profitless_cat_1.original_value, this.scenario.uwi_count_profitless_cat_1.original_value),
          liquid: this.calcLiquid(this.scenario.liquid_profitless_cat_1.original_value, this.scenario.oil_profitless_cat_1.original_value),
          avgQn: this.calcAvgQn(this.scenario.oil_profitless_cat_1.original_value, this.scenario.days_worked_profitless_cat_1.original_value),
          oil: this.calcOil(this.scenario.oil_profitless_cat_1.original_value),
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_profitless_cat_1.original_value),
          overallExpenditures: this.calcOverallExpenditures(this.scenario.Overall_expenditures_full_profitless_cat_1.original_value),
          operatingProfit: this.calcOperatingProfit(this.scenario.Operating_profit_profitless_cat_1.original_value),
          color: '#313560',
          style: 'padding-left: 30px !important;',
        },
        {
          title: this.trans('economic_reference.profitless_cat_2'),
          uwiCount: +this.scenario.uwi_count_profitless_cat_2.original_value,
          prsCount: +this.scenario.prs_profitless_cat_2.original_value,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_profitless_cat_2.original_value, this.scenario.uwi_count_profitless_cat_2.original_value),
          liquid: this.calcLiquid(this.scenario.liquid_profitless_cat_2.original_value, this.scenario.oil_profitless_cat_2.original_value),
          avgQn: this.calcAvgQn(this.scenario.oil_profitless_cat_2.original_value, this.scenario.days_worked_profitless_cat_2.original_value),
          oil: this.calcOil(this.scenario.oil_profitless_cat_2.original_value),
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_profitless_cat_2.original_value),
          overallExpenditures: this.calcOverallExpenditures(this.scenario.Overall_expenditures_full_profitless_cat_2.original_value),
          operatingProfit: this.calcOperatingProfit(this.scenario.Operating_profit_profitless_cat_2.original_value),
          color: '#313560',
          style: 'padding-left: 30px !important;',
        },
      ]
    },

    tableDataOptimized() {
      return [
        {
          title: this.trans('economic_reference.total_wells_including'),
          uwiCount: +this.scenario.uwi_count.original_value_optimized,
          prsCount: +this.scenario.prs.original_value_optimized,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs.original_value_optimized, this.scenario.uwi_count.original_value_optimized),
          liquid: this.calcLiquid(this.scenario.liquid.original_value_optimized, this.scenario.oil.original_value_optimized),
          avgQn: this.calcAvgQn(this.scenario.oil.original_value_optimized, this.scenario.days_worked.original_value_optimized),
          oil: this.calcOil(this.scenario.oil.original_value_optimized),
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total.original_value_optimized),
          overallExpenditures: this.calcOverallExpenditures(this.scenario.Overall_expenditures_full_scenario),
          operatingProfit: this.calcOperatingProfit(this.scenario.Operating_profit_scenario),
        },
        {
          title: this.trans('economic_reference.profitable'),
          uwiCount: +this.scenario.uwi_count_profitable.original_value_optimized,
          prsCount: +this.scenario.prs_profitable.original_value_optimized,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_profitable.original_value_optimized, this.scenario.uwi_count_profitable.original_value_optimized),
          liquid: this.calcLiquid(this.scenario.liquid_profitable.original_value_optimized, this.scenario.oil_profitable.original_value_optimized),
          avgQn: this.calcAvgQn(this.scenario.oil_profitable.original_value_optimized, this.scenario.days_worked_profitable.original_value_optimized),
          oil: this.calcOil(this.scenario.oil_profitable.original_value_optimized),
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_profitable.original_value_optimized),
          overallExpenditures: this.calcOverallExpenditures(this.scenario.Overall_expenditures_full_scenario_profitable),
          operatingProfit: this.calcOperatingProfit(this.scenario.Operating_profit_scenario_profitable),
        },
        {
          title: this.trans('economic_reference.profitless_all'),
          uwiCount: +this.scenario.uwi_count_profitless_cat_1.original_value_optimized + +this.scenario.uwi_count_profitless_cat_2.original_value_optimized,
          prsCount: +this.scenario.prs_profitless_cat_1.original_value_optimized + +this.scenario.prs_profitless_cat_2.original_value_optimized,
          prsPerUwi: this.calcPrsPerUwi(
              +this.scenario.prs_profitless_cat_1.original_value_optimized +
              +this.scenario.prs_profitless_cat_2.original_value_optimized,
              +this.scenario.uwi_count_profitless_cat_1.original_value_optimized +
              +this.scenario.uwi_count_profitless_cat_2.original_value_optimized
          ),
          liquid: this.calcLiquid(
              +this.scenario.liquid_profitless_cat_1.original_value_optimized +
              +this.scenario.liquid_profitless_cat_2.original_value_optimized,
              +this.scenario.oil_profitless_cat_1.original_value_optimized +
              +this.scenario.oil_profitless_cat_2.original_value_optimized
          ),
          avgQn: this.calcAvgQn(
              +this.scenario.oil_profitless_cat_1.original_value_optimized +
              +this.scenario.oil_profitless_cat_2.original_value_optimized,
              +this.scenario.days_worked_profitless_cat_1.original_value_optimized +
              +this.scenario.days_worked_profitless_cat_2.original_value_optimized
          ),
          oil: this.calcOil(
              +this.scenario.oil_profitless_cat_1.original_value_optimized +
              +this.scenario.oil_profitless_cat_2.original_value_optimized
          ),
          revenueTotal: this.calcRevenueTotal(
              +this.scenario.Revenue_total_profitless_cat_1.original_value_optimized +
              +this.scenario.Revenue_total_profitless_cat_2.original_value_optimized
          ),
          overallExpenditures: this.calcOverallExpenditures(
              +this.scenario.Overall_expenditures_full_profitless_cat_1.original_value_optimized +
              +this.scenario.Overall_expenditures_full_profitless_cat_2.original_value_optimized
          ),
          operatingProfit: this.calcOperatingProfit(
              +this.scenario.Operating_profit_profitless_cat_1.original_value_optimized +
              +this.scenario.Operating_profit_profitless_cat_2.original_value_optimized
          ),
        },
        {
          title: this.trans('economic_reference.profitless_cat_1'),
          uwiCount: +this.scenario.uwi_count_profitless_cat_1.original_value_optimized,
          prsCount: +this.scenario.prs_profitless_cat_1.original_value_optimized,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_profitless_cat_1.original_value_optimized, this.scenario.uwi_count_profitless_cat_1.original_value_optimized),
          liquid: this.calcLiquid(this.scenario.liquid_profitless_cat_1.original_value_optimized, this.scenario.oil_profitless_cat_1.original_value_optimized),
          avgQn: this.calcAvgQn(this.scenario.oil_profitless_cat_1.original_value_optimized, this.scenario.days_worked_profitless_cat_1.original_value_optimized),
          oil: this.calcOil(this.scenario.oil_profitless_cat_1.original_value_optimized),
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_profitless_cat_1.original_value_optimized),
          overallExpenditures: this.calcOverallExpenditures(this.scenario.Overall_expenditures_full_scenario_profitless_cat_1),
          operatingProfit: this.calcOperatingProfit(this.scenario.Operating_profit_scenario_profitless_cat_1),
          color: '#313560',
          style: 'padding-left: 30px !important;',
        },
        {
          title: this.trans('economic_reference.profitless_cat_2'),
          uwiCount: +this.scenario.uwi_count_profitless_cat_2.original_value_optimized,
          prsCount: +this.scenario.prs_profitless_cat_2.original_value_optimized,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_profitless_cat_2.original_value_optimized, this.scenario.uwi_count_profitless_cat_2.original_value_optimized),
          liquid: this.calcLiquid(this.scenario.liquid_profitless_cat_2.original_value_optimized, this.scenario.oil_profitless_cat_2.original_value_optimized),
          avgQn: this.calcAvgQn(this.scenario.oil_profitless_cat_2.original_value_optimized, this.scenario.days_worked_profitless_cat_2.original_value_optimized),
          oil: this.calcOil(this.scenario.oil_profitless_cat_2.original_value_optimized),
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_profitless_cat_2.original_value_optimized),
          overallExpenditures: this.calcOverallExpenditures(this.scenario.Overall_expenditures_full_scenario_profitless_cat_2),
          operatingProfit: this.calcOperatingProfit(this.scenario.Operating_profit_scenario_profitless_cat_2),
          color: '#313560',
          style: 'padding-left: 30px !important;',
        },
      ]
    },

    tableKeys() {
      return [
        {
          title: this.trans('economic_reference.indicators'),
          value: 'title',
          flexWidth: '185px',
          flexGrow: 0,
        },
        {
          title: this.trans('economic_reference.wells_count'),
          value: 'uwiCount',
          flexWidth: '100px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.prs_count'),
          value: 'prsCount',
          flexWidth: '100px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.prs_per_well_count'),
          value: 'prsPerUwi',
          flexWidth: '120px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.water_cut'),
          value: 'liquid',
          flexWidth: '135px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.avg_qn'),
          value: 'avgQn',
          flexWidth: '100px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.production'),
          value: 'oil',
          flexWidth: '115px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.revenue'),
          value: 'revenueTotal',
          flexWidth: '120px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.costs'),
          value: 'overallExpenditures',
          flexWidth: '120px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.operating_profit'),
          value: 'operatingProfit',
          flexWidth: '120px',
          flexGrow: 1,
        },
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

.line-height-14px {
  line-height: 14px;
}

.line-height-16px {
  line-height: 16px;
}

.line-height-18px {
  line-height: 18px;
}

.font-size-16px {
  font-size: 16px;
}
</style>