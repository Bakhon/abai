<template>
  <div :style="isVisibleWellChanges ? 'padding-right: 75px !important' : 'padding-right: 0'"
       class="position-relative row">
    <div class="col-12 px-3 mb-10px">
      <div class="row text-white text-wrap flex-nowrap ">
        <calculated-header
            v-for="(header, index) in calculatedHeaders"
            :key="`calculated_${index}`"
            :header="header"
            :form="form"
            :class="index ? 'ml-2' : ''"
            class="flex-grow-1"
            style="min-height: 135px"/>

        <remote-header
            v-for="(header, index) in remoteHeaders"
            :key="`remote_${index}`"
            :header="header"
            :form="form"
            class="flex-grow-1 ml-2 px-3 py-2"
            style="min-height: 135px"/>
      </div>
    </div>

    <div class="col-12 px-2 py-3 bg-main1 mb-10px">
      <select-scenario-variations
          :form="form"
          :scenario-variation="scenarioVariation"
          :scenario-variations="scenarioVariations"
          @changeScenario="getData()"/>
    </div>

    <div :class="scenarioVariation.isFullScreen ? 'col-12' : 'col-9 pr-2'">
      <tables
          v-if="res.scenario.id"
          :scenario="scenario"
          :scenario-variations="scenarioVariations"
          :res="res"
          @updateTab="updateTab"/>
    </div>

    <div v-show="!scenarioVariation.isFullScreen" class="col-3 pr-0">
      <economic-block
          v-for="(block, index) in blocks"
          :key="index"
          :index="index"
          :block="block"
          :form="form"
          :class="index === blocks.length - 1 ? '' : 'mb-10px'"
          :style="form.scenario_id ? 'min-height: 150px' : 'min-height: 155px'"
      />
    </div>
  </div>
</template>

<script>
import {globalloadingMutations, globalloadingState} from '@store/helpers';

import {formatValueMixin} from "../mixins/formatMixin";

import SelectScenarioVariations from "./components/SelectScenarioVariations";
import Tables from "./components/Tables";
import EconomicBlock from "./components/EconomicBlock";
import CalculatedHeader from "./components/CalculatedHeader";
import RemoteHeader from "./components/RemoteHeader";

const optimizeColumns = [
  'Revenue_total',
  'Revenue_local',
  'Revenue_export',
  'oil',
  'liquid',
  'prs',
  'uwi_count',
  'days_worked',
  'production_export',
  'production_local',
  'Fixed_noWRpayroll_expenditures',
  'Overall_expenditures',
  'Overall_expenditures_full',
  'Operating_profit',
  'Overall_expenditures',
  'Overall_expenditures_full',
];

let defaultRes = {
  scenario: {
    id: null,
    name: '',
    params: {
      oil_prices: [],
      dollar_rates: [],
      fixed_nopayrolls: [],
      cost_wr_payrolls: [],
    },
    results: [{
      scenario_id: null,
      dollar_rate: null,
      oil_price: null,
      variants: [{
        coef_Fixed_nopayroll: null,
        coef_cost_WR_payroll: null,
        percent_stop_cat_1: 0,
        percent_stop_cat_2: 0,
        stopped_uwis: []
      }],
      wells: []
    }]
  },
  dollarRate: {
    value: 0,
    url: ''
  },
  oilPrice: {
    value: 0,
    url: ''
  },
  org: {
    id: '',
    name: ''
  },
  gtms: []
}

let columnPairs = (column) => {
  return [
    {
      original: column,
      optimize: `${column}_optimize`
    },
    {
      original: `${column}_profitable`,
      optimize: `${column}_profitable_optimize`
    },
    {
      original: `${column}_profitless_cat_1`,
      optimize: `${column}_profitless_cat_1_optimize`
    },
    {
      original: `${column}_profitless_cat_2`,
      optimize: `${column}_profitless_cat_2_optimize`
    },
  ]
}

optimizeColumns.forEach(column => {
  columnPairs(column).forEach(pair => {
    defaultRes.scenario.results[0].variants[0][pair.original] = 0

    defaultRes.scenario.results[0].variants[0][pair.optimize] = 0
  })
})

export default {
  name: "economic-optimization",
  components: {
    SelectScenarioVariations,
    Tables,
    EconomicBlock,
    CalculatedHeader,
    RemoteHeader,
  },
  mixins: [formatValueMixin],
  data: () => ({
    form: {
      org_id: null,
      scenario_id: null
    },
    scenarioVariation: {
      dollar_rate: null,
      oil_price: null,
      salary_percent: null,
      retention_percent: null,
      optimization_percent: {
        cat_1: null,
        cat_2: null,
      },
      isFullScreen: false
    },
    res: defaultRes,
    isVisibleWellChanges: false
  }),
  computed: {
    ...globalloadingState(['loading']),

    url() {
      return this.localeUrl('/economic/optimization/get-data')
    },

    calculatedHeaders() {
      let headers = [
        {
          name: this.trans('economic_reference.revenue'),
          key: 'Revenue_total'
        },
        {
          name: this.trans('economic_reference.costs'),
          key: 'Overall_expenditures_full'
        },
        {
          name: this.trans('economic_reference.operating_profit'),
          key: 'Operating_profit'
        }
      ]

      return headers.map(header => {
        let value = this.scenario[header.key]

        let optimizedValue = this.scenario[`${header.key}_optimize`]

        let formattedOptimizedValue = this.formatValue(optimizedValue)

        return {
          name: header.name,
          baseValue: this.formatValue(value).value,
          value: formattedOptimizedValue.value,
          dimension: formattedOptimizedValue.dimension,
          percent: this.calcPercent(optimizedValue, value)
        }
      })
    },

    remoteHeaders() {
      return [
        {
          name: this.trans('economic_reference.oil_price'),
          url: this.res.oilPrice.url,
          value: this.res.oilPrice.value,
          dimension: '$ / bbl',
          percent: this.oilPricePercent,
        },
        {
          name: this.trans('economic_reference.course_prices'),
          url: this.res.dollarRate.url,
          value: this.res.dollarRate.value,
          dimension: 'kzt / $',
          percent: this.dollarRatePercent,
        }
      ]
    },

    blocks() {
      return [
        [
          {
            title: this.trans('economic_reference.oil_production'),
            icon: 'oil_production.svg',
            value: this.formatValue(this.scenario.oil_optimize).value.toFixed(2),
            dimension: this.formatValue(this.scenario.oil_optimize).dimension,
            dimensionSuffix: this.trans('economic_reference.tons'),
            percent: +(this.formatValue(this.oilPercent).value.toFixed(2)),
            percentDimension: this.formatValue(this.oilPercent).dimension,
            reverse: true,
            reversePercent: true
          },
          {
            title: this.trans('economic_reference.total_prs'),
            icon: 'total_prs.svg',
            value: +this.scenario.prs_optimize,
            dimension: this.trans('economic_reference.units'),
            percent: this.prsPercent,
            reversePercent: true
          },
        ],
        [
          {
            title: this.trans('economic_reference.liquid_production'),
            icon: 'oil_production.svg',
            value: this.formatValue(this.scenario.liquid_optimize).value.toFixed(2),
            dimension: this.formatValue(this.scenario.liquid_optimize).dimension,
            dimensionSuffix: this.trans('economic_reference.tons'),
            percent: +(this.formatValue(this.liquidPercent).value.toFixed(2)),
            percentDimension: this.formatValue(this.liquidPercent).dimension,
            reverse: true,
            reversePercent: true
          },
          {
            title: this.trans('economic_reference.specific_prs'),
            icon: 'specific_prs.svg',
            value: this.avgPrsValue(),
            dimension: this.trans('economic_reference.units_per_well'),
            percent: this.avgPrsPercent,
            reversePercent: true
          }
        ],
        [
          {
            title: this.trans('economic_reference.water_cut'),
            icon: 'liquid.svg',
            value: this.waterCutValue(true),
            dimension: '%',
            percent: this.waterCutPercent,
            reversePercent: true
          },
          {
            title: this.trans('economic_reference.mrp'),
            icon: 'total_prs.svg',
            value: this.mrpValue(true),
            dimension: this.trans('economic_reference.days_declination'),
            percent: this.mrpPercent,
            reverse: true
          },
        ],
        [
          {
            title: this.trans('economic_reference.avg_oil_rate'),
            icon: 'total_prs.svg',
            value: this.avgOilValue(),
            dimension: this.trans('economic_reference.tons_per_day'),
            percent: this.avgOilPercent,
            reverse: true
          },
          {
            title: this.trans('economic_reference.avg_liquid_rate'),
            icon: 'specific_prs.svg',
            value: this.avgLiquidValue(),
            dimension: this.trans('economic_reference.cubic_meter_per_day'),
            percent: this.avgLiquidPercent,
            reverse: false,
            reversePercent: true
          },
        ],
      ]
    },

    scenario() {
      let percentStopCat1 = +this.scenarioVariation.optimization_percent.cat_1

      let percentStopCat2 = +this.scenarioVariation.optimization_percent.cat_2

      return this.res.scenario.results
          .find(result =>
              +result.oil_price === +this.scenarioVariation.oil_price &&
              +result.dollar_rate === +this.scenarioVariation.dollar_rate
          )
          .variants
          .find(variant =>
              +variant.coef_cost_WR_payroll === +this.scenarioVariation.salary_percent &&
              +variant.coef_Fixed_nopayroll === +this.scenarioVariation.retention_percent &&
              +variant.percent_stop_cat_1 === percentStopCat1 &&
              +variant.percent_stop_cat_2 === percentStopCat2
          ) || this.res.scenario.results[0].variants[0]
    },

    scenarioVariations() {
      let variations = {
        oil_prices: this.res.scenario.params.oil_prices.map(item => item.value),
        dollar_rates: this.res.scenario.params.dollar_rates.map(item => item.value),
        salary_percents: this.res.scenario.params.cost_wr_payrolls.map(item => {
          return {
            label: `${item.value * 100}%`,
            value: item.value,
          }
        }),
        retention_percents: this.res.scenario.params.fixed_nopayrolls.map(item => {
          return {
            label: `${item.value * 100}%`,
            value: item.value,
          }
        }),
        optimization_percents: [],
      }

      for (let percentStopCat1 = 0; percentStopCat1 <= 100; percentStopCat1 += 20) {
        variations.optimization_percents.push({
          label: `
            ${this.trans('economic_reference.cat_1_trips')}: ${percentStopCat1}%,
            ${this.trans('economic_reference.cat_2_trips')}: 0%
          `,
          value: {
            cat_1: percentStopCat1 / 100,
            cat_2: 0
          }
        })
      }

      for (let percentStopCat2 = 10; percentStopCat2 <= 100; percentStopCat2 += 10) {
        variations.optimization_percents.push({
          label: `
            ${this.trans('economic_reference.cat_1_trips')}: 100%,
            ${this.trans('economic_reference.cat_2_trips')}: ${percentStopCat2}%
          `,
          value: {
            cat_1: 1,
            cat_2: percentStopCat2 / 100
          }
        })
      }

      return variations
    },

    oilPercent() {
      return +this.scenario.oil - +this.scenario.oil_optimize
    },

    liquidPercent() {
      return +this.scenario.liquid - +this.scenario.liquid_optimize
    },

    prsPercent() {
      return +this.scenario.prs_optimize - +this.scenario.prs
    },

    avgOilPercent() {
      return (this.avgOilValue() - this.avgOilValue(false)).toFixed(2)
    },

    avgLiquidPercent() {
      return (this.avgLiquidValue(true, 4) - this.avgLiquidValue(false, 4)).toFixed(2)
    },

    avgPrsPercent() {
      return (this.avgPrsValue(true, 4) - this.avgPrsValue(false, 4)).toFixed(2)
    },

    waterCutPercent() {
      return (this.waterCutValue() - this.waterCutValue(false)).toFixed(2)
    },

    mrpPercent() {
      return (this.mrpValue() - this.mrpValue(false)).toFixed(2)
    },
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getData() {
      this.SET_LOADING(true)

      try {
        const {data} = await this.axios.get(this.url, {params: this.form})

        this.scenarioVariation.dollar_rate = data.scenario.params.dollar_rates[0].value

        this.scenarioVariation.oil_price = data.scenario.params.oil_prices[0].value

        this.scenarioVariation.salary_percent = data.scenario.params.cost_wr_payrolls[0].value

        this.scenarioVariation.retention_percent = data.scenario.params.fixed_nopayrolls[0].value

        this.scenarioVariation.optimization_percent.cat_1 = 0

        this.scenarioVariation.optimization_percent.cat_2 = 0

        this.res = data
      } catch (e) {
        this.res = defaultRes

        console.log(e)
      }

      this.SET_LOADING(false)
    },

    updateTab(tab) {
      this.isVisibleWellChanges = tab === 'well_changes'
    },

    calcPercent(last, prev) {
      last = +last

      prev = +prev

      if (!prev) {
        return last ? 100 : 0;
      }

      return prev < 0
          ? (prev - last) * 100 / prev
          : (last - prev) * 100 / prev
    },

    mrpValue(isOptimize = true) {
      if (!this.form.scenario_id) {
        isOptimize = false
      }

      let workedDays = isOptimize
          ? +this.scenario.days_worked_optimize
          : +this.scenario.days_worked

      let prs = isOptimize
          ? +this.scenario.prs_optimize
          : +this.scenario.prs

      return prs
          ? (workedDays / prs).toFixed(2)
          : 0
    },

    waterCutValue(isOptimize = true) {
      if (!this.form.scenario_id) {
        isOptimize = false
      }

      let liquid = isOptimize
          ? +this.scenario.liquid_optimize
          : +this.scenario.liquid

      let oil = isOptimize
          ? +this.scenario.oil_optimize
          : +this.scenario.oil

      // TODO: посмотреть более точную формулу
      return liquid
          ? (100 * (liquid - oil) / liquid).toFixed(2)
          : 0
    },

    avgOilValue(isOptimize = true) {
      if (!this.form.scenario_id) {
        isOptimize = false
      }

      let days_worked = isOptimize
          ? +this.scenario.days_worked_optimize
          : +this.scenario.days_worked

      let oil = isOptimize
          ? +this.scenario.oil_optimize
          : +this.scenario.oil

      return days_worked
          ? (oil / days_worked).toFixed(2)
          : 0
    },

    avgLiquidValue(isOptimize = true, fractionDigits = 2) {
      if (!this.form.scenario_id) {
        isOptimize = false
      }

      let days_worked = isOptimize
          ? +this.scenario.days_worked_optimize
          : +this.scenario.days_worked

      let liquid = isOptimize
          ? +this.scenario.liquid_optimize
          : +this.scenario.liquid

      return days_worked
          ? (liquid / days_worked).toFixed(fractionDigits)
          : 0
    },

    avgPrsValue(isOptimize = true, fractionDigits = 2) {
      if (!this.form.scenario_id) {
        isOptimize = false
      }

      let uwi_count = isOptimize
          ? +this.scenario.uwi_count_optimize
          : +this.scenario.uwi_count

      let prs = isOptimize
          ? +this.scenario.prs_optimize
          : +this.scenario.prs

      return uwi_count
          ? (prs / uwi_count).toFixed(fractionDigits)
          : 0
    },
  }
};
</script>
<style scoped>
.mb-10px {
  margin-bottom: 10px;
}
</style>
