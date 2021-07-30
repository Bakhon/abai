<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      <div>{{ trans('economic_reference.table_economic_efficiency_title') }}</div>
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
          name: 'Валовый доход',
          type: 'line',
          data: this.data.map(x => +x.Revenue_total.original_value)
        },
        {
          name: 'Валовый доход (наилучший)',
          type: 'line',
          data: this.data.map(x => +x.Revenue_total.original_value_optimized)
        },
        {
          name: 'Расходы',
          type: 'line',
          data: this.data.map(x => +x.Overall_expenditures.original_value)
        },
        {
          name: 'Расходы (наилучший)',
          type: 'line',
          data: this.data.map(x => +x.Overall_expenditures.original_value_optimized)
        },
        {
          name: 'Операционная прибыль',
          type: 'bar',
          data: this.data.map(x => +x.operating_profit_12m.original_value)
        },
        {
          name: 'Операционная прибыль (наилучший)',
          type: 'bar',
          data: this.data.map(x => +x.operating_profit_12m.original_value_optimized)
        },
      ]
    },

    chartOptions() {
      return {
        labels: this.oilPrices,
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
          size: 5
        },
        plotOptions: {
          bar: {
            columnWidth: '70%'
          }
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
  }
}
</script>

<style scoped>

</style>