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
            >{{trans('tr.fa_tr_deviations')}}</a
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
            >{{trans('tr.tr')}}</a
          >
        </div>
      </div>
      <div class="row sec_nav trfacolmdrowsecnav">
        <div class="dropdown">
          <button
            class="btn btn-secondary dropdown-toggle trfabtgraph"
            type="button"
            id="dropdownMenuButton"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            {{trans('tr.choose_date')}}
          </button>
          <div
            class="dropdown-menu fadropmenu"
            aria-labelledby="dropdownMenuLink"
            style="background: #40467e"
          >
            <label for="inputDate" style="margin-left: 8px;">{{trans('tr.enter_reference_date')}}:</label>
            <input type="date" class="form-control" v-model="calendarDate" />
            <a href="#" class="btn btn-sm button_form" @click.prevent="chooseDate"
              >{{trans('tr.form')}}</a
            >
          </div>
        </div>
          <div style="margin-left: 7px; cursor: pointer;">
            <select
              class="select_mod form-control fa_weekly_dropdown"
              v-model="Filter_field"
              value="??????????????????????????"
            >
              <option v-for="(f, k) in fieldFilter" :key="k" :value="f">
                {{ f === undefined ? trans('tr.choose_field') : f }}
              </option>
            </select>
          </div>
        <div>
          <div style="margin-left: 7px; cursor: pointer;">
            <select
              class="select_mod form-control fa_weekly_dropdown"
              v-model="Filter_well"
              value="????????????????"
            >
              <option v-for="(f, k) in wellFilters" :key="k" :value="f">
                {{ f === undefined ? trans('tr.choose_well') : f }}
              </option>
            </select>
          </div>
        </div>
      </div>
      <div class="sec_nav">
          <div
            class="first_block"
            style="display: flex; justify-content: center"
          >
            <apexchart
              v-if="areaChartData && areaChartRerender"
              type="line"
              width="1600"
              height="100%"
              :options="areaChartOptions"
              :series="areaChartData"
            ></apexchart>
        </div>      
        </div>
    </div>

  </div>
</template>
<script>
import VueApexCharts from "vue-apexcharts";
import trHelper from '~/mixins/trHelper';

import moment from "moment";


export default {
  name: "Trfa",
  components: {

    "apexchart": VueApexCharts
  },
  mixins: [trHelper],
  computed: {
    subtitleText() {
      return [
        this.getFilterText(
          this.chartFilter_field,
          this.fieldFilters[0].fields,
          "fields"
        ),
        this.getFilterText(
          this.chartFilter_horizon,
          this.horizonFilters[0].fields,
          "horizons"
        ),
        `${this.getFilterText(
          this.chartFilter_exp_meth,
          this.exp_methFilters[0].fields,
          "expMethods"
        )} ????????????`,
        this.getFilterText(
          this.chartFilter_object,
          this.objectFilters[0].fields,
          "objects"
        ),
      ];
    },
    areaChartData() {
      if (this.chartWells && this.chartWells.length > 0) {
        let field = this.Filter_field;
        let rus_wellname = this.Filter_well;
        try {
          let filteredResult = this.allWells.filter(
            (row) =>
              (!field || row.field === field) &&
              (!rus_wellname || row.rus_wellname === rus_wellname)
          ).sort((row1,row2)=>{
            return new Date(row1.date) - new Date(row2.date);
          });
          let qOil = filteredResult.map((row) => {
            return row.q_o
          });
          let qLiquid = filteredResult.map((row) => {
            return row.q_l
          });
          let qWct = filteredResult.map((row) => {
            return row.wct
          });
          this.areaChartOptions.xaxis.categories = filteredResult.map((row) => {
            return new Date(row.date).toLocaleDateString('ru-RU')
          });
          this.areaChartOptions.title.text = this.trans('tr.weekly_fa_title') + ' ' + this.Filter_well + ' ' + this.trans('tr.weekly_fa_title_2');
          return [
            {
              name: this.trans('tr.q_oil'),
              data: qOil
            },
            {
              name: this.trans('tr.q_liquid'),
              data: qLiquid
            },
            {
              name: this.trans('tr.water_cut'),
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
            filters.indexOf(el.field) === -1
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
            filters.indexOf(el.rus_wellname) === -1 &&
            (!this.Filter_field || el.field === this.Filter_field)
          ) {
            filters = [...filters, el.rus_wellname];
          }
        });
        return [...filters];
      } else return [];
    },
  },
  data: function () {
    return {
      chartWells: [],
      allWells: [],
      filteredWellsBar: [],
      titleDate: null,
      calendarDate: null,
      areaChartRerender: true,
      Filter_well: undefined,
      Filter_field: undefined,
      areaChartOptions: {
        chart: {
            type: 'line',
            height: 350,
            stacked: false
          },
          title: {
            align: "center",
            style: {
              color: "#5FA7FF",
            },
          },
          dataLabels: {
            enabled: false
          },
          colors: ["#06AED5", "#9C7300", "#33CC99"],
          stroke: {
            width: [4, 4, 4]
          },
          plotOptions: {
            bar: {
              columnWidth: "20%"
            }
          },
          legend: {
            position: "bottom",
            labels: {
              useSeriesColors: true,
            },
          },
          xaxis: {
            labels: {
              hideOverlappingLabels: true,
              style: {
                colors: "#5FA7FF",
              },
          },},
          yaxis: [
            {
              seriesName: this.trans('tr.q_oil'),
              axisTicks: {
                show: true
              },
              axisBorder: {
                show: true,
              },
              title: {
                text: this.trans('tr.qn_ql'),
                style: {
                  color: "#06AED5"
                }
              },
              labels: {
                formatter: function (val) {
                  return val.toFixed(1);
                },
                hideOverlappingLabels: true,
                style: {
                  colors: "#06AED5",
                },
              },
            },
            {
              seriesName: this.trans('tr.q_oil'),
              show: false
            }, {
              opposite: true,
              seriesName: this.trans('tr.water_cut'),
              axisTicks: {
                show: true
              },
              axisBorder: {
                show: true,
              },
              title: {
                text: this.trans('tr.water_cut'),
                style: {
                  color: "#33CC99"
                }
              },
              labels: {
                formatter: function (val) {
                  return val.toFixed(1);
                },
                hideOverlappingLabels: true,
                style: {
                  colors: "#33CC99",
                },
              },
            }
          ],
        },
      postApiUrl: process.env.MIX_POST_API_URL,
    };
  },
  watch: {
    areaChartData() {
      this.areaChartRerender = false;
      this.$nextTick(() => {
        this.areaChartRerender = true;
      });
    },
    wellFilters(newValue) {
      this.Filter_well = newValue[0];
    },
    fieldFilter(newValue) {
      this.Filter_field = newValue[0];
    },
  },
  methods: {
    chooseDate() {
      const { calendarDate } = this;
      const apiDate = moment(calendarDate).format("YYYY/MM/DD");
      this.titleDate = moment(calendarDate).format("DD.MM.YYYY");
      this.axios
        .get(
          this.postApiUrl + "techregime/factor/graph2/" +
            apiDate +
            "/"
        )
        .then((response) => {
          this.$store.commit("globalloading/SET_LOADING", false);
          let data = response.data;
          if (data) {
            this.chartWells = data.data;
            this.allWells = data.data;
          } else {
            this.chartWells = [];
            this.allWells = [];            
            this.$store.commit("globalloading/SET_LOADING", false);
          }
        })
        .catch((error) => {
          console.log(error.data);
          this.$store.commit("globalloading/SET_LOADING", false);
        });
    },
  },
  created: function () {
    this.$store.commit("globalloading/SET_LOADING", true);
    if (
      this.$store.getters["fa/month"] &&
      this.$store.getters["fa/year"] &&
      this.$store.getters["fa/day"] 
    ) {
      var mm = this.$store.getters["fa/month"];
      var dd = this.$store.getters["fa/day"];
      var yyyy = this.$store.getters["fa/year"];
      this.calendarDate = yyyy + "-" + mm + "-" + dd;
      this.titleDate = dd + '.' + mm + '.' + yyyy;
      var apiDate = yyyy + "/" + mm + "/" + dd;      
    } else {
      this.calendarDate = moment().format("YYYY-MM-DD");
      var apiDate = moment().format("YYYY/MM/DD");
      this.titleDate = moment().format("DD.MM.YYYY");
    }
    this.axios
      .get(
          this.postApiUrl + "techregime/factor/graph2/" +
            apiDate +
            "/"
        )
      .then((response) => {
        this.$store.commit("globalloading/SET_LOADING", false);
        let data = response.data;
        if (data) {
          this.chartWells = data.data;
          this.allWells = data.data;
        } else {
          console.log("No data");
        }
      })
      .catch((error) => {
        console.log(error.data);
        this.$store.commit("globalloading/SET_LOADING", false);
      });  
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

.trfabtgraph {
  width: 195px;
  background: #454FA1  !important;
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
.fa_weekly_dropdown {
  background: #454FA1 !important;
}
</style>
