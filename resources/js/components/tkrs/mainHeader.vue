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
import MultiLevelDropdown from '../PlastFluids/components/MultiLevelDropdown.vue';

export default {
  name: "mainHeader",
  components: {
    MultiLevelDropdown,
  },
  inject: ["headingKey"],
  data() {
    return {
      hover: "#2E50E9",
      headerMenu: [
        {
          name: this.trans('tkrs.monitoring'),
          imagePath: "/img/tkrs/eyes.svg",
          showArrow: true,
          activeKey: "reservoir-oil-samples-analysis",
          position: "bottom",
          children: [
            {
              name: this.trans('tkrs.brigades'),
              imagePath: "/img/tkrs/brigada_header.svg",
              showArrow: false,
              position: "right",
            },
          ],
        },
        
        {
          name: this.trans('tkrs.analytics'),
          imagePath: "/img/tkrs/analytic_header_icon.svg",
          showArrow: true,
          activeKey: "reservoir-oil-samples-analysis",
          position: "bottom",
          children: [
            {
              name: this.trans('tkrs.analysis_pv_npv'),
              imagePath: "/img/tkrs/search_header.svg",
              showArrow: false,
              position: "right",
            },
          ],
        },
        {
          name: "Документация",
          imagePath: "/img/tkrs/document_header.svg",
          showArrow: true,
          activeKey: "reservoir-oil-samples-analysis",
          position: "bottom",
          children: [
            {
              name: "Нефть",
              imagePath: "/img/PlastFluids/oil.svg",
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
              name: "Документация",
              imagePath: "/img/tkrs/document_header.svg",
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
          name: "Библиотека",
          imagePath: "/img/tkrs/library_header.svg",
          showArrow: true,
          activeKey: "reservoir-oil-samples-analysis",
          position: "bottom",
          children: [
            {
              name: "Нефть",
              imagePath: "/img/PlastFluids/oil.svg",
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
              imagePath: "/img/PlastFluids/gasCondensate.svg",
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
        
      ],
    };
  },
};
</script>

<style scoped>
.data-analysis-header {
  display: grid;
  column-gap: 10px;
  grid-template-columns: repeat(4, 1fr);
  margin: 0 0 5px 0;
}

.activeLink {
  background: #2e50e9;
  font-weight: 700;
}
</style>
