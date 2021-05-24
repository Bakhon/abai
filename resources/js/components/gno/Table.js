import {mapMutations, mapState} from 'vuex'
import { Plotly } from "vue-plotly";
import { eventBus } from "../../event-bus.js";
import NotifyPlugin from "vue-easy-notify";
import 'vue-easy-notify/dist/vue-easy-notify.css';
import { VueMomentLib }from "vue-moment-lib";
import moment from "moment";
import {PerfectScrollbar} from "vue2-perfect-scrollbar";
import "vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css";
import Vue from 'vue';
import FullPageLoader from '../ui-kit/FullPageLoader';
import * as htmlToImage from 'html-to-image';
import jsPDF from 'jspdf';
import Tabs from './tabs/Tabs.vue'
const fileDownload = require("js-file-download");

Vue.prototype.$eventBus = new Vue();


Vue.use(NotifyPlugin,VueMomentLib);
Vue.component("Plotly", Plotly);


export default {
  components: { PerfectScrollbar, FullPageLoader, Tabs },
  data: function () {
    return {
      url: "http://127.0.0.1:7575/api/pgno/",
      isLoading: false,
      activeRightTabName: 'technological-mode',
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
        height: 360,
        showlegend: true,
        margin: {
          l: 50,
          r: 50,
          b: 80,
          t: 30
        },
        xaxis: {
          title: "",
          hoverformat: ".1f",
          zeroline: false,
          gridcolor: "#123E73",
        },
        yaxis: {
          title: "",
          hoverformat: ".1f",
          showlegend: true,
          zeroline: false,
          gridcolor: "#123E73",
        },

        paper_bgcolor: "#2B2E5E",
        plot_bgcolor: "#2B2E5E",
        font: { color: "#fff" },

        legend: {
          orientation: "h",
          y: -0.3,
          font: {
            size: 9.3,
            color: "#fff",
          },
        },
      },

      data: [
        {
          name: "IPR (кривая притока)",
          x: [0,1,3],
          y: [0,1,3],

          marker: {
            size: "15",
            color: "#FF0D18",
          },
        },
      ],
      nameKPP: "Кривая притока (пользователь)",
      nameKPA: "Кривая притока (анализ)",
      nameTR: "Текущий режим",
      namePR: "Потенциальный режим",
      titleXRu: "Дебит жидкости, м³/сут.",
      titleXKz: "Сұйықтық дебиті, м³/тәул.",
      titleXEn: "Liquid flow rate, м³/d.",
      titleYRu: "Давление, атм/газосодержание, %",
      titleYKz: "Қысым, атм / газ құрамы, %",
      titleYEn: "Pressure, atm/gas saturation, %",
      hovertemplateKPP: "<b>Кривая притока (пользователь)</b><br>" +
            "Qж = %{x:.1f} м³/сут<br>" +
            "Qн = %{text:.1f} т/сут<br>" +
            "Pзаб = %{y:.1f} атм<extra></extra>",
      hovertemplateKPA: "<b>Кривая притока (анализ)</b><br>" +
            "Qж = %{x:.1f} м³/сут<br>" +
            "Qн = %{text:.1f} т/сут<br>" +
            "Pзаб = %{y:.1f} атм<extra></extra>",
      hovertemplateTR: "<b>Текущий режим</b><br>" +
            "Qж = %{x:.1f} м³/сут<br>" +
            "Qн = %{text:.1f} т/сут<br>" +
            "Pзаб = %{y:.1f} атм<extra></extra>",
      hovertemplatePR: "<b>Потенциальный режим</b><br>" +
            "Qж = %{x:.1f} м³/сут<br>" +
            "Qн = %{text:.1f} т/сут<br>" +
            "Pзаб = %{y:.1f} атм<extra></extra>",
      bhpPot: null,
      qlPot: null,
      pinPot: null,
      isVisibleChart: true,
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
      hPerfND: null,
      type: String,
      required: true,
      wellNumber: null,
      isYoungAge: false,
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
      gor:null,
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
      QhydCurveSelect: null,
      curr: null,
      expChoose: null,
      CelButton: 'ql',
      bhpCurveButton: '',
      qL: null,
      qlCelValue: null,
      bhpCelValue: null,
      piCelValue: null,
      expID: null,
      CelValue: null,
      isAnalysisBoxValue1: true,
      isAnalysisBoxValue2: true,
      isAnalysisBoxValue3: true,
      isAnalysisBoxValue4: true,
      isAnalysisBoxValue5: true,
      isAnalysisBoxValue6: true,
      isAnalysisBoxValue7: true,
      isAnalysisBoxValue8: true,
      nk_fields: [
        {
          short_name: "UZN",
          full_name: "Узень",
          id: 0
        },
        {
          short_name: "KMB",
          full_name: "Карамандыбас",
          id: 1
        },
        {
          short_name: "JET",
          full_name: "Жетыбай",
          id: 2
        }],
      omg_fields: [
        {
          short_name: "UZN",
          full_name: "Узень",
        },
        {
          short_name: "KMB",
          full_name: "Карамандыбас",
        }],
      mmg_fields: [
        {
          short_name: "JET",
          full_name: "Жетыбай",
        }],
      shgnTubOD: null,
      menu: "MainMenu",
      ngdu: null,
      sk: null,
      hasGrp: false,
      newData: null,
      strokeLenDev: null,
      spmDev: '1/мин',
      expAnalysisData:{
        NNO1:null,
        NNO2:null,
        fieldNNO1:null,
        fieldNNO2:null,
        prs1:null,
        prs2:null,
        qoilEcn:null,
        qoilShgn:null,
        shgnParam:null,
        ecnParam:null,
        ecnNpv:null,
        shgnNpv:null,
        npvTable1:{},
        npvTable2:{},
        nno1:null,
        nno2:null,
      },

      qZhExpEcn:null,
      qOilExpEcn:null,
      qZhExpShgn:null,
      qOilExpShgn:null,
      q1ZhidM3:null,
      q2ZhidM3:null,
      param_eco:null,
      param_org:null,
      param_fact:null,
      wellData: null,
      field: null,
      wellIncl: null,
      dataNNO:"2020-11-01",
      nearWells: [],
      windowWidth: null,

      wellOkr: null,
      piOkr: null,
      khOkr: null,
      skinOkr: null,
      presOkr: null,
      stanokKachalka: null,
      freq: 'Число качаний',
      dNasosa: 'Диаметр насоса',
      hasStrokeLength: false,
      krsTable: [],
      numberRepairs: null,
      numberNNO: null,
      langUrl: '',
      sep_meth: 'input_value',
      nat_sep: true,
      mech_sep: null,
      sep_value: null,
      mech_sep_value: 50,
      pBuf: null,
      ao: null,
      orgs: null,
      nkt: null,
      liftValue: "ШГН",
      stepValue: 10,
      centratorsInfo: null,
      centratorsRequiredValue: null,
      centratorsRecommendedValue: null,
      nkt_choose: [
        {
          for_calc_value: 50.3,
          show_value: "60x5",
        },
        {
          for_calc_value: 62,
          show_value: "73x5,5",
        },
        {
          for_calc_value: 59.3,
          show_value: "73x7",
        },
        {
          for_calc_value: 75.9,
          show_value: "89x6,5",
        },
        {
          for_calc_value: 83.6,
          show_value: "102x6,5",
        },
        {
          for_calc_value: 100.3,
          show_value: "114x7",
        }],
      hPumpFromIncl: null,
      isButtonHpump: false,
      postdata: null,
      inflowCurveTitle: this.trans('pgno.krivaya_pritoka'),
      podborGnoTitle: this.trans('pgno.podbor_gno')
    };

  },

  watch: {
    curveSelect(newVal) {
      if (newVal === 'pi') {
        this.QhydCurveSelect = null;
      } else {
        this.QhydCurveSelect = 'hdyn';
      }
    },
    QhydCurveSelect(newVal) {
      if (newVal === 'hdyn') {
        this.curveSelect = 'hdyn';
      }
    },      
  },
  beforeCreate: function () {
    this.axios.get('/ru/organizations').then(({data}) => {
      if (data.organizations.length == 0) {
        this.organization = "НК КазМунайГаз"
      } else {
        this.organization = data.organizations[0]["name"]
      }
      if (this.organization == "АО «ОзенМунайГаз»") {
        this.orgs = this.omg_fields
      } else if (this.organization == "НК КазМунайГаз") {
        this.orgs = this.nk_fields
      } else if (this.organization == "АО «Мангистаумунайгаз»"){
        this.orgs = this.mmg_fields
      }
    })
    
  },
  mounted() {
    this.windowWidth = window.innerWidth;

    if (this.windowWidth <= 1300 && this.windowWidth > 991) {
      this.activeRightTabName = 'devices';
    }
  },
  computed: {
  
    wellNum() {
      return this.$store.state.wellNum
    },
    wellType() {
      return this.$store.state.wellType
    },
    ...mapState(['wells'])
  },
  methods: {
    setHpumpValueFromIncl() {
      this.$modal.hide('modalIncl')
      this.hPumpValue = this.$store.getters.getHpump
      this.postCurveData();
    },
    prepareData() {
      this.postdata = JSON.stringify(
        {
          "welldata": this.wellData,
          "settings" : {
            "curveSelect": this.curveSelect,
            "presValue": this.pResInput.split(' ')[0],
            "piValue": this.piInput.split(' ')[0],
            "qlValue": this.qLInput.split(' ')[0],
            "bhpValue": this.bhpInput.split(' ')[0],
            "hdynValue": [this.hDynInput.split(' ')[0], this.pAnnularInput.split(' ')[0]],
            "pmanomValue": [this.pManomInput.split(' ')[0], this.hPumpManomInput.split(' ')[0]],
            "whpValue": this.whpInput.split(' ')[0],
            "wctValue": this.wctInput.split(' ')[0],
            "gorValue": this.gorInput.split(' ')[0],
            "expSelect": this.expChoose,
            "hPumpValue": this.hPumpValue.split(' ')[0],
            "celSelect": this.CelButton,
            "celValue": this.CelValue.split(' ')[0],
            "menu": this.menu,
            "well_age": this.isYoungAge,
            "grp_skin": this.hasGrp,
            "analysisBox1": this.isAnalysisBoxValue1,
            "analysisBox2": this.isAnalysisBoxValue2,
            "analysisBox3": this.isAnalysisBoxValue3,
            "analysisBox4": this.isAnalysisBoxValue4,
            "analysisBox5": this.isAnalysisBoxValue5,
            "analysisBox6": this.isAnalysisBoxValue6,
            "analysisBox7": this.isAnalysisBoxValue7,
            "analysisBox8": this.isAnalysisBoxValue8,
            "sep_meth": this.sep_meth,
            "sep_value": this.sep_value,
            "mech_sep": this.mech_sep,
            "mech_sep_value": this.mech_sep_value,
            "nat_sep": this.nat_sep,
            "nkt": this.nkt,
          }
        })
    },
    downloadExcel() {
      this.isLoading = true;

      if (this.CelButton == 'ql') {
        this.CelValue = this.qlCelValue
      } else if (this.CelButton == 'bhp') {
        this.CelValue = this.bhpCelValue
      } else if (this.CelButton == 'pin') {
        this.CelValue = this.piCelValue
      }
      this.prepareData()
      let uri = "http://127.0.0.1:7575/api/pgno/"+ this.field + "/" + this.wellNumber + "/download";
      this.axios.post(uri, postdata,{responseType: "blob"}).then((response) => {
        fileDownload(response.data, "ПГНО_" + this.field + "_" + this.wellNumber + ".xlsx")
      }).catch(function (error) {
        console.error('oops, something went wrong!', error);
      }).finally(() => {
        this.isLoading = false;
    });
    },

    updateWellNum(event) {
      this.$store.commit('UPDATE_MESSAGE', event.target.value)
      this.$store.dispatch('loadWells')
    },
    closeModal(modalName) {
      this.$modal.hide(modalName)
    },

    closeInclModal() {
      this.isButtonHpump = this.$store.getters.getHpumpButton
      this.$modal.hide('modalIncl')
    },
    closeEconomicModal() {
      this.$modal.hide('tablePGNO')
      this.$modal.show('modalExpAnalysis')
    },

    onChangeParams() {
      this.$modal.show('modalSeparation')
    },
    
    setData: function(data) {
      if (this.method == "CurveSetting") {
        this.pResInput = data["Well Data"]["p_res"] + " " + this.trans('measurements.atm')
        this.piInput = data["Well Data"]["pi"].toFixed(2)  + " " +  this.trans('measurements.m3/d/atm')
        this.qLInput = data["Well Data"]["q_l"].toFixed(0)  + " " +  this.trans('measurements.m3/day')
        this.wctInput = data["Well Data"]["wct"]  + " " +  this.trans('measurements.percent')
        this.hPumpValue = data["Well Data"]["h_pump_set"].toFixed(0)  + " " +  this.trans('measurements.m')
        this.gorInput = data["Well Data"]["gor"]  + " " +  this.trans('measurements.m3/t')
        this.bhpInput = data["Well Data"]["bhp"].toFixed(0)  + " " +  this.trans('measurements.atm')
        this.hDynInput = data["Well Data"]["h_dyn"].toFixed(0)  + " " + this.trans('measurements.m')
        this.pAnnularInput = data["Well Data"]["p_annular"].toFixed(0)  + " " +  this.trans('measurements.atm')
        this.qlCelValue = JSON.parse(data.PointsData)["data"][2]["q_l"].toFixed(0)  + " " +  this.trans('measurements.m3/day')
        this.bhpCelValue = JSON.parse(data.PointsData)["data"][2]["p"].toFixed(0)  + " " +  this.trans('measurements.atm')
        this.piCelValue = JSON.parse(data.PointsData)["data"][2]["pin"].toFixed(0)  + " " +  this.trans('measurements.atm')
        this.whpInput = data["Well Data"]["whp"].toFixed(0)  + " " +  this.trans('measurements.atm')
        this.pManomInput = data["Well Data"]["p_intake"]  + " " +  this.trans('measurements.atm')
        this.sep_value = (data["Well Data"]["es"]* 100).toFixed(0)
        if(this.curveSelect == 'pmanom') {
          this.hPumpManomInput = data["Well Data"]["h_pump_set"]  + " " + this.trans('measurements.m')
        }
        this.curveLineData = JSON.parse(data.LineData)["data"]
        this.curvePointsData = JSON.parse(data.PointsData)["data"]
        this.qOil = this.curvePointsData[2]["q_oil"].toFixed(0)
        this.bhpPot = this.curvePointsData[1]["p"].toFixed(0)
        this.qlPot = this.curvePointsData[1]["q_l"].toFixed(0)
        this.pinPot = this.curvePointsData[1]["pin"].toFixed(0)
      } else {
        this.ngdu = data["Well Data"]["ngdu"]
        this.sk = data["Well Data"]["sk_type"]
        this.wellNumber = data["Well Data"]["well"].split("_")[1]
        this.isYoungAge = data["Age"]
        this.horizon = data["Well Data"]["horizon"]
        this.expMeth = data["Well Data"]["exp_meth"]
        this.tseh = data["Well Data"]["tseh"]
        this.gu = data["Well Data"]["gu"]
        this.stroke_len = data["Well Data"]["stroke_len"]
        this.casOD = data["Well Data"]["cas_OD"]
        this.casID = data["Well Data"]["cas_ID"]
        this.hPerf = data["Well Data"]["h_up_perf_vd"]
        this.udl = data["udl"].toFixed(1)
        this.hPumpSet = data["Well Data"]["h_pump_set"]
        this.tubOD = data["Well Data"]["tub_OD"]
        this.tubID = data["Well Data"]["tub_ID"]
        this.stopDate = data["Well Data"]["stop_date"]
        this.pumpType = data["Well Data"]["pump_type"]
        this.PBubblePoint = data["Well Data"]["P_bubble_point"].toFixed(2)
        this.gor = data["Well Data"]["gor"].toFixed(0)
        this.tRes = data["Well Data"]["t_res"].toFixed(2)
        this.viscOilRc = data["Well Data"]["visc_oil_rc"].toFixed(2)
        this.viscWaterRc = data["Well Data"]["visc_wat_rc"].toFixed(2)
        this.densOil = data["Well Data"]["dens_oil"].toFixed(2)
        this.densWater = data["Well Data"]["dens_liq"].toFixed(2)
        this.qL = data["Well Data"]["q_l"].toFixed(0)
        this.qO = data["Well Data"]["q_o"].toFixed(0)
        this.wct = data["Well Data"]["wct"].toFixed(0)
        this.bhp = data["Well Data"]["bhp"].toFixed(0)
        this.pRes = data["Well Data"]["p_res"].toFixed(0)
        this.hDyn = data["Well Data"]["h_dyn"].toFixed(0)
        this.pAnnular = data["Well Data"]["p_annular"].toFixed(0)
        this.whp = data["Well Data"]["whp"].toFixed(0)
        this.pBuf = data["Well Data"]["whp"].toFixed(0)
        this.lineP = data["Well Data"]["line_p"].toFixed(0)
        this.piInput = data["Well Data"]["pi"].toFixed(2) + ' м³/сут/ат'
        this.curr = data["Well Data"]["curr_bh"].toFixed(0)
        this.piCelValue = JSON.parse(data.PointsData)["data"][0]["pin"].toFixed(0)  + " " +  this.trans('measurements.atm')
        this.bhpCelValue = JSON.parse(data.PointsData)["data"][0]["p"].toFixed(0)  + " " +  this.trans('measurements.atm')
        this.wellIncl = data["Well Data"]["well"]
        this.hPerfND = data["Well Data"]["h_perf"]
        this.strokeLenDev = data["Well Data"]["stroke_len"]
        this.sep_value = (data["Well Data"]["es"]* 100).toFixed(0)
        this.nkt = this.tubID
        let langUrl = `${window.location.pathname}`.slice(1, 3);
        if (this.expMeth == 'ШГН') {
          if(langUrl === 'ru') {
            this.dNasosa = 'Диаметр насоса'
            this.freq = 'Число качаний'
          } else if(langUrl === 'kz') {
            this.dNasosa = "Сораптың диаметрі"
            this.freq = "Тербеліс саны"
          } else {
            this.dNasosa = "Pump diameter"
            this.freq = "Pump rate"
          }
          this.spmDev = data["Well Data"]["spm"]  + " " +  this.trans('measurements.1/min')
          this.pumpType = this.pumpType  + " " +  this.trans('measurements.mm')
        } else {
          if(langUrl === 'ru') {
            this.dNasosa = 'Номинальная подача'
            this.freq = 'Частота'
          } else if(langUrl === 'kz') {
            this.dNasosa = "Номиналды беру"
            this.freq = "Жиілігі"
          } else {
            this.dNasosa = "Nominal feed"
            this.freq = "Frequency"
          }
          this.spmDev = data["Well Data"]["freq"]  + " " +  this.trans('measurements.gc')
          this.pumpType = this.pumpType  + " " +  this.trans('measurements.m3/day')
        }
        if (this.expMeth == 'УЭЦН') {
        this.hasStrokeLength = true
        } else


        this.stopDate = this.stopDate.substring(0, 10)
        this.pResInput = this.pRes  + " " +  this.trans('measurements.atm')
        this.qLInput = this.qL   + " " +  this.trans('measurements.m3/day')
        this.wctInput = this.wct  + " " +  this.trans('measurements.percent')
        this.gorInput = this.gor  + " " +  this.trans('measurements.m3/t')
        this.bhpInput = this.bhp  + " " +  this.trans('measurements.atm')
        this.hDynInput = this.hDyn  + " " +  this.trans('measurements.m')
        this.pAnnularInput = this.pAnnular + " " + this.trans('measurements.atm')
        this.pManomInput = data["Well Data"]["p_intake"]  + " " +  this.trans('measurements.atm')
        this.hPumpManomInput = data["Well Data"]["h_pump_set"]  + " " +  this.trans('measurements.m')
        this.whpInput = this.whp  + " " +  this.trans('measurements.atm')
        this.qlCelButton = true
        this.qlCelValue = this.qLInput
        this.hPumpValue = this.hPumpSet  + " " +  this.trans('measurements.m')
        
        this.expChoose = this.expMeth
        if (this.expMeth === "УЭЦН") {
          this.expChoose = "ЭЦН"
        }

        if (this.isYoungAge) {
          this.curveSelect = 'pi'
        } else {
          if (this.expMeth === "ФОН"){
            this.curveSelect = "whp"
          } else {
            this.curveSelect = 'hdyn'
          }
        }

        this.piButton = true
        this.curveLineData = JSON.parse(data.LineData)["data"]
        this.curvePointsData = JSON.parse(data.PointsData)["data"]
        this.qOil = this.curvePointsData[2]["q_oil"].toFixed(0)
        this.bhpPot = this.curvePointsData[1]["p"].toFixed(0)
        this.qlPot = this.curvePointsData[1]["q_l"].toFixed(0)
        this.pinPot = this.curvePointsData[1]["pin"].toFixed(0)
      }
    },
    setLine: function (value) {
      let ipr_points = [], qo_points = [], value2 = [], ipr_points2 = [], qo_points2 = [], q_oil = [], q_oil2 = [];

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
          name: this.nameKPP,
          legendgroup: 1,
          x: qo_points2,
          y: ipr_points2,
          text: q_oil2,
          hovertemplate: this.hovertemplateKPP, 
          marker: {
            size: "15",
            color: "#FF0D18",
          },
        },
        {
          name: this.nameTR,
          legendgroup: 2,
          x: [],
          y: [],
          text: [],
          mode: "markers",
          hovertemplate: this.hovertemplateTR,
          marker: {
            size: "15",
            color: "#00A0E3",
          },
        },

        {
          name: this.namePR,
          legendgroup: 3,
          x: [],
          y: [],
          text: [],
          mode: "markers",
          hovertemplate: this.hovertemplatePR,
          marker: {
            size: "8",
            color: "#FBA409",
          },
        },
        {
          name: this.nameKPA,
          legendgroup: 4,
          x: [],
          y: [],
          text: [],
          hovertemplate: this.hovertemplateKPA,

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


    updateLine:  function (value) {
        let ipr_points = [], qo_points = [], value2 = [], ipr_points2 = [], qo_points2 = [], q_oil = [], q_oil2 = [];

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
      this.layout['shapes'][0]['x0'] = value[1]['q_l']
      this.layout['shapes'][0]['x1'] = value[1]['q_l']

    },
    updateAnalysisMenu() {
      this.postCurveData()
      this.setLine(this.curveLineData)
      this.setPoints(this.curvePointsData)
      if (this.isYoungAge) {
        this.postAnalysisNew();
        this.$modal.show('modalNewWell');
      } else {
        this.postAnalysisOld();
        this.$modal.show('modalOldWell');
      }
    },

    async setExpAnalysisMenu(){
      await this.NnoCalc()

      if(this.casOD < 127) {
        this.$notify({
          message: this.trans('pgno.notify_ek_127'),
          type: 'error',
          size: 'sm',
          timeout: 8000
        })
      } 

      if (this.qlCelValue.split(' ')[0] < 28) {
        this.$notify({
            message: this.trans('pgno.notify_uecn_not_recommended'),
            type: 'warning',
            size: 'sm',
            timeout: 8000
          })
      }

      if (this.qlCelValue.split(' ')[0] > 106) {
        this.$notify({
            message: this.trans('pgno.notify_shgn_restrict_potencial'),
            type: 'warning',
            size: 'sm',
            timeout: 8000
          })
      } 

      this.qZhExpEcn=this.qlCelValue.split(' ')[0]*((1-(this.wctInput.split(' ')[0]/100))*this.densOil+ this.wctInput.split(' ')[0]/100*this.densWater)
      this.qOilExpEcn=this.qlCelValue.split(' ')[0]*(1-(this.wctInput.split(' ')[0]/100))*this.densOil
      this.q2ZhidM3=this.qlCelValue.split(' ')[0]

      if (this.qlCelValue.split(' ')[0] < 106){
        this.qZhExpShgn=this.qlCelValue.split(' ')[0]*((1-(this.wctInput.split(' ')[0]/100))*this.densOil+ this.wctInput.split(' ')[0]/100*this.densWater)
        this.qOilExpShgn=this.qlCelValue.split(' ')[0]*(1-(this.wctInput.split(' ')[0]/100))*this.densOil
        this.q1ZhidM3=this.qlCelValue.split(' ')[0]
      } else {
        this.qZhExpShgn=106*((1-(this.wctInput.split(' ')[0]/100))*this.densOil+ this.wctInput.split(' ')[0]/100*this.densWater)
        this.qOilExpShgn=106*(1-(this.wctInput.split(' ')[0]/100))*this.densOil
        this.q1ZhidM3=106
      }

      this.expAnalysisData.qoilShgn=this.qOilExpShgn
      this.expAnalysisData.qoilEcn=this.qOilExpEcn

      if(this.expAnalysisData.NNO1!=null) {
        await this.EconomParam();
      }

    },
    async EconomParam(){
        //эта функция будет сделана на бэк-энде, сейчас временно тут
      var prs1 = this.expAnalysisData.prs1;
      var prs2 = this.expAnalysisData.prs2;

      var nnoDayUp=moment(this.dataNNO, 'YYYY-MM-DD').toDate();
      var nnoDayFrom=moment(this.stopDate, 'YYYY-MM-DD').toDate();

      var date_diff=(nnoDayUp-nnoDayFrom)/(1000*3600*24);

      if (date_diff<365){
        date_diff=365;
      }

      if (prs1!=0 && prs2!=0){
        this.param_eco=1;
        await this.EconomCalc();
      } else if (prs1==0 && prs2==0){
        if(this.isYoungAge){
          this.param_eco=1;
          await this.EconomCalc();
        } else {
          if(this.expMeth=="ШГН"){
            this.expAnalysisData.NNO1=date_diff;
            this.param_eco=1;
            await this.EconomCalc();
          }else{
            this.expAnalysisData.NNO2=date_diff;
            this.param_eco=1;
            await this.EconomCalc();
          }
        }
      } else if (prs1==0 && prs2!=0){
        this.param_eco=2;
        await this.EconomCalc();
      } else {
        this.param_eco=3;
        await this.EconomCalc();
      }
    },
    async EconomCalc(){

      if (this.field=='JET'){
        this.param_org=7;
        this.param_fact="Корр. 6 на 2021-2025";
      }
      else {
        this.param_org=5;
        this.param_fact="Корр. 5 на 2021-2025";
      }

      let uri2=this.localeUrl("/nnoeco?equip=1&org="+this.param_org+"&param="+this.param_eco+"&qo="+this.qOilExpShgn+"&qzh="+this.qZhExpShgn+"&liq="+this.q1ZhidM3+"&reqd="+this.expAnalysisData.NNO1+"&reqecn="+this.expAnalysisData.prs1+"&scfa="+this.param_fact)
      let uri3=this.localeUrl("/nnoeco?equip=2&org="+this.param_org+"&param="+this.param_eco+"&qo="+this.qOilExpEcn+"&qzh="+this.qZhExpEcn+"&liq="+this.q2ZhidM3+"&reqd="+this.expAnalysisData.NNO2+"&reqecn="+this.expAnalysisData.prs2+"&scfa="+this.param_fact)

      this.isLoading = true;

      const responses = await Promise.all([ this.axios.get(uri2), this.axios.get(uri3) ]).finally(() => {
        this.isLoading = false;
      });


      let data = responses[0].data;
      if(data) {

        this.expAnalysisData.shgnParam=data[12].godovoiShgnParam;
        this.expAnalysisData.shgnNpv=data[12].npv;
        this.expAnalysisData.npvTable1=data[12];
      }
      else {
        console.log('No data');
      }



      let data2 = responses[1].data;
      if (data2) {

        this.expAnalysisData.ecnParam=data2[12].godovoiEcnParam;
        this.expAnalysisData.ecnNpv=data2[12].npv;
        this.expAnalysisData.npvTable2=data2[12];

        if(this.qOilExpShgn!=null && this.qOilExpEcn!=null && this.expAnalysisData.NNO1!=null && this.expAnalysisData.NNO2!=null && this.expAnalysisData.shgnParam!=null && this.expAnalysisData.shgnNpv!=null && this.expAnalysisData.ecnParam!=null && this.expAnalysisData.ecnNpv!=null ){
          this.$modal.show("modalExpAnalysis");
        }

      }
      else {
        console.log('No data');
      }
    },
    async NnoCalc(){
      let uri = "http://127.0.0.1:7575/api/nno/";

      this.eco_param=null;

      this.qZhExpEcn=this.qlCelValue.split(' ')[0]
      this.qOilExpEcn=this.qlCelValue.split(' ')[0]*(1-(this.wctInput.split(' ')[0]/100))*this.densOil

      if (this.qlCelValue.split(' ')[0]<106){
        this.qZhExpShgn=this.qlCelValue.split(' ')[0]
        this.qOilExpShgn=this.qlCelValue.split(' ')[0]*(1-(this.wctInput.split(' ')[0]/100))*this.densOil

      } else {
        this.qZhExpShgn=106
        this.qOilExpShgn=106*(1-(this.wctInput.split(' ')[0]/100))*this.densOil
      }

      if(this.wellNumber!=null){
        let jsonData = JSON.stringify(
          {"well_number": this.wellNumber,
            "exp_meth": "ШГН",
            "field": this.field,
          }
        )

        let jsonData2 = JSON.stringify(
          {"well_number": this.wellNumber,
            "exp_meth": "ЭЦН",
            "field": this.field,
          }
        )

        this.isLoading = true;

        const responses = await Promise.all([ this.axios.post(uri, jsonData), this.axios.post(uri, jsonData2) ])
            .finally(() => {
              this.isLoading = false;
            });


        var data = JSON.parse(responses[0].data.Result)
        if (data) {
          this.expAnalysisData.NNO1=data.NNO
          this.expAnalysisData.qoilShgn=this.qOilExpShgn
          this.expAnalysisData.prs1=data.prs
          this.expAnalysisData.fieldNNO1=data.fieldNNO
        } else {
          console.log("No data");
        }

        var data2 = JSON.parse(responses[1].data.Result)
        if (data2) {
          this.expAnalysisData.NNO2=data2.NNO
          this.expAnalysisData.qoilEcn=this.qOilExpEcn
          this.expAnalysisData.prs2=data2.prs
          this.expAnalysisData.fieldNNO2=data.fieldNNO
        } else {
          console.log("No data");
        }



      }
    },

    onOpenTable() {
      this.$modal.show("modalNearWells");
    },

    onParamSep() {
      this.$modal.show("paramSep")
    },

    InclMenu() {
      if (this.isYoungAge) {
        this.$notify({
            message: this.trans('pgno.notify_no_incl'),
            type: 'warning',
            size: 'sm',
            timeout: 8000
          })
        } else {
        this.$store.commit('UPDATE_HPUMP', this.hPumpValue)
        this.$modal.show('modalIncl')
      }
    },

    getWellNumber(wellnumber) {
      if(this.field == "JET") {
              this.ao = 'АО "ММГ"'
            } else {
              this.ao = 'АО "ОМГ"'
            }
      this.isVisibleChart = true;
      let uri = this.url + this.field + "/" + wellnumber + "/";
      this.isLoading = true;

      this.axios.get(uri).then((response) => {
          let data = response.data;
          this.wellData = data["Well Data"]
          this.method = 'MainMenu'
          if (data["Error"] == "NoData" || data["Error"] == 'data_error'){
            if(data["Error"] == "NoData") {
                this.$notify({
                  message: this.trans('pgno.notify_well_doesnt_exist'),
                  type: 'error',
                  size: 'sm',
                  timeout: 8000
                })
            } 
            if(data["Error"] == 'data_error') {
                this.$notify({
                  message: this.trans('pgno.notify_well_data_not_correct'),
                  type: 'error',
                  size: 'sm',
                  timeout: 8000
                })    
            }


            

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


          } else if(data["Age"] === true) {


            this.curveLineData = JSON.parse(data.LineData)["data"]
            this.curvePointsData = JSON.parse(data.PointsData)["data"]
            this.horizon = data["Well Data"]["horizon"]
            this.curveSelect = 'pi'
            this.isYoungAge = data["Age"]


            this.PBubblePoint = data["Well Data"]["P_bubble_point"].toFixed(1)
            this.gor = data["Well Data"]["gor"].toFixed(1)
            this.tRes = data["Well Data"]["t_res"].toFixed(1)
            this.viscOilRc = data["Well Data"]["visc_oil_rc"].toFixed(1)
            this.viscWaterRc = data["Well Data"]["visc_wat_rc"].toFixed(1)
            this.densOil = data["Well Data"]["dens_oil"].toFixed(1)
            this.densWater = data["Well Data"]["dens_liq"].toFixed(1)
            this.hPumpValue = data["Well Data"]["h_pump_set"].toFixed(0)  + " " +  this.trans('measurements.m')

            this.$notify({
                  message: this.trans('pgno.notify_150_hpump'),
                  type: 'warning',
                  size: 'sm',
                  timeout: 8000
                })

            this.$notify({
                  message: this.trans('pgno.new_well'),
                  type: 'warning',
                  size: 'sm',
                  timeout: 8000
                }) 
            

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
            this.hPerf = data["Well Data"]["h_up_perf_vd"].toFixed(0);
            this.udl = 0;

            //Оборудование
            this.pumpType = 0;
            this.hPumpSet = 0
            this.tubOD = 73;
            this.tubID = 62;
            this.stopDate = 0;
            this.stroke_len = 0;
            this.spmDev = 0;

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
            this.pResInput = 0  + " " +  this.trans('measurements.atm');
            this.piInput = 0  + " " +  this.trans('measurements.m3/d/atm');
            this.qLInput = 0  + " " +  this.trans('measurements.m3/day');
            this.bhpInput = 0  + " " +  this.trans('measurements.atm');
            this.wctInput = 0  + " " +  this.trans('measurements.percent');
            this.gorInput = this.gor  + " " +  this.trans('measurements.m3/t');;
            this.hDynInput = 0  + " " +  this.trans('measurements.m');
            this.pAnnularInput = 0  + " " +  this.trans('measurements.atm');
            this.hPumpManomInput = 0  + " " +  this.trans('measurements.atm');
            this.whpInput = 0  + " " +  this.trans('measurements.atm');
            this.pManomInput = 0  + " " +  this.trans('measurements.atm');
            this.expChoose = 'ШГН'

            //Параметры подбора
            this.qlCelValue = 0  + " " +  this.trans('measurements.m3/day');
            this.bhpCelValue = 0  + " " +  this.trans('measurements.atm');
            this.piCelValue = 0  + " " +  this.trans('measurements.atm');
            this.sep_value = 60
          } else if (data["Age"] === false){
            this.setData(data)
            if(data["error_len"] == "error_len") {
              this.$notify({
                  message: this.trans('pgno.notify_no_sk_for_length'),
                  type: 'warning',
                  size: 'sm',
                  timeout: 8000
                }) 
            }
            if(data["error_spm"] == "error_spm") {
              this.$notify({
                message: this.trans('pgno.notify_no_sk_for_num_kach'),
                type: 'warning',
                size: 'sm',
                timeout: 8000
              })           
          }

            if (this.expMeth == "ШГН") {
              this.mech_sep = false
            } else if (this.expMeth == "ЭЦН" || this.expMeth == "УЭЦН") {
              this.mech_sep = true,
              this.mech_sep_value = "50 %"
            }
          }
          this.$emit('LineData', this.curveLineData)
          this.$emit('PointsData', this.curvePointsData)
          
        }
      ).finally((response) => {
        this.isLoading = false;
      });



    },

    fetchBlockCentrators() {
      let fieldInfo = this.wellIncl.split('_');
      let urlForIncl = "http://127.0.0.1:7575/api/pgno/incl";
      if (this.expChoose == 'ЭЦН') {
        (this.liftValue = 'ЭЦН') && (this.stepValue = 20);
      } else {
        (this.liftValue = 'ШГН') && (this.stepValue = 10);
      }

      let centratorsData = JSON.stringify(
        { 
          "well_number": fieldInfo[1],
          "lift_method": this.liftValue,
          "field": fieldInfo[0],
          "glubina": this.hPumpValue.substring(0,4) * 1,
          "step": this.stepValue,
        }
      )

      this.axios.post(urlForIncl, centratorsData).then((response) => {
        this.centratorsInfo = response.data
        this.centratorsRequiredValue = this.centratorsInfo["CenterRange"]["red"]
      })
    },

    postCurveData() {
      this.isVisibleChart = true;
      let uri = this.url + this.field + "/" + this.wellNumber + "/";
      if (this.CelButton == 'ql') {
        this.CelValue = this.qlCelValue
      } else if (this.CelButton == 'bhp') {
        this.CelValue = this.bhpCelValue
      } else if (this.CelButton == 'pin') {
        this.CelValue = this.piCelValue
      }
      this.menu = "MainMenu"
      this.prepareData()

      if(this.pResInput.split(' ')[0] * 1 <= this.bhpInput.split(' ')[0] * 1 || this.pResInput.split(' ')[0] * 1 <= this.bhpCelValue.split(' ')[0] * 1) {
        this.$notify({
            message: this.trans('pgno.notify_p_zab_more_p_pl'),
            type: 'error',
            size: 'sm',
            timeout: 8000
          }) 
      } else {
        this.isLoading = true;

      if(this.casOD < 127) {
        this.$notify({
                message: this.trans('pgno.notify_ek_127_down'),
                type: 'error',
                size: 'sm',
                timeout: 8000
              }) 
      }

      if (this.qlCelValue.split(' ')[0] < 28) {
        this.$notify({
          message: this.trans('pgno.notify_uecn_not_recommended'),
          type: 'warning',
          size: 'sm',
          timeout: 8000
              })       
      }
      if (this.qlCelValue.split(' ')[0] > 106) {
        this.$notify({
          message: this.trans('pgno.notify_shgn_restrict_potencial'),
          type: 'warning',
          size: 'sm',
          timeout: 8000
          })  
      }

        this.axios.post(uri, this.postdata).then((response) => {
          let data = response.data;
          if (data) {
            this.method = "CurveSetting"
            if(data["Well Data"]["pi"][0] * 1 < 0) {
              this.$notify({
                message: this.trans('pgno.notify_p_zab_more_p_pl'),
                type: 'warning',
                size: 'sm',
                timeout: 8000
              })  
              
            } else {
              if(this.hPumpValue.split(' ')[0] * 1 > this.hPerf * 1){
                this.$notify({
                  message: this.trans('pgno.notify_n_set_down_perf'),
                  type: 'warning',
                  size: 'sm',
                  timeout: 8000
                })   
              }
              this.setData(data)
              this.$emit('LineData', this.curveLineData)
              this.$emit('PointsData', this.curvePointsData)
              if(this.qlPot * 1 < this.qlCelValue.split(' ')[0] * 1 && this.CelButton == 'ql'){
                this.$notify({
                  message: this.trans('pgno.notify_cel_rezhim_more_perf'),
                  type: 'error',
                  size: 'sm',
                  timeout: 8000
                }) 
              } else if(this.bhpPot * 1  > this.bhpCelValue.split(' ')[0] * 1  && this.CelButton == 'bhp'){
                this.$notify({
                  message: this.trans('pgno.notify_cel_rezhim_more_perf'),
                  type: 'error',
                  size: 'sm',
                  timeout: 8000
                }) 
              } else if(this.pinPot * 1  > this.piCelValue.split(' ')[0] * 1  && this.CelButton == 'pin'){
                this.$notify({
                  message: this.trans('pgno.notify_cel_rezhim_more_perf'),
                  type: 'error',
                  size: 'sm',
                  timeout: 8000
                }) 
              }
            }

          } else {
          }
        }).finally(() => {
          this.isLoading = false;
        });
      }

    },

    postAnalysisOld() {
      this.isVisibleChart = true;
      let uri = this.url + this.field + "/" + this.wellNumber + "/";
      if (this.CelButton == 'ql') {
        this.CelValue = this.qlCelValue
      } else if (this.CelButton == 'bhp') {
        this.CelValue = this.bhpCelValue
      } else if (this.CelButton == 'pin') {
        this.CelValue = this.piCelValue
      }
      this.menu = "PotencialAnalysis"

      this.prepareData()

      this.isLoading = true;

      this.axios.post(uri, this.postdata).then((response) => {
        let data = response.data;
        if (data) {
          this.method = "CurveSetting"
          this.newData = data["Well Data"]
          this.newCurveLineData = JSON.parse(data.LineData)["data"]
          this.newPointsData = JSON.parse(data.PointsData)["data"]
          this.updateLine(this.newCurveLineData)
          this.setPoints(this.newPointsData)
        } else {
        }
      }).finally(() => {
        this.isLoading = false;
      });
    },

    postAnalysisNew() {
      this.isVisibleChart = true;
      let uri = this.url + this.field + "/" + this.wellNumber + "/";
      if (this.CelButton == 'ql') {
        this.CelValue = this.qlCelValue
      } else if (this.CelButton == 'bhp') {
        this.CelValue = this.bhpCelValue
      } else if (this.CelButton == 'pin') {
        this.CelValue = this.piCelValue
      }
      this.menu = "PotencialAnalysis"

      this.prepareData()

      this.isLoading = true;

      this.axios.post(uri, this.postdata).then((response) => {
        let data = response.data;
        if (data) {
          this.newData = data["Well Data"]
          this.method = "CurveSetting"
          this.newCurveLineData = JSON.parse(data.LineData)["data"]
          this.newPointsData = JSON.parse(data.PointsData)["data"]
          this.nearWells = JSON.parse(data.NearWells)["data"]
          this.updateLine(this.newCurveLineData)
          this.setPoints(this.newPointsData)
          this.wellOkr = data["Well Data"]["well"]
          this.piOkr = data["Well Data"]["pi"].toFixed(2)
          this.khOkr = data["Well Data"]["kh"].toFixed(1)
          this.skinOkr = data["Well Data"]["skin"].toFixed(1)
          this.presOkr = data["Well Data"]["p_res"].toFixed(0)
          this.wctOkr = data["Well Data"]["wct"].toFixed(0)
        } else {
        }
      }).finally(() => {
        this.isLoading = false;
      });
    },
    setGraphOld() {
      this.updateLine(this.newCurveLineData)
      this.setPoints(this.newPointsData)
      this.$modal.hide('modalOldWell');
      this.$eventBus.$emit('newCurveLineData', this.newCurveLineData)
      this.$eventBus.$emit('newPointsData', this.newPointsData)
      this.pResInput = this.newData["p_res"].toFixed(0)  + " " +  this.trans('measurements.atm');
      this.piInput = this.newData["pi"].toFixed(2)  + " " +  this.trans('measurements.m3/d/atm');
      this.qLInput = this.newData["q_l"].toFixed(0)  + " " +  this.trans('measurements.m3/day');
      this.bhpInput = this.newData["bhp"].toFixed(0)  + " " +  this.trans('measurements.atm');
      this.hDynInput = this.newData["h_dyn"].toFixed(0) + " " +  this.trans('measurements.m');
      this.pAnnularInput = this.newData["p_annular"].toFixed(0)  + " " +  this.trans('measurements.atm');
      this.pManomInput = this.newData["p_intake"].toFixed(0)  + " " +  this.trans('measurements.atm');
      this.hPumpManomInput = this.newData["h_pump_set"].toFixed(0)  + " " +  this.trans('measurements.m');
      this.whpInput = this.newData["whp"].toFixed(0)  + " " +  this.trans('measurements.atm');
      this.wctInput = this.newData["wct"].toFixed(0)  + " " +  this.trans('measurements.percent');
      this.qlCelValue = this.newPointsData[0]["q_l"].toFixed(0)  + " " +  this.trans('measurements.m3/day');
      this.bhpCelValue = this.newPointsData[0]["p"].toFixed(0)  + " " +  this.trans('measurements.atm');
      this.piCelValue = this.newPointsData[0]["pin"].toFixed(0)  + " " +  this.trans('measurements.atm');
    },

    setGraphNew() {
       this.$notify({
        message: this.trans('pgno.notify_150_hpump'),
        type: 'warning',
        size: 'sm',
        timeout: 8000
      }) 
      
      this.updateLine(this.newCurveLineData)
      this.setPoints(this.newPointsData)
      this.$modal.hide('modalNewWell');
      this.$eventBus.$emit('newCurveLineData', this.newCurveLineData)
      this.$eventBus.$emit('newPointsData', this.newPointsData)
      this.pResInput = this.newData["p_res"].toFixed(0)  + " " +  this.trans('measurements.atm');
      this.piInput = this.newData["pi"].toFixed(2)  + " " +  this.trans('measurements.m3/d/at');
      this.wctInput = this.newData["wct"].toFixed(0)  + " " +  this.trans('measurements.percent');
      this.hPumpValue = this.newData["h_pump_set"].toFixed(0)  + " " +  this.trans('measurements.m');
    },

    onCompareNpv() {
      if(this.expAnalysisData.ecnNpv > this.expAnalysisData.shgnNpv) {
        this.expChoose = "ЭЦН"
      } else {
        this.expChoose = "ШГН"
      }
      this.$modal.hide("modalExpAnalysis");
      this.postCurveData();
    },

    onShowTable() {
      this.$modal.hide("modalExpAnalysis");
      this.$modal.show("tablePGNO")
    },

    onPgnoClick() {
      if(this.qlPot * 1 < this.qlCelValue.split(' ')[0] * 1 && this.CelButton == 'ql'){
        this.$notify({
          message: this.trans('pgno.notify_cel_rezhim_more_perf'),
          type: 'error',
          size: 'sm',
          timeout: 8000
        }) 
      } else if(this.bhpPot * 1  > this.bhpCelValue.split(' ')[0] * 1  && this.CelButton == 'bhp'){
        this.$notify({
          message: this.trans('pgno.notify_cel_rezhim_more_perf'),
          type: 'error',
          size: 'sm',
          timeout: 8000
        }) 
      } else if(this.pinPot * 1  > this.piCelValue.split(' ')[0] * 1  && this.CelButton == 'pin'){
        this.$notify({
          message: this.trans('pgno.notify_cel_rezhim_more_perf'),
          type: 'error',
          size: 'sm',
          timeout: 8000
        }) 
      } else {
        if(this.expChoose == 'ШГН'){
          if (this.CelButton == 'ql') {
            this.CelValue = this.qlCelValue
          } else if (this.CelButton == 'bhp') {
            this.CelValue = this.bhpCelValue
          } else if (this.CelButton == 'pin') {
            this.CelValue = this.piCelValue
          }
          if(this.isVisibleChart) {
            let uri = "http://127.0.0.1:7575/api/pgno/shgn";
            this.prepareData()
            this.axios.post(uri, this.postdata).then((response) => {
              let data = JSON.parse(response.data);
              this.fetchBlockCentrators();
              if(data) {
                if (data["error"] == "NoIntersection") {
                  this.$notify({
                    message: this.trans('pgno.notify_change_depth_descent'),
                    type: 'warning',
                    size: 'sm',
                    timeout: 8000
                  }) 
                } else {
                  if(this.sk == "ПШГН" || this.sk == "0") {
                    this.$notify({
                      message: this.trans('pgno.notify_well_not_def'),
                      type: 'warning',
                      size: 'sm',
                      timeout: 8000
                    })   
                  }
                  this.shgnPumpType = data["pump_type"]
                  if(this.shgnPumpType == 70) {
                    this.shgnTubOD = 89
                  } else {
                    this.shgnTubOD = this.tubOD
                  }
                  if(this.shgnPumpType == 70 && this.casOD * 1 < 115) {
                      this.$notify({
                        message: this.trans('pgno.notify_nkn70_nkt89_restricted'),
                        type: 'warning',
                        size: 'sm',
                        timeout: 8000
                      })
                      this.$notify({
                        message: this.trans('pgno.notify_change_depth_descent'),
                        type: 'warning',
                        size: 'sm',
                        timeout: 8000
                      })
                  } else {
                      this.$notify({
                          message: this.trans('pgno.notify_shgn_under_contstruction'),
                          type: 'warning',
                          size: 'sm',
                          timeout: 8000
                        })
                    
                    this.shgnSPM = data["spm"].toFixed(0)
                    this.shgnLen = data["stroke_len"]
                    this.shgnS1D = data["s1d"].toFixed(0)
                    this.shgnS2D = data["s2d"].toFixed(0)
                    this.shgnS1L = data["s1l"].toFixed(0)
                    this.shgnS2L = data["s2l"].toFixed(0)
                    this.shgnTN = data["tn"]
                    this.shgnTNL = data["tn_l"]
                    this.isVisibleChart = !this.isVisibleChart
                  }

                }
              } else {
              }
            }).finally(() => {
              this.isLoading = false;
            })
          } else {
            this.isVisibleChart = !this.isVisibleChart
            this.postCurveData()

          }
        } else {
          
          this.$notify({
            message: this.trans('pgno.notify_uecn_ne_razrabotan'),
            type: 'warning',
            size: 'sm',
            timeout: 8000
          })
        }

      }
    },
    setActiveRightTabName: function (e, val) {
      if (val === this.activeRightTabName && (this.windowWidth > 1300 || this.windowWidth <= 991)) {
        this.activeRightTabName = 'technological-mode';
        return;
      }

      if (val === this.activeRightTabName && this.windowWidth <= 1300 && this.windowWidth > 991) {
        this.activeRightTabName = 'devices';
        return;
      }

      if (val === 'technological-mode' && this.windowWidth <= 1300 && this.windowWidth > 991) {
        return;
      }

      this.activeRightTabName = val;
    },

    onPrsButtonClick() {
      this.$modal.show('modal-prs')
    },

    createPDF() {

      this.isLoading = true;

      htmlToImage.toPng(this.$refs['gno-page'])
        .then(function (dataUrl) {
          let img = new Image();
          let pdf = new jsPDF({
            orientation: 'p',
            unit: 'mm',
            format: 'a4'
          })
          img.src = dataUrl;


          pdf.addImage(dataUrl, 'png', 10, 1, 180, 300);
          pdf.save('test.pdf')
        })
        .catch(function (error) {
          console.error('oops, something went wrong!', error);
        }).finally(() => {
            this.isLoading = false;
      });
    },

    takePDF() {
      this.isLoading = true;
      htmlToImage.toPng(this.$refs['gno-chart'])
        .then(function (dataUrl) {
          let img = new Image();
          let pdf = new jsPDF({
            orientation: 'p',
            unit: 'mm',
            format: 'a4'
          })
          img.src = dataUrl;


          pdf.addImage(dataUrl, 'png', 10, 1, 180, 80);
          pdf.save('test.pdf')
        })
        .catch(function (error) {
          console.error('oops, something went wrong!', error);
        }).finally(() => {
            this.isLoading = false;
      });
    },

    takePhoto() {
     this.isLoading = true;

      htmlToImage.toPng(this.$refs['gno-chart'])
        .then(function (dataUrl) {
          let link = document.createElement('a');
          link.setAttribute('href', dataUrl);
          link.setAttribute('download','download');
          link.click();
          link.remove();
        })
        .catch(function (error) {
          console.error('oops, something went wrong!', error);
        }).finally(() => {
            this.isLoading = false;
      });

    },

    takePhotoOldNewWell() {
     this.isLoading = true;
      
      htmlToImage.toPng(this.$refs['gno-chart-new-old-well'])
        .then(function (dataUrl) {
          let link = document.createElement('a');
          link.setAttribute('href', dataUrl);
          link.setAttribute('download','download');
          link.click();
          link.remove();
        })
        .catch(function (error) {
          console.error('oops, something went wrong!', error);
        }).finally(() => {
            this.isLoading = false;
      });

    },
  },
  created() {
    window.addEventListener("resize", () => {
      this.windowWidth = window.innerWidth;
    });

    let langUrl = `${window.location.pathname}`.slice(1, 3);
    if(langUrl === 'ru') {
      this.layout.xaxis.title = this.titleXRu
      this.layout.yaxis.title = this.titleYRu
    } else if(langUrl === 'kz') {  
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
  }
};