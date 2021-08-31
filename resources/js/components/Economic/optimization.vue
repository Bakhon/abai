<template>
  <div class="position-relative">
    <div class="row">
      <div class="col-9 pr-2">
        <div class="row text-white text-wrap flex-nowrap mb-10px">
          <div
              v-for="(header, index) in calculatedHeaders"
              :key="`calculated_${index}`"
              class="p-3 bg-blue-dark position-relative">
            <divider v-if="index"/>

            <economic-title
                font-size="58"
                line-height="72"
                class="text-nowrap">
              <span> {{ header.value }} </span>

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

              <div>{{ header.baseValue }}</div>
            </div>

            <div v-if="form.scenario_id"
                 class="d-flex align-items-center">
              <percent-badge
                  :percent="header.percent"
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
                font-size="58"
                line-height="72"
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

      <div
          :style="isVisibleWellChanges ? 'padding-right: 75px' : 'padding-right:0'"
          class="col-3">
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
              <div class="font-size-12px" style="width: 150px;">
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

        <div
            v-for="(block, index) in blocks"
            :key="index"
            :style="form.scenario_id ? 'min-height: 175px' : 'min-height: 100px'"
            class="d-flex bg-main1 text-white text-wrap p-3 mb-10px">
          <div
              v-for="(subBlock, subBlockIndex) in block"
              :key="subBlock.title"
              :class="subBlockIndex % 2 === 1 ? '' : 'pl-0 pr-2'"
              class="col-6 d-flex flex-column position-relative">
            <divider v-if="subBlockIndex % 2 === 1"/>

            <div class="d-flex align-items-center font-size-32px line-height-38px text-nowrap">
              <img :src="`/img/economic/${subBlock.icon}`" alt="">

              <div class="ml-2 d-flex align-items-center">
                <span class="font-weight-bold">
                  {{ subBlock.value.toLocaleString() }}
                </span>

                <span class="ml-2 d-flex flex-column text-blue font-size-14px line-height-16px">
                  <div>{{ subBlock.dimension }}</div>

                  <div v-if="subBlock.dimensionSuffix">
                    {{ subBlock.dimensionSuffix }}
                  </div>
                </span>
              </div>
            </div>

            <div v-if="form.scenario_id"
                 class="text-grey font-size-14px line-height-14px font-weight-bold mb-3">
              {{ trans('economic_reference.optimized') }}
            </div>

            <div v-if="form.scenario_id"
                 class="d-flex align-items-center font-size-12px line-height-14px text-nowrap">
              <percent-badge-icon
                  :percent="subBlock.reversePercent ? -subBlock.percent : subBlock.percent"
                  :reverse="subBlock.reverse"
                  class="font-size-22px line-height-26px mr-1"/>

              <span class="font-size-24px line-height-28px font-weight-bold">
                {{ Math.abs(subBlock.percent) }}
              </span>

              <span class="ml-2 d-flex flex-column font-size-12px line-height-12px">
                 <div>{{ subBlock.dimension }}</div>

                  <div v-if="subBlock.dimensionSuffix">
                    {{ subBlock.dimensionSuffix }}
                  </div>
              </span>

              <span class="ml-1 font-size-12px line-height-14px text-blue">
                {{ trans('economic_reference.vs_base') }}
              </span>
            </div>

            <div class="flex-grow-1 mt-3 font-weight-bold line-height-20px font-size-16px">
              {{ subBlock.title }}
            </div>
          </div>
        </div>

        <div class="bg-main1 p-3 text-white text-wrap">
          <div class="font-size-16px line-height-22px font-weight-bold mb-3">
            {{ trans('economic_reference.select_optimization_scenarios') }}
          </div>

          <select-organization
              :form="form"
              class="mb-3"
              @change="getData"/>

          <select
              v-model="form.scenario_id"
              id="scenarios"
              class="mb-3 form-control text-white border-0 bg-dark-blue"
              @change="selectScenario">
            <option
                v-for="item in scenarios"
                :key="item.value"
                :value="item.value">
              {{ item.label }}
            </option>
          </select>

          <div v-if="form.scenario_id">
            <div>
              <label for="oil_price">
                {{ trans('economic_reference.oil_price') }}
              </label>

              <select
                  v-model="scenarioVariation.oil_price"
                  id="oil_price"
                  class="mb-3 form-control text-white border-0 bg-dark-blue">
                <option
                    v-for="item in scenarioVariations.oil_prices"
                    :key="item"
                    :value="item">
                  {{ item }}
                </option>
              </select>
            </div>

            <div>
              <label for="dollar_rate">
                {{ trans('economic_reference.course_prices') }}
              </label>

              <select
                  v-model="scenarioVariation.dollar_rate"
                  id="dollar_rate"
                  class="mb-3 form-control text-white border-0 bg-dark-blue">
                <option
                    v-for="item in scenarioVariations.dollar_rates"
                    :key="item"
                    :value="item">
                  {{ item }}
                </option>
              </select>
            </div>

            <div>
              <label for="salary_percent">
                {{ trans('economic_reference.salary_optimization') }}
              </label>

              <select
                  v-model="scenarioVariation.salary_percent"
                  id="salary_percent"
                  class="mb-3 form-control text-white border-0 bg-dark-blue">
                <option
                    v-for="item in scenarioVariations.salary_percents"
                    :key="item.value"
                    :value="item.value">
                  {{ item.label }}
                </option>
              </select>
            </div>

            <div>
              <label for="retention_percent">
                {{ trans('economic_reference.retention_percents') }}
              </label>

              <select
                  v-model="scenarioVariation.retention_percent"
                  id="retention_percent"
                  class="mb-3 form-control text-white border-0 bg-dark-blue">
                <option
                    v-for="item in scenarioVariations.retention_percents"
                    :key="item.value"
                    :value="item.value">
                  {{ item.label }}
                </option>
              </select>
            </div>

            <div>
              <label for="optimization_percent">
                {{ trans('economic_reference.stop_unprofitable_fund') }}
              </label>

              <select
                  v-model="scenarioVariation.optimization_percent"
                  id="optimization_percent"
                  class="mb-3 form-control text-white border-0 bg-dark-blue">
                <option
                    v-for="item in scenarioVariations.optimization_percents"
                    :key="item.label"
                    :value="item.value">
                  {{ item.label }}
                </option>
              </select>
            </div>
          </div>

          <button class="btn btn-primary mt-4 py-2 w-100 border-0 bg-export">
            {{ trans('economic_reference.export_excel') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const fileDownload = require("js-file-download");

import {globalloadingMutations, globalloadingState} from '@store/helpers';

import Divider from "./components/Divider";
import EconomicCol from "./components/EconomicCol";
import EconomicTitle from "./components/EconomicTitle";
import Subtitle from "./components/Subtitle";
import PercentBadge from "./components/PercentBadge";
import PercentBadgeIcon from "./components/PercentBadgeIcon";
import PercentProgress from "./components/PercentProgress";
import SelectOrganization from "./components/SelectOrganization";
import Tables from "./components/Tables";

const optimizedColumns = [
  'Revenue_total',
  'Revenue_local',
  'Revenue_export',
  'Overall_expenditures',
  'Overall_expenditures_full',
  'operating_profit_12m',
  'oil',
  'liquid',
  'prs',
  'uwi_count',
  'days_worked',
  'production_export',
  'production_local',
];

const optimizedOtherColumns = [
  'Overall_expenditures',
  'Overall_expenditures_full',
  'operating_profit_12m',
];

let economicRes = {
  scenarios: [{
    scenario_id: null,
    percent_stop_cat_1: 0,
    percent_stop_cat_2: 0,
    coef_Fixed_nopayroll: 0,
    coef_cost_WR_payroll: 0,
    dollar_rate: 0,
    oil_price: 0,
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
  }
}

let columnVariations = (column) => {
  if (optimizedOtherColumns.includes(column)) {
    return [column]
  }

  return [
    column,
    column + '_profitable',
    column + '_profitless_cat_1',
    column + '_profitless_cat_2',
  ];
}

optimizedColumns.forEach(column => {
  columnVariations(column).forEach(columnVariation => {
    economicRes.scenarios[0][columnVariation] = {
      value: [0, ''],
      value_optimized: [0, ''],
      percent: 0,
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
    Tables,
  },
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
      }
    },
    res: economicRes,
    isVisibleWellChanges: false
  }),
  computed: {
    ...globalloadingState(['loading']),

    calculatedHeaders() {
      return [
        {
          name: this.trans('economic_reference.revenue'),
          baseValue: this.scenario.Revenue_total.value[0],
          value: this.scenario.Revenue_total[this.scenarioValueKey][0],
          dimension: this.scenario.Revenue_total[this.scenarioValueKey][1],
          percent: this.scenario.Revenue_total.percent
        },
        {
          name: this.trans('economic_reference.costs'),
          baseValue: this.scenario.Overall_expenditures_full.value[0],
          value: this.scenario.Overall_expenditures_full[this.scenarioValueKey][0],
          dimension: this.scenario.Overall_expenditures_full[this.scenarioValueKey][1],
          percent: this.scenario.Overall_expenditures_full.percent
        },
        {
          name: this.trans('economic_reference.operating_profit'),
          baseValue: this.scenario.operating_profit_12m.value[0],
          value: this.scenario.operating_profit_12m[this.scenarioValueKey][0],
          dimension: this.scenario.operating_profit_12m[this.scenarioValueKey][1],
          percent: this.scenario.operating_profit_12m.percent
        }
      ]
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
            value: this.scenario.oil[this.scenarioValueKey][0],
            dimension: this.scenario.oil[this.scenarioValueKey][1],
            dimensionSuffix: this.trans('economic_reference.tons'),
            percent: this.oilPercent,
            reverse: true,
            reversePercent: true
          },
          {
            title: this.trans('economic_reference.water_cut'),
            icon: 'liquid.svg',
            value: this.liquidValue(true),
            dimension: '%',
            percent: this.liquidPercent,
            reversePercent: true
          }
        ],
        [
          {
            title: this.trans('economic_reference.total_prs'),
            icon: 'total_prs.svg',
            value: this.scenario.prs[this.scenarioValueKey][0] * 1000,
            dimension: this.trans('economic_reference.units'),
            percent: this.prsPercent,
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
            reverse: true,
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
          value_optimized: this.scenario.uwi_count_profitless_cat_1.original_value_optimized
        },
        {
          name: this.trans('economic_reference.profitless_cat_2'),
          value: this.scenario.uwi_count_profitless_cat_2.original_value,
          value_optimized: this.scenario.uwi_count_profitless_cat_2.original_value_optimized,
        },
        {
          name: this.trans('economic_reference.new_wells'),
          value: 0,
          value_optimized: 0
        }
      ]
    },

    scenarios() {
      return [
        {
          label: this.trans('economic_reference.basic_variant'),
          value: null,
        },
        {
          label: this.trans('economic_reference.test_scenario'),
          value: 6,
        }
      ]
    },

    scenario() {
      return this.res.scenarios.find(item =>
          item.oil_price === this.scenarioVariation.oil_price &&
          item.dollar_rate === this.scenarioVariation.dollar_rate &&
          item.coef_cost_WR_payroll === this.scenarioVariation.salary_percent &&
          item.coef_Fixed_nopayroll === this.scenarioVariation.retention_percent &&
          item.percent_stop_cat_1 === this.scenarioVariation.optimization_percent.cat_1 &&
          item.percent_stop_cat_2 === this.scenarioVariation.optimization_percent.cat_2
      ) || this.res.scenarios[0]
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
      return this.form.scenario_id ? 'value_optimized' : 'value'
    },

    dollarRatePercent() {
      return (+this.res.dollarRate.value - (+this.scenario.dollar_rate)).toFixed(2)
    },

    oilPricePercent() {
      return (+this.res.oilPrice.value - (+this.scenario.oil_price)).toFixed(2)
    },

    oilPercent() {
      return ((this.scenario.oil.original_value - this.scenario.oil.original_value_optimized) / 1000).toFixed(2)
    },

    prsPercent() {
      return this.scenario.prs.original_value_optimized - this.scenario.prs.original_value
    },

    liquidPercent() {
      return (this.liquidValue() - this.liquidValue(false)).toFixed(2)
    },

    avgOilPercent() {
      return (this.avgOilValue() - this.avgOilValue(false)).toFixed(2)
    },

    avgLiquidPercent() {
      return (this.avgLiquidValue(true, 4) - this.avgLiquidValue(false, 4)).toFixed(2)
    },

    avgPrsPercent() {
      return (this.avgPrsValue(true, 4) - this.avgPrsValue(false, 4)).toFixed(2)
    }
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

    selectScenario() {
      this.scenarioVariation.dollar_rate = this.scenarioVariations.dollar_rates[0]

      this.scenarioVariation.oil_price = this.scenarioVariations.oil_prices[0]

      this.scenarioVariation.salary_percent = this.scenarioVariations.salary_percents[0].value

      this.scenarioVariation.retention_percent = this.scenarioVariations.retention_percents[0].value

      this.scenarioVariation.optimization_percent.cat_1 = this.scenarioVariations.optimization_percents[0].value.cat_1

      this.scenarioVariation.optimization_percent.cat_2 = this.scenarioVariations.optimization_percents[0].value.cat_2
    },

    liquidValue(optimized = true) {
      if (!this.form.scenario_id) {
        optimized = false
      }

      let liquid = optimized
          ? this.scenario.liquid.original_value_optimized
          : this.scenario.liquid.original_value

      let oil = optimized
          ? this.scenario.oil.original_value_optimized
          : this.scenario.oil.original_value

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
          ? this.scenario.days_worked.original_value_optimized
          : this.scenario.days_worked.original_value

      let oil = optimized
          ? this.scenario.oil.original_value_optimized
          : this.scenario.oil.original_value

      return days_worked
          ? (oil / days_worked).toFixed(2)
          : 0
    },

    avgLiquidValue(optimized = true, fractionDigits = 2) {
      if (!this.form.scenario_id) {
        optimized = false
      }

      let days_worked = optimized
          ? this.scenario.days_worked.original_value_optimized
          : this.scenario.days_worked.original_value

      let liquid = optimized
          ? this.scenario.liquid.original_value_optimized
          : this.scenario.liquid.original_value

      return days_worked
          ? (liquid / days_worked).toFixed(fractionDigits)
          : 0
    },

    avgPrsValue(optimized = true, fractionDigits = 2) {
      if (!this.form.scenario_id) {
        optimized = false
      }

      let uwi_count = optimized
          ? this.scenario.uwi_count.original_value_optimized
          : this.scenario.uwi_count.original_value

      let prs = optimized
          ? this.scenario.prs.original_value_optimized
          : this.scenario.prs.original_value

      return uwi_count
          ? (prs / uwi_count).toFixed(fractionDigits)
          : 0
    },

    updateTab(tab){
      this.isVisibleWellChanges = tab === 'well_changes'
    }
  }
};
</script>
<style scoped>
.font-size-12px {
  font-size: 12px;
}

.font-size-14px {
  font-size: 14px;
}

.font-size-16px {
  font-size: 16px;
}

.font-size-22px {
  font-size: 22px;
}

.font-size-24px {
  font-size: 24px;
}

.font-size-32px {
  font-size: 32px;
}

.line-height-12px {
  line-height: 12px;
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

.line-height-22px {
  line-height: 22px;
}

.line-height-26px {
  line-height: 26px;
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
