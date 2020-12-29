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
        stroke: {
          curve: 'straight',
          colors: ['#1956e5']
        },
        chart: {
          // locales: 'ru',
          foreColor: '#ffffff',
          toolbar: {
            show: false,
            autoSelected: "pan",
          },
          id: 'area-datetime',
          type: 'area',
          // height: 400,
          zoom: {
            autoScaleYaxis: true
          }
        },
        annotations: {
          yaxis: [{
            y: 30,
            borderColor: '#999',
            label: {
              show: true,
              text: 'Support',
              style: {
                color: "#fff",
                background: '#00E396'
              }
            }
          }],
          xaxis: [{
            x: new Date().getTime(),
            borderColor: '#e30b0b',
            yAxisIndex: 0,
            axisBorder: {
              show: true,
              color: '#36d90e',
            },
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
        },
        tooltip: {
          x: {
            format: 'dd MMM yyyy'
          }
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
      // chartOptions: {
      //   xaxis: {
      //     labels: {
      //       show: false,
      //     },
      //   },
      //   yaxis: {
      //     labels: {
      //       formatter: function (val) {
      //         return val.toFixed(0);
      //       },
      //     },
      //   },
      //   chart: {
      //     toolbar: {
      //       show: false,
      //       autoSelected: "pan",
      //     },
      //     zoom: {
      //       enabled: false,
      //     },
      //     foreColor: "#FFFFFF",
      //     height: 150,
      //     type: "area",
      //     stacked: false,
      //   },
      //   stroke: {
      //     curve: "smooth",
      //   },
      //   plotOptions: {
      //     bar: {
      //       columnWidth: "50%",
      //     },
      //   },
      //   dataLabels: {
      //     enabled: false,
      //   },
      //   labels: [""],
      //   tooltip: {
      //     enabled: true,
      //     enabledOnSeries: undefined,
      //     shared: true,
      //     followCursor: false,
      //     intersect: false,
      //     inverseOrder: false,
      //     custom: undefined,
      //     fillSeriesColor: false,
      //     theme: false,
      //     style: {
      //       fontSize: "12px",
      //       fontFamily: undefined,
      //     },
      //     x: {
      //       show: false,
      //       format: "dd MMM",
      //       formatter: undefined,
      //     },
      //     y: {
      //       show: false,
      //       formatter: undefined,
      //       title: {
      //         formatter: (seriesName) => seriesName,
      //       },
      //     },
      //     z: {
      //       show: false,
      //       formatter: undefined,
      //       title: "Size: ",
      //     },
      //
      //     marker: {
      //       show: false,
      //     },
      //     fixed: {
      //       enabled: false,
      //       position: "topRight",
      //       offsetX: 0,
      //       offsetY: 0,
      //     },
      //   },
      // },
      // series: [
      //   {
      //     name: "Курс",
      //     stacked: false,
      //     type: "area",
      //     stroke: {
      //       curve: "smooth",
      //     },
      //     data: [11, 32, 45, 32, 34, 52, 41],
      //   },
      // ],
    };
  },
  methods: {
    updateChartOptions(value) {
      this.chartOptions = {
        ...this.chartOptions, ...{
          xaxis: {
            min: value.for_chart[0][0]
          }
        }
      }

      this.series = [
        {
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
