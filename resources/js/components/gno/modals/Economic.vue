<template>
  <div>
    <apexchart
        ref="ecoChart"
        type="bar"
        height="380"
        style="margin-top: 0px;"
        :options="chartOptions"
        :series="series"
    ></apexchart>
  </div>
</template>

<script>
import { pgnoMapState, pgnoMapGetters, pgnoMapMutations, pgnoMapActions } from '@store/helpers';
import VueApexCharts from "vue-apexcharts";
import moment from "moment";

export default {
  name: "economic-chart",
  computed: {
    ...pgnoMapState([
      'well',
      'shgnSettings',
      'curveSettings'
    ]),
  },
  components: {
    "apexchart": VueApexCharts
  },
  data: function () {
    return {
      apiUrl: process.env.MIX_PGNO_API_URL,
      nno1: null,
      nno2: null,
      expAnalysisData: {},
      qLiqEcn: null,
      qOilEcn: null,
      qLiqShgn: null,
      qOilShgn: null,
      qLiqEcnm3: null,
      qLiqShgnm3: null,
      chartOptions: {
        tooltip: {
          theme: "dark",
          x: {
            show: true,
          },
          y: {
            title: {
              show: true,
              formatter: function () {
                return "";
              },
            },
          },
        },

        colors: ["#fba409", "#13b062"],
        chart: {
          background: '#272953',
          toolbar: {
            show: true,
            Color: "#373d3f",
          },
          foreColor: "#fff",
          animations: {
            speed: 200,
          },
          type: "area",
        },

        plotOptions: {
          bar: {
            dataLabels: {
              position: "top",
            },
            columnWidth: "50%",
          },
        },

        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return val;
          },
          offsetY: -20,
          style: {
            fontSize: "12px",
            colors: ["#c5c5c5"],
          },
        },

        labels: [this.trans('pgno.q_nefti') + ", " + this.trans('measurements.t/d'), this.trans('pgno.nno') + ", " + this.trans('measurements.day'), this.trans('pgno.power_consumption') + ", " + this.trans('measurements.kvh'), this.trans('pgno.npv')],
        legend: {
          show: true,
          position: "bottom",
          horizontalAlign: "center",
        },

        yaxis: {
          axisBorder: {
            show: true,
          },
          axisTicks: {
            show: true,
          },
          labels: {

            show: true,
            formatter: function (val) {
              return val;
            },
          },
        },
        xaxis: {
          position: "bottom",
          axisBorder: {
            show: true,
          },
          axisTicks: {
            show: true,
          },
          labels: {

            show: true,
            formatter: function (val) {
              return val;
            },
          },
        },

        title: {
          text: this.trans('pgno.techniko_econom_god'),
          align: 'center',
          margin: 20,
          offsetY: 20,
          style: {
            fontSize: '20px'
          },
        },
      },
      series: [

        {
          name: this.trans('pgno.shgn_pokupka'),
          type: "bar",

          stroke: {
            show: true,
          },
          data: [],
        },
        {
          name: this.trans('pgno.ecn_arenda'),
          type: "bar",

          stroke: {
            show: true,
          },
          data: [],
        }
      ]
    };
  },
  methods: {
    ...pgnoMapActions([
      'setEconomic'
    ]),
    async setExpAnalysisMenu() {
      await this.NnoCalc()
      this.qLiqEcn = this.curveSettings.qlTargetValue * ((1 - (this.curveSettings.wctInput / 100)) * this.well.densOil + this.curveSettings.wctInput / 100 * this.well.densLiq)
      this.qOilEcn = this.curveSettings.qlTargetValue * (1 - (this.curveSettings.wctInput / 100)) * this.well.densOil
      this.qLiqEcnm3 = this.curveSettings.qlTargetValue

      if (this.curveSettings.qlTargetValue < 106) {
        this.qLiqShgn = this.curveSettings.qlTargetValue * ((1 - (this.curveSettings.wctInput / 100)) * this.well.densOil + this.curveSettings.wctInput / 100 * this.well.densLiq)
        this.qOilShgn = this.curveSettings.qlTargetValue * (1 - (this.curveSettings.wctInput / 100)) * this.well.densOil
        this.qLiqShgnm3 = this.curveSettings.qlTargetValue
      } else {
        this.qLiqShgn = 106 * ((1 - (this.curveSettings.wctInput / 100)) * this.well.densOil + this.curveSettings.wctInput / 100 * this.well.densLiq)
        this.qOilShgn = 106 * (1 - (this.curveSettings.wctInput / 100)) * this.well.densOil
        this.qLiqShgnm3 = 106
      }

      this.expAnalysisData.qoilShgn = this.qOilShgn
      this.expAnalysisData.qoilEcn = this.qOilEcn

      await this.EconomParam()
      this.$refs.ecoChart.updateSeries([{data: [Math.round(this.expAnalysisData.qoilShgn), Math.round(this.expAnalysisData.nnoShgn), Math.round(this.expAnalysisData.shgnParam / 1000), Math.round(this.expAnalysisData.shgnNpv / 1000000)]},
      {data:[Math.round(this.expAnalysisData.qoilEcn), Math.round(this.expAnalysisData.nnoEcn), Math.round(this.expAnalysisData.ecnParam / 1000), Math.round(this.expAnalysisData.ecnNpv / 1000000)]}])
      this.setEconomic(this.expAnalysisData)
    },
    async EconomParam() {
      let nnoDayUp = moment("2020-11-01", 'YYYY-MM-DD').toDate();
      let nnoDayFrom = moment("2021-01-17", 'YYYY-MM-DD').toDate();
      let date_diff = (nnoDayUp - nnoDayFrom) / (1000 * 3600 * 24);
      if (date_diff < 365) {
        date_diff = 365;
      }

      if (this.expAnalysisData.prsShgn != 0 && this.expAnalysisData.prsEcn != 0) {
        await this.EconomCalc(1);
      } else if (this.expAnalysisData.prsShgn == 0 && this.expAnalysisData.prsEcn == 0) {
        if (this.well.newWell) {
          await this.EconomCalc(1);
        } else {
          if (this.curveSettings.expChoosen == "ШГН") {
            this.expAnalysisData.nnoShgn = date_diff;
            await this.EconomCalc(1);
          } else {
            this.expAnalysisData.nnoEcn = date_diff;
            await this.EconomCalc(1);
          }
        }
      } else if (this.expAnalysisData.prsShgn == 0 && this.expAnalysisData.prsEcn != 0) {
        await this.EconomCalc(2);
      } else {
        await this.EconomCalc(3);
      }
    },
    async EconomCalc(param) {

      if (this.well.fieldUwi == 'JET' || this.well.fieldUwi == 'ASA') {
        this.param_org = 7;
        this.param_fact = "Корр. 6 на 2021-2025";
      } else {
        this.param_org = 5;
        this.param_fact = "Корр. 5 на 2021-2025";
      }

      let uri2 = this.localeUrl("/nnoeco?equip=1&org=" + this.param_org + "&param=" + param + "&qo=" + this.qOilShgn + "&qzh=" + this.qLiqShgn + "&liq=" + this.qLiqShgnm3 + "&reqd=" + this.expAnalysisData.nnoShgn + "&reqecn=" + this.expAnalysisData.prsShgn + "&scfa=" + this.param_fact)
      let uri3 = this.localeUrl("/nnoeco?equip=2&org=" + this.param_org + "&param=" + param + "&qo=" + this.qOilEcn + "&qzh=" + this.qLiqEcn + "&liq=" + this.qLiqEcnm3 + "&reqd=" + this.expAnalysisData.nnoEcn + "&reqecn=" + this.expAnalysisData.prsEcn + "&scfa=" + this.param_fact)

      this.isLoading = true;

      const responses = await Promise.all([this.axios.get(uri2), this.axios.get(uri3)]).finally(() => {
        this.isLoading = false;
      });

      let data = responses[0].data;
      if (data) {
        this.expAnalysisData.shgnParam = data[12].godovoiShgnParam;
        this.expAnalysisData.shgnNpv = data[12].npv;
        this.expAnalysisData.npvTable1 = data[12];
      } else {
        console.log('No data');
      }


      let data2 = responses[1].data;
      if (data2) {
        this.expAnalysisData.ecnParam = data2[12].godovoiEcnParam;
        this.expAnalysisData.ecnNpv = data2[12].npv;
        this.expAnalysisData.npvTable2 = data2[12];

      } else {
        console.log('No data');
      }
      return Promise
    },
    async NnoCalc() {
      this.qLiqEcn = this.curveSettings.qlTargetValue
      this.qOilEcn = this.curveSettings.qlTargetValue * (1 - (this.curveSettings.wctInput / 100)) * this.well.densOil

      if (this.curveSettings.qlTargetValue < 106) {
        this.qLiqShgn = this.curveSettings.qlTargetValue
        this.qOilShgn = this.curveSettings.qlTargetValue * (1 - (this.curveSettings.wctInput / 100)) * this.well.densOil

      } else {
        this.qLiqShgn = 106
        this.qOilShgn = 106 * (1 - (this.curveSettings.wctInput / 100)) * this.well.densOil
      }

        this.isLoading = true;

      return this.axios.get(this.apiUrl + "nno/" + this.well.fieldUwi + "/" + this.well.wellUwi).then((response) => {
        var data = response.data
        
        this.expAnalysisData.nnoShgn = data.prs.nno['nno']
        this.expAnalysisData.qoilShgn = this.qOilShgn
        this.expAnalysisData.prsShgn = data.prs.nno['prs']

        this.expAnalysisData.nnoEcn = 365
        this.expAnalysisData.qoilEcn = this.qOilEcn
        this.expAnalysisData.prsEcn = 0
      })
    },
  },
  created() {
    this.setExpAnalysisMenu()
  }
}
</script>
