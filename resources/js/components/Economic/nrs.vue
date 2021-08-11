<template>
  <div class="position-relative">
    <div class="row">
      <div class="col-9">
        <div class="row justify-content-between text-white bg-blue-dark text-wrap mb-10px">
          <economic-col>
            <economic-title>
              <span>{{ res.lastMonth.cat1.count.value.toLocaleString() }}</span>

              <div class="d-flex align-items-center">
                <percent-badge
                    :percent="-res.lastMonth.cat1.count.percent"
                    class="flex-shrink-0"/>

                <div class="flex-grow-1 text-blue font-size-12px line-height-20px text-right">
                  {{ trans('economic_reference.compare_to_prev_month') }}
                </div>
              </div>
            </economic-title>

            <subtitle class="mt-2 line-height-20px">
              {{ trans('economic_reference.count_unprofitable_well_last_month') }}
            </subtitle>
          </economic-col>

          <economic-col>
            <divider/>

            <economic-title>
              <span>{{ res.lastYear.Operating_profit.sum.value[0].toLocaleString() }}</span>
              <span class="font-size-16px line-height-20px text-blue">
                {{ res.lastYear.Operating_profit.sum.value[1] }}
              </span>
            </economic-title>

            <subtitle class="mt-2 line-height-20px">
              {{ trans('economic_reference.operating_profit_last_year') }}
            </subtitle>
          </economic-col>

          <economic-col>
            <divider/>

            <economic-title>
              <span>
                {{ res.lastMonth.Operating_profit.sum.value[0].toLocaleString() }}
              </span>

              <span class="font-size-16px line-height-20px text-blue">
                {{ res.lastMonth.Operating_profit.sum.value[1] }}
              </span>

              <div class="d-flex align-items-center">
                <percent-badge :percent="-res.lastMonth.Operating_profit.sum.percent"/>

                <div class="flex-grow-1 text-blue font-size-12px line-height-20px text-right">
                  {{ trans('economic_reference.compare_to_prev_month') }}
                </div>
              </div>
            </economic-title>

            <subtitle class="mt-2 line-height-20px">
              {{ trans('economic_reference.operating_profit_last_month') }}
            </subtitle>
          </economic-col>

          <economic-col>
            <divider/>

            <economic-title>
              {{ res.lastYear.prs1.count.value.toLocaleString() }}
            </economic-title>

            <subtitle class="mt-2 line-height-20px">
              {{ trans('economic_reference.count_prs_per_nrs_last_year') }}
            </subtitle>
          </economic-col>
        </div>

        <charts
            v-if="!loading"
            :charts="res.charts"
            :granularity="form.granularity"
            :profitability="form.profitability"
            :oil-prices="res.oilPrices"
            :dollar-rates="res.dollarRates"/>
      </div>

      <div class="col-3 pr-0 pl-10px">
        <div
            v-for="(block, index) in blocks"
            :key="index"
            class="d-flex bg-main1 text-white text-wrap p-3 mb-10px"
            style="min-height: 220px">
          <div
              v-for="(subBlock, subBlockIndex) in block"
              :key="subBlock.title"
              :class="subBlockIndex % 2 === 0 ? 'pl-0' : ''"
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

            <percent-progress :percent="subBlock.sum.percent"/>

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

        <div class="bg-main1 p-3 text-white text-wrap">
          <div class="font-size-16px line-height-22px font-weight-bold mb-3">
            {{ trans('economic_reference.select_data_display_options') }}
          </div>

          <select-interval
              :form="form"
              class="mb-3"
              @change="getData"/>

          <select-granularity
              :form="form"
              class="mb-3"
              @change="getData"/>

          <select-profitability
              :form="form"
              class="mb-3"
              @change="getData"/>

          <select-organization
              :form="form"
              class="mb-3"
              @change="getData"/>

          <select-field
              v-if="form.org_id"
              :org_id="form.org_id"
              :form="form"
              @change="getData"/>

          <button
              class="btn btn-primary mt-4 py-2 w-100 border-0 bg-export"
              @click="exportData">
            {{ trans('economic_reference.export_excel') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const fileDownload = require("js-file-download");

import Divider from "./components/Divider";
import EconomicCol from "./components/EconomicCol";
import Charts from "./components/Charts";
import EconomicTitle from "./components/EconomicTitle";
import Subtitle from "./components/Subtitle";
import PercentBadge from "./components/PercentBadge";
import PercentProgress from "./components/PercentProgress";
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
  oilPrices: [],
  dollarRates: [],
}

export default {
  name: "economic-nrs",
  components: {

    Divider,
    EconomicCol,
    Charts,
    EconomicTitle,
    Subtitle,
    PercentBadge,
    PercentProgress,
    SelectInterval,
    SelectGranularity,
    SelectOrganization,
    SelectField,
    SelectProfitability,
  },
  data: () => ({
    form: {
      org_id: null,
      field_id: null,
      interval_start: '2020-01-01T00:00:00.000Z',
      interval_end: '2021-01-01T00:00:00.000Z',
      granularity: GRANULARITY_DAY,
      profitability: PROFITABILITY_FULL,
    },
    res: economicRes,
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
  },
  methods: {
    async getData() {
      this.loading = true

      try {
        const {data} = await this.axios.get(this.localeUrl('/economic/nrs/get-data'), {params: this.form})

        this.res = data
      } catch (e) {
        this.res = economicRes

        console.log(e)
      }

      this.loading = false
    },

    async exportData() {
      try {
        this.loading = true

        const {data} = await this.axios.post(this.localeUrl('/economic/nrs/export-data'), this.form)

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

.pl-10px {
  padding-left: 10px;
}

.mb-10px {
  margin-bottom: 10px;
}
</style>
