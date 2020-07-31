<template>
<div>
  <apexchart type="bar" height="200" width="320" :options="chartOptions" :series="series"></apexchart>
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
		  tooltip: {
              theme: 'dark',
              x: {
                show: false
              },
              y: {
                title: {
					 show: false,
                  formatter: function () {
                    return ''
                  }
                }
              }
            },
          
		  colors:['#115ED9','#47D660'],
        chart: {
			animations: {
            speed: 200
          },
			  height: 150,
              type: 'bar'
        },
   
        plotOptions: {
          bar: {
			  dataLabels: {
                  position: 'top', // top, center, bottom
                },
            columnWidth: '50%'
          }
        },
		     
		dataLabels: {
              enabled: false,/*вывод значений из раздела data*/
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
		'2018',
		'2019',
		'2020'	
		],
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
             /* categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"], вывод сверху списка месяцев*/
              position: 'top',
              axisBorder: {
                show: false
              },
              axisTicks: {
                show: false
              },

             
            },
        },
      series: [{
        name: 'План',
        type: 'bar',
        stroke: {
			show:false
               },
        data: [11, 32, 45]
      }, 
	  
	  {
        name: 'Факт',
        type: 'bar',
        stroke: {
			show:false
               },
        data: [22, 42, 49]
      }, 
	  
	 
	 
	 ],
    }
  },
    
}
</script>
