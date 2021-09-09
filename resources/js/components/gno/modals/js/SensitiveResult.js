import { Plotly } from "vue-plotly";
import { pgnoMapState, pgnoMapGetters, pgnoMapMutations, pgnoMapActions } from '@store/helpers';
import { globalloadingMutations } from "@store/helpers";

export default {
  name: "sensetive-curve-chart",
  components: {
    Plotly
  },
  computed: {
    ...pgnoMapState([
      'sensetiveSettings',
      'curveSettings',
      'well',
    ]),
  },
  data: function () {
    return {
      apiUrl: process.env.MIX_PGNO_API_URL,              
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
        showlegend: false,
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
    ...globalloadingMutations(["SET_LOADING"]),
    updateGraph (data) {
      this.data = data['lines']

      }
  },
  created: function () {
    this.SET_LOADING(true);
    var payload = {
          well: this.well,
          curve_settings: this.curveSettings,
          sensetive_settings: this.sensetiveSettings
        };
    this.axios.post(this.apiUrl + "fon", payload).then((response) => {
      let data = response.data;
      this.updateGraph(data)
      }).catch((error) => {
      }).finally(() => {
        this.SET_LOADING(false);
      });
  },
}