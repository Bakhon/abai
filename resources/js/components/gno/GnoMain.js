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
import Tabs from "./components/tabs/Tabs.vue";
import { globalloadingMutations } from "@store/helpers";
import _ from 'lodash'
import orgSample from "./jsons/orgs.json";

const fileDownload = require("js-file-download");

Vue.use(NotifyPlugin);

export default {
  components: { PerfectScrollbar, FullPageLoader, Tabs, Plotly },
  props: ["user"],
  computed: {
    ...pgnoMapState([
      "calcedWell",
      'wellAnalysis',
      'linesAnalysis',
      'pointsAnalysis',
      "well",
      "lines",
      "points",
      "analysisSettings",
      "centralizer_range",
      'sensetiveSettings',
      "mainSettings",
    ]),
    ...pgnoMapGetters([
      'curveSettingsStore',
      'shgnSettings'
    ])
  },
  data: function () {
    return {
      apiUrl: process.env.MIX_PGNO_API_URL,
      updateCurveTrigger: true,
      devBlockRatedFeed: null,
      devBlockFrequency: null,
      steel: null,
      techmodeDate: null,
      curveSettings: {},
      lines_analysis: {},
      points_analysis: {},
      construction: {},
      shgnPumpType: null,
      shgnSPM: null,
      shgnLen: null,
      wellNumber: null,
      curveSelect: "pi",
      curveQselect: null,
      fieldsByOrgId: orgSample,
      shgnTubOD: null,
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
      dzos: null,
      dzo: null,
      fields: null,
      field: null,
      isDisabledForKgm: false,
      windowWidth: null,
      ao: null,
      centratorsRequiredValue: null,
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
      isServiceOnline: true,
      skTypes: null,
      horizons: null,
      skType: null,
      horizon: null,
      spm: null,
      calcKpodTrigger: true,
      shgnResult: {},
      centratorsType: String,
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
  beforeCreate: function () {
    this.apiUrl = process.env.MIX_PGNO_API_URL;

    this.axios.get(this.apiUrl + "status").then((response) => {
      this.isServiceOnline = true;
    }).catch((error) => {
      this.isServiceOnline = false
    });

    this.axios.get(this.apiUrl + "lastdate").then((response) => {
      this.techmodeDate = response.data["date"];
    });

    this.axios.get(this.apiUrl + "sk_types").then((response) => {
      this.skTypes = response.data;
      this.skTypes.sort(function (a, b) {
        if (a.sk_name > b.sk_name) {
          return 1;
        }
        if (a.sk_name < b.sk_name) {
          return -1;
        }
        return 0;
      });
    });
    this.axios.get(this.apiUrl + "horizons").then((response) => {
      this.horizons = response.data;
    });
  },
  mounted() {
    this.windowWidth = window.innerWidth;
    if (this.windowWidth <= 1300 && this.windowWidth > 991) {
      this.mainSettings.activeRightTabName = "devices";
    }
  },
  methods: {
    ...globalloadingMutations(["SET_LOADING"]),
    ...pgnoMapActions([
      "setKpodSettings",
      "setDefault",
      "getWell",
      "postWell",
      "setCurveSettings",
      "getInclinometry",
    ]),
    chooseDZO() {
      this.field = null
      this.wellNumber = null
      if (this.dzo ==='ТОО «СП КазГерМунай»') {
        this.isDisabledForKgm = true
        this.curveSettings.expChoosen = "ЭЦН"
      } else {
        this.isDisabledForKgm = false
      }
    },
    setNotify(message, title, type) {
      this.$bvToast.toast(message, {
        title: title,
        variant: type,
        solid: true,
        toaster: "b-toaster-top-center",
        autoHideDelay: 8000,
      });
    },
    raiseTargetNotify() {
      if (this.points.qlPotencial < this.curveSettings.qlTargetValue && this.targetButton == "ql") {
        this.setNotify(this.trans("pgno.notify_cel_rezhim_more_perf"), "Error", "danger");
        return true;
      } else if (this.points.bhpPotencial > this.curveSettings.bhpTargetValue && this.targetButton == "bhp") {
        this.setNotify(this.trans("pgno.notify_cel_rezhim_more_perf"), "Error", "danger");
        return true;
      } else if (this.points.pintakePotencial > this.curveSettings.pintakeTargetValue && this.targetButton == "pin") {
        this.setNotify(this.trans("pgno.notify_cel_rezhim_more_perf"), "Error", "danger");
        return true;
      } else {
        return false;
      }
    },
    isNktExist(val) {
      const found = this.nkt_choose.some(
        (el) => el.for_calc_value === this.curveSettings.nkt
      );
      if (!found) {
        let type
        let title
        if (val === "get") {
          type = "warning";
          title = "Warning";
        }
        if (val === "pgno") {
          title = "Error";
          type = "danger";
        }
        this.setNotify(this.trans("pgno.check_nkt_notify"), title, type);
      }
      return found
    },
    editPage() {
      if (!this.wellNumber) {
        this.setNotify("Выберите скважину", "Error", "danger");
        return
      }
      if (this.mainSettings.isEditing) {
        this.well.skType = this.skType
        this.well.horizon = this.horizon
      }
      this.mainSettings.isEditing = !this.mainSettings.isEditing
    },
    isSkExist(skType) {
      return this.skTypes.some(function (sk) {
        return sk.sk_name === skType;
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
      
      this.curveSettings.whpInput = well.whp.toFixed(0);
      this.curveSettings.expChoosen = well.expMeth;


      this.curveSettings.es = (well.es * 100).toFixed(0);
      this.curveSettings.mechanicalSeparation = well.mechanicalSeparation;
      this.curveSettings.mechanicalSeparationValue = well.mechanicalSeparationValue;
      this.curveSettings.naturalSeparation = well.naturalSeparation;

      if (well.newWell || well.wellError === "no_well_data") {
        this.curveSettings.qlTargetValue = 0
        this.curveSettings.bhpTargetValue = 0
        this.curveSettings.pintakeTargetValue = 0
      } else {
        this.curveSettings.qlTargetValue = points.qlCelValue.toFixed(0);
        this.curveSettings.bhpTargetValue = points.bhpCelValue.toFixed(0);
        this.curveSettings.pintakeTargetValue = points.piCelValue.toFixed(0);

      }

    },
    async getWellData(wellnumber) {
      this.SET_LOADING(true);
      this.mainSettings.isVisibleChart = true;
      this.calcKpodTrigger = true;
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
        var kpod = this.well.qL / (1440 * 3.14 * this.well.pumpType ** 2 * this.well.strokeLen * (this.well.spm / 4000000))
			  if (kpod < 0.4 || kpod > 0.9) {
				  var message = this.trans('pgno.kpodWarning', {kpod: kpod.toFixed(2)})
				  this.setNotify(message, "Warning", "warning")
			  }
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
      this.curveSettings.hPumpManomInput = this.well.hPumpSet.toFixed(0);
      this.curveSettings.pBuff = this.well.whp.toFixed(0);
      this.curveSettings.hPumpValue = this.well.hPumpSet.toFixed(0);
      this.skType = this.well.skType;
      this.horizon = this.well.horizon;
      if (this.well.wellError === "no_well_data") {
        this.setNotify(this.trans('pgno.notify_well_doesnt_exist'), "Error", 'danger')
      } else if (!this.well.newWell && !this.isSkExist(this.skType)) {
        this.setNotify(this.trans("pgno.notify_error_sk"), "Warning", "warning");
        this.isNktExist("get")
      }
      this.setCurveSettings(this.curveSettings);
      this.updateCurveTrigger = !this.updateCurveTrigger;
      this.SET_LOADING(false);
    },
    preparePost() {
      var payload = {};
      payload.url = this.apiUrl + "calculate";
      if (this.curveSettings.expChoosen ==="ФОН") {
        payload.data = {
          shgn_settings: this.shgnSettings,
          well: this.well,
          curve_settings: this.curveSettings,
          analysis_settings: this.analysisSettings,
          sensetive_settings: this.sensetiveSettings
        };
      } else {
        payload.data = {
          shgn_settings: this.shgnSettings,
          well: this.well,
          curve_settings: this.curveSettings,
          analysis_settings: this.analysisSettings,
        };
      }

      return payload
    },

    async postCurveData() {
      if (!this.wellNumber) {
        this.setNotify("Выберите скважину", "Error", "danger");
        return
      }
      this.mainSettings.isVisibleChart = true;
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
      var payload = this.preparePost()
      var isPostSuccess = await this.postWell(payload);
      if (!isPostSuccess) {
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
    onPgnoClick() {
      if (!this.wellNumber) {
        this.setNotify("Выберите скважину", "Error", "danger");
        return
      }
      var nktError = this.isNktExist("pgno")
      var errorCheck = this.raiseTargetNotify();
      if (!this.isSkExist(this.skType)) {
        this.setNotify(this.trans("pgno.notify_error_sk"), "Error", "danger");
      } else if (errorCheck || nktError) {
        if (this.curveSettings.expChoosen == "ШГН") {
          if (this.mainSettings.isVisibleChart) {
            this.SET_LOADING(true);
            var payload = {
              shgn_settings: this.shgnSettings,
              well: this.well,
              curve_settings: this.curveSettings,
              analysis_settings: this.analysisSettings,
              points: this.points,
            };
            this.axios.post(this.apiUrl + "shgn", payload).then((response) => {
                let data = response.data;
                this.shgnResult = data
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
                  this.pElectricity = (data.checks["p_electricity"] / 1000).toFixed(0);
                  this.wDay = data.checks["w_day"].toFixed(0);
                  this.ure = data.checks["ure"].toFixed(1);
                  if (this.shgnSettings.kPodMode) {
                    this.kPodText = this.trans("pgno.kPodCalced")
                  } else {
                    this.kPodText = this.trans("pgno.kPodUser")
                  }
                  if (data.checks["load_limit_check"]["type"] === "warning") {
                    var message = `${this.trans("pgno.load_warning")} ${data.checks["load_limit_check"]["value"]} ${this.trans("measurements.percent")}`;
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
                  this.mainSettings.isVisibleChart = !this.mainSettings.isVisibleChart;
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
            this.mainSettings.isVisibleChart = !this.mainSettings.isVisibleChart;
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
      this.centratorsType = this.trans('pgno.required')
      if (this.centralizer_range === "NoIncl") {
        this.centratorsRequiredValue = "Нет данных"
      } else if (!this.centralizer_range["red"]) {
        this.centratorsType = this.trans('pgno.recommended')
        this.centratorsRequiredValue = this.centralizer_range["yellow"];
      } else {
        this.centratorsRequiredValue = this.centralizer_range["red"];
      }
    },

    closeModal(modalName) {
      this.$modal.hide(modalName);
    },
    openSensAnalysisModal() {
      this.$modal.show('sensAnalysisModal')
    },
    openEcoModal() {
      if (!this.wellNumber) {
        this.setNotify("Выберите скважину", "Error", "danger");
        return
      }
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
      if (!this.wellNumber) {
        this.setNotify("Выберите скважину", "Error", "danger");
        return
      }
      this.$modal.show("modal-prs");
    },
    openInclinometryModal() {
      if (!this.wellNumber) {
        this.setNotify("Выберите скважину", "Error", "danger");
        return
      }
      if (this.well.newWell) {
        this.setNotify(this.trans("pgno.notify_no_incl"), "Warning", "warning");
      } else if (!this.wellNumber) {
        this.setNotify("Выберите скважину", "Warning", "warning");
      } else {
        this.$modal.show("modalIncl");
      }
    },
    closeInclModal(value) {
      if (value==='noIncl') {
        this.setNotify(this.trans("pgno.no_incl_data"), "Warning", "warning");
      }
      this.$modal.hide("modalIncl");
      this.curveSettings.hPumpValue = this.curveSettingsStore.hPumpValue;
      this.postCurveData();

    },
    openAnalysisModal() {
      if (!this.wellNumber) {
        this.setNotify("Выберите скважину", "Error", "danger");
        return
      }
      this.$modal.show('analysisMenu');
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
    openTabsModal() {
      if (!this.wellNumber) {
        this.setNotify("Выберите скважину", "Error", "danger");
        return
      }
      if (this.calcKpodTrigger) {
        var payload = {
          pumpType: this.well.pumpType,
          spm: this.well.spm,
          strokeLen: this.well.strokeLen,
          ql: this.curveSettings.qLInput,
        }
        this.setKpodSettings(payload)
      }
      this.$modal.show("modalTabs");
    },
    closeTabsModal() {
      this.$modal.hide("modalTabs");
      this.postCurveData();
      this.calcKpodTrigger = false
    },
    openSensAnalysisModal() {
      this.$modal.show("sensitiveSettings");
    },
    openSensitiveResult() {
      this.$modal.hide("sensitiveSettings");
      this.$modal.show("sensitiveResult");
    },
    downloadExcel(menu) {
      this.SET_LOADING(true);
      if (menu === "analysis") {
        var payload = {
          shgn_settings: this.shgnSettings,
          well: this.wellAnalysis,
          curve_settings: this.curveSettings,
          analysis_settings: this.analysisSettings,
          points: this.pointsAnalysis,
          lines: this.linesAnalysis,
        };
        var url = this.apiUrl + "excel/download"
        var filename = "ПГНО_АНАЛИЗ_" + this.field + "_" + this.wellNumber + ".xlsx"
      } else if (menu === "main") {
        var payload = {
          shgn_settings: this.shgnSettings,
          well: this.well,
          curve_settings: this.curveSettings,
          analysis_settings: this.analysisSettings,
          points: this.points,
          lines: this.lines,
        };
        var url = this.apiUrl + "excel/download"
        var filename = "ПГНО_КРИВЫЕ_" + this.field + "_" + this.wellNumber + ".xlsx"
      } else if (menu === "gno" || menu === "report") {
        this.shgnResult.centralizer_range = this.centralizer_range
        this.shgnResult.shgnImg = this.shgnImg
        this.shgnResult.user = this.user
        var payload = {
          shgn_settings: this.shgnSettings,
          well: this.well,
          curve_settings: this.curveSettings,
          analysis_settings: this.analysisSettings,
          points: this.points,
          result: this.shgnResult,
        };
        var url = menu === "gno" ? this.apiUrl + "shgn/download": this.apiUrl + "report/download"
        var startline = menu === "gno" ? "ПГНО_РЕЗУЛЬТАТ_" : "ПГНО_ОТЧЁТ_"
        var filename = startline + this.field + "_" + this.wellNumber + "_ШГН.xlsx"
      }
      this.axios.post(url, payload, { responseType: "blob" }).then((response) => {
        fileDownload(response.data, filename)
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
        .catch(function (error) {
          console.error("oops, something went wrong!", error);
        })
        .finally(() => {
          this.SET_LOADING(false);
        });
    },

    setActiveRightTabName: function (e, val) {
      if (
        val === this.mainSettings.activeRightTabName &&
        (this.windowWidth > 1300 || this.windowWidth <= 991)
      ) {
        this.mainSettings.activeRightTabName = "techmode";
        return;
      }

      if (
        val === this.mainSettings.activeRightTabName &&
        this.windowWidth <= 1300 &&
        this.windowWidth > 991
      ) {
        this.mainSettings.activeRightTabName = "devices";
        return;
      }

      if (
        val === "techmode" &&
        this.windowWidth <= 1300 &&
        this.windowWidth > 991
      ) {
        return;
      }

      this.mainSettings.activeRightTabName = val;
    },
    takePhoto() {
      this.SET_LOADING(true);

      htmlToImage
        .toPng(this.$refs["gno-chart"])
        .then(function (dataUrl) {
          let link = document.createElement("a");
          link.setAttribute("href", dataUrl);
          link.setAttribute("download", "download");
          link.click();
          link.remove();
        })
        .catch(function (error) {
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
        .then(function (dataUrl) {
          let link = document.createElement("a");
          link.setAttribute("href", dataUrl);
          link.setAttribute("download", "download");
          link.click();
          link.remove();
        })
        .catch(function (error) {
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
    if (this.user.org_structure.includes("org:2")) {
      this.dzos = Object.keys(orgSample)
    } else if (this.user.org_structure.includes("org:112")) {
      this.dzos = ["АО «Мангистаумунайгаз»"]
    } else if (this.user.org_structure.includes("org:3")) {
      this.dzos = ["АО ОзенМунайГаз"]
    } else if (this.user.org_structure.includes("org:179")) {
      this.dzos = ["ТОО «СП КазГерМунай»"]
    }
  },
};
  