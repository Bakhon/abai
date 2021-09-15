<template>
  <div class="scatter-graph">
    <div class="scatter-graph-header">
      <p>Давление насыщения от газосодержания пластовой нефти КТ-II</p>
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
      @close-approximation="isApproximationOpen = false"
    />
  </div>
</template>

<script>
import ScatterGraphApproximation from "./ScatterGraphApproximation.vue";
import VueApexCharts from "vue-apexcharts";
import Export from "apexcharts/src/modules/Exports.js";

export default {
  name: "ScatterGraph",
  props: {
    series: Object,
    type: String,
    approximation: Object,
  },
  components: {
    ApexCharts: VueApexCharts,
    ScatterGraphApproximation,
  },
  data() {
    return {
      isApproximationOpen: false,
      chartOptions: {
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
          max: 600,
          tickAmount: 6,
        },
        yaxis: {
          labels: {
            formatter: (value) => value.toFixed(),
          },
          lines: {
            show: true,
          },
        },
      },
    };
  },
  computed: {
    graphSeries() {
      const seriesData = [this.series];
      if (this.approximation) {
        seriesData.push(this.approximation);
      }
      return seriesData;
    },
  },
  methods: {
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
