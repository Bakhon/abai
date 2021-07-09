<template>
  <div class="container-fluid position-relative">
    <cat-loader v-show="loading"/>

    <div class="row">
      <div class="col-9 pr-2">
        <div class="row text-white text-wrap flex-nowrap">
          <div class="p-3 bg-blue-dark">
            <economic-title font-size="58" line-height="72" class="text-nowrap">
              <span>259 846</span>
              <span class="font-size-16px line-height-20px text-blue">
                млн. тенге
              </span>
            </economic-title>

            <subtitle font-size="18">
              Выручка
            </subtitle>

            <div class="progress my-2 bg-progress"
                 style="height: 5px">
              <div
                  :style="{width: 50 + '%'}"
                  :aria-valuenow="50"
                  :aria-valuemin="0"
                  :aria-valuemax="100"
                  class="progress-bar"
                  role="progressbar"
              ></div>
            </div>

            <div class="d-flex font-size-12px line-height-14px mb-2">
              <div class="flex-grow-1 text-blue">
                89.25%
              </div>

              <div>291 167</div>
            </div>

            <div class="d-flex align-items-center">
              <percent-badge :percent="-10.7" class="text-nowrap mr-2"/>

              <div class="flex-grow-1 text-blue font-size-12px line-height-16px text-right">
                vs Базовый вариант
              </div>
            </div>
          </div>

          <div class="p-3 bg-blue-dark position-relative">
            <divider/>

            <economic-title font-size="58" line-height="72" class="text-nowrap">
              <span>175 083</span>
              <span class="font-size-16px line-height-20px text-blue">
                млн. тенге
              </span>
            </economic-title>

            <subtitle font-size="18">
              Расходы
            </subtitle>

            <div class="progress my-2 bg-progress"
                 style="height: 5px">
              <div
                  :style="{width: 50 + '%'}"
                  :aria-valuenow="50"
                  :aria-valuemin="0"
                  :aria-valuemax="100"
                  class="progress-bar"
                  role="progressbar"
              ></div>
            </div>

            <div class="d-flex font-size-12px line-height-14px mb-2">
              <div class="flex-grow-1 text-blue">
                28.9%
              </div>

              <div>246 236</div>
            </div>

            <div class="d-flex align-items-center">
              <percent-badge :percent="28.9" class="text-nowrap mr-2"/>

              <div class="flex-grow-1 text-blue font-size-12px line-height-16px text-right">
                vs Базовый вариант
              </div>
            </div>
          </div>

          <div class="p-3 bg-blue-dark position-relative">
            <divider/>

            <economic-title font-size="58" line-height="72" class="text-nowrap">
              <span>1 608</span>
              <span class="font-size-16px line-height-20px text-blue">
                млн. тенге
              </span>
            </economic-title>

            <subtitle font-size="18">
              Операционная прибыль
            </subtitle>

            <div class="progress my-2 bg-progress"
                 style="height: 5px">
              <div
                  :style="{width: 50 + '%'}"
                  :aria-valuenow="50"
                  :aria-valuemin="0"
                  :aria-valuemax="100"
                  class="progress-bar"
                  role="progressbar"
              ></div>
            </div>

            <div class="d-flex font-size-12px line-height-14px mb-2">
              <div class="flex-grow-1 text-blue">
                -40.438%
              </div>

              <div>34 880</div>
            </div>

            <div class="d-flex align-items-center">
              <div class="font-size-24px line-height-28px font-weight-bold text-nowrap mr-2">
                <percent-badge-icon :percent="5" reverse/>

                <span>49 856</span>
              </div>

              <div class="flex-grow-1 text-blue font-size-12px line-height-14px text-right">
                млн. тенге vs Базовый вариант
              </div>
            </div>
          </div>

          <div class="p-3 bg-blue-dark flex-grow-1 ml-2 d-flex flex-column">
            <div class="text-nowrap font-weight-bold"
                 style="font-size: 52px; line-height: 64px;">
              <span>55</span>
              <span class="font-size-16px line-height-20px text-blue">
                  $ / bbl
              </span>
            </div>

            <subtitle font-size="18">
              Цена на нефть
            </subtitle>

            <span class="text-grey font-size-12px line-height-14px flex-grow-1">
              текущий
            </span>

            <div class="d-flex align-items-center">
              <div class="font-size-24px line-height-28px font-weight-bold text-nowrap">
                <percent-badge-icon :percent="-5" reverse/>

                <span>5</span>

                <span class="font-size-16px">$/bbl</span>
              </div>

              <div class="flex-grow-1 text-blue font-size-12px line-height-14px text-right">
                vs выбор
              </div>
            </div>
          </div>

          <div class="p-3 bg-blue-dark flex-grow-1 ml-2 d-flex flex-column">
            <div class="text-nowrap font-weight-bold"
                 style="font-size: 52px; line-height: 64px;">
              <span>421</span>
              <span class="font-size-16px line-height-20px text-blue">
                   kzt / $
              </span>
            </div>

            <subtitle font-size="18">
              Курс доллара
            </subtitle>

            <span class="text-grey font-size-12px line-height-14px flex-grow-1">
              текущий
            </span>

            <div class="d-flex align-items-center">
              <div class="font-size-24px line-height-28px font-weight-bold text-nowrap">
                <percent-badge-icon :percent="-19" reverse/>

                <span>19</span>

                <span class="font-size-16px">kzt / $</span>
              </div>

              <div class="flex-grow-1 text-blue font-size-12px line-height-16px text-right">
                vs выбор
              </div>
            </div>
          </div>
        </div>

        <div class="row p-3 mt-3 bg-main1">
          <chart-button
              v-for="(tab, index) in tabs"
              :key="index"
              :text="tab"
              :active="activeTab === index"
              :class="index ? 'ml-2' : ''"
              class="col"
              @click.native="activeTab = index"/>
        </div>
      </div>

      <div class="col-3">
        <div class="bg-main1 text-white text-wrap p-3 mb-3">
          <subtitle>
            Фонд добывающих скважин
          </subtitle>

          <div class="mt-4 position-relative">
            <divider style="left: 150px; height: 100%; top: 0;"/>
            <divider style="left: 230px; height: 100%; top: 0;"/>

            <div v-for="(fond, index) in fonds"
                 :key="index"
                 :class="fond.name ? '' : 'font-weight-bold text-grey'"
                 class="d-flex">
              <div class="font-size-12px" style="width: 150px;">
                {{ fond.name }}
              </div>

              <div class="ml-2" style="width: 80px">
                <span> {{ fond.val1 }}</span>
              </div>

              <div>
                <span> {{ fond.val2 }}</span>
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

              <div class="ml-2">
                <span class="font-weight-bold">
                  {{ subBlock.value.toLocaleString() }}
                </span>

                <span class="text-blue font-size-14px line-height-16px">
                  {{ subBlock.valueWord }}
                </span>
              </div>
            </div>

            <div class="text-grey font-size-14px line-height-14px font-weight-bold mb-3">
              Оптимизированный
            </div>

            <div class="font-size-12px line-height-14px text-nowrap">
              <percent-badge-icon
                  :percent="subBlock.reversePercent ? -subBlock.percent : subBlock.percent"
                  :reverse="subBlock.reverse"
                  class="font-size-22px line-height-26px mr-1"/>

              <span class="font-size-24px line-height-28px font-weight-bold">
                {{ subBlock.percent }}
              </span>

              <span class="font-size-12px line-height-14px">
                {{ subBlock.percentWord }}
              </span>

              <span class="font-size-12px line-height-14px text-blue">
                vs базовый
              </span>
            </div>

            <div class="flex-grow-1 mt-3 font-weight-bold line-height-20px font-size-16px">
              {{ subBlock.title }}
            </div>
          </div>
        </div>

        <div class="bg-main1 p-3 mt-3 text-white text-wrap">
          <div class="font-size-16px line-height-22px font-weight-bold mb-3">
            Выберите сценарии оптимизации
          </div>

          <select-organization
              :form="form"
              class="mb-3"/>

          <select
              class="mb-3 form-control text-white border-0"
              style="background-color: #333975;">
            <option
                v-for="price in oilPrices"
                :key="price.id"
                :value="price.id">
              {{ price.name }}
            </option>
          </select>

          <select
              class="mb-3 form-control text-white border-0"
              style="background-color: #333975;">
            <option
                v-for="rate in dollarRates"
                :key="rate.id"
                :value="rate.id">
              {{ rate.name }}
            </option>
          </select>

          <select
              class="mb-3 form-control text-white border-0"
              style="background-color: #333975;">
            <option
                v-for="salaryPercent in salaryPercents"
                :key="salaryPercent.id"
                :value="salaryPercent.id">
              {{ salaryPercent.name }}
            </option>
          </select>

          <select
              class="mb-3 form-control text-white border-0"
              style="background-color: #333975;">
            <option
                v-for="optimizationPercent in optimizationPercents"
                :key="optimizationPercent.id"
                :value="optimizationPercent.id">
              {{ optimizationPercent.name }}
            </option>
          </select>

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
import ChartButton from "./components/ChartButton";
import SelectInterval from "./components/SelectInterval";
import SelectGranularity, {GRANULARITY_DAY} from "./components/SelectGranularity";
import SelectOrganization from "./components/SelectOrganization";
import SelectField from "./components/SelectField";
import SelectProfitability, {PROFITABILITY_FULL} from "./components/SelectProfitability";

const economicRes = {
  lastYear: {
    Operating_profit: {
      data: [],
      sum: {
        value: [0, '']
      },
    },
    prs1: {
      data: [],
      count: {
        value: 0
      },
    },
  },
  lastMonth: {
    Operating_profit: {
      data: [],
      sum: {
        value: [0, ''],
        percent: 0
      },
    },
    Fixed_expenditures: {
      data: [],
      sum: {
        value: [0, ''],
        value_prev: [0, ''],
        percent: 0
      },
    },
    MET_payments: {
      data: [],
      sum: {
        value: [0, ''],
        value_prev: [0, ''],
        percent: 0
      },
    },
    Production_expenditures: {
      data: [],
      sum: {
        value: [0, ''],
        value_prev: [0, ''],
        percent: 0
      },
    },
    Revenue_export: {
      data: [],
      sum: {
        value: [0, ''],
        value_prev: [0, ''],
        percent: 0
      },
    },
    Revenue_local: {
      data: [],
      sum: {
        value: [0, ''],
        value_prev: [0, ''],
        percent: 0
      },
    },
    Variable_expenditures: {
      data: [],
      sum: {
        value: [0, ''],
        value_prev: [0, ''],
        percent: 0
      },
    },
    cat1: {
      data: [],
      count: {
        value: 0,
        percent: 0
      },
    },
  },
  charts: {
    profitability: null,
    pausedProfitability: null,
    oilProduction: null,
    liquidProduction: null,
    operatingProfitTop: null,
  },
}

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
    SelectInterval,
    SelectGranularity,
    SelectOrganization,
    SelectField,
    SelectProfitability,
    ChartButton,
  },
  data: () => ({
    activeTab: 0,
    form: {
      org_id: null,
      field_id: null,
      interval_start: '2020-06-01T00:00:00.000Z',
      interval_end: '2020-09-01T00:00:00.000Z',
      granularity: GRANULARITY_DAY,
      profitability: PROFITABILITY_FULL,
    },
    res: economicRes,
    params: {
      data: [],
      enableSearch: true,
      header: 'row',
      border: true,
      stripe: true,
      pagination: true,
      pageSize: 10,
      pageSizes: [10, 20, 50],
      height: 300
    },
    loading: false
  }),
  computed: {
    blocks() {
      return [
        [
          {
            title: 'Добыча нефти',
            icon: 'oil_production.svg',
            value: 4908,
            valueWord: 'тыс. тонн',
            percent: 527,
            percentWord: 'тыс. тонн',
            reverse: true,
            reversePercent: true
          },
          {
            title: 'Обводненность',
            icon: 'liquid.svg',
            value: 93,
            valueWord: '%',
            percent: 5.1,
            percentWord: 'тыс. тонн',
          }
        ],
        [
          {
            title: 'Общее количество ПРС',
            icon: 'total_prs.svg',
            value: 6130,
            valueWord: 'ед',
            percent: 527,
            percentWord: 'ед',
          },
          {
            title: 'Удельный ПРС на скв',
            icon: 'specific_prs.svg',
            value: 3.5,
            valueWord: 'ед/скв',
            percent: 1.2,
            percentWord: 'ед/скв',
          }
        ],
        [
          {
            title: 'Средний дебит нефти',
            icon: 'total_prs.svg',
            value: 7.2,
            valueWord: 'тонн/сут',
            percent: 3.2,
            percentWord: 'тонн/сут',
            reverse: true,
          },
          {
            title: 'Средний дебит Жидкости',
            icon: 'specific_prs.svg',
            value: 35.1,
            valueWord: 'м³/сут',
            percent: 3.9,
            percentWord: 'м³/сут',
            reverse: true,
            reversePercent: true
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

    fonds() {
      return [
        {
          name: '',
          val1: 'Базовый',
          val2: 'Выбранный'
        },
        {
          name: 'Нерентабельные',
          val1: 1024,
          val2: 1024
        },
        {
          name: 'Условно-рентабельные',
          val1: 709,
          val2: 709
        },
        {
          name: 'Нерентабельные, в т.ч.',
          val1: 1830,
          val2: 709
        },
        {
          name: 'Категория 1',
          val1: 1120,
          val2: 0
        },
        {
          name: 'Категория 2',
          val1: 710,
          val2: 0
        },
        {
          name: 'Новые скважины',
          val1: 0,
          val2: 53
        }
      ]
    },

    oilPrices() {
      return [
        {
          id: null,
          name: 'Цена на нефть'
        },
        {
          id: 1,
          name: 50
        },
        {
          id: 2,
          name: 60
        }
      ]
    },

    dollarRates() {
      return [
        {
          id: null,
          name: 'Курс доллара'
        },
        {
          id: 1,
          name: 30
        },
        {
          id: 2,
          name: 40
        }
      ]
    },

    salaryPercents() {
      return [
        {
          id: null,
          name: 'Процент оптимизации заработной платы'
        },
        {
          id: 1,
          name: 50
        },
        {
          id: 2,
          name: 70
        }
      ]
    },

    optimizationPercents() {
      return [
        {
          id: null,
          name: 'Процент остановки нерентабельного фонда'
        },
        {
          id: 1,
          name: 10
        },
        {
          id: 2,
          name: 20
        }
      ]
    },
  },
  methods: {
    calcSubBlockBg(percent, reversePercent) {
      return (percent > 0 && !reversePercent) || (percent < 0 && reversePercent)
          ? 'bg-green'
          : 'bg-red'
    },

    calcSubBlockWidth(percent) {
      return percent <= 0
          ? percent + 100
          : +Math.floor(100 * percent / (100 + percent))
    },

    async getEconomicData() {
      return

      this.loading = true

      try {
        const {data} = await this.axios.get(this.localeUrl('/geteconimicdata'), {params: this.form})

        this.res = data
      } catch (e) {
        this.res = economicRes

        console.log(e)
      }

      this.loading = false
    },

    async exportEconomicData() {
      try {
        this.loading = true

        const {data} = await this.axios.post(this.localeUrl('/export-economic-data'), this.form)

        this.exportFromExcelJob(data)
      } catch (e) {
        this.loading = false

        console.log(e)
      }
    },

    exportFromExcelJob({id}) {
      let interval = setInterval(async () => {
        const {data} = await this.axios.get(this.localeUrl('/jobs/status'), {params: {id: id}})

        switch (data.job.status) {
          case 'finished':
            clearInterval(interval)

            this.loading = false

            return window.open(data.job.output.filename, '_blank')
          case 'failed':
            clearInterval(interval)

            this.loading = false

            return alert('Export error')
        }
      }, 2000)
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

.line-height-28px {
  line-height: 28px;
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

.line-height-26px {
  line-height: 26px;
}

.progress-reverse {
  transform: rotateY(180deg);
}

.bg-blue-dark {
  background: #2B2E5E;
}

.bg-light-blue-dark {
  background: #323370;
}

.bg-export {
  background: #213181;
}

.bg-red {
  background: rgb(171, 19, 14);
}

.bg-green {
  background: rgb(19, 176, 98);
}

.bg-progress {
  background: #323370;
}

.text-blue {
  color: #82BAFF;
}

.text-grey {
  color: #656A8A
}

.loader {
  flex: 0 1 auto;
  flex-flow: row wrap;
  width: 100%;
  align-items: flex-start;
  position: absolute;
  height: 100%;
  justify-content: center;
  display: flex;
  z-index: 5000;
  background: rgba(0, 0, 0, 0.4);
  left: 0;
  top: 0;
  right: 0;
  bottom: 0;
}
</style>
