<template>
<div>
  <apexchart type="area" height="350" width="1290" :options="chartOptions" :series="series"></apexchart>
</div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'

Vue.component('apexchart', VueApexCharts)
export default {
  name: 'mix-chart',
  props: 
  ['postTitle'],

  data: function() {
    return {
      chartOptions: {
        chart: {
            /*stacked: true,*/
            foreColor: '#FFFFFF',
			  height: 250,
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
        /*fill: {
          opacity: [0.85, 0.25, 1],
          gradient: {
            inverseColors: false,
            shade: 'light',
            type: "area",
            opacityFrom: 0.85,
            opacityTo: 0.55,
            stops: [0, 100, 100, 100]
          }
        },*/
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
        /*markers: {
          size: 0
        },
        xaxis: {
          type: 'datetime'
        },
        yaxis: {
          title: {
            text: 'Количество',
          },
          min: 0
        },*/
       /* tooltip: {
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
        }*/
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
         {
        name: 'Факт',
        type: 'area',
        stroke: {
         /* width: 5,*/
          curve: 'smooth'
        },
        data: [11, 32, 45, 32, 34, 52, 41]
      }, ],
    }
  },

  /*created: function () {
    // `this` указывает на экземпляр vm
   console.log(this.postTitle);
  }*/


  mounted () {
    // показывает данные после отрисовки компонента в консоли
   // console.log(this.postTitle)
    console.log(localStorage.getItem("production-fact"));
  },

 /* updated: function () {
  this.$nextTick(function () {
    // Код, который будет запущен только после
    // обновления всех представлений
    console.log(this.postTitle);
  })
}*/
    
}
</script>
