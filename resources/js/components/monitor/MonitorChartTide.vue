<template>
<div>
  <apexchart type="area" height="180"  :options="chartOptions" :series="series"></apexchart>
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
              toolbar: {         
            show: false,},
            /*stacked: true,*/
            foreColor: '#FFFFFF',
			  height: 350,
              type: 'area'
        },
        stroke: {
          /*width: 4,*/
          curve: 'smooth'
        },
        plotOptions: {
          bar: {
            columnWidth: '50%'
          }
        },

		 dataLabels: {
          enabled: false
        },
        labels: [
		'1',
		'2',
		'3',
		'4',
		'5',
		'6',
		'7',
		'8',
		'9',
		'10'		
		],

      },
      series: [{
        name: 'План',
         type: 'area',
        stroke: {
           /* width: 5,*/
          curve: 'smooth'
        },
        data: [31, 40, 28, 51, 42, 109, 100]
      }, 
          ],
    }
  },
    
}
</script>
