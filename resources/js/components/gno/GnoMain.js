import {
  pgnoMapState,
  pgnoMapGetters,
  pgnoMapMutations,
  pgnoMapActions,
} from "@store/helpers";
import { Plotly } from "vue-plotly";
import NotifyPlugin from "vue-easy-notify";
import "vue-easy-notify/dist/vue-easy-notify.css";
import { PerfectScrollbar } from "vue2-perfect-scrollbar";
import "vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css";
import Vue from "vue";
import FullPageLoader from "@ui-kit/FullPageLoader";
import * as htmlToImage from "html-to-image";
import jsPDF from "jspdf";
import Tabs from "./components/tabs/Tabs.vue";
import { globalloadingMutations } from "@store/helpers";

const fileDownload = require("js-file-download");

Vue.use(NotifyPlugin);

export default {
  components: { PerfectScrollbar, FullPageLoader, Tabs, Plotly },
  props: ["params"],
  computed: {
    ...pgnoMapState([
      "calcedWell",
      'wellAnalysis',
      'linesAnalysis',
      'pointsAnalysis',
      "well",
      "lines",
      "points",
      "shgnSettings",
      "analysisSettings",
      "centralizer_range",
    ]),
    ...pgnoMapGetters([
      'curveSettingsStore'
    ])
  },
  data: function() {
    return {
      apiUrl: process.env.MIX_PGNO_API_URL,
      updateCurveTrigger: true,
      analysisTrigger: true,
      bhpTargetValue: null,
      pintakeTargetValue: null,

      devBlockDmPumps: null,
      devBlockNumSwings: null,

      devBlockRatedFeed: null,
      devBlockFrequency: null,

      steel: null,
      freegasCel: null,
      techmodeDate: null,
      404: require("./images/404.svg"),
      isSkError: false,
      nearDist: 1000,
      perms: this.params,
      isEditing: false,
      permissionName: "podborGno edit main",
      activeRightTabName: "technological-mode",
      curveSettings: {},
      lines_analysis: {},
      points_analysis: {},
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
      curveSelect: "pi",
      curveValue: "",
      curveQselect: null,
      curr: null,
      expChoose: null,
      targetButton: "ql",
      bhpCurveButton: "",
      qL: null,
      qlTargetValue: null,
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
      isAnalysisBoxValue9: true,
      nk_fields: [
        {
          short_name: "UZN",
          full_name: "Узень",
          id: 0,
        },
        {
          short_name: "KMB",
          full_name: "Карамандыбас",
          id: 1,
        },
        {
          short_name: "JET",
          full_name: "Жетыбай",
          id: 2,
        },
        {
          short_name: "ASA",
          full_name: "Асар",
          id: 3,
        },
      ],
      omg_fields: [
        {
          short_name: "UZN",
          full_name: "Узень",
        },
        {
          short_name: "KMB",
          full_name: "Карамандыбас",
        },
      ],
      mmg_fields: [
        {
          short_name: "JET",
          full_name: "Жетыбай",
        },
        {
          short_name: "ASA",
          full_name: "Асар",
        },
      ],
      shgnTubOD: null,
      menu: "MainMenu",
      ngdu: null,
      sk: null,
      hasGrp: false,
      newData: null,
      strokeLenDev: null,
      spmDev: "1/мин",
      expAnalysisData: {
        NNO1: null,
        NNO2: null,
        fieldNNO1: null,
        fieldNNO2: null,
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
        nno1: null,
        nno2: null,
      },

      qZhExpEcn: null,
      qOilExpEcn: null,
      qZhExpShgn: null,
      qOilExpShgn: null,
      q1ZhidM3: null,
      q2ZhidM3: null,
      param_eco: null,
      param_org: null,
      param_fact: null,
      welldata: null,
      field: null,
      wellIncl: null,
      dataNNO: "2020-11-01",
      nearWells: [],
      windowWidth: null,

      wellOkr: null,
      piOkr: null,
      khOkr: null,
      skinOkr: null,
      presOkr: null,
      stanokKachalka: null,
      freq: "Число качаний",
      dNasosa: "Диаметр насоса",
      hasStrokeLength: false,
      krsTable: [],
      numberRepairs: null,
      numberNNO: null,
      langUrl: "",
      sep_meth: "input_value",
      nat_sep: true,
      mech_sep: null,
      es: null,
      mechanicalSeparationValue: 50,
      pBuf: 4,
      ao: null,
      orgs: null,
      nkt: null,
      liftValue: "ШГН",
      stepValue: 10,
      strokeLenMin: null,
      strokeLenMax: null,
      spmMin: null,
      spmMax: null,
      kpodMin: null,
      groupPosad: null,
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
        },
      ],
      hPumpFromIncl: null,
      isButtonHpump: false,
      postdata: null,
      inflowCurveTitle: this.trans("pgno.krivaya_pritoka"),
      podborGnoTitle: this.trans("pgno.podbor_gno"),
      serviceOffline: false,
      isIntervals: false,
      skTypes: null,
      horizons: null,
      skType: null,
      horizon: null,
      isNktError: null,
      spm: null,
      qLforKpod: null,
      pumpTypeforKpod: null,
    };
  },
  watch: {
    curveSelect(newVal) {
      if (newVal === "pi") {
        this.curveQselect = null;
      } else {
        this.curveQselect = "hdyn";
      }
    },
    curveQselect(newVal) {
      if (newVal === "hdyn") {
        this.curveSelect = "hdyn";
      }
    },
  },
  beforeCreate: function() {
    this.apiUrl = process.env.MIX_PGNO_API_URL;
    this.axios.get("/ru/organizations").then(({ data }) => {
      if (data.organizations.length == 0) {
        this.organization = "НК КазМунайГаз";
      } else {
        this.organization = data.organizations[0]["name"];
      }
      if (this.organization == "АО «ОзенМунайГаз»") {
        this.orgs = this.omg_fields;
      } else if (this.organization == "НК КазМунайГаз") {
        this.orgs = this.nk_fields;
      } else if (this.organization == "АО «Мангистаумунайгаз»") {
        this.orgs = this.mmg_fields;
      }
    });

    this.axios.get(this.apiUrl + "status/").then((response) => {
      if (response.status !== 200) {
        this.serviceOffline = true;
      }
    });

    this.axios.get(this.apiUrl + "lastdate/").then((response) => {
      this.techmodeDate = response.data["date"];
    });

    this.axios.get(this.apiUrl + "sk_types").then((response) => {
      this.skTypes = response.data;
    });
    this.axios.get(this.apiUrl + "horizons").then((response) => {
      this.horizons = response.data;
    });
  },
  mounted() {
    this.windowWidth = window.innerWidth;

    if (this.windowWidth <= 1300 && this.windowWidth > 991) {
      this.activeRightTabName = "devices";
    }
  },
  methods: {
    ...globalloadingMutations(["SET_LOADING"]),
    ...pgnoMapActions([
      "setDefault",
      "getWell",
      "postWell",
      "setCurveSettings",
      "getInclinometry",
    ]),
    setNotify(message, title, type) {
      this.$bvToast.toast(message, {
        title: title,
        variant: type,
        solid: true,
        toaster: "b-toaster-top-center",
        autoHideDelay: 8000,
      });
    },
    setCurveData(well, points) {
      this.curveSettings.pResInput = well.pRes.toFixed(0);
      this.curveSettings.piInput = well.pi.toFixed(2);
      this.curveSettings.qLInput = well.qL.toFixed(0);
      this.curveSettings.wctInput = well.wct.toFixed(0);
      this.curveSettings.gorInput = well.gor.toFixed(0);

      this.curveSettings.bhpInput = well.bhp.toFixed(0);
      this.curveSettings.hDynInput = well.hDyn.toFixed(0);
      this.curveSettings.pAnnularInput = well.pAnnular.toFixed(0);
      this.curveSettings.pManomInput = well.pIntake.toFixed(0);
      this.curveSettings.hPumpManomInput = well.hPumpSet.toFixed(0);
      this.curveSettings.whpInput = well.whp.toFixed(0);
      this.curveSettings.expChoosen = well.expMeth;
      this.curveSettings.pBuff = well.whp.toFixed(0);
      this.curveSettings.hPumpValue = well.hPumpSet.toFixed(0);

      this.curveSettings.es = (well.es * 100).toFixed(0);
      this.curveSettings.mechanicalSeparation = well.mechanicalSeparation;
      this.curveSettings.mechanicalSeparationValue = well.mechanicalSeparationValue;
      this.curveSettings.naturalSeparation = well.naturalSeparation;

      if (well.newWell || well.wellError==="no_well_data"){
        this.curveSettings.qlTargetValue = 0
        this.curveSettings.bhpTargetValue = 0
        this.curveSettings.pintakeTargetValue = 0
      } else {
        this.curveSettings.qlTargetValue = points.qlCelValue.toFixed(0);
        this.curveSettings.bhpTargetValue = points.bhpCelValue.toFixed(0);
        this.curveSettings.pintakeTargetValue = points.piCelValue.toFixed(0);

      }

    },

    skExist(skType) {
      return this.skTypes.some(function(sk) {
        return sk.sk_name === skType;
      }); 
    },

    async getWellData(wellnumber) {
      this.isIntervals = true;
      this.SET_LOADING(true);
      this.isVisibleChart = true;
      this.setDefault();
      if (["JET", "ASA"].includes(this.field)) {
        this.ao = 'АО "ММГ"';
      } else if (["UZN", "KMB"].includes(this.field)) {
        this.ao = 'АО "ОМГ"';
      } else {
        this.ao = null;
      }

      let url = this.apiUrl + this.field + "/" + wellnumber;
      await this.getWell(url);
      this.curveSettings.separationMethod = this.well.separationMethod;
      if (this.well.expMeth === "ШГН") {
        this.curveSelect = "hdyn";
        this.mech_sep = false;
      } else if (this.well.expMeth === "ЭЦН") {
        this.curveSelect = "hdyn";
        this.mech_sep = true;
      } else if (this.well.expMeth === "ФОН") {
        this.curveSelect = "whp";
      }
      this.setCurveData(this.well, this.points);
      if (this.well.qL < 20) {
        this.curveSettings.mechanicalSeparationValue = 95;
      } else if (this.well.qL < 55) {
        this.curveSettings.mechanicalSeparationValue = 60;
      } else {
        this.curveSettings.mechanicalSeparationValue = 50;
      }

      if (this.well.newWell) {
        this.curveSelect = "pi";
        this.setNotify(
          this.trans("pgno.notify_150_hpump"),
          "Warning",
          "warning"
        );
        this.setNotify(this.trans("pgno.new_well"), "Warning", "warning");
      }
      this.curveSettings.targetButton = "ql";
      this.curveSettings.nkt = this.well.tubId;
      this.skType = this.well.skType;
      this.horizon = this.well.horizon;
      if (this.well.wellError==="no_well_data"){
        this.setNotify(this.trans('pgno.notify_well_doesnt_exist'), "Error", 'danger')
      } else if (!this.well.newWell && !this.skExist(this.skType)) {
        this.setNotify(this.trans("pgno.notify_error_sk"), "Warning", "warning");
        this.nktExist("get")
      }
      this.setCurveSettings(this.curveSettings);
      this.updateCurveTrigger = !this.updateCurveTrigger;
      this.SET_LOADING(false);
    },
    editPage() {
      if (this.isEditing) {
        this.well.skType = this.skType
        this.well.horizon = this.horizon
      }
      this.isEditing = !this.isEditing
    },
    async postCurveData() {
      this.isVisibleChart = true;
      this.SET_LOADING(true);
      if (this.well.casOd < 127) {
        this.setNotify(
          this.trans("pgno.notify_ek_127_down"),
          "Error",
          "danger"
        );
      }
      if (
        this.curveSettings.qlTargetValue < 28 &&
        this.curveSettings.expChoosen == "ЭЦН"
      ) {
        this.setNotify(
          this.trans("pgno.notify_uecn_not_recommended"),
          "Warning",
          "warning"
        );
      }
      if (this.curveSettings.qlTargetValue > 106) {
        this.setNotify(
          this.trans("pgno.notify_shgn_restrict_potencial"),
          "Warning",
          "warning"
        );
      }
      this.curveSettings.es = this.curveSettings.es / 100
      this.curveSettings.curveSelect = this.curveSelect
      var payload = {};
      payload.url = this.apiUrl + "calculate";
      payload.data = {
        shgn_settings: this.shgnSettings,
        well: this.well,
        curve_settings: this.curveSettings,
        analysis_settings: this.analysisSettings,
      };
      var isPostSuccess = await this.postWell(payload);
      if (!isPostSuccess){
        this.curveSettings.es = this.curveSettings.es * 100
        this.SET_LOADING(false);
        return
      }
      this.setCurveData(this.calcedWell, this.points);
      if (this.curveSettings.piInput < 0) {
        this.setNotify(
          this.trans("pgno.notify_p_zab_more_p_pl"),
          "Warning",
          "warning"
        );
      } else {
        if (this.curveSettings.hPumpValue > this.well.hUpPerfVd) {
          this.setNotify(
            this.trans("pgno.notify_n_set_down_perf"),
            "Warning",
            "warning"
          );
        }
      }
      this.updateCurveTrigger = !this.updateCurveTrigger;
      this.SET_LOADING(false);
    },
    raiseTargetNotify() {
      if (
        this.points.qlPotencial < this.curveSettings.qlTargetValue &&
        this.targetButton == "ql"
      ) {
        this.setNotify(
          this.trans("pgno.notify_cel_rezhim_more_perf"),
          "Error",
          "danger"
        );
        return true;
      } else if (
        this.points.bhpPotencial > this.curveSettings.bhpTargetValue &&
        this.targetButton == "bhp"
      ) {
        this.setNotify(
          this.trans("pgno.notify_cel_rezhim_more_perf"),
          "Error",
          "danger"
        );
        return true;
      } else if (
        this.points.pintakePotencial > this.curveSettings.pintakeTargetValue &&
        this.targetButton == "pin"
      ) {
        this.setNotify(
          this.trans("pgno.notify_cel_rezhim_more_perf"),
          "Error",
          "danger"
        );
        return true;
      } else {
        return false;
      }
    },
    openEcoModal() {
      if (this.well.casOd < 127) {
        this.setNotify(this.trans("pgno.notify_ek_127"), "Error", "danger");
      }

      if (this.curveSettings.qlTargetValue < 28) {
        this.setNotify(
          this.trans("pgno.notify_uecn_not_recommended"),
          "Warning",
          "warning"
        );
      }

      if (this.curveSettings.qlTargetValue > 106) {
        this.setNotify(
          this.trans("pgno.notify_shgn_restrict_potencial"),
          "Warning",
          "warning"
        );
      }
      this.$modal.show("modalExpAnalysis");
    },
    openPrsModal() {
      this.$modal.show("modal-prs");
    },
    closeModal(modalName) {
      this.$modal.hide(modalName);
    },
    openInclinometryModal() {
      if (this.well.newWell) {
        this.setNotify(this.trans("pgno.notify_no_incl"), "Warning", "warning");
      } else if (!this.wellNumber) {
        this.setNotify("Выберите скважину", "Warning", "warning");
      } else {
        this.$modal.show("modalIncl");
      }
    },
    closeAnalysisModal() {
      this.updateCurveTrigger = !this.updateCurveTrigger;
      this.setCurveData(this.wellAnalysis, this.points);
      this.$modal.hide("analysisMenu");
    },
    openEcoTableModal() {
      this.$modal.hide("modalExpAnalysis");
      this.$modal.show("tablePGNO");
    },
    closeEcoTableModal() {
      this.$modal.hide("tablePGNO");
      this.$modal.show("modalExpAnalysis");
    },
    closeInclModal() {
      this.$modal.hide("modalIncl");
      this.curveSettings.hPumpValue = this.curveSettingsStore.hPumpValue;
      this.postCurveData();
      
    },
    openAnalysisModal() {
      this.$modal.show('analysisMenu');
    },
    closeAnalysisModal() {
      this.updateCurveTrigger = !this.updateCurveTrigger
      this.setCurveData(this.wellAnalysis, this.points)
      this.$modal.hide("analysisMenu");
    },

    openTabsModal() {
      if (this.well.qL && this.curveSettings.qLInput !== 0) {
        this.qLforKpod = this.curveSettings.qLInput;
        this.pumpTypeforKpod = this.curveSettings.pumpType;
      }
      this.$modal.show("modalTabs");
    },
    closeTabsModal() {
      this.$modal.hide("modalTabs");
      this.postCurveData();
    },
    nktExist(val) {
      const found = this.nkt_choose.some(
        (el) => el.for_calc_value === this.curveSettings.nkt
      );
      if (!found) {
        let type
        let title
        if (val === "get") {
          type = "warning";
          title = "Warning";
        } else if (val === "pgno") {
          title = "Error";
          type = "danger";
        }
        this.setNotify(this.trans("pgno.check_nkt_notify"), title, type);
      }
      return found
    },
    onPgnoClick() {
      var nktError = this.nktExist("pgno")
      var errorCheck = this.raiseTargetNotify();
      if (!this.skExist(this.skType)) {
        this.setNotify(this.trans("pgno.notify_error_sk"), "Error", "danger");
      } else if (errorCheck || nktError) {
        if (this.curveSettings.expChoosen == "ШГН") {
          if (this.isVisibleChart) {
            this.SET_LOADING(true);
            var payload = {
              shgn_settings: this.shgnSettings,
              well: this.well,
              curve_settings: this.curveSettings,
              analysis_settings: this.analysisSettings,
              points: this.points,
            };
            this.axios
              .post(this.apiUrl + "shgn", payload)
              .then((response) => {
                let data = response.data;
                if (!this.well.newWell) {
                  this.fetchBlockCentrators();
                } else {
                  this.centratorsRequiredValue = [];
                }
                if (this.skType == "ПШГН" || this.skType == "0") {
                  this.setNotify(
                    this.trans("pgno.notify_well_not_def"),
                    "Warning",
                    "warning"
                  );
                }
                if (data.kPodData["pump_type"] == 70) {
                  this.shgnTubOD = 89;
                } else {
                  this.shgnTubOD = this.well.tubOd;
                }
                if (data.kPodData["pump_type"] && this.well.casOd < 115) {
                  this.setNotify(
                    this.trans("pgno.notify_nkn70_nkt89_restricted"),
                    "Warning",
                    "warning"
                  );
                  this.setNotify(
                    this.trans("pgno.notify_change_depth_descent"),
                    "Warning",
                    "warning"
                  );
                } else {
                  this.setNotify(
                    this.trans("pgno.notify_shgn_under_contstruction"),
                    "Warning",
                    "warning"
                  );
                  this.shgnPumpType = data.kPodData["pump_type"]

                  this.freegasCel = this.points.freegasCelValue.toFixed(1),
                  this.qoilShgnTable = this.points.qoCelValue.toFixed(1);
                  this.construction = data.construction;
                  this.shgnSPM = data.kPodData["spm_calc"].toFixed(1);
                  this.shgnLen = data.kPodData["stroke_lens"].toFixed(1);
                  this.kPod = data.kPodData["k_pod"].toFixed(2);
                  this.skPmax = data.checks["sk_pmax"];
                  this.skMn2 = data.checks["sk_mn2"];
                  this.steel = data.checks["steel"];
                  this.pElectricity = (
                    data.checks["p_electricity"] / 1000
                  ).toFixed(0);
                  this.wDay = data.checks["w_day"].toFixed(0);
                  this.ure = data.checks["ure"].toFixed(1);
                  if (data.checks["load_limit_check"]["type"] === "warning") {
                    var message = `${this.trans("pgno.load_warning")} ${
                      data.checks["load_limit_check"]["value"]
                    } ${this.trans("measurements.percent")}`;
                    this.setNotify(message, "Warning", "warning");
                  } else if (
                    data.checks["load_limit_check"]["type"] === "error"
                  ) {
                    this.setNotify(
                      this.trans("pgno.shtang_not_recommended"),
                      "Error",
                      "danger"
                    );
                  }
                  if (data.checks["load_check"] === "error") {
                    this.setNotify(
                      this.trans("pgno.balance_more_100"),
                      "Error",
                      "danger"
                    );
                  } else if (data.checks["load_check"] === "warning") {
                    this.setNotify(
                      this.trans("pgno.balance_more_80"),
                      "Warning",
                      "warning"
                    );
                  }
                  if (data.checks["load_reduct_check"] === "error") {
                    this.setNotify(
                      this.trans("pgno.max_reductor"),
                      "Error",
                      "danger"
                    );
                  }
                  this.isVisibleChart = !this.isVisibleChart;
                }
              })
              .catch((error) => {
                if (error.request) {
                  var data = error.response.data;
                  if (data["detail"] == "No intersection") {
                    this.setNotify(
                      this.trans("pgno.notify_change_depth_descent"),
                      "Warning",
                      "warning"
                    );
                  } else if (data["detail"] == "KpodError") {
                    this.setNotify(
                      this.trans("pgno.kpod_more_params"),
                      "Warning",
                      "warning"
                    );
                  } else if (data["detail"] == "ConstructionError") {
                    this.setNotify(
                      this.trans("pgno.cant_calc_construction"),
                      "Warning",
                      "warning"
                    );
                  }
                }
              })
              .finally(() => {
                this.SET_LOADING(false);
              });
          } else {
            this.isVisibleChart = !this.isVisibleChart;
            this.postCurveData();
          }
        } else {
          this.setNotify(
            this.trans("pgno.notify_uecn_ne_razrabotan"),
            "Warning",
            "warning"
          );
        }
      }
    },
    downloadExcel(menu) {
      this.SET_LOADING(true);
      if (menu === "analysis"){
        var payload = {
          shgn_settings: this.shgnSettings,
          well: this.wellAnalysis,
          curve_settings: this.curveSettings,
          analysis_settings: this.analysisSettings,
          points: this.pointsAnalysis,
          lines: this.linesAnalysis,
        };
      } else {
        var payload = {
          shgn_settings: this.shgnSettings,
          well: this.well,
          curve_settings: this.curveSettings,
          analysis_settings: this.analysisSettings,
          points: this.points,
          lines: this.lines,
        };
      }
      
      this.axios.post(this.apiUrl + "excel/download", payload, { responseType: "blob" }).then((response) => {
        fileDownload(response.data, "ПГНО_" + this.field + "_" + this.wellNumber + ".xlsx")
      }).catch(function (error) {
        console.error('oops, something went wrong!', error);
      }).finally(() => {
        this.SET_LOADING(false);
      });
    },

    downloadEconomicExcel() {
      this.SET_LOADING(true);
      let req = [
        this.expAnalysisData.npvTable1,
        this.expAnalysisData.npvTable2,
      ];
      this.axios
        .post(this.apiUrl + "economic/download", req, { responseType: "blob" })
        .then((response) => {
          fileDownload(
            response.data,
            "ЭКОНОМИКА_" + this.field + "_" + this.wellNumber + ".xlsx"
          );
        })
        .catch(function(error) {
          console.error("oops, something went wrong!", error);
        })
        .finally(() => {
          this.SET_LOADING(false);
        });
    },
    async fetchBlockCentrators() {
      var payload = {};
      var stepValue;
      if (this.curveSettings.expChoosen == "ЭЦН") {
        stepValue = 20;
      } else {
        stepValue = 10;
      }
      payload.url = `${this.apiUrl}inclinometry/${this.well.fieldUwi}/${this.well.wellUwi}`;
      payload.data = {
        expMeth: this.curveSettings.expChoosen,
        hPumpSet: this.curveSettings.hPumpValue,
        inclinometryStep: stepValue,
        calculateMethod: this.stepCalc,
      };
      await this.getInclinometry(payload);
      this.centratorsRequiredValue = this.centralizer_range["red"];
    },
    setActiveRightTabName: function(e, val) {
      if (
        val === this.activeRightTabName &&
        (this.windowWidth > 1300 || this.windowWidth <= 991)
      ) {
        this.activeRightTabName = "technological-mode";
        return;
      }

      if (
        val === this.activeRightTabName &&
        this.windowWidth <= 1300 &&
        this.windowWidth > 991
      ) {
        this.activeRightTabName = "devices";
        return;
      }

      if (
        val === "technological-mode" &&
        this.windowWidth <= 1300 &&
        this.windowWidth > 991
      ) {
        return;
      }

      this.activeRightTabName = val;
    },
    takePhoto() {
      this.SET_LOADING(true);

      htmlToImage
        .toPng(this.$refs["gno-chart"])
        .then(function(dataUrl) {
          let link = document.createElement("a");
          link.setAttribute("href", dataUrl);
          link.setAttribute("download", "download");
          link.click();
          link.remove();
        })
        .catch(function(error) {
          console.error("oops, something went wrong!", error);
        })
        .finally(() => {
          this.SET_LOADING(false);
        });
    },
    takePhotoOldNewWell() {
      this.SET_LOADING(true);

      htmlToImage
        .toPng(this.$refs["gno-chart-new-old-well"])
        .then(function(dataUrl) {
          let link = document.createElement("a");
          link.setAttribute("href", dataUrl);
          link.setAttribute("download", "download");
          link.click();
          link.remove();
        })
        .catch(function(error) {
          console.error("oops, something went wrong!", error);
        })
        .finally(() => {
          this.SET_LOADING(false);
        });
    },
  },
  created() {
    window.addEventListener("resize", () => {
      this.windowWidth = window.innerWidth;
    });
    this.setDefault();
  },
};
