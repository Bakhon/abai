import Vue from 'vue';
import { Plotly } from "vue-plotly";
import { PerfectScrollbar } from "vue2-perfect-scrollbar";
import "vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css";
import { pgnoMapState, pgnoMapGetters, pgnoMapMutations, pgnoMapActions } from '@store/helpers';
import {globalloadingMutations} from '@store/helpers';
import NotifyPlugin from "vue-easy-notify";


Vue.component("Plotly", Plotly);
Vue.use(NotifyPlugin);

export default {
  components: { PerfectScrollbar },
  data: function () {
    return {
      apiUrl: process.env.MIX_PGNO_API_URL,
      data() { },
      dls1: "-",
      dls2: "-",
      zu1: "-",
      zu2: "-",
      disabled: false,
      isButtonHpump: false,
      hPump: null,
      hVal: null,
      color: null,
      tmp: null,
      tmp2: null,
      tmp3: null,
      dzArray: null,
      dxArray: null,
      dyArray: null,
      incl: null,
      maxDls: null,
      maxIncl: null,
      dlsGlubina: null,
      inclGlubina: null,
      xArr: null,
      yArr: null,
      zArr: null,
      indexZ: null,
      pointZ: null,
      pointX: null,
      pointY: null,
      chart: null,
      point: null,
      dlsColor: [],
      dls: [],
      xChart: [],
      yChart: [],
      zChart: [],
      layout: {
        showlegend: false,
        plot_bgcolor: "#272953",
        paper_bgcolor: "#2b2e5e",
        margin: {
          l: 0,
          r: 0,
          b: 0,
          t: 0,
          pad: 0
        },
        height: 450,
        gridcolor: "white",
        font: { color: "white" },

        scene: {
          xaxis: {
            title: 'dx',
            range: [0, 0],
            gridcolor: "white",
            zerolinecolor: "white",
            hovertemplate: "<b>Кривая притока</b><br>" +
                "Qж = %{x:.1f} м³/сут<br>" +
                "Qн = %{text:.1f} т/сут<br>" +
                "Pзаб = %{y:.1f} атм<extra></extra>",
          },
          yaxis: {
            title: 'dy',
            range: [0, 0],
            gridcolor: "white",
            zerolinecolor: "white",
            hovertemplate: "<b>Кривая притока</b><br>" +
                "Qж = %{x:.1f} м³/сут<br>" +
                "Qн = %{text:.1f} т/сут<br>" +
                "Pзаб = %{y:.1f} атм<extra></extra>",
          },
          zaxis: {
            title: 'md',
            gridcolor: "white",
            zerolinecolor: "white",
            hovertemplate: "<b>Кривая притока</b><br>" +
                "Qж = %{x:.1f} м³/сут<br>" +
                "Qн = %{text:.1f} т/сут<br>" +
                "Pзаб = %{y:.1f} атм<extra></extra>",
          },

        }
      }

    }

  },
  computed: {
    ...pgnoMapState([
      'well',
      'shgnSettings',
      'curveSettings',
      'analysisSettings',
      'inclinometry',
      'centralizer',
      'centralizer_range',
    ]),
    ...pgnoMapGetters([
      'hPumpIncl'
    ]),
  },
  methods: {
    ...globalloadingMutations([
      'SET_LOADING'
      ]),
    ...pgnoMapActions([
      'getInclinometry',
      'sethPumpValue'
    ]),
    closestVal(num, arr) {
      var curr = arr[0],
          diff = Math.abs(num - curr),
          index = 0;
      for (var val = 0; val < arr.length; val++) {
        let newdiff = Math.abs(num - arr[val]);
        if (newdiff < diff) {
          diff = newdiff;
          curr = arr[val];
          index = val;
        }
      }
      return index
    },

    async buildModel() {
      this.SET_LOADING(true);
      this.xChart = []
      this.yChart = []
      this.zChart = []
      this.dls = []
      this.dlsColor = []
      var payload = {}
      payload.url = `${this.apiUrl}inclinometry/${this.well.fieldUwi}/${this.well.wellUwi}`
      payload.data = {
        "expMeth": this.curveSettings.expChoosen,
        "hPumpSet": this.hPump,
        "inclinometryStep": this.shgnSettings.inclStep,
        "calculateMethod": this.stepCalc,
      }
      await this.getInclinometry(payload)
      for(let [key, value] of Object.entries(this.inclinometry)) {

        this.xChart.push(value['dx'])
        this.yChart.push(value['dy'])
        this.zChart.push(value['md'])
        this.dls.push(value['dls'])
        this.dlsColor.push(value['dls_color'])
      }
      var indexHpump = this.closestVal(this.hPump, this.zChart)
      var pointZ = this.zChart[indexHpump]
      var pointX = this.xChart[indexHpump]
      var pointY = this.yChart[indexHpump]
      var maxX = Math.max(...this.xChart.map(a => Math.abs(a)))
      var maxY = Math.max(...this.yChart.map(a => Math.abs(a)))

      if (maxX < 50 && maxY < 50) {
        this.layout['scene']['xaxis']['range'][0] = 50
        this.layout['scene']['xaxis']['range'][1] = -50
        this.layout['scene']['yaxis']['range'][0] = 50
        this.layout['scene']['yaxis']['range'][1] = -50
      } else {
        this.layout['scene']['xaxis']['range'][0] = maxX * 1.5
        this.layout['scene']['xaxis']['range'][1] = maxX * -1.5
        this.layout['scene']['yaxis']['range'][0] = maxY * 1.5
        this.layout['scene']['yaxis']['range'][1] = maxY * -1.5
      }

      this.chart = [{
        type: 'scatter3d',
        mode: 'lines',
        x: this.xChart,
        y: this.yChart,
        z: this.zChart.map(x => x * -1),
        text: this.dls,
        hovertemplate:
            "MD = %{z:.1f} м<br>" +
            "DLS = %{text:.1f} гр/10м<extra></extra>",
        opacity: 1,
        line: {
          width: 12,
          color: this.dlsColor,
          colorscale: [[0, 'rgb(0,0,255)'], [1, 'rgb(255,0,0)']],
          type: 'heatmap'
        },
      }, {
        type: 'scatter3d',
        mode: 'markers',
        hovertemplate:
            "Насос <br>" +
            "MD = %{z:.1f} м<br>",
        name: '',
        x: [pointX],
        y: [pointY],
        z: [pointZ * -1],
        marker: {
          size: 10,
          color: '#AFCFEA',
        }
      }
      ],
      this.point = []
      this.SET_LOADING(false);
    },
    async onClickHpump() {
      await this.sethPumpValue(this.hPump)
      this.$emit('update-hpump');
    }
  },
  mounted() {
  },
  created: function () {
    this.hPump = this.curveSettings.hPumpValue
    this.buildModel()
  }
}
