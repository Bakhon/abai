<template>
  <div id="chart-donut2">
    <apexchart
      type="donut"
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
  //props: ["oil","index"],
  props: ["oil"],

  /*{
oil: Array,
index: Number,
    },
    */

  data: function () {
    return {
      series: [0],
      chartOptions: {
        labels: [],
        chart: {
          type: "donut",
        },

        colors: [
          "#FF9769",
          "#F7BB2E",
          "#00A0E3",
          "#A3A0FB",
          "#E06765",
          "#3B86FF",
          "#13B062",
        ],
        plotOptions: {
          pie: {
            expandOnClick: false,
          },
        },
        responsive: [
          {
            breakpoint: 480,
            options: {
              chart: {
                width: 200,
              },
              legend: {
                position: "bottom",
              },
            },
          },
        ],
      },
    };
  },

  created: function () {
    var data = this.oil;
    // var data2 = this.index;
    var oilFull;

    var gk_fact = [];
    var dzo = [];
    var gas_fact = [];
    var colors = [];
    //console.log(data);
    _.forEach(data, function (item) {
      gk_fact.push(Number(item.gk_fact));
      dzo.push(item.dzo);
      gas_fact.push(Number(item.gas_fact));
      colors.push(item.colors);
    });

    //console.log(gas_fact);

    this.series = gas_fact;
    this.chartOptions = {
      colors: colors,
      dataLabels: {
        enabled: false,
      } /*убирается подсветка процентов на круге*/,
      tooltip: {
        enabled: true,
      },
      legend: {
        show: false,
      } /*убирается навигация рядом с кругом*/,
      labels: dzo,
    };
  },
};
</script>
