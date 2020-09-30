<template>
  <div>
    <apexchart

      type="line"
       height="400"
      :options="chartOptions"
      :series="series"
    ></apexchart>
    <div class="begin">{{ begin }}</div>
    <div class="">{{ oilPeriod }}</div>
    <div class="end">{{ end }}</div>
  </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";
import { EventBus } from "../../event-bus.js";
Vue.component("apexchart", VueApexCharts);
export default {
  name: "mix-chart",
  props: ["postTitle"],
  data: function () {
    return {
      series: "",
      oilPeriod: "",
      begin: "",
      end: "",
      chartOptions: {
        yaxis: {
          labels: {
            formatter: function (val) {
              //return val.toFixed(0);
              return Math.round(val);
            },
          },
        },
        chart: {      
          scaleIntegersOnly: true,
          toolbar: {         
            show: true,
             Color: '#373d3f',
            //autoSelected: "pan",
            
          },
          zoom: {
            enabled: true,
          },
          foreColor: "#FFFFFF",
        //  height: 150,
       //   type: "area",
        },
        stroke: {
          curve: "smooth",
          width: 4,
        },
        plotOptions: {
          bar: {
            columnWidth: "50%",
          },
        },
       legend: {
          position: "bottom",
          horizontalAlign: "right",
        },
        dataLabels: {
          enabled: false,
        },
        colors: ["#CC6F3C","#FF0D18",  "#237DEB"],
        labels: "",
        xaxis: {
          labels: {
            show: true,
          },
        },

        annotations: {
          points: [
            {
              x: 14,
              y: 75,
              marker: {
                strokeColor: "red",
                fillColor: "red",
                size: 7,
              },
              label: {
                //  foreColor: "red",
                background: "#FF4560",
                borderColor: "#FF4560",
                style: {
                  color: "#000",
                  //background: '#FF4560',
                },
                text: "Point Annotation",
              },
            },

            {
              x: 26,
              y: 39,
              marker: {
                strokeColor: "#13B062",
                fillColor: "#13B062",
                size: 7,
              },
              label: {
                //  foreColor: "red",
                background: "#13B062",
                borderColor: "#13B062",
                style: {
                  color: "#000",
                  //background: '#FF4560',
                },
                text: "Point Annotation",
              },
            },
          ],
        },

        tooltip: {
          enabled: true,
          enabledOnSeries: undefined,
          shared: true,
          followCursor: false,
          intersect: false,
          inverseOrder: false,
          custom: undefined,
          fillSeriesColor: false,
          theme: false,
          style: {
            fontSize: "12px",
            fontFamily: undefined,
            
          },
          x: {
            show: false,
            format: "dd MMM",
            formatter: undefined,
          },
          y: {
            show: false,
            formatter: undefined,
            title: {
              formatter: (seriesName) => seriesName,
            },
          },
          z: {
            show: false,
            formatter: undefined,
            title: "Size: ",
          },

          marker: {
            show: false,
          },
          fixed: {
            enabled: false,
            position: "topRight",
            offsetX: 0,
            offsetY: 0,
          },
        },
      },
      series: [
        {
          name: "1",
          type: "line",
          stroke: {
           // curve: "smooth",
          },
          data: [0],
        },
        {
          name: "2",
          type: "line",
          stroke: {
           // curve: "smooth",
          },
          data: [0],
        },

        {
          name: "3",
          type: "line",
          stroke: {
           // curve: "smooth",
          },
          data: [0],
        },
      ],
    };
  },
  methods: {
    setValue: function (value) {
      var ipr_points = [];
      var pintake_points = [];
      var freegas_points = [];
      var qo_points = [];
      var value2 = [];
      var ipr_points2 = [];
      var pintake_points2 = [];
      var freegas_points2 = [];
      var qo_points2 = [];

      var filtered = value.filter(function (_, i) {
        return i % 20 === 0;
      });

     // console.log(filtered);
      _.forEach(filtered, function (values) {
        ipr_points = values.ipr_points;
        pintake_points = values.pintake_points;
        freegas_points = values.freegas_points;
        qo_points = values.qo_points;

        ipr_points2.push(ipr_points);
        pintake_points2.push(pintake_points);
        freegas_points2.push(freegas_points);
        qo_points2.push(qo_points);
      });

      console.log([ipr_points2]);
      this.series = [
        {
          name: "Pnp",
          data: pintake_points2,
        },
        {
          name: "IPR (кривая притока)",
          data: ipr_points2,
        },

        {
          //name: "Текущий режим",
          name: "Газосодержание в насосе",
          data: freegas_points2,
        },
      ];

      this.chartOptions = {
        labels: qo_points2,
      };
    },
  },

  mounted() {},
  created: function () {
    this.$parent.$on("data", this.setValue);
  },
};
</script>
