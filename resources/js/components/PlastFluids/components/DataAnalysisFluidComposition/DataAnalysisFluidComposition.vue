<template>
  <div class="data-analysis-fluid-composition">
    <div class="fluid-composition-graph-holder">
      <div class="heading-title-wrapper">
        <div class="heading-title">
          <img src="/img/PlastFluids/graphs.svg" alt="graph" />
          <p>График</p>
        </div>
      </div>
      <div class="content">
        <div class="graph-holder">
          <LineGraph title="Углеводородная фракция" :series="series" />
        </div>
      </div>
    </div>
    <DataAnalysisDataTable
      tableTitle="oil_composition_quality"
      imagePath="/img/PlastFluids/sampleDataIcon.png"
      :fields="fields"
      :items="items"
    />
  </div>
</template>

<script>
import LineGraph from "./LineGraph.vue";
import DataAnalysisDataTable from "../DataAnalysisDataTable.vue";

export default {
  name: "DataAnalysisFluidComposition",
  components: {
    LineGraph,
    DataAnalysisDataTable,
  },
  data() {
    return {
      cartFull: false,
      items: [],
      fields: [
        "Скважина",
        "Дата отбора",
        "H2S",
        "CO2",
        "N2",
        "C1",
        "C2",
        "C3",
        "IC4",
        "NC4",
        "IC6",
        "NC5",
      ],
      series: {
        name: "Тест",
        type: "line",
        data: [
          { x: 16.4, y: 5.4 },
          { x: 21.7, y: 2 },
          { x: 25.4, y: 3 },
          { x: 19, y: 2 },
          { x: 10.9, y: 1 },
          { x: 13.6, y: 3.2 },
          { x: 10.9, y: 7.4 },
          { x: 10.9, y: 0 },
          { x: 10.9, y: 8.2 },
          { x: 16.4, y: 0 },
          { x: 16.4, y: 1.8 },
          { x: 13.6, y: 0.3 },
          { x: 13.6, y: 0 },
          { x: 29.9, y: 0 },
          { x: 27.1, y: 2.3 },
          { x: 16.4, y: 0 },
          { x: 13.6, y: 3.7 },
          { x: 10.9, y: 5.2 },
          { x: 16.4, y: 6.5 },
          { x: 10.9, y: 0 },
          { x: 24.5, y: 7.1 },
          { x: 10.9, y: 0 },
          { x: 8.1, y: 4.7 },
          { x: 19, y: 0 },
          { x: 21.7, y: 1.8 },
          { x: 27.1, y: 0 },
          { x: 24.5, y: 0 },
          { x: 27.1, y: 0 },
          { x: 29.9, y: 1.5 },
          { x: 27.1, y: 0.8 },
          { x: 22.1, y: 2 },
        ],
      },
    };
  },
  methods: {
    pushData() {
      for (let i = 0; i < 40; i++) {
        this.items.push([
          "П-2",
          2.32,
          2.32,
          2.32,
          2.32,
          2.32,
          2.32,
          2.32,
          2.32,
          2.32,
          2.32,
          2.32,
        ]);
      }
    },
  },
  mounted() {
    this.pushData();
  },
};
</script>

<style scoped>
.data-analysis-fluid-composition {
  display: flex;
  flex-flow: column;
  width: 100%;
  height: 100%;
}

.fluid-composition-graph-holder {
  display: flex;
  flex-flow: column;
  flex: 2 1 auto;
  min-height: 0;
}

.heading-title-wrapper {
  height: 38px;
  padding: 6px 6px 0 6px;
  background: #272953;
  display: flex;
  align-items: center;
}

.heading-title {
  display: flex;
  position: relative;
  align-items: center;
  justify-content: flex-start;
  width: 100%;
  height: 32px;
  border: 1px solid #545580;
  background: #323370;
  padding: 0 11px;
}

.heading-title > img {
  margin-right: 9px;
  width: 18px;
  height: 18px;
}

.heading-title > p {
  margin: 0;
  color: #fff;
  font-size: 16px;
}

.content {
  display: flex;
  width: 100%;
  height: calc(100% - 38px);
  border: 6px solid #272953;
  padding: 4px;
  overflow: hidden;
}

.graph-holder {
  flex: 1 1 auto;
  overflow: auto;
  padding: 0;
}
</style>
