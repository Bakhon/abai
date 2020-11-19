<template>
  <div>
    <apexchart
      type="bar"
      height="380"
      style="margin-top: 0px;"
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
  props:["data"],
  data: function () {
    return {
      chartOptions: {
        tooltip: {
          theme: "dark",
          x: {
            show: true,
          },
          y: {
            title: {
              show: true,
              formatter: function () {
                return "";
              },
            },
          },
        },

        colors: ["#fba409", "#13b062"],
        chart: {
          toolbar: {
            show: true,
            Color: "#373d3f",
            //autoSelected: "pan",
          },
          foreColor: "#fff",
          animations: {
            speed: 200,
          },
          //  height: 150,
          type: "area",
        },

        plotOptions: {
          bar: {
            //  endingShape: 'rounded'  ,
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
        labels: ["Qн, т/сут", "ННО, сут", "Энергопотребление кВт*ч",  "NPV, млрд.тг"],
        legend: {
          show: true,
          position: "bottom",
          horizontalAlign: "center",
        },

        yaxis: {
          axisBorder: {
            show: true,
          },
          axisTicks: {
            show: true,
          },
          labels: {
            show: true,
            formatter: function (val) {
              return val /*+ "%"*/;
            },
          },
        },
        xaxis: {
          /* categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"], вывод сверху списка месяцев*/
          position: "bottom",
          axisBorder: {
            show: true,
          },
          axisTicks: {
            show: true,
          },
        },
      },
      series:[]
    };
  },

  mounted(){



      //this.data=JSON.parse(this.data)


      this.series= [
        {
          name: "ШГН",
          type: "bar",
          stroke: {
            show: true,
          },
          data: [Math.round(this.data.qoilShgn/1000), Math.round(this.data.NNO1), Math.round(this.data.shgnParam), Math.round(this.data.shgnNpv/1000)],
        },
        {
          name: "ЭЦН (аренда)",
          type: "bar",
          stroke: {
            show: true,
          },
          data: [Math.round(this.data.qoilEcn/1000), Math.round(this.data.NNO2), Math.round(this.data.ecnParam), Math.round(this.data.ecnNpv/1000)],
        },
      ]

  }





}
</script>
