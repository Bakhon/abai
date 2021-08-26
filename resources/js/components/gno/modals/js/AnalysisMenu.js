import {pgnoMapState, pgnoMapGetters, pgnoMapMutations, pgnoMapActions} from '@store/helpers';
import {globalloadingMutations} from '@store/helpers';
import {Plotly} from "vue-plotly";
import Vue from 'vue';

Vue.prototype.$eventBus = new Vue();
export default {
    components: {Plotly},
    data: function () {
        return {
            apiUrl: process.env.MIX_PGNO_API_URL,
            name: "analysis-menu",
            settings: {
                analysisOld: [
                    "analysisOldPres",
                    "analysisOldHdyn",
                    "analysisOldBhp",
                    "analysisOldQlAsma",
                    "analysisOldWctAsma",
                    "analysisOldGorAsma",],
                analysisNew: [
                    "analysisNewPres",
                    "analysisNewPi",
                    "analysisNewBhp",
                ],
                nearDist: 1000,
                hasGrp: false,
            },
            layout: {
                shapes: [{
                    type: 'line',
                    yref: 'paper',
                    x0: [],
                    y0: 0,
                    x1: [],
                    y1: 100,
                    line: {
                        color: 'orange',
                        width: 1,
                        dash: 'dot'
                    }
                }],
                height: 360,
                showlegend: true,
                margin: {
                    l: 50,
                    r: 50,
                    b: 80,
                    t: 30
                },
                xaxis: {
                    autorange: true,
                    title: "",
                    hoverformat: ".1f",
                    zeroline: false,
                    gridcolor: "#123E73",
                    rangemode: "nonnegative"
                },
                yaxis: {
                    autorange: true,
                    title: "",
                    hoverformat: ".1f",
                    showlegend: true,
                    zeroline: false,
                    gridcolor: "#123E73",
                    rangemode: "nonnegative"
                },

                paper_bgcolor: "#2B2E5E",
                plot_bgcolor: "#2B2E5E",
                font: {color: "#fff"},

                legend: {
                    orientation: "h",
                    y: -0.3,
                    font: {
                        size: 9.3,
                        color: "#fff",
                    },
                },
            },
            data: [],
            chartOptions: {}
        }
    },
    computed: {
        ...pgnoMapState([
            'well',
            'lines',
            'points',
            'wellAnalysis',
            'linesAnalysis',
            'pointsAnalysis',
            'curveSettings',
        ]),
        ...pgnoMapGetters([
            'shgnSettings'
        ]),
    },
    methods: {
        ...globalloadingMutations([
            'SET_LOADING'
            ]),
        ...pgnoMapActions([
            "postAnalysis",
            "updateWell",
            "setAnalysisSettings"
        ]),
        async updateGraph() {
            this.SET_LOADING(true);
            var payload = {}
            payload.url = this.apiUrl + "analysis"
            payload.data = {
                "shgn_settings": this.shgnSettings,
                "well": this.well,
                "curve_settings": this.curveSettings,
                "analysis_settings": this.settings,
              }
            await this.postAnalysis(payload)
            this.data = [ 
              {
                name: this.trans("pgno.curveMainLineName"),
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
                name: this.trans("pgno.curveAnalysisLineName"),
                x: this.linesAnalysis.qlLine,
                y: this.linesAnalysis.bhpLine,
                text: this.linesAnalysis.qoilLine,
                hovertemplate: this.trans("pgno.curveBhpLineHover"), 
                marker: {
                  x: 20,
                  y: 60,
                  size: "15",
                  color: "#237DEB",
                },
              },
              {
                name: this.trans("pgno.curveCurrentPointName"),
                x: [this.pointsAnalysis.ql],
                y: [this.pointsAnalysis.bhp],
                text: [this.pointsAnalysis.qo],
                mode: "markers",
                hovertemplate: this.trans("pgno.curveCurrentPointHover"),
                marker: {
                  size: "15",
                  color: "#00A0E3",
                },
              },
              {
                name: this.trans("pgno.curvePotencialPointName"),
                x: [this.pointsAnalysis.qlPotencial],
                y: [this.pointsAnalysis.bhpPotencial],
                text: [this.pointsAnalysis.qOilPotencial],
                mode: "markers",
                hovertemplate: this.trans("pgno.curvePotencialPointHover"),
                marker: {
                  size: "10",
                  color: "#FBA409",
                },
              },
            ];
            this.chartOptions = {
              labels: this.lines.qlLine,
            };
            this.layout.shapes[0].x0 = this.layout.shapes[0].x1 = this.pointsAnalysis.qlPotencial
            this.SET_LOADING(false);
          },
        changeAnalysisSettings() {
            var payload = {}
            payload.wellAnalysis = this.wellAnalysis
            payload.linesAnalysis = this.linesAnalysis
            payload.pointsAnalysis = this.pointsAnalysis
            this.updateWell(payload)
            this.setAnalysisSettings(this.settings)
            this.$emit('clicked', "settings")
        },
        openNearWellsModal() {
            this.$modal.show("modalNearWells");
        },
    },
    mounted() {
    },
    created: function () {
        if (window.innerWidth <= 1300) {
            this.layout.margin = {
                l: 60,
                r: 40,
                b: 60,
                t: 20,
            };
        }

        if (window.innerWidth <= 600) {
            this.layout.margin = {
                l: 40,
                r: 20,
                b: 60,
                t: 20,
            };
        }

        let langUrl = `${window.location.pathname}`.slice(1, 3);
        if (langUrl === 'ru') {
            this.titleXRu = "Дебит жидкости, м³/сут.",
                this.titleXKz = "Сұйықтық дебиті, м³/тәул.",
                this.titleXEn = "Liquid flow rate, м³/d.",
                this.titleYRu = "Давление, атм/газосодержание, %",
                this.titleYKz = "Қысым, атм / газ құрамы, %",
                this.titleYEn = "Pressure, atm/GVF, %",
                this.nameKPP = "Кривая притока (пользователь)",
                this.nameKPA = "Кривая притока (анализ)",
                this.nameTR = "Текущий режим",
                this.namePR = "Потенциальный режим",
                this.titleXRu = "Дебит жидкости, м³/сут.",
                this.titleXKz = "Сұйықтық дебиті, м³/тәул.",
                this.titleXEn = "Liquid flow rate, м³/d.",
                this.titleYRu = "Давление, атм/газосодержание, %",
                this.titleYKz = "Қысым, атм / газ құрамы, %",
                this.titleYEn = "Pressure, atm/gas saturation, %",
                this.hovertemplateKPP = "<b>Кривая притока (пользователь)</b><br>" +
                    "Qж = %{x:.1f} м³/сут<br>" +
                    "Qн = %{text:.1f} т/сут<br>" +
                    "Pзаб = %{y:.1f} атм<extra></extra>",
                this.hovertemplateKPA = "<b>Кривая притока (анализ)</b><br>" +
                    "Qж = %{x:.1f} м³/сут<br>" +
                    "Qн = %{text:.1f} т/сут<br>" +
                    "Pзаб = %{y:.1f} атм<extra></extra>",
                this.hovertemplateTR = "<b>Текущий режим</b><br>" +
                    "Qж = %{x:.1f} м³/сут<br>" +
                    "Qн = %{text:.1f} т/сут<br>" +
                    "Pзаб = %{y:.1f} атм<extra></extra>",
                this.hovertemplatePR = "<b>Потенциальный режим</b><br>" +
                    "Qж = %{x:.1f} м³/сут<br>" +
                    "Qн = %{text:.1f} т/сут<br>" +
                    "Pзаб = %{y:.1f} атм<extra></extra>",
                this.layout.xaxis.title = this.titleXRu
            this.layout.yaxis.title = this.titleYRu
        } else if (langUrl === 'kz') {
            this.layout.xaxis.title = this.titleXKz
            this.layout.yaxis.title = this.titleYKz
            this.nameKPP = "Ағын қисығы (қолданушы)"
            this.nameKPA = "Ағын қисығы (талдау)"
            this.namePN = "Сорғының қабылдау қысымы"
            this.nameGN = "Газ құрамы"
            this.nameTR = "Ағымдағы  режим"
            this.nameCR = "Мақсатты режим"
            this.namePR = "Потенциалдық  режим"
            this.hovertemplateKPP = "<b>Ағын қисығы (қолданушы)</b><br>" +
                "Qж = %{x:.1f} м³/сут<br>" +
                "Qн = %{text:.1f} т/сут<br>" +
                "Pзаб = %{y:.1f} атм<extra></extra>",
                this.hovertemplateKPA = "<b>Ағын қисығы (талдау)</b><br>" +
                    "Qж = %{x:.1f} м³/сут<br>" +
                    "Qн = %{text:.1f} т/сут<br>" +
                    "Pзаб = %{y:.1f} атм<extra></extra>",
                this.hovertemplateTR = "<b>Ағымдағы  режим</b><br>" +
                    "Qж = %{x:.1f} м³/сут<br>" +
                    "Qн = %{text:.1f} т/сут<br>" +
                    "Pзаб = %{y:.1f} атм<extra></extra>",
                this.hovertemplatePR = "<b>Потенциалдық  режим</b><br>" +
                    "Qж = %{x:.1f} м³/сут<br>" +
                    "Qн = %{text:.1f} т/сут<br>" +
                    "Pзаб = %{y:.1f} атм<extra></extra>"
        } else {
            this.layout.xaxis.title = this.titleXEn
            this.layout.yaxis.title = this.titleYEn
            this.nameKPP = "Inflow curve (user)"
            this.nameKPA = "Inflow curve (analys)"
            this.namePN = "Intake pressure"
            this.nameGN = "Gas saturation"
            this.nameTR = "Current mode"
            this.nameCR = "Target mode"
            this.namePR = "Potential mode",
                this.hovertemplateKPP = "<b>Inflow curve (user)</b><br>" +
                    "Qж = %{x:.1f} м³/сут<br>" +
                    "Qн = %{text:.1f} т/сут<br>" +
                    "Pзаб = %{y:.1f} атм<extra></extra>",
                this.hovertemplateKPA = "<b>Inflow curve (analys)</b><br>" +
                    "Qж = %{x:.1f} м³/сут<br>" +
                    "Qн = %{text:.1f} т/сут<br>" +
                    "Pзаб = %{y:.1f} атм<extra></extra>",
                this.hovertemplateTR = "<b>Current mode</b><br>" +
                    "Qж = %{x:.1f} м³/сут<br>" +
                    "Qн = %{text:.1f} т/сут<br>" +
                    "Pзаб = %{y:.1f} атм<extra></extra>",
                this.hovertemplatePR = "<b>Potential mode</b><br>" +
                    "Qж = %{x:.1f} м³/сут<br>" +
                    "Qн = %{text:.1f} т/сут<br>" +
                    "Pзаб = %{y:.1f} атм<extra></extra>"
        }
        this.updateGraph()
    },
}
