<template>
  <apexchart
      :options="options"
      :series="chartSeries"
      :height="745"
      type="bar"/>
</template>

<script>
import {chartInitMixin} from "../mixins/chartMixin";

export default {
  name: 'Chart3',
  mixins: [chartInitMixin],
  computed: {
    chartSeries() {
      return [
        {
          name: this.trans('economic_reference.operating_profit_top_10_lowest'),
          data: this.data.Operating_profit.slice(0, 10)
        },
        {
          name: this.trans('economic_reference.operating_profit_top_10_highest'),
          data: this.data.Operating_profit.slice(10)
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
            foreColor: '#FFFFFF'
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
            categories: this.data.uwi,
          },
          fill: {
            opacity: 1
          },
          tooltip: {
            custom: ({seriesIndex, dataPointIndex}) => this.customTooltip(seriesIndex, dataPointIndex)
          }
        }
      }
    }
  },
  methods: {
    customTooltip(seriesIndex, dataPointIndex) {
      return '<div class="arrow_box">' +
          '<span>' + this.data.uwi[seriesIndex + dataPointIndex * 2] + '</span>' +
          '</div>'
    }
  }
}
</script>
