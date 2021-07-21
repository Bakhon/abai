<template>
  <div class="row p-3 mt-3 bg-main1">
    <div class="d-flex">
      <chart-button
          v-for="(tab, index) in tabs"
          :key="index"
          :text="tab"
          :active="activeTab === index"
          :class="index ? 'ml-2' : ''"
          class="px-2 d-flex align-items-center"
          @click.native="activeTab = index"/>
    </div>

    <div
        v-for="(tab, index) in tabs"
        v-show="activeTab === index"
        :key="tab"
        class="mt-3 w-100">
      <table-specific-indicators
          v-if="index === 2"
          :org="res.org"
          :scenario="scenario"
          :oil-prices="oilPrices"
          :data="res.specificIndicator"
          class="text-white"/>

      <table-technical-economic-indicators
          v-if="index === 1"
          :org="res.org"
          :scenarios="res.scenarios"
          :scenario="scenario"
          :oil-prices="oilPrices"
          :data="res.technicalEconomicIndicator"
          class="text-white"/>

      <table-oil-price-options
          v-if="index === 0"
          :org="res.org"
          :scenarios="res.scenarios"
          :scenario="scenario"
          :oil-prices="oilPrices"
          :data="res.technicalEconomicIndicator"
          class="text-white"/>
    </div>
  </div>
</template>

<script>
import ChartButton from "./ChartButton";
import TableSpecificIndicators from "./TableSpecificIndicators";
import TableTechnicalEconomicIndicators from "./TableTechnicalEconomicIndicators";
import TableOilPriceOptions from "./TableOilPriceOptions";

export default {
  name: "Tables",
  components: {
    ChartButton,
    TableSpecificIndicators,
    TableTechnicalEconomicIndicators,
    TableOilPriceOptions,
  },
  props: {
    scenario: {
      required: true,
      type: Object
    },
    oilPrices: {
      required: true,
      type: Array
    },
    res: {
      required: true,
      type: Object
    }
  },
  data: () => ({
    activeTab: 0
  }),
  computed: {
    tabs() {
      return [
        this.trans('economic_reference.oil_price_options'),
        this.trans('economic_reference.technical_economic_indicators'),
        this.trans('economic_reference.specific_indicators'),
      ]
    }
  }
}
</script>

<style scoped>

</style>