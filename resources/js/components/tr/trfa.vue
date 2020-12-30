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
            >Факторный анализ отклонений ТР</a
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
            >Технологический режим</a
          >
        </div>
      </div>
      <div
        class="row sec_nav trfacolmdrowsecnav"
      >
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
            Выберите график
          </a>
          <div
            class="dropdown-menu fadropmenu"
            aria-labelledby="dropdownMenuLink"
            style="width: 576px; padding: 0"
          >
            <a
              class="dropdown-item background_dropdown"
              href="#"
              @click="chartShow = 'pie'"
              >Распределение фонда скважин по основной причине снижения дебита
              нефти</a
            >
            <a
              class="dropdown-item background_dropdown"
              href="#"
              @click="chartShow = 'bar'"
              >Распределение суммарных отклонений TP по факторам, т/сут</a
            >
          </div>
          <!-- <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <a
              class="dropdown-item"
              v-for="(item, index) in chartNames"
              :key="item"
              href="#"
              @click="chartShow = index"
              >{{ item }}</a
            >
          </div> -->
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
            Выберите дату
          </button>
          <div
            class="dropdown-menu fadropmenu"
            aria-labelledby="dropdownMenuLink"
            style="background: #40467e"
          >
            <label for="inputDate" style="margin-left: 8px;">Введите опорную дату:</label>
            <input type="date" class="form-control" v-model="date1" />
            <label for="inputDate" style="margin-left: 8px;">Введите дату для сравнения:</label>
            <input type="date" class="form-control" v-model="date2" />
            <a href="#" class="btn btn-sm button_form" @click.prevent="chooseDt"
              >Сформировать</a
            >
          </div>
        </div>
        <div class="namefilter" @click="showFilters = !showFilters">
          <svg
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <g id="filter">
              <path
                id="Combined Shape"
                d="M10.1488 12.2398H10.8488C10.8488 12.0699 10.787 11.9057 10.6749 11.778L10.1488 12.2398ZM5.25043 6.65971L4.72436 7.1215H4.72436L5.25043 6.65971ZM18.7472 6.65971L18.2211 6.19791L18.7472 6.65971ZM13.7956 12.3004L13.2696 11.8386C13.1574 11.9663 13.0956 12.1304 13.0956 12.3004H13.7956ZM13.7956 16.3796L14.2041 16.948C14.3871 16.8165 14.4956 16.6049 14.4956 16.3796H13.7956ZM10.1488 19H9.44881C9.44881 19.2625 9.59575 19.503 9.82938 19.6228C10.063 19.7427 10.3441 19.7216 10.5573 19.5684L10.1488 19ZM10.6749 11.778L5.77649 6.19791L4.72436 7.1215L9.62275 12.7016L10.6749 11.778ZM5.77649 6.19791C5.6063 6.00404 5.74397 5.7 6.00195 5.7V4.3C4.5401 4.3 3.75996 6.02289 4.72436 7.1215L5.77649 6.19791ZM6.00195 5.7H17.9957V4.3H6.00195V5.7ZM17.9957 5.7C18.2536 5.7 18.3913 6.00404 18.2211 6.19791L19.2733 7.12151C20.2377 6.02289 19.4575 4.3 17.9957 4.3V5.7ZM18.2211 6.19791L13.2696 11.8386L14.3217 12.7622L19.2733 7.12151L18.2211 6.19791ZM13.0956 12.3004V16.3796H14.4956V12.3004H13.0956ZM13.3872 15.8111L9.74034 18.4315L10.5573 19.5684L14.2041 16.948L13.3872 15.8111ZM10.8488 19V12.2398H9.44881V19H10.8488Z"
                fill="white"
              />
            </g>
          </svg>
          <div class="mx-2">Фильтр</div>
        </div>
        <div class="filters row" v-if="showFilters">
          <div class="filters__item">
            <select
              class="form-control"
              v-model="chartFilter_field"
              value="Месторождение"
            >
              <option v-for="(f, k) in fieldFilters" :key="k" :value="f">
                {{ f === undefined ? "Все месторождения" : f }}
              </option>
            </select>
          </div>
          <div class="filters__item">
            <select class="form-control" v-model="chartFilter_horizon">
              <option v-for="(f, k) in horizonFilters" :key="k" :value="f">
                {{ f === undefined ? "Все горизонты" : f }}
              </option>
            </select>
          </div>
          <div class="filters__item">
            <select
              v-if="exp_methFilters"
              class="form-control"
              v-model="chartFilter_exp_meth"
            >
              <option v-for="(f, k) in exp_methFilters" :key="k" :value="f">
                {{ f === undefined ? "Все способы эксплуатации" : f }}
              </option>
            </select>
          </div>
        </div>
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
              width="800"
              :options="chartBarOptions"
              :series="[{ name: '', data: barChartData }]"
            ></apexchart>
          </div>
        </div>
        <div class="" v-if="chartShow === 'pie'">
          <div
            class="first_block"
            style="display: flex; justify-content: center"
          >
            <apexchart
              v-if="pieChartData && pieChartRerender"
              type="donut"
              width="650"
              :options="chartOptions"
              :series="pieChartData"
            ></apexchart>
          </div>
        </div>
      </div>
      <notifications position="top"></notifications>
    </div>
    <big-numbers :list="filteredWellsBar" />
  </div>
</template>
<script>
import NotifyPlugin from "vue-easy-notify";
import "vue-easy-notify/dist/vue-easy-notify.css";
import { VueMomentLib } from "vue-moment-lib";
import moment from "moment";
import Vue from "vue";
import BigNumbers from "./BigNumbers.vue";

Vue.use(NotifyPlugin, VueMomentLib);
import VueApexCharts from "vue-apexcharts";
export default {
  name: "Trfa",
  components: {
    BigNumbers,
  },
  computed: {
    // field horizon exp_meth
    // Pbh wct p_res PI
    subtitleText() {
      let filtersText = "";
      if (this.chartFilter_field) filtersText = this.chartFilter_field;
      if (this.chartFilter_horizon)
        filtersText = filtersText
          ? `${filtersText}, ${this.chartFilter_horizon}`
          : this.chartFilter_horizon;
      if (this.chartFilter_exp_meth)
        filtersText = filtersText
          ? `${filtersText}, ${this.chartFilter_exp_meth}`
          : this.chartFilter_exp_meth;
      if (filtersText) filtersText = `по ${filtersText}`;

      return filtersText;
    },
    pieChartData() {
      if (this.chartWells && this.chartWells.length > 0) {
        let field = this.chartFilter_field;
        let horizon = this.chartFilter_horizon;
        let exp_meth = this.chartFilter_exp_meth;
        try {
          let filteredResult = this.chartWells.filter(
            (row) =>
              (!field || row.field === field) &&
              (!horizon || row.horizon === horizon) &&
              (!exp_meth || row.exp_meth === exp_meth)
          );
          console.log("filteredResult pie = ", filteredResult);
          this.chartOptions.title.text = `Распределение фонда скважин по основной причине снижения дебита нефти`;
          this.chartOptions.subtitle.text = `на ${this.dt}/${this.dt2} ${this.subtitleText}`;
          let filteredData = filteredResult.reduce((acc, res) => {
            if (acc.hasOwnProperty(res["Main_problem"])) {
              acc[res["Main_problem"]] += 1;
            } else {
              acc[res["Main_problem"]] = 1;
            }
            return acc;
          }, {});
          console.log("Pie chart filtered data:", filteredData);
          return [
            filteredData["Недостижение режимного P забойного"] || 0,
            filteredData["Рост обводненности"] || 0,
            // filteredData['p_res'],
            filteredData["Снижение P пластового"] || 0,
            filteredData["Снижение Кпрод"] || 0,
          ];
        } catch (err) {
          console.error(err);
          return false;
        }
        return false;
      } else return false;
    },
    barChartData() {
      if (this.chartWells && this.chartWells.length > 0) {
        let field = this.chartFilter_field;
        let horizon = this.chartFilter_horizon;
        let exp_meth = this.chartFilter_exp_meth;
        try {
          let filteredResult = this.chartWells.filter(
            (row) =>
              (!field || row.field === field) &&
              (!horizon || row.horizon === horizon) &&
              (!exp_meth || row.exp_meth === exp_meth)
          );
          this.filteredWellsBar = filteredResult;
          console.log("filteredResult bat = ", filteredResult);
          this.chartBarOptions.title.text = `Распределение суммарных отклонений TP по факторам, т/сут на ${this.dt}/${this.dt2}`;
          this.chartBarOptions.subtitle.text = this.subtitleText;
          let filteredData = filteredResult.reduce(
            (acc, res) => {
              acc = {
                Pbh: acc["Pbh"] + res["Pbh"],
                wct: acc["wct"] + res["wct"],
                p_res: acc["p_res"] + res["p_res"],
                PI: acc["PI"] + res["PI"],
              };
              return acc;
            },
            {
              Pbh: 0,
              wct: 0,
              p_res: 0,
              PI: 0,
            }
          );
          return [
            filteredData["Pbh"].toFixed(1),
            filteredData["wct"].toFixed(1),
            filteredData["p_res"].toFixed(1),
            filteredData["PI"].toFixed(1),
          ];
        } catch (err) {
          console.error(err);
          return false;
        }
        //return false;
      } else return false;
    },

    fieldFilters() {
      if (this.chartWells && this.chartWells.length > 0) {
        let filters = [];
        this.chartWells.forEach((el) => {
          if (
            filters.indexOf(el.field) === -1 &&
            (!this.chartFilter_horizon ||
              el.horizon === this.chartFilter_horizon) &&
            (!this.chartFilter_exp_meth ||
              el.exp_meth === this.chartFilter_exp_meth)
          ) {
            filters = [...filters, el.field];
          }
        });
        return [undefined, ...filters];
      } else return [];
    },
    horizonFilters() {
      if (this.chartWells && this.chartWells.length > 0) {
        let filters = [];
        this.chartWells.forEach((el) => {
          if (
            filters.indexOf(el.horizon) === -1 &&
            (!this.chartFilter_field || el.field === this.chartFilter_field) &&
            (!this.chartFilter_exp_meth ||
              el.exp_meth === this.chartFilter_exp_meth)
          ) {
            filters = [...filters, el.horizon];
          }
        });
        return [undefined, ...filters];
      } else return [];
    },
    exp_methFilters() {
      if (this.chartWells && this.chartWells.length > 0) {
        let filters = [];
        this.chartWells.forEach((el) => {
          if (
            filters.indexOf(el.exp_meth) === -1 &&
            (!this.chartFilter_field || el.field === this.chartFilter_field) &&
            (!this.chartFilter_horizon ||
              el.horizon === this.chartFilter_horizon)
          ) {
            filters = [...filters, el.exp_meth];
          }
        });
        return [undefined, ...filters];
      } else return [];
    },
  },
  data: function () {
    return {
      chartShow: "pie",
      chartArr: ["pie", "bar"],
      pieChartRerender: true,
      wells: [],
      chartWells: [],
      filteredWellsBar: [],
      sortType: "asc",
      dt: null,
      dt2: null,
      date1: null,
      date2: null,
      fullWells: [],
      filter: null,
      editdtm: null,
      editdty: null,
      editdtprevm: null,
      editdtprevy: null,
      showFilters: false,
      chartFilter_field: undefined,
      chartFilter_horizon: undefined,
      chartFilter_exp_meth: undefined,
      // chartNames: [
      //   "Распределение фонда скважин по основной причине снижения дебита нефти",
      //   "Распределение суммарных отклонений TP по факторам, т/сут",
      // ],
      chartBarOptions: {
        chart: {
          height: "100%",
          type: "bar",
          toolbar: {
            show: true,
          },
          fontFamily: "Harmonia-sans, Helvetica, Arial, sans-serif",
        },
        title: {
          align: "center",
          offsetY: 18,
          style: {
            fontSize: "14px",
            color: "#5FA7FF",
          },
        },
        subtitle: {
          align: "center",
          offsetY: 36,
          margin: 10,
          style: {
            fontSize: "14px",
            color: "#5FA7FF",
            fontWeight: 700,
          },
        },
        plotOptions: {
          bar: {
            dataLabels: {
              position: "bottom", // top, center, bottom
            },
          },
        },
        // legend: {
        //   position: "top",
        //   labels: {
        //     useSeriesColors: true,
        //   },
        // },
        dataLabels: {
          enabled: true,
          offsetY: -20,
          style: {
            fontSize: "12px",
            colors: ["#5FA7FF"],
          },
        },

        xaxis: {
          categories: [
            "Недостижение режимного Pзаб",
            "Рост обводненности",
            "Снижение Pпл",
            "Снижение Kпрод",
          ],
          position: "bottom",
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
          crosshairs: {
            fill: {
              type: "gradient",
              gradient: {
                colorFrom: "#D8E3F0",
                colorTo: "#BED1E6",
                stops: [0, 100],
                opacityFrom: 0.4,
                opacityTo: 0.5,
              },
            },
          },
          tooltip: {
            enabled: true,
          },
          labels: {
            style: {
              colors: "#5FA7FF",
            },
          },
        },
        yaxis: {
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: true,
            formatter: function (val) {
              return val;
            },
          },
          title: {
            style: {
              color: "#5FA7FF",
            },
          },
          labels: {
            style: {
              colors: "#5FA7FF",
            },
          },
        },
      },
      chartOptions: {
        labels: [
          "Недостижение режимного Pзаб",
          "Рост обводненности",
          "Снижение Pпл",
          "Снижение Kпрод",
        ],
        title: {
          align: "center",
          offsetY: 18,
          style: {
            fontSize: "14px",
            color: "#5FA7FF",
          },
        },
        subtitle: {
          align: "center",
          offsetY: 36,
          margin: 15,
          style: {
            fontSize: "14px",
            color: "#5FA7FF",
            fontWeight: 700,
          },
        },
        chart: {
          type: "donut",
          toolbar: {
            show: true,
          },
          fontFamily: "Harmonia-sans, Helvetica, Arial, sans-serif",
        },
        dataLabels: {
          enabled: true,
        } /*убирается подсветка процентов на круге*/,
        /*tooltip: {
        enabled: false},*/
        legend: {
          position: "bottom",
          labels: {
            useSeriesColors: true,
          },
        },
        colors: ["#ff382c", "#b051df", "#59c9fa", "#007bff"],
        plotOptions: {
          pie: {
            expandOnClick: true,
          },
        },
        responsive: [
          {
            breakpoint: 480,
            options: {
              chart: {
                width: 200,
              },
              legend: {
                position: "bottom",
              },
            },
          },
        ],
      },
    };
  },
  watch: {
    pieChartData() {
      this.pieChartRerender = false;
      this.$nextTick(() => {
        this.pieChartRerender = true;
      });
    },
    barChartData() {
      this.pieChartRerender = false;
      this.$nextTick(() => {
        this.pieChartRerender = true;
      });
    },
  },
  methods: {
    chooseDt() {
      this.$store.commit("globalloading/SET_LOADING", true);
      const { date1, date2 } = this;
      console.log("dt1-", date1, " dt2-", date2);
      var choosenDt = date1.split("-");
      var choosenSecDt = date2.split("-");
      const mm = choosenDt[1];
      const prMm = choosenSecDt[1];
      const yyyy = choosenDt[0];
      const pryyyy = choosenSecDt[0];

      if (choosenDt[1] <= choosenSecDt[1] && choosenDt[0] === choosenSecDt[0]) {
        Vue.prototype.$notifyError("Дата 2 должна быть меньше чем Дата 1");
      } else {
        this.$store.commit("fa/SET_MONTH", mm);
        this.$store.commit("fa/SET_YEAR", yyyy);
        this.$store.commit("fa/SET_PR_MONTH", prMm);
        this.$store.commit("fa/SET_PR_YEAR", pryyyy);
        console.log("date1", mm, yyyy, "date2", prMm, pryyyy);
        this.axios
          .get(
            "http://172.20.103.187:7576/api/techregime/factor/graph1/" +
              yyyy +
              "/" +
              mm +
              "/" +
              pryyyy +
              "/" +
              prMm +
              "/"
          )
          .then((response) => {
            this.$store.commit("globalloading/SET_LOADING", false);
            let data = response.data;
            this.editdtm = choosenDt[1];
            this.editdty = choosenDt[0];
            this.editdtprevm = choosenSecDt[1];
            this.editdtprevy = choosenSecDt[0];
            if (data) {
              console.log(data);
              this.wells = data.data;
              this.fullWells = data.data;
              this.chartWells = data.data;
            } else {
              console.log("No data");
            }
            this.dt = "01" + "." + this.editdtm + "." + this.editdty;
            this.dt2 = "01" + "." + this.editdtprevm + "." + this.editdtprevy;
          });
      }
    },
    pushBign(bign) {
      switch (bign) {
        case "bign1":
          this.params.data = this.wellsList;
          break;
      }
      this.$modal.show(bign);
    },
    getColor(status) {
      if (status < "0") return "#ac3939";
    },
  },
  created: function () {
    this.$store.commit("globalloading/SET_LOADING", true);
    if (this.$store.getters["fa/chart"])
      this.chartShow = this.chartArr[this.$store.getters["fa/chart"]];
    var today = new Date();
    // var dd = String(today.getDate()).padStart(2, '0');
    var dd = 1;

    if (
      this.$store.getters["fa/month"] &&
      this.$store.getters["fa/year"] &&
      this.$store.getters["fa/prmonth"] &&
      this.$store.getters["fa/pryear"]
    ) {
      var mm = this.$store.getters["fa/month"];
      var prMm = this.$store.getters["fa/prmonth"];
      var yyyy = this.$store.getters["fa/year"];
      var pryyyy = this.$store.getters["fa/pryear"];
    } else {
      var mm = today.getMonth() + 1;
      var yyyy = today.getFullYear();
      if (mm == 1) {
        var prMm = 12;
        var pryyyy = yyyy - 1;
      } else {
        var prMm = mm - 1;
        var pryyyy = yyyy;
      }
      this.$store.commit("fa/SET_MONTH", mm);
      this.$store.commit("fa/SET_YEAR", yyyy);
      this.$store.commit("fa/SET_PR_MONTH", prMm);
      this.$store.commit("fa/SET_PR_YEAR", pryyyy);
    }
    this.axios
      .get(
        "http://172.20.103.187:7576/api/techregime/factor/graph1/" +
          yyyy +
          "/" +
          mm +
          "/" +
          pryyyy +
          "/" +
          prMm +
          "/"
      )
      .then((response) => {
        this.$store.commit("globalloading/SET_LOADING", false);
        let data = response.data;
        this.editdtm = mm;
        console.log(this.editdtm);
        this.editdty = yyyy;
        console.log(this.editdty);
        this.editdtprevm = prMm;
        console.log(this.editdtprevm);
        this.editdtprevy = yyyy;
        console.log(this.editdtprevy);
        if (data) {
          console.log(data);
          this.wells = data.data;
          this.fullWells = data.data;
          this.chartWells = data.data;
        } else {
          console.log("No data");
        }
        if (String(this.editdtm).length < 2) {
          this.dt = "01" + ".0" + this.editdtm + "." + this.editdty;
        } else {
          this.dt = "01" + "." + this.editdtm + "." + this.editdty;
        }
        if (String(this.editdtprevm).length < 2) {
          this.dt2 = "01" + ".0" + this.editdtprevm + "." + this.editdtprevy;
        } else {
          this.dt2 = "01" + "." + this.editdtprevm + "." + this.editdtprevy;
        }
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
  min-height: 633px;
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
  /* display: flex;  */
  /* justify-content: center */
}
</style>