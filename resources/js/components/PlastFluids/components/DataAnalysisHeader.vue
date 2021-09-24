<template>
  <div class="data-analysis-header">
    <MultiLevelDropdown
      v-for="heading in headerMenu"
      :class="{ activeLink: heading.activeKey === headingKey }"
      :key="heading.name"
      :item="heading"
      :hover="hover"
    />
  </div>
</template>

<script>
import MultiLevelDropdown from "./MultiLevelDropdown.vue";

export default {
  name: "DataAnalysisHeader",
  components: {
    MultiLevelDropdown,
  },
  inject: ["headingKey"],
  data() {
    return {
      hover: "#2E50E9",
      headerMenu: [
        {
          name: "Давление и температура",
          showArrow: false,
          url: "pf-data-analysis/pressure-and-temperature",
          activeKey: "pressure-and-temperature",
        },
        {
          name: "Анализ проб пластовой нефти",
          showArrow: true,
          activeKey: "reservoir-oil-samples-analysis",
          position: "bottom",
          children: [
            {
              name: "Нефть",
              imagePath: "/img/PlastFluids/Oil.svg",
              showArrow: false,
              position: "right",
              children: [
                {
                  name: "Изученность",
                  imagePath: "/img/PlastFluids/study.svg",
                  justify: "flex-start",
                  url:
                    "pf-data-analysis/reservoir-oil-samples-analysis/oil/study",
                },
                {
                  name: "Карты и таблицы",
                  imagePath: "/img/PlastFluids/mapsAndTables.svg",
                  justify: "flex-start",
                  url:
                    "pf-data-analysis/reservoir-oil-samples-analysis/oil/maps-and-tables",
                },
                {
                  name: "Карта свойств",
                  imagePath: "/img/PlastFluids/propertyMap.svg",
                  justify: "flex-start",
                  url:
                    "pf-data-analysis/reservoir-oil-samples-analysis/oil/property-map",
                },
                {
                  name: "Графики и таблицы",
                  imagePath: "/img/PlastFluids/graphsAndTables.svg",
                  justify: "flex-start",
                  url:
                    "pf-data-analysis/reservoir-oil-samples-analysis/oil/graphs-and-tables",
                },
                {
                  name: "Состав жидкости",
                  imagePath: "/img/PlastFluids/fluidComposition.svg",
                  justify: "flex-start",
                  url:
                    "pf-data-analysis/reservoir-oil-samples-analysis/oil/fluid-composition",
                },
                {
                  name: "Газоконденсатные исследования",
                  imagePath: "/img/PlastFluids/gasCondensateStudies.svg",
                  justify: "flex-start",
                  url:
                    "pf-data-analysis/reservoir-oil-samples-analysis/oil/gas-condensate-studies",
                },
              ],
            },
            {
              name: "Газоконденсат",
              imagePath: "/img/PlastFluids/GasCondensate.svg",
              showArrow: false,
              position: "right",
              children: [
                {
                  name: "Изученность",
                  imagePath: "/img/PlastFluids/study.svg",
                  justify: "flex-start",
                  url:
                    "pf-data-analysis/reservoir-oil-samples-analysis/gascondensate/study",
                },
                {
                  name: "Карты и таблицы",
                  imagePath: "/img/PlastFluids/mapsAndTables.svg",
                  justify: "flex-start",
                  url:
                    "pf-data-analysis/reservoir-oil-samples-analysis/gascondensate/maps-and-tables",
                },
                {
                  name: "Состав жидкости",
                  imagePath: "/img/PlastFluids/fluidComposition.svg",
                  justify: "flex-start",
                  url:
                    "pf-data-analysis/reservoir-oil-samples-analysis/gascondensate/fluid-composition",
                },
                {
                  name: "Газоконденсатные исследования",
                  imagePath: "/img/PlastFluids/gasCondensateStudies.svg",
                  justify: "flex-start",
                  url:
                    "pf-data-analysis/reservoir-oil-samples-analysis/gascondensate/gas-condensate-studies",
                },
              ],
            },
          ],
        },
        {
          name: "Утвержденные параметры",
          showArrow: false,
          activeKey: "approved-parameters",
          url: "pf-data-analysis/approved-parameters",
        },
      ],
    };
  },
};
</script>

<style scoped>
.data-analysis-header {
  display: grid;
  column-gap: 10px;
  grid-template-columns: repeat(3, 1fr);
  margin: 0 0 10px 0;
}

.activeLink {
  background: #2e50e9;
  font-weight: 700;
}
</style>
