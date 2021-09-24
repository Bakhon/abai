const DataAnalysisPressureAndTemperature = () =>
  import("./components/DataAnalysisPressureAndTemperature.vue");
const DataAnalysisApprovedParameters = () =>
  import("./components/DataAnalysisApprovedParameters.vue");
const DataAnalysisStudy = () => import("./components/DataAnalysisStudy.vue");
const DataAnalysisMapsAndTables = () =>
  import("./components/DataAnalysisMapsAndTables.vue");
const DataAnalysisPropertyMap = () =>
  import("./components/DataAnalysisPropertyMap.vue");
const DataAnalysisGraphsAndTablesSideMenu = () =>
  import("./components/DataAnalysisGraphsAndTables/LeftMenu.vue");
const DataAnalysisGraphsAndTables = () =>
  import("./components/DataAnalysisGraphsAndTables/GraphsAndTables.vue");
const DataAnalysisFluidComposition = () =>
  import("./components/DataAnalysisFluidComposition.vue");
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
            sidemenu = DataAnalysisGraphsAndTablesSideMenu;
            content = DataAnalysisStudy;
            break;
          case "maps-and-tables":
            sidemenu = DataAnalysisGraphsAndTablesSideMenu;
            content = DataAnalysisMapsAndTables;
            break;
          case "property-map":
            sidemenu = DataAnalysisGraphsAndTablesSideMenu;
            content = DataAnalysisPropertyMap;
            break;
          case "graphs-and-tables":
            sidemenu = DataAnalysisGraphsAndTablesSideMenu;
            content = DataAnalysisGraphsAndTables;
            break;
          case "fluid-composition":
            sidemenu = DataAnalysisGraphsAndTablesSideMenu;
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
