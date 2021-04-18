<template>
  <apexchart
      :options="options"
      :series="chartSeries"
      height="350"
      type="bar"/>
</template>

<script>
import {chartInitMixin} from "../mixins/chartMixin";

export default {
  name: 'EconomicChart3',
  mixins: [chartInitMixin],
  data: () => ({
    chartOptions: {
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
        categories: ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
      },
      // yaxis: {
      //   title: {
      //     text: 'Скважины'
      //   }
      // },
      fill: {
        opacity: 1
      },
      // tooltip: {
      //   y: {
      //     formatter: function(val) {
      //       return new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(val) + " тыс. тенге"
      //     }
      //   }
      // }
    },
  }),
  computed: {
    chartSeries() {
      return [
        {
          name: 'Топ 10 нерентабельных скважин',
          data: [
            this.data.Operating_profit[0],
            this.data.Operating_profit[1],
            this.data.Operating_profit[2],
            this.data.Operating_profit[3],
            this.data.Operating_profit[4],
            this.data.Operating_profit[5],
            this.data.Operating_profit[6],
            this.data.Operating_profit[7],
            this.data.Operating_profit[8],
            this.data.Operating_profit[9],
          ]
        },
        {
          name: 'Топ 10 рентабельных скважин',
          data: [
            this.data.Operating_profit[10],
            this.data.Operating_profit[11],
            this.data.Operating_profit[12],
            this.data.Operating_profit[13],
            this.data.Operating_profit[14],
            this.data.Operating_profit[15],
            this.data.Operating_profit[16],
            this.data.Operating_profit[17],
            this.data.Operating_profit[18],
            this.data.Operating_profit[19],
          ]
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
        }
      }
    }
  },
}
</script>
