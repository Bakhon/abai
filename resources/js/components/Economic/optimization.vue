<template>
  <div class="container-fluid position-relative">
    <cat-loader v-show="loading"/>

    <div class="row">
      <div class="col-9 pr-2">
        <div class="row text-white text-wrap flex-nowrap">
          <div class="p-3 bg-blue-dark">
            <economic-title font-size="58" line-height="72" class="text-nowrap">
              <span>{{ res.Revenue_total.sum.value_optimized[0] }}</span>
              <span class="font-size-16px line-height-20px text-blue">
               {{ res.Revenue_total.sum.value_optimized[1] }}
              </span>
            </economic-title>

            <subtitle font-size="18">
              Выручка
            </subtitle>

            <percent-progress :percent="res.Revenue_total.sum.percent"/>

            <div class="d-flex font-size-12px line-height-14px mb-2">
              <div class="flex-grow-1 text-blue">
                {{ 100 + res.Revenue_total.sum.percent }} %
              </div>

              <div>{{ res.Revenue_total.sum.value[0] }}</div>
            </div>

            <div class="d-flex align-items-center">
              <percent-badge
                  :percent="res.Revenue_total.sum.percent"
                  class="text-nowrap mr-2"/>

              <div class="flex-grow-1 text-blue font-size-12px line-height-16px text-right">
                vs Базовый вариант
              </div>
            </div>
          </div>

          <div class="p-3 bg-blue-dark position-relative">
            <divider/>

            <economic-title font-size="58" line-height="72" class="text-nowrap">
              <span>{{ res.Overall_expenditures.sum.value[0] }}</span>
              <span class="font-size-16px line-height-20px text-blue">
                {{ res.Overall_expenditures.sum.value[1] }}
              </span>
            </economic-title>

            <subtitle font-size="18">
              Расходы
            </subtitle>

            <percent-progress :percent="res.Overall_expenditures.sum.percent"/>

            <div class="d-flex font-size-12px line-height-14px mb-2">
              <div class="flex-grow-1 text-blue">
                {{ 100 + res.Overall_expenditures.sum.percent }} %
              </div>

              <div>{{ res.Overall_expenditures.sum.value[0] }}</div>
            </div>

            <div class="d-flex align-items-center">
              <percent-badge
                  :percent="res.Overall_expenditures.sum.percent"
                  class="text-nowrap mr-2"/>

              <div class="flex-grow-1 text-blue font-size-12px line-height-16px text-right">
                vs Базовый вариант
              </div>
            </div>
          </div>

          <div class="p-3 bg-blue-dark position-relative">
            <divider/>

            <economic-title font-size="58" line-height="72" class="text-nowrap">
              <span>{{ res.Operating_profit.sum.value[0] }}</span>
              <span class="font-size-16px line-height-20px text-blue">
                {{ res.Operating_profit.sum.value[1] }}
              </span>
            </economic-title>

            <subtitle font-size="18">
              Операционная прибыль
            </subtitle>

            <percent-progress :percent="res.Operating_profit.sum.percent"/>

            <div class="d-flex font-size-12px line-height-14px mb-2">
              <div class="flex-grow-1 text-blue">
                {{ 100 + res.Operating_profit.sum.percent }} %
              </div>

              <div>{{ res.Operating_profit.sum.value[0] }}</div>
            </div>

            <div class="d-flex align-items-center">
              <percent-badge
                  :percent="res.Operating_profit.sum.percent"
                  class="text-nowrap mr-2"/>

              <div class="flex-grow-1 text-blue font-size-12px line-height-14px text-right">
                vs Базовый вариант
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
              class="mb-3"
              @change="getData"/>

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
import PercentProgress from "./components/PercentProgress";
import ChartButton from "./components/ChartButton";
import SelectOrganization from "./components/SelectOrganization";

const economicRes = {
  Revenue_total: {
    sum: {
      value: [0, ''],
      value_optimized: [0, ''],
      percent: 0
    }
  },
  Overall_expenditures: {
    sum: {
      value: [0, ''],
      value_optimized: [0, ''],
      percent: 0
    }
  },
  Operating_profit: {
    sum: {
      value: [0, ''],
      value_optimized: [0, ''],
      percent: 0
    }
  },
  oil:{
    sum:{
      value: [0, ''],
    }
  }
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
    PercentProgress,
    SelectOrganization,
    ChartButton,
  },
  data: () => ({
    activeTab: 0,
    form: {
      org_id: null,
    },
    res: economicRes,
    loading: true
  }),
  computed: {
    blocks() {
      return [
        [
          {
            title: 'Добыча нефти',
            // sum "oil"
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
            // высчитывается по ф-ле
            // (liquid - oil) /  liquid
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
            // sum "prs"
            icon: 'total_prs.svg',
            value: 6130,
            valueWord: 'ед',
            percent: 527,
            percentWord: 'ед',
          },
          {
            title: 'Удельный ПРС на скв',
            // sum prs / well count
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
            // sum "oil" / (365 * well count)
            icon: 'total_prs.svg',
            value: 7.2,
            valueWord: 'тонн/сут',
            percent: 3.2,
            percentWord: 'тонн/сут',
            reverse: true,
          },
          {
            title: 'Средний дебит Жидкости',
            // sum "liquid" / (365 * well count)
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
          val2: 'Оптимизированный'
        },
        {
          name: 'Рентабельные',
          val1: 1024,
          val2: 1024
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
    calcSubBlockWidth(percent) {
      return percent <= 0
          ? percent + 100
          : +Math.floor(100 * percent / (100 + percent))
    },

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
