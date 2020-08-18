<template>
  <div id="chart-donut2">
    <apexchart
      type="donut"
      :options="chartOptions"
      :series="series"
    ></apexchart>
    <div class="donut-inner1 inner1">
    В работе
      <br />
      {{ wells2.prod_wells_work }}
    </div>
    <div class="donut-inner1 inner2">
      В простое<br />
      {{ wells2.prod_wells_idle }}
    </div>
  </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";

Vue.component("apexchart", VueApexCharts);
export default {
  name: "mix-chart",
  props: ["wells2"],
  data: function () {
    return {
      series: [0, 0],
      chartOptions: {
        labels: ["В работе", "В простое"],
        chart: {
          type: "donut",
        },
        dataLabels: {
          enabled: false,
        } /*убирается подсветка процентов на круге*/,
        /*tooltip: {
      enabled: false},*/
        legend: {
          show: false,
        } /*убирается навигация рядом с кругом*/,
        colors: ["#47d660", "#ec5464"],

        plotOptions: {
          pie: {
            expandOnClick: true,
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
    console.log(this.wells2);
    var a = this.wells2.prod_wells_work;
    var b = this.wells2.prod_wells_idle;
    var wells = new Array(a, b);
    if (a==undefined && b==undefined){} else{this.series = wells;}



  }, 
};
</script>
