<template>
  <div id="chart-donut2">
   <div class="donut-summ-area">
    <div class="donut-summ">
      {{ new Intl.NumberFormat("ru-RU").format(summ) }}
    </div></div>
    <apexchart
      type="donut"
      :options="chartOptions"
      :series="series"
    ></apexchart>
    <div class="donut-inner1 inner2">
      В работе
      <br />
      {{ wells2.prod_wells_work }} {{ wells2.prod_wells_work_year }}
    </div>
    <div class="donut-inner1 inner1">
      В простое<br />
      {{ wells2.prod_wells_idle }} {{ wells2.prod_wells_idle_year }}
    </div>
  </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";

export default {
  name: "mix-chart",
  components: {
    "apexchart": VueApexCharts
  },
  props: ["wells2"],
  data: function () {
    return {
      summ: "",
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
        colors: ["#13B062", "#DA454E"],

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
   //console.log(this.wells2);
    var a = this.wells2.prod_wells_work;
    var b = this.wells2.prod_wells_idle;
    var wells = new Array(a, b);
    if (a == undefined && b == undefined) {
    } else {
      this.series = wells;
      this.summ = a + b;
    }

    var c = this.wells2.prod_wells_work_year;
    var d = this.wells2.prod_wells_idle_year;
    var wells = new Array(c, d);
    if (c == undefined && d == undefined) {
    } else {
      this.series = wells;
      this.summ = c + d;
    }
  },
};
</script>
