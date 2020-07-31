<template>
<div id="chart-donut2">
<apexchart type="donut" :options="chartOptions" :series="series"></apexchart>
      </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'

Vue.component('apexchart', VueApexCharts)
export default {
  name: 'mix-chart',
  data: function() {
    return {
	series: [1011, 1006],
          chartOptions: {
		    labels: ['В простое', 'В работе'],
            chart: {
              type: 'donut',
            },
				 dataLabels: {
				 enabled:false},/*убирается подсветка процентов на круге*/
				   /*tooltip: {
      enabled: false},*/
	    legend: {
				 show: false},/*убирается навигация рядом с кругом*/
		colors: ['#47d660', '#ec5464'],		 
				 
			plotOptions: {
			
    pie: {
      expandOnClick: true
			},},
            responsive: [{
              breakpoint: 480,
              options: {
                chart: {
                  width: 200
                },
                legend: {
			
					   
                  position: 'bottom'
                }
              }
            }]
          },
    }
  },
    
}
</script>
