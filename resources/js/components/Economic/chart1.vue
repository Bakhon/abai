<template>
  <div class="example">
    <apexchart height="350" type="line" :options="chartOptions" :series="series"></apexchart>
  </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'

Vue.component('apexchart', VueApexCharts)
export default {
  name: 'mix-chart',
  data: function() {
    return {
      chartOptions: {
        chart: {
            stacked: true,
            foreColor: '#FFFFFF'
        },
        colors:['#13B062', '#F7BB2E', '#AB130E'],
        stroke: {
          width: 1,
          curve: 'smooth'
        },
        labels: ['01/01/2020', '02/01/2020', '03/01/2020', '04/01/2020', '05/01/2020', '06/01/2020', '07/01/2020', '08/01/2020', '09/01/2020', '10/01/2020', '11/01/2020'],
        markers: {
          size: 0
        },
        xaxis: {
          type: 'datetime'
        },
        yaxis: {
          labels: {
            formatter: function (value) {
                return Math.round(value);
            }
          },
          title: {
            text: 'Количество скважин',
          },
          min: 0
        },
        tooltip: {
          shared: true,
          intersect: false,
          y: {
            formatter: function(y) {
              if (typeof y !== "undefined") {
                return y.toFixed(0) + "";
              }
              return y;
            }
          }
        }
      },
      series: [{
        name: 'Рентабельные скважины',
        type: 'area',
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
      }, {
        name: 'Нерентабельные скважины 2',
        type: 'area',
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
      }, {
        name: 'Нерентабельные скважины',
        type: 'area',
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
      }],
    }
  },
  methods: {
    setValue: function(value) {
        this.series = [
            {
                name: 'Рентабельные скважины',
                data: value.profitable
            }, {
                name: 'Нерентабельные скважины 2',
                data: value.profitless_cat_2
            }, {
            name: 'Нерентабельные скважины',
                data: value.profitless_cat_1
            }
            ];

        this.chartOptions = {
            labels: value.dt
        };
    }
  },
  created: function() {
    this.$parent.$on('chart1', this.setValue);
  }
}
</script>

