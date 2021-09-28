<template>
  <div class="position-relative">
    <div class="row">
      <div class="col-12 px-2 py-3 bg-main1 mb-10px">
        <select-scenario-variations
            :form="form"
            :scenario-variation="scenarioVariation"
            :scenario-variations="scenarioVariations"
            @changeOrg="getData()"/>
      </div>

      <div :class="scenarioVariation.isFullScreen ? 'col-12' : 'col-9 pr-2'">
        <div class="row text-white text-wrap flex-nowrap mb-10px">
          <div
              v-for="(header, index) in calculatedHeaders"
              :key="`calculated_${index}`"
              class="p-3 bg-blue-dark position-relative">
            <divider v-if="index"/>

            <economic-title
                font-size="32"
                line-height="46"
                class="text-nowrap">
              <span> {{ header.value.toFixed(2) }} </span>

              <span class="font-size-16px line-height-20px text-blue">
               {{ header.dimension }}
              </span>
            </economic-title>

            <subtitle font-size="18"> {{ header.name }}</subtitle>

            <percent-progress v-if="form.scenario_id" :percent="header.percent"/>

            <div v-if="form.scenario_id"
                 class="d-flex font-size-12px line-height-14px mb-2">
              <div class="flex-grow-1 text-blue">
                {{ (100 + header.percent).toFixed(2) }} %
              </div>

              <div>{{ header.baseValue.toFixed(2) }}</div>
            </div>

            <div v-if="form.scenario_id"
                 class="d-flex align-items-center">
              <percent-badge
                  :percent="header.percent.toFixed(2)"
                  class="text-nowrap mr-2"
                  reverse/>

              <div class="flex-grow-1 text-blue font-size-12px line-height-16px text-right">
                {{ trans('economic_reference.vs_base_case') }}
              </div>
            </div>
          </div>

          <div
              v-for="(header, index) in remoteHeaders"
              :key="`remote_${index}`"
              class="p-3 bg-blue-dark flex-grow-1 ml-2 d-flex flex-column position-relative">
            <economic-title
                font-size="32"
                line-height="46"
                flex-grow="0"
                class="text-nowrap">
              <span> {{ header.value }} </span>

              <span class="font-size-16px line-height-20px text-blue">
                {{ header.dimension }}
              </span>
            </economic-title>

            <subtitle font-size="18">
              {{ header.name }}
            </subtitle>

            <span class="text-grey font-size-12px line-height-14px flex-grow-1">
              {{ trans('economic_reference.current') }}
            </span>

            <div v-if="form.scenario_id" class="d-flex align-items-center">
              <div class="font-size-24px line-height-28px font-weight-bold text-nowrap">
                <percent-badge-icon :percent="header.percent" reverse/>

                <span>{{ header.percent }}</span>

                <span class="font-size-16px">{{ header.dimension }}</span>
              </div>

              <div class="flex-grow-1 text-blue font-size-12px line-height-14px text-right">
                {{ trans('economic_reference.vs_choice') }}
              </div>
            </div>

            <a :href="header.url" target="_blank" class="remote-link">
              <i class="fas fa-external-link-alt text-blue"> </i>
            </a>
          </div>
        </div>

        <tables
            v-if="!loading"
            :scenario="scenario"
            :scenario-variations="scenarioVariations"
            :res="res"
            @updateTab="updateTab"/>
      </div>

      <div v-show="!scenarioVariation.isFullScreen"
           :style="isVisibleWellChanges ? 'padding-right: 75px' : 'padding-right:0'"
           class="col-3">
        <economic-block
            v-for="(block, index) in blocks"
            :key="index"
            :index="index"
            :block="block"
            :form="form"
            :style="form.scenario_id ? 'min-height: 180px' : 'min-height: 120px'"
        />

        <div class="bg-main1 text-white text-wrap p-3 mb-10px">
          <subtitle>
            {{ trans('economic_reference.production_wells_fund') }}
          </subtitle>

          <div class="mt-4 position-relative">
            <divider style="left: 150px; height: 100%; top: 0;"/>

            <divider
                v-if="form.scenario_id"
                style="left: 230px; height: 100%; top: 0;"/>

            <div v-for="(wellCount, index) in wellsCount"
                 :key="index"
                 :class="wellCount.name ? '' : 'font-weight-bold text-grey'"
                 class="d-flex">
              <div :class="wellCount.nameClass" class="font-size-12px" style="width: 150px;">
                {{ wellCount.name }}
              </div>

              <div class="ml-2" style="width: 80px">
                {{ wellCount.value }}
              </div>

              <div v-if="form.scenario_id">
                {{ wellCount.value_optimized }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const fileDownload = require("js-file-download");

import {globalloadingMutations, globalloadingState} from '@store/helpers';

import {formatValueMixin} from "./mixins/formatMixin";

import Divider from "./components/Divider";
import EconomicCol from "./components/EconomicCol";
import EconomicTitle from "./components/EconomicTitle";
import Subtitle from "./components/Subtitle";
import PercentBadge from "./components/PercentBadge";
import PercentBadgeIcon from "./components/PercentBadgeIcon";
import PercentProgress from "./components/PercentProgress";
import SelectOrganization from "./components/SelectOrganization";
import SelectScenario from "./components/SelectScenario";
import SelectScenarioVariations from "./components/SelectScenarioVariations";
import Tables from "./components/Tables";
import EconomicBlock from "./components/EconomicBlock";

const optimizedColumns = [
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
];

const optimizedScenarioColumns = [
  'Overall_expenditures',
  'Overall_expenditures_full',
  'Operating_profit',
];

const jsonColumns = [
  'uwi_stop',
]

let economicRes = {
  scenarios: [{
    scenario_id: null,
    percent_stop_cat_1: 0,
    percent_stop_cat_2: 0,
    coef_Fixed_nopayroll: 0,
    coef_cost_WR_payroll: 0,
    dollar_rate: 0,
    oil_price: 0,
    uwi_stop: [],
  }],
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
  if (optimizedScenarioColumns.includes(column)) {
    return [
      {
        original: column,
        optimized: `${column}_scenario`
      },
      {
        original: `${column}_profitable`,
        optimized: `${column}_scenario_profitable`
      },
      {
        original: `${column}_profitless_cat_1`,
        optimized: `${column}_scenario_profitless_cat_1`
      },
      {
        original: `${column}_profitless_cat_2`,
        optimized: `${column}_scenario_profitless_cat_2`
      },
    ]
  }

  return [
    {
      original: column,
      optimized: `${column}_optimized`
    },
    {
      original: `${column}_profitable`,
      optimized: `${column}_profitable_optimized`
    },
    {
      original: `${column}_profitless_cat_1`,
      optimized: `${column}_profitless_cat_1_optimized`
    },
    {
      original: `${column}_profitless_cat_2`,
      optimized: `${column}_profitless_cat_2_optimized`
    },
  ]
}

let columnVariations = (column) => {
  let pairs = columnPairs(column)

  let variations = []

  pairs.forEach(pair => variations.push(pair.original, pair.optimized))

  return variations
}

optimizedColumns.forEach(column => {
  columnPairs(column).forEach(pair => {
    economicRes.scenarios[0][pair.original] = {
      original_value: 0,
      original_value_optimized: 0,
    }
  })
})

export default {
  name: "economic-optimization",
  components: {
    Divider,
    EconomicCol,
    EconomicTitle,
    Subtitle,
    PercentBadge,
    PercentBadgeIcon,
    PercentProgress,
    SelectOrganization,
    SelectScenario,
    SelectScenarioVariations,
    Tables,
    EconomicBlock
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
    res: economicRes,
    isVisibleWellChanges: false
  }),
  computed: {
    ...globalloadingState(['loading']),

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
        let scenarioValue = this.scenario[header.key]

        let formattedValue = this.formatValue(scenarioValue[this.scenarioValueKey])

        return {
          name: header.name,
          baseValue: this.formatValue(scenarioValue.original_value).value,
          value: formattedValue.value,
          dimension: formattedValue.dimension,
          percent: this.calcPercent(scenarioValue[this.scenarioValueKey], scenarioValue.original_value)
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
            value: this.formatValue(this.scenario.oil[this.scenarioValueKey]).value.toFixed(2),
            dimension: this.formatValue(this.scenario.oil[this.scenarioValueKey]).dimension,
            dimensionSuffix: this.trans('economic_reference.tons'),
            percent: this.formatValue(this.oilPercent).value,
            percentDimension: this.formatValue(this.oilPercent).dimension,
            reverse: true,
            reversePercent: true
          },
          {
            title: this.trans('economic_reference.total_prs'),
            icon: 'total_prs.svg',
            value: +this.scenario.prs[this.scenarioValueKey],
            dimension: this.trans('economic_reference.units'),
            percent: this.prsPercent,
            reversePercent: true
          },
        ],
        [
          {
            title: this.trans('economic_reference.liquid_production'),
            icon: 'oil_production.svg',
            value: this.formatValue(this.scenario.liquid[this.scenarioValueKey]).value.toFixed(2),
            dimension: this.formatValue(this.scenario.liquid[this.scenarioValueKey]).dimension,
            dimensionSuffix: this.trans('economic_reference.tons'),
            percent: this.formatValue(this.liquidPercent).value,
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
            icon: 'liquid.svg',
            value: this.mrpValue(true),
            dimension: '%',
            percent: this.mrpPercent,
            reversePercent: true
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

    wellsCount() {
      return [
        {
          name: '',
          value: this.trans('economic_reference.basic'),
          value_optimized: this.trans('economic_reference.optimized')
        },
        {
          name: this.trans('economic_reference.total'),
          value: (+this.scenario.uwi_count_profitable.original_value)
              + (+this.scenario.uwi_count_profitless_cat_1.original_value)
              + (+this.scenario.uwi_count_profitless_cat_2.original_value),
          value_optimized: (+this.scenario.uwi_count_profitable.original_value_optimized)
              + (+this.scenario.uwi_count_profitless_cat_1.original_value_optimized)
              + (+this.scenario.uwi_count_profitless_cat_2.original_value_optimized),
        },
        {
          name: this.trans('economic_reference.profitable'),
          value: this.scenario.uwi_count_profitable.original_value,
          value_optimized: this.scenario.uwi_count_profitable.original_value_optimized,
        },
        {
          name: this.trans('economic_reference.profitless_all'),
          value: (+this.scenario.uwi_count_profitless_cat_1.original_value)
              + (+this.scenario.uwi_count_profitless_cat_2.original_value),
          value_optimized: (+this.scenario.uwi_count_profitless_cat_1.original_value_optimized)
              + (+this.scenario.uwi_count_profitless_cat_2.original_value_optimized)
        },
        {
          name: this.trans('economic_reference.profitless_cat_1'),
          value: this.scenario.uwi_count_profitless_cat_1.original_value,
          value_optimized: this.scenario.uwi_count_profitless_cat_1.original_value_optimized,
          nameClass: 'pl-3'
        },
        {
          name: this.trans('economic_reference.profitless_cat_2'),
          value: this.scenario.uwi_count_profitless_cat_2.original_value,
          value_optimized: this.scenario.uwi_count_profitless_cat_2.original_value_optimized,
          nameClass: 'pl-3'
        },
        {
          name: this.trans('economic_reference.new_wells'),
          value: 0,
          value_optimized: 0
        }
      ]
    },

    scenario() {
      let scenario = this.res.scenarios.find(item =>
          item.oil_price === this.scenarioVariation.oil_price &&
          item.dollar_rate === this.scenarioVariation.dollar_rate &&
          item.coef_cost_WR_payroll === this.scenarioVariation.salary_percent &&
          item.coef_Fixed_nopayroll === this.scenarioVariation.retention_percent &&
          item.percent_stop_cat_1 === this.scenarioVariation.optimization_percent.cat_1 &&
          item.percent_stop_cat_2 === this.scenarioVariation.optimization_percent.cat_2
      ) || this.res.scenarios[0]

      jsonColumns.forEach(column => {
        if (typeof scenario[column] === 'string') {
          scenario[column] = JSON.parse(scenario[column])
        }
      })

      return scenario
    },

    scenarioVariations() {
      let variations = {
        oil_prices: {},
        dollar_rates: {},
        salary_percents: {},
        retention_percents: {},
        optimization_percents: {},
      }

      this.res.scenarios.forEach(item => {
        variations.oil_prices[item.oil_price] = 1

        variations.dollar_rates[item.dollar_rate] = 1

        variations.salary_percents[item.coef_cost_WR_payroll] = 1

        variations.retention_percents[item.coef_Fixed_nopayroll] = 1

        variations.optimization_percents[`${item.percent_stop_cat_1}-${item.percent_stop_cat_2}`] = 1
      })

      variations.oil_prices = Object.keys(variations.oil_prices)

      variations.dollar_rates = Object.keys(variations.dollar_rates)

      variations.salary_percents = Object.keys(variations.salary_percents).map(value => ({
        label: `${value * 100}%`,
        value: value,
      }))

      variations.retention_percents = Object.keys(variations.retention_percents).map(value => ({
        label: `${value * 100}%`,
        value: value,
      }))

      variations.optimization_percents = Object.keys(variations.optimization_percents).map((value) => {
        let values = value.split('-')

        let cat1 = values[0]

        let cat2 = values[1]

        return {
          label: `${this.trans('economic_reference.cat_1_trips')}: ${cat1 * 100}%, ` +
              `${this.trans('economic_reference.cat_2_trips')}: ${cat2 * 100}%`,
          value: {
            cat_1: cat1,
            cat_2: cat2
          }
        }
      })

      return variations
    },

    scenarioValueKey() {
      return this.form.scenario_id ? 'original_value_optimized' : 'original_value'
    },

    dollarRatePercent() {
      return (+this.res.dollarRate.value - (+this.scenario.dollar_rate)).toFixed(2)
    },

    oilPricePercent() {
      return (+this.res.oilPrice.value - (+this.scenario.oil_price)).toFixed(2)
    },

    oilPercent() {
      return this.scenario.oil.original_value - this.scenario.oil.original_value_optimized
    },

    liquidPercent() {
      return this.scenario.liquid.original_value - this.scenario.liquid.original_value_optimized
    },

    prsPercent() {
      return this.scenario.prs.original_value_optimized - this.scenario.prs.original_value
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
      this.SET_LOADING(true);

      try {
        const {data} = await this.axios.get(this.localeUrl('/economic/optimization/get-data'), {params: this.form})

        this.res = data
      } catch (e) {
        this.res = economicRes

        console.log(e)
      }

      this.SET_LOADING(false);
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

    mrpValue(optimized = true) {
      if (!this.form.scenario_id) {
        optimized = false
      }

      let workedDays = optimized
          ? +this.scenario.days_worked.original_value_optimized
          : +this.scenario.days_worked.original_value

      let prs = optimized
          ? +this.scenario.prs.original_value_optimized
          : +this.scenario.prs.original_value

      return prs
          ? (workedDays / prs).toFixed(2)
          : 0
    },

    waterCutValue(optimized = true) {
      if (!this.form.scenario_id) {
        optimized = false
      }

      let liquid = optimized
          ? +this.scenario.liquid.original_value_optimized
          : +this.scenario.liquid.original_value

      let oil = optimized
          ? +this.scenario.oil.original_value_optimized
          : +this.scenario.oil.original_value

      // TODO: посмотреть более точную формулу
      return liquid
          ? (100 * (liquid - oil) / liquid).toFixed(2)
          : 0
    },

    avgOilValue(optimized = true) {
      if (!this.form.scenario_id) {
        optimized = false
      }

      let days_worked = optimized
          ? +this.scenario.days_worked.original_value_optimized
          : +this.scenario.days_worked.original_value

      let oil = optimized
          ? +this.scenario.oil.original_value_optimized
          : +this.scenario.oil.original_value

      return days_worked
          ? (oil / days_worked).toFixed(2)
          : 0
    },

    avgLiquidValue(optimized = true, fractionDigits = 2) {
      if (!this.form.scenario_id) {
        optimized = false
      }

      let days_worked = optimized
          ? +this.scenario.days_worked.original_value_optimized
          : +this.scenario.days_worked.original_value

      let liquid = optimized
          ? +this.scenario.liquid.original_value_optimized
          : +this.scenario.liquid.original_value

      return days_worked
          ? (liquid / days_worked).toFixed(fractionDigits)
          : 0
    },

    avgPrsValue(optimized = true, fractionDigits = 2) {
      if (!this.form.scenario_id) {
        optimized = false
      }

      let uwi_count = optimized
          ? +this.scenario.uwi_count.original_value_optimized
          : +this.scenario.uwi_count.original_value

      let prs = optimized
          ? +this.scenario.prs.original_value_optimized
          : +this.scenario.prs.original_value

      return uwi_count
          ? (prs / uwi_count).toFixed(fractionDigits)
          : 0
    },
  }
};
</script>
<style scoped>
.font-size-12px {
  font-size: 12px;
}

.font-size-16px {
  font-size: 16px;
}

.font-size-24px {
  font-size: 24px;
}

.line-height-14px {
  line-height: 14px;
}

.line-height-16px {
  line-height: 16px;
}

.line-height-20px {
  line-height: 20px;
}

.line-height-28px {
  line-height: 28px;
}

.bg-blue-dark {
  background: #2B2E5E;
}

.bg-dark-blue {
  background: #333975;
}

.bg-export {
  background: #213181;
}

.text-blue {
  color: #82BAFF;
}

.text-grey {
  color: #656A8A
}

.remote-link {
  position: absolute;
  top: 5px;
  right: 5px;
}

.mb-10px {
  margin-bottom: 10px;
}
</style>
