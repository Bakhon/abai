<template>
  <div class="scatter-graph">
    <div class="scatter-graph-header">
      <p>{{ title }}</p>
      <div class="scatter-graph-toolbar">
        <button @click.stop="isApproximationOpen = true">
          {{ trans("plast_fluids.approximation") }}
        </button>
        <img
          src="/img/PlastFluids/download.svg"
          @click="saveToPng"
          width="14"
          height="14"
        />
        <img src="/img/PlastFluids/openModal.svg" width="14" />
      </div>
    </div>
    <ApexCharts
      ref="scatterGraph"
      :options="chartOptions"
      :series="graphSeries"
      :type="type"
      height="100%"
    ></ApexCharts>
    <ScatterGraphApproximation
      v-show="isApproximationOpen"
      :series="graphSeries[0].data"
      :graphType="graphType"
      @close-approximation="isApproximationOpen = false"
      @get-approximation="getApproximation"
    />
  </div>
</template>

<script>
import ScatterGraphApproximation from "./ScatterGraphApproximation.vue";
import VueApexCharts from "vue-apexcharts";
import Export from "apexcharts/src/modules/Exports.js";

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
      graphSeries: [],
      approximation: [],
      minXAxisBorder: "",
      minYAxisBorder: "",
      maxXAxisBorder: "",
      maxYAxisBorder: "",
      chartOptions: {
        stroke: {
          show: true,
        },
        dataLabels: {
          enabled: false,
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
          text: "Нет данных",
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
          type: "numeric",
          lines: {
            show: true,
          },
          min: 0,
          tickAmount: 6,
        },
        yaxis: {
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
        const minX = this.getMaxMinInObjectArray(filtered, "x")[0];
        const maxX = this.getMaxMinInObjectArray(filtered, "x")[1];
        const minY = this.getMaxMinInObjectArray(filtered, "y")[0];
        const maxY = this.getMaxMinInObjectArray(filtered, "y")[1];

        const isPositiveX = this.comparePositives(maxX, minX);
        const isPositiveY = this.comparePositives(maxY, minY);

        const calculate = (isPositive, num1, num2, axis, type) => {
          let largeDiff, sum, max, min;
          if (axis === "x") {
            max = maxX;
            min = minX;
          }
          if (axis === "y") {
            max = maxY;
            min = minY;
          }
          largeDiff = max - min > max * 0.2;

          if (isPositive) {
            type === "min"
              ? (sum = largeDiff ? num2 - num2 * 0.2 : num2 - 10)
              : (sum = largeDiff ? num2 + num2 * 0.2 : num2 + 10);
          } else {
            type === "min"
              ? (sum = largeDiff ? num1 + num1 * 0.2 : num1 + 10)
              : (sum = largeDiff ? num1 - num1 * 0.2 : num1 - 10);
          }
          return sum;
        };

        this.minXAxisBorder =
          obj.config.minX === "auto"
            ? calculate(isPositiveX, maxX, minX, "x", "min")
            : obj.config.minX;
        this.minYAxisBorder =
          obj.config.minY === "auto"
            ? calculate(isPositiveY, maxY, minY, "y", "min")
            : obj.config.minY;
        this.maxXAxisBorder =
          obj.config.maxX === "auto"
            ? calculate(isPositiveX, minX, maxX, "x", "max")
            : obj.config.maxX;
        this.maxYAxisBorder =
          obj.config.maxY === "auto"
            ? calculate(isPositiveY, minY, maxY, "y", "max")
            : obj.config.maxY;

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
      return value.toFixed(Math.abs(this.maxYAxisBorder) < 4 ? 1 : "");
    },
    labelFormatterX(value) {
      return value.toFixed(Math.abs(this.maxXAxisBorder) < 4 ? 1 : "");
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
      }
      if (data.graphOptions) {
        const minY =
          this.chartOptions.yaxis.min ?? this.chartOptions.yaxis[0].min;
        const maxY =
          this.chartOptions.yaxis.max ?? this.chartOptions.yaxis[0].max;
        this.chartOptions = {
          ...this.chartOptions,
          yaxis: {
            min: data.graphOptions.ordinateFrom
              ? Number(data.graphOptions.ordinateFrom)
              : minY,
            max: data.graphOptions.ordinateTo
              ? Number(data.graphOptions.ordinateTo)
              : maxY,
            labels: {
              formatter: this.labelFormatterY,
            },
            lines: {
              show: true,
            },
            tickAmount: 4,
          },
          xaxis: {
            ...this.chartOptions.xaxis,
            min: data.graphOptions.abscissaFrom
              ? Number(data.graphOptions.abscissaFrom)
              : this.chartOptions.xaxis.min,
            max: data.graphOptions.abscissaTo
              ? Number(data.graphOptions.abscissaTo)
              : this.chartOptions.xaxis.max,
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
    saveToPng() {
      const exprt = new Export(this.$refs.scatterGraph.chart);
      exprt.exportToPng();
    },
    setEvents() {
      this.chartOptions.chart.events.markerClick = this.handleMarkerClick;
    },
  },
  created() {
    this.setEvents();
  },
};
</script>

<style scoped>
.scatter-graph {
  height: calc(100% - 30px);
  width: 100%;
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
}

.scatter-graph-toolbar > img:nth-of-type(1) {
  margin-right: 12px;
}
</style>
