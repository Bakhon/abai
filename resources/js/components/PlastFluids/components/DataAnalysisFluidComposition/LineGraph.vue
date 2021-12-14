<template>
  <div :class="isFullScreen ? 'fullscreen' : 'line-graph'">
    <div
      :class="isFullScreen ? 'fullscreen-graph' : 'graph-content-wrapper'"
      v-click-outside="exitFullScreen"
    >
      <div class="line-graph-header">
        <p>{{ title }}</p>
        <div class="line-graph-toolbar">
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
          ref="lineGraph"
          :options="chartOptions"
          :series="graphSeries"
          :type="type"
          :height="height"
        ></ApexCharts>
      </div>
    </div>
  </div>
</template>

<script>
import VueApexCharts from "vue-apexcharts";
import Export from "apexcharts/src/modules/Exports.js";

export default {
  name: "LineGraph",
  components: {
    ApexCharts: VueApexCharts,
  },
  props: {
    series: Object,
    title: String,
  },
  data() {
    return {
      maxX: 10,
      type: "line",
      height: "300px",
      isFullScreen: false,
      graphSeries: [],
      chartOptions: {
        chart: {
          toolbar: {
            show: false,
          },
          foreColor: "#fff",
          background: "#1A214A",
          events: {},
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
          max: 30,
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
          max: 10,
          tickAmount: 4,
        },
      },
    };
  },
  watch: {
    series: {
      handler(value) {
        this.maxX = this.getMaxMinInObjectArray(value.data, "x")[1];
        this.graphSeries.push({
          name: value.name,
          type: value.type,
          data: value.data,
        });
      },
      immediate: true,
    },
  },
  methods: {
    exitFullScreen() {
      this.isFullScreen = false;
    },
    saveToPng() {
      const exprt = new Export(this.$refs.lineGraph.chart);
      exprt.exportToPng();
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
    labelFormatterX(value) {
      return value.toFixed(
        Math.abs(this.maxXAxisBorder) < 4 && Math.abs(this.minXAxisBorder)
          ? 1
          : ""
      );
    },
    labelFormatterY(value) {
      return value.toFixed(
        Math.abs(this.maxYAxisBorder) < 4 && Math.abs(this.minYAxisBorder) < 4
          ? 1
          : ""
      );
    },
  },
  mounted() {
    this.$nextTick(() => (this.height = "100%"));
  },
};
</script>

<style scoped>
.line-graph {
  width: 100%;
  height: 100%;
  padding: 0;
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
}

.line-graph-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #323370;
  height: 30px;
  width: 100%;
  padding: 0 10px;
}

.line-graph-header > p {
  margin: 0;
  font-size: 14px;
  color: #fff;
}

.line-graph-toolbar {
  display: flex;
  align-items: center;
}

.line-graph-toolbar > button {
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

.line-graph-toolbar > img {
  width: 16px;
  height: 16px;
  cursor: pointer;
  margin-right: 12px;
}

.line-graph-toolbar > img:last-of-type {
  margin-right: 0;
}
</style>
