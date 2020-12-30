<template>
  <div>
    <apexchart
        type="area"
        height="450px"
        width="100%"
        ref="chart"
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
  props: ['postTitles', 'chartData', 'tableData'],
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
          // height: '450px',
          // width: '100%',
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
            type: 'x',
            enabled: true,
            autoScaleYaxis: true
          }
        },
        annotations: {
          yaxis: [{
            y: 30,
            // label: {
            //   show: false,
            // }
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

      // console.log(value);

      this.chartOptions = {
        ...this.chartOptions, ...{
          xaxis: {
            min: value[0][0]
          },
          tooltip: {
            x: {
              format: 'dd MMM yyyy'
            },
            style: {
              fontSize: '14px',
            },
            custom: function({series, seriesIndex, dataPointIndex, w}) {

              return '<div class="vc-chart-tooltip">' +
                  '<div>Покупка</div>' +
                  '<div class="vc-chart-tooltip-value">' + series[seriesIndex][dataPointIndex] + '</div>' +
                  // '<div>' + self.getDate(w.globals.labels[dataPointIndex]) + '</div>' +
                  '</div>'
            }
          },
        }
      }

      this.series = [
        {
          name: 'Продажа',
          data: value
        }
      ]
    },
    updateZoom() {
      let self = this;

      setTimeout(() => {
        self.$refs.chart.zoomX(
            self.tableData[0].timestamp,
            self.tableData[self.tableData.length - 1].timestamp
        )
      }, 100);
    }
  },
  watch: {
    tableData() {
      this.updateZoom();
    },
    chartData(newVal) {
      this.updateChartOptions(newVal);
    }
  },
};
</script>
