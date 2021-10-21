<template>
  <div>
    <select v-model="wellKey" class="form-control bg-dark-blue text-white">
      <option
          v-for="key in wellKeys"
          :key="key.value"
          :value="key.value">
        {{ key.label }}
      </option>
    </select>

    <apexchart
        :key="wellKey"
        :options="options"
        :series="chartSeries"
        :height="520"/>
  </div>
</template>

<script>
import chart from "vue-apexcharts";
import {chartInitMixin} from "../../mixins/chartMixin";

export default {
  name: 'ChartWithWellTop',
  mixins: [chartInitMixin],
  components: {apexchart: chart},
  props: {
    org_id: {
      required: true,
      type: Number
    }
  },
  data: () => ({
    wellKey: 'Operating_profit'
  }),
  computed: {
    chartSeries() {
      let wellKey = this.wellKeys.find(key => key.value === this.wellKey)

      let dimension = wellKey.dimension || 1

      return [
        {
          name: this.trans('economic_reference.operating_profit_top_10_lowest'),
          data: this.data[this.wellKey].lowest.map(well => +well[wellKey.value] / dimension)
        },
        {
          name: this.trans('economic_reference.operating_profit_top_10_highest'),
          data: this.data[this.wellKey].highest.map(well => +well[wellKey.value] / dimension)
        }
      ];
    },

    options() {
      return {
        ...this.chartOptions, ...{
          plotOptions: {
            bar: {
              horizontal: true,
              barHeight: '30%',
              borderRadius: 7,
              radiusOnLastStackedBar: false
            },
          },
          chart: {
            type: 'bar',
            height: 440,
            stacked: true,
            foreColor: '#FFFFFF',
            events: {
              dataPointSelection: (event, chartContext, config) => this.pointSelection(config)
            }
          },
          colors: ['#AB130E', '#13B062'],
          dataLabels: {
            enabled: false
          },
          stroke: {
            show: true,
            colors: ['transparent']
          },
          xaxis: {
            categories: this.wellUwis
          },
          yaxis: {},
          fill: {
            opacity: 1
          },
          tooltip: {
            custom: ({seriesIndex, dataPointIndex}) => this.customTooltip(seriesIndex, dataPointIndex)
          }
        }
      }
    },

    wellKeys() {
      return [
        {
          value: 'Operating_profit',
          label: this.trans('economic_reference.operating_profit'),
          dimensionTitle: `${this.trans('economic_reference.thousand')} ${this.trans('economic_reference.tenge')}`,
          dimension: 1000,
        },
        {
          value: 'oil',
          label: this.trans('economic_reference.oil_production'),
          dimensionTitle: this.trans('economic_reference.tons')
        },
        {
          value: 'liquid',
          label: this.trans('economic_reference.liquid_production'),
          dimensionTitle: this.trans('economic_reference.tons')
        }
      ]
    },

    wellUwis() {
      let uwis = []

      this.data[this.wellKey].highest.forEach((well, index) => {
        uwis.push(well.uwi, this.data[this.wellKey].lowest[index].uwi)
      })

      return uwis
    },
  },
  methods: {
    customTooltip(seriesIndex, dataPointIndex) {
      let prefix = seriesIndex ? 'highest' : 'lowest'

      let well = this.data[this.wellKey][prefix][dataPointIndex]

      let wellKey = this.wellKeys.find(key => key.value === this.wellKey)

      let value = wellKey.dimension
          ? well[this.wellKey] / wellKey.dimension
          : well[this.wellKey]

      return `<div class="p-2">
                <div> ${well.uwi} </div>
                <div>
                    ${(+(value.toFixed(2))).toLocaleString()}
                    ${wellKey.dimensionTitle}
                </div>
              </div>`
    },

    pointSelection({seriesIndex, dataPointIndex}) {
      let prefix = seriesIndex ? 'highest' : 'lowest'

      let well = this.data[this.wellKey][prefix][dataPointIndex]

      window.open(this.localeUrl(`/economic/nrs/wells/${this.org_id}/${well.uwi}`), '_blank')
    },
  }
}
</script>

<style scoped>
.bg-dark-blue {
  background-color: #333975;
}
</style>
