<template>
  <div class="tr-chart">
    <div class="tr-chart__content">
      <div class="col-md-12 row">
        <div class="row justify-content-between">
          <a href="fa" class="col but-nav__link but"
            ><i style="margin-right: 10px"
              ><svg
                width="24"
                height="14"
                viewBox="0 0 24 14"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M13.8015 10.4124C13.4953 10.4123 13.2018 10.2864 12.9853 10.062L9.52204 6.47442L2.25734 14L0.625 12.309L8.36763 4.28837C8.58407 4.06415 8.87765 3.93811 9.1838 3.93799H9.86032C10.1665 3.93811 10.46 4.06415 10.6765 4.28837L14.1397 7.87597L19.0956 2.74212L16.4485 0H23.375V7.17519L20.7279 4.43307L15.2941 10.062C15.0777 10.2864 14.7841 10.4123 14.478 10.4124H13.8015Z"
                  fill="white"
                /></svg></i
            >{{trans('tr.tr')}}</a
          >
          <a href="tr" class="col but-nav__link but trfabuttech"
            ><i style="margin-right: 10px"
              ><svg
                width="14"
                height="17"
                viewBox="0 0 14 17"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M6.75 16.905L0 11.655L1.215 10.71L6.7425 15.0075L12.2775 10.7032L13.5 11.655L6.75 16.905ZM6.75 13.7025L0 8.45249L1.215 7.50749L6.7425 11.805L12.2775 7.49999L13.5 8.45249L6.75 13.7025ZM6.75 10.5L1.2225 6.2025L0 5.25L6.75 0L13.5 5.25L12.27 6.2025L6.75 10.5Z"
                  fill="white"
                />
              </svg> </i
            >{{trans('tr.btr')}}</a
          >
        </div>
      </div>
      <div class="row sec_nav trfacolmdrowsecnav">
        <div class="dropdown show">
          <a
            class="btn btn-secondary dropdown-toggle trfabtgraph"
            href="#"
            role="button"
            id="dropdownMenuLink"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            {{trans('tr.trfacg')}}
          </a>
          <div
            class="dropdown-menu fadropmenu"
            aria-labelledby="dropdownMenuLink"
            style="width: 576px; padding: 0"
          >
            <a
              class="dropdown-item background_dropdown"
              href="#"
              @click="chartShow = 'bar'"
              >{{trans('tr.trfag2')}}</a
            >
            <a
              class="dropdown-item background_dropdown"
              href="#"
              @click="chartShow = 'line'"
              >demo</a
            >
          </div>
        </div>
        <div class="dropdown">
          <button
            class="btn btn-secondary dropdown-toggle trfabtgraph"
            type="button"
            id="dropdownMenuButton"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            {{trans('tr.trchdt')}}
          </button>
          <div
            class="dropdown-menu fadropmenu"
            aria-labelledby="dropdownMenuLink"
            style="background: #40467e"
          >
            <label for="inputDate" style="margin-left: 8px;">{{trans('tr.fadt1')}}:</label>
            <input type="date" class="form-control" v-model="date1" />
            <a href="#" class="btn btn-sm button_form" @click.prevent="chooseDt"
              >{{trans('tr.sf')}}</a
            >
          </div>
        </div>
          <div style="margin-left: 7px; cursor: pointer;">
            <select
              class="select_mod form-control"
              style="background: #334296 !important"
              v-model="Filter_field"
              value="Месторождение"
            >
              <option v-for="(f, k) in fieldFilter" :key="k" :value="f">
                {{ f === undefined ? "Выберите месторождение" : f }}
              </option>
            </select>
          </div>
        <div>
          <div style="margin-left: 7px; cursor: pointer;">
            <select
              class="select_mod form-control"
              style="background: #334296 !important"
              v-model="Filter_well"
              value="Скважина"
            >
              <option v-for="(f, k) in wellFilters" :key="k" :value="f">
                {{ f === undefined ? "Выберите скважину" : f }}
              </option>
            </select>
          </div>
        </div>
        <notifications position="top"></notifications>
      </div>
      <div class="sec_nav">
        <div class="" v-if="chartShow === 'bar'">
          <div
            class="second_block"
            style="display: flex; justify-content: center"
          >
            <apexchart
              v-if="barChartData && pieChartRerender"
              type="bar"
              width="1500"
              height="95%"
              :options="chartBarOptions"
              :series="[{ name: '', data: barChartData }]"
            ></apexchart>
          </div>
        </div>

        <div class="" v-if="chartShow === 'line'">
          <div
            class="first_block"
            style="display: flex; justify-content: center"
          >
            <apexchart
              v-if="areaChartData && areaChartRerender"
              type="line"
              width="800"
              height="100%"
              :options="areaChartOptions"
              :series="areaChartData"
            ></apexchart>
          </div>
        </div>      
        </div>
    </div>
  </div>
</template>
<script>
import Vue from "vue";
import TrMultiselect from "./TrMultiselect.vue";
import { getFilterText } from "./helpers.js";
import VueApexCharts from "vue-apexcharts";
export default {
  name: "Trfa",
  computed: {

    subtitleText() {
      return [
        getFilterText(
          this.chartFilter_field,
          this.fieldFilters[0].fields,
          "fields"
        ),
        getFilterText(
          this.chartFilter_horizon,
          this.horizonFilters[0].fields,
          "horizons"
        ),
        `${getFilterText(
          this.chartFilter_exp_meth,
          this.exp_methFilters[0].fields,
          "expMethods"
        )} добычи`,
        getFilterText(
          this.chartFilter_object,
          this.objectFilters[0].fields,
          "objects"
        ),
      ];
    },
    areaChartData() {
      if (this.chartShow === 'line' && this.chartWells && this.chartWells.length > 0) {
        let field = this.Filter_field;
        let well = this.Filter_well;
        try {
          let filteredResult = this.allWells.filter(
            (row) =>
              (!field || row.field === field) &&
              (!well || row.well === well)
          );

          let qOil = filteredResult.map((row) => {
            return row.q_o
          });
          let qLiquid = filteredResult.map((row) => {
            return row.q_l
          });
          let qWct = filteredResult.map((row) => {
            return row.wct
          });
          const categories = filteredResult.map((row) => {
            return row.date
          });

          return [
            {
              name: "Q_Oil",
              data: qOil
            },
            {
              name: "Q_Liquid",
              data: qLiquid
            },
            {
              name: "Q_WCT",
              data: qWct
            },
          ]
        } catch (err) {
          console.error(err);
          return false;
        }   
      }
    },
    fieldFilter() {
      if (this.allWells && this.allWells.length > 0) {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.field) === -1 &&
            (!this.Filter_well || el.well === this.Filter_well)
          ) {
            filters = [...filters, el.field];
          }
        });
        return [undefined, ...filters];
      } else return [];
    },
    wellFilters() {
      if (this.allWells && this.allWells.length > 0) {
        let filters = [];
        this.allWells.forEach((el) => {
          if (
            filters.indexOf(el.well) === -1 &&
            (!this.Filter_field || el.field === this.Filter_field)
          ) {
            filters = [...filters, el.well];
          }
        });
        return [...filters];
      } else return [];
    },
  },
  data: function () {
    return {
      chartShow: "bar",
      chartArr: ["bar","line"],
      chartWells: [],
      allWells: [],
      filteredWellsBar: [],
      dt: null,
      dt2: null,
      date1: null,
      fullWells: [],
      showFilters: false,
      areaChartRerender: true,
      Filter_well: undefined,
      Filter_field: undefined,
      xdate: [],

      areaChartOptions: {
        chart: {
            type: 'line',
            height: 350,
            stacked: false
          },
          dataLabels: {
            enabled: false
          },
          colors: ["#FF1654", "#247BA0", "#5FA7FF"],
          stroke: {
            width: [4, 4, 4]
          },
          plotOptions: {
            bar: {
              columnWidth: "20%"
            }
          },
          xaxis: {
            categories: []
          },

        },
    };
  },
  watch: {
    areaChartData() {
      this.areaChartRerender = false;
      this.$nextTick(() => {
        this.areaChartRerender = true;
      });
    },
  },
  methods: {
    chooseDt() {
      const { date1 } = this;
      console.log("dt1-", date1);
      var choosenDt = date1.split("-");
      const mm = choosenDt[1];
      const yyyy = choosenDt[0];
      const dd = choosenDt[2];
      this.axios
        .get(
          "http://172.20.103.187:7576/api/techregime/factor/graph2/" +
            yyyy +
            "/" +
            mm +
            "/" +
            dd +
            "/"
        )
        .then((response) => {
          this.$store.commit("globalloading/SET_LOADING", false);
          let data = response.data;
          if (data) {
            console.log(data);
            this.fullWells = data.data;
            this.chartWells = data.data;
            this.allWells = data.data;
          } else {
            console.log("No data");
          }
        });
    },
  },
  created: function () {
    this.$store.commit("globalloading/SET_LOADING", true);
    var wdate1 = new Date();
    this.wdate1 = wdate1.setDate(wdate1.getDate()-1);
    this.wdate1 = wdate1.toLocaleDateString();
    var dynamic_date1 = this.wdate1.split(".");
    var dd = dynamic_date1[0];
    var mm = dynamic_date1[1];
    var yyyy = dynamic_date1[2];
    if (
      this.$store.getters["fa/month"] &&
      this.$store.getters["fa/year"] &&
      this.$store.getters["fa/day"] 
    ) {
      var mm = this.$store.getters["fa/month"];
      var dd = this.$store.getters["fa/day"];
      var yyyy = this.$store.getters["fa/year"];
    } else {
      var mm = today.getMonth();
      var yyyy = today.getFullYear();
      var dd = today.getDate();
    }
    this.axios
      .get(
          "http://172.20.103.187:7576/api/techregime/factor/graph2/" +
            yyyy +
            "/" +
            mm +
            "/" +
            dd +
            "/"
        )
      .then((response) => {
        this.$store.commit("globalloading/SET_LOADING", false);
        let data = response.data;

        if (data) {
          console.log(data);
          this.fullWells = data.data;
          this.chartWells = data.data;
          this.allWells = data.data;
        } else {
          console.log("No data");
        }
        this.date1 = yyyy + "-" + mm + "-" + dd;
      });
  },
  mounted: function () {
    const mm =
      `${this.$store.getters["fa/month"]}`.length < 2
        ? `0${this.$store.getters["fa/month"]}`
        : `${this.$store.getters["fa/month"]}`;
    const prmm =
      `${this.$store.getters["fa/prmonth"]}`.length < 2
        ? `0${this.$store.getters["fa/prmonth"]}`
        : `${this.$store.getters["fa/prmonth"]}`;
    this.date1 = `${this.$store.getters["fa/year"]}-${mm}-01`;
    this.date2 = `${this.$store.getters["fa/pryear"]}-${prmm}-01`;
    this.dt = `01.${mm}.${this.$store.getters["fa/year"]}`;
    this.dt2 = `01.${prmm}.${this.$store.getters["fa/pryear"]}`;
  },
};
</script>
<style  scoped>
.second_block,
.first_block {
  height: calc(100vh - 280px);
  min-height: 587px;
  margin: 0 auto;
}
body {
  color: white !important;
}
.trfabuttech {
  margin-left: 13px;
}
.trfacolmdrowsecnav {
  margin-bottom: 13px;
  margin-top: 13px;
}
.trfacolbutnavlinkbut {
  margin-left: 28px;
}
.trfabtdata {
  margin-left: 864px;
  background: #5973cc !important;
}
.trfabtgraph {
  width: 195px;
  background: #40467e !important;
}
a:hover {
  color: #ffffff;
}
.form-control {
  background: #272953 !important;
  border: 1px solid #656a8a !important;
  height: 35px !important;
  color: white !important;
}
.fadropmenu.fadropmenu {
  background: #40467e;
  color: #ffffff;
  width: 246px;
}
.background_dropdown {
  color: #ffffff;
  background: #40467e;
}
.button_form.button_form {
  background: #333975;
  border: 0px;
  color: #fff;
  align-self: center;
  width: 150px;
  margin-top: 5px;

}
</style>