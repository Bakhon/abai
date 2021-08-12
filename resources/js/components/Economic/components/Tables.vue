<template>
  <div class="row p-3 bg-main1 position-relative">
    <div class="d-flex">
      <chart-button
          v-for="(tab, index) in tabs"
          :key="index"
          :text="tab"
          :active="activeTab === index"
          :class="index ? 'ml-2' : ''"
          class="px-2 d-flex align-items-center"
          @click.native="selectTab(index)"/>
    </div>

    <div class="mt-3 w-100">
      <table-palette
          v-if="1"
          :scenarios="res.scenarios"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          class="text-white"/>

      <table-specific-indicators
          v-else-if="activeTab === 0"
          :org="res.org"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          :data="res.specificIndicator"
          class="text-white"/>

      <table-technical-economic-indicators
          v-else-if="activeTab === 1"
          :org="res.org"
          :scenarios="res.scenarios"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          class="text-white"/>

      <table-oil-price-options
          v-else-if="activeTab === 2"
          :org="res.org"
          :scenarios="res.scenarios"
          :scenario="scenario"
          class="text-white"/>

      <table-well-changes
          v-else-if="activeTab === 3"
          :org="res.org"
          :scenarios="res.scenarios"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          :data="res.wellChanges"
          ref="well-changes"
          class="text-white"/>

      <table-economic-efficiency
          v-else-if="activeTab === 4"
          :scenarios="res.scenarios"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          class="text-white"/>

      <table-porcupine
          v-else-if="activeTab === 5"
          :scenarios="res.scenarios"
          :scenario="scenario"
          :scenario-variations="scenarioVariations"
          class="text-white"/>

      <table-technological-indicators
          v-else-if="6"
          :scenarios="res.scenarios"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
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
    TablePalette
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
    activeTab: 0,
  }),
  computed: {
    tabs() {
      return [
        this.trans('economic_reference.palette'),
        this.trans('economic_reference.technological_indicators'),
        this.trans('economic_reference.specific_indicators'),
        this.trans('economic_reference.technical_economic_indicators'),
        this.trans('economic_reference.oil_price_options'),
        this.trans('economic_reference.table_well_changes'),
        this.trans('economic_reference.economic_efficiency'),
        this.trans('economic_reference.table_porcupine'),
      ]
    }
  },
  methods: {
    selectTab(index) {
      this.activeTab = index

      this.$emit('updateTab', index)
    },
  }
}
</script>

<style scoped>

</style>