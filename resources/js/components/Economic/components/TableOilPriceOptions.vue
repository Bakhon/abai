<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      <div>{{ trans('economic_reference.table_oil_price_options_title') }}</div>
      <div>“{{ org.name }}”</div>
    </subtitle>

    <div class="mt-3">
      <div class="text-center border-grey d-flex bg-header">
        <div
            v-for="item in tableKeys"
            :key="item.value"
            :style="`flex: ${item.flexGrow} 0 ${item.flexWidth}`"
            class="px-3 border-grey d-flex align-items-center justify-content-center"
            style="white-space: normal">
          {{ item.title }}
        </div>
      </div>

      <div v-for="(item, index) in tableData"
           :key="index"
           :style="`background: ${item.color}`"
           class="d-flex">
        <div v-for="key in tableKeys"
             :key="key.value"
             :class="index ? 'p-3' : 'px-3 py-1'"
             :style="`flex: ${key.flexGrow} 0 ${key.flexWidth}`"
             class="border-grey text-center">
          {{
            typeof item[key.value] === 'string'
                ? item[key.value]
                : (+(item[key.value]).toFixed(2)).toLocaleString()
          }}
        </div>
      </div>
    </div>

    <subtitle font-size="18" style="line-height: 26px" class="mt-3">
      {{ trans('economic_reference.cat_1_trips') }}: {{ scenario.percent_stop_cat_1 * 100 }}%,
      {{ trans('economic_reference.cat_2_trips') }}: {{ scenario.percent_stop_cat_2 * 100 }}%
    </subtitle>

    <div class="mt-3">
      <div v-for="(item, index) in tableDataOptimized"
           :key="index"
           :style="`background: ${item.color}`"
           class="d-flex">
        <div v-for="key in tableKeys"
             :key="key.value"
             :class="index ? 'p-3' : 'px-3 py-1'"
             :style="`flex: ${key.flexGrow} 0 ${key.flexWidth}`"
             class="border-grey text-center">
          {{
            typeof item[key.value] === 'string'
                ? item[key.value]
                : (+(item[key.value]).toFixed(2)).toLocaleString()
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
    oilPrices: {
      required: true,
      type: Array,
    },
    data: {
      required: true,
      type: Object
    }
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

    calcRevenueTotal(revenue_total) {
      return +revenue_total / 1000000000
    },

    calcOil(oil) {
      return +oil / 1000
    },
  },
  computed: {
    tableData() {
      return [
        {
          title: `${this.trans('economic_reference.at_export_price')} - ${this.scenario.oil_price}$/bbl`,
          uwiCount: this.trans('economic_reference.units'),
          prsCount: this.trans('economic_reference.units'),
          prsPerUwi: this.trans('economic_reference.units'),
          liquid: '%',
          avgQn: this.trans('economic_reference.tn_per_day'),
          oil: this.trans('economic_reference.thousand_tons'),
          number: this.trans('economic_reference.people_short'),
          revenueTotal: `${this.trans('economic_reference.billion')} ${this.trans('economic_reference.tenge')}`,
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
          number: '',
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total.original_value)
        },
        {
          title: this.trans('economic_reference.profitable'),
          uwiCount: +this.scenario.uwi_count_profitable.original_value,
          prsCount: +this.scenario.prs_profitable.original_value,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_profitable.original_value, this.scenario.uwi_count_profitable.original_value),
          liquid: this.calcLiquid(this.scenario.liquid_profitable.original_value, this.scenario.oil_profitable.original_value),
          avgQn: this.calcAvgQn(this.scenario.oil_profitable.original_value, this.scenario.days_worked_profitable.original_value),
          oil: this.calcOil(this.scenario.oil_profitable.original_value),
          number: '',
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_profitable.original_value)
        },
        {
          title: this.trans('economic_reference.profitless_cat_1'),
          uwiCount: +this.scenario.uwi_count_profitless_cat_1.original_value,
          prsCount: +this.scenario.prs_profitless_cat_1.original_value,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_profitless_cat_1.original_value, this.scenario.uwi_count_profitless_cat_1.original_value),
          liquid: this.calcLiquid(this.scenario.liquid_profitless_cat_1.original_value, this.scenario.oil_profitless_cat_1.original_value),
          avgQn: this.calcAvgQn(this.scenario.oil_profitless_cat_1.original_value, this.scenario.days_worked_profitless_cat_1.original_value),
          oil: this.calcOil(this.scenario.oil_profitless_cat_1.original_value),
          number: '',
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_profitless_cat_1.original_value)
        },
        {
          title: this.trans('economic_reference.profitless_cat_2'),
          uwiCount: +this.scenario.uwi_count_profitless_cat_2.original_value,
          prsCount: +this.scenario.prs_profitless_cat_2.original_value,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_profitless_cat_2.original_value, this.scenario.uwi_count_profitless_cat_2.original_value),
          liquid: this.calcLiquid(this.scenario.liquid_profitless_cat_2.original_value, this.scenario.oil_profitless_cat_2.original_value),
          avgQn: this.calcAvgQn(this.scenario.oil_profitless_cat_2.original_value, this.scenario.days_worked_profitless_cat_2.original_value),
          oil: this.calcOil(this.scenario.oil_profitless_cat_2.original_value),
          number: '',
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_profitless_cat_2.original_value)
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
          number: '',
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total.original_value_optimized)
        },
        {
          title: this.trans('economic_reference.profitable'),
          uwiCount: +this.scenario.uwi_count_profitable.original_value_optimized,
          prsCount: +this.scenario.prs_profitable.original_value_optimized,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_profitable.original_value_optimized, this.scenario.uwi_count_profitable.original_value_optimized),
          liquid: this.calcLiquid(this.scenario.liquid_profitable.original_value_optimized, this.scenario.oil_profitable.original_value_optimized),
          avgQn: this.calcAvgQn(this.scenario.oil_profitable.original_value_optimized, this.scenario.days_worked_profitable.original_value_optimized),
          oil: this.calcOil(this.scenario.oil_profitable.original_value_optimized),
          number: '',
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_profitable.original_value_optimized)
        },
        {
          title: this.trans('economic_reference.profitless_cat_1'),
          uwiCount: +this.scenario.uwi_count_profitless_cat_1.original_value_optimized,
          prsCount: +this.scenario.prs_profitless_cat_1.original_value_optimized,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_profitless_cat_1.original_value_optimized, this.scenario.uwi_count_profitless_cat_1.original_value_optimized),
          liquid: this.calcLiquid(this.scenario.liquid_profitless_cat_1.original_value_optimized, this.scenario.oil_profitless_cat_1.original_value_optimized),
          avgQn: this.calcAvgQn(this.scenario.oil_profitless_cat_1.original_value_optimized, this.scenario.days_worked_profitless_cat_1.original_value_optimized),
          oil: this.calcOil(this.scenario.oil_profitless_cat_1.original_value_optimized),
          number: '',
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_profitless_cat_1.original_value_optimized)
        },
        {
          title: this.trans('economic_reference.profitless_cat_2'),
          uwiCount: +this.scenario.uwi_count_profitless_cat_2.original_value_optimized,
          prsCount: +this.scenario.prs_profitless_cat_2.original_value_optimized,
          prsPerUwi: this.calcPrsPerUwi(this.scenario.prs_profitless_cat_2.original_value_optimized, this.scenario.uwi_count_profitless_cat_2.original_value_optimized),
          liquid: this.calcLiquid(this.scenario.liquid_profitless_cat_2.original_value_optimized, this.scenario.oil_profitless_cat_2.original_value_optimized),
          avgQn: this.calcAvgQn(this.scenario.oil_profitless_cat_2.original_value_optimized, this.scenario.days_worked_profitless_cat_2.original_value_optimized),
          oil: this.calcOil(this.scenario.oil_profitless_cat_2.original_value_optimized),
          number: '',
          revenueTotal: this.calcRevenueTotal(this.scenario.Revenue_total_profitless_cat_2.original_value_optimized)
        },
      ]
    },

    tableKeys() {
      return [
        {
          title: this.trans('economic_reference.indicators'),
          value: 'title',
          flexWidth: '300px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.wells_count'),
          value: 'uwiCount',
          flexWidth: '120px',
          flexGrow: 0,
        },
        {
          title: this.trans('economic_reference.prs_count'),
          value: 'prsCount',
          flexWidth: '120px',
          flexGrow: 0,
        },
        {
          title: this.trans('economic_reference.prs_per_well_count'),
          value: 'prsPerUwi',
          flexWidth: '120px',
          flexGrow: 0,
        },
        {
          title: this.trans('economic_reference.water_cut'),
          value: 'liquid',
          flexWidth: '140px',
          flexGrow: 0,
        },
        {
          title: this.trans('economic_reference.avg_qn'),
          value: 'avgQn',
          flexWidth: '120px',
          flexGrow: 0,
        },
        {
          title: this.trans('economic_reference.production'),
          value: 'oil',
          flexWidth: '120px',
          flexGrow: 0,
        },
        {
          title: this.trans('economic_reference.number'),
          value: 'number',
          flexWidth: '120px',
          flexGrow: 0,
        },
        {
          title: this.trans('economic_reference.revenue'),
          value: 'revenueTotal',
          flexWidth: '120px',
          flexGrow: 0,
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
</style>