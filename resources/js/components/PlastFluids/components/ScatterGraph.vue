<template>
  <div class="scatter-graph">
    <div class="scatter-graph-header">
      <p>{{ title }}</p>
      <div class="scatter-graph-toolbar">
        <button @click.stop="isApproximationOpen = true">Аппроксимация</button>
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
      :series="series.data"
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
      maxX: "",
      maxY: "",
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
          size: [4, 0, 0],
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
          text: "Загрузка...",
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
          type: "numeric",
          lines: {
            show: true,
          },
          min: 0,
          tickAmount: 6,
        },
        yaxis: {
          labels: {
            formatter: (value) => value.toFixed(),
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
        this.maxX = this.getMaxInObjectArray(obj.data, "x");
        this.maxY = this.getMaxInObjectArray(obj.data, "y");
        Vue.set(this.chartOptions.xaxis, "max", this.maxX + 50);
        Vue.set(this.chartOptions.yaxis, "max", this.maxY + 5);
        this.graphSeries = [];
        this.graphSeries.push(obj);
      },
      immediate: true,
    },
  },
  methods: {
    getMaxInObjectArray(obj, property) {
      let max = 0;
      obj.forEach((dot) => {
        if (dot[property] > max) max = dot[property];
      });
      return max;
    },
    getApproximation(data) {
      if (data.approximation) {
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
              ? parseInt(data.graphOptions.ordinateFrom)
              : minY,
            max: data.graphOptions.ordinateTo
              ? parseInt(data.graphOptions.ordinateTo)
              : maxY,
            labels: {
              formatter: (value) => value.toFixed(),
            },
            lines: {
              show: true,
            },
            tickAmount: 4,
          },
          xaxis: {
            ...this.chartOptions.xaxis,
            min: data.graphOptions.abscissaFrom
              ? parseInt(data.graphOptions.abscissaFrom)
              : this.chartOptions.xaxis.min,
            max: data.graphOptions.abscissaTo
              ? parseInt(data.graphOptions.abscissaTo)
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
      console.log(max);
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
