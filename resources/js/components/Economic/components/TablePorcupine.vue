<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      <div>{{ trans('economic_reference.table_porcupine_title') }}</div>
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
          )

          data.push({
            salary_percent: salary_percent,
            retention_percent: retention_percent,
            series: retentionScenarios.map(scenario => {
              return {
                cat_1: scenario.percent_stop_cat_1,
                cat_2: scenario.percent_stop_cat_2,
                oil: scenario.oil.value_optimized[0],
                operating_profit_12m: scenario.operating_profit_12m.value_optimized[0],
              }
            }),
          })
        })
      })

      return data
    },

    chartSeries() {
      return this.filteredData.map(item => {
        return {
          name: `${item.salary_percent.value}, ${item.retention_percent.value}`,
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

    chartLabels() {
      return this.filteredData.map(item => {
        return {
          name: `${item.salary_percent.value}, ${item.retention_percent.value}`,
          data: item.series.map(item => item.oil)
        }
      })
    },

    chartOptions() {
      return {
        labels: [],
        stroke: {
          width: 4,
          curve: 'straight',
          dashArray: [0, 0, 5, 5]
        },
        colors: [
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
        ],
        chart: {
          foreColor: '#FFFFFF',
          locales: [ru],
          defaultLocale: 'ru'
        },
        markers: {
          size: 5
        },
        plotOptions: {
          bar: {
            columnWidth: '70%',
          },
        },
        yaxis: {
          labels: {
            formatter: (val) => val,
          },
          title: {
            text: 'Доход/убыток предприятия, млрд. тг.',
          },
        },
        xaxis: {
          labels: {
            formatter: (val) => (+val).toFixed(2).toLocaleString(),
          },
          title: {
            text: 'Годовая добыча нефти, тыс. тонн',
          },
        },
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