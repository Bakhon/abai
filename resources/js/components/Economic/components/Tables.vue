<template>
  <div class="row p-3 bg-main1 position-relative">
    <div class="d-flex">
      <chart-button
          v-for="(tab, index) in tabs"
          :key="index"
          :text="tab"
          :active="activeIndex === index"
          :class="index ? 'ml-2' : ''"
          class="px-2 d-flex align-items-center"
          @click.native="selectTab(index)"/>
    </div>

    <div class="mt-3 w-100">
      <table-specific-indicators
          v-if="activeTab === 'specific-indicators'"
          :org="res.org"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          :data="res.specificIndicator"
          class="text-white"/>

      <table-technical-economic-indicators
          v-else-if="activeTab === 'technical-economic-indicators'"
          :org="res.org"
          :scenarios="res.scenarios"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          class="text-white"/>

      <table-oil-price-options
          v-else-if="activeTab === 'oil-price-options'"
          :org="res.org"
          :scenarios="res.scenarios"
          :scenario="scenario"
          class="text-white"/>

      <table-well-changes
          v-else-if="activeTab === 'well-changes'"
          :org="res.org"
          :scenarios="res.scenarios"
          :scenario="scenario"
          :oil-prices="scenarioVariations.oil_prices"
          :data="res.wellChanges"
          ref="well-changes"
          class="text-white"/>

      <table-economic-efficiency
          v-else-if="activeTab === 'economic-efficiency'"
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
          v-else-if="activeTab === 'technological-indicators'"
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
    TablePalette,
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
    activeIndex: 0,
    activeTab: 'specific-indicators',
  }),
  computed: {
    tabs() {
      return [
        this.trans('economic_reference.specific_indicators'),
        this.trans('economic_reference.technical_economic_indicators'),
        this.trans('economic_reference.oil_price_options'),
        this.trans('economic_reference.table_well_changes'),
        this.trans('economic_reference.economic_efficiency'),
        this.trans('economic_reference.table_porcupine'),
        this.trans('economic_reference.technological_indicators'),
        this.trans('economic_reference.palette'),
      ]
    }
  },
  methods: {
    selectTab(index) {
      this.activeIndex = index

      this.activeTab = this.mapActiveTab(index)

      this.$emit('updateTab', index)
    },

    mapActiveTab(index) {
      switch (index) {
        case 0:
          return 'specific-indicators'
        case 1:
          return 'technical-economic-indicators'
        case 2:
          return 'oil-price-options'
        case 3:
          return 'well-changes'
        case 4:
          return 'economic-efficiency'
        case 5:
          return 'porcupine'
        case 6:
          return 'technological-indicators'
        case 7:
          return 'palette'
      }
    }
  }
}
</script>

<style scoped>

</style>