<template>
  <div class="scatter-graph">
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
          @click="saveToPng"
          width="14"
          height="14"
        />
        <img src="/img/PlastFluids/openModal.svg" width="14" />
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
    <ScatterGraphApproximation
      v-show="isApproximationOpen"
      :series="graphSeries[0].data"
      :graphType="graphType"
      :minX="minXAxisBorder"
      :maxX="maxXAxisBorder"
      :minY="minYAxisBorder"
      :maxY="maxYAxisBorder"
      @close-approximation="isApproximationOpen = false"
      @get-approximation="getApproximation"
    />
  </div>
</template>

<script>
import ScatterGraphApproximation from "./ScatterGraphApproximation.vue";
import VueApexCharts from "vue-apexcharts";
import Export from "apexcharts/src/modules/Exports.js";
import _ from "lodash";

export default {
  name: "ScatterGraph",
  components: {
    ApexCharts: VueApexCharts,
    ScatterGraphApproximation,
  },
  props: {
    series: Object,
    title: String,
    graphType: String,
  },
  data() {
    return {
      type: "scatter",
      isApproximationOpen: false,
      currentAnnotationColorIndex: 1,
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
        colors: ["#82BAFF", "#CF3630", "#F27E31"],
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
        },
        tooltip: {
          shared: false,
          intersect: true,
          theme: "dark",
        },
        legend: {
          show: true,
          showForSingleSeries: true,
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
      },
      immediate: true,
    },
  },
  methods: {
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
        this.chartOptions.stroke.curve = "smooth";
        this.graphSeries.push(data.approximation);
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
            x:
              this.currentAnnotationColorIndex === 1
                ? this.minXAxisBorder
                : this.currentAnnotationColorIndex === 2
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
              offsetX:
                this.currentAnnotationColorIndex === 1
                  ? 5
                  : this.currentAnnotationColorIndex === 2
                  ? -5
                  : 0,
              style: {
                color: "#fff",
                background: temp.colors[this.currentAnnotationColorIndex],
                cssClass: "show",
              },
              textAnchor:
                this.currentAnnotationColorIndex === 1
                  ? "start"
                  : this.currentAnnotationColorIndex === 2
                  ? "end"
                  : "middle",
              text: '',
            },
          };
          if(r2) {
            let r2Push = _.cloneDeep(pushObject);
            r2Push.label.text = r2;
            temp.annotations.points.push(r2Push);
          }
          if(equation) {
            let equationPush = _.cloneDeep(pushObject);
            equationPush.label.text = equation;
            r2 ? equationPush.label.offsetY = 20 : '';
            temp.annotations.points.push(equationPush);
          }
          this.chartOptions = temp;
          this.currentAnnotationColorIndex++;
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
    handleMarkerClick(
      event,
      chartContext,
      { seriesIndex, dataPointIndex, config }
    ) {
      console.log(event, chartContext, { seriesIndex, dataPointIndex, config });
    },
    toggleApproximationR2AndEquation(chartContext, seriesIndex, config) {
      const temp = _.cloneDeep(this.chartOptions);
      temp.annotations.points.forEach((point) => {
        if (point.seriesIndex === this.graphSeries[seriesIndex].name) {
          point.label.style.cssClass =
            point.label.style.cssClass === "hide" ? "show" : "hide";
          point.marker.radius = {};
        }
      });
      this.chartOptions = temp;
    },
    saveToPng() {
      const exprt = new Export(this.$refs.scatterGraph.chart);
      exprt.exportToPng();
    },
    setEvents() {
      this.chartOptions.chart.events.markerClick = this.handleMarkerClick;
      this.chartOptions.chart.events.legendClick = this.toggleApproximationR2AndEquation;
    },
  },
  created() {
    this.setEvents();
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

.graph-holder {
  width: 100%;
  height: calc(100% - 30px);
  display: block;
  overflow: hidden;
}

.graph-holder::v-deep .show {
  display: block;
}

.graph-holder::v-deep .hide {
  display: none;
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
