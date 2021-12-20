<template>
  <div class="data-analysis-fluid-composition">
    <div class="fluid-composition-graph-holder">
      <div class="heading-title-wrapper">
        <div class="heading-title">
          <img src="/img/PlastFluids/graphs.svg" alt="graph" />
          <p>{{ trans("plast_fluids.graph") }}</p>
        </div>
      </div>
      <div class="content">
        <LineGraph
          :title="trans('plast_fluids.hydrocarbon_fraction')"
          :series="series"
        />
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
          { x: 2, y: 2 },
          { x: 25, y: 8 },
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
</style>
