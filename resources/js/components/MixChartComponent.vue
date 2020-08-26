<template>
  <div>
    <apexchart height="350" type="line" :options="chartOptions" :series="series"></apexchart>
  </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";

Vue.component("apexchart", VueApexCharts);
export default {
  name: "mix-chart",
  data: function () {
    return {
      chartOptions: {
        chart: {
          stacked: true,
          foreColor: "#FFFFFF",
        },
        stroke: {
          width: 4,
          curve: "smooth",
        },
        plotOptions: {
          bar: {
            columnWidth: "50%",
          },
        },
        fill: {
          opacity: [0.85, 0.25, 1],
          gradient: {
            inverseColors: false,
            shade: "light",
            type: "vertical",
            opacityFrom: 0.85,
            opacityTo: 0.55,
            stops: [0, 100, 100, 100],
          },
        },
        labels: [
          "01/01/2020",
          "02/01/2020",
          "03/01/2020",
          "04/01/2020",
          "05/01/2020",
          "06/01/2020",
          "07/01/2020",
          "08/01/2020",
          "09/01/2020",
          "10/01/2020",
          "11/01/2020",
        ],
        markers: {
          size: 0,
        },
        xaxis: {
          type: "datetime",
        },
        yaxis: {
          labels: {
            formatter: function (value) {
              return Math.round(value);
            },
          },
          title: {
            text: "Количество",
          },
          min: 0,
        },
        tooltip: {
          shared: true,
          intersect: false,
          y: {
            formatter: function (y) {
              if (typeof y !== "undefined") {
                return y.toFixed(0) + "";
              }
              return y;
            },
          },
        },
      },
    };
  },
  methods: {},
  mounted() {
    console.log(this.series);
  },
};
</script>
