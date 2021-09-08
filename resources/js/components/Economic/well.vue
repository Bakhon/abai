<template>
  <div>
    <div class="p-3 bg-main1 mb-3 mx-auto max-width-88vw">
      <select-interval :form="form" @change="getData"/>
    </div>

    <div v-if="!loading && res"
         class="p-3 bg-main1 mb-3 mx-auto max-width-88vw d-flex align-items-center">
      <img src="/img/economic/total_prs.svg"
           height="200px"
           width="200px"
           alt=""
           class="flex-grow-0 mr-3">

      <div class="flex-grow-1">
        <div class="d-flex text-center text-white">
          <div class="flex-25"> {{ trans('economic_reference.org') }}</div>

          <div class="flex-25"> {{ trans('economic_reference.well') }}</div>

          <div class="flex-25"> {{ trans('economic_reference.operating_profit') }}</div>

          <div class="flex-25">{{ trans('economic_reference.avg_oil_rate') }}</div>
        </div>

        <div class="d-flex text-center text-white" style="font-size: 20px">
          <div class="flex-25"> {{ res.org.name }}</div>

          <div class="flex-25"> {{ well_id }}</div>

          <div class="flex-25">
            {{ operatingProfit.value.toFixed(2) }}
            {{ operatingProfit.dimension }}
            {{ trans('economic_reference.tenge') }}
          </div>

          <div class="flex-25">
            {{ formatValue(oilPerDay).value.toFixed(2) }}
            {{ formatValue(oilPerDay).dimension }}
            {{ trans('economic_reference.tons') }}
          </div>
        </div>

        <apexchart
            :options="chartOptions"
            :series="chartSeries"
            :height="300"
            type="line"
            class="bg-economic-chart mt-3"/>
      </div>
    </div>
  </div>
</template>

<script>
const ru = require("apexcharts/dist/locales/ru.json");

import chart from "vue-apexcharts";

import {globalloadingMutations, globalloadingState} from '@store/helpers';

import SelectInterval from "./components/SelectInterval";

export default {
  name: "economic-nrs-well",
  components: {
    apexchart: chart,
    SelectInterval,
  },
  props: {
    org_id: {
      required: true,
      type: Number
    },
    well_id: {
      required: true,
      type: String
    }
  },
  data: () => ({
    form: {
      interval_start: '2021-01-01T00:00:00.000Z',
      interval_end: '2021-02-01T00:00:00.000Z',
    },
    res: {
      dates: [],
      uwis: {},
      org: {name: null},
    },
  }),
  computed: {
    ...globalloadingState(['loading']),

    url() {
      return this.localeUrl('/economic/nrs/get-wells')
    },

    oilPerDay() {
      let oil = this.res.uwis[this.well_id].oil

      if (oil.sum === 0) {
        return 0
      }

      let workedDays = 0

      Object.keys(oil).forEach(day => {
        if (day === 'sum' || oil[day] === 0) return;

        workedDays += 1
      })

      return workedDays ? oil.sum / workedDays : 0
    },

    operatingProfit() {
      return this.formatValue(this.res.uwis[this.well_id].Operating_profit.sum)
    },

    chartOptions() {
      return {
        labels: [],
        stroke: {
          width: 4,
          curve: 'smooth'
        },
        chart: {
          foreColor: '#FFFFFF',
          locales: [ru],
          defaultLocale: 'ru'
        },
        markers: {
          size: 0
        },
        xaxis: {
          type: 'numeric'
        },
      }
    },

    chartSeries() {
      return [
        {
          name: this.well_id,
          type: 'line',
          data: [{
            x: this.oilPerDay,
            y: this.operatingProfit.value
          }]
        }
      ]
    },
  },
  created() {
    this.getData()
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getData() {
      this.SET_LOADING(true);

      let params = {...{org_id: this.org_id, well_id: this.well_id}, ...this.form}

      try {
        const {data} = await this.axios.get(this.url, {params: params})

        this.res = data
      } catch (e) {
        this.res = null

        console.log(e)
      }

      this.SET_LOADING(false);
    },

    formatValue(value) {
      value = +value

      let absoluteValue = Math.abs(+value)

      if (absoluteValue < 1000000) {
        return {
          value: value / 1000,
          dimension: this.trans('economic_reference.thousand')
        }
      }

      if (absoluteValue < 1000000000) {
        return {
          value: value / 1000000,
          dimension: this.trans('economic_reference.million')
        }
      }

      return {
        value: value / 1000000000,
        dimension: this.trans('economic_reference.billion')
      }
    },
  }
};
</script>
<style scoped>
.max-width-88vw {
  max-width: 88vw;
}

.flex-25 {
  flex: 0 0 25%;
}

.bg-economic-chart {
  background: #2B2E5E;
}
</style>
