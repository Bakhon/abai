<template>
  <div class="position-relative">
    <div class="row">
      <div class="col-9">
        <div class="row justify-content-between text-white bg-blue-dark text-wrap mb-10px">
          <economic-col>
            <economic-title>
              <span>{{ res.lastMonth.cat1.count.value.toLocaleString() }}</span>

              <div class="d-flex align-items-center mt-2">
                <percent-badge
                    :percent="-res.lastMonth.cat1.count.percent"
                    class="flex-shrink-0 font-size-16px line-height-18px"/>

                <div class="flex-grow-1 text-blue font-size-12px line-height-20px text-right">
                  {{ trans('economic_reference.compare_to_prev_month') }}
                </div>
              </div>
            </economic-title>

            <subtitle :font-size="14" class="mt-2 line-height-18px">
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

            <subtitle :font-size="14" class="mt-2 line-height-18px">
              {{ trans('economic_reference.operating_profit_last_year') }}
            </subtitle>
          </economic-col>

          <economic-col :font-size="52" :line-height="54">
            <divider/>

            <economic-title>
              <span>
                {{ res.lastMonth.Operating_profit.sum.value[0].toLocaleString() }}
              </span>

              <span class="font-size-16px line-height-20px text-blue">
                {{ res.lastMonth.Operating_profit.sum.value[1] }}
              </span>

              <div class="d-flex align-items-center mt-2">
                <percent-badge
                    :percent="-res.lastMonth.Operating_profit.sum.percent"
                    class="font-size-16px line-height-18px"/>

                <div class="flex-grow-1 text-blue font-size-12px line-height-20px text-right">
                  {{ trans('economic_reference.compare_to_prev_month') }}
                </div>
              </div>
            </economic-title>

            <subtitle :font-size="14" class="mt-2 line-height-18px">
              {{ trans('economic_reference.operating_profit_last_month') }}
            </subtitle>
          </economic-col>

          <economic-col :font-size="52" :line-height="54">
            <divider/>

            <economic-title>
              {{ res.lastYear.prs1.count.value.toLocaleString() }}
            </economic-title>

            <subtitle :font-size="14" class="mt-2 line-height-18px">
              {{ trans('economic_reference.count_prs_per_nrs_last_year') }}
            </subtitle>
          </economic-col>
        </div>

        <charts
            v-if="res.charts.profitability"
            :charts="res.charts"
            :granularity="form.granularity"
            :profitability="form.profitability"
            :oil-prices="res.oilPrices"
            :dollar-rates="res.dollarRates"
            :form="form"/>
      </div>

      <div class="col-3 pr-0 pl-10px">
        <div
            v-for="(block, index) in blocks"
            :key="index"
            class="d-flex bg-main1 text-white text-wrap px-3 py-2 mb-10px"
            style="min-height: 150px">
          <div
              v-for="(subBlock, subBlockIndex) in block"
              :key="subBlock.title"
              :class="subBlockIndex % 2 === 0 ? 'pl-0' : ''"
              class="col-6 d-flex flex-column position-relative">
            <divider v-if="subBlockIndex % 2 === 1"/>

            <div class="font-weight-bold font-size-26px">
              {{ subBlock.sum.value[0].toLocaleString() }}
            </div>

            <div class="text-blue font-size-12px line-height-14px">
              {{ subBlock.sum.value[1] }}
            </div>

            <div class="flex-grow-1 mt-2 font-weight-bold font-size-14px line-height-18px">
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
                class="font-size-16px line-height-18px"/>
          </div>
        </div>

        <div class="bg-main1 p-3 text-white text-wrap">
          <div class="font-size-16px line-height-14px font-weight-bold mb-3">
            {{ trans('economic_reference.select_data_display_options') }}
          </div>

          <select-interval
              :form="form"
              class="mb-2"
              @change="getData"/>

          <select-granularity
              :form="form"
              class="mb-2"
              @change="getData"/>

          <select-profitability
              :form="form"
              class="mb-2"
              @change="getData"/>

          <select-organization
              :form="form"
              class="mb-2"
              hide-label
              @change="getData"/>

          <div class="d-flex">
            <select-field
                v-if="form.org_id"
                :org_id="form.org_id"
                :form="form"
                @change="getData"/>

            <input-exclude-uwis :form="form" class="ml-2"/>
          </div>

          <div class="d-flex align-items-center" style="margin-top: 10px;">
            <button
                class="btn btn-primary w-100 border-0 bg-export py-2">
              {{ trans('economic_reference.export_excel') }}
            </button>

            <a :href="localeUrl('/economic/optimization')"
               target="_blank"
               class="ml-2">
              <button
                  class="btn btn-primary w-100 border-0 bg-export py-2">
                {{ trans('economic_reference.optimization') }}
              </button>
            </a>
          </div>
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
import Charts from "./components/nrs/Charts";
import EconomicTitle from "./components/EconomicTitle";
import Subtitle from "./components/Subtitle";
import PercentBadge from "./components/PercentBadge";
import PercentProgress from "./components/PercentProgress";
import SelectInterval from "./components/SelectInterval";
import SelectGranularity, {GRANULARITY_DAY} from "./components/SelectGranularity";
import SelectOrganization from "./components/SelectOrganization";
import SelectField from "./components/SelectField";
import SelectProfitability, {PROFITABILITY_FULL} from "./components/SelectProfitability";
import InputExcludeUwis from "./components/nrs/InputExcludeUwis";

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
    tax_costs: {
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
    wellTop: null,
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
    InputExcludeUwis,
  },
  data: () => ({
    form: {
      org_id: null,
      field_id: null,
      interval_start: '2020-01-01T00:00:00.000Z',
      interval_end: '2021-06-30T00:00:00.000Z',
      granularity: GRANULARITY_DAY,
      profitability: PROFITABILITY_FULL,
      exclude_uwis: null
    },
    res: economicRes,
  }),
  computed: {
    ...globalloadingState(['loading']),

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
            sum: this.res.lastMonth.tax_costs.sum,
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
    ...globalloadingMutations(['SET_LOADING']),

    async getData() {
      this.SET_LOADING(true);

      this.res = economicRes

      let params = {...this.form}

      if (params.exclude_uwis) {
        params.exclude_uwis = params.exclude_uwis.split(/\r?\n/)
      }

      try {
        const {data} = await this.axios.get(this.localeUrl('/economic/nrs/get-data'), {params: params})

        this.res = data
      } catch (e) {
        console.log(e)
      }

      this.SET_LOADING(false);
    },

    async exportData() {
      this.SET_LOADING(true);

      try {
        const {data} = await this.axios.post(this.localeUrl('/economic/nrs/export-data'), this.form)

        this.exportFromExcelJob(data)
      } catch (e) {
        console.log(e)
      }

      this.SET_LOADING(false);
    },

    exportFromExcelJob({id}) {
      let interval = setInterval(async () => {
        const {data} = await this.axios.get(this.localeUrl('/jobs/status'), {params: {id: id}})

        switch (data.job.status) {
          case 'finished':
            clearInterval(interval)

            this.SET_LOADING(false);

            return window.open(data.job.output.filename, '_blank')
          case 'failed':
            clearInterval(interval)

            this.SET_LOADING(false);

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

.font-size-26px {
  font-size: 26px;
}

.line-height-14px {
  line-height: 14px;
}

.line-height-18px {
  line-height: 18px;
}

.line-height-20px {
  line-height: 20px;
}

.bg-blue-dark {
  background: #2B2E5E;
}

.bg-export {
  background: #213181;
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
