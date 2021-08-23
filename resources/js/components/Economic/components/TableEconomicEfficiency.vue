<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      {{ trans('economic_reference.table_economic_efficiency_title') }}
    </subtitle>

    <apexchart
        ref="chart"
        :options="chartOptions"
        :series="chartSeries"
        type="line"
        class="apexcharts-custom-legend"
        style="color: #000"/>
  </div>
</template>

<script>
import chart from "vue-apexcharts";

import Subtitle from "./Subtitle";

const ru = require("apexcharts/dist/locales/ru.json");

export default {
  name: "TableEconomicEfficiency",
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
    oilPrices: {
      required: true,
      type: Array
    },
  },
  computed: {
    data() {
      return this.oilPrices.map(oilPrice =>
          this.scenarios
              .filter(
                  scenario => scenario.oil_price === oilPrice &&
                      scenario.dollar_rate === this.scenario.dollar_rate &&
                      scenario.coef_cost_WR_payroll === this.scenario.coef_cost_WR_payroll &&
                      scenario.coef_Fixed_nopayroll === this.scenario.coef_Fixed_nopayroll
              )
              .reduce((prev, current) => (+prev.operating_profit_12m_optimize > +current.operating_profit_12m_optimize) ? prev : current)
      )
    },

    chartSeries() {
      return [
        {
          name: `${this.trans('economic_reference.gross_income')} ${this.trans('economic_reference.before_optimization')}`,
          type: 'line',
          data: this.chartData.map(x => x ? +x.Revenue_total.original_value : null)
        },
        {
          name: `${this.trans('economic_reference.gross_income')} ${this.trans('economic_reference.after_optimization')}`,
          type: 'line',
          data: this.chartData.map(x => x ? +x.Revenue_total.original_value_optimized : null)
        },
        {
          name: `${this.trans('economic_reference.costs')} ${this.trans('economic_reference.before_optimization')}`,
          type: 'line',
          data: this.chartData.map(x => x ? +x.Overall_expenditures.original_value : null)
        },
        {
          name: `${this.trans('economic_reference.costs')} ${this.trans('economic_reference.after_optimization')}`,
          type: 'line',
          data: this.chartData.map(x => x ? +x.Overall_expenditures.original_value_optimized : null)
        },
        {
          name: `${this.trans('economic_reference.operating_profit_loss')} ${this.trans('economic_reference.before_optimization')}`,
          type: 'bar',
          data: this.chartData.map(x => x ? +x.operating_profit_12m.original_value : null)
        },
        {
          name: `${this.trans('economic_reference.operating_profit_loss')} ${this.trans('economic_reference.after_optimization')}`,
          type: 'bar',
          data: this.chartData.map(x => x ? +x.operating_profit_12m.original_value_optimized : null)
        },
      ]
    },

    chartOptions() {
      return {
        labels: this.chartLabels,
        stroke: {
          width: 4,
          curve: 'straight',
          dashArray: [0, 0, 5, 5]
        },
        colors: ['#F27E31', '#82BAFF', '#F27E31', '#82BAFF', '#C4C4C4', '#147050'],
        chart: {
          foreColor: '#FFFFFF',
          locales: [ru],
          defaultLocale: 'ru'
        },
        markers: {
          size: 7,
          strokeOpacity: 0.1,
        },
        plotOptions: {
          bar: {
            columnWidth: '70%',
          },
        },
        dataLabels: {
          enabled: true,
          enabledOnSeries: [4, 5],
          formatter(val) {
            return val === null ? '' : (+val / 1000000000).toFixed(2);
          },
          background: {
            enabled: false
          },
          style: {
            colors: ['#fff']
          },
        },
        yaxis: {
          labels: {
            formatter(val) {
              return (+val / 1000000000).toFixed(2);
            }
          },
          title: {
            text: `${this.trans('economic_reference.billion')} ${this.trans('economic_reference.tenge')}`,
          },
        },
      }
    },

    chartLabels() {
      return [
        ...[Math.floor(+this.oilPrices[0] / 1.5)],
        ...this.oilPrices.map(oilPrice => (+oilPrice).toLocaleString()),
        ...[Math.ceil(+this.oilPrices[this.oilPrices.length - 1] * 1.5)]
      ]
    },

    chartData() {
      let data = this.data

      data.unshift(null)

      data.push(null)

      return data
    },
  }
}
</script>

<style scoped>
.apexcharts-custom-legend >>> .apexcharts-legend-marker {
  margin-right: 20px;
}

.apexcharts-custom-legend >>> .apexcharts-legend-series::before {
  content: "";
  width: 40px;
  margin-right: -26px;
}

.apexcharts-custom-legend >>> .apexcharts-legend-series[rel='1']::before {
  border: 2px solid #F27E31;
}

.apexcharts-custom-legend >>> .apexcharts-legend-series[rel='2']::before {
  border: 2px solid #82BAFF;
}

.apexcharts-custom-legend >>> .apexcharts-legend-series[rel='3']::before {
  border: 2px dotted #F27E31;
}

.apexcharts-custom-legend >>> .apexcharts-legend-series[rel='4']::before {
  border: 2px dotted #82BAFF;
}

.apexcharts-custom-legend >>> .apexcharts-legend-series[rel='5']::before {
  border: 6px solid #C4C4C4;
}

.apexcharts-custom-legend >>> .apexcharts-legend-series[rel='6']::before {
  border: 6px solid #147050;
}
</style>