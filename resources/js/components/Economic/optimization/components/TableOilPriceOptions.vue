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
import Subtitle from "../../components/Subtitle";

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
          uwiCount: +this.scenario.uwi_count,
          prsCount: +this.scenario.prs,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs, this.scenario.uwi_count),
          liquid: this.calcLiquid(this.scenario.liquid, this.scenario.oil),
          avgQn: this.calcAvgQn(this.scenario.oil, this.scenario.days_worked),
          oil: this.calcOil(this.scenario.oil),
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total),
          overallExpenditures: this.calcOverallExpenditures(this.scenario.Overall_expenditures_full),
          operatingProfit: this.calcOperatingProfit(this.scenario.Operating_profit),
        },
        {
          title: this.trans('economic_reference.profitable'),
          uwiCount: +this.scenario.uwi_count_profitable,
          prsCount: +this.scenario.prs_profitable,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_profitable, this.scenario.uwi_count_profitable),
          liquid: this.calcLiquid(this.scenario.liquid_profitable, this.scenario.oil_profitable),
          avgQn: this.calcAvgQn(this.scenario.oil_profitable, this.scenario.days_worked_profitable),
          oil: this.calcOil(this.scenario.oil_profitable),
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_profitable),
          overallExpenditures: this.calcOverallExpenditures(this.scenario.Overall_expenditures_full_profitable),
          operatingProfit: this.calcOperatingProfit(this.scenario.Operating_profit_profitable),
        },
        {
          title: this.trans('economic_reference.profitless_all'),
          uwiCount: +this.scenario.uwi_count_profitless_cat_1 +
              +this.scenario.uwi_count_profitless_cat_2,
          prsCount: +this.scenario.prs_profitless_cat_1 +
              +this.scenario.prs_profitless_cat_2,
          prsPerUwi: this.calcPrsPerUwi(
              +this.scenario.prs_profitless_cat_1 +
              +this.scenario.prs_profitless_cat_2,
              +this.scenario.uwi_count_profitless_cat_1 +
              +this.scenario.uwi_count_profitless_cat_2
          ),
          liquid: this.calcLiquid(
              +this.scenario.liquid_profitless_cat_1 +
              +this.scenario.liquid_profitless_cat_2,
              +this.scenario.oil_profitless_cat_1 +
              +this.scenario.oil_profitless_cat_2
          ),
          avgQn: this.calcAvgQn(
              +this.scenario.oil_profitless_cat_1 +
              +this.scenario.oil_profitless_cat_2,
              +this.scenario.days_worked_profitless_cat_1 +
              +this.scenario.days_worked_profitless_cat_2
          ),
          oil: this.calcOil(
              +this.scenario.oil_profitless_cat_1 +
              +this.scenario.oil_profitless_cat_2
          ),
          revenueTotal: this.calcRevenueTotal(
              +this.scenario.Revenue_total_profitless_cat_1 +
              +this.scenario.Revenue_total_profitless_cat_2
          ),
          overallExpenditures: this.calcOverallExpenditures(
              +this.scenario.Overall_expenditures_full_profitless_cat_1 +
              +this.scenario.Overall_expenditures_full_profitless_cat_2
          ),
          operatingProfit: this.calcOperatingProfit(
              +this.scenario.Operating_profit_profitless_cat_1 +
              +this.scenario.Operating_profit_profitless_cat_2
          ),
        },
        {
          title: this.trans('economic_reference.profitless_cat_1'),
          uwiCount: +this.scenario.uwi_count_profitless_cat_1,
          prsCount: +this.scenario.prs_profitless_cat_1,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_profitless_cat_1, this.scenario.uwi_count_profitless_cat_1),
          liquid: this.calcLiquid(this.scenario.liquid_profitless_cat_1, this.scenario.oil_profitless_cat_1),
          avgQn: this.calcAvgQn(this.scenario.oil_profitless_cat_1, this.scenario.days_worked_profitless_cat_1),
          oil: this.calcOil(this.scenario.oil_profitless_cat_1),
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_profitless_cat_1),
          overallExpenditures: this.calcOverallExpenditures(this.scenario.Overall_expenditures_full_profitless_cat_1),
          operatingProfit: this.calcOperatingProfit(this.scenario.Operating_profit_profitless_cat_1),
          color: '#313560',
          style: 'padding-left: 30px !important;',
        },
        {
          title: this.trans('economic_reference.profitless_cat_2'),
          uwiCount: +this.scenario.uwi_count_profitless_cat_2,
          prsCount: +this.scenario.prs_profitless_cat_2,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_profitless_cat_2, this.scenario.uwi_count_profitless_cat_2),
          liquid: this.calcLiquid(this.scenario.liquid_profitless_cat_2, this.scenario.oil_profitless_cat_2),
          avgQn: this.calcAvgQn(this.scenario.oil_profitless_cat_2, this.scenario.days_worked_profitless_cat_2),
          oil: this.calcOil(this.scenario.oil_profitless_cat_2),
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_profitless_cat_2),
          overallExpenditures: this.calcOverallExpenditures(this.scenario.Overall_expenditures_full_profitless_cat_2),
          operatingProfit: this.calcOperatingProfit(this.scenario.Operating_profit_profitless_cat_2),
          color: '#313560',
          style: 'padding-left: 30px !important;',
        },
      ]
    },

    tableDataOptimized() {
      return [
        {
          title: this.trans('economic_reference.total_wells_including'),
          uwiCount: +this.scenario.uwi_count_optimize,
          prsCount: +this.scenario.prs_optimize,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_optimize, this.scenario.uwi_count_optimize),
          liquid: this.calcLiquid(this.scenario.liquid_optimize, this.scenario.oil_optimize),
          avgQn: this.calcAvgQn(this.scenario.oil_optimize, this.scenario.days_worked_optimize),
          oil: this.calcOil(this.scenario.oil_optimize),
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_optimize),
          overallExpenditures: this.calcOverallExpenditures(this.scenario.Overall_expenditures_full_optimize),
          operatingProfit: this.calcOperatingProfit(this.scenario.Operating_profit_optimize),
        },
        {
          title: this.trans('economic_reference.profitable'),
          uwiCount: +this.scenario.uwi_count_profitable_optimize,
          prsCount: +this.scenario.prs_profitable_optimize,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_profitable_optimize, this.scenario.uwi_count_profitable_optimize),
          liquid: this.calcLiquid(this.scenario.liquid_profitable_optimize, this.scenario.oil_profitable_optimize),
          avgQn: this.calcAvgQn(this.scenario.oil_profitable_optimize, this.scenario.days_worked_profitable_optimize),
          oil: this.calcOil(this.scenario.oil_profitable_optimize),
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_profitable_optimize),
          overallExpenditures: this.calcOverallExpenditures(this.scenario.Overall_expenditures_full_profitable_optimize),
          operatingProfit: this.calcOperatingProfit(this.scenario.Operating_profit_profitable_optimize),
        },
        {
          title: this.trans('economic_reference.profitless_all'),
          uwiCount: +this.scenario.uwi_count_profitless_cat_1_optimize + +this.scenario.uwi_count_profitless_cat_2_optimize,
          prsCount: +this.scenario.prs_profitless_cat_1_optimize + +this.scenario.prs_profitless_cat_2_optimize,
          prsPerUwi: this.calcPrsPerUwi(
              +this.scenario.prs_profitless_cat_1_optimize +
              +this.scenario.prs_profitless_cat_2_optimize,
              +this.scenario.uwi_count_profitless_cat_1_optimize +
              +this.scenario.uwi_count_profitless_cat_2_optimize
          ),
          liquid: this.calcLiquid(
              +this.scenario.liquid_profitless_cat_1_optimize +
              +this.scenario.liquid_profitless_cat_2_optimize,
              +this.scenario.oil_profitless_cat_1_optimize +
              +this.scenario.oil_profitless_cat_2_optimize
          ),
          avgQn: this.calcAvgQn(
              +this.scenario.oil_profitless_cat_1_optimize +
              +this.scenario.oil_profitless_cat_2_optimize,
              +this.scenario.days_worked_profitless_cat_1_optimize +
              +this.scenario.days_worked_profitless_cat_2_optimize
          ),
          oil: this.calcOil(
              +this.scenario.oil_profitless_cat_1_optimize +
              +this.scenario.oil_profitless_cat_2_optimize
          ),
          revenueTotal: this.calcRevenueTotal(
              +this.scenario.Revenue_total_profitless_cat_1_optimize +
              +this.scenario.Revenue_total_profitless_cat_2_optimize
          ),
          overallExpenditures: this.calcOverallExpenditures(
              +this.scenario.Overall_expenditures_full_profitless_cat_1_optimize +
              +this.scenario.Overall_expenditures_full_profitless_cat_2_optimize
          ),
          operatingProfit: this.calcOperatingProfit(
              +this.scenario.Operating_profit_profitless_cat_1_optimize +
              +this.scenario.Operating_profit_profitless_cat_2_optimize
          ),
        },
        {
          title: this.trans('economic_reference.profitless_cat_1'),
          uwiCount: +this.scenario.uwi_count_profitless_cat_1_optimize,
          prsCount: +this.scenario.prs_profitless_cat_1_optimize,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_profitless_cat_1_optimize, this.scenario.uwi_count_profitless_cat_1_optimize),
          liquid: this.calcLiquid(this.scenario.liquid_profitless_cat_1_optimize, this.scenario.oil_profitless_cat_1_optimize),
          avgQn: this.calcAvgQn(this.scenario.oil_profitless_cat_1_optimize, this.scenario.days_worked_profitless_cat_1_optimize),
          oil: this.calcOil(this.scenario.oil_profitless_cat_1_optimize),
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_profitless_cat_1_optimize),
          overallExpenditures: this.calcOverallExpenditures(this.scenario.Overall_expenditures_full_profitless_cat_1_optimize),
          operatingProfit: this.calcOperatingProfit(this.scenario.Operating_profit_profitless_cat_1_optimize),
          color: '#313560',
          style: 'padding-left: 30px !important;',
        },
        {
          title: this.trans('economic_reference.profitless_cat_2'),
          uwiCount: +this.scenario.uwi_count_profitless_cat_2_optimize,
          prsCount: +this.scenario.prs_profitless_cat_2_optimize,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_profitless_cat_2_optimize, this.scenario.uwi_count_profitless_cat_2_optimize),
          liquid: this.calcLiquid(this.scenario.liquid_profitless_cat_2_optimize, this.scenario.oil_profitless_cat_2_optimize),
          avgQn: this.calcAvgQn(this.scenario.oil_profitless_cat_2_optimize, this.scenario.days_worked_profitless_cat_2_optimize),
          oil: this.calcOil(this.scenario.oil_profitless_cat_2_optimize),
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_profitless_cat_2_optimize),
          overallExpenditures: this.calcOverallExpenditures(this.scenario.Overall_expenditures_full_profitless_cat_2_optimize),
          operatingProfit: this.calcOperatingProfit(this.scenario.Operating_profit_profitless_cat_2_optimize),
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