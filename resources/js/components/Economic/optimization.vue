<template>
  <div class="container-fluid position-relative">
    <cat-loader v-show="loading"/>

    <div class="row">
      <div class="col-9 pr-2">
        <div class="row text-white text-wrap flex-nowrap">
          <div class="p-3 bg-blue-dark">
            <economic-title font-size="58" line-height="72" class="text-nowrap">
              <span>{{ scenario.Revenue_total.value_optimized[0] }}</span>

              <span class="font-size-16px line-height-20px text-blue">
               {{ scenario.Revenue_total.value_optimized[1] }}
              </span>
            </economic-title>

            <subtitle font-size="18">
              {{ trans('economic_reference.Revenue') }}
            </subtitle>

            <percent-progress :percent="scenario.Revenue_total.percent"/>

            <div class="d-flex font-size-12px line-height-14px mb-2">
              <div class="flex-grow-1 text-blue">
                {{ 100 + scenario.Revenue_total.percent }} %
              </div>

              <div>{{ scenario.Revenue_total.value[0] }}</div>
            </div>

            <div class="d-flex align-items-center">
              <percent-badge
                  :percent="scenario.Revenue_total.percent"
                  class="text-nowrap mr-2"
                  reverse/>

              <div class="flex-grow-1 text-blue font-size-12px line-height-16px text-right">
                {{ trans('economic_reference.vs_base_case') }}
              </div>
            </div>
          </div>

          <div class="p-3 bg-blue-dark position-relative">
            <divider/>

            <economic-title font-size="58" line-height="72" class="text-nowrap">
              <span>{{ scenario.Overall_expenditures.value_optimized[0] }}</span>

              <span class="font-size-16px line-height-20px text-blue">
                {{ scenario.Overall_expenditures.value_optimized[1] }}
              </span>
            </economic-title>

            <subtitle font-size="18">
              {{ trans('economic_reference.costs') }}
            </subtitle>

            <percent-progress :percent="scenario.Overall_expenditures.percent"/>

            <div class="d-flex font-size-12px line-height-14px mb-2">
              <div class="flex-grow-1 text-blue">
                {{ 100 + scenario.Overall_expenditures.percent }} %
              </div>

              <div>{{ scenario.Overall_expenditures.value[0] }}</div>
            </div>

            <div class="d-flex align-items-center">
              <percent-badge
                  :percent="-scenario.Overall_expenditures.percent"
                  class="text-nowrap mr-2"/>

              <div class="flex-grow-1 text-blue font-size-12px line-height-16px text-right">
                {{ trans('economic_reference.vs_base_case') }}
              </div>
            </div>
          </div>

          <div class="p-3 bg-blue-dark position-relative">
            <divider/>

            <economic-title font-size="58" line-height="72" class="text-nowrap">
              <span>{{ scenario.operating_profit_12m.value_optimized[0] }}</span>

              <span class="font-size-16px line-height-20px text-blue">
                {{ scenario.operating_profit_12m.value_optimized[1] }}
              </span>
            </economic-title>

            <subtitle font-size="18">
              {{ trans('economic_reference.operating_profit') }}
            </subtitle>

            <percent-progress :percent="scenario.operating_profit_12m.percent"/>

            <div class="d-flex font-size-12px line-height-14px mb-2">
              <div class="flex-grow-1 text-blue">
                {{ 100 + scenario.operating_profit_12m.percent }} %
              </div>

              <div>{{ scenario.operating_profit_12m.value[0] }}</div>
            </div>

            <div class="d-flex align-items-center">
              <percent-badge
                  :percent="scenario.operating_profit_12m.percent"
                  class="text-nowrap mr-2"
                  reverse/>

              <div class="flex-grow-1 text-blue font-size-12px line-height-14px text-right">
                {{ trans('economic_reference.vs_base_case') }}
              </div>
            </div>
          </div>

          <div class="p-3 bg-blue-dark flex-grow-1 ml-2 d-flex flex-column">
            <div class="text-nowrap font-weight-bold"
                 style="font-size: 52px; line-height: 64px;">
              <span>{{ res.oilPrice }}</span>

              <span class="font-size-16px line-height-20px text-blue">$ / bbl</span>
            </div>

            <subtitle font-size="18">
              {{ trans('economic_reference.oil_price') }}
            </subtitle>

            <span class="text-grey font-size-12px line-height-14px flex-grow-1">
              {{ trans('economic_reference.current') }}
            </span>

            <div class="d-flex align-items-center">
              <div class="font-size-24px line-height-28px font-weight-bold text-nowrap">
                <percent-badge-icon :percent="oilPricePercent" reverse/>

                <span>{{ oilPricePercent }}</span>

                <span class="font-size-16px">$/bbl</span>
              </div>

              <div class="flex-grow-1 text-blue font-size-12px line-height-14px text-right">
                {{ trans('economic_reference.vs_choice') }}
              </div>
            </div>
          </div>

          <div class="p-3 bg-blue-dark flex-grow-1 ml-2 d-flex flex-column">
            <div class="text-nowrap font-weight-bold"
                 style="font-size: 52px; line-height: 64px;">
              <span>{{ res.dollarRate }}</span>

              <span class="font-size-16px line-height-20px text-blue">kzt / $</span>
            </div>

            <subtitle font-size="18">
              {{ trans('economic_reference.course_prices') }}
            </subtitle>

            <span class="text-grey font-size-12px line-height-14px flex-grow-1">
              {{ trans('economic_reference.current') }}
            </span>

            <div class="d-flex align-items-center">
              <div class="font-size-24px line-height-28px font-weight-bold text-nowrap">
                <percent-badge-icon :percent="dollarRatePercent" reverse/>

                <span>{{ dollarRatePercent }}</span>

                <span class="font-size-16px">kzt / $</span>
              </div>

              <div class="flex-grow-1 text-blue font-size-12px line-height-16px text-right">
                {{ trans('economic_reference.vs_choice') }}
              </div>
            </div>
          </div>
        </div>

        <tables v-if="!loading"/>
      </div>

      <div class="col-3">
        <div class="bg-main1 text-white text-wrap p-3 mb-3">
          <subtitle>
            {{ trans('economic_reference.production_wells_fund') }}
          </subtitle>

          <div class="mt-4 position-relative">
            <divider style="left: 150px; height: 100%; top: 0;"/>

            <divider style="left: 230px; height: 100%; top: 0;"/>

            <div v-for="(wellCount, index) in wellsCount"
                 :key="index"
                 :class="wellCount.name ? '' : 'font-weight-bold text-grey'"
                 class="d-flex">
              <div class="font-size-12px" style="width: 150px;">
                {{ wellCount.name }}
              </div>

              <div class="ml-2" style="width: 80px">
                <span> {{ wellCount.value }}</span>
              </div>

              <div>
                <span> {{ wellCount.value_optimized }}</span>
              </div>
            </div>
          </div>
        </div>

        <div
            v-for="(block, index) in blocks"
            :key="index"
            class="d-flex bg-main1 text-white text-wrap p-3 mb-3"
            style="min-height: 175px">
          <div
              v-for="(subBlock, subBlockIndex) in block"
              :key="subBlock.title"
              :class="subBlockIndex % 2 === 1 ? '' : 'px-0'"
              class="col-6 d-flex flex-column position-relative">
            <divider v-if="subBlockIndex % 2 === 1"/>

            <div class="d-flex align-items-center font-size-32px line-height-38px text-nowrap">
              <img :src="`/img/economic/${subBlock.icon}`" alt="">

              <div class="ml-2 d-flex align-items-center">
                <span class="font-weight-bold">
                  {{ subBlock.value.toLocaleString() }}
                </span>

                <span class="ml-2 d-flex flex-column text-blue font-size-14px line-height-16px">
                  <div>{{ subBlock.valueWord }}</div>

                  <div v-if="subBlock.valueWordSuffix">
                    {{ subBlock.valueWordSuffix }}
                  </div>
                </span>
              </div>
            </div>

            <div class="text-grey font-size-14px line-height-14px font-weight-bold mb-3">
              {{ trans('economic_reference.optimized') }}
            </div>

            <div class="d-flex align-items-center font-size-12px line-height-14px text-nowrap">
              <percent-badge-icon
                  :percent="subBlock.reversePercent ? -subBlock.percent : subBlock.percent"
                  :reverse="subBlock.reverse"
                  class="font-size-22px line-height-26px mr-1"/>

              <span class="font-size-24px line-height-28px font-weight-bold">
                {{ Math.abs(subBlock.percent) }}
              </span>

              <span class="ml-2 d-flex flex-column font-size-12px line-height-12px">
                 <div>{{ subBlock.percentWord }}</div>

                  <div v-if="subBlock.percentWordSuffix">
                    {{ subBlock.percentWordSuffix }}
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

        <div class="bg-main1 p-3 mt-3 text-white text-wrap">
          <div class="font-size-16px line-height-22px font-weight-bold mb-3">
            {{ trans('economic_reference.select_optimization_scenarios') }}
          </div>

          <select-organization
              :form="form"
              class="mb-3"
              @change="getData"/>

          <div>
            <label for="oil_price">
              {{ trans('economic_reference.oil_price') }}
            </label>

            <select
                id="oil_price"
                class="mb-3 form-control text-white border-0 bg-dark-blue">
              <option
                  v-for="item in oilPrices"
                  :key="item.value"
                  :value="item.value">
                {{ item.label }}
              </option>
            </select>
          </div>

          <div>
            <label for="dollar_rate">
              {{ trans('economic_reference.course_prices') }}
            </label>

            <select
                id="dollar_rate"
                class="mb-3 form-control text-white border-0 bg-dark-blue">
              <option
                  v-for="item in dollarRates"
                  :key="item.value"
                  :value="item.value">
                {{ item.label }}
              </option>
            </select>
          </div>

          <div>
            <label for="salary_percent">
              {{ trans('economic_reference.salary_optimization') }}
            </label>

            <select
                id="salary_percent"
                class="mb-3 form-control text-white border-0 bg-dark-blue">
              <option
                  v-for="item in salaryPercents"
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
                id="retention_percent"
                class="mb-3 form-control text-white border-0 bg-dark-blue">
              <option
                  v-for="item in retentionPercents"
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
                v-model="scenarioIndex"
                id="optimization_percent"
                class="mb-3 form-control text-white border-0 bg-dark-blue">
              <option
                  v-for="item in optimizationPercents"
                  :key="item.value"
                  :value="item.value">
                {{ item.label }}
              </option>
            </select>
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

import CatLoader from '../ui-kit/CatLoader'
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
  "Revenue_total",
  "Overall_expenditures",
  "operating_profit_12m",
  "oil",
  "liquid",
  "prs",
  "well_count",
  "well_count_profitable",
  "well_count_profitless_cat_1",
  "well_count_profitless_cat_2",
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
  dollarRate: 0,
  oilPrice: 0,
}

optimizedColumns.forEach(column => {
  economicRes.scenarios[0][column] = {
    value: [0, ''],
    value_optimized: [0, ''],
    percent: 0,
    original_value: 0,
    original_value_optimized: 0,
  }
})

export default {
  name: "economic-nrs",
  components: {
    CatLoader,
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
    },
    res: economicRes,
    loading: true,
    scenarioIndex: 0
  }),
  computed: {
    blocks() {
      return [
        [
          {
            // если растет -> то зеленая вверх
            title: this.trans('economic_reference.oil_production'),
            icon: 'oil_production.svg',
            value: this.scenario.oil.value_optimized[0],
            valueWord: this.scenario.oil.value_optimized[1],
            valueWordSuffix: 'тонн',
            percent: this.oilPercent,
            percentWord: this.scenario.oil.value_optimized[1],
            percentWordSuffix: 'тонн',
            reverse: true,
            reversePercent: true
          },
          {
            // если растет -> то красная вверх
            title: this.trans('economic_reference.water_cut'),
            icon: 'liquid.svg',
            value: this.liquidValue(true),
            valueWord: '%',
            percent: this.liquidPercent,
            percentWord: '%',
            reversePercent: true
          }
        ],
        [
          {
            // если растет -> то красная вверх
            title: this.trans('economic_reference.total_prs'),
            icon: 'total_prs.svg',
            value: this.scenario.prs.value_optimized[0] * 1000,
            valueWord: 'ед',
            percent: this.prsPercent,
            percentWord: 'ед',
            reversePercent: true
          },
          {
            // если растет -> то красная вверх
            title: this.trans('economic_reference.specific_prs'),
            icon: 'specific_prs.svg',
            value: this.avgPrsValue(),
            valueWord: 'ед/скв',
            percent: this.avgPrsPercent,
            percentWord: 'ед/скв',
            reversePercent: true
          }
        ],
        [
          {
            // если растет -> то зеленая вверх
            title: this.trans('economic_reference.avg_oil_rate'),
            icon: 'total_prs.svg',
            value: this.avgOilValue(),
            valueWord: 'тонн/сут',
            percent: this.avgOilPercent,
            percentWord: 'тонн/сут',
            reverse: true
          },
          {
            // если растет -> то красная вверх
            title: this.trans('economic_reference.avg_liquid_rate'),
            icon: 'specific_prs.svg',
            value: this.avgLiquidValue(),
            valueWord: 'м³/сут',
            percent: this.avgLiquidPercent,
            percentWord: 'м³/сут',
            reverse: true,
          },
        ],
      ]
    },

    tabs() {
      return [
        'Удельные показатели',
        'Технологические показатели',
        'Технико-экономические показатели',
        'Обзорная карта скважин',
        'Таблица изменений скважины «Светофор»',
        'Зависимость прибыли скважин “Дикобраз”',
        'Варианты при цене на нефть в Х $/баррель',
        'Денежный поток НДО “Шахматка”',
        'Экономическая эффективность',
        'Палетка'
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
          name: 'Всего',
          value: (+this.scenario.well_count_profitable.original_value)
              + (+this.scenario.well_count_profitless_cat_1.original_value)
              + (+this.scenario.well_count_profitless_cat_2.original_value),
          value_optimized: (+this.scenario.well_count_profitable.original_value_optimized)
              + (+this.scenario.well_count_profitless_cat_1.original_value_optimized)
              + (+this.scenario.well_count_profitless_cat_2.original_value_optimized),
        },
        {
          name: this.trans('economic_reference.profitable'),
          value: this.scenario.well_count_profitable.original_value,
          value_optimized: this.scenario.well_count_profitable.original_value_optimized,
        },
        {
          name: this.trans('economic_reference.profitless_all'),
          value: (+this.scenario.well_count_profitless_cat_1.original_value) + (+this.scenario.well_count_profitless_cat_2.original_value),
          value_optimized: (+this.scenario.well_count_profitless_cat_1.original_value_optimized) + (+this.scenario.well_count_profitless_cat_2.original_value_optimized)
        },
        {
          name: this.trans('economic_reference.profitless_cat_1'),
          value: this.scenario.well_count_profitless_cat_1.original_value,
          value_optimized: this.scenario.well_count_profitless_cat_1.original_value_optimized
        },
        {
          name: this.trans('economic_reference.profitless_cat_2'),
          value: this.scenario.well_count_profitless_cat_2.original_value,
          value_optimized: this.scenario.well_count_profitless_cat_2.original_value_optimized,
        },
        {
          name: this.trans('economic_reference.new_wells'),
          value: 0,
          value_optimized: 0
        }
      ]
    },

    oilPrices() {
      return [
        {
          label: this.scenario.oil_price,
          value: this.scenario.oil_price,
        }
      ]
    },

    dollarRates() {
      return [
        {
          label: this.scenario.dollar_rate,
          value: this.scenario.dollar_rate,
        }
      ]
    },

    salaryPercents() {
      return [
        {
          label: `${this.scenario.coef_cost_WR_payroll * 100}%`,
          value: this.scenario.coef_cost_WR_payroll,
        },
      ]
    },

    retentionPercents() {
      return [
        {
          label: `${this.scenario.coef_Fixed_nopayroll * 100}%`,
          value: this.scenario.coef_Fixed_nopayroll,
        },
      ]
    },

    optimizationPercents() {
      let items = []

      this.res.scenarios.forEach((item, index) => {
        items.push({
          label: `Отключения категории 1: ${item.percent_stop_cat_1 * 100}%, категории 2: ${item.percent_stop_cat_2 * 100}%`,
          value: index,
        })
      })

      return items
    },

    scenario() {
      return this.res.scenarios[this.scenarioIndex]
    },

    dollarRatePercent() {
      return (+this.res.dollarRate - (+this.scenario.dollar_rate)).toFixed(2)
    },

    oilPricePercent() {
      return (+this.res.oilPrice - (+this.scenario.oil_price)).toFixed(2)
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
      return (this.avgLiquidValue(true, 4) - this.avgLiquidValue(false, 4)).toFixed(3)
    },

    avgPrsPercent() {
      return (this.avgPrsValue(true, 4) - this.avgPrsValue(false, 4)).toFixed(2)
    }
  },
  methods: {
    async getData() {
      this.loading = true

      try {
        const {data} = await this.axios.get(this.localeUrl('/economic/optimization/get_data'), {params: this.form})

        this.res = data
      } catch (e) {
        this.res = economicRes

        console.log(e)
      }

      this.loading = false
    },

    calcSubBlockWidth(percent) {
      return percent <= 0
          ? percent + 100
          : +Math.floor(100 * percent / (100 + percent))
    },

    liquidValue(optimized = true) {
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
      let well_count = optimized
          ? this.scenario.well_count.original_value_optimized
          : this.scenario.well_count.original_value

      let oil = optimized
          ? this.scenario.oil.original_value_optimized
          : this.scenario.oil.original_value

      return well_count
          ? (oil / (365 * well_count)).toFixed(2)
          : 0
    },

    avgLiquidValue(optimized = true, fractionDigits = 2) {
      let well_count = optimized
          ? this.scenario.well_count.original_value_optimized
          : this.scenario.well_count.original_value

      let liquid = optimized
          ? this.scenario.liquid.original_value_optimized
          : this.scenario.liquid.original_value

      return well_count
          ? (liquid / (365 * well_count)).toFixed(fractionDigits)
          : 0
    },

    avgPrsValue(optimized = true, fractionDigits = 2) {
      let well_count = optimized
          ? this.scenario.well_count.original_value_optimized
          : this.scenario.well_count.original_value

      let prs = optimized
          ? this.scenario.prs.original_value_optimized
          : this.scenario.prs.original_value

      return well_count
          ? (prs * 1000 / well_count).toFixed(fractionDigits)
          : 0
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

.line-height-28px {
  line-height: 28px;
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
</style>
