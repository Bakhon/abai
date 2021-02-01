<template>
  <div>
    <apexchart
      v-if="series.length"
      type="bar"
      height="480"
      style="margin-top: 0px"
      :options="chartOptions"
      :series="series"
    ></apexchart>
  </div>
</template>


<script>
var ru = require("apexcharts/dist/locales/ru.json");
import moment from "moment";
import VueApexCharts from "vue-apexcharts";


Vue.component("apexchart", VueApexCharts);
export default {
  name: "mix-chart",
  props: ["chartData"],
  data: function () {
    return {};
  },
  computed: {
    chartOptions() {  
    let datetime;
    if (this.chartData.labels.length > 1)
    datetime = "datetime";  else datetime;   
    
     if (typeof this.chartData === "undefined") {
        return {};
      }

      return {
        grid: {
          show: true,
          borderColor: "#90A4AE",
          strokeDashArray: 0,
          position: "back",
          row: {
            colors: undefined,
            opacity: 0.5,
          },
          column: {
            colors: undefined,
            opacity: 0.5,
          },
          padding: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0,
          },
        },
        tooltip: {
          enabled: false,
          enabledOnSeries: undefined,
          shared: true,
          followCursor: false,
          intersect: false,
          inverseOrder: false,
          custom: undefined,
          fillSeriesColor: false,
          theme: false,
               y: {
            formatter: function (y) {
              if (typeof y !== "undefined") {
                return (
                  new Intl.NumberFormat("en-IN", {
                    maximumSignificantDigits: 3,
                  }).format(y.toFixed(0)) + ""
                );
              }
              return y;
            },
          },
        },
        colors: ["#4A90E2", "#0080FF", "#F5FCFF"],
        chart: {
          stacked: false,
          locales: [ru],
          defaultLocale: "ru",
          toolbar: {
            show: false,
            Color: "#373d3f",
          },
          foreColor: "#FFFFFF",
              },

        plotOptions: {
          bar: {
            rangeBarOverlap: true,
            dataLabels: {
              //    position: 'top',
            },
            columnWidth: "20%",
          },
        },

        dataLabels: {
          enabled: false,
          formatter: function (val) {
            return val /*+"%"*/;
          },
          offsetY: -20,
          style: {
            fontSize: "12px",
            colors: ["#c5c5c5"],
          },
        },
        labels: this.chartData.labels,
        legend: {
          show: false,
          position: "bottom",
          horizontalAlign: "right",
        },

        yaxis: {
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: true,
            formatter: function (val) {
              return val /*+ "%"*/;
            },
          },
        },

        yaxis: {
          lines: {
            show: true,
          },
        },
        
        xaxis: {
       
         
        
          type: datetime,
           lines: {
              show: false,
            },
          labels: {     
                formatter: function (val) {
                  
              return moment(val).format("DD MMM YYYY")  /*+ "%"*/;
            },  
              
            datetimeFormatter: {
              day: "dd MMM yy",
              month: "dd MMM yy",
              year: "yy",
            },
         
          },
          position: "bottom",
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },
      };
    },
    series() {
          if (typeof this.chartData === "undefined") {
        return [];
      } else
        return [
          {
            type: "bar",
           // name: "Фактическая закачка ингибитора коррозии",
            stroke: {
              show: false,
            },
            data: this.chartData.series,
          },
        ];
    },
  },
  methods: {
    /*  setValue: function(value) {
          this.series = [
              {
                  name: 'Фактическая закачка ингибитора коррозии',
                 // data: value.value
                 data:  [20,30,40]
              }
              ];

          this.chartOptions = {
          //  ['20','30','40'] /// labels: value.dt
          };
      }*/
  },
  created: function () {
    // this.$parent.$on('chart3', this.setValue);
    // this.setValue;
  },
};
</script>
