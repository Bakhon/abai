<template>
  <Plotly :data="data" :layout="layout" :display-mode-bar="false"></Plotly>
</template>

<script>
//
import { Plotly } from "vue-plotly";
import { EventBus } from "../../event-bus.js";
Vue.component("Plotly", Plotly);
export default {
  name: "mix-chart",
  props: ["postTitle"],
  data: function () {
    return {
      layout: {
        autosize: true,
        // width: 200,
        //height: 500,
        //      showlegend: false,
        xaxis: {
          hoverformat: ".1f",
          // showline: true,
          zeroline: false,
          showgrid: false,
          // mirror:true,
          // ticklen: 4,
          gridcolor: "#123E73",
          tickfont: { size: 10 },
        },
        yaxis: {
          // rangemode: "tozero",
          hoverformat: ".1f",
          // showline: true,
          zeroline: false,
          //showgrid: true,
          // mirror:true,
          // ticklen: 4,
          gridcolor: "#123E73",
          tickfont: { size: 10 },
        },

        //   scene:{ gridcolor: '#ffffff',},
        paper_bgcolor: "#272953",
        //paper_bgcolor: "#20274e",
        plot_bgcolor: "#272953",
        font: { color: "#fff" },

        legend: {
          orientation: "h",
          y: -3.8,
          font: {
            size: 12,
            color: "#fff",
          },
        },
      },

      data: {
        data: [
          {
            name: "Line1",
            x: [""],
          },
        ],
      },
    };
  },
  methods: {
    setValue: function (value) {
      var productionFactForChart = new Array();
      _.forEach(value, function (item) {
        productionFactForChart.push(item.productionFactForChart);
      });

      var productionPlanForChart = new Array();
      _.forEach(value, function (item) {
        productionPlanForChart.push(item.productionPlanForChart);
      });

      var quantity = value.length;

      var quantity2 = [];
      for (let i = 1; i <= quantity; i++) {
        quantity2.push(i);
      }

      this.data = [
        {
          name: "План",
          x: quantity2,
          y: productionPlanForChart,
          mode: "lines",

          marker: {
            size: "15",
            color: "#a0a7cb",
          },
        },
        {
          name: "Факт",
          x: quantity2,
          y: productionFactForChart,
          mode: "lines",

          marker: {
            size: "15",
            color: "#2e50ea",
          },
        },
      ];
    },
  },

  mounted() {},
  created: function () {
    this.$parent.$on("data", this.setValue);
  },
};
</script>
