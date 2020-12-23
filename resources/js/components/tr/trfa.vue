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
              ><svg width="14" height="17" viewBox="0 0 14 17" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M6.75 16.905L0 11.655L1.215 10.71L6.7425 15.0075L12.2775 10.7032L13.5 11.655L6.75 16.905ZM6.75 13.7025L0 8.45249L1.215 7.50749L6.7425 11.805L12.2775 7.49999L13.5 8.45249L6.75 13.7025ZM6.75 10.5L1.2225 6.2025L0 5.25L6.75 0L13.5 5.25L12.27 6.2025L6.75 10.5Z" fill="white"/>
</svg>
</i
            >Технологический режим</a
          >
        </div>
        <!-- <div class="row justify-content-between">
                <form class="form-group but-nav__link">
                        <label for="inputDate">Введите дату:</label>
                        <input type="date" class="form-control" v-model="date1">
                </form>
                <form class="form-group but-nav__link">
                        <label for="inputDate">Выбор даты 2:</label>
                        <input type="date" class="form-control" v-model="date2">
                </form>
                <a href="#" class="but-nav__link but" @click.prevent="chooseDt">Сформировать</a>
        </div> -->
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
            Выберите график
          </a>
          <div class="dropdown-menu fadropmenu" aria-labelledby="dropdownMenuLink" style="   width: 576px;">
            <a class="dropdown-item" href="#" @click="chartShow = 'pie'"
              >Распределение фонда скважин по основной причине снижения дебита нефти</a
            >
            <a class="dropdown-item" href="#" @click="chartShow = 'bar'"
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
          <div class="dropdown-menu fadropmenu" aria-labelledby="dropdownMenuLink" style="background: #656A8A;">
            <label for="inputDate">Введите опорную дату:</label>
            <input type="date" class="form-control" v-model="date1" />
            <label for="inputDate">Введите дату для сравнения:</label>
            <input type="date" class="form-control" v-model="date2" />
            <a href="#" class="btn btn-primary" @click.prevent="chooseDt"
              >Сформировать</a
            >
          </div>
        </div>
      </div>
      <div class="sec_nav">
        <!-- <h4 style="color: white">{{ chartNames[chartShow] }}</h4> -->
        <div class="filter_chart row" style=" display: flex;justify-content: center;">
          <div class="namefilter mb-2" style="color: white">
            <h4>Фильтр по</h4>
          </div>
          <div class="filterplaceone" style="margin-left: 15px">
            <select
              class="form-control mb-2"
              v-model="chartFilter_field"
              value="Месторождение"
            >
              <option v-for="(f, k) in fieldFilters" :key="k" :value="f">
                {{ f === undefined ? "Выберите месторождение" : f }}
              </option>
            </select>
          </div>
          <div class="filterplacetwo" style="margin-left: 15px">
            <select class="form-control mb-2" v-model="chartFilter_horizon">
              <option v-for="(f, k) in horizonFilters" :key="k" :value="f">
                {{ f === undefined ? "Выберите горизонт" : f }}
              </option>
            </select>
          </div>
          <div class="filterplacethree" style="margin-left: 15px">
            <select
              v-if="exp_methFilters"
              class="form-control mb-2"
              v-model="chartFilter_exp_meth"
            >
              <option v-for="(f, k) in exp_methFilters" :key="k" :value="f">
                {{ f === undefined ? "Выберите способ эксплуатации" : f }}
              </option>
            </select>
          </div>
        </div>
        <div class="col-sm" v-if="chartShow === 'bar'">
          <div class="second_block" style="display: flex; justify-content: center;">
            <apexchart
              v-if="barChartData && pieChartRerender"
              type="bar"
              width="1200"
              height='500'
              :options="chartBarOptions"
              :series="[{ name: '', data: barChartData }]"
            ></apexchart>
          </div>
        </div>
        <div class="col-sm" v-if="chartShow === 'pie'">
          <div class="first_block" style="display: flex; justify-content: center;">
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
      if (filtersText) filtersText = `${filtersText}`;

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
      chartFilter_field: undefined,
      chartFilter_horizon: undefined,
      chartFilter_exp_meth: undefined,
      // chartNames: [
      //   "Распределение фонда скважин по основной причине снижения дебита нефти",
      //   "Распределение суммарных отклонений TP по факторам, т/сут",
      // ],
      chartBarOptions: {
        chart: {
          height: 350,
          type: "bar",
          toolbar: {
            show: true,
          },
        },
        title: {
          align: "center",
          offsetY: 18,
          style: {
            fontSize: '14px',
            color: "#008FFB",
          },
        },
        subtitle: {
        align: "center",
        offsetY: 36,
        margin: 10,
        style: {
          fontSize: '14px',
          color: "#008FFB",
          fontWeight: 900,
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
            colors: ["#008ffb"],
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
          labels : {
            style : {
              colors: "#008ffb"
            }
          }
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
              color: "#008ffb"
            }

          },
          labels : {
            style : {
              colors: "#008ffb"
            }
          }
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
            fontSize: '14px',
            color: "#008FFB",
          },
        },
        subtitle: {
          align: "center",
          offsetY: 36,
          margin: 10,
          style: {
            fontSize: '14px',
            color: "#008FFB",
            fontWeight: 900,
          },
        },
        chart: {
          type: "donut",
          toolbar: {
            show: true,
          },
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
        if (this.editdtm < 10 && this.editdtprevm < 10) {
          this.dt = "01" + ".0" + this.editdtm + "." + this.editdty;
          this.dt2 = "01" + ".0" + this.editdtprevm + "." + this.editdtprevy;
        } else if (this.editdtm <= 10 && this.editdtprevm <= 10) {
          this.dt = "01" + "." + this.editdtm + "." + this.editdty;
          this.dt2 = "01" + "." + this.editdtprevm + "." + this.editdtprevy;
        } else if (this.editdtm >= 10 && this.editdtprevm < 10) {
          this.dt = "01" + ".0" + this.editdtm + "." + this.editdty;
          this.dt2 = "01" + ".0" + this.editdtprevm + "." + this.editdtprevy;
        }
        if (this.editdtm < 10) {
          this.dt = "01" + ".0" + this.editdtm + "." + this.editdty;
        } else {
          this.dt = "01" + "." + this.editdtm + "." + this.editdty;
        }
        if (this.editdtprevm < 10) {
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
.tr-chart .row {
  margin-left: 0;
  margin-right: 0;
  padding: 0;
  width: 100%;
}
.tr-chart .sec_nav {
  padding: 20px;
  box-sizing: border-box;
  width: 100%;
  justify-content: space-between;
}
.tr-chart .dropdown {
  display: flex;
  height: 35px;
  margin: 0 20px;
  width: 195px;
}
.tr-chart__loader {
  margin: 50px auto;
  width: 1px;
  height: 78px;
}
body {
  color: white !important;
}
.trfabuttech {
  margin-left: 57px;
}
.trfacolmdrowsecnav {
  margin-bottom: 7px;
  margin-top: 7px;
  margin-left: 1px;
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
  background: #5973cc !important;
}
a:hover {
    color: #FFFFFF;
}
</style>
<style scoped >
.tr-chart {
  display: flex;
  width: 100%;
}
.tr-chart__loader {
  margin: 50px auto;
  width: 1px;
  height: 78px;
}
.tr-chart__content {
  flex-basis: 0;
  flex-grow: 1;
  flex-shrink: 0;
}
.form-control {
  background: #272953 !important;
  border: 1px solid #656a8a !important;
  height: 35px !important;
  color: white !important;
}
.fadropmenu.fadropmenu {
  background: #656a8a;
  color: #ffffff;
  width: 246px;
}

</style>