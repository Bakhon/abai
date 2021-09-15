<template>
  <div class="data-analysis-content">
    <component :is="currentComponent"></component>
  </div>
</template>

<script>
const DataAnalysisPressureAndTemperature = () =>
  import("./DataAnalysisPressureAndTemperature.vue");
const DataAnalysisApprovedParameters = () =>
  import("./DataAnalysisApprovedParameters.vue");
const DataAnalysisStudy = () => import("./DataAnalysisStudy.vue");
const DataAnalysisMapsAndTables = () =>
  import("./DataAnalysisMapsAndTables.vue");
const DataAnalysisPropertyMap = () => import("./DataAnalysisPropertyMap.vue");
const DataAnalysisGraphsAndTables = () =>
  import("./DataAnalysisGraphsAndTables.vue");
const DataAnalysisFluidComposition = () =>
  import("./DataAnalysisFluidComposition.vue");
const DataAnalysisGasCondensateStudies = () =>
  import("./DataAnalysisGasCondensateStudies.vue");

export default {
  name: "DataAnalysisContent",
  inject: ["headingKey", "reservoilOilInfo"],

  computed: {
    currentComponent() {
      let comp;
      if (this.headingKey === "pressure-and-temperature") {
        comp = DataAnalysisPressureAndTemperature;
        return comp;
      }
      if (this.headingKey === "reservoir-oil-samples-analysis") {
        switch (this.reservoilOilInfo[1]) {
          case "study":
            comp = DataAnalysisStudy;
            break;
          case "maps-and-tables":
            comp = DataAnalysisMapsAndTables;
            break;
          case "property-map":
            comp = DataAnalysisPropertyMap;
            break;
          case "graphs-and-tables":
            comp = DataAnalysisGraphsAndTables;
            break;
          case "fluid-composition":
            comp = DataAnalysisFluidComposition;
            break;
          case "gas-condensate-studies":
            comp = DataAnalysisGasCondensateStudies;
            break;
        }
      }
      if (this.headingKey === "approved-parameters") {
        comp = DataAnalysisApprovedParameters;
        return comp;
      }
      return comp;
    },
  },
};
</script>

<style>
.data-analysis-content {
  width: 100%;
  height: calc(100% - 46px);
}
</style>
