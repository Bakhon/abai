import Vue from 'vue';
import { Plotly } from "vue-plotly";
import { pgnoMapState, pgnoMapGetters, pgnoMapMutations, pgnoMapActions } from '@store/helpers';

Vue.prototype.$eventBus = new Vue();
export default {
  name: "inflow-curve-chart",
  components: {
    Plotly
  },
  props: ["updateCurveTrigger"],
  computed: {
    ...pgnoMapState([
      'well',
      'lines',
      'points',
    ]),
  },
  data: function () {
    return {              
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
        height: 410,
        margin: {
          l: 100,
          r: 100,
          b: 100,
          t: 30
        },
        xaxis: {
          title: this.trans("pgno.curveXaxisTitle"),
          hoverformat: ".1f",
          rangemode: 'nonnegative',
          gridcolor: "#454D7D",
          linewidth: 1,
          linecolor: "#454D7D"
        },
        yaxis: {
          title: this.trans("pgno.curveYaxisTitle"),
          hoverformat: ".1f",
          rangemode: 'nonnegative',
          showline: true,
          gridcolor: "#454D7D",
          linewidth: 1,
          linecolor: "#454D7D"
        },
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
  watch: { 
    updateCurveTrigger: function() {
      this.updateGraph()
    }
  },
  methods: {
    updateGraph () {
      this.data = [ 
        {
          name: this.trans("pgno.curveBhpLineName"),
          legendgroup: "group1",
          x: this.lines.qlLine,
          y: this.lines.bhpLine,
          text: this.lines.qoilLine,
          hovertemplate: this.trans("pgno.curveBhpLineHover"), 
          marker: {
            x: 20,
            y: 60,
            size: "15",
            color: "#FF0D18",
          },
        },

        {
          name: this.trans("pgno.curvePintakeLineName"),
          legendgroup: "group2",
          x: this.lines.qlLine,
          y: this.lines.pintakeLine,
          hovertemplate: '<b>Pnp = %{y:.1f} атм</b><extra></extra>',
          marker: {
            size: "15",
            color: "#CC6F3C",
          },
        },

        {
          name: this.trans("pgno.curveFreegasLineName"),
          legendgroup: "group3",
          x: this.lines.qlLine,
          y: this.lines.freegasLine,
          yaxis: 'y',
          hovertemplate: this.trans("pgno.curveFreegasHover"), 
          marker: {
            size: "15",
            color: "#237DEB",
          },
        },

        {
          name: this.trans("pgno.curveTargetPointName"),
          legendgroup: "group5",
          x: [this.points.qlCelValue],
          y: [this.points.bhpCelValue],
          text: [this.points.qoCelValue],
          mode: "markers",
          hovertemplate: this.trans("pgno.curveTargetPointHover"),
          marker: {
            size: "15",
            color: "#13B062",
          },
        },

        {
          name: this.trans("pgno.curveCurrentPointName"),
          legendgroup: "group4",
          x: [this.points.ql],
          y: [this.points.bhp],
          text: [this.points.qo],
          mode: "markers",
          hovertemplate: this.trans("pgno.curveCurrentPointHover"),
          marker: {
            size: "15",
            color: "#00A0E3",
          },
        },

        {
          name: this.trans("pgno.curvePotencialPointName"),
          legendgroup: "group6",
          x: [this.points.qlPotencial],
          y: [this.points.bhpPotencial],
          text: [this.points.qOilPotencial],
          mode: "markers",
          hovertemplate: this.trans("pgno.curvePotencialPointHover"),
          marker: {
            size: "6",
            color: "#FBA409",
          },
        },
      ];
      this.chartOptions = {
        labels: this.lines.qlLine,
      };
      this.layout.shapes[0].x0 = this.layout.shapes[0].x1 = this.points.qlPotencial
    },

  },
  mounted() {},
  created: function () {

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
  },
}