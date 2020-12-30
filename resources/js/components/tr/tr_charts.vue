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
          <a href="tr" class="col but-nav__link but ml-3"
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
          <div class="dropdown-menu droptr" aria-labelledby="dropdownMenuLink">
            <a
              class="dropdown-item"
              style="background: #5973cc !important; color: #fff"
              v-for="(item, index) in chartNames"
              :key="item"
              href="#"
              @click="chartShow = index"
              >{{ item }}</a
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
            Выберите месяц
          </button>

          <div
            class="dropdown-menu"
            style="background: #5973cc !important"
            aria-labelledby="dropdownMenuButton"
            data-toggle="dropdown"
            @click.prevent.stop="() => {}"
          >
            <div>
              <select
                v-model="month"
                style="
                  background-color: #5973cc !important;
                  border-color: #5973cc !important;

                  color: white;
                "
                class="form-control"
                id="companySelect"
                @change="onChangeMonth($event)"
              >
                <option disabled>Выберите месяц</option>
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
                v-model="selectYear"
                style="
                  background-color: #5973cc !important;
                  border-color: #5973cc !important;
                  color: white;
                "
                class="form-control"
                id="companySelect"
                @change="onChangeYear($event)"
              >
                <option disabled value="">Выберите год</option>
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
              class="btn btn-primary"
              style="margin-left: 15px"
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
            <tr-multiselect
              :filter="chartFilter_field"
              :fieldFilterOptions="fieldFilters"
              @change-filter="handlerFilterFields"
              filterName="месторождения"
            />
          </div>
          <div class="filters__item">
            <tr-multiselect
              :filter="chartFilter_horizon"
              :fieldFilterOptions="horizonFilters"
              @change-filter="handlerFilterHorizons"
              filterName="горизонты"
              textFormsRow="horizons"
            />
          </div>
          <div class="filters__item">
            <tr-multiselect
              :filter="chartFilter_exp_meth"
              :fieldFilterOptions="exp_methFilters"
              @change-filter="handlerFilterFieldsMethods"
              filterName="способы"
              filterNameAdditional="добычи"
              textFormsRow="expMethods"
            />
          </div>
          <div class="filters__item">
            <tr-multiselect
              :filter="chartFilter_object"
              :fieldFilterOptions="objectFilters"
              @change-filter="handlerFilterObjects"
              filterName="блоки"
              textFormsRow="blocks"
            />
          </div>
          <clear-icon
            v-if="chartWells.length !== filteredWellsPreGraph.length"
            @clear-click="clearFilters()"
            background="#333975"
            placeholder="Сбросить фильтры"
            style="margin-left: 10px"
          />
        </div>
      </div>
      <div class="sec_nav">
        <div class="">
          <div class="second_block">
            <apexchart
              v-if="chartData"
              height="100%"
              :options="chartBarOptions"
              :series="chartData"
            ></apexchart>
          </div>
        </div>
      </div>
    </div>
    <big-numbers :list="filteredWells" />
  </div>
</template>
<script>
import VueApexCharts from "vue-apexcharts";
// import FadeLoader from "vue-spinner/src/FadeLoader.vue";
import BigNumbers from "./BigNumbers.vue";
import TrMultiselect from "./TrMultiselect.vue";
import { getFilterText } from "./helpers.js";
import ClearIcon from "../ui-kit/ClearIcon.vue";

export default {
  name: "TrCharts",
  components: {
    // FadeLoader,
    TrMultiselect,
    ClearIcon,
    BigNumbers,
  },
  computed: {
    titleText() {
      return `${this.chartNames[this.chartShow]} на ${this.dt}`;
    },
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
          "blocks"
        ),
      ];
    },
    fieldFilters() {
      if (this.chartWells && this.chartWells.length > 0) {
        let filters = [];
        this.chartWells.forEach((el) => {
          const el_horizon = this.getStringOrFirstItem(el, "horizon");
          const el_exp_meth = this.getStringOrFirstItem(el, "exp_meth");
          if (
            filters.indexOf(el.field) === -1 &&
            (!this.chartFilter_horizon ||
              this.chartFilter_horizon.length === 0 ||
              this.chartFilter_horizon.indexOf(el_horizon) !== -1) &&
            (!this.chartFilter_exp_meth ||
              this.chartFilter_exp_meth.length === 0 ||
              this.chartFilter_exp_meth.indexOf(el_exp_meth) !== -1) &&
            (!this.chartFilter_object ||
              this.chartFilter_object.length === 0 ||
              this.chartFilter_object.indexOf(el.block) !== -1)
            //change it to object
          ) {
            filters = [...filters, el.field];
          }
        });
        return [
          {
            group: "Все месторождения",
            fields: [...filters],
          },
        ];
      } else return [];
    },
    horizonFilters() {
      if (this.chartWells && this.chartWells.length > 0) {
        let filters = [];
        this.chartWells.forEach((el) => {
          const el_horizon = this.getStringOrFirstItem(el, "horizon");
          const el_exp_meth = this.getStringOrFirstItem(el, "exp_meth");
          if (
            filters.indexOf(el_horizon) === -1 &&
            (!this.chartFilter_field ||
              this.chartFilter_field.length === 0 ||
              this.chartFilter_field.indexOf(el.field) !== -1) &&
            (!this.chartFilter_exp_meth ||
              this.chartFilter_exp_meth.length === 0 ||
              this.chartFilter_exp_meth.indexOf(el_exp_meth) !== -1) &&
            (!this.chartFilter_object ||
              this.chartFilter_object.length === 0 ||
              this.chartFilter_object.indexOf(el.block) !== -1)
          ) {
            filters = [...filters, el_horizon];
          }
        });
        return [
          {
            group: "Все горизонты",
            fields: [...filters],
          },
        ];
      } else return [];
    },
    exp_methFilters() {
      if (this.chartWells && this.chartWells.length > 0) {
        let filters = [];

        this.chartWells.forEach((el) => {
          const el_horizon = this.getStringOrFirstItem(el, "horizon");
          const el_exp_meth = this.getStringOrFirstItem(el, "exp_meth");
          if (
            filters.indexOf(el_exp_meth) === -1 &&
            (!this.chartFilter_field ||
              this.chartFilter_field.length === 0 ||
              this.chartFilter_field.indexOf(el.field) !== -1) &&
            (!this.chartFilter_horizon ||
              this.chartFilter_horizon.length === 0 ||
              this.chartFilter_horizon.indexOf(el_horizon) !== -1) &&
            (!this.chartFilter_object ||
              this.chartFilter_object.length === 0 ||
              this.chartFilter_object.indexOf(el.block) !== -1)
          ) {
            filters = [...filters, el_exp_meth];
          }
        });
        return [
          {
            group: "Все способы добычи",
            fields: [...filters],
          },
        ];
      } else return [];
    },
    objectFilters() {
      if (this.chartWells && this.chartWells.length > 0) {
        let filters = [];

        this.chartWells.forEach((el) => {
          const el_horizon = this.getStringOrFirstItem(el, "horizon");
          const el_exp_meth = this.getStringOrFirstItem(el, "exp_meth");
          if (
            filters.indexOf(el.block) === -1 &&
            (!this.chartFilter_field ||
              this.chartFilter_field.length === 0 ||
              this.chartFilter_field.indexOf(el.field) !== -1) &&
            (!this.chartFilter_horizon ||
              this.chartFilter_horizon.length === 0 ||
              this.chartFilter_horizon.indexOf(el_horizon) !== -1) &&
            (!this.chartFilter_exp_meth ||
              this.chartFilter_exp_meth.length === 0 ||
              this.chartFilter_exp_meth.indexOf(el_exp_meth) !== -1)
          ) {
            filters = [...filters, el.block];
          }
        });
        return [
          {
            group: "Все блоки",
            fields: [...filters],
          },
        ];
      } else return [];
    },
  },
  data: function () {
    return {
      chartShow: 0,
      // isLoading: true,
      chartWells: [],
      filteredWellsPreGraph: [],
      filteredWells: [],
      sortType: "asc",
      dt: null,
      date1: null,
      fullWells: [],
      filter: null,
      editdtm: null,
      editdty: null,
      editdtprevm: null,
      editdtprevy: null,
      showFilters: false,
      chartFilter_field: [],
      chartFilter_field_start: true,
      chartFilter_horizon: [],
      chartFilter_horizon_start: true,
      chartFilter_exp_meth: [],
      chartFilter_exp_meth_start: true,
      chartFilter_object: [],
      chartFilter_object_start: true,
      // sortField: null,
      // currentSortDir: 'asc',
      year: null,
      selectYear: null,
      month: null,
      chartData: false,
      chartNames: [
        "Анализ глубин пластов, спуска насосов и динамического уровня",
        "ТОП-30 скважин. Потенциал прироста дебита нефти",
        "ТОП-30 скважин. Потенциал прироста дебита нефти. Обводненность",
        "ТОП-30 скважин. Потенциал прироста дебита нефти. Газовый фактор",
        "ТОП-30 скважин. Потенциал прироста дебита жидкости",
        "Суммарный дебит нефти и жидкости",
        "Распределение коэффициента продуктивности",
        "Распределение скважин по дебиту нефти",
        "Распределение скважин по обводненности",
        "Распределение скважин по дебиту жидкости",
      ],
      chartBarOptions: {
        colors: ["#00e396", "#feb019", "#5FA7FF", "#ff4560", "#554298"],
        chart: {
          height: "100%",
          stacked: true,
          toolbar: {
            show: true,
          },
          zoom: {
            enabled: true,
          },
          fontFamily: "Harmonia-sans, Helvetica, Arial, sans-serif",
        },
        plotOptions: {
          bar: {
            dataLabels: {
              position: "bottom", // top, center, bottom
            },
          },
        },
        stroke: {
          show: false,
        },
        markers: {
          size: [0, 0, 0, 8, 8],
          offsetX: -2,
        },
        legend: {
          position: "bottom",
          labels: {
            useSeriesColors: true,
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
          labels: {
            hideOverlappingLabels: true,
            rotate: -45,
            style: {
              colors: "#5FA7FF",
            },
          },
          categories: [],
          tickPlacement: "on",
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
        dataLabels: {
          enabled: false,
          enabledOnSeries: undefined,
        },
      },
      markersBase: {
        size: [0, 0, 0, 8, 8],
        offsetX: -2,
      },
      fillBase: {
        opacity: 1,
      },
      titleBase: {
        align: "center",
        offsetY: 15,
        style: {
          fontSize: "12px",
          color: "#5FA7FF",
        },
      },
      subtitleBase: {
        align: "center",
        offsetY: 30,
        style: {
          fontSize: "12px",
          color: "#5FA7FF",
          fontWeight: 700,
        },
      },
      yaxisBase: {
        axisBorder: {
          show: true,
        },
        labels: {
          style: {
            colors: "#5FA7FF",
          },
        },
        axisTicks: {
          show: false,
        },
        title: {
          text: "Дебит нефти [т/сут]",
          style: {
            color: "#5FA7FF",
          },
        },
        decimalsInFloat: 2,
      },
    };
  },
  watch: {
    chartShow() {
      this.calcChartData();
    },
    chartWells() {
      this.calcChartData();
    },
    fieldFilters() {
      if (this.chartFilter_field_start) {
        this.chartFilter_field = this.fieldFilters[0].fields;
        this.chartFilter_field_start = false;
      } else {
        const newFilter = this.chartFilter_field.filter(
          (el) => this.fieldFilters[0].fields.indexOf(el) !== -1
        );
        if (newFilter.length !== this.chartFilter_field.length)
          this.chartFilter_field = newFilter;
      }
      this.refreshFilters();
      this.calcChartData();
    },
    horizonFilters() {
      if (this.chartFilter_horizon_start) {
        this.chartFilter_horizon = this.horizonFilters[0].fields;
        this.chartFilter_horizon_start = false;
      } else {
        const newFilter = this.chartFilter_horizon.filter(
          (el) => this.horizonFilters[0].fields.indexOf(el) !== -1
        );
        if (newFilter.length !== this.chartFilter_horizon.length)
          this.chartFilter_horizon = newFilter;
      }
      this.refreshFilters();
      this.calcChartData();
    },
    exp_methFilters() {
      if (this.chartFilter_exp_meth_start) {
        this.chartFilter_exp_meth = this.exp_methFilters[0].fields;
        this.chartFilter_exp_meth_start = false;
      } else {
        const newFilter = this.chartFilter_exp_meth.filter(
          (el) => this.exp_methFilters[0].fields.indexOf(el) !== -1
        );
        if (newFilter.length !== this.chartFilter_exp_meth.length)
          this.chartFilter_exp_meth = newFilter;
      }
      this.refreshFilters();
      this.calcChartData();
    },
    objectFilters() {
      if (this.chartFilter_object_start) {
        this.chartFilter_object = this.objectFilters[0].fields;
        this.chartFilter_object_start = false;
      } else {
        const newFilter = this.chartFilter_object.filter(
          (el) => this.objectFilters[0].fields.indexOf(el) !== -1
        );
        if (newFilter.length !== this.chartFilter_object.length)
          this.chartFilter_object = newFilter;
      }
      this.refreshFilters();
      this.calcChartData();
    },
  },
  methods: {
    clearFilters() {
      this.chartFilter_object = [];
      this.chartFilter_exp_meth = [];
      this.chartFilter_horizon = [];
      this.chartFilter_field = [];
    },
    refreshFilters() {
      if (
        this.chartFilter_object.length === 0 &&
        this.chartFilter_exp_meth.length === 0 &&
        this.chartFilter_horizon.length === 0 &&
        this.chartFilter_field.length === 0
      ) {
        this.chartFilter_object = [...this.objectFilters[0].fields];
        this.chartFilter_exp_meth = [...this.exp_methFilters[0].fields];
        this.chartFilter_horizon = [...this.horizonFilters[0].fields];
        this.chartFilter_field = [...this.fieldFilters[0].fields];
      }
    },
    handlerFilterFields(filter) {
      this.chartFilter_field = filter;
    },
    handlerFilterHorizons(filter) {
      this.chartFilter_horizon = filter;
    },
    handlerFilterFieldsMethods(filter) {
      this.chartFilter_exp_meth = filter;
    },
    handlerFilterObjects(filter) {
      this.chartFilter_object = filter;
    },
    async calcChartData() {
      if (this.chartWells && this.chartWells.length > 0) {
        const field = this.chartFilter_field;
        const horizon = this.chartFilter_horizon;
        const exp_meth = this.chartFilter_exp_meth;
        const object = this.chartFilter_object;
        try {
          const filteredResult = this.chartWells.filter(
            (row) =>
              (!field || field.indexOf(row.field) !== -1) &&
              (!object || object.indexOf(row.block) !== -1) &&
              (!horizon ||
                horizon.indexOf(this.getStringOrFirstItem(row, "horizon")) !==
                  -1) &&
              (!exp_meth ||
                exp_meth.indexOf(this.getStringOrFirstItem(row, "exp_meth")) !==
                  -1)
          );
          console.log("filtered = ", filteredResult);
          this.filteredWellsPreGraph = filteredResult;
          this.chartData = await this[`setDataChart${this.chartShow}`](
            filteredResult
          );
        } catch (err) {
          console.error(err);
          this.chartData = false;
        }
        //return false;
      } else {
        this.chartData = false;
      }
    },
    setDataChart0(filteredResult) {
      // Все скважины. Потенциал снижения динамического уровня, спуска ГНО
      this.filteredWells = filteredResult;
      const self = this;
      filteredResult.sort(function (a, b) {
        if (b.h_up_perf_md < a.h_up_perf_md) return 1;
        if (b.h_up_perf_md > a.h_up_perf_md) return -1;
        return 0;
      });
      let maxY1 = 0,
        minY1 = 0;
      const categories = filteredResult.map((item) => {
        let newMaxY1, newMinY1;
        if (item.h_dyn > item.h_up_perf_md) {
          if (item.h_dyn > item.h_pump_set) newMaxY1 = item.h_dyn;
          else newMaxY1 = item.h_pump_set;
        } else {
          if (item.h_up_perf_md > item.h_pump_set) newMaxY1 = item.h_up_perf_md;
          else newMaxY1 = item.h_pump_set;
        }
        if (item.h_dyn < item.h_up_perf_md) {
          if (item.h_dyn < item.h_pump_set) newMinY1 = item.h_dyn;
          else newMinY1 = item.h_pump_set;
        } else {
          if (item.h_up_perf_md < item.h_pump_set) newMinY1 = item.h_up_perf_md;
          else newMinY1 = item.h_pump_set;
        }
        if (newMinY1 < minY1) minY1 = newMinY1;
        if (newMaxY1 > maxY1) maxY1 = newMaxY1;
        return this.getStringOrFirstItem(item, "well");
      });
      const labels = { ...this.chartBarOptions.xaxis.labels };
      labels.style.cssClass = "chart-labels";
      labels.rotateAlways = true;
      const xaxis = { ...this.chartBarOptions.xaxis, labels, categories };
      const stacked = false;
      const stroke = {
        show: true,
        width: [1, 1, 5],
        colors: ["#27295300", "#27295300", "#5FA7FF"],
      };
      const chart = { ...this.chartBarOptions.chart, stacked };
      const yaxis = {
        ...this.yaxisBase,
        title: {
          text: "Измеренная глубина [м]",
          style: {
            color: "#5FA7FF",
          },
        },
        max: maxY1,
        min: minY1,
        reversed: true,
      };
      const title = {
        ...this.titleBase,
        text: this.titleText,
      };
      const subtitle = {
        ...this.subtitleBase,
        text: this.subtitleText,
      };

      this.chartBarOptions = {
        ...this.chartBarOptions,
        xaxis,
        yaxis,
        chart,
        stroke,
        markers: {
          size: [5, 5, 0],
          offsetX: -2,
        },
        fill: {
          opacity: 0.3,
        },
        title,
        subtitle,
      };

      const series = [
        {
          name: "Н дин",
          type: "line",
          data: filteredResult.map((item) =>
            this.getStringOrFirstItem(item, "h_dyn")
          ),
        },
        {
          name: "Н сп насоса",
          type: "line",
          data: filteredResult.map((item, index) =>
            this.getStringOrFirstItem(item, "h_pump_set")
          ),
        },
        {
          name: "Н вдп",
          type: "area",
          data: filteredResult.map((item) =>
            this.getStringOrFirstItem(item, "h_up_perf_md")
          ),
        },
      ];
      return series;
    },
    setDataChart1(filteredResult) {
      // ТОП-30 скважин. Потенциал прироста дебита нефти
      const self = this;
      filteredResult.sort(function (a, b) {
        const grow1 =
          self.getStringOrFirstItem(a, "tp_idn_oil_inc") +
          self.getStringOrFirstItem(a, "tp_idn_grp_q_oil");
        const grow2 =
          self.getStringOrFirstItem(b, "tp_idn_oil_inc") +
          self.getStringOrFirstItem(b, "tp_idn_grp_q_oil");
        if (grow2 > grow1) return 1;
        if (grow2 < grow1) return -1;
        return 0;
      });
      let filtered30;
      filtered30 = filteredResult.slice(0, 30);
      this.filteredWells = filtered30;
      let maxY1 = 0,
        minY1 = 0,
        maxY2 = 0,
        minY2 = 0;
      const categories = filtered30.map((item) => {
        const newY1 = item.q_o + item.tp_idn_oil_inc + item.tp_idn_grp_q_oil;
        const newY2Max =
          item.tp_idn_bhp > item.bhp ? item.tp_idn_bhp : item.bhp;
        const newY2Min =
          item.tp_idn_bhp < item.bhp ? item.tp_idn_bhp : item.bhp;
        if (newY1 < minY1) minY1 = newY1;
        if (newY1 > maxY1) maxY1 = newY1;
        if (newY2Min < minY2) minY1 = newY2Min;
        if (newY2Max > maxY2) maxY2 = newY2Max;
        return this.getStringOrFirstItem(item, "well");
      });
      const labels = { ...this.chartBarOptions.xaxis.labels };
      labels.style.cssClass = "";
      labels.rotateAlways = true;
      const xaxis = { ...this.chartBarOptions.xaxis, labels, categories };
      console.log("xaxis = ", xaxis);
      const stacked = true;
      const stroke = {
        show: false,
        width: [1, 1, 1],
      };
      const chart = { ...this.chartBarOptions.chart, stacked };
      const yaxis = [
        {
          // seriesName: "Q нефти",
          ...this.yaxisBase,
          tooltip: {
            enabled: true,
          },
          max: maxY1,
          min: minY1,
        },
        {
          ...this.yaxisBase,
          show: false,
          max: maxY1,
          min: minY1,
        },
        {
          ...this.yaxisBase,
          show: false,
          max: maxY1,
          min: minY1,
        },
        {
          ...this.yaxisBase,
          opposite: true,
          title: {
            rotate: 90,
            text: "Давление [атм]",
            style: {
              color: "#5FA7FF",
            },
          },
          max: maxY2,
          min: minY2,
        },
      ];
      const title = {
        ...this.titleBase,
        text: this.titleText,
      };
      const subtitle = {
        ...this.subtitleBase,
        text: this.subtitleText,
      };

      this.chartBarOptions = {
        ...this.chartBarOptions,
        xaxis,
        yaxis,
        chart,
        stroke,
        markers: this.markersBase,
        fill: this.fillBase,
        title,
        subtitle,
      };
      const series = [
        {
          name: "Q нефти",
          type: "bar",
          data: filtered30.map((item) =>
            this.getStringOrFirstItem(item, "q_o")
          ),
        },
        {
          name: "Прирост Qн идн",
          type: "bar",
          data: filtered30.map((item) =>
            this.getStringOrFirstItem(item, "tp_idn_oil_inc")
          ),
        },
        {
          name: "Прирост Qн грп",
          type: "bar",
          data: filtered30.map((item) =>
            this.getStringOrFirstItem(item, "tp_idn_grp_q_oil")
          ),
        },
        {
          name: "Рзаб идн",
          type: "line",
          data: filtered30.map((item, index) =>
            this.getStringOrFirstItem(item, "tp_idn_bhp")
          ),
        },
        {
          name: "Рзаб факт",
          type: "bubble",
          data: filtered30.map((item, inde) =>
            this.getStringOrFirstItem(item, "bhp")
          ),
        },
      ];
      return series;
    },
    setDataChart2(filteredResult) {
      // ТОП-30 скважин. Потенциал прироста дебита нефти. Обводненность
      const self = this;
      filteredResult.sort(function (a, b) {
        const grow1 =
          self.getStringOrFirstItem(a, "tp_idn_oil_inc") +
          self.getStringOrFirstItem(a, "tp_idn_grp_q_oil");
        const grow2 =
          self.getStringOrFirstItem(b, "tp_idn_oil_inc") +
          self.getStringOrFirstItem(b, "tp_idn_grp_q_oil");
        if (grow2 > grow1) return 1;
        if (grow2 < grow1) return -1;
        return 0;
      });
      let filtered30;
      filtered30 = filteredResult.slice(0, 30);
      this.filteredWells = filtered30;
      let maxY1 = 0,
        minY1 = 0,
        maxY2 = 0,
        minY2 = 0;
      const categories = filtered30.map((item) => {
        const newY1 = item.q_o + item.tp_idn_oil_inc + item.tp_idn_grp_q_oil;
        const newY2 = item.wct;
        if (newY1 < minY1) minY1 = newY1;
        if (newY1 > maxY1) maxY1 = newY1;
        if (newY2 < minY2) minY1 = newY2;
        if (newY2 > maxY2) maxY2 = newY2;
        return this.getStringOrFirstItem(item, "well");
      });
      const labels = { ...this.chartBarOptions.xaxis.labels };
      labels.style.cssClass = "";
      labels.rotateAlways = true;
      const xaxis = { ...this.chartBarOptions.xaxis, labels, categories };
      const stacked = true;
      const stroke = {
        show: false,
        width: [1, 1, 1],
      };
      const chart = { ...this.chartBarOptions.chart, stacked };
      const yaxis = [
        {
          ...this.yaxisBase,
          tooltip: {
            enabled: true,
          },
          max: maxY1,
          min: minY1,
        },
        {
          ...this.yaxisBase,
          show: false,
          max: maxY1,
          min: minY1,
        },
        {
          ...this.yaxisBase,
          show: false,
          max: maxY1,
          min: minY1,
        },
        {
          ...this.yaxisBase,
          opposite: true,
          title: {
            rotate: 90,
            text: "Обводненность [%]",
            style: {
              color: "#5FA7FF",
            },
          },
          max: maxY2,
          min: minY2,
        },
      ];
      const title = {
        ...this.titleBase,
        text: this.titleText,
      };
      const subtitle = {
        ...this.subtitleBase,
        text: this.subtitleText,
      };

      this.chartBarOptions = {
        ...this.chartBarOptions,
        xaxis,
        yaxis,
        chart,
        stroke,
        markers: this.markersBase,
        fill: this.fillBase,
        title,
        subtitle,
      };
      const series = [
        {
          name: "Q нефти",
          type: "bar",
          data: filtered30.map((item) =>
            this.getStringOrFirstItem(item, "q_o")
          ),
        },
        {
          name: "Прирост Qн идн",
          type: "bar",
          data: filtered30.map((item) =>
            this.getStringOrFirstItem(item, "tp_idn_oil_inc")
          ),
        },
        {
          name: "Прирост Qн грп",
          type: "bar",
          data: filtered30.map((item) =>
            this.getStringOrFirstItem(item, "tp_idn_grp_q_oil")
          ),
        },
        {
          name: "Обводненность",
          type: "line",
          data: filtered30.map((item, index) =>
            this.getStringOrFirstItem(item, "wct")
          ),
        },
      ];
      return series;
    },
    setDataChart3(filteredResult) {
      // ТОП-30 скважин. Потенциал прироста дебита нефти. Газовый фактор
      const self = this;
      filteredResult.sort(function (a, b) {
        const grow1 =
          self.getStringOrFirstItem(a, "tp_idn_oil_inc") +
          self.getStringOrFirstItem(a, "tp_idn_grp_q_oil");
        const grow2 =
          self.getStringOrFirstItem(b, "tp_idn_oil_inc") +
          self.getStringOrFirstItem(b, "tp_idn_grp_q_oil");
        if (grow2 > grow1) return 1;
        if (grow2 < grow1) return -1;
        return 0;
      });
      let filtered30;
      filtered30 = filteredResult.slice(0, 30);
      this.filteredWells = filtered30;
      let maxY1 = 0,
        minY1 = 0,
        maxY2 = 0,
        minY2 = 0;
      const categories = filtered30.map((item) => {
        const newY1 = item.q_o + item.tp_idn_oil_inc + item.tp_idn_grp_q_oil;
        const newY2 = item.gor;
        if (newY1 < minY1) minY1 = newY1;
        if (newY1 > maxY1) maxY1 = newY1;
        if (newY2 < minY2) minY1 = newY2;
        if (newY2 > maxY2) maxY2 = newY2;
        return this.getStringOrFirstItem(item, "well");
      });
      const labels = { ...this.chartBarOptions.xaxis.labels };
      labels.style.cssClass = "";
      labels.rotateAlways = true;
      const xaxis = { ...this.chartBarOptions.xaxis, labels, categories };
      const stacked = true;
      const stroke = {
        show: false,
        width: [1, 1, 1],
      };
      const chart = { ...this.chartBarOptions.chart, stacked };
      const yaxis = [
        {
          ...this.yaxisBase,
          tooltip: {
            enabled: true,
          },
          max: maxY1,
          min: minY1,
        },
        {
          ...this.yaxisBase,
          show: false,
          max: maxY1,
          min: minY1,
        },
        {
          ...this.yaxisBase,
          show: false,
          max: maxY1,
          min: minY1,
        },
        {
          ...this.yaxisBase,
          opposite: true,
          title: {
            rotate: 90,
            text: "ГФ [м3/т]",
            style: {
              color: "#5FA7FF",
            },
          },
          max: maxY2,
          min: minY2,
        },
      ];
      const title = {
        ...this.titleBase,
        text: this.titleText,
      };
      const subtitle = {
        ...this.subtitleBase,
        text: this.subtitleText,
      };

      this.chartBarOptions = {
        ...this.chartBarOptions,
        xaxis,
        yaxis,
        chart,
        stroke,
        markers: this.markersBase,
        fill: this.fillBase,
        title,
        subtitle,
      };
      const series = [
        {
          name: "Q нефти",
          type: "bar",
          data: filtered30.map((item) =>
            this.getStringOrFirstItem(item, "q_o")
          ),
        },
        {
          name: "Прирост Qн идн",
          type: "bar",
          data: filtered30.map((item) =>
            this.getStringOrFirstItem(item, "tp_idn_oil_inc")
          ),
        },
        {
          name: "Прирост Qн грп",
          type: "bar",
          data: filtered30.map((item) =>
            this.getStringOrFirstItem(item, "tp_idn_grp_q_oil")
          ),
        },
        {
          name: "Газовый фактор",
          type: "line",
          data: filtered30.map((item, index) =>
            this.getStringOrFirstItem(item, "gor")
          ),
        },
      ];
      return series;
    },
    setDataChart4(filteredResult) {
      // ТОП-30 скважин. Потенциал прироста дебита жидкости
      const self = this;
      filteredResult.sort(function (a, b) {
        const grow1 =
          self.getStringOrFirstItem(a, "tp_idn_oil_inc") +
          self.getStringOrFirstItem(a, "tp_idn_grp_q_oil");
        const grow2 =
          self.getStringOrFirstItem(b, "tp_idn_oil_inc") +
          self.getStringOrFirstItem(b, "tp_idn_grp_q_oil");
        if (grow2 > grow1) return 1;
        if (grow2 < grow1) return -1;
        return 0;
      });
      let filtered30;
      filtered30 = filteredResult.slice(0, 30);
      this.filteredWells = filtered30;
      let maxY1 = 0,
        minY1 = 0,
        maxY2 = 0,
        minY2 = 0;
      const categories = filtered30.map((item) => {
        const newY1 = item.q_l + item.tp_idn_liq_inc + item.tp_idn_grp_q_liq;
        const newY2Max =
          item.tp_idn_bhp > item.bhp ? item.tp_idn_bhp : item.bhp;
        const newY2Min =
          item.tp_idn_bhp < item.bhp ? item.tp_idn_bhp : item.bhp;
        if (newY1 < minY1) minY1 = newY1;
        if (newY1 > maxY1) maxY1 = newY1;
        if (newY2Min < minY2) minY1 = newY2Min;
        if (newY2Max > maxY2) maxY2 = newY2Max;
        return this.getStringOrFirstItem(item, "well");
      });
      const labels = { ...this.chartBarOptions.xaxis.labels };
      labels.style.cssClass = "";
      labels.rotateAlways = true;
      const xaxis = { ...this.chartBarOptions.xaxis, labels, categories };
      const stacked = true;
      const stroke = {
        show: false,
        width: [1, 1, 1],
      };
      const chart = { ...this.chartBarOptions.chart, stacked };
      const yaxis = [
        {
          // seriesName: "Q нефти",
          ...this.yaxisBase,
          title: {
            text: "Дебит жидкости [м3/сут]",
            style: {
              color: "#5FA7FF",
            },
          },
          tooltip: {
            enabled: true,
          },
          max: maxY1,
          min: minY1,
        },
        {
          ...this.yaxisBase,
          show: false,
          max: maxY1,
          min: minY1,
        },
        {
          ...this.yaxisBase,
          show: false,
          max: maxY1,
          min: minY1,
        },
        {
          ...this.yaxisBase,
          opposite: true,
          title: {
            rotate: 90,
            text: "Давление [атм]",
            style: {
              color: "#5FA7FF",
            },
          },
          max: maxY2,
          min: minY2,
        },
      ];
      const title = {
        ...this.titleBase,
        text: this.titleText,
      };
      const subtitle = {
        ...this.subtitleBase,
        text: this.subtitleText,
      };

      this.chartBarOptions = {
        ...this.chartBarOptions,
        xaxis,
        yaxis,
        chart,
        stroke,
        markers: this.markersBase,
        fill: this.fillBase,
        title,
        subtitle,
      };
      const series = [
        {
          name: "Q жидкости",
          type: "bar",
          data: filtered30.map((item) =>
            this.getStringOrFirstItem(item, "q_l")
          ),
        },
        {
          name: "Прирост Qж идн",
          type: "bar",
          data: filtered30.map((item) =>
            this.getStringOrFirstItem(item, "tp_idn_liq_inc")
          ),
        },
        {
          name: "Прирост Qж грп",
          type: "bar",
          data: filtered30.map((item) =>
            this.getStringOrFirstItem(item, "tp_idn_grp_q_liq")
          ),
        },
        {
          name: "Рзаб идн",
          type: "line",
          data: filtered30.map((item, index) =>
            this.getStringOrFirstItem(item, "tp_idn_bhp")
          ),
        },
        {
          name: "Рзаб факт",
          type: "bubble",
          data: filtered30.map((item, inde) =>
            this.getStringOrFirstItem(item, "bhp")
          ),
        },
      ];
      return series;
    },
    setDataChart5(filteredResult) {
      this.filteredWells = filteredResult;
      const categories = ["Факт", "ИДН", "ИДН+ГРП"];
      const labels = { ...this.chartBarOptions.xaxis.labels };
      labels.style.cssClass = "";
      labels.rotateAlways = false;
      const xaxis = { ...this.chartBarOptions.xaxis, labels, categories };
      const stacked = false;
      const chart = { ...this.chartBarOptions.chart, stacked };
      const yaxis = {
        ...this.yaxisBase,
        title: {
          text: "Дебит нефти [т.сут] | Дебит жидкости [м3/сут]",
          style: {
            color: "#5FA7FF",
          },
        },
      };
      const title = {
        ...this.titleBase,
        text: this.titleText,
      };
      const stroke = {
        show: false,
        width: [1, 1],
      };
      const subtitle = {
        ...this.subtitleBase,
        text: this.subtitleText,
      };

      this.chartBarOptions = {
        ...this.chartBarOptions,
        xaxis,
        yaxis,
        chart,
        stroke,
        markers: this.markersBase,
        fill: this.fillBase,
        title,
        subtitle,
      };
      let filteredData = filteredResult.reduce(
        (acc, res) => {
          acc = {
            oil: acc["oil"] + res["q_o"],
            q_l: acc["q_l"] + res["q_l"],
            tp_idn_oil: acc["tp_idn_oil"] + res["tp_idn_oil"],
            tp_idn_liq_cas_d_corr:
              acc["tp_idn_liq_cas_d_corr"] + res["tp_idn_liq_cas_d_corr"],
            tp_idn_grp_q_oil: acc["tp_idn_grp_q_oil"] + res["tp_idn_grp_q_oil"],
            tp_idn_grp_q_liq_cas_d_corr:
              acc["tp_idn_grp_q_liq_cas_d_corr"] +
              res["tp_idn_grp_q_liq_cas_d_corr"],
          };
          return acc;
        },
        {
          oil: 0,
          q_l: 0,
          tp_idn_oil: 0,
          tp_idn_liq_cas_d_corr: 0,
          tp_idn_grp_q_oil: 0,
          tp_idn_grp_q_liq_cas_d_corr: 0,
        }
      );
      const series = [
        {
          name: "Q нефти суммарный по фонду",
          type: "bar",
          data: [
            filteredData.oil,
            filteredData.tp_idn_oil,
            filteredData.tp_idn_grp_q_oil,
          ],
        },
        {
          name: "Q жидкости суммарный по фонду",
          type: "bar",
          data: [
            filteredData.q_l,
            filteredData.tp_idn_liq_cas_d_corr,
            filteredData.tp_idn_grp_q_liq_cas_d_corr,
          ],
        },
      ];
      return series;
      // Суммарный дебит нефти и жидкости
    },
    setDataChart6(filteredResult) {
      // Распределение коэффициента продуктивности
      this.filteredWells = filteredResult;
      const self = this;
      filteredResult.sort(function (a, b) {
        if (b.pi > a.pi) return 1;
        if (b.pi < a.pi) return -1;
        return 0;
      });
      const categories = filteredResult.map((item) =>
        this.getStringOrFirstItem(item, "well")
      );
      const labels = { ...this.chartBarOptions.xaxis.labels };
      labels.style.cssClass = "chart-labels";
      labels.rotateAlways = true;
      const xaxis = { ...this.chartBarOptions.xaxis, labels, categories };
      const yaxis = {
        ...this.yaxisBase,
        title: {
          text: "Коэффициент продуктивности [м3/сут/атм]",
          style: {
            color: "#5FA7FF",
          },
        },
      };
      const title = {
        ...this.titleBase,
        text: this.titleText,
      };
      const subtitle = {
        ...this.subtitleBase,
        text: this.subtitleText,
      };
      const stroke = {
        show: false,
        width: [1],
      };
      this.chartBarOptions = {
        ...this.chartBarOptions,
        xaxis,
        yaxis,
        stroke,
        fill: this.fillBase,
        title,
        subtitle,
      };
      const series = [
        {
          name: "Кпрод",
          type: "bar",
          data: filteredResult.map((item) =>
            this.getStringOrFirstItem(item, "pi")
          ),
        },
      ];
      return series;
    },
    setDataChart7(filteredResult) {
      // Распределение скважин по дебиту нефти
      this.filteredWells = filteredResult;
      const self = this;
      filteredResult.sort(function (a, b) {
        if (b.q_o > a.q_o) return 1;
        if (b.q_o < a.q_o) return -1;
        return 0;
      });
      const categories = filteredResult.map((item) =>
        this.getStringOrFirstItem(item, "well")
      );
      const labels = { ...this.chartBarOptions.xaxis.labels };
      labels.style.cssClass = "chart-labels";
      labels.rotateAlways = true;
      const xaxis = { ...this.chartBarOptions.xaxis, labels, categories };
      const yaxis = { ...this.yaxisBase };
      const title = {
        ...this.titleBase,
        text: this.titleText,
      };
      const subtitle = {
        ...this.subtitleBase,
        text: this.subtitleText,
      };
      const stroke = {
        show: false,
        width: [1],
      };
      this.chartBarOptions = {
        ...this.chartBarOptions,
        xaxis,
        yaxis,
        stroke,
        fill: this.fillBase,
        title,
        subtitle,
      };
      const series = [
        {
          name: "Q нефти",
          type: "bar",
          data: filteredResult.map((item) =>
            this.getStringOrFirstItem(item, "q_o")
          ),
        },
      ];
      return series;
    },
    setDataChart8(filteredResult) {
      // Распределение скважин по обводненности
      this.filteredWells = filteredResult;
      const self = this;
      filteredResult.sort(function (a, b) {
        if (b.wct > a.wct) return 1;
        if (b.wct < a.wct) return -1;
        return 0;
      });
      const categories = filteredResult.map((item) =>
        this.getStringOrFirstItem(item, "well")
      );
      const labels = { ...this.chartBarOptions.xaxis.labels };
      labels.style.cssClass = "chart-labels";
      labels.rotateAlways = true;
      const xaxis = { ...this.chartBarOptions.xaxis, labels, categories };
      const yaxis = {
        ...this.yaxisBase,
        title: {
          text: "Обводненность [%]",
          style: {
            color: "#5FA7FF",
          },
        },
      };
      const title = {
        ...this.titleBase,
        text: this.titleText,
      };
      const subtitle = {
        ...this.subtitleBase,
        text: this.subtitleText,
      };
      const stroke = {
        show: false,
        width: [1],
      };
      this.chartBarOptions = {
        ...this.chartBarOptions,
        xaxis,
        yaxis,
        stroke,
        fill: this.fillBase,
        title,
        subtitle,
      };
      const series = [
        {
          name: "Обводненность",
          type: "bar",
          data: filteredResult.map((item) =>
            this.getStringOrFirstItem(item, "wct")
          ),
        },
      ];
      return series;
    },
    setDataChart9(filteredResult) {
      // Распределение скважин по дебиту жидкости
      this.filteredWells = filteredResult;
      const self = this;
      filteredResult.sort(function (a, b) {
        if (b.q_l > a.q_l) return 1;
        if (b.q_l < a.q_l) return -1;
        return 0;
      });
      const categories = filteredResult.map((item) =>
        this.getStringOrFirstItem(item, "well")
      );
      const labels = { ...this.chartBarOptions.xaxis.labels };
      labels.style.cssClass = "chart-labels";
      labels.rotateAlways = true;
      const xaxis = { ...this.chartBarOptions.xaxis, labels, categories };
      const yaxis = {
        ...this.yaxisBase,
        title: {
          text: "Дебит жидкости [м3/сут]",
          style: {
            color: "#5FA7FF",
          },
        },
      };
      const title = {
        ...this.titleBase,
        text: this.titleText,
      };
      const subtitle = {
        ...this.subtitleBase,
        text: this.subtitleText,
      };
      const stroke = {
        show: false,
        width: [1],
      };
      this.chartBarOptions = {
        ...this.chartBarOptions,
        xaxis,
        yaxis,
        stroke,
        fill: this.fillBase,
        title,
        subtitle,
      };
      const series = [
        {
          name: "Дебит жидкости",
          type: "bar",
          data: filteredResult.map((item) =>
            this.getStringOrFirstItem(item, "q_l")
          ),
        },
      ];
      return series;
    },
    getStringOrFirstItem(el, param) {
      return Array.isArray(el[param]) ? el[param][0] : el[param];
    },
    onChangeMonth(event) {
      this.$store.commit("tr/SET_MONTH", event.target.value);
    },
    onChangeYear(event) {
      this.$store.commit("tr/SET_YEAR", event.target.value);
    },
    chooseDt() {
      this.$store.commit("globalloading/SET_LOADING", true);
      // this.isLoading = true;
      this.$store.commit("tr/SET_MONTH", this.month);
      this.$store.commit("tr/SET_YEAR", this.selectYear);
      if (this.month < 10) {
        this.dt = "01" + ".0" + this.month + "." + this.selectYear;
      } else {
        this.dt = "01" + "." + this.month + "." + this.selectYear;
      }
      this.axios
        .get(
          "http://172.20.103.187:7576/api/techregime/graph1/" +
            this.selectYear +
            "/" +
            this.month +
            "/"
        )
        .then((response) => {
          // this.editdtm = choosenDt[1];
          // this.editdty = choosenDt[0];
          this.$store.commit("globalloading/SET_LOADING", false);
          // this.isLoading = false;
          let data = response.data;
          if (data) {
            this.fullWells = data.data;
            this.chartWells = data.data;
            this.chartFilter_field_start = true;
            this.chartFilter_horizon_start = true;
            this.chartFilter_exp_meth_start = true;
            this.chartFilter_object_start = true;
          } else {
            console.log("No data");
          }
        });
    },
    getColor(status) {
      if (status < "0") return "#ac3939";
    },
    setChart(status) {
      if (status < "0") return "#ac3939";
    },
  },
  created() {
    this.$store.commit("globalloading/SET_LOADING", true);
    // this.isLoading = true;
    if (this.$store.getters["tr/chart"])
      this.chartShow = this.$store.getters["tr/chart"];
    let mm, yyyy;
    if (this.$store.getters["tr/month"] && this.$store.getters["tr/year"]) {
      mm = this.$store.getters["tr/month"];
      yyyy = this.$store.getters["tr/year"];
    } else {
      const today = new Date();
      const dd = today.getDate();
      mm = today.getMonth() + 1;
      yyyy = today.getFullYear();
      this.$store.commit("tr/SET_MONTH", mm);
      this.$store.commit("tr/SET_YEAR", yyyy);
    }
    this.selectYear = yyyy;
    this.month = mm;
    this.axios
      .get(
        "http://172.20.103.187:7576/api/techregime/graph1/" +
          yyyy +
          "/" +
          mm +
          "/"
      )
      .then((response) => {
        this.$store.commit("globalloading/SET_LOADING", false);
        // this.isLoading = false;
        let data = response.data;
        this.editdtm = mm;
        this.editdty = yyyy;
        if (data) {
          this.fullWells = data.data;
          this.chartWells = data.data;
        } else {
          console.log("No data");
        }
        if (mm < 10) {
          this.dt = "01" + ".0" + mm + "." + yyyy;
        } else {
          this.dt = "01" + "." + mm + "." + yyyy;
        }
      })
      .catch((e) => {
        this.$store.commit("globalloading/SET_LOADING", false);
        // this.isLoading = false;
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
  margin-bottom: 13px;
  margin-top: 13px;
  display: flex;
  justify-content: flex-start;
}
.trfacolbutnavlinkbut {
  margin-left: 28px;
}
.trfabtgraph {
  width: 195px;
  background: #5973cc !important;
}
.trfa_page.trfa_page {
  padding: 0 !important;
  width: calc(100vw - 65px);
  display: flex;
  margin-left: 44px;
}
.trfa_page .level1-content {
  margin: 0;
  width: 100%;
}
.trfa_page .main {
  padding: 0;
  margin: 0;
}
.second_block {
  height: calc(100vh - 280px);
  min-height: 587px;
  margin: 0 auto;
}
.droptr.droptr {
  background: #5973cc;
  padding: 0px;
}
a:hover {
  color: #ffffff;
}
.fadropmenu .fadropmenu {
  background: #656a8a;
  width: 246px;
}
.form-control {
  background: #272953 !important;
  border: 1px solid #656a8a !important;
  height: 35px !important;
  color: white !important;
}
</style>

<style >
.tr-chart {
  display: flex;
  width: 100%;
}
.tr-chart__content {
  flex-basis: 0;
  flex-grow: 1;
  flex-shrink: 0;
}
.tr-chart__loader {
  margin: 50px auto;
  width: 1px;
  height: 78px;
}
.namefilter {
  color: #fff;
  margin: 0 0 0 auto;
  display: flex;
  align-items: center;
  background: #454fa1;
  border: 1px solid #82baff;
  box-sizing: border-box;
  border-radius: 4px;
  padding: 3px 4px;
  cursor: pointer;
}
.filters.filters.filters {
  background: #333975;
  border: 1px solid #82baff;
  box-sizing: border-box;
  border-radius: 4px;
  display: flex;
  justify-content: center;
  align-items: center;
  width: calc(100% - 155px);
  position: absolute;
  min-height: 55px;
  top: 10px;
  padding: 0 10px 10px 0;
  z-index: 1000;
}
.filters__item {
  flex: auto;
  margin: 10px 0 0 10px;
}
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
  position: relative;
}
.tr-chart .dropdown {
  display: flex;
  height: 35px;
  margin-right: 20px;
  width: 195px;
}
</style>

