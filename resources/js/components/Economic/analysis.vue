<template>
  <div class="position-relative row">
    <div class="col-12 px-3 mb-10px">
      <div class="row text-white text-wrap flex-nowrap">
        <calculated-header
            v-for="(header, index) in calculatedHeaders"
            :key="`calculated_${index}`"
            :header="header"
            :index="index"
            :class="index ? 'ml-2' : ''"
            class="flex-grow-1 px-3 py-1"
            style="min-height: 130px"/>

        <remote-header
            v-for="(header, index) in remoteHeaders"
            :key="`remote_${index}`"
            :header="header"
            :form="form"
            class="flex-grow-1 px-3 py-1 ml-2"
            style="min-height: 130px"/>
      </div>
    </div>

    <div class="col-12 p-2 bg-main1 mb-10px">
      <select-scenario-variations
          :form="form"
          :scenario-variation="scenarioVariation"
          :scenario-variations="scenarioVariations"
          @changeOrg="getData()"/>
    </div>

    <div :class="scenarioVariation.isFullScreen ? 'col-12' : 'col-9 pr-2'">
      <tables
          v-if="!loading"
          :scenario="scenario"
          :scenario-variations="scenarioVariations"
          :res="res"
          style="min-height: 100%"/>
    </div>

    <div v-show="!scenarioVariation.isFullScreen" class="col-3 pr-0">
      <economic-block
          v-for="(block, index) in blocks"
          :key="index"
          :index="index"
          :block="block"
          :form="form"
          class="mb-10px"
          style="min-height: 160px"/>

      <month-headers :headers="monthHeaders"/>
    </div>
  </div>
</template>

<script>
const fileDownload = require("js-file-download");

import {globalloadingMutations, globalloadingState} from '@store/helpers';

import {formatValueMixin} from "./mixins/formatMixin";
import {scenarioMixin} from "./mixins/scenarioMixin";
import {calcPercentMixin} from "./mixins/percentMixin";

import EconomicBlock from "./components/analysis/EconomicBlock";
import SelectScenarioVariations from "./components/SelectScenarioVariations";
import CalculatedHeader from "./components/analysis/CalculatedHeader";
import RemoteHeader from "./components/RemoteHeader";
import MonthHeaders from "./components/analysis/MonthHeaders";
import Tables from "./components/analysis/Tables";

export default {
  name: "economic-analysis",
  components: {
    SelectScenarioVariations,
    Tables,
    EconomicBlock,
    CalculatedHeader,
    RemoteHeader,
    MonthHeaders,
  },
  mixins: [formatValueMixin, scenarioMixin, calcPercentMixin],
  data: () => ({
    form: {
      org_id: null,
      scenario_id: null
    },
  }),
  computed: {
    ...globalloadingState(['loading']),

    calculatedHeaders() {
      let blocks = [
        {
          title: 'НРС ОМГ',
          value: 202
        },
        {
          title: 'ЧРФ ОМГ',
          value: 134
        },
        {
          title: 'ОПЕК +',
          value: 78
        }
      ]

      return [
        {
          name: 'Количество фактических остановленных скважин',
          value: 418,
          dimension: this.trans('economic_reference.wells_count').toLocaleLowerCase(),
          blocks: blocks,
        },
        {
          name: 'Количество предлагаемых скважин на остановку',
          value: 421,
          dimension: this.trans('economic_reference.wells_count').toLocaleLowerCase(),
          blocks: blocks,
        },
        {
          name: 'Потеря добычи на остановках',
          value: 43,
          dimension: this.trans('economic_reference.thousand_tons'),
          blocks: blocks,
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
            diff: true,
          },
        ],
      ]
    },
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getData() {
      return

      this.SET_LOADING(true);

      try {
        const {data} = await this.axios.get(this.localeUrl('/economic/analysis/get-data'), {params: this.form})

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

.font-size-16px {
  font-size: 16px;
}

.font-size-32px {
  font-size: 32px;
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

.bg-export {
  background: #213181;
}

.text-blue {
  color: #82BAFF;
}

.mb-10px {
  margin-bottom: 10px;
}
</style>
