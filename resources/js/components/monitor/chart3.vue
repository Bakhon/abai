<template>
<div>
  <apexchart type="bar" height="180" style="margin-top:0px;" :options="chartOptions" :series="series"></apexchart>
</div>
</template>



<script>
var ru = require("apexcharts/dist/locales/ru.json");
import VueApexCharts from 'vue-apexcharts'

Vue.component('apexchart', VueApexCharts)
export default {
  name: 'mix-chart',
  data: function() {
    return {
      chartOptions: {
        chart: {
            stacked: true,
            foreColor: '#FFFFFF',
            locales: [ru],
            defaultLocale: 'ru'
        },
        tooltip: {
          theme: 'dark',
          shared: true,
          intersect: false,
          y: {
            formatter: function(y) {
              if (typeof y !== "undefined") {
                return new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(y.toFixed(0)) + "";
              }
              return y;
            }
          }
        },
		colors:['#00B8FF','#0080FF','#F5FCFF'],
        chart: {
          toolbar: {
            show: false,
             Color: '#373d3f',

          },
           foreColor: "#FFFFFF",
			animations: {
            speed: 200
          },
              type: 'area'
        },

        plotOptions: {
          bar: {
			  dataLabels: {
                  position: 'top',
                },
            columnWidth: '100%'
          }
        },

		dataLabels: {
              enabled: false,
              formatter: function (val) {
                return val  /*+"%"*/;
              },
              offsetY: -20,
              style: {
                fontSize: '12px',
                colors: ["#c5c5c5"]
              }
            },
        labels: [
		'0',
		],
      legend: {
        show:false,
          position: "bottom",
          horizontalAlign: "right",
        },

      		  yaxis: {
              axisBorder: {
                show: false
              },
              axisTicks: {
                show: false,
              },
              labels: {
                show: false,
                formatter: function (val) {
                  return val /*+ "%"*/;
                }
		  },},
       xaxis: {
              position: 'bottom',
              axisBorder: {
                show: false
              },
              axisTicks: {
                show: false
              },


            },
        },
      series: [{
        type: 'bar',
        stroke: {
			show:false
               },
        data: [0,0,0,0,0,0,0]
      }],
    }
  },
  methods: {
    setValue: function(value) {
        this.series = [
            {
                name: 'Фактическая скорость коррозии',
                data: value.value
            }
            ];

        this.chartOptions = {
            labels: value.dt
        };
    }
  },
  created: function() {
    this.$parent.$on('chart3', this.setValue);
  }
}
</script>
