<template>
  <div>
    <Header />
    <div class="data-analysis">
      <component v-bind:is="mainPage.leftPanel"></component>
      <div class="data-analysis__content">
        <data-analysis-tab @changePage="changePage" />
        <component v-bind:is="mainPage.component"></component>
      </div>
    </div>
  </div>
</template>

<script>
import Header from "../components/Header.vue";
import DataAnalysisTab from "../components/DataAnalysisTab.vue";
import DataAnalysisStudy from "../components/DataAnalysisStudy.vue";

export default {
  name: "PfDataAnalysis",

  components: {
    DataAnalysisTab,
    Header,
    DataAnalysisStudy,
  },

  data() {
    return {
      cartFull: false,
      mainPage: {
        name: "Изученность",
        img: "Oil.svg",
        component: {
          name: "main-table",
          template: "<data-analysis-study></data-analysis-study>",
        },
        leftPanel: {
          name: "main-table",
          template: "<data-analysis-study-panel></data-analysis-study-panel>",
        },
      },
    };
  },
  methods: {
    changePage(component) {
      this.mainPage = component;
    },
  },
};
Vue.component(
  "data-analysis-property-map",
  require("../components/DataAnalysisPropertyMap").default
);
Vue.component(
  "data-analysis-study",
  require("../components/DataAnalysisStudy").default
);
Vue.component(
  "data-analysis-study-panel",
  require("../components/DataAnalysisStudyPanel").default
);
Vue.component(
  "data-analysis-panel",
  require("../components/DataAnalysisPanel").default
);
Vue.component(
  "data-analysis-map-table-panel",
  require("../components/DataAnalysisMapTablePanel").default
);
Vue.component(
  "data-analysis-left-panel",
  require("../components/DataAnalysisLeftPanel").default
);
Vue.component(
  "data-analysis-gas-composition",
  require("../components/DataAnalysisGasComposition").default
);
Vue.component(
  "data-analysis-gas-composition-panel",
  require("../components/DataAnalysisGasCompositionPanel").default
);
Vue.component(
  "data-analysis-fluid-composition",
  require("../components/DataAnalysisFluidComposition").default
);
Vue.component(
  "data-analysis-fluid-composition-panel",
  require("../components/DataAnalysisFluidCompositionPanel").default
);
Vue.component(
  "data-analysis-custom-charts",
  require("../components/DataAnalysisCustomCharts").default
);
Vue.component(
  "data-analysis-custom-charts-panel",
  require("../components/DataAnalysisCustomChartsPanel").default
);
</script>

<style lang="scss">
.data-analysis {
  display: flex;
  color: #fff;

  &__content {
    width: calc(100% - 340px);
  }
}

.data-analysis__wrapper {
  background: #272953;
  padding: 8px;

  &-title {
    display: flex;
    align-items: center;
    background: #323370;
    border: 1px solid #545580;
    padding: 8px;
    margin-bottom: 8px;
    height: 30px;
    /*width: calc(100% - 42px);*/

    .icon-title {
      background-color: #b3b6d1;
      border-radius: 5px;
      margin-right: 10px;
      width: 26px;
      text-align: center;
    }

    .fa-sliders-h {
      color: #868bb2;
      font-size: 16px;
    }

    span {
      font-size: 16px;
    }
  }

  &-img {
    background: #000;
    text-align: center;
    padding: 6px;
  }

  img {
    width: 100%;
  }
}
.full {
  height: calc(100vh - 350px);
}
.next {
  display: flex;
  justify-content: space-between;
  /*align-items: center;*/
}
.data-analysis .row {
}
.next .data-analysis__wrapper-title {
  width: calc(100% - 35px);
}
.data-analysis__wrapper-title img {
  display: block;
  width: 17px;
  height: auto;
  margin-right: 10px;
}
.data-analysis__row_bottom {
  width: 31px;
  height: 42px;
  background: #333975;
  border: 1px solid #545580;
  border-radius: 4px;
  display: flex;
  align-items: center;
  cursor: pointer;
}

.data-analysis__row_bottom img {
  display: block;
  width: 14px;
  height: 6px;
  margin: 0 auto;
  transition: all 0.3s ease-in-out;
}
.data-analysis__row_bottom.active img {
  transform: rotate(180deg);
}

.data-analysis table.defaultTable {
  max-height: 600px;
  position: relative;
  display: block;
  width: 100%;
  font-size: 12px;
  text-align: center;
  color: #ffffff;
  overflow-x: scroll;
}

.data-analysis table.defaultTable tbody {
  width: 120%;
  display: table;
}

.data-analysis table.defaultTable tr:nth-child(even) {
  background: rgba(69, 77, 125, 0.7);
}
.data-analysis table.defaultTable tr:nth-child(odd) {
  background: #34365d;
}

.data-analysis table.defaultTable td,
.data-analysis table.defaultTable th {
  border: 1px solid #454d7d;
  padding: 0.5rem 0.23rem;
  vertical-align: middle !important;
}

.data-analysis table.defaultTable td.head {
  background: #333975;
  height: 26px;
}
.data-analysis table.defaultTable th {
  font-size: 11px;
  background: #333975;
}
.data-analysis table.defaultTable::-webkit-scrollbar-thumb {
  background-color: #000000;
  border: 2px solid #ffffff;
}
.data-analysis table.defaultTable::-webkit-scrollbar {
  width: 4px;
}
table.defaultTable thead {
  position: fixed;
  top: 0;
}
</style>
