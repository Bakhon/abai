<template>
  <div>
    <apexchart
        type="area"
        height="450"
        width="1100"
        :options="chartOptions"
        :series="series"
    ></apexchart>
    <div class="begin">{{ begin }}</div>
    <div class="end2">{{ end }}</div>
  </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";
import {EventBus} from "../../event-bus.js";

Vue.component("apexchart", VueApexCharts);

export default {
  name: "mix-chart",
  props: ['postTitles', 'currencyChartData'],
  data: function () {
    return {
      begin: "",
      end: "",
      series: [{
        data: []
      }],
      chartOptions: {
        legend: {
          show: true,
          position: 'top',
          horizontalAlign: 'left',
          fontSize: '14px',
          fontWeight: 400,
          showForSingleSeries: true,
        },
        stroke: {
          curve: 'straight',
          colors: ['#1956e5']
        },
        chart: {
          locales: [{
            "name": "ru",
            "options": {
              "months": ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
              "shortMonths": ["Янв", "Фев", "Мар", "Апр", "Май", "Июнь", "Июль", "Авг", "Сент", "Окт", "Нояб", "Дек"],
              "days": ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
              "shortDays": ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
            }
          }],
          defaultLocale: "ru",
          foreColor: '#ffffff',
          toolbar: {
            show: false,
            autoSelected: "pan",
          },
          id: 'area-datetime',
          type: 'area',
          zoom: {
            autoScaleYaxis: true
          }
        },
        annotations: {
          yaxis: [{
            y: 30,
            label: {
              show: true,
              text: 'Support',
              style: {
                color: "#333333",
                background: '#00E396'
              }
            }
          }],
          xaxis: [{
            x: new Date().getTime(),
            yAxisIndex: 0,
          }]
        },
        dataLabels: {
          enabled: false
        },
        markers: {
          size: 0,
          style: 'hollow',
        },
        xaxis: {
          type: 'datetime',
          min: 1608595200000,
          tickAmount: 6,
          axisBorder: {
            show: true,
            color: '#2f356f',
            height: 2,
            width: '100%',
            offsetX: 0,
            offsetY: 0
          },
          axisTicks: {
            show: true,
            borderType: 'solid',
            color: '#2f356f',
            height: 6,
            offsetX: 0,
            offsetY: 0
          },
          labels: {
            style: {
              fontSize: '14px'
            }
          }
        },
        yaxis: {
          labels: {
            style: {
              fontSize: '14px'
            }
          }
        },
        grid: {
          show: true,
          borderColor: '#2f356f',
          xaxis: {
            lines: {
              show: false
            }
          },
          yaxis: {
            lines: {
              show: true
            }
          },
        },
        fill: {
          type: 'gradient',
          gradient: {
            shadeIntensity: 1,
            opacityFrom: 0,
            opacityTo: 0,
            stops: [0, 100]
          }
        },
      },
    };
  },
  methods: {
    getDate(timestamp) {
      return this.$moment(timestamp).format('dddd, DD MMMM YYYY');
    },
    updateChartOptions(value) {
      let self = this;

      this.chartOptions = {
        ...this.chartOptions, ...{
          xaxis: {
            min: value.for_chart[0][0]
          },
          tooltip: {
            x: {
              format: 'dd MMM yyyy'
            },
            style: {
              fontSize: '14px',
            },
            custom: function({series, seriesIndex, dataPointIndex, w}) {
              // console.log(w.globals.labels);

              return '<div class="vc-chart-tooltip">' +
                  '<div>Покупка</div>' +
                  '<div class="vc-chart-tooltip-value">' + series[seriesIndex][dataPointIndex] + '</div>' +
                  '<div>' + self.getDate(w.globals.labels[dataPointIndex]) + '</div>' +
                  '</div>'
            }
          },
        }
      }

      this.series = [
        {
          name: 'Продажа',
          data: value.for_chart
        }
      ]
    },
  },
  watch: {
    currencyChartData(newVal) {
      this.updateChartOptions(newVal);
    }
  },
};
</script>
