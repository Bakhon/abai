const DataAnalysisPressureAndTemperature = () =>
  import("./components/DataAnalysisPressureAndTemperature.vue");
const DataAnalysisApprovedParameters = () =>
  import("./components/DataAnalysisApprovedParameters.vue");
const DataAnalysisStudySideMenu = () => import("./components/DataAnalysisStudy/LeftMenu.vue");
const DataAnalysisStudy = () => import("./components/DataAnalysisStudy/DataAnalysisStudy.vue");
const DataAnalysisMapsAndTablesSideMenu = () =>
  import("./components/DataAnalysisMapsAndTables/LeftMenu.vue");
const DataAnalysisMapsAndTables = () =>
  import("./components/DataAnalysisMapsAndTables/DataAnalysisMapsAndTables.vue");
const DataAnalysisPropertyMap = () =>
  import("./components/DataAnalysisPropertyMap/DataAnalysisPropertyMap.vue");
const DataAnalysisGraphsAndTablesSideMenu = () =>
  import("./components/DataAnalysisGraphsAndTables/LeftMenu.vue");
const DataAnalysisGraphsAndTables = () =>
  import("./components/DataAnalysisGraphsAndTables/GraphsAndTables.vue");
  const DataAnalysisFluidCompositionSideMenu = () =>
  import("./components/DataAnalysisFluidComposition/LeftMenu.vue");
const DataAnalysisFluidComposition = () =>
  import("./components/DataAnalysisFluidComposition/DataAnalysisFluidComposition.vue");
const DataAnalysisGasCondensateStudies = () =>
  import("./components/DataAnalysisGasCondensateStudies.vue");

const setDynamicComponentContent = {
  inject: ["headingKey", "reservoilOilInfo"],
  computed: {
    currentComponent() {
      let sidemenu, content;
      if (this.headingKey === "pressure-and-temperature") {
        sidemenu = DataAnalysisGraphsAndTablesSideMenu;
        content = DataAnalysisPressureAndTemperature;
        return [sidemenu, content];
      }
      if (this.headingKey === "reservoir-oil-samples-analysis") {
        switch (this.reservoilOilInfo[1]) {
          case "study":
            sidemenu = DataAnalysisStudySideMenu;
            content = DataAnalysisStudy;
            break;
          case "maps-and-tables":
            sidemenu = DataAnalysisMapsAndTablesSideMenu;
            content = DataAnalysisMapsAndTables;
            break;
          case "property-map":
            sidemenu = DataAnalysisMapsAndTablesSideMenu;
            content = DataAnalysisPropertyMap;
            break;
          case "graphs-and-tables":
            sidemenu = DataAnalysisGraphsAndTablesSideMenu;
            content = DataAnalysisGraphsAndTables;
            break;
          case "fluid-composition":
            sidemenu = DataAnalysisFluidCompositionSideMenu;
            content = DataAnalysisFluidComposition;
            break;
          case "gas-condensate-studies":
            sidemenu = DataAnalysisGraphsAndTablesSideMenu;
            content = DataAnalysisGasCondensateStudies;
            break;
        }
      }
      if (this.headingKey === "approved-parameters") {
        sidemenu = DataAnalysisGraphsAndTablesSideMenu;
        content = DataAnalysisApprovedParameters;
        return [sidemenu, content];
      }
      return [sidemenu, content];
    },
  },
};

const handleTableChange = {
  data() {
    return {
      tableState: "common",
    };
  },
  methods: {
    setTableState(value) {
      this.tableState = value;
    },
  },
};

export { setDynamicComponentContent, handleTableChange };
