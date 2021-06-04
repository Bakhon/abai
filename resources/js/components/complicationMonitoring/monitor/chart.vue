<template>
  <div>
    <apexchart
        type="bar"
        height="166"
        style="margin-top:0px;"
        :options="chartOptions"
        :series="series"
    />
  </div>
</template>


<script>
var ru = require("apexcharts/dist/locales/ru.json");
import VueApexCharts from 'vue-apexcharts'

Vue.component('apexchart', VueApexCharts)
export default {
  name: 'mix-chart',
  props: {
    title: {
      type: String,
      required: true,
    },
    data: {
      data: Object,
      required: true,
    },
    measurement: {
      data: String,
      default: '',
    },

  },
  data: function () {
    return {
      chartOptions: {
        tooltip: {
          theme: 'dark',
          shared: true,
          intersect: false,
          y: {
            formatter: (y) => {
              if (typeof y !== "undefined") {
                return y + ' ' + this.measurement;
              }
              return y;
            },
            title: {
              formatter: (seriesName) => {
                return '';
              },
            },
          }
        },
        fill: {
          colors: ['#0080ff'],
          opacity: 1
        },
        chart: {
          stacked: true,
          locales: [ru],
          defaultLocale: 'ru',
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
            columnWidth: '85%'
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
          show: false,
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
          },
        },
        xaxis: {
          position: 'bottom',
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          labels: {
            style: {
              fontSize: '7px'
            }
          }
        },
        grid: {
          borderColor: '#454d7d',
        }
      },
      series: [{
        type: 'bar',
        stroke: {
          show: false
        },
        data: [0, 0, 0, 0, 0, 0, 0]
      }],
    }
  },
  watch: {
    data(value) {
      this.setValue(value)
    }
  },
  methods: {
    setValue: function (value) {
      this.series = [
        {
          name: this.title,
          data: value.value
        }
      ];

      this.chartOptions = {
        labels: value.dt
      };
    }
  },
}
</script>
