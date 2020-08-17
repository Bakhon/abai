<template>
  <div>
    <apexchart
      type="bar"
      height="180"
      width="400"
      :options="chartOptions"
      :series="series"
    ></apexchart>
  </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";

Vue.component("apexchart", VueApexCharts);
export default {
  name: "mix-chart",
  props: ["starts"],
  data: function () {
    return {
      chartOptions: {
        tooltip: {
          theme: "dark",
          x: {
            show: false,
          },
          y: {
            title: {
              show: false,
              formatter: function () {
                return "";
              },
            },
          },
        },

        colors: ["#e8e522"],
        chart: {
          animations: {
            speed: 200,
          },
          height: 180,
          type: "bar",
        },

        plotOptions: {
          bar: {
            dataLabels: {
              position: "top", // top, center, bottom
            },
            columnWidth: "50%",
          },
        },

        dataLabels: {
          enabled: false /*вывод значений из раздела data*/,
          formatter: function (val) {
            return val /*+"%"*/;
          },
          offsetY: -20,
          style: {
            fontSize: "12px",
            colors: ["#c5c5c5"],
          },
        },
        labels: ["1", "2", "3"],
        yaxis: {
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
            formatter: function (val) {
              return val /*+ "%"*/;
            },
          },
        },
        xaxis: {
          /* categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"], вывод сверху списка месяцев*/
          position: "top",
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
        },
      },
      series: [
        {
          /*
        name: 'Факт',
        type: 'bar',
        stroke: {
			show:false
               },*/
          data: [1, 2, 3],
        },
      ],
    };
  },

  created: function () {
    var a = this.starts.starts_prs;
    var b = this.starts.starts_krs;
    var c = this.starts.starts_drl;
    var starts2 = new Array({ data: [a, b, c] });
    this.series = starts2;
  },
};
</script>
