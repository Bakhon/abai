<template>
  <div class="row px-3 pt-3 pb-2 bg-main1 position-relative">
    <div class="d-flex">
      <chart-button
          v-for="(tab, index) in Object.keys(tabs)"
          :key="index"
          :text="tabs[tab]"
          :active="activeTab === tab"
          :class="index ? 'ml-2' : ''"
          class="px-2 d-flex align-items-center"
          @click.native="selectTab(tab)"/>
    </div>

    <div class="mt-2 w-100">
      <table-specific-indicators
          v-if="activeTab === 'specific_indicators'"
          :org="res.org"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          :data="res.specificIndicator"
          :dollar-rates="scenarioVariations.dollar_rates"
          :gtms="res.gtms"
          :is-fullscreen="isFullscreen"
          class="text-white"/>

      <table-technical-economic-indicators
          v-else-if="activeTab === 'technical_economic_indicators'"
          :org="res.org"
          :scenarios="res.scenario.results"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          :is-fullscreen="isFullscreen"
          :manufacturing-program="res.manufacturingProgram"
          class="text-white"/>

      <table-oil-price-options
          v-else-if="activeTab === 'oil_price_options'"
          :org="res.org"
          :scenarios="res.scenario.results"
          :scenario="scenario"
          :is-fullscreen="isFullscreen"
          class="text-white"/>

      <table-well-changes
          v-else-if="activeTab === 'well_changes'"
          :key="`${res.scenario.id}_${isFullscreen}`"
          :scenario="scenario"
          :scenarios="res.scenario.results"
          :oil-prices="scenarioVariations.oil_prices"
          :is-fullscreen="isFullscreen"
          class="text-white"/>

      <table-economic-efficiency
          v-else-if="activeTab === 'economic_efficiency'"
          :scenarios="res.scenario.results"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          :is-fullscreen="isFullscreen"
          class="text-white"/>

      <table-porcupine
          v-else-if="activeTab === 'porcupine'"
          :key="res.scenario.id"
          :scenarios="res.scenario.results"
          :scenario="scenario"
          :scenario-variations="scenarioVariations"
          :is-fullscreen="isFullscreen"
          class="text-white"/>

      <table-technological-indicators
          v-else-if="activeTab === 'technological_indicators'"
          :scenarios="res.scenario.results"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          :is-fullscreen="isFullscreen"
          class="text-white"/>

      <table-chess
          v-else-if="activeTab === 'chess'"
          :scenarios="res.scenario.results"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          :is-fullscreen="isFullscreen"
          :manufacturing-program="res.manufacturingProgram"
          class="text-white"/>

      <table-palette
          v-else-if="activeTab === 'palette'"
          :scenarios="res.scenario.results"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          :is-fullscreen="isFullscreen"
          :manufacturing-program="res.manufacturingProgram"
          class="text-white"/>

      <table-well-tree-map
          v-else-if="activeTab === 'well_treemap'"
          :key="scenarioUniqueKey"
          :scenario="scenario"
          :scenarios="res.scenario.results"
          :is-fullscreen="isFullscreen"
          class="text-white"/>

      <table-well-overview-map
          v-else-if="activeTab === 'well_overview_map'"
          :key="res.scenario.id"
          :scenario="scenario"
          :scenarios="res.scenario.results"
          :is-fullscreen="isFullscreen"/>

      <table-well-stock
          v-else-if="activeTab === 'well_stock'"
          :scenarios="res.scenario.results"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          :is-fullscreen="isFullscreen"/>
    </div>
  </div>
</template>

<script>
import ChartButton from "../../components/ChartButton";
import TableSpecificIndicators from "./TableSpecificIndicators";
import TableTechnicalEconomicIndicators from "./TableTechnicalEconomicIndicators";
import TableOilPriceOptions from "./TableOilPriceOptions";
import TableWellChanges from "./TableWellChanges";
import TableEconomicEfficiency from "./TableEconomicEfficiency";
import TablePorcupine from "./TablePorcupine";
import TableTechnologicalIndicators from "./TableTechnologicalIndicators";
import TableChess from "./TableChess";
import TablePalette from "./TablePalette";
import TableWellTreeMap from "./TableWellTreeMap";
import TableWellOverviewMap from "./TableWellOverviewMap";
import TableWellStock from "./TableWellStock";

export default {
  name: "Tables",
  components: {
    ChartButton,
    TableSpecificIndicators,
    TableTechnicalEconomicIndicators,
    TableOilPriceOptions,
    TableWellChanges,
    TableEconomicEfficiency,
    TablePorcupine,
    TableTechnologicalIndicators,
    TableChess,
    TablePalette,
    TableWellTreeMap,
    TableWellOverviewMap,
    TableWellStock
  },
  props: {
    scenario: {
      required: true,
      type: Object
    },
    scenarioVariations: {
      required: true,
      type: Object
    },
    res: {
      required: true,
      type: Object
    },
    isFullscreen: {
      required: false,
      type: Boolean
    }
  },
  data: () => ({
    activeTab: 'specific_indicators',
  }),
  computed: {
    tabs() {
      return {
        specific_indicators: this.trans('economic_reference.specific_indicators'),
        technological_indicators: this.trans('economic_reference.technological_indicators'),
        technical_economic_indicators: this.trans('economic_reference.technical_economic_indicators'),
        oil_price_options: this.trans('economic_reference.oil_price_options'),
        well_changes: this.trans('economic_reference.table_well_changes'),
        porcupine: this.trans('economic_reference.table_porcupine'),
        chess: this.trans('economic_reference.table_chess'),
        economic_efficiency: this.trans('economic_reference.economic_efficiency'),
        palette: this.trans('economic_reference.palette'),
        well_treemap: 'TreeMap',
        well_overview_map: this.trans('economic_reference.well_overview_map'),
        well_stock: this.trans('economic_reference.production_wells_fund'),
      }
    },

    scenarioUniqueKey() {
      return `${this.res.scenario.id}
          ${this.scenario.dollar_rate},
          ${this.scenario.oil_price},
          ${this.scenario.coef_Fixed_nopayroll},
          ${this.scenario.coef_cost_WR_payroll}
          ${this.scenario.percent_stop_cat_1},
          ${this.scenario.percent_stop_cat_2},`
    }
  },
  methods: {
    selectTab(tab) {
      this.activeTab = tab

      this.$emit('updateTab', tab)
    },
  }
}
</script>

<style scoped>

</style>