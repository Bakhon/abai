<template>
  <div class="container-fluid">
    <div class="col-md-12 row">
      <div class="col-md-9 row justify-content-between">
        <a href="fa" class="col but-nav__link but trfacolbutnavlinkbut"
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
    <div class="col-md-9 row sec_nav trfacolmdrowsecnav">
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
        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <a class="dropdown-item" href="#" @click="chartShow = 'pie'"
            >ТОП-30 скважин. Потенциал прироста дебита нефти</a
          >
          <a class="dropdown-item" href="#" @click="chartShow = 'bar'"
            >BarChart</a
          >
        </div>
      </div>

      <div class="col dropdown">
        <button
          class="col-md-12 but-nav__link but"
          type="button"
          id="dropdownMenuButton"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          <i style="margin-right: 10px">
            <svg
              width="18"
              height="20"
              viewBox="0 0 18 20"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M15.6583 19.4286H2.33239C1.281 19.4286 0.42868 18.5843 0.42868 17.5429V4.34285C0.42868 3.3014 1.281 2.45714 2.33239 2.45714H4.23609V0.571426H6.1398V2.45714H11.8509V0.571426H13.7546V2.45714H15.6583C16.7098 2.45714 17.562 3.3014 17.562 4.34285V17.5429C17.562 18.5843 16.7098 19.4286 15.6583 19.4286ZM2.33239 8.11428V17.5429H15.6583V8.11428H2.33239ZM2.33239 4.34285V6.22857H15.6583V4.34285H2.33239ZM8.04351 16.0475L4.51499 12.5523L5.86091 11.2191L8.04351 13.3811L12.1298 9.3334L13.4757 10.6666L8.04351 16.0465V16.0475Z"
                fill="white"
              />
            </svg>
          </i>
          Выберите месяц
        </button>

        <div
          class="dropdown-menu trdropdown"
          aria-labelledby="dropdownMenuButton"
          data-toggle="dropdown"
          @click.prevent.stop="() => {}"
        >
          <div>
            <select
              style="
                background-color: #20274e;
                border-color: #20274e;
                color: white;
              "
              class="form-control"
              id="companySelect"
              @change="onChangeMonth($event)"
            >
              <option>Выберите месяц</option>
              <option value="1">январь</option>
              <option value="2">февраль</option>
              <option value="3">март</option>
              <option value="4">апрель</option>
              <option value="5">май</option>
              <option value="6">июнь</option>
              <option value="7">июль</option>
              <option value="8">август</option>
              <option value="9">сентябрь</option>
              <option value="10">октябрь</option>
              <option value="11">ноябрь</option>
              <option value="12">декабрь</option>
            </select>
          </div>
          <div>
            <select
              style="
                background-color: #20274e;
                border-color: #20274e;
                color: white;
              "
              class="form-control"
              id="companySelect"
              @change="onChangeYear($event)"
            >
              <option value="">Выберите год</option>
              <option value="2020">2020</option>
              <option value="2019">2019</option>
              <option value="2018">2018</option>
              <option value="2017">2017</option>
              <option value="2016">2016</option>
              <option value="2015">2015</option>
              <option value="2014">2014</option>
            </select>
          </div>
          <a
            href="#"
            @click.prevent="chooseDt"
            class="but-nav__link but trbutnav"
            >Сформировать</a
          >
        </div>
      </div>
    </div>
    <div class="col-md-9 sec_nav">
      <div class="namefilter" style="color: white; margin-left: 556px">
        <h3>Фильтр по</h3>
      </div>
      <div class="filter_chart row">
        <div class="filterplaceone" style="margin-left: 211px; width: 300px">
          <select
            class="form-control"
            v-model="chartFilter_field"
            value="Месторождение"
          >
            <option v-for="(f, k) in fieldFilters" :key="k" :value="f">
              {{ f === undefined ? "Выберите месторождение" : f }}
            </option>
          </select>
        </div>
        <div class="filterplacetwo" style="width: 300; margin-left: 7px">
          <select class="form-control" v-model="chartFilter_horizon">
            <option v-for="(f, k) in horizonFilters" :key="k" :value="f">
              {{ f === undefined ? "Выберите горизонт" : f }}
            </option>
          </select>
        </div>
        <div class="filterplacethree" style="margin-left: 7; width: 300">
          <select
            v-if="exp_methFilters"
            class="form-control"
            v-model="chartFilter_exp_meth"
          >
            <option v-for="(f, k) in exp_methFilters" :key="k" :value="f">
              {{ f === undefined ? "Выберите способ эксплуатации" : f }}
            </option>
          </select>
        </div>
      </div>
      <div class="col-sm" v-if="chartShow === 'bar'">
        <div class="second_block">
          <apexchart
            v-if="barChartData && pieChartRerender"
            type="bar"
            :options="chartBarOptions"
            :series="barChartData"
          ></apexchart>
        </div>
      </div>
      <div class="col-sm" v-if="chartShow === 'pie'">
        <div class="first_block">
          <apexchart
            v-if="pieChartData && pieChartRerender"
            type="pie"
            :options="chartOptions"
            :series="pieChartData"
          ></apexchart>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import VueApexCharts from "vue-apexcharts";
export default {
  computed: {
    // field horizon exp_meth
    // Pbh wct p_res PI
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
          console.log(filteredResult);
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
        console.log("chartWells = ", this.chartWells);
        console.log("field = ", field);
        console.log("horizon = ", horizon);
        console.log("exp_meth = ", exp_meth);
        try {
          let filteredResult = this.chartWells.filter(
            (row) =>
              (!field || row.field === field) &&
              (!horizon || this.getStringOrFirstItem(row, 'horizon') === horizon) &&
              (!exp_meth || this.getStringOrFirstItem(row, 'exp_meth') === exp_meth)
          );
          const self = this
          filteredResult.sort(function (a, b) {
                const grow1 = self.getStringOrFirstItem(a, 'tp_idn_oil_inc') + self.getStringOrFirstItem(a, 'tp_idn_grp_q_oil')
                const grow2 = self.getStringOrFirstItem(b, 'tp_idn_oil_inc') + self.getStringOrFirstItem(b, 'tp_idn_grp_q_oil')
                if (grow2 > grow1) {
                    return 1;
                }
                if (grow2 < grow1) {
                    return -1;
                }
                return 0;
          });
          const filtered30 = filteredResult.slice(29);
          console.log("filteredResult = ", filteredResult);
          const categories = filtered30.map(item => this.getStringOrFirstItem(item, 'well'))
          const xaxis = { ...this.chartBarOptions.xaxis, categories }
          this.chartBarOptions = { ...this.chartBarOptions, xaxis }
          console.log('categories = ', categories)
          console.log('xaxis = ', xaxis)
          console.log('chartBarOptions = ', this.chartBarOptions)
          const series= [{
            name: 'Q нефти',
            type: 'bar',
            data: filtered30.map(item => this.getStringOrFirstItem(item, 'q_o'))
          },{
            name: 'Прирост Qн идн',
            type: 'bar',
            data: filtered30.map(item => this.getStringOrFirstItem(item, 'tp_idn_oil_inc'))
          },{
            name: 'Прирост Qн грп',
            type: 'bar',
            data: filtered30.map(item => this.getStringOrFirstItem(item, 'tp_idn_grp_q_oil'))
          },{
            name: 'Рзаб идн',
            type: 'scatter',
            data: filtered30.map(item => this.getStringOrFirstItem(item, 'tp_idn_bhp'))
          }, {
            name: 'Рзаб идн',
            type: 'scatter',
            data: filtered30.map(item => this.getStringOrFirstItem(item, 'bhp'))
          }]
          console.log('series = ', series)
          return series;
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
          const el_horizon = this.getStringOrFirstItem(el, 'horizon')
          const el_exp_meth = this.getStringOrFirstItem(el, 'exp_meth')
          if (
            filters.indexOf(el.field) === -1 &&
            (!this.chartFilter_horizon ||
              el_horizon === this.chartFilter_horizon) &&
            (!this.chartFilter_exp_meth ||
              el_exp_meth === this.chartFilter_exp_meth)
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
          const el_horizon = this.getStringOrFirstItem(el, 'horizon')
          const el_exp_meth = this.getStringOrFirstItem(el, 'exp_meth')
          if (
            filters.indexOf(el_horizon) === -1 &&
            (!this.chartFilter_field || el.field === this.chartFilter_field) &&
            (!this.chartFilter_exp_meth ||
              el_exp_meth === this.chartFilter_exp_meth)
          ) {
            filters = [...filters, el_horizon];
          }
        });
        return [undefined, ...filters];
      } else return [];
    },
    exp_methFilters() {
      if (this.chartWells && this.chartWells.length > 0) {
        let filters = [];

        this.chartWells.forEach((el) => {
          const el_horizon = this.getStringOrFirstItem(el, 'horizon')
          const el_exp_meth = this.getStringOrFirstItem(el, 'exp_meth')
          if (
            filters.indexOf(el_exp_meth) === -1 &&
            (!this.chartFilter_field || el.field === this.chartFilter_field) &&
            (!this.chartFilter_horizon ||
              el_horizon === this.chartFilter_horizon)
          ) {
            filters = [...filters, el_exp_meth];
          }
        });
        return [undefined, ...filters];
      } else return [];
    },
  },
  data: function () {
    return {
      chartShow: "bar",
      pieChartRerender: true,
      wells: [],
      chartWells: [],
      sortType: "asc",
      dt: null,
      date1: null,
      fullWells: [],
      filter: null,
      editdtm: null,
      editdty: null,
      editdtprevm: null,
      editdtprevy: null,
      chartFilter_field: undefined,
      chartFilter_horizon: undefined,
      chartFilter_exp_meth: undefined,
      // sortField: null,
      // currentSortDir: 'asc',
      year: null,
      selectYear: null,
      month: null,
      chartBarOptions: {
        chart: {
          height: 350,
          type: "bar",
        },
        plotOptions: {
          bar: {
            dataLabels: {
              position: "bottom", // top, center, bottom
            },
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
            colors: ["#304758"],
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
        },
      },
      chartOptions: {
        labels: [
          "Недостижение режимного Pзаб",
          "Рост обводненности",
          "Снижение Pпл",
          "Снижение Kпрод",
        ],
        chart: {
          type: "pie",
        },
        dataLabels: {
          enabled: false,
        } /*убирается подсветка процентов на круге*/,
        /*tooltip: {
        enabled: false},*/
        legend: {
          show: false,
        } /*убирается навигация рядом с кругом*/,
        colors: ["#330000", "#804d00", "#00004d", "#999900"],
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
    getStringOrFirstItem(el, param) {
      return Array.isArray(el[param]) ? el[param][0] : el[param];
    },
    onChangeMonth(event) {
      if (event.target.value == 1) {
        this.month = 12;
      } else {
        this.month = event.target.value - 1;
      }
    },
    onChangeYear(event) {
      this.selectYear = event.target.value;
    },
    chooseDt() {
      //   const { dt } = this;
      //   console.log(dt)
      //   var choosenDt = dt.split("-");
      this.$store.commit("tr/SET_MONTH", this.month);
      this.$store.commit("tr/SET_YEAR", this.selectYear);
      if (this.month == 12) {
        this.year = this.selectYear - 1;
      } else {
        this.year = this.selectYear;
      }
      this.axios
        .get(
          "http://172.20.103.51:7576/api/techregime/graph1/" +
            this.year +
            "/" +
            this.month +
            "/"
        )
        .then((response) => {
          // this.editdtm = choosenDt[1];
          // this.editdty = choosenDt[0];
          console.log(this.year);
          console.log(this.month);
          let data = response.data;
          if (data) {
            console.log(data);
            this.wells = data.data;
            this.fullWells = data.data;
            this.chartWells = data.data;
          } else {
            console.log("No data");
          }
          if (this.month < 9) {
            this.dt = "01" + ".0" + (this.month + 1) + "." + this.year;
          } else if (this.month == 12) {
            this.dt = "01" + ".01." + (this.year + 1);
          } else {
            this.dt = "01" + "." + (this.month + 1) + "." + this.year;
          }
        });
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
  created() {
    let prMm, yyyy;
    if (this.$store.getters["tr/month"] && this.$store.getters["tr/year"]) {
      prMm = this.$store.getters["tr/month"];
      yyyy = this.$store.getters["tr/year"];
    } else {
      const today = new Date();
      const dd = String(today.getDate()).padStart(2, "0");
      const mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
      yyyy = today.getFullYear();
      if (mm == 0) {
        prMm = 12;
      } else {
        prMm = mm - 1;
      }
      this.$store.commit("tr/SET_MONTH", prMm);
      this.$store.commit("tr/SET_YEAR", yyyy);
    }
    this.axios
      .get(
        "http://172.20.103.51:7576/api/techregime/graph1/" + yyyy + "/" + prMm + "/"
      )
      .then((response) => {
        let data = response.data;
        this.editdtm = prMm;
        console.log(this.editdtm);
        this.editdty = yyyy;
        console.log(this.editdty);
        if (data) {
          console.log(data);
          this.wells = data.data;
          this.fullWells = data.data;
          this.chartWells = data.data;
        } else {
          console.log("No data");
        }
        if (prMm < 9) {
          this.dt = "01" + ".0" + prMm + "." + yyyy;
        } else {
          this.dt = "01" + "." + prMm + "." + yyyy;
        }
      });
  },
};
</script>
<style  scoped>
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
  margin-left: 45px;
  background: #5973cc !important;
}
</style>



