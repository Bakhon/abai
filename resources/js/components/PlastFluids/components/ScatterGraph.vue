<template>
  <div :class="isFullScreen ? 'fullscreen' : 'scatter-graph'">
    <div
      :class="isFullScreen ? 'fullscreen-graph' : 'graph-content-wrapper'"
      v-click-outside="exitFullScreen"
    >
      <div class="scatter-graph-header">
        <p>{{ title }}</p>
        <div class="scatter-graph-toolbar">
          <img
            @click.stop="isApproximationOpen = true"
            src="/img/PlastFluids/settings.svg"
            alt="customize graph"
          />
          <img
            src="/img/PlastFluids/download.svg"
            @click.stop="saveToPng"
            width="14"
            height="14"
          />
          <img
            @click.stop="isFullScreen = true"
            src="/img/PlastFluids/openModal.svg"
            width="14"
          />
        </div>
      </div>
      <div class="graph-holder">
        <ApexCharts
          ref="scatterGraph"
          :options="chartOptions"
          :series="graphSeries"
          :type="type"
          height="100%"
        ></ApexCharts>
      </div>
    </div>
    <ScatterGraphApproximation
      v-show="isApproximationOpen"
      :series="graphSeries[0].data"
      :seriesNames="seriesNames"
      :graphType="graphType"
      :minX="minXAxisBorder"
      :maxX="maxXAxisBorder"
      :minY="minYAxisBorder"
      :maxY="maxYAxisBorder"
      @close-approximation="closeApproximation"
      @get-approximation="getApproximation"
    />
    <BaseModal
      v-show="isRemoveModalOpen"
      @close-modal="isRemoveModalOpen = false"
      @modal-response="handleModalResponse"
      type="delete"
      :heading="heading"
    />
  </div>
</template>

<script>
import ScatterGraphApproximation from "./ScatterGraphApproximation.vue";
import BaseModal from "./BaseModal.vue";
import VueApexCharts from "vue-apexcharts";
import Export from "apexcharts/src/modules/Exports.js";
import _ from "lodash";
import { mapState, mapMutations } from "vuex";
import { convertToFormData, between } from "../helpers";
import { getCorrelationData } from "../services/graphService";

export default {
  name: "ScatterGraph",
  components: {
    ApexCharts: VueApexCharts,
    ScatterGraphApproximation,
    BaseModal,
  },
  props: {
    series: Object,
    title: String,
    graphType: String,
  },
  data() {
    return {
      type: "scatter",
      isFullScreen: false,
      isApproximationOpen: false,
      isRemoveModalOpen: false,
      currentAnnotationColorIndex: 0,
      prevPoint: null,
      currentSeries: null,
      graphSeries: [],
      approximation: [],
      minXAxisBorder: "",
      minYAxisBorder: "",
      maxXAxisBorder: "",
      maxYAxisBorder: "",
      chartOptions: {
        annotations: {
          points: [],
        },
        stroke: {
          show: true,
        },
        colors: [
          "#82BAFF",
          "#CF3630",
          "#F27E31",
          "#82BAFF",
          "#CF3630",
          "#F27E31",
        ],
        chart: {
          toolbar: {
            show: false,
          },
          foreColor: "#fff",
          background: "#1A214A",
          events: {},
        },
        markers: {
          size: [4, 0],
          discrete: [],
        },
        tooltip: {
          shared: false,
          intersect: true,
          theme: "dark",
        },
        legend: {
          show: true,
          showForSingleSeries: true,
          onItemClick: {
            toggleDataSeries: false,
          },
        },
        noData: {
          text: this.trans("plast_fluids.no_data"),
        },
        grid: {
          show: true,
          borderColor: "#3C4270",
          position: "back",
          xaxis: {
            lines: {
              show: true,
            },
          },
          yaxis: {
            lines: {
              show: true,
            },
          },
          row: {
            colors: ["#2B2E5E"],
          },
          column: {
            colors: ["#2B2E5E"],
          },
        },
        xaxis: {
          labels: {
            formatter: this.labelFormatterX,
          },
          seriesName: this.trans("plast_fluids.data"),
          type: "numeric",
          lines: {
            show: true,
          },
          min: 0,
          tickAmount: 6,
        },
        yaxis: {
          seriesName: this.trans("plast_fluids.data"),
          labels: {
            formatter: this.labelFormatterY,
          },
          lines: {
            show: true,
          },
          min: 0,
          tickAmount: 4,
        },
      },
    };
  },
  watch: {
    series: {
      handler(obj) {
        const filtered = obj.data.filter((item) => item.x && item.y);
        let axis = {};
        axis.minX = this.getMaxMinInObjectArray(filtered, "x")[0];
        axis.maxX = this.getMaxMinInObjectArray(filtered, "x")[1];
        axis.minY = this.getMaxMinInObjectArray(filtered, "y")[0];
        axis.maxY = this.getMaxMinInObjectArray(filtered, "y")[1];

        const calculate = (num, axisLine, type) => {
          let largeDiff, sum, max, min;
          max = axis["max" + axisLine];
          min = axis["min" + axisLine];
          largeDiff = max - min > max * 0.2;
          if (type === "min") {
            sum = largeDiff ? num - num * 0.2 : num - num * 0.05;
          } else {
            sum = largeDiff ? num + num * 0.2 : num + num * 0.05;
          }
          return Number(sum.toFixed(1));
        };

        const temp = {
          minX:
            obj.config.minX === "auto"
              ? calculate(axis.minX, "X", "min")
              : obj.config.minX,
          minY:
            obj.config.minY === "auto"
              ? calculate(axis.minY, "Y", "min")
              : obj.config.minY,
          maxX:
            obj.config.maxX === "auto"
              ? calculate(axis.maxX, "X", "max")
              : obj.config.maxX,
          maxY:
            obj.config.maxY === "auto"
              ? calculate(axis.maxY, "Y", "max")
              : obj.config.maxY,
        };

        this.minXAxisBorder = this.comparePositives(axis.maxX, axis.minX)
          ? temp.minX
          : temp.maxX;
        this.minYAxisBorder = this.comparePositives(axis.maxY, axis.minY)
          ? temp.minY
          : temp.maxY;
        this.maxXAxisBorder = this.comparePositives(axis.maxX, axis.minX)
          ? temp.maxX
          : temp.minX;
        this.maxYAxisBorder = this.comparePositives(axis.maxY, axis.minY)
          ? temp.maxY
          : temp.minY;

        this.chartOptions = {
          ...this.chartOptions,
          xaxis: {
            ...this.chartOptions.xaxis,
            min: this.minXAxisBorder,
            max: this.maxXAxisBorder,
          },
          yaxis: {
            min: this.minYAxisBorder,
            max: this.maxYAxisBorder,
            labels: {
              formatter: this.labelFormatterY,
            },
            lines: {
              show: true,
            },
            tickAmount: 4,
          },
        };
        this.graphSeries = [];
        this.graphSeries.push({
          name: obj.name,
          type: obj.type,
          data: filtered,
        });
        this.chartOptions = {
          ...this.chartOptions,
          chart: {
            ...this.chartOptions.chart,
            type: "scatter",
          },
        };
        this.type = "scatter";
      },
      immediate: true,
    },
    currentSelectedSamples: {
      handler(value) {
        const temp = _.cloneDeep(this.graphSeries);
        const selectedSamples = [];
        const unselectedSamples = temp[0].data.reduce((initial, item) => {
          if (value.includes(item.key)) {
            selectedSamples.push({
              ...item,
              fillColor: "#009000",
            });
            return initial;
          }
          const obj = { x: item.x, y: item.y, key: item.key };
          initial.push(obj);
          return initial;
        }, []);
        const samples = unselectedSamples.concat(selectedSamples);
        temp[0].data = samples;
        this.graphSeries = temp;
      },
      deep: true,
    },
  },
  computed: {
    ...mapState("plastFluids", [
      "currentSubsoilHorizon",
      "currentSubsoilField",
    ]),
    ...mapState("plastFluidsLocal", [
      "currentSelectedCorrelation_ps",
      "currentSelectedCorrelation_bs",
      "currentSelectedCorrelation_ms",
      "currentBlocks",
      "currentSelectedSamples",
    ]),
    heading() {
      return this.currentSeries
        ? `${this.trans("plast_fluids.sure_want_to_delete_optional")} "${
            this.graphSeries[this.currentSeries].name
          }" ?`
        : this.trans("plast_fluids.sure_want_to_delete");
    },
    seriesNames() {
      const names = this.graphSeries.map((series) => series.name);
      names.shift();
      return names;
    },
  },
  methods: {
    ...mapMutations("plastFluidsLocal", ["SET_CURRENT_SELECTED_SAMPLES"]),
    exitFullScreen() {
      this.isFullScreen = false;
    },
    closeApproximation() {
      this.isApproximationOpen = false;
    },
    comparePositives(max, min) {
      return Math.abs(max) > Math.abs(min);
    },
    labelFormatterY(value) {
      return value.toFixed(
        Math.abs(this.maxYAxisBorder) < 4 && Math.abs(this.minYAxisBorder) < 4
          ? 1
          : ""
      );
    },
    labelFormatterX(value) {
      return value.toFixed(
        Math.abs(this.maxXAxisBorder) < 4 && Math.abs(this.minXAxisBorder)
          ? 1
          : ""
      );
    },
    r2AndEquationHelper(value, acc) {
      return value === acc || value === acc + 3;
    },
    getMaxMinInObjectArray(obj, property) {
      let max = Number.NEGATIVE_INFINITY;
      let min = Number.POSITIVE_INFINITY;
      obj.forEach((dot) => {
        if (dot[property] > max) max = dot[property];
        if (dot[property] < min) min = dot[property];
      });
      return [min, max];
    },
    getApproximation(data) {
      if (data.approximation) {
        this.chartOptions.markers.size.push(0);
        this.type = "line";
        this.chartOptions = {
          ...this.chartOptions,
          chart: {
            ...this.chartOptions.chart,
            type: "line",
          },
          stroke: {
            ...this.chartOptions.stroke,
            curve: "smooth",
          },
        };
        this.graphSeries.push(data.approximation);
        this.currentAnnotationColorIndex++;
        if (data.approximation.r2 || data.approximation.function) {
          let r2 = data.approximation.r2
            ? "R2: " + data.approximation.r2.toFixed(2)
            : "";
          let equation = data.approximation.function
            ? "Функция: " + data.approximation.function
            : "";
          const temp = _.cloneDeep(this.chartOptions);
          !temp.colors[this.currentAnnotationColorIndex]
            ? (this.currentAnnotationColorIndex = 0)
            : "";
          const pushObject = {
            x: this.r2AndEquationHelper(this.currentAnnotationColorIndex, 1)
              ? this.minXAxisBorder
              : this.r2AndEquationHelper(this.currentAnnotationColorIndex, 2)
              ? this.maxXAxisBorder
              : this.maxXAxisBorder / 2,
            y: this.maxYAxisBorder,
            seriesIndex: data.approximation.name,
            marker: {
              size: 0,
            },
            label: {
              borderColor: temp.colors[this.currentAnnotationColorIndex],
              offsetY: 0,
              offsetX: this.r2AndEquationHelper(
                this.currentAnnotationColorIndex,
                1
              )
                ? 5
                : this.r2AndEquationHelper(this.currentAnnotationColorIndex, 2)
                ? -5
                : 0,
              style: {
                color: "#fff",
                background: temp.colors[this.currentAnnotationColorIndex],
                cssClass: "show",
              },
              textAnchor: this.r2AndEquationHelper(
                this.currentAnnotationColorIndex,
                1
              )
                ? "start"
                : this.r2AndEquationHelper(this.currentAnnotationColorIndex, 2)
                ? "end"
                : "middle",
              text: "",
            },
          };
          if (r2) {
            let r2Push = _.cloneDeep(pushObject);
            r2Push.label.text = r2;
            temp.annotations.points.push(r2Push);
          }
          if (equation) {
            let equationPush = _.cloneDeep(pushObject);
            equationPush.label.text = equation;
            r2 ? (equationPush.label.offsetY = 20) : "";
            temp.annotations.points.push(equationPush);
          }
          this.chartOptions = temp;
        }
      }
      if (data.graphOptions) {
        const minY =
          this.chartOptions.yaxis.min ?? this.chartOptions.yaxis[0].min;
        const maxY =
          this.chartOptions.yaxis.max ?? this.chartOptions.yaxis[0].max;
        this.chartOptions = {
          ...this.chartOptions,
          xaxis: {
            ...this.chartOptions.xaxis,
            min: data.graphOptions.abscissaFrom
              ? Number(data.graphOptions.abscissaFrom)
              : this.chartOptions.xaxis.min,
            max: data.graphOptions.abscissaTo
              ? Number(data.graphOptions.abscissaTo)
              : this.chartOptions.xaxis.max,
          },
          yaxis: {
            labels: {
              formatter: this.labelFormatterY,
            },
            lines: {
              show: true,
            },
            tickAmount: 4,
            min: data.graphOptions.ordinateFrom
              ? Number(data.graphOptions.ordinateFrom)
              : minY,
            max: data.graphOptions.ordinateTo
              ? Number(data.graphOptions.ordinateTo)
              : maxY,
          },
        };
      }
    },
    handleDataPointSelection(
      event,
      chartContext,
      { dataPointIndex, seriesIndex }
    ) {
      this.SET_CURRENT_SELECTED_SAMPLES(
        this.graphSeries[seriesIndex].data[dataPointIndex].key
      );
    },
    handleModalResponse() {
      this.removeSeries(this.currentSeries);
      this.currentSeries = null;
    },
    removeSeries(seriesIndex) {
      const temp = _.cloneDeep(this.chartOptions);
      let larger = false;
      temp.annotations.points = temp.annotations.points.reduce(
        (initial, point) => {
          if (point.seriesIndex === this.graphSeries[seriesIndex].name) {
            larger = true;
          }
          if (larger) {
            point.label.borderColor =
              this.chartOptions.colors[this.currentAnnotationColorIndex - 1];
            point.label.style.background =
              this.chartOptions.colors[this.currentAnnotationColorIndex - 1];
            point.x = this.r2AndEquationHelper(
              this.currentAnnotationColorIndex - 1,
              1
            )
              ? this.minXAxisBorder
              : this.r2AndEquationHelper(
                  this.currentAnnotationColorIndex - 1,
                  2
                )
              ? this.maxXAxisBorder
              : this.maxXAxisBorder / 2;
            point.label.offsetX = this.r2AndEquationHelper(
              this.currentAnnotationColorIndex - 1,
              1
            )
              ? 5
              : this.r2AndEquationHelper(
                  this.currentAnnotationColorIndex - 1,
                  2
                )
              ? -5
              : 0;
            point.label.textAnchor = this.r2AndEquationHelper(
              this.currentAnnotationColorIndex - 1,
              1
            )
              ? "start"
              : this.r2AndEquationHelper(
                  this.currentAnnotationColorIndex - 1,
                  2
                )
              ? "end"
              : "middle";
          }
          if (point.seriesIndex !== this.graphSeries[seriesIndex].name) {
            initial.push(point);
          }
          return initial;
        },
        []
      );
      this.graphSeries.splice(seriesIndex, 1);
      if (this.graphSeries.length === 1) {
        this.type = "scatter";
        temp.markers.size.pop();
        temp.chart.type = "scatter";
      }
      this.currentAnnotationColorIndex--;
      this.chartOptions = temp;
    },
    openRemoveModal(chartContext, seriesIndex, config, a) {
      if (seriesIndex !== 0) {
        this.currentSeries = seriesIndex;
        this.isRemoveModalOpen = true;
      }
    },
    saveToPng() {
      const exprt = new Export(this.$refs.scatterGraph.chart);
      exprt.exportToPng();
    },
    setEvents() {
      this.chartOptions.chart.events.dataPointSelection =
        this.handleDataPointSelection;
      this.chartOptions.chart.events.legendClick = this.openRemoveModal;
    },

    async handleCorrelationAdd() {
      const horizonIDs = this.currentSubsoilHorizon.length
        ? this.currentSubsoilHorizon.map((horizon) => horizon.horizon_id)
        : "None";

      const blockIDs = this.currentBlocks.length
        ? this.currentBlocks.map((block) => block.block_id)
        : "None";
      const postTemp = {
        field_id: this.currentSubsoilField[0].field_id,
        correlations_type: this.graphType.toLowerCase(),
        func_id:
          this["currentSelectedCorrelation_" + this.graphType.toLowerCase()]
            .func_id,
        horizons: horizonIDs,
        blocks: blockIDs,
      };
      const postData = convertToFormData(postTemp);
      const correlationData = await getCorrelationData(postData);
      const correlationSeries = {
        name: this["currentSelectedCorrelation_" + this.graphType.toLowerCase()]
          .name,
        type: "line",
        data: [],
      };
      this.chartOptions.markers.size.push(0);
      this.type = "line";
      this.chartOptions = {
        ...this.chartOptions,
        chart: {
          ...this.chartOptions.chart,
          type: "line",
        },
      };
      correlationSeries.data = correlationData[
        this.graphType.toLowerCase()
      ].chart.reduce((result, xy) => {
        const entry = Object.entries(xy)[0];
        if (
          between(Number(entry[0]), this.minXAxisBorder, this.maxXAxisBorder) &&
          between(Number(entry[1]), this.minYAxisBorder, this.maxYAxisBorder)
        ) {
          const objectToPush = { x: Number(entry[0]), y: Number(entry[1]) };
          result.push(objectToPush);
        }
        return result;
      }, []);
      this.currentAnnotationColorIndex++;
      this.graphSeries.push(correlationSeries);
    },
  },
  created() {
    this.setEvents();
    this.$watch(
      "currentSelectedCorrelation_" + this.graphType.toLowerCase(),
      () => this.handleCorrelationAdd()
    );
  },
  mounted() {
    this.chartOptions = {
      ...this.chartOptions,
      xaxis: {
        ...this.chartOptions.xaxis,
        max: this.maxXAxisBorder,
      },
    };
  },
};
</script>

<style scoped>
.scatter-graph {
  width: 100%;
  height: 100%;
  flex: 1;
  padding: 0;
  min-height: 0;
  overflow: auto;
}

.fullscreen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  z-index: 1000;
  display: flex;
  flex-flow: column;
  justify-content: center;
  align-items: center;
  background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7));
}

.fullscreen-graph {
  width: 80%;
  height: 80%;
  padding: 0;
  min-height: 0;
}

.graph-content-wrapper {
  width: 100%;
  height: 100%;
}

.graph-holder {
  width: 100%;
  height: calc(100% - 30px);
  display: block;
  overflow: hidden;
}

.graph-holder::v-deep .show {
  display: block;
}

.approx-button {
  width: auto;
}

.graph-modal-button {
  margin: 0 12px;
}

.scatter-graph-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #323370;
  height: 30px;
  width: 100%;
  padding: 0 10px;
}

.scatter-graph-header > p {
  margin: 0;
  font-size: 14px;
  color: #fff;
}

.scatter-graph-toolbar {
  display: flex;
  align-items: center;
}

.scatter-graph-toolbar > button {
  display: flex;
  align-items: center;
  height: 22px;
  color: #fff;
  background-color: #293688;
  border: 0.2px solid #3366ff;
  border-radius: 4px;
  padding: 3px 14px;
  margin-right: 12px;
}

.scatter-graph-toolbar > img {
  width: 16px;
  height: 16px;
  cursor: pointer;
  margin-right: 12px;
}

.scatter-graph-toolbar > img:last-of-type {
  margin-right: 0;
}
</style>
