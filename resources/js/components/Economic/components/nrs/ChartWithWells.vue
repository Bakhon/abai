<template>
  <div>
    <apexchart
        :options="chartOptions"
        :series="chartSeries"
        :height="285"/>

    <div class="mt-2 text-white">
      <div class="text-center border-grey d-flex bg-header">
        <div v-for="(item, index) in tableKeys"
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
      if (this.form.org_id === 2) return

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

    getProfitability(well) {
      if (+well.Operating_profit_variable_prs.sum <= 0) {
        return 'profitless_cat_1'
      }

      return +well.Operating_profit.sum > 0
          ? 'profitable'
          : 'profitless_cat_2'
    },

    calcLiquid(liquid, oil) {
      return +liquid === 0
          ? 0
          : 100 * (+liquid - +oil) / +liquid
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

      return Object.keys(this.wells).sort((prev, next) =>
          +this.wells[prev].Operating_profit.sum - +this.wells[next].Operating_profit.sum
      )
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
            dimensionTitle: this.trans('economic_reference.tons'),
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
          dimensionTitle: this.trans('economic_reference.units'),
          value: 'uwiCount',
          flexWidth: '100px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.prs_count'),
          dimensionTitle: this.trans('economic_reference.units'),
          value: 'prsCount',
          flexWidth: '100px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.prs_per_well_count'),
          dimensionTitle: this.trans('economic_reference.units'),
          value: 'prsPerUwi',
          flexWidth: '120px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.water_cut'),
          dimensionTitle: '%',
          value: 'liquid',
          flexWidth: '135px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.production'),
          dimensionTitle: this.trans('economic_reference.thousand_tons'),
          dimension: 1000,
          value: 'oil',
          flexWidth: '115px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.revenue'),
          dimensionTitle: `
            ${this.trans('economic_reference.billion')}
            ${this.trans('economic_reference.tenge')}
          `,
          value: 'revenueTotal',
          flexWidth: '120px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.gross_income'),
          dimensionTitle: `
            ${this.trans('economic_reference.billion')}
            ${this.trans('economic_reference.tenge')}
          `,
          value: 'netBack',
          flexWidth: '100px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.costs'),
          dimensionTitle: `
            ${this.trans('economic_reference.billion')}
            ${this.trans('economic_reference.tenge')}
          `,
          value: 'overallExpenditures',
          flexWidth: '120px',
          flexGrow: 1,
        },
        {
          title: this.trans('economic_reference.operating_profit'),
          dimensionTitle: `
            ${this.trans('economic_reference.billion')}
            ${this.trans('economic_reference.tenge')}
          `,
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
        'Revenue_total',
        'Overall_expenditures',
        'Operating_profit',
        'NetBack_bf_pr_exp',
      ]

      let sumValues = {uwiCount: {}}

      this.profitabilityTypes.forEach(type => {
        sumValues.uwiCount[type.key] = 0
      })

      sumKeys.forEach(key => {
        sumValues[key] = {...sumValues.uwiCount}
      })

      this.sortedUwis.forEach(uwi => {
        let profitability = this.getProfitability(this.wells[uwi])

        let isProfitless = ['profitless_cat_1', 'profitless_cat_2'].includes(profitability)

        sumValues.uwiCount[profitability] += 1

        sumValues.uwiCount.total += 1

        if (isProfitless) {
          sumValues.uwiCount.profitless += 1
        }

        sumKeys.forEach(key => {
          sumValues[key][profitability] += +this.wells[uwi][key].sum

          sumValues[key].total += +this.wells[uwi][key].sum

          if (isProfitless) {
            sumValues[key].profitless += +this.wells[uwi][key].sum
          }
        })
      })

      let titles = {color: '#151E70'}

      this.tableKeys.forEach(key => {
        titles[key.value] = key.dimensionTitle || ''
      })

      let rows = [titles]

      this.profitabilityTypes.forEach(profitability => {
        rows.push({
          title: profitability.title,
          uwiCount: sumValues.uwiCount[profitability.key],
          prsCount: sumValues.prs1[profitability.key],
          prsPerUwi: sumValues.uwiCount[profitability.key]
              ? sumValues.prs1[profitability.key] / sumValues.uwiCount[profitability.key]
              : 0,
          liquid: this.calcLiquid(
              sumValues.liquid[profitability.key],
              sumValues.oil[profitability.key]
          ),
          oil: sumValues.oil[profitability.key] / 1000,
          revenueTotal: sumValues.Revenue_total[profitability.key] / 1000000000,
          netBack: sumValues.NetBack_bf_pr_exp[profitability.key] / 1000000000,
          overallExpenditures: sumValues.Overall_expenditures[profitability.key] / 1000000000,
          operatingProfit: sumValues.Operating_profit[profitability.key] / 1000000000,
          color: profitability.color,
          style: profitability.style
        })
      })

      return rows
    },

    profitabilityTypes() {
      return [
        {
          key: 'total',
          title: this.trans('economic_reference.total_wells_including')
        },
        {
          key: 'profitable',
          title: this.trans('economic_reference.profitable')
        },
        {
          key: 'profitless',
          title: this.trans('economic_reference.profitless_all')
        },
        {
          key: 'profitless_cat_1',
          title: this.trans('economic_reference.profitless_cat_1'),
          color: '#313560',
          style: 'padding-left: 30px !important;',
        },
        {
          key: 'profitless_cat_2',
          title: this.trans('economic_reference.profitless_cat_2'),
          color: '#313560',
          style: 'padding-left: 30px !important;',
        },
      ]
    }
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
</style>