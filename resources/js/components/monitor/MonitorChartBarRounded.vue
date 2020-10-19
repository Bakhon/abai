<template>
<div>
  <apexchart type="bar" height="180" style="margin-top:0px;" :options="chartOptions" :series="series"></apexchart>
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
          
		  colors:['#00B8FF','#0080FF','#F5FCFF'],
        chart: {
          toolbar: {         
            show: false,
             Color: '#373d3f',
            //autoSelected: "pan",
            
          },
           foreColor: "#FFFFFF",
			animations: {
            speed: 200
          },
			//  height: 150,
              type: 'area'
        },
   
        plotOptions: {
          bar: {
            
              
              //  endingShape: 'rounded'  ,
			  dataLabels: {
                  position: 'top', // top, center, bottom
                },
            columnWidth: '100%'
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
             /* categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"], вывод сверху списка месяцев*/
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
        name: 'План',
        type: 'bar',
        stroke: {
			show:false
               },
        data: [1,0,1,0,2,0,4]
      }, 
	  
	 


      	 
      
	  
	 
	 
	 ],
    }
  },
    
}
</script>
