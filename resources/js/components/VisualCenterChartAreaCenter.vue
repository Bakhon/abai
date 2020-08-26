<template>
  <div>
    <apexchart
      type="area"
      height="350"
      width="1290"
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
  props: ["postTitle"],

  data: function () {
    return {
      chartOptions: {
        chart: {
          /*stacked: true,*/
          foreColor: "#FFFFFF",
          height: 250,
          type: "area",
        },
        stroke: {
          /*width: 4,*/
          curve: "smooth",
        },
        plotOptions: {
          bar: {
            columnWidth: "50%",
          },
        },
        /*fill: {
          opacity: [0.85, 0.25, 1],
          gradient: {
            inverseColors: false,
            shade: 'light',
            type: "area",
            opacityFrom: 0.85,
            opacityTo: 0.55,
            stops: [0, 100, 100, 100]
          }
        },*/
        legend: {
          position: "top",
          /*horizontalAlign: 'left'*/
        },
        dataLabels: {
          enabled: false,
        },
        labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
        /*markers: {
          size: 0
        },
        xaxis: {
          type: 'datetime'
        },
        yaxis: {
          title: {
            text: 'Количество',
          },
          min: 0
        },*/
        /* tooltip: {
          shared: true,
          intersect: false,
          y: {
            formatter: function(y) {
              if (typeof y !== "undefined") {
                return y.toFixed(0) + "";
              }
              return y;
            }
          }
        }*/
      },
      series: [
        {
          name: "План",
          type: "area",
          stroke: {
            /* width: 5,*/
            curve: "smooth",
          },
          data: [0],
        },
        {
          name: "Факт",
          type: "area",
          stroke: {
            /* width: 5,*/
            curve: "smooth",
          },
          data: [0],
        },
      ],
    };
  },

  /*created: function () {
    // `this` указывает на экземпляр vm
   console.log(this.postTitle);
  }*/

  mounted() {
    // показывает данные после отрисовки компонента в консоли

    var data = [];
    var data = this.postTitle;

    var productionPlanForChart = new Array();
    _.forEach(data, function (item) {
      productionPlanForChart.push(item.productionPlanForChart);
    });

    var productionFactForChart = new Array();
    _.forEach(data, function (item) {
      productionFactForChart.push(item.productionFactForChart);
    });

    var productionFactForChartMonth = new Array();
    _.forEach(data, function (item) {
      productionFactForChartMonth.push(item.productionFactForChartMonth);
    });

    var productionPlanForChartMonth = new Array();
    _.forEach(data, function (item) {
      productionPlanForChartMonth.push(item.productionPlanForChartMonth);
    });

    var productionFactForChartYear = new Array();
    _.forEach(data, function (item) {
      productionFactForChartYear.push(item.productionFactForChartYear);
    });

    var productionPlanForChartYear = new Array();
    _.forEach(data, function (item) {
      productionPlanForChartYear.push(item.productionPlanForChartYear);
    });

    var quantity = data.length;

    var quantity2 = [];
    for (let i = 1; i <= quantity; i++) {
      var a = [i];
      quantity2.push(a);
    }

    this.chartOptions = { labels: quantity2 };

    //this.dataLabels= {labels:quantity2};
    /* 
            _.each(quantity, function (quantity) {
              quantity.push({ quantity });
            });*/
    if (
      productionPlanForChart[1] == undefined &&
      productionFactForChart[1] == undefined
    ) {
    } else {
      this.series = [
        {
          name: "План",
          type: "area",
          stroke: {
            /* width: 5,*/
            curve: "smooth",
          },
          // data: [31, 40, 28, 51, 42, 109, 100]

          data: productionPlanForChart,
        },
        {
          name: "Факт",
          type: "area",
          stroke: {
            /* width: 5,*/
            curve: "smooth",
          },
          data: productionFactForChart,
        },
      ];
    }

    //console.log(productionPlanForChartMonth);
    if (
      productionPlanForChartMonth[1] == undefined &&
      productionFactForChartMonth[1] == undefined
    ) {
    } else {
      this.series = [
        {
          name: "План",
          type: "area",
          stroke: {
            /* width: 5,*/
            curve: "smooth",
          },
          // data: [31, 40, 28, 51, 42, 109, 100]

          data: productionPlanForChartMonth,
        },
        {
          name: "Факт",
          type: "area",
          stroke: {
            /* width: 5,*/
            curve: "smooth",
          },
          data: productionFactForChartMonth,
        },
      ];
    }

    if (
      productionPlanForChartYear[1] == undefined &&
      productionPlanForChartYear[1] == undefined
    ) {
    } else {
      this.chartOptions = { labels: ["2018", "2019", "2020"] };
      this.series = [
        {
          name: "План",
          type: "area",
          stroke: {
            /* width: 5,*/
            curve: "smooth",
          },
          // data: [31, 40, 28, 51, 42, 109, 100]

          data: productionPlanForChartYear,
        },
        {
          name: "Факт",
          type: "area",
          stroke: {
            /* width: 5,*/
            curve: "smooth",
          },
          data: productionFactForChartYear,
        },
      ];
    }

    console.log(this.postTitle);
  },
};
</script>
