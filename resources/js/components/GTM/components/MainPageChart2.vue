<template>
  <div>
      <apexchart type="line" height="180" :options="chartOptions" :series="series"></apexchart>
  </div>

</template>
<style scoped>
</style>
<script>
import VueApexCharts from "vue-apexcharts";
export default {
  components: {
    "apexchart": VueApexCharts
  },
  data: function() {
    return {
    series: [
      {
        name: this.trans('paegtm.planEd'),
        type: 'column',
        data: [1, 2, 6, 11, 19, 27, 35, 40, 49, 57, 65, 74]
      },
      {
        name: this.trans('paegtm.factEd'),
        type: 'column',
        data: [2, 3, 7, 16, 18, 29, 38, 43, 53, 53, 72, 89]
      },
      {
        name: this.trans('paegtm.planOil'),
        type: 'line',
        data: [20, 30, 40, 55, 67, 75, 87, 98, 110, 120, 145, 155],
      },
      {
        name: this.trans('paegtm.factOil'),
        type: 'line',
        data: [10, 25, 35, 47, 53, 62, 77, 81, 92, 103, 120, 130]
      }
    ],
    chartOptions: {
      grid: {
        show: true,
        borderColor: '#454d7d',
        strokeDashArray: 0,
        position: 'back',
        xaxis: {
          lines: {
            show: true
          }
        },
        yaxis: {
          lines: {
            show: true
          }
        },
        row: {
          colors: undefined,
          opacity: 3
        },
        column: {
          colors: undefined,
          opacity: 3
        },
        padding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 0
        },
      },
      colors: [ '#4f81bd', '#c0504d', '#9bbb59', '#8064a2'],
      chart: {
        background: '#272953',
        type: 'line',
        foreColor: '#fff',
        width: '10%',
      },
      stroke: {
        width: [0, 0, 5, 5]
      },
      title: {
        text: this.trans('paegtm.dynamicChartOil'),
        align: 'center',
        style: {
          fontSize:  '14px',
          fontWeight:  'bolder',
          offsetY: 10
        },
      },
      markers: {
        size: 4,
        colors: undefined,
        strokeWidth: 0
      },
      dataLabels: {
        enabled: true,
        enabledOnSeries: [0, 1],
         background: {
          enabled: true,
          foreColor: '#fff',
          opacity: 0,
          padding: 0,
          dropShadow: {
            enabled: false,
          }
  },
        style: {
          fontSize: '11px',
          fontWeight: 'bold'
        }
      },
      labels: [
        this.trans('paegtm.Jan'), 
        this.trans('paegtm.Feb'), 
        this.trans('paegtm.Mar'), 
        this.trans('paegtm.Apr'), 
        this.trans('paegtm.May'), 
        this.trans('paegtm.Jun'), 
        this.trans('paegtm.Jul'),
        this.trans('paegtm.Aug'), 
        this.trans('paegtm.Sep'), 
        this.trans('paegtm.Oct'), 
        this.trans('paegtm.Nov'), 
        this.trans('paegtm.Dec')
      ],
    },
    }
  } 

}
</script>

<style scoped>

</style>