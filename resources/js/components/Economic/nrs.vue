<template>
  <div class="position-relative">
    <div class="row">
      <div class="col-9">
        <div class="row justify-content-between text-white bg-blue-dark text-wrap mb-10px">
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
                {{ formatValue(res.lastYear.operatingProfit).value.toFixed(2) }}
              </span>
              <span class="font-size-16px line-height-20px text-blue">
                {{ formatValue(res.lastYear.operatingProfit).dimension }}
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
                {{ formatValue(res.lastMonth.operatingProfit.last).value.toFixed(2) }}
              </span>

              <span class="font-size-16px line-height-20px text-blue">
                {{ formatValue(res.lastMonth.operatingProfit.last).dimension }}
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

      <div class="col-3 pr-0 pl-10px">
        <economic-block
            v-for="(block, index) in blocks"
            :key="index"
            :block="block"
            class="mb-10px"
            style="min-height: 150px"/>

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

import {formatValueMixin} from "./mixins/formatMixin";

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
import EconomicBlock from "./components/nrs/EconomicBlock";

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
    SelectInterval,
    SelectGranularity,
    SelectOrganization,
    SelectField,
    SelectProfitability,
    InputExcludeUwis,
    EconomicBlock,
  },
  mixins: [formatValueMixin],
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

    calcPercent({last, prev}) {
      last = +last

      prev = +prev

      if (!prev) {
        return last ? 100 : 0;
      }

      let percent = prev < 0
          ? (prev - last) * 100 / prev
          : (last - prev) * 100 / prev

      return percent.toFixed(2)
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
