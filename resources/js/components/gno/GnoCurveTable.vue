<template>
  <div>
    <div class="gno-curve-table-title">
      {{trans('pgno.krivaya_pritoka')}}
    </div>

    <Plotly :data="data"
            :layout="layout"
            :display-mode-bar="false"
            :displaylogo="false"
            :mode-bar-buttons-to-remove="buttonsToRemove"/>
  </div>
</template>

<script>
import { Scatter } from 'vue-chartjs';
import { Plotly } from "vue-plotly";
import { eventBus } from "../../event-bus.js";

Vue.prototype.$eventBus = new Vue();
Vue.component("Plotly", Plotly);
export default {

  name: "mix-chart",
  props: ["postTitle"],
  data: function () {
    return {
      titleXRu: "Дебит жидкости, м³/сут.",
      titleXKz: "Сұйықтық дебиті, м³/тәул.",
      titleXEn: "Liquid flow rate, м³/d.",
      titleYRu: "Давление, атм/газосодержание, %",
      titleYKz: "Қысым, атм / газ құрамы, %",
      titleYEn: "Pressure, atm/gas saturation, %",
      nameKP: "Кривая притока" ,
      namePN: "Давление на приёме насоса",
      nameGN: "Газосодержание в насосе",
      nameTR: "Текущий режим",
      nameCR: "Целевой режим",
      namePR: "Потенциальный режим",
      markers: [],
      buttonsToRemove: [
        'zoom2d',
        'pan2d',
        'select2d',
        'lasso2d',
        'zoomIn2d',
        'zoomOut2d',
        'autoScale2d',
        'resetScale2d',
        'hoverClosestCartesian',
        'hoverCompareCartesian',
        'toggleSpikelines'
      ],
      layout: {
        shapes: [{
          type: 'line',
          yref: 'paper',
          x0: 20,
          y0: 0,
          x1: 20,
          y1: 1,
          line: {
            color: 'orange',
            width: 1,
            dash: 'dot'
          }
        }],
        // width:  1200,
        height: 410,
        // autosize: true,
        // showlegend: true,
        margin: {
          l: 100,
          r: 100,
          b: 100,
          t: 30
        },
        xaxis: {
          title: '',
          hoverformat: ".1f",
          // showline: true,
          // autorange: false,
          // showgrid: true,
          // showline: true,
          // mirror: 'ticks',
          // range: [0,100],
          // zeroline: false,
          rangemode: 'nonnegative',
          // showgrid: true,
          // mirror:true,
          // ticklen: 4,
          gridcolor: "#454D7D",
          // tickfont: {size: 10},
          linewidth: 1,
          linecolor: "#454D7D"
        },
        yaxis: {
          title: '',
          hoverformat: ".1f",
          rangemode: 'nonnegative',
          showline: true,
          // range: [0,100],
          // zeroline: false,
          // showgrid: true,
          // mirror: 'ticks',
          // mirror:true,
          // ticklen: 4,
          gridcolor: "#454D7D",
          // tickfont: {size: 10},
          linewidth: 1,
          linecolor: "#454D7D"
        },

        //   scene:{ gridcolor: '#ffffff',},
        paper_bgcolor: "#272953",
        plot_bgcolor: "#272953",
        font: { color: "#fff" },

        legend: {
          orientation: "h",
          y: -0.3,
          font: {
            size: 11.4,
            color: "#fff",
          },
        },
      },

      data: []
    };
  },
  methods: {

    setLine: function (value) {
      // console.log(value)
      var ipr_points = [];
      var pintake_points = [];
      var freegas_points = [];
      var qo_points = [];
      var value2 = [];
      var ipr_points2 = [];
      var pintake_points2 = [];
      var freegas_points2 = [];
      var qo_points2 = [];
      var q_oil = [];
      var q_oil2 = [];

      _.forEach(value, function (values) {
        ipr_points = values.ipr_points;
        pintake_points = values.pintake_points;
        freegas_points = values.freegas_points;
        qo_points = values.qo_points;
        q_oil = values.q_oil;

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
        q_oil2.push(q_oil);
      });

      this.data = [ {
          name: this.nameKP,
          legendgroup: "group1",
          x: qo_points2,
          y: ipr_points2,
          text: q_oil2,
          hovertemplate: "<b>Кривая притока</b><br>" +
                          "Qж = %{x:.1f} м³/сут<br>" +
                          "Qн = %{text:.1f} т/сут<br>" +
                          "Pзаб = %{y:.1f} атм<extra></extra>",
          marker: {
            x: 20,
            y: 60,
            size: "15",
            color: "#FF0D18",
          },
        },

        {
          name: this.namePN,
          legendgroup: "group2",
          x: qo_points2,
          y: pintake_points2,
          hovertemplate: '<b>Pnp = %{y:.1f} атм</b><extra></extra>',

          marker: {
            size: "15",
            color: "#CC6F3C",
          },
        },

        {
          name: this.nameGN,
          legendgroup: "group3",
          x: qo_points2,
          y: freegas_points2,
          yaxis: 'y',
          hovertemplate: '<b>Газосодержание в насосе = %{y:.1f}%</b><extra></extra>',
          marker: {
            size: "15",
            color: "#237DEB",
          },
        },

        {
          name: this.nameTR,
          legendgroup: "group4",
          x: [],
          y: [],
          text: [],
          mode: "markers",
          hovertemplate:  "<b>Текущий режим</b><br><extra></extra>" +
                          "Qж = %{x:.1f} м³/сут<br>" +
                          "Qн = %{text:.1f} т/сут<br>" +
                          "Pзаб = %{y:.1f} атм",
          marker: {
            size: "15",
            color: "#00A0E3",
          },
        },

        {
          name: this.nameCR,
          legendgroup: "group5",
          x: [],
          y: [],
          text: [],
          mode: "markers",
          hovertemplate:  "<b>Целевой режим</b><br>" +
                          "Qж = %{x:.1f} м³/сут<br>" +
                          "Qн = %{text:.1f} т/сут<br>" +
                          "Pзаб = %{y:.1f} атм<extra></extra>",
          marker: {
            size: "15",
            color: "#13B062",
          },
        },

        {
          name: this.namePR,
          legendgroup: "group6",
          x: [],
          y: [],
          text: [],
          mode: "markers",
          hovertemplate:  "<b>Потенциальный режим</b><br>" +
                          "Qж = %{x:.1f} м³/сут<br>" +
                          "Qн = %{text:.1f} т/сут<br>" +
                          "Pзаб = %{y:.1f} атм<extra></extra>",
          marker: {
            size: "6",
            color: "#FBA409",
          },
        },
      ];
      this.chartOptions = {
        // ["10", "20", "3", "4", "5", "6", "7", "8", "9", "10"],
        labels: qo_points2,
      };
     /////////

     /////////
    },
    setPoints: function (value) {
      this.data[3]['x'][0] = value[0]["q_l"]
      this.data[3]['y'][0] = value[0]["p"]
      this.data[3]['text'][0] = value[0]["q_oil"]
      this.data[5]['x'][0] = value[1]["q_l"]
      this.data[5]['y'][0] = value[1]["p"]
      this.data[5]['text'][0] = value[1]["q_oil"]
      this.layout['shapes'][0]['x0'] = value[1]['q_l']
      this.layout['shapes'][0]['x1'] = value[1]['q_l']
      this.data[4]['x'][0] = value[2]["q_l"]
      this.data[4]['y'][0] = value[2]["p"]
      this.data[4]['text'][0] = value[2]["q_oil"]
    },
    // resize() {
    //   console.log(window.innerWidth);
    // }
  },
  mounted() {},
  created: function () {
    this.$parent.$on("LineData", this.setLine);
    this.$parent.$on("PointsData", this.setPoints);
    // window.addEventListener("resize", this.resize);

    // this.$on("LineData", this.setLine);
    // this.$on("PointsData", this.setPoints);

    if (window.innerWidth <= 1300) {
      this.layout.margin = {
        l: 60,
        r: 40,
        b: 60,
        t: 20
      }
    }

    if (window.innerWidth <= 600) {
      this.layout.margin = {
        l: 40,
        r: 20,
        b: 60,
        t: 20
      }
    }


    let url = `${window.location.pathname}`
    let langUrl = url.slice(1, 3);
    if(langUrl === 'ru') {
      this.layout.xaxis.title = this.titleXRu
      this.layout.yaxis.title = this.titleYRu
    } else if(langUrl === 'kz') {  
      this.layout.xaxis.title = this.titleXKz
      this.layout.yaxis.title = this.titleYKz
      this.nameKP = "Ағын қисығы"
      this.namePN = "Сорғының қабылдау қысымы"
      this.nameGN = "Газ құрамы"
      this.nameTR = "Ағымдағы  режим"
      this.nameCR = "Мақсатты режим"
      this.namePR = "Потенциалдық  режим"
    } else {
      this.layout.xaxis.title = this.titleXEn
      this.layout.yaxis.title = this.titleYEn
      this.nameKP = "Inflow curve"
      this.namePN = "Intake pressure"
      this.nameGN = "Gas saturation"
      this.nameTR = "Current mode"
      this.nameCR = "Target mode"
      this.namePR = "Potential mode"
    }
 
    

  },
  updated: function() {
    this.$eventBus.$on("newCurveLineData", this.setLine);
    this.$eventBus.$on("newPointsData", this.setPoints);
  }
}
</script>
