<template>
<div>
  <apexchart type="bar" height="480"  style="margin-top:0px;" :options="chartOptions" :series="series"></apexchart>
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
               enabled: true,
          enabledOnSeries: undefined,
          shared: true,
          followCursor: false,
          intersect: false,
          inverseOrder: false,
          custom: undefined,
          fillSeriesColor: false,
          theme: false,
         // theme: 'dark',
         /// shared: false,
         // intersect: false,
          y: {
            formatter: function(y) {
              if (typeof y !== "undefined") {
                return new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(y.toFixed(0)) + "";
              }
              return y;
            }
          }
        },
		colors:['#4A90E2','#0080FF','#F5FCFF'],
        chart: {
          toolbar: {
            show: false,
             Color: '#373d3f',

          },
           foreColor: "#FFFFFF",
			/*animations: {
            speed: 200
          },*/
            //  type: 'area'
        },

        plotOptions: {
          bar: {
			  dataLabels: {
                  position: 'top',
                },
            columnWidth: '15%'
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
		'5','15','25','25','25','25',
		],
      legend: {
        show:false,
          position: "bottom",
          horizontalAlign: "right",
        },

      		  yaxis: {
              axisBorder: {
                show: true
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
         name: 'Фактическая закачка ингибитора коррозии',
        stroke: {
			show:false
               },
        data: [10,20,30,40,50,60]
      }],
    }
  },
  methods: {
  /*  setValue: function(value) {
        this.series = [
            {
                name: 'Фактическая закачка ингибитора коррозии',
               // data: value.value
               data:  [20,30,40]
            }
            ];

        this.chartOptions = {
        //  ['20','30','40'] /// labels: value.dt
        };
    }*/
  },
  created: function() {
   // this.$parent.$on('chart3', this.setValue);
   // this.setValue;
  }
}
</script>
