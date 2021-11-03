<template>
  <div class="row px-3 py-2 bg-main1 position-relative">
    <div class="d-flex">
      <chart-button
          v-for="(tab, index) in Object.keys(tabs)"
          :key="index"
          :text="tabs[tab]"
          :active="activeTab === tab"
          :class="index ? 'ml-2' : ''"
          class="px-2 d-flex align-items-center h-50px"
          @click.native="selectTab(tab)"/>
    </div>

    <div class="mt-2 w-100 h-100">
      <table-production-loss
          v-if="activeTab === 'production_loss'"
          :wells="wellsByLossStatuses"
          class="text-white"
          @updateWide="updateWide"/>

      <table-oil-production-loss
          v-else-if="activeTab === 'oil_production_loss'"
          :wells="wellsByLossStatuses"
          class="text-white"
          @updateWide="updateWide"/>

      <table-financial-loss
          v-else-if="activeTab === 'financial_loss'"
          :wells="wellsByStatuses"
          class="text-white"
          @updateWide="updateWide"/>

      <table-well-distribution
          v-else-if="activeTab === 'well_distribution'"
          class="text-white"
          @updateWide="updateWide"/>

      <table-additional-stops
          v-else-if="activeTab === 'additional_stops'"
          class="text-white"
          @updateWide="updateWide"/>

      <table-oil-production-loss
          v-else-if="activeTab === 'oil_production_tech_loss'"
          :wells="wellsByStatuses"
          class="text-white"
          is-tech-loss
          @updateWide="updateWide"/>

      <table-economic-tech-loss
          v-else-if="activeTab === 'economic_tech_loss'"
          class="text-white"
          @updateWide="updateWide"/>

      <table-oil-production-loss
          v-else-if="activeTab === 'prs_cost'"
          :wells="wellsByLossStatuses"
          class="text-white"
          is-prs
          @updateWide="updateWide"/>
    </div>
  </div>
</template>

<script>
import ChartButton from "../ChartButton";
import TableProductionLoss from "./TableProductionLoss";
import TableOilProductionLoss from "./TableOilProductionLoss";
import TableFinancialLoss from "./TableFinancialLoss";
import TableWellDistribution from "./TableWellDistribution";
import TableAdditionalStops from "./TableAdditionalStops";
import TableEconomicTechLoss from "./TableEconomicTechLoss";

export default {
  name: "Tables",
  components: {
    ChartButton,
    TableProductionLoss,
    TableOilProductionLoss,
    TableFinancialLoss,
    TableWellDistribution,
    TableAdditionalStops,
    TableEconomicTechLoss,
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
    wellsByStatuses: {
      required: true,
      type: Array
    },
    wellsByLossStatuses: {
      required: true,
      type: Array
    },
  },
  data: () => ({
    activeTab: 'production_loss',
  }),
  computed: {
    tabs() {
      return {
        production_loss: 'Потеря добычи остановок',
        oil_production_loss: 'Потеря добычи по типу рентабельности',
        financial_loss: 'Финансовые потери от остановок',
        well_distribution: 'Распределение остановленных скважин',
        additional_stops: 'Возможность дополнительных остановок',
        oil_production_tech_loss: 'Технологические потери: добыча',
        economic_tech_loss: 'Технологические потери: экономика',
        prs_cost: 'Расходы на ПРС',
      }
    },
  },
  methods: {
    selectTab(tab) {
      this.activeTab = tab

      this.$emit('updateTab', tab)
    },

    updateWide(val){
      this.$emit('updateWide', val)
    }
  }
}
</script>

<style scoped>
.h-50px {
  height: 50px;
}
</style>