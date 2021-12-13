<template>
  <div class="position-relative">
    <div class="row">
      <div :class="form.isFullScreen ? 'col-12' : 'col-9'">
        <div v-if="form.isFullScreen" class="row mb-10px">
          <select-params
              :form="form"
              is-fullscreen
              class="w-100"
              @update="getData()"
              @fullscreen="toggleFullscreen()"/>
        </div>

        <div v-else
             class="row justify-content-between text-white bg-blue-dark text-wrap mb-10px">
          <economic-col>
            <economic-title>
              <span>{{ res.lastMonth.uwiCount.last.toLocaleString() }}</span>

              <div class="d-flex align-items-center mt-2">
                <percent-badge
                    :percent="-calcPercent(res.lastMonth.uwiCount)"
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
              <span>
                {{ localeValue(res.lastYear.operatingProfit, 1000000, false, 0) }}
              </span>
              <span class="font-size-16px line-height-20px text-blue">
                {{ trans('economic_reference.million') }}
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
                {{ localeValue(res.lastMonth.operatingProfit.last, 1000000, false, 0) }}
              </span>

              <span class="font-size-16px line-height-20px text-blue">
                 {{ trans('economic_reference.million') }}
              </span>

              <div class="d-flex align-items-center mt-2">
                <percent-badge
                    :percent="-calcPercent(res.lastMonth.operatingProfit)"
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
              {{ res.lastYear.prs.toLocaleString() }}
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

      <div v-if="!form.isFullScreen" class="col-3 pr-0 pl-10px">
        <economic-block
            v-for="(block, index) in blocks"
            :key="index"
            :block="block"
            class="mb-10px"
            style="min-height: 150px"/>

        <select-params
            :form="form"
            @update="getData()"
            @fullscreen="toggleFullscreen()"/>
      </div>
    </div>
  </div>
</template>

<script>
const fileDownload = require("js-file-download");

import {globalloadingMutations, globalloadingState} from '@store/helpers';

import {formatValueMixin} from "../mixins/formatMixin";

import Divider from "../components/Divider";
import EconomicCol from "./components/EconomicCol";
import Charts from "./components/Charts";
import EconomicTitle from "./components/EconomicTitle";
import Subtitle from "../components/Subtitle";
import PercentBadge from "../components/PercentBadge";
import PercentProgress from "../components/PercentProgress";
import SelectParams from "./components/SelectParams";
import {GRANULARITY_DAY} from "../components/SelectGranularity";
import {PROFITABILITY_FULL} from "./components/SelectProfitability";
import EconomicBlock from "./components/EconomicBlock";

const economicRes = {
  lastYear: {
    operatingProfit: 0,
    prs: 0,
  },
  lastMonth: {
    Fixed_expenditures: {last: 0, prev: 0},
    Production_expenditures: {last: 0, prev: 0},
    Variable_expenditures: {last: 0, prev: 0},
    Revenue_export: {last: 0, prev: 0},
    Revenue_local: {last: 0, prev: 0},
    Tax_costs: {last: 0, prev: 0},
    operatingProfit: {last: 0, prev: 0},
    uwiCount: {last: 0, prev: 0},
  },
  charts: {
    profitability: null,
    production: null,
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
    SelectParams,
    EconomicBlock,
  },
  mixins: [formatValueMixin],
  data: () => ({
    form: {
      org_id: null,
      field_id: null,
      interval_start: '2020-01-01T00:00:00.000Z',
      interval_end: '2021-09-30T00:00:00.000Z',
      granularity: GRANULARITY_DAY,
      profitability: PROFITABILITY_FULL,
      exclude_uwis: null,
      isFullScreen: false,
    },
    isFullScreenUpdate: false,
    res: economicRes,
  }),
  computed: {
    ...globalloadingState(['loading']),

    url() {
      return this.localeUrl('/economic/nrs/get-data')
    },

    blocks() {
      return [
        [
          {
            title: this.trans('economic_reference.revenue_export'),
            value: this.res.lastMonth.Revenue_export,
            percent: this.calcPercent(this.res.lastMonth.Revenue_export),
            reverse: true
          },
          {
            title: this.trans('economic_reference.revenue_local'),
            value: this.res.lastMonth.Revenue_local,
            percent: this.calcPercent(this.res.lastMonth.Revenue_local),
            reverse: true
          }
        ],
        [
          {
            title: this.trans('economic_reference.variable_expenditures'),
            value: this.res.lastMonth.Variable_expenditures,
            percent: this.calcPercent(this.res.lastMonth.Variable_expenditures),
            reversePercent: true,
          },
          {
            title: this.trans('economic_reference.fixed_expenditures'),
            value: this.res.lastMonth.Fixed_expenditures,
            percent: this.calcPercent(this.res.lastMonth.Fixed_expenditures),
            reversePercent: true,
          }
        ],
        [
          {
            title: this.trans('economic_reference.met_payments'),
            value: this.res.lastMonth.Tax_costs,
            percent: this.calcPercent(this.res.lastMonth.Tax_costs),
            reversePercent: true,
          },
          {
            title: this.trans('economic_reference.production_expenditures'),
            value: this.res.lastMonth.Production_expenditures,
            percent: this.calcPercent(this.res.lastMonth.Production_expenditures),
            reversePercent: true,
          },
        ],
      ]
    },
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getData() {
      if (this.isFullScreenUpdate) {
        return this.isFullScreenUpdate = false
      }

      this.SET_LOADING(true)

      this.res = economicRes

      let params = {...this.form}

      if (params.exclude_uwis) {
        params.exclude_uwis = params.exclude_uwis.split(/\r?\n/)
      }

      try {
        const {data} = await this.axios.get(this.url, {params: params})

        this.res = data
      } catch (e) {
        console.log(e)
      }

      this.SET_LOADING(false)
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

    calcPercent({last, prev}) {
      last = +last

      prev = +prev

      if (!prev) {
        return last ? 100 : 0;
      }

      let percent = prev < 0
          ? (prev - last) * 100 / prev
          : (last - prev) * 100 / prev

      return percent.toFixed(1)
    },

    toggleFullscreen() {
      this.form.isFullScreen = !this.form.isFullScreen

      this.form.isFullScreenUpdate = true
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

.line-height-18px {
  line-height: 18px;
}

.line-height-20px {
  line-height: 20px;
}

.bg-blue-dark {
  background: #2B2E5E;
}

.text-blue {
  color: #82BAFF;
}

.mb-10px {
  margin-bottom: 10px;
}

.pl-10px {
  padding-left: 10px;
}
</style>
