import {Plotly} from "vue-plotly";
import {eventBus} from "../../event-bus.js";
import NotifyPlugin from "vue-easy-notify";
import 'vue-easy-notify/dist/vue-easy-notify.css';
import {VueMomentLib} from "vue-moment-lib";
import moment from "moment";
import Vue from 'vue';

Vue.prototype.$eventBus = new Vue();


Vue.use(NotifyPlugin, VueMomentLib);
Vue.component("Plotly", Plotly);

export default {
  data: function () {
    return {

      activeRightTabName: 'technological-mode',
      layout: {
        width: 950,
        height: 450,
        showlegend: true,
        xaxis: {
          title: "Дебит, Qж, м³/сут.",
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
        font: {color: "#fff"},

        legend: {
          orientation: "h",
          y: -0.3,
          font: {
            size: 12,
            color: "#fff",
          },
        },
      },

      data: [
        {
          name: "IPR (кривая притока)",
          x: [0, 1, 3],
          y: [0, 1, 3],

          marker: {
            size: "15",
            color: "#FF0D18",
          },
        },
      ],
      bhpPot: null,
      qlPot: null,
      pinPot: null,
      visibleChart: true,
      stroke_len: null,
      qOil: null,
      shgnPumpType: null,
      shgnSPM: null,
      shgnLen: null,
      shgnS1D: null,
      shgnS2D: null,
      shgnS1L: null,
      shgnS2L: null,
      shgnTNL: null,
      shgnTNL: null,
      hPerfND: null,
      type: String,
      required: true,
      wellNumber: null,
      age: false,
      horizon: null,
      x: null,
      y: null,
      wctOkr: null,
      expMeth: null,
      tseh: null,
      gu: null,
      casOD: null,
      casID: null,
      hPerf: null,
      udl: null,
      pumpType: null,
      hPumpSet: null,
      tubOD: null,
      tubID: null,
      stopDate: null,
      PBubblePoint: null,
      gor: null,
      tRes: null,
      viscOilRc: null,
      viscWaterRc: null,
      densOil: null,
      densWater: null,
      qO: null,
      wct: null,
      bhp: null,
      pRes: null,
      hDyn: null,
      pAnnular: null,
      whp: null,
      lineP: null,
      piInput: null,
      pplInput: null,
      pResInput: null,
      qLInput: null,
      wctInput: null,
      gorInput: null,
      bhpInput: null,
      hDynInput: null,
      pAnnularInput: null,
      pManomInput: null,
      hPumpManomInput: null,
      whpInput: null,
      hPumpValue: null,
      curveSelect: 'pi',
      curveValue: '',
      curr: null,
      expChoose: null,
      CelButton: 'ql',
      bhpCurveButton: '',
      qlCelValue: null,
      bhpCelValue: null,
      piCelValue: null,
      expID: null,
      CelValue: null,
      analysisBox1: true,
      analysisBox2: true,
      analysisBox3: true,
      analysisBox4: true,
      analysisBox5: true,
      analysisBox6: true,
      analysisBox7: true,

      analysisBox8: true,
      menu: "MainMenu",
      ngdu: 0,
      sk: 0,
      grp_skin: false,
      newData: null,
      expAnalysisData: {
        NNO1: null,
        NNO2: null,
        prs1: null,
        prs2: null,
        qoilEcn: null,
        qoilShgn: null,
        shgnParam: null,
        ecnParam: null,
        ecnNpv: null,
        shgnNpv: null,
        npvTable1: {},
        npvTable2: {},
      },
      qZhExpEcn: null,
      qOilExpEcn: null,
      qZhExpShgn: null,
      qOilExpShgn: null,
      param_eco: null,

      field: "UZN",
      wellIncl: null,
      dataNNO: "2020-11-01",

    };

  },

  methods: {
    setData: function (data) {
      if (this.method == "CurveSetting") {
        this.pResInput = data["Well Data"]["p_res"][0]
        this.piInput = data["Well Data"]["pi"][0].toFixed(2)
        this.qLInput = data["Well Data"]["q_l"][0].toFixed(0)
        this.wctInput = data["Well Data"]["wct"][0]
        this.gorInput = data["Well Data"]["gor"][0]
        this.bhpInput = data["Well Data"]["bhp"][0].toFixed(0)
        this.hDynInput = data["Well Data"]["h_dyn"][0].toFixed(0)
        this.pAnnularInput = data["Well Data"]["p_annular"][0].toFixed(0)
        this.qlCelValue = JSON.parse(data.PointsData)["data"][2]["q_l"]
        this.bhpCelValue = JSON.parse(data.PointsData)["data"][2]["p"].toFixed(0)
        this.piCelValue = JSON.parse(data.PointsData)["data"][2]["pin"].toFixed(0)
        this.whpInput = data["Well Data"]["whp"][0].toFixed(0)
        this.curveLineData = JSON.parse(data.LineData)["data"]
        this.curvePointsData = JSON.parse(data.PointsData)["data"]
        this.qOil = this.curvePointsData[2]["q_oil"].toFixed(0)
        this.bhpPot = this.curvePointsData[1]["p"].toFixed(0)
        this.qlPot = this.curvePointsData[1]["q_l"].toFixed(0)
        this.pinPot = this.curvePointsData[1]["pin"].toFixed(0)
      } else {
        this.ngdu = data["Well Data"]["ngdu"][0]
        this.sk = data["Well Data"]["sk_type"][0]
        this.wellNumber = data["Well Data"]["well"][0].split("_")[1]
        this.age = data["Age"]
        this.horizon = data["Well Data"]["horizon"][0]
        this.expMeth = data["Well Data"]["exp_meth"][0]
        this.tseh = data["Well Data"]["tseh"][0]
        this.gu = data["Well Data"]["gu"][0]
        this.stroke_len = data["Well Data"]["stroke_len"][0]
        this.casOD = data["Well Data"]["cas_OD"][0]
        this.casID = data["Well Data"]["cas_ID"][0]
        this.hPerf = data["Well Data"]["h_up_perf_vd"][0]
        this.udl = data["udl"].toFixed(1)
        this.hPumpSet = data["Well Data"]["h_pump_set"][0]
        this.tubOD = data["Well Data"]["tub_OD"][0]
        this.tubID = data["Well Data"]["tub_ID"][0]
        this.stopDate = data["Well Data"]["stop_date"][0]
        this.pumpType = data["Well Data"]["pump_type"][0]
        this.PBubblePoint = data["Well Data"]["P_bubble_point"][0].toFixed(2)
        this.gor = data["Well Data"]["gor"][0].toFixed(0)
        this.tRes = data["Well Data"]["t_res"][0].toFixed(2)
        this.viscOilRc = data["Well Data"]["visc_oil_rc"][0].toFixed(2)
        this.viscWaterRc = data["Well Data"]["visc_wat_rc"][0].toFixed(2)
        this.densOil = data["Well Data"]["dens_oil"][0].toFixed(2)
        this.densWater = data["Well Data"]["dens_liq"][0].toFixed(2)
        this.qL = data["Well Data"]["q_l"][0].toFixed(0)
        this.qO = data["Well Data"]["q_o"][0].toFixed(0)
        this.wct = data["Well Data"]["wct"][0].toFixed(0)
        this.bhp = data["Well Data"]["bhp"][0].toFixed(0)
        this.pRes = data["Well Data"]["p_res"][0].toFixed(0)
        this.hDyn = data["Well Data"]["h_dyn"][0].toFixed(0)
        this.pAnnular = data["Well Data"]["p_annular"][0].toFixed(0)
        this.whp = data["Well Data"]["whp"][0].toFixed(0)
        this.lineP = data["Well Data"]["line_p"][0].toFixed(0)
        this.piInput = data["Well Data"]["pi"][0].toFixed(2)
        this.curr = data["Well Data"]["curr_bh"][0].toFixed(0)
        this.piCelValue = JSON.parse(data.PointsData)["data"][0]["pin"].toFixed(0)
        this.bhpCelValue = JSON.parse(data.PointsData)["data"][0]["p"].toFixed(0)
        this.wellIncl = data["Well Data"]["well"][0]
        this.hPerfND = data["Well Data"]["h_perf"][0]


        this.stopDate = this.stopDate.substring(0, 10)
        this.pResInput = this.pRes
        this.qLInput = this.qL
        this.wctInput = this.wct
        this.gorInput = this.gor
        this.bhpInput = this.bhp
        this.hDynInput = this.hDyn
        this.pAnnularInput = this.pAnnular
        this.pManomInput = data["Well Data"]["p_intake"][0]
        this.hPumpManomInput = data["Well Data"]["h_pump_set"][0]
        this.whpInput = this.whp
        this.qlCelButton = true
        this.qlCelValue = this.qLInput * 1
        this.hPumpValue = this.hPumpSet


        if (this.expMeth == "ШГН") {
          this.expChoose = "ШГН"
        } else {
          this.expChoose = "ЭЦН"
        }
        if (this.age === true) {
          this.curveSelect = 'pi'
        } else {
          this.curveSelect = 'hdyn'
        }

        this.piButton = true
        this.curveLineData = JSON.parse(data.LineData)["data"]
        this.curvePointsData = JSON.parse(data.PointsData)["data"]
        this.qOil = this.curvePointsData[2]["q_oil"]
        this.bhpPot = this.curvePointsData[1]["p"].toFixed(0)
        this.qlPot = this.curvePointsData[1]["q_l"].toFixed(0)
        this.pinPot = this.curvePointsData[1]["pin"].toFixed(0)
      }
    },
    setLine: function (value) {
      console.log(value)
      var ipr_points = [];
      var qo_points = [];
      var value2 = [];
      var ipr_points2 = [];
      var qo_points2 = [];
      var q_oil = [];
      var q_oil2 = [];


      _.forEach(value, function (values) {
        ipr_points = values.ipr_points;
        qo_points = values.qo_points;
        q_oil = values.q_oil
        ipr_points2.push(ipr_points);
        qo_points2.push("" + qo_points + "");
        q_oil2.push(q_oil);
      });

      this.data = [
        {
          name: "IPR (кривая притока)",
          x: qo_points2,
          y: ipr_points2,
          text: q_oil2,
          hovertemplate: "<b>IPR (кривая притока)</b><br>" +
            "Qж = %{x:.1f} м³/сут<br>" +
            "Qн = %{text:.1f} т/сут<br>" +
            "Pзаб = %{y:.1f} атм<extra></extra>",

          marker: {
            size: "15",
            color: "#FF0D18",
          },
        },
        {
          name: "Текущий режим",
          x: [],
          y: [],
          text: [],
          mode: "markers",
          hovertemplate: "<b>Текущий режим</b><br>" +
            "Qж = %{x:.1f} м³/сут<br>" +
            "Qн = %{text:.1f} т/сут<br>" +
            "Pзаб = %{y:.1f} атм<extra></extra>",
          marker: {
            size: "15",
            color: "#00A0E3",
          },
        },

        {
          name: "Потенциальный режим",
          x: [],
          y: [],
          text: [],
          mode: "markers",
          hovertemplate: "<b>Потенциальный режим</b><br>" +
            "Qж = %{x:.1f} м³/сут<br>" +
            "Qн = %{text:.1f} т/сут<br>" +
            "Pзаб = %{y:.1f} атм<extra></extra>",
          marker: {
            size: "15",
            color: "#FBA409",
          },
        },
        {
          name: "New Line",
          x: [],
          y: [],
          text: [],
          hovertemplate: "<b>New Line</b><br>" +
            "Qж = %{x:.1f} м³/сут<br>" +
            "Qн = %{text:.1f} т/сут<br>" +
            "Pзаб = %{y:.1f} атм<extra></extra>",

          marker: {
            size: "15",
            color: "#237DEB",
          },
        },
      ];
      this.chartOptions = {
        labels: qo_points2,
      };
    },
    updateLine: function (value) {
      var ipr_points = [];
      var qo_points = [];
      var ipr_points2 = [];
      var qo_points2 = [];
      var q_oil = [];
      var q_oil2 = [];

      _.forEach(value, function (values) {
        ipr_points = values.ipr_points;
        qo_points = values.qo_points;
        q_oil = values.q_oil
        ipr_points2.push(ipr_points);
        qo_points2.push("" + qo_points + "");
        q_oil2.push(q_oil)
      });
      this.data[3]['x'] = qo_points2
      this.data[3]['y'] = ipr_points2
      this.data[3]['text'] = q_oil2
      console.log(JSON.stringify(this.data[0]['x']) == JSON.stringify(this.data[3]['x']))
      if (JSON.stringify(this.data[0]['x']) == JSON.stringify(this.data[3]['x']) && JSON.stringify(this.data[0]['y']) == JSON.stringify(this.data[3]['y'])) {
        this.data[3]['x'] = []
        this.data[3]['y'] = []
        this.data[3]['text'] = []
      }
    },
    setPoints: function (value) {
      this.data[1]['x'][0] = value[0]["q_l"]
      this.data[1]['y'][0] = value[0]["p"]
      this.data[1]['text'][0] = value[0]["q_oil"]
      this.data[2]['x'][0] = value[1]["q_l"]
      this.data[2]['y'][0] = value[1]["p"]
      this.data[2]['text'][0] = value[1]["q_oil"]

    },
    PotAnalysisMenu() {
      this.postCurveData()
      this.setLine(this.curveLineData)
      this.setPoints(this.curvePointsData)
      if (this.age) {
        this.postAnalysisNew();
        this.$modal.show('modalNewWell');
      } else {
        this.postAnalysisOld();
        this.$modal.show('modalOldWell');
      }
    },

    ExpAnalysisMenu() {
      if (this.casID == 114) {
        Vue.prototype.$notifyError('В ЭК 114мм применение УЭЦН с габаритами 5 и 5А невозможно')
      }
      this.NnoCalc()
      this.qZhExpEcn = this.qlCelValue
      this.qOilExpEcn = this.qlCelValue * (1 - (this.wctInput / 100)) * this.densOil

      if (this.qlCelValue < 106) {
        this.qZhExpShgn = this.qlCelValue
        this.qOilExpShgn = this.qlCelValue * (1 - (this.wctInput / 100)) * this.densOil

      } else {
        this.qZhExpShgn = 106
        this.qOilExpShgn = 106 * (1 - (this.wctInput / 100)) * this.densOil
      }

      this.expAnalysisData.qoilShgn = this.qOilExpShgn
      this.expAnalysisData.qoilEcn = this.qOilExpEcn

      if (this.expAnalysisData.NNO1 != null) {
        this.EconomParam();
      }


    },
    EconomParam() {
      var prs1 = this.expAnalysisData.prs1
      var prs2 = this.expAnalysisData.prs2

      var nnoDayUp = moment(this.dataNNO, 'YYYY-MM-DD').toDate()
      var nnoDayFrom = moment(this.stopDate, 'YYYY-MM-DD').toDate()

      var date_diff = (nnoDayUp - nnoDayFrom) / (1000 * 3600 * 24)

      if (date_diff > 365) {
        date_diff = date_diff - 365
      }

      console.log('data', date_diff)

      if (prs1 != 0 && prs2 != 0) {
        this.param_eco = 1;
        this.EconomCalc();
      } else if (prs1 == 0 && prs2 == 0) {
        if (this.age) {
          this.param_eco = 1;
          this.EconomCalc()
        } else {
          if (this.expChoose == "ШГН") {
            this.expAnalysisData.NNO1 = date_diff
            this.param_eco = 1;
            this.EconomCalc()
          } else {
            this.expAnalysisData.NNO2 = date_diff
            this.param_eco = 1;
            this.EconomCalc()
          }
        }
      } else if (prs1 == 0 && prs2 != 0) {
        this.param_eco = 2;
        this.EconomCalc();
      } else {
        this.param_eco = 3;
        this.EconomCalc();
      }
    },
    EconomCalc() {
      let uri2 = "/ru/nnoeco?equip=1&org=5&param=" + this.param_eco + "&qo=" + this.qOilExpShgn + "&qzh=" + this.qZhExpShgn + "&reqd=" + this.expAnalysisData.NNO1 + "&reqecn=" + this.expAnalysisData.prs1 + "&scfa=%D0%A4%D0%B0%D0%BA%D1%82&start=2021-01-21";
      this.axios.get(uri2).then((response) => {
        let data = response.data;
        if (data) {

          this.expAnalysisData.shgnParam = data[12].godovoiShgnParam
          this.expAnalysisData.shgnNpv = data[12].npv
          this.expAnalysisData.npvTable1 = data[12]
        } else {
          console.log('No data');
        }
      });

      let uri3 = "/ru/nnoeco?equip=2&org=5&param=" + this.param_eco + "&qo=" + this.qOilExpEcn + "&qzh=" + this.qZhExpEcn + "&reqd=" + this.expAnalysisData.NNO2 + "&reqecn=" + this.expAnalysisData.prs2 + "&scfa=%D0%A4%D0%B0%D0%BA%D1%82&start=2021-01-21";
      this.axios.get(uri3).then((response) => {
        let data2 = response.data;
        if (data2) {

          this.expAnalysisData.ecnParam = data2[12].godovoiEcnParam
          this.expAnalysisData.ecnNpv = data2[12].npv
          this.expAnalysisData.npvTable2 = data2[12]

          if (this.qOilExpShgn != null && this.qOilExpEcn != null && this.expAnalysisData.NNO1 != null && this.expAnalysisData.NNO2 != null && this.expAnalysisData.shgnParam != null && this.expAnalysisData.shgnNpv != null && this.expAnalysisData.ecnParam != null && this.expAnalysisData.ecnNpv != null) {
            this.$modal.show("modalExpAnalysis");
          }

        } else {
          console.log('No data');
        }
      });
    },
    NnoCalc() {
      let uri = "http://172.20.103.187:7575/api/nno/";

      this.eco_param = null;

      this.qZhExpEcn = this.qlCelValue
      this.qOilExpEcn = this.qlCelValue * (1 - (this.wctInput / 100)) * this.densOil

      if (this.qlCelValue < 106) {
        this.qZhExpShgn = this.qlCelValue
        this.qOilExpShgn = this.qlCelValue * (1 - (this.wctInput / 100)) * this.densOil

      } else {
        this.qZhExpShgn = 106
        this.qOilExpShgn = 106 * (1 - (this.wctInput / 100)) * this.densOil
      }

      let jsonData = JSON.stringify(
        {
          "well_number": this.wellNumber,
          "exp_meth": "ШГН",
        }
      )

      let jsonData2 = JSON.stringify(
        {
          "well_number": this.wellNumber,
          "exp_meth": "ЭЦН",
        }
      )

      let jsonData3 = JSON.stringify(
        {
          "well_number": this.wellNumber,
          "exp_meth": "УЭЦН",

        }
      )

      //microservise na SHGN NNO
      this.axios.post(uri, jsonData).then((response) => {
        var data = JSON.parse(response.data.Result)
        if (data) {
          this.expAnalysisData.NNO1 = data.NNO
          this.expAnalysisData.qoilShgn = this.qOilExpShgn
          this.expAnalysisData.prs1 = data.prs
        } else {
          console.log("No data");
        }
      });

      //microservise na ECN NNO
      this.axios.post(uri, jsonData2).then((response) => {
        var data = JSON.parse(response.data.Result)
        if (data) {
          this.expAnalysisData.NNO2 = data.NNO
          this.expAnalysisData.qoilEcn = this.qOilExpEcn
          this.expAnalysisData.prs2 = data.prs
        } else {
          console.log("No data");
        }
      });
    },
    // PgnoMenu() {

    // },
    InclMenu() {
      if (this.age === true) {
        Vue.prototype.$notifyWarning("Данные инклинометрии новой скважины отсутствуют");

      } else {
        this.$modal.show('modalIncl')
      }
    },

    getWellNumber(wellnumber) {
      this.visibleChart = true;
      let uri = "http://172.20.103.187:7575/api/pgno/" + this.field + "/" + wellnumber + "/";
      this.axios.get(uri).then((response) => {
          var data = response.data;
          this.method = 'MainMenu'
          if (data["Error"] === "NoData") {
            Vue.prototype.$notifyError("Указанная скважина отсутствует");

            this.curveLineData = JSON.parse(data.LineData)["data"]
            this.curvePointsData = JSON.parse(data.PointsData)["data"]
            this.ngdu = 0
            this.sk = 0

            //Выбор скважины
            this.horizon = 0;
            this.expMeth = 0;
            this.tseh = 0;
            this.gu = 0;
            this.curr = 0;

            // Конструкция
            this.casOD = 0;
            this.casID = 0;
            this.hPerf = 0;
            this.udl = 0;

            //PVT
            this.PBubblePoint = 0;
            this.gor = 0;
            this.tRes = 0;
            this.densOil = 0;
            this.viscOilRc = 0;
            this.viscWaterRc = 0;
            this.densWater = 0;
            this.hdynValue = [this.hDynInput = 0, this.pAnnularInput = 0];

            //Оборудование
            this.pumpType = 0;
            this.hPumpSet = 0;
            this.tubOD = 0;
            this.tubID = 0;
            this.stopDate = 0;

            //Технологический  режим
            this.qL = 0;
            this.qO = 0;
            this.wct = 0;
            this.bhp = 0;
            this.pRes = 0;
            this.hDyn = 0;
            this.pAnnular = 0;
            this.whp = 0;
            this.lineP = 0;

            //Настройка кривой притока
            this.pResInput = 0;
            this.piInput = 0;
            this.qLInput = 0;
            this.bhpInput = 0;
            this.wctInput = 0;
            this.gorInput = 0;
            this.hDynInput = 0;
            this.pAnnularInput = 0;
            this.hPumpManomInput = 0;
            this.whpInput = 0;

            //Параметры подбора
            this.hPumpValue = 0;
            this.qlCelValue = 0;
            this.bhpCelValue = 0;
            this.piCelValue = 0;


          } else if (data["Age"] === true) {


            this.curveLineData = JSON.parse(data.LineData)["data"]
            this.curvePointsData = JSON.parse(data.PointsData)["data"]
            this.horizon = data["Well Data"]["horizon"][0]
            this.curveSelect = 'pi'
            this.age = data["Age"]


            this.PBubblePoint = data["Well Data"]["P_bubble_point"][0].toFixed(1)
            this.gor = data["Well Data"]["gor"][0].toFixed(1)
            this.tRes = data["Well Data"]["t_res"][0].toFixed(1)
            this.viscOilRc = data["Well Data"]["visc_oil_rc"][0].toFixed(1)
            this.viscWaterRc = data["Well Data"]["visc_wat_rc"][0].toFixed(1)
            this.densOil = data["Well Data"]["dens_oil"][0].toFixed(1)
            this.densWater = data["Well Data"]["dens_liq"][0].toFixed(1)
            this.hPumpValue = data["Well Data"]["h_pump_set"][0].toFixed(1)


            Vue.prototype.$notifyWarning("Новая скважина");

            Vue.prototype.$notifyWarning("Нсп установлено на 150м выше ВДП по умолчанию")

            this.ngdu = 0
            this.sk = 0

            //Выбор скважины
            this.expMeth = 0;
            this.tseh = 0;
            this.gu = 0;
            this.curr = 0;

            // Конструкция
            this.casOD = 168;
            this.casID = 150;
            this.hPerf = data["Well Data"]["h_up_perf_vd"][0].toFixed(0);
            this.udl = 0;

            //Оборудование
            this.pumpType = 0;
            this.hPumpSet = 0
            this.tubOD = 73;
            this.tubID = 62;
            this.stopDate = 0;

            //Технологический  режим
            this.qL = 0;
            this.qO = 0;
            this.wct = 0;
            this.bhp = 0;
            this.pRes = 0;
            this.hDyn = 0;
            this.pAnnular = 0;
            this.whp = 0;
            this.lineP = 0;

            //Настройка кривой притока
            this.pResInput = 0;
            this.piInput = 0;
            this.qLInput = 0;
            this.bhpInput = 0;
            this.wctInput = 0;
            this.gorInput = this.gor;
            this.hDynInput = 0;
            this.pAnnularInput = 0;
            this.hPumpManomInput = 0;
            this.whpInput = 0;

            //Параметры подбора
            this.qlCelValue = 0;
            this.bhpCelValue = 0;
            this.piCelValue = 0;

          } else if (data["Age"] === false) {
            this.setData(data)
          }
          this.$emit('LineData', this.curveLineData)
          this.$emit('PointsData', this.curvePointsData)
          this.NnoCalc();
        }
      );


    },
    postCurveData(value) {
      this.visibleChart = true;
      console.log(value)
      let uri = "http://172.20.103.187:7575/api/pgno/" + this.field + "/" + this.wellNumber + "/";
      // api/pgno/UZN/
      // KMB
      if (this.CelButton == 'ql') {
        this.CelValue = this.qlCelValue
      } else if (this.CelButton == 'bhp') {
        this.CelValue = this.bhpCelValue
      } else if (this.CelButton == 'pin') {
        this.CelValue = this.piCelValue
      }


      let jsonData = JSON.stringify(
        {
          "curveSelect": this.curveSelect,
          "presValue": this.pResInput,
          "piValue": this.piInput,
          "qlValue": this.qLInput,
          "bhpValue": this.bhpInput,
          "hdynValue": [this.hDynInput, this.pAnnularInput],
          "pmanomValue": [this.pManomInput, this.hPumpManomInput],
          "whpValue": this.whpInput,
          "wctValue": this.wctInput,
          "gorValue": this.gorInput,
          "expSelect": this.expChoose,
          "hPumpValue": this.hPumpValue,
          "celSelect": this.CelButton,
          "celValue": this.CelValue,
          "menu": "MainMenu",
          "well_age": this.age,
          "grp_skin": this.grp_skin,
          "analysisBox1": this.analysisBox1,
          "analysisBox2": this.analysisBox2,
          "analysisBox3": this.analysisBox3,
          "analysisBox4": this.analysisBox4,
          "analysisBox5": this.analysisBox5,
          "analysisBox6": this.analysisBox6,
          "analysisBox7": this.analysisBox7,
          "analysisBox8": this.analysisBox8
        }
      )

      if (this.pResInput * 1 <= this.bhpInput * 1 || (this.pResInput * 1 < this.bhpCelValue * 1 && this.CelButton == 'bhp')) {
        Vue.prototype.$notifyError("Pзаб не должно быть больше чем Рпл");
      } else if (this.qlPot < this.qlCelValue && this.CelButton == 'ql') {
        Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
      } else if (this.bhpPot > this.bhpCelValue && this.CelButton == 'bhp') {
        Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
      } else if (this.pinPot > this.piCelValue && this.CelButton == 'pin') {
        Vue.prototype.$notifyError("Целевой режим превышает тех. потенциал")
      } else if (this.hPumpValue > this.hPerf) {
        Vue.prototype.$notifyError("Обычно насос устанавливается выше интервала перфорации")
      } else {
        this.axios.post(uri, jsonData).then((response) => {
          var data = response.data;
          if (data) {
            this.method = "CurveSetting"
            if (data["Well Data"]["pi"][0] * 1 < 0) {
              Vue.prototype.$notifyWarning("Pзаб не должно быть больше чем Рпл")
            } else {
              this.setData(data)
              this.$emit('LineData', this.curveLineData)
              this.$emit('PointsData', this.curvePointsData)
            }

          } else {
          }
        });
      }

    },

    postAnalysisOld() {
      this.visibleChart = true;
      let uri = "http://172.20.103.187:7575/api/pgno/" + this.field + "/" + this.wellNumber + "/";
      if (this.CelButton == 'ql') {
        this.CelValue = this.qlCelValue
      } else if (this.CelButton == 'bhp') {
        this.CelValue = this.bhpCelValue
      } else if (this.CelButton == 'pin') {
        this.CelValue = this.piCelValue
      }

      let jsonData = JSON.stringify(
        {
          "curveSelect": this.curveSelect,
          "presValue": this.pResInput,
          "piValue": this.piInput,
          "qlValue": this.qLInput,
          "bhpValue": this.bhpInput,
          "hdynValue": [this.hDynInput, this.pAnnularInput],
          "pmanomValue": [this.pManomInput, this.hPumpManomInput],
          "whpValue": this.whpInput,
          "wctValue": this.wctInput,
          "gorValue": this.gorInput,
          "expSelect": this.expChoose,
          "hPumpValue": this.hPumpValue,
          "celSelect": this.CelButton,
          "celValue": this.CelValue,
          "menu": "PotencialAnalysis",
          "well_age": this.age,
          "grp_skin": this.grp_skin,
          "analysisBox1": this.analysisBox1,
          "analysisBox2": this.analysisBox2,
          "analysisBox3": this.analysisBox3,
          "analysisBox4": this.analysisBox4,
          "analysisBox5": this.analysisBox5,
          "analysisBox6": this.analysisBox6,
          "analysisBox7": this.analysisBox7,
          "analysisBox8": this.analysisBox8
        }
      )
      this.axios.post(uri, jsonData).then((response) => {
        var data = response.data;
        if (data) {
          console.log(data)
          this.method = "CurveSetting"
          this.newData = data["Well Data"]
          // this.setData(data)
          this.newCurveLineData = JSON.parse(data.LineData)["data"]
          this.newPointsData = JSON.parse(data.PointsData)["data"]
          this.updateLine(this.newCurveLineData)
          this.setPoints(this.newPointsData)
          // this.$emit('LineData', this.curveLineData)
          // this.$emit('PointsData', this.curvePointsData)
        } else {
        }
      });
    },

    postAnalysisNew() {
      this.visibleChart = true;
      console.log("POST NEW WELL")
      let uri = "http://172.20.103.187:7575/api/pgno/" + this.field + "/" + this.wellNumber + "/";
      if (this.CelButton == 'ql') {
        this.CelValue = this.qlCelValue
      } else if (this.CelButton == 'bhp') {
        this.CelValue = this.bhpCelValue
      } else if (this.CelButton == 'pin') {
        this.CelValue = this.piCelValue
      }

      let jsonData = JSON.stringify(
        {
          "curveSelect": this.curveSelect,
          "presValue": this.pResInput,
          "piValue": this.piInput,
          "qlValue": this.qLInput,
          "bhpValue": this.bhpInput,
          "hdynValue": [this.hDynInput, this.pAnnularInput],
          "pmanomValue": [this.pManomInput, this.hPumpManomInput],
          "whpValue": this.whpInput,
          "wctValue": this.wctInput,
          "gorValue": this.gorInput,
          "expSelect": this.expChoose,
          "hPumpValue": this.hPumpValue,
          "celSelect": this.CelButton,
          "celValue": this.CelValue,
          "menu": "PotencialAnalysis",
          "well_age": this.age,
          "grp_skin": this.grp_skin,
          "analysisBox1": this.analysisBox1,
          "analysisBox2": this.analysisBox2,
          "analysisBox3": this.analysisBox3,
          "analysisBox4": this.analysisBox4,
          "analysisBox5": this.analysisBox5,
          "analysisBox6": this.analysisBox6,
          "analysisBox7": this.analysisBox7,
          "analysisBox8": this.analysisBox8
        }
      )
      this.axios.post(uri, jsonData).then((response) => {
        var data = response.data;
        if (data) {
          console.log(data)
          this.newData = data["Well Data"]
          this.method = "CurveSetting"
          this.newCurveLineData = JSON.parse(data.LineData)["data"]
          this.newPointsData = JSON.parse(data.PointsData)["data"]
          this.updateLine(this.newCurveLineData)
          this.setPoints(this.newPointsData)
          this.wctOkr = data["Well Data"]["wct"][0].toFixed(0)
          // this.$emit('LineData', this.curveLineData)
          // this.$emit('PointsData', this.curvePointsData)
        } else {
        }
      });
    },
    setGraphOld() {
      this.updateLine(this.newCurveLineData)
      this.setPoints(this.newPointsData)
      this.$modal.hide('modalOldWell');
      this.$eventBus.$emit('newCurveLineData', this.newCurveLineData)
      this.$eventBus.$emit('newPointsData', this.newPointsData)
      this.pResInput = this.newData["p_res"][0].toFixed(0)
      this.piInput = this.newData["pi"][0].toFixed(2)
      this.qLInput = this.newData["q_l"][0].toFixed(0)
      this.bhpInput = this.newData["bhp"][0].toFixed(0)
      this.hDynInput = this.newData["h_dyn"][0].toFixed(0)
      this.pAnnularInput = this.newData["p_annular"][0].toFixed(0)
      this.pManomInput = this.newData["p_intake"][0].toFixed(0)
      this.hPumpManomInput = this.newData["h_pump_set"][0].toFixed(0)
      this.whpInput = this.newData["whp"][0].toFixed(0)
      this.wctInput = this.newData["wct"][0].toFixed(0)
      this.qlCelValue = this.newPointsData[0]["q_l"].toFixed(0)
      this.bhpCelValue = this.newPointsData[0]["p"].toFixed(0)
      this.piCelValue = this.newPointsData[0]["pin"].toFixed(0)
    },

    setGraphNew() {
      Vue.prototype.$notifyWarning("Нсп установлено на 150м выше ВДП по умолчанию")
      this.updateLine(this.newCurveLineData)
      this.setPoints(this.newPointsData)
      this.$modal.hide('modalNewWell');
      this.$eventBus.$emit('newCurveLineData', this.newCurveLineData)
      this.$eventBus.$emit('newPointsData', this.newPointsData)
      this.pResInput = this.newData["p_res"][0].toFixed(0)
      this.piInput = this.newData["pi"][0].toFixed(2)
      this.wctInput = this.newData["wct"][0].toFixed(0)
      this.hPumpValue = this.newData["h_pump_set"][0].toFixed(0)
      console.log(this.newData)
    },

    onCompareNpv() {
      console.log(this.expAnalysisData.ecnNpv);
      console.log(this.expAnalysisData.shgnNpv);
      if (this.expAnalysisData.ecnNpv > this.expAnalysisData.shgnNpv) {
        this.expChoose == "ЭЦН"
      } else {
        this.expChoose == "ШГН"
      }
      this.$modal.hide("modalExpAnalysis");
    },

    onShowTable() {
      console.log('mytable');
      this.$modal.hide("modalExpAnalysis");
      this.$modal.show("tablePGNO")
    },

    onPgnoClick() {
      if (this.expChoose == 'ШГН') {
        if (this.visibleChart) {
          let uri = "http://172.20.103.187:7575/api/pgno/shgn";
          let jsonData = JSON.stringify(
            {
              "ql_cel": this.qlCelValue,
              "h_pump_set": this.hPumpValue,
              "sk_type": this.sk,
              "dens_oil": this.densOil,
              "dens_water": this.densWater,
              "wct": this.wctInput,
              "stroke_len": this.stroke_len
            }
          )
          this.axios.post(uri, jsonData).then((response) => {
            var data = JSON.parse(response.data);
            console.log(data);
            if (data) {
              if (data["error"] == "NoIntersection") {
                Vue.prototype.$notifyWarning("По выбранным параметрам насос подобрать невозможно, попробуйте изменить глубину спуска или ожидаемый дебит");
              } else {
                Vue.prototype.$notifyWarning("Раздел 'Подбор ШГН' находится в разработке")
                this.shgnPumpType = data["pump_type"]
                this.shgnSPM = data["spm"].toFixed(0)
                this.shgnLen = data["stroke_len"]
                this.shgnS1D = data["s1d"].toFixed(0)
                this.shgnS2D = data["s2d"].toFixed(0)
                this.shgnS1L = data["s1l"].toFixed(0)
                this.shgnS2L = data["s2l"].toFixed(0)
                this.shgnTN = data["tn"]
                this.shgnTNL = data["tn_l"]
                this.visibleChart = !this.visibleChart
              }
            } else {
            }
          })
        } else {
          this.visibleChart = !this.visibleChart
          this.postCurveData()
        }
      } else {
        Vue.prototype.$notifyWarning("Раздел 'Подбор УЭЦН' не разработан")
      }

    },

    setActiveRightTabName: function (e, val) {
      if (val === this.activeRightTabName) {
        this.activeRightTabName = 'technological-mode';
      } else {
        this.activeRightTabName = val;
      }
    },

  },
};
