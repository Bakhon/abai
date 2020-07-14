<template>
<div>
  <button  type="button" class="btn btn-info" @click="updateChart('2.0')">Озенмунайгаз</button>
  <button type="button" class="btn btn-info" @click="updateChart('2.000000000004E12')">Мангистаумунайгаз</button>
  <button type="button" class="btn btn-info" @click="updateChart('5.000001017E9')">Каражанбасмунай</button>
  <button type="button" class="btn btn-info" @click="updateChart('3.0')">Эмбамунайгаз</button>
  <button type="button" class="btn btn-info" @click="updateChart('5.00000202E9')">КазГерМунай</button>
  <apexchart width="1000" height="550" type="line" :options="chartOptions" :series="series"></apexchart>
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
        stroke: {
          width: 4,
          curve: 'smooth'
        },
        plotOptions: {
          bar: {
            columnWidth: '50%'
          }
        },
        fill: {
          opacity: [0.85, 0.25, 1],
          gradient: {
            inverseColors: false,
            shade: 'light',
            type: "vertical",
            opacityFrom: 0.85,
            opacityTo: 0.55,
            stops: [0, 100, 100, 100]
          }
        },
        labels: ['01/01/2020', '02/01/2020', '03/01/2020', '04/01/2020', '05/01/2020', '06/01/2020', '07/01/2020', '08/01/2020', '09/01/2020', '10/01/2020', '11/01/2020'],
        markers: {
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
        name: 'Нерентабельные скважины',
        type: 'column',
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
      }, {
        name: 'Рентабельные скважины',
        type: 'column',
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
      }, {
        name: 'Рентабельные скважины 2',
        type: 'column',
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
      }, {
        name: 'Цена нефти',
        type: 'line',
        stroke: {
          width: 5,
          curve: 'smooth'
        },
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
      }],
    }
  },
    methods: {
      updateChart(org) {
         let uri = 'http://172.20.103.32/ru/geteconimicdata?org=' + org + '';
         this.axios.get(uri).then((response) => {
            let data = response.data;
            console.log(data);
            if(data) {
                this.chartOptions = {
                    labels: data.dt
                };
                this.series = [{
                    name: 'Нерентабельные скважины',
                        type: 'column',
                        data: data.profitless_cat_1
                    }, {
                        name: 'Рентабельные скважины',
                        type: 'column',
                        data: data.profitable
                    }, {
                        name: 'Нерентабельные скважины 2',
                        type: 'column',
                        data: data.profitless_cat_2
                    }, {
                        name: 'Цена нефти',
                        type: 'line',
                        stroke: {
                        width: 5,
                        curve: 'smooth'
                        },
                        data: data.price
                }];
            }
            else {
                console.log('No data');
            }
        });
      }
    }
}
</script>
