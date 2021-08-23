<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      {{ trans('economic_reference.table_porcupine_title') }}
    </subtitle>

    <apexchart
        ref="chart"
        :options="chartOptions"
        :series="chartSeries"
        type="line"
        style="color: #000"/>
  </div>
</template>

<script>
import chart from "vue-apexcharts";

import Subtitle from "./Subtitle";

const ru = require("apexcharts/dist/locales/ru.json");

export default {
  name: "TablePorcupine",
  components: {
    Subtitle,
    apexchart: chart,
  },
  props: {
    scenarios: {
      required: true,
      type: Array
    },
    scenario: {
      required: true,
      type: Object
    },
    scenarioVariations: {
      required: true,
      type: Object
    },
  },
  methods: {
    tooltipFormatter(value, index) {
      return `
        ${value} ${this.trans('economic_reference.billion')}. ${this.trans('economic_reference.tenge')}.
        ${this.trans('economic_reference.cat_1_trips')}: ${this.filteredData[0].series[index].cat_1 * 100}%,
        ${this.trans('economic_reference.cat_2_trips')}: ${this.filteredData[0].series[index].cat_2 * 100}%
      `
    },

    dataLabelsFormatter(value, {seriesIndex, dataPointIndex}) {
      return this.filteredData[seriesIndex].series[dataPointIndex].uwi_count
    }
  },
  computed: {
    filteredScenarios() {
      return this.scenarios.filter(scenario =>
          scenario.dollar_rate === this.scenario.dollar_rate &&
          scenario.oil_price === this.scenario.oil_price
      )
    },

    filteredData() {
      let data = []

      this.scenarioVariations.salary_percents.forEach(salary_percent => {
        let salaryScenarios = this.filteredScenarios.filter(scenario =>
            scenario.coef_cost_WR_payroll === salary_percent.value
        )

        this.scenarioVariations.retention_percents.forEach(retention_percent => {
          let retentionScenarios = salaryScenarios.filter(scenario =>
              scenario.coef_Fixed_nopayroll === retention_percent.value
          ).reverse()

          let series = []

          let seriesGtm = []

          retentionScenarios.forEach(scenario => {
            let operating_profit_12m = +scenario.operating_profit_12m.original_value_optimized

            let dimension = 1000000000

            series.push({
              uwi_count: scenario.uwi_count_optimize,
              cat_1: scenario.percent_stop_cat_1,
              cat_2: scenario.percent_stop_cat_2,
              oil: scenario.oil.original_value_optimized,
              operating_profit_12m: (operating_profit_12m / dimension).toFixed(2),
            })

            seriesGtm.push({
              uwi_count: scenario.uwi_count_optimize,
              cat_1: scenario.percent_stop_cat_1,
              cat_2: scenario.percent_stop_cat_2,
              oil: scenario.oil.original_value_optimized + scenario.gtm_oil,
              operating_profit_12m: ((operating_profit_12m + (+scenario.gtm_operating_profit_12m)) / dimension).toFixed(2),
            })
          })

          data.push(
              {
                salary_percent: salary_percent,
                retention_percent: retention_percent,
                series: series
              },
              {
                salary_percent: salary_percent,
                retention_percent: retention_percent,
                series: seriesGtm,
                is_gtm: true
              },
          )
        })
      })

      return data
    },

    chartSeries() {
      return this.filteredData.map(item => {
        const prefix = item.is_gtm ? 'GTM:' : ''

        return {
          name: `${prefix}${item.salary_percent.value}, ${item.retention_percent.value}`,
          type: 'line',
          data: item.series.map(item => {
            return {
              y: item.operating_profit_12m,
              x: item.oil
            }
          })
        }
      })
    },

    chartColors() {
      const colors = [
        '#34558C',
        '#9C7300',
        '#666666',
        '#A3480E',
        '#374AB4',
        '#79B44E',
        '#82BAFF',
        '#FFC607',
        '#A9A9A9',
        '#F37F31',
        '#436DB0',
        '#81B9FE',
        '#374AB4',
        '#436B2A',
      ]

      let result = []

      colors.forEach(color => {
        result.push(color)

        result.push(color)
      })

      return result
    },

    chartOptions() {
      return {
        stroke: {
          width: 4,
          curve: 'straight',
          dashArray: this.chartSeries.map((item, index) => index % 2 === 0 ? 0 : 5)
        },
        chart: {
          foreColor: '#FFFFFF',
          locales: [ru],
          defaultLocale: 'ru'
        },
        markers: {
          size: 5,
          strokeOpacity: 0.1,
          discrete: this.chartSeries.map((series, seriesIndex) => {
            return {
              seriesIndex: seriesIndex,
              dataPointIndex: series.data.reduce(
                  (bestIndex, value, currentIndex, data) => +value.y > +data[bestIndex].y
                      ? currentIndex
                      : bestIndex
                  , 0
              ),
              fillColor: '#fff',
              strokeColor: '#fff',
              size: 10,
              shape: "circle"
            }
          })
        },
        yaxis: {
          title: {
            text: `
            ${this.trans('economic_reference.enterprise_income_loss')},
            ${this.trans('economic_reference.billion')}.
            ${this.trans('economic_reference.tenge')}.
            `,
          },
        },
        xaxis: {
          labels: {
            formatter: (val) => (+val / 1000).toFixed(0),
          },
          title: {
            text: `
            ${this.trans('economic_reference.annual_oil_production')},
            ${this.trans('economic_reference.thousand_tons')}
            `,
          },
        },
        tooltip: {
          shared: true,
          intersect: false,
          y: {
            formatter: (value, {dataPointIndex}) => this.tooltipFormatter(value, dataPointIndex)
          }
        },
        dataLabels: {
          enabled: true,
          enabledOnSeries: [0],
          offsetY: -7,
          offsetX: 5,
          formatter: (value, params) => this.dataLabelsFormatter(value, params),
          background: {
            enabled: false
          },
          style: {
            colors: ['#fff']
          },
        },
        colors: this.chartColors
      }
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
</style>