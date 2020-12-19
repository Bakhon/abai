<template>
  <Plotly :data="data"
          :layout="layout"
          :display-mode-bar="false"></Plotly>
</template>

<script>
//
import { Plotly } from "vue-plotly";
import { EventBus } from "../../event-bus.js";
Vue.component("Plotly", Plotly);
export default {
  data: function ()
  {
    return {
      layout: {
        //      showlegend: false,
        xaxis: {
          hoverformat: ".1f",
          //  showline: true,
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

  mounted: function () {
    console.log('Mounted'),
    this.$parent.$on("LineDataSmallwindow", this.setData);
  },
  created: function () {
    console.log('Created')
    this.$parent.$on("LineDataSmallwindow", this.setLine);

  },
  methods: {
    setData: function (data) {
      console.log(data)
      this.val = data
    },
    setLine: function (value) {
      console.log(value);
      var ipr_points = [];
      var qo_points = [];

      _.forEach(value, function (values) {
        ipr_points = values.ipr_points;
        qo_points = values.qo_points;

        ipr_points2.push(ipr_points);
        qo_points2.push("" + qo_points + "");
      });
      console.log("IPR = ", ipr_points2)
      console.log(this.data)
      this.data = [
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
          name: "Текущий режим",
          x: [],
          y: [],
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
      console.log(this.data)

    this.chartOptions = {
        // ["10", "20", "3", "4", "5", "6", "7", "8", "9", "10"],
        labels: qo_points2,
      };

    },
    setPoints: function (value) {
      console.log(value)
      this.data[3]['x'][0] = value[0]["q_l"]
      this.data[3]['y'][0] = value[0]["p"]
      this.data[5]['x'][0] = value[1]["q_l"]
      this.data[5]['y'][0] = value[1]["p"]
    },
  },

};
</script>
