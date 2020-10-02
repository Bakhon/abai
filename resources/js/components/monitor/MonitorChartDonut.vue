<template>
  <div id="chart-donut2">
    <apexchart
      type="donut"
      height="200"
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
  //props: ["oil"],

  /*{
oil: Array,
index: Number,
    },
    */

  data: function () {
    return {
      oil: [
        {
          colors: "#00A0E3",
          dzo: "ОМГ",
          gas_fact: "",
          gk_fact: "25",
          proportion: "100%",
        },

        {
          colors: "#2EC5FF",
          dzo: "ОМГ",
          gas_fact: "",
          gk_fact: "18",
          proportion: "100%",
        },

        {
          colors: "#F5FCFF",
          dzo: "ОМГ",
          gas_fact: "",
          gk_fact: "10",
          proportion: "100%",
        },
        {
          colors: "#087EF4",
          dzo: "ОМГ",
          gas_fact: "",
          gk_fact: "50",
          proportion: "100%",
        },
      ],

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
    var colors = [];
    //console.log(data);
    _.forEach(data, function (item) {
      gk_fact.push(Number(item.gk_fact));
      dzo.push(item.dzo);
      colors.push(item.colors);
    });

    console.log(colors);

    this.series = gk_fact;
    this.chartOptions = {
      colors: colors,
      dataLabels: {
        enabled: true,
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

  /*created: function () {
this.showChart();
  },
        updated(){this.showChart();},*/
};
</script>
