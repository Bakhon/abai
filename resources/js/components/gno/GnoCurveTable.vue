<template>
  <Plotly :data="data" :layout="layout" :display-mode-bar="false"></Plotly>
</template>

<script>
//
import { Plotly } from "vue-plotly";
import { eventBus } from "../../event-bus.js";

Vue.prototype.$eventBus = new Vue();
Vue.component("Plotly", Plotly);
export default {
  name: "mix-chart",
  props: ["postTitle"],
  data: function () {
    return {
      flag: false,
      layout: {
        //      showlegend: false,
        xaxis: {
          title: "Дебит, q, м³/сут.",
          hoverformat: ".1f",
          //  showline: true,
          // autorange: false,
          // range: [0,150],
          zeroline: false,
          // showgrid: true,
          // mirror:true,
          // ticklen: 4,
          gridcolor: "#123E73",
          //tickfont: {size: 10},
        },
        yaxis: {
          hoverformat: ".1f",
          // showline: true,
          zeroline: false,
          //showgrid: true,
          // mirror:true,
          // ticklen: 4,
          gridcolor: "#123E73",
          //tickfont: {size: 10},
        },

        //   scene:{ gridcolor: '#ffffff',},
        paper_bgcolor: "#20274e",
        plot_bgcolor: "#20274e",
        font: { color: "#fff" },

        legend: {
          orientation: "h",
          y: -0.3,
          font: {
            size: 12,
            color: "#fff",
          },
        },
      },

      data: []
    };
  },
  methods: {
    setLine: function (value) {
      console.log(value)
      var ipr_points = [];
      var pintake_points = [];
      var freegas_points = [];
      var qo_points = [];
      var value2 = [];
      var ipr_points2 = [];
      var pintake_points2 = [];
      var freegas_points2 = [];
      var qo_points2 = [];

      _.forEach(value, function (values) {
        ipr_points = values.ipr_points;
        pintake_points = values.pintake_points;
        freegas_points = values.freegas_points;
        qo_points = values.qo_points;

        //if (freegas_points==0) {freegas_points=0};
        if (freegas_points == "nan") {
          freegas_points = null;
        }
        if (pintake_points == "nan") {
          pintake_points = null;
        }
        ipr_points2.push(ipr_points);
        pintake_points2.push(pintake_points);
        freegas_points2.push(freegas_points);
        qo_points2.push("" + qo_points + "");
      });

      this.data = [
        {
          name: "Pnp",
          x: qo_points2,
          y: pintake_points2,

          marker: {
            size: "15",
            color: "#CC6F3C",
          },
        },

        {
          name: "IPR (кривая притока)",
          x: qo_points2,
          y: ipr_points2,

          marker: {
            size: "15",
            color: "#FF0D18",
          },
        },

        {
          name: "Газосодержание в насосе",
          x: qo_points2,
          y: freegas_points2,
          marker: {
            size: "15",
            color: "#237DEB",
          },
        },

        {
          name: "Текущий режим",
          x: [40],
          y: [40],
          mode: "markers",
          marker: {
            size: "15",
            color: "#00A0E3",
          },
        },

        {
          name: "Целевой (расчётный) режим",
          x: [],
          y: [],
          mode: "markers",
          marker: {
            size: "15",
            color: "#13B062",
          },
        },

        {
          name: "Потенциальный режим",
          x: [],
          y: [],
          mode: "markers",
          marker: {
            size: "15",
            color: "#FBA409",
          },
        },
      ];
      this.chartOptions = {
        // ["10", "20", "3", "4", "5", "6", "7", "8", "9", "10"],
        labels: qo_points2,
      };
    },
    setPoints: function (value) {
      this.data[3]['x'][0] = value[0]["q_l"]
      this.data[3]['y'][0] = value[0]["p"]
      this.data[5]['x'][0] = value[1]["q_l"]
      this.data[5]['y'][0] = value[1]["p"]
      this.data[4]['x'][0] = value[2]["q_l"]
      this.data[4]['y'][0] = value[2]["p"]
    },
  },

  mounted() {},
  created: function () {
    this.$parent.$on("LineData", this.setLine);
    this.$parent.$on("PointsData", this.setPoints);
    // this.$on("LineData", this.setLine);
    // this.$on("PointsData", this.setPoints);
    
  },
  updated: function() {
    this.$eventBus.$on("newCurveLineData", this.setLine);
    this.$eventBus.$on("newPointsData", this.setPoints);
  }

};
</script>
