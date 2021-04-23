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
            <title>
              <span>{{ res.lastMonth.cat1.count.value.toLocaleString() }}</span>

              <percent-badge :percent="-res.lastMonth.cat1.count.percent"/>
            </title>

            <subtitle>
              {{ trans('economic_reference.count_unprofitable_well_last_month') }}
            </subtitle>
          </economic-col>

          <economic-col @click.native="pushBign('bign2')">
            <divider/>

            <title>
              <span>{{ res.lastYear.Operating_profit.sum.value[0].toLocaleString() }}</span>
              <span class="font-size-16px line-height-20px text-blue">
                {{ res.lastYear.Operating_profit.sum.value[1] }}
              </span>
            </title>

            <subtitle>
              {{ trans('economic_reference.operating_profit_last_year') }}
            </subtitle>
          </economic-col>

          <economic-col @click.native="pushBign('bign3')">
            <divider/>

            <title>
              <span>
                {{ res.lastMonth.Operating_profit.sum.value[0].toLocaleString() }}
              </span>

              <span class="font-size-16px line-height-20px text-blue">
                {{ res.lastMonth.Operating_profit.sum.value[1] }}
              </span>

              <percent-badge :percent="-res.lastMonth.Operating_profit.sum.percent"/>
            </title>

            <subtitle>
              {{ trans('economic_reference.operating_profit_last_month') }}
            </subtitle>
          </economic-col>

          <economic-col @click.native="pushBign('bign4')">
            <divider/>

            <title>
              {{ res.lastYear.prs1.count.value.toLocaleString() }}
            </title>

            <subtitle>
              {{ trans('economic_reference.count_prs_per_nrs_last_year') }}
            </subtitle>
          </economic-col>
        </div>

        <charts
            v-if="!loading"
            :charts="res"
            :granularity="form.granularity"/>
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
            <divider v-if="subBlockIndex % 2 === 1"/>

            <div class="font-weight-bold font-size-32px line-height-38px">
              {{ subBlock.sum.value[0].toLocaleString() }}
            </div>

            <div class="text-blue font-size-12px line-height-14px">
              {{ subBlock.sum.value[1] }}
            </div>

            <div class="flex-grow-1 mt-3 font-weight-bold line-height-20px font-size-16px">
              {{ subBlock.title }}
            </div>

            <div :class="subBlock.sum.percent > 0 ? 'progress-reverse' : ''"
                 class="progress my-2 bg-progress"
                 style="height: 5px">
              <div
                  :class="calcSubBlockBg(subBlock.sum.percent, subBlock.reversePercent)"
                  :style="{width: calcSubBlockWidth(subBlock.sum.percent) + '%'}"
                  :aria-valuenow="subBlock.sum.percent"
                  :aria-valuemin="0"
                  :aria-valuemax="100"
                  class="progress-bar"
                  role="progressbar"
              ></div>
            </div>

            <div class="d-flex font-size-12px line-height-14px mb-2">
              <div class="flex-grow-1 text-blue">
                {{ 100 + subBlock.sum.percent }} %
              </div>

              <div>{{ subBlock.sum.value_prev[0] }}</div>
            </div>

            <percent-badge
                :percent="subBlock.reversePercent ? -subBlock.sum.percent : subBlock.sum.percent"
                :reverse="subBlock.reverse"
                class="font-size-22px line-height-26px"/>
          </div>
        </div>

        <div class="bg-main1 p-3 mt-3 text-white text-wrap">
          <div class="font-size-16px line-height-22px font-weight-bold mb-3">
            {{ trans('economic_reference.select_data_display_options') }}
          </div>

          <select-interval
              :form="form"
              class="mb-3"
              @change="getEconomicData"/>

          <select-granularity
              :form="form"
              class="mb-3"
              @change="getEconomicData"/>

          <select-organization
              :form="form"
              class="mb-3"
              @change="getEconomicData"/>

          <select-field
              v-if="form.org_id"
              :org_id="form.org_id"
              :form="form"
              @change="getEconomicData"/>

          <button
              class="btn btn-primary mt-4 py-2 w-100 border-0 bg-export"
              @click="exportEconomicData">
            {{ trans('economic_reference.export_excel') }}
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
import Divider from "./components/Divider";
import EconomicCol from "./components/EconomicCol";
import Charts from "./components/Charts";
import Title from "./components/Title";
import Subtitle from "./components/Subtitle";
import SelectInterval from "./components/SelectInterval";
import SelectGranularity, {GRANULARITY_DAY} from "./components/SelectGranularity";
import SelectOrganization from "./components/SelectOrganization";
import SelectField from "./components/SelectField";
import PercentBadge from "./components/PercentBadge";

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
    Divider,
    EconomicCol,
    Charts,
    Title,
    Subtitle,
    SelectInterval,
    SelectGranularity,
    SelectOrganization,
    SelectField,
    PercentBadge
  },
  data: () => ({
    activeTab: 0,
    form: {
      org_id: null,
      field_id: null,
      granularity: GRANULARITY_DAY,
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
            title: this.trans('economic_reference.revenue_export'),
            sum: this.res.lastMonth.Revenue_export.sum,
            reverse: true
          },
          {
            title: this.trans('economic_reference.revenue_local'),
            sum: this.res.lastMonth.Revenue_local.sum,
            reverse: true
          }
        ],
        [
          {
            title: this.trans('economic_reference.variable_expenditures'),
            sum: this.res.lastMonth.Variable_expenditures.sum,
            reversePercent: true
          },
          {
            title: this.trans('economic_reference.fixed_expenditures'),
            sum: this.res.lastMonth.Fixed_expenditures.sum,
            reversePercent: true
          }
        ],
        [
          {
            title: this.trans('economic_reference.met_payments'),
            sum: this.res.lastMonth.MET_payments.sum,
            reversePercent: true
          },
          {
            title: this.trans('economic_reference.production_expenditures'),
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
  font-size: 12px;
}

.font-size-16px {
  font-size: 16px;
}

.font-size-22px {
  font-size: 22px;
}

.font-size-32px {
  font-size: 32px;
}

.line-height-14px {
  line-height: 14px;
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
