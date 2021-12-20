<template>
  <div>
    <subtitle font-size="16" style="line-height: 18px">
      {{ trans('economic_reference.table_porcupine_title') }}
    </subtitle>

    <div class="mt-2 percent-block">
      <select
          v-model="selectedVariations"
          :title="trans('economic_reference.select_params')"
          data-style="text-white bg-main1 border-white"
          data-size="5"
          class="percent-variations"
          multiple>
        <option :value="null" disabled selected>
          {{ trans('economic_reference.select_item') }}
        </option>

        <option
            v-for="(percentVariation, percentIndex) in percentVariations"
            :key="percentIndex"
            :value="percentIndex">
          {{ trans('economic_reference.fot_optimization') }}:
          {{ percentVariation.salaryPercent.label }},
          {{ trans('economic_reference.non_optimizable_costs_share') }}:
          {{ percentVariation.retentionPercent.label }}
        </option>
      </select>
    </div>

    <apexchart
        ref="chart"
        :options="chartOptions"
        :series="chartSeries"
        :height="475"
        style="color: #000"/>
  </div>
</template>

<script>
import chart from "vue-apexcharts";

import Subtitle from "../../components/Subtitle";

const ru = require("apexcharts/dist/locales/ru.json");

const COLORS = [
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
  data: () => ({
    selectedVariations: [0],
  }),
  mounted() {
    $('.percent-variations').selectpicker()
  },
  methods: {
    tooltipFormatter(value, index) {
      return `
        ${value} ${this.trans('economic_reference.billion')} ${this.trans('economic_reference.tenge')}.
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
      let scenarios = []

      this.scenarios.forEach(scenario => {
        if (+scenario.oil_price !== +this.scenario.oil_price) return

        if (+scenario.dollar_rate !== +this.scenario.dollar_rate) return

        scenarios.push(...scenario.variants)
      })

      return scenarios
    },

    filteredData() {
      let data = []

      this.selectedVariations.forEach(variation => {
        let salaryPercent = this.percentVariations[variation].salaryPercent

        let retentionPercent = this.percentVariations[variation].retentionPercent

        let scenarios = this.filteredScenarios.filter(scenario =>
            +scenario.coef_cost_WR_payroll === +salaryPercent.value &&
            +scenario.coef_Fixed_nopayroll === +retentionPercent.value
        )

        let series = []

        let seriesGtm = []

        scenarios.forEach(scenario => {
          let operatingProfit = +scenario.Operating_profit_optimize

          let dimension = 1000000000

          series.push({
            uwi_count: scenario.uwi_count_optimize,
            cat_1: scenario.percent_stop_cat_1,
            cat_2: scenario.percent_stop_cat_2,
            oil: +scenario.oil_optimize,
            operating_profit: (operatingProfit / dimension).toFixed(2),
          })

          if (scenario.gtms) {
            seriesGtm.push({
              uwi_count: scenario.uwi_count_optimize,
              cat_1: scenario.percent_stop_cat_1,
              cat_2: scenario.percent_stop_cat_2,
              oil: +scenario.oil_optimize + +scenario.gtm_oil,
              operating_profit: ((operatingProfit + +scenario.gtm_operating_profit) / dimension).toFixed(2),
            })
          }
        })

        data.push({
          salary_percent: salaryPercent,
          retention_percent: retentionPercent,
          series: series
        })

        if (seriesGtm.length) {
          data.push({
            salary_percent: salaryPercent,
            retention_percent: retentionPercent,
            series: seriesGtm,
            is_gtm: true
          })
        }
      })

      return data
    },

    chartSeries() {
      return this.filteredData.map(item => ({
        name: `
          ${this.trans('economic_reference.fot_optimization')} - ${+item.salary_percent.value * 100}%,
          ${this.trans('economic_reference.non_optimizable_costs_share')} - ${+item.retention_percent.value * 100}%
          ${item.is_gtm ? this.trans('economic_reference.with_gtm') : this.trans('economic_reference.without_gtm')}
          `,
        type: 'line',
        data: item.series.map(item => ({
          y: item.operating_profit,
          x: item.oil
        }))
      }))
    },

    chartColors() {
      let result = []

      COLORS.forEach(color => result.push(color, color))

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
          discrete: this.chartSeries.map((series, seriesIndex) => ({
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
          }))
        },
        yaxis: {
          title: {
            text: `
            ${this.trans('economic_reference.enterprise_income_loss')},
            ${this.trans('economic_reference.billion')}
            ${this.trans('economic_reference.tenge')}.
            `,
          },
          labels: {
            formatter: (value) => (+value.toFixed(0)).toLocaleString()
          },
        },
        xaxis: {
          type: 'numeric',
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
        colors: this.chartColors,
        legend: {
          height: 50
        }
      }
    },

    percentVariations() {
      let variations = []

      this.scenarioVariations.salary_percents.forEach(salaryPercent => {
        this.scenarioVariations.retention_percents.forEach(retentionPercent => {
          variations.push({
            salaryPercent: salaryPercent,
            retentionPercent: retentionPercent,
          })
        })
      })

      return variations
    },
  }
}
</script>

<style scoped>
.percent-block >>> .percent-variations {
  width: 460px !important;
}
</style>