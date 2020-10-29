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
	series: [			1,
						2,
						3,
						7,
						5,
						6,
						4],
          chartOptions: {
		    labels: 
['ТОО «Казахтуркмунай»',
'ТОО «Казахойл Актобе»',
'АО «ЭмбаМунайГаз»',
'ТОО «КазГерМунай»',
'АО «Мангистаумунайгаз»',
'АО «ОзенМунайГаз»',
'АО «Каражанбасмунай»'],
            chart: {
              type: 'donut',
            },
				 dataLabels: {
				 enabled:false},/*убирается подсветка процентов на круге*/
				   /*tooltip: {
      enabled: false},*/
	    legend: {
				 show: false},/*убирается навигация рядом с кругом*/
		colors: ['#FF9769',
              '#F7BB2E',
              '#00A0E3',
              '#A3A0FB',
              '#E06765',
              '#3B86FF',
              '#13B062'],		 
				 
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
