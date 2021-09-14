<template>
  <div class="row p-3 bg-main1 position-relative overflow-auto customScroll">
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

    <div class="mt-3 w-100">
      <table-specific-indicators
          v-if="activeTab === 'specific_indicators'"
          :org="res.org"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          :data="res.specificIndicator"
          :dollar-rates="scenarioVariations.dollar_rates"
          :gtms="res.gtms"
          class="text-white"/>

      <table-technical-economic-indicators
          v-else-if="activeTab === 'technical_economic_indicators'"
          :org="res.org"
          :scenarios="res.scenarios"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          class="text-white"/>

      <table-oil-price-options
          v-else-if="activeTab === 'oil_price_options'"
          :org="res.org"
          :scenarios="res.scenarios"
          :scenario="scenario"
          class="text-white"/>

      <table-well-changes
          v-else-if="activeTab === 'well_changes'"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          :data="res.wellChanges"
          class="text-white"/>

      <table-economic-efficiency
          v-else-if="activeTab === 'economic_efficiency'"
          :scenarios="res.scenarios"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          class="text-white"/>

      <table-porcupine
          v-else-if="activeTab === 'porcupine'"
          :scenarios="res.scenarios"
          :scenario="scenario"
          :scenario-variations="scenarioVariations"
          class="text-white"/>

      <table-technological-indicators
          v-else-if="activeTab === 'technological_indicators'"
          :scenarios="res.scenarios"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          class="text-white"/>

      <table-palette
          v-else-if="activeTab === 'palette'"
          :scenarios="res.scenarios"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          class="text-white"/>

      <table-well-tree-map
          v-else-if="activeTab === 'well_treemap'"
          :scenario="scenario"
          :key="scenarioUniqueKey"
          :data="res.wellChanges"
          class="text-white"/>
    </div>
  </div>
</template>

<script>
import ChartButton from "./ChartButton";
import TableSpecificIndicators from "./TableSpecificIndicators";
import TableTechnicalEconomicIndicators from "./TableTechnicalEconomicIndicators";
import TableOilPriceOptions from "./TableOilPriceOptions";
import TableWellChanges from "./TableWellChanges";
import TableEconomicEfficiency from "./TableEconomicEfficiency";
import TablePorcupine from "./TablePorcupine";
import TableTechnologicalIndicators from "./TableTechnologicalIndicators";
import TablePalette from "./TablePalette";
import TableWellTreeMap from "./TableWellTreeMap";

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
    TablePalette,
    TableWellTreeMap
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
    }
  },
  data: () => ({
    activeTab: 'specific_indicators',
  }),
  computed: {
    tabs() {
      return {
        specific_indicators: this.trans('economic_reference.specific_indicators'),
        technical_economic_indicators: this.trans('economic_reference.technical_economic_indicators'),
        oil_price_options: this.trans('economic_reference.oil_price_options'),
        well_changes: this.trans('economic_reference.table_well_changes'),
        economic_efficiency: this.trans('economic_reference.economic_efficiency'),
        porcupine: this.trans('economic_reference.table_porcupine'),
        technological_indicators: this.trans('economic_reference.technological_indicators'),
        palette: this.trans('economic_reference.palette'),
        well_treemap: 'TreeMap',
      }
    },

    scenarioUniqueKey() {
      return `${this.scenario.dollar_rate},
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