<template>
  <div class="position-relative">
    <div class="row">
      <div class="col-9 pr-2">
        <div class="row text-white text-wrap flex-nowrap mb-10px">
          <div v-for="(header, index) in calculatedHeaders"
               :key="`calculated_${index}`"
               class="p-3 bg-blue-dark position-relative"
               style="flex: 1 0 250px;">
            <divider v-if="index"/>

            <economic-title
                font-size="58"
                line-height="72"
                class="text-nowrap">
              <span> {{ +header.value.toFixed(2) }} </span>

              <span class="font-size-16px line-height-20px text-blue">
               {{ header.dimension }}
              </span>
            </economic-title>

            <subtitle font-size="18"> {{ header.name }}</subtitle>

            <div class="d-flex mt-2 pt-2 border-grey-top">
              <div class="flex-grow-1">
                <subtitle font-size="24"> {{ header.nrsOmg }}</subtitle>

                <div class="font-size-14px line-height-20px text-blue font-weight-bold">
                  НРС ОМГ
                </div>
              </div>

              <div class="flex-grow-1">
                <subtitle font-size="24"> {{ header.crfOmg }}</subtitle>

                <div class="font-size-14px line-height-20px text-blue font-weight-bold">
                  ЧРФ ОМГ
                </div>
              </div>

              <div class="flex-grow-1">
                <subtitle font-size="24"> {{ header.opec }}</subtitle>

                <div class="font-size-14px line-height-20px text-blue font-weight-bold">
                  ОПЕК +
                </div>
              </div>
            </div>
          </div>

          <div v-for="(header, index) in remoteHeaders"
               :key="`remote_${index}`"
               class="p-3 bg-blue-dark flex-grow-1 ml-2 d-flex flex-column position-relative"
               style="min-width: 270px">
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

            <span class="text-grey font-size-14px line-height-22px flex-grow-1 font-weight-bold">
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
            :res="res"/>
      </div>

      <div class="col-3 pr-0">
        <div class="bg-main1 text-white text-wrap mb-10px">
          <div v-for="(header, index) in monthHeaders"
               :key="header.name"
               :class="index ? 'border-grey-top' : ''"
               class="d-flex line-height-16px">
            <div :class="[index ? '' : 'pt-3', index === monthHeaders.length - 1 ? 'pb-3' : '']"
                 class="pl-3 py-2 flex-150px font-size-14px text-wrap"
                 style="font-weight: 600">
              {{ header.name }}
            </div>

            <div class="mx-2 p-2 bg-grey flex-120px">
              {{ header.dimension }}
            </div>

            <div :class="index ? '' : 'pt-3'"
                 class="p-2 flex-120px">
              {{ header.value }}
            </div>
          </div>
        </div>

        <div v-for="(block, index) in blocks"
             :key="index"
             :style="form.scenario_id ? 'min-height: 175px' : 'min-height: 100px'"
             class="d-flex bg-main1 text-white text-wrap p-3 mb-10px">
          <div v-for="(subBlock, subBlockIndex) in block"
               :key="subBlock.title"
               :class="subBlockIndex % 2 === 1 ? '' : 'pl-0 pr-2'"
               class="col-6 d-flex flex-column position-relative">
            <divider v-if="subBlockIndex % 2 === 1"/>

            <div class="d-flex align-items-center font-size-32px text-nowrap">
              <div class="d-flex align-items-center">
                <span class="font-weight-bold">
                  {{ +subBlock.value.toFixed(2) }}
                </span>

                <span class="ml-2 d-flex flex-column text-blue font-size-14px line-height-16px">
                  <div>{{ subBlock.dimension }}</div>

                  <div v-if="subBlock.dimensionSuffix">
                    {{ subBlock.dimensionSuffix }}
                  </div>
                </span>
              </div>
            </div>

            <div class="flex-grow-1 font-weight-bold line-height-20px font-size-16px">

            </div>

            <div class="flex-grow-1 font-weight-bold line-height-20px font-size-16px">
              <div>{{ subBlock.name }}</div>
              <div>Предлагаемый вариант вариант</div>
            </div>

            <percent-progress :percent="subBlock.percent"/>

            <div class="d-flex font-size-12px line-height-14px mb-2">
              <div class="flex-grow-1 text-blue">
                {{ (100 + subBlock.percent).toFixed(2) }} %
              </div>

              <div>{{ subBlock.value.toFixed(2) }}</div>
            </div>

            <div class="d-flex align-items-center">
              <percent-badge
                  :percent="subBlock.percent.toFixed(2)"
                  class="text-nowrap mr-2"
                  reverse/>

              <div class="flex-grow-1 text-blue font-size-12px line-height-16px text-right">
                vs факт
              </div>
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

          <select-scenario-variations
              v-if="form.scenario_id"
              :scenario-variation="scenarioVariation"
              :scenario-variations="scenarioVariations"/>

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

import {formatValueMixin} from "./mixins/formatMixin";
import {scenarioMixin} from "./mixins/scenarioMixin";
import {calcPercentMixin} from "./mixins/percentMixin";

import Divider from "./components/Divider";
import EconomicCol from "./components/EconomicCol";
import EconomicTitle from "./components/EconomicTitle";
import Subtitle from "./components/Subtitle";
import PercentBadge from "./components/PercentBadge";
import PercentBadgeIcon from "./components/PercentBadgeIcon";
import PercentProgress from "./components/PercentProgress";
import SelectOrganization from "./components/SelectOrganization";
import SelectScenarioVariations from "./components/SelectScenarioVariations";
import Tables from "./components/analysis/Tables";

export default {
  name: "economic-analysis",
  components: {
    Divider,
    EconomicCol,
    EconomicTitle,
    Subtitle,
    PercentBadge,
    PercentBadgeIcon,
    PercentProgress,
    SelectOrganization,
    SelectScenarioVariations,
    Tables,
  },
  mixins: [formatValueMixin, scenarioMixin, calcPercentMixin],
  computed: {
    ...globalloadingState(['loading']),

    calculatedHeaders() {
      return [
        {
          name: 'Количество фактических остановленных скважин',
          value: 418,
          dimension: this.trans('economic_reference.wells_count').toLocaleLowerCase(),
          nrsOmg: 202,
          crfOmg: 134,
          opec: 78
        },
        {
          name: 'Количество предлагаемых скважин на остановку',
          value: 421,
          dimension: this.trans('economic_reference.wells_count').toLocaleLowerCase(),
          nrsOmg: 202,
          crfOmg: 134,
          opec: 78
        },
        {
          name: 'Потеря добычи на остановках',
          value: 43,
          dimension: this.trans('economic_reference.thousand_tons'),
          nrsOmg: 2.77,
          crfOmg: 8.50,
          opec: 31.72
        }
      ]
    },

    monthHeaders() {
      return [
        {
          name: 'Месяц',
          value: 'Май',
          dimension: '',
        },
        {
          name: 'Нетбэк 2020 прогноз',
          value: 51986.1,
          dimension: 'тенге/тонна',
        },
        {
          name: 'Условно-переменные расходы',
          value: 350.3,
          dimension: 'тг/тонну жидкости'
        },
        {
          name: 'Условно-постоянные расходы',
          value: 67,
          dimension: 'тыс.тг/скв/сут с ФОТ'
        },
        {
          name: 'Средняя стоимость ПРС',
          value: 1948,
          dimension: 'тыс.тг/рем без ФОТ'
        },
        {
          name: 'Плотность нефти',
          value: 0.8,
          dimension: 'тн/м3'
        },
        {
          name: 'Дней в месяце',
          value: 31,
          dimension: 'дни'
        },
        {
          name: 'Усл.-постоянные расходы для отключаемых скважин',
          value: 46.9,
          dimension: ''
        }
      ]
    },

    blocks() {
      let revenue = this.formatValue(this.scenario.Revenue_total[this.scenarioValueKey])

      let expenditures = this.formatValue(this.scenario.Overall_expenditures_full[this.scenarioValueKey])

      let operatingProfit = this.formatValue(this.scenario.Operating_profit[this.scenarioValueKey])

      let diff = this.formatValue(this.scenario.Operating_profit[this.scenarioValueKey] - this.scenario.Operating_profit.original_value)

      return [
        [
          {
            name: 'Доходы',
            value: revenue.value,
            dimension: revenue.dimension,
            dimensionSuffix: this.trans('economic_reference.tenge'),
            percent: this.calcPercent(
                this.scenario.Revenue_total[this.scenarioValueKey],
                this.scenario.Revenue_total.original_value
            ),
          },
          {
            name: 'Расходы',
            value: expenditures.value,
            dimension: expenditures.dimension,
            dimensionSuffix: this.trans('economic_reference.tenge'),
            percent: this.calcPercent(
                this.scenario.Overall_expenditures_full[this.scenarioValueKey],
                this.scenario.Overall_expenditures_full.original_value
            ),
          }
        ],
        [
          {
            name: 'Прибыль',
            value: operatingProfit.value,
            dimension: operatingProfit.dimension,
            dimensionSuffix: this.trans('economic_reference.tenge'),
            percent: this.calcPercent(
                this.scenario.Operating_profit[this.scenarioValueKey],
                this.scenario.Operating_profit.original_value
            ),
          },
          {
            name: 'Экономический эффект',
            value: diff.value,
            dimension: diff.dimension,
            dimensionSuffix: this.trans('economic_reference.tenge'),
            percent: this.calcPercent(
                this.scenario.Operating_profit[this.scenarioValueKey],
                this.scenario.Operating_profit.original_value
            ),
          },
        ],
      ]
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

.bg-grey {
  background: #313560;
}

.text-blue {
  color: #82BAFF;
}

.text-grey {
  color: #656A8A
}

.border-grey-top {
  border-top: 1px solid #454D7D;
}

.remote-link {
  position: absolute;
  top: 5px;
  right: 5px;
}

.mb-10px {
  margin-bottom: 10px;
}

.flex-120px {
  flex: 1 0 120px;
}

.flex-150px {
  flex: 1 0 150px;
}
</style>
