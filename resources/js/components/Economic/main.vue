<template>
  <div class="container-fluid position-relative">
    <cat-loader v-show="loading"/>

    <div class="row">
      <div class="col-9">
        <modal
            v-for="bignKey in bignKeys"
            :key="bignKey"
            :name="bignKey"
            :width="1150"
            :height="400"
            adaptive>
          <vue-table-dynamic ref="table" :params="params"/>
        </modal>

        <div class="row justify-content-between text-white bg-blue-dark text-wrap">
          <economic-col @click.native="pushBign('bign1')">
            <economic-title>
              <span>{{ res.lastMonth.cat1.count.value.toLocaleString() }}</span>

              <economic-percent-badge :percent="-res.lastMonth.cat1.count.percent"/>
            </economic-title>

            <economic-subtitle>
              Количество нерентабельных скважин за последний месяц
            </economic-subtitle>
          </economic-col>

          <economic-col @click.native="pushBign('bign2')">
            <economic-divider/>

            <economic-title>
              <span>{{ res.lastYear.Operating_profit.sum.value[0].toLocaleString() }}</span>
              <span class="font-size-16px line-height-20px text-blue">
                {{ res.lastYear.Operating_profit.sum.value[1] }}
              </span>
            </economic-title>

            <economic-subtitle>
              Операционные убытки по НРС с начала года
            </economic-subtitle>
          </economic-col>

          <economic-col @click.native="pushBign('bign3')">
            <economic-divider/>

            <economic-title>
              <span>
                {{ res.lastMonth.Operating_profit.sum.value[0].toLocaleString() }}
              </span>

              <span class="font-size-16px line-height-20px text-blue">
                {{ res.lastMonth.Operating_profit.sum.value[1] }}
              </span>

              <economic-percent-badge :percent="-res.lastMonth.Operating_profit.sum.percent"/>
            </economic-title>

            <economic-subtitle>
              Операционные убытки по НРС за последний месяц
            </economic-subtitle>
          </economic-col>

          <economic-col @click.native="pushBign('bign4')">
            <economic-divider/>

            <economic-title>
              {{ res.lastYear.prs1.count.value.toLocaleString() }}
            </economic-title>

            <economic-subtitle>
              Количество ПРС на НРС с начала года
            </economic-subtitle>
          </economic-col>
        </div>

        <economic-charts v-if="!loading" :charts="res"/>
      </div>

      <div class="col-3">
        <div
            v-for="(block, index) in blocks"
            :key="index"
            class="d-flex bg-main1 text-white text-wrap p-3 mb-3"
            style="min-height: 220px">
          <div
              v-for="(subBlock, subBlockIndex) in block"
              :key="subBlock.title"
              class="col-6 d-flex flex-column position-relative">
            <economic-divider v-if="subBlockIndex % 2 === 1"/>

            <div class="font-weight-bold font-size-32px line-height-38px">
              {{ subBlock.sum.value[0].toLocaleString() }}
            </div>

            <div class="text-blue font-size-12px line-height-14px">
              {{ subBlock.sum.value[1] }}
            </div>

            <div class="flex-grow-1 mt-3 font-weight-bold line-height-20px font-size-16px">
              {{ subBlock.title }}
            </div>

            <div class="progress my-2"
                 style="background: rgba(94, 92, 230, 0.2); height: 5px">
              <div
                  :class="subBlock.sum.percent > 0  && !subBlock.reversePercent || subBlock.sum.percent < 0 && subBlock.reversePercent ? 'bg-green' : 'bg-red'"
                  :style="{width: (subBlock.sum.percent < 0 ? subBlock.sum.percent + 100 : subBlock.sum.percent) + '%'}"
                  :aria-valuenow="subBlock.sum.percent"
                  :aria-valuemin="0"
                  :aria-valuemax="100"
                  class="progress-bar"
                  role="progressbar"
              ></div>
            </div>

            <div class="d-flex font-size-12px line-height-14px mb-2">
              <div class="flex-grow-1" style="color: #82BAFF">
                {{ 100 + subBlock.sum.percent }} %
              </div>

              <div>{{ subBlock.sum.value_prev[0] }}</div>
            </div>

            <economic-percent-badge
                :percent="subBlock.reversePercent ? -subBlock.sum.percent : subBlock.sum.percent"
                :reverse="subBlock.reverse"
                class="font-size-22px line-height-26px"/>
          </div>
        </div>

        <div class="bg-main1 p-3 mt-3 text-white text-wrap">
          <div class="font-size-16px line-height-22px font-weight-bold mb-3">
            Выбор параметров отображения данных
          </div>

          <economic-select-interval
              :form="form"
              class="mb-3"
              @change="getEconomicData"/>

          <economic-select-organization
              :form="form"
              class="mb-3"
              @change="getEconomicData"/>

          <economic-select-dpz
              :form="form"
              @change="getEconomicData"/>

          <button
              class="btn btn-primary mt-4 py-2 w-100 border-0"
              style="background: #213181 !important"
              @click="exportEconomicData">
            Выгрузить в Excel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const fileDownload = require("js-file-download");

import VModal from 'vue-js-modal'
import VueTableDynamic from 'vue-table-dynamic'
import CatLoader from '../ui-kit/CatLoader'
import EconomicDivider from "./components/EconomicDivider";
import EconomicCol from "./components/EconomicCol";
import EconomicCharts from "./components/EconomicCharts";
import EconomicTitle from "./components/EconomicTitle";
import EconomicSubtitle from "./components/EconomicSubtitle";
import EconomicSelectInterval from "./components/EconomicSelectInterval";
import EconomicSelectOrganization from "./components/EconomicSelectOrganization";
import EconomicSelectDpz from "./components/EconomicSelectDpz";
import EconomicPercentBadge from "./components/EconomicPercentBadge";

Vue.use(VModal, {dynamicDefault: {draggable: true, resizable: true}});

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
  chart1: null,
  chart2: null,
  chart3: null,
  chart4: null,
  chart5: null,
}

export default {
  name: "economic-component",
  components: {
    VueTableDynamic,
    CatLoader,
    EconomicDivider,
    EconomicCol,
    EconomicCharts,
    EconomicTitle,
    EconomicSubtitle,
    EconomicSelectInterval,
    EconomicSelectOrganization,
    EconomicSelectDpz,
    EconomicPercentBadge
  },
  data: () => ({
    activeTab: 0,
    form: {
      org: null,
      dpz: null,
      interval_start: null,
      interval_end: null
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
    loading: true
  }),
  computed: {
    blocks() {
      return [
        [
          {
            title: 'Выручка экспорт',
            sum: this.res.lastMonth.Revenue_export.sum,
            reverse: true
          },
          {
            title: 'Выручка местный рынок',
            sum: this.res.lastMonth.Revenue_local.sum,
            reverse: true
          }
        ],
        [
          {
            title: 'Условно-переменные затраты',
            sum: this.res.lastMonth.Variable_expenditures.sum,
            reversePercent: true
          },
          {
            title: 'Условно-постоянные затраты',
            sum: this.res.lastMonth.Fixed_expenditures.sum,
            reversePercent: true
          }
        ],
        [
          {
            title: 'Отчисления в государство (НДПИ, Рентный налог, ЭТП)',
            sum: this.res.lastMonth.MET_payments.sum,
            reversePercent: true
          },
          {
            title: 'Общие призводственые затраты',
            sum: this.res.lastMonth.Production_expenditures.sum,
            reversePercent: true
          },
        ],
      ]
    },

    bignKeys() {
      return [
        'bign1',
        'bign2',
        'bign3',
        'bign4',
      ]
    },
  },
  methods: {
    async getEconomicData() {
      this.loading = true

      try {
        const {data} = await this.axios.get('/ru/geteconimicdata', {params: this.form})

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

        const {data} = await this.axios.post('/ru/exporteconimicdata', this.form)

        this.exportFromExcelJob(data)
      } catch (e) {
        this.loading = false

        console.log(e)
      }
    },

    exportFromExcelJob({id}) {
      let interval = setInterval(async () => {
        const {data} = await this.axios.get('/ru/jobs/status', {params: {id: id}})

        switch (data.job.status) {
          case 'finished':
            clearInterval(interval)

            this.loading = false

            return window.open(data.job.output.filename, '_blank')
          case 'failed':
            clearInterval(interval)

            this.loading = false

            return alert('Ошибка экспорта')
        }
      }, 2000)
    },

    pushBign(bign) {
      switch (bign) {
        case 'bign1':
          this.params.data = this.res.lastMonth.cat1.data;
          break;
        case 'bign2':
          this.params.data = this.res.lastYear.Operating_profit.data;
          break;
        case 'bign3':
          this.params.data = this.res.lastMonth.Operating_profit.data;
          break;
        case 'bign4':
          this.params.data = this.res.lastYear.prs1.data;
          break;
      }

      this.$modal.show(bign);
    }
  }
};
</script>
<style scoped>
.font-size-12px {
  font-size: 12px !important;
}

.font-size-16px {
  font-size: 16px !important;
}

.font-size-22px {
  font-size: 22px !important;
}

.font-size-32px {
  font-size: 32px !important;
}

.line-height-14px {
  line-height: 14px !important;
}

.line-height-20px {
  line-height: 20px !important;
}

.line-height-22px {
  line-height: 22px !important;
}

.line-height-26px {
  line-height: 26px !important;
}

.bg-blue-dark {
  background: #2B2E5E;
}

.bg-light-blue-dark {
  background: #323370 !important;
}

.bg-red {
  background: rgb(171, 19, 14) !important;
}

.bg-green {
  background: rgb(19, 176, 98) !important;
}

.text-blue {
  color: #82BAFF;
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
