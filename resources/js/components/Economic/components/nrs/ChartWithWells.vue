<template>
  <div>
    <apexchart
        :options="chartOptions"
        :series="chartSeries"
        :height="350"/>

    <div class="mt-2 text-white">
      <div class="text-center border-grey d-flex bg-header">
        <div
            v-for="(item, index) in tableKeys"
            :key="item.value"
            :style="`flex: ${item.flexGrow} 0 ${item.flexWidth}`"
            :class="index ? 'justify-content-center' : ''"
            class="p-3 border-grey d-flex align-items-center line-height-16px"
            style="white-space: normal">
          {{ item.title }}
        </div>
      </div>

      <div v-for="(item, index) in tableData"
           :key="index"
           :style="`background: ${item.color}`"
           class="d-flex">
        <div v-for="(key, keyIndex) in tableKeys"
             :key="key.value"
             :class="keyIndex ? 'text-center justify-content-center' : ''"
             :style="`flex: ${key.flexGrow} 0 ${key.flexWidth}; ${keyIndex ? '' : item.style}`"
             class="border-grey line-height-14px d-flex align-items-center px-3 py-2">
          {{
            typeof item[key.value] === 'string'
                ? item[key.value]
                : (+item[key.value].toFixed(2)).toLocaleString()
          }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

import chart from "vue-apexcharts";

const ru = require("apexcharts/dist/locales/ru.json");

export default {
  name: "ChartWithWells",
  components: {apexchart: chart},
  props: {
    form: {
      required: true,
      type: Object
    }
  },
  data: () => ({
    wells: null,
    dates: [],
  }),
  created() {
    this.getWells()
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getWells() {
      this.SET_LOADING(true);

      let params = {
        ...this.form,
        ...{granularity: 'year'},
      }

      try {
        const {data} = await this.axios.get(this.url, {params: params})

        this.dates = data.dates

        this.wells = data.uwis
      } catch (e) {
        console.log(e)
      }

      this.SET_LOADING(false);
    },

    calcLiquid(liquid, oil) {
      return +liquid === 0
          ? 0
          : 100 * (+liquid - +oil) / (+liquid)
    },

    calcAvgQn(oil, day_well_number) {
      return +day_well_number === 0
          ? 0
          : +oil / +day_well_number
    },
  },
  computed: {
    url() {
      return this.localeUrl('/economic/nrs/get-wells')
    },

    sortedUwis() {
      if (!this.wells) {
        return []
      }

      return Object.keys(this.wells).sort((prev, next) => {
        return +this.wells[prev].Operating_profit.sum - +this.wells[next].Operating_profit.sum
      })
    },

    chartOptions() {
      return {
        labels: this.sortedUwis,
        stroke: {
          width: 4,
          curve: 'smooth'
        },
        chart: {
          stacked: false,
          foreColor: '#FFFFFF',
          locales: [ru],
          defaultLocale: 'ru'
        },
        markers: {
          size: 0
        },
        plotOptions: {
          bar: {
            columnWidth: '50%'
          }
        },
        fill: {
          opacity: 0.9,
        },
        yaxis: this.chartSeries.map((chart, index) => {
          return {
            show: true,
            opposite: !!index,
            title: {
              text: chart.name
            },
            labels: {
              formatter: (value) => {
                if (chart.dimension) {
                  value /= chart.dimension
                }

                return +value.toFixed(2)
              }
            },
          }
        }),
        tooltip: {
          shared: true,
          intersect: false,
          y: this.chartSeries.map((chart) => {
            return {
              formatter: (value) => {
                if (chart.dimension) {
                  value /= chart.dimension
                }

                return `${(+value.toFixed(2)).toLocaleString()} ${chart.dimensionTitle}`
              }
            }
          })
        },
      }
    },

    chartSeries() {
      let series = []

      let oil = []

      let operatingProfit = []

      this.sortedUwis.forEach(uwi => {
        oil.push(+this.wells[uwi].oil.sum)

        operatingProfit.push(+this.wells[uwi].Operating_profit.sum)
      })

      series.push(
          {
            name: this.trans('economic_reference.oil_production'),
            type: 'area',
            color: '#5697D9',
            data: oil,
            dimensionTitle: `
              ${this.trans('economic_reference.tons')}
            `,
          },
          {
            name: this.trans('economic_reference.operating_profit'),
            type: 'line',
            color: '#F08537',
            data: operatingProfit,
            dimension: 1000000,
            dimensionTitle: `
              ${this.trans('economic_reference.million')}.
              ${this.trans('economic_reference.tenge')}
            `,
          },
      )

      return series
    },

    tableKeys() {
      return [
        {
          title: this.trans('economic_reference.indicators'),
          value: 'title',
          flexWidth: '185px',
          flexGrow: 0,
        },
        {
          title: this.trans('economic_reference.wells_count'),
          value: 'uwiCount',
          flexWidth: '100px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.prs_count'),
          value: 'prsCount',
          flexWidth: '100px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.prs_per_well_count'),
          value: 'prsPerUwi',
          flexWidth: '120px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.water_cut'),
          value: 'liquid',
          flexWidth: '135px',
          flexGrow: 1,
        },
        // {
        //   title: this.trans('economic_reference.avg_qn'),
        //   value: 'avgQn',
        //   flexWidth: '100px',
        //   flexGrow: 1,
        // },
        {
          title: this.trans('economic_reference.production'),
          value: 'oil',
          flexWidth: '115px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.revenue'),
          value: 'revenueTotal',
          flexWidth: '120px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.gross_income'),
          value: 'netBack',
          flexWidth: '100px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.costs'),
          value: 'overallExpenditures',
          flexWidth: '120px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.operating_profit'),
          value: 'operatingProfit',
          flexWidth: '120px',
          flexGrow: 1,
        },
      ]
    },

    tableData() {
      let sumKeys = [
        'prs1',
        'oil',
        'liquid',
        // 'day_well_number',
        'Revenue_total',
        'Overall_expenditures',
        'Operating_profit',
        'NetBack_bf_pr_exp',
      ]

      let sumValues = {
        uwiCount: {profitable: 0, profitless: 0}
      }

      sumKeys.forEach(key => {
        sumValues[key] = {profitable: 0, profitless: 0}
      })

      this.sortedUwis.forEach(uwi => {
        let profitability = +this.wells[uwi].Operating_profit.sum > 0
            ? 'profitable'
            : 'profitless'

        sumValues.uwiCount[profitability] += 1

        sumKeys.forEach(key => {
          sumValues[key][profitability] += +this.wells[uwi][key].sum
        })
      })

      return [
        {
          title: ``,
          uwiCount: this.trans('economic_reference.units'),
          prsCount: this.trans('economic_reference.units'),
          prsPerUwi: this.trans('economic_reference.units'),
          liquid: '%',
          oil: this.trans('economic_reference.thousand_tons'),
          revenueTotal: `
            ${this.trans('economic_reference.billion')}
            ${this.trans('economic_reference.tenge')}
          `,
          netBack: `
            ${this.trans('economic_reference.billion')}
            ${this.trans('economic_reference.tenge')}
          `,
          overallExpenditures: `
            ${this.trans('economic_reference.billion')}
            ${this.trans('economic_reference.tenge')}
          `,
          operatingProfit: `
            ${this.trans('economic_reference.billion')}
            ${this.trans('economic_reference.tenge')}
          `,
          color: '#151E70',
        },
        {
          title: this.trans('economic_reference.total_wells_including'),
          uwiCount: sumValues.uwiCount.profitable + sumValues.uwiCount.profitless,
          prsCount: sumValues.prs1.profitable + sumValues.prs1.profitless,
          prsPerUwi: (sumValues.prs1.profitable + sumValues.prs1.profitless) / (sumValues.uwiCount.profitable + sumValues.uwiCount.profitless),
          liquid: this.calcLiquid(
              sumValues.liquid.profitable + sumValues.liquid.profitless,
              sumValues.oil.profitable + sumValues.oil.profitless,
          ),
          oil: (sumValues.oil.profitable + sumValues.oil.profitless) / 1000,
          revenueTotal: (sumValues.Revenue_total.profitable + sumValues.Revenue_total.profitless) / 1000000000,
          netBack: (sumValues.NetBack_bf_pr_exp.profitable + sumValues.NetBack_bf_pr_exp.profitless) / 1000000000,
          overallExpenditures: (sumValues.Overall_expenditures.profitable + sumValues.Overall_expenditures.profitless) / 1000000000,
          operatingProfit: (sumValues.Operating_profit.profitable + sumValues.Operating_profit.profitless) / 1000000000,
        },
        {
          title: this.trans('economic_reference.profitable'),
          uwiCount: sumValues.uwiCount.profitable,
          prsCount: sumValues.prs1.profitable,
          prsPerUwi: sumValues.prs1.profitable / sumValues.uwiCount.profitable,
          liquid: this.calcLiquid(
              sumValues.liquid.profitable,
              sumValues.oil.profitable,
          ),
          oil: sumValues.oil.profitable / 1000,
          revenueTotal: sumValues.Revenue_total.profitable / 1000000000,
          netBack: sumValues.NetBack_bf_pr_exp.profitable / 1000000000,
          overallExpenditures: sumValues.Overall_expenditures.profitable / 1000000000,
          operatingProfit: sumValues.Operating_profit.profitable / 1000000000,
        },
        {
          title: this.trans('economic_reference.profitless'),
          uwiCount: sumValues.uwiCount.profitless,
          prsCount: sumValues.prs1.profitless,
          prsPerUwi: sumValues.prs1.profitless / sumValues.uwiCount.profitless,
          liquid: this.calcLiquid(
              sumValues.liquid.profitless,
              sumValues.oil.profitless,
          ),
          oil: sumValues.oil.profitless / 1000,
          revenueTotal: sumValues.Revenue_total.profitless / 1000000000,
          netBack: sumValues.NetBack_bf_pr_exp.profitless / 1000000000,
          overallExpenditures: sumValues.Overall_expenditures.profitless / 1000000000,
          operatingProfit: sumValues.Operating_profit.profitless / 1000000000,
        },
      ]
    },
  }
}
</script>

<style scoped>
.border-grey {
  border: 1px solid #454D7D
}

.bg-header {
  background: #333975;
}

.line-height-14px {
  line-height: 14px;
}

.line-height-16px {
  line-height: 16px;
}

.line-height-18px {
  line-height: 18px;
}

.font-size-16px {
  font-size: 16px;
}
</style>