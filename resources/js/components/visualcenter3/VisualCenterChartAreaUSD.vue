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
import moment from "moment";

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
          locales: [{
            "name": "ru",
            "options": {
              "months": [
                this.trans("visualcenter.chartOptions.monthNames.january"),
                this.trans("visualcenter.chartOptions.monthNames.february"),
                this.trans("visualcenter.chartOptions.monthNames.march"),
                this.trans("visualcenter.chartOptions.monthNames.april"),
                this.trans("visualcenter.chartOptions.monthNames.may"),
                this.trans("visualcenter.chartOptions.monthNames.june"),
                this.trans("visualcenter.chartOptions.monthNames.july"),
                this.trans("visualcenter.chartOptions.monthNames.august"),
                this.trans("visualcenter.chartOptions.monthNames.september"),
                this.trans("visualcenter.chartOptions.monthNames.october"),
                this.trans("visualcenter.chartOptions.monthNames.november"),
                this.trans("visualcenter.chartOptions.monthNames.december"),
              ],
              "shortMonths": [
                this.trans("visualcenter.jan"),
                this.trans("visualcenter.feb"),
                this.trans("visualcenter.mar"),
                this.trans("visualcenter.apr"),
                this.trans("visualcenter.may"),
                this.trans("visualcenter.june"),
                this.trans("visualcenter.july"),
                this.trans("visualcenter.aug"),
                this.trans("visualcenter.sept"),
                this.trans("visualcenter.oct"),
                this.trans("visualcenter.nov"),
                this.trans("visualcenter.dec")
              ],
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
            },
            formatter: function (value) {
              return moment(value).format("DD MMM");
            },
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
    updateChartOptions(value) {
      let self = this;

      this.chartOptions = {
        ...this.chartOptions, ...{
          tooltip: {
            x: {
              formatter: function (value) {
                return self.$moment(value).format('DD MMM YYYY');
              }
            },
            style: {
              fontSize: '14px',
            },
            custom: function({series, seriesIndex, dataPointIndex, w}) {
              return '<div class="vc-chart-tooltip">' +
                      '<div>' + self.trans("visualcenter.buy") + '</div>' +
                      '<div class="vc-chart-tooltip-value">' + series[seriesIndex][dataPointIndex] + '</div>' +
                      '</div>'
            }
          },
        }
      }

      this.series = [
        {
          name: this.trans("visualcenter.chartOptions.selling"),
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