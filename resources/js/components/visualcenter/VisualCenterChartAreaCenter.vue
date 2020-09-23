<template>
  <div>
    <apexchart
      type="area"
      height="350"
      width="1243"
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
             yaxis: { 
               labels: {
            formatter: function (val) {
           if (val> 1000){
              return new Intl.NumberFormat('ru-RU').format( (Math.round(val / 100) * 100));
              } else
              {
              return new Intl.NumberFormat('ru-RU').format( (Math.round(val / 10) * 10));
              }
              
              
              
            },
          },
      min: 0},
        chart: {         
          toolbar: {
            show: false,
            autoSelected: "pan",
          },
          zoom: {
            enabled: false,
          },
          foreColor: "#FFFFFF",
          height: 250,
          type: "area",
        },
        stroke: {
          curve: "smooth",
        },
        plotOptions: {       
          bar: {
            columnWidth: "50%",
          },
        },
        legend: {
          position: "top",
        },
        dataLabels: {
          enabled: false,
        },
        labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
      },
      series: [
        {
          name: "План",
          type: "area",
          stroke: {
            curve: "smooth",
          },
          data: [0],
        },
        {
          name: "Факт",
          type: "area",
          stroke: {
            curve: "smooth",
          },
          data: [0],
        },
      ],
    };
  },
  mounted() {
    var data = [];
    var data = this.postTitle;
    //console.log(this.postTitle);

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
    productionFactForChartYear = productionFactForChartYear.reverse();

    var productionPlanForChartYear = new Array();
    _.forEach(data, function (item) {
      productionPlanForChartYear.push(item.productionPlanForChartYear);
    });
    productionPlanForChartYear = productionPlanForChartYear.reverse();

    var quantity = data.length;

    var quantity2 = [];
    for (let i = 1; i <= quantity; i++) {
      var a = [i];
      quantity2.push(a);
    }

    this.chartOptions = { labels: quantity2 };

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
            curve: "smooth",
          },

          data: productionPlanForChart,
        },
        {
          name: "Факт",
          type: "area",
          stroke: {
            curve: "smooth",
          },
          data: productionFactForChart,
        },
      ];
    }

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
            curve: "smooth",
          },

          data: productionPlanForChartMonth,
        },
        {
          name: "Факт",
          type: "area",
          stroke: {
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
            curve: "smooth",
          },

          data: productionPlanForChartYear,
        },
        {
          name: "Факт",
          type: "area",
          stroke: {
            curve: "smooth",
          },
          data: productionFactForChartYear,
        },
      ];
    }
  },
};
</script>
