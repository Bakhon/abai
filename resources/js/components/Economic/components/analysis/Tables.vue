<template>
  <div class="row px-3 py-2 bg-main1 position-relative">
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
      <table-production-loss
          v-if="activeTab === 'production_loss'"
          class="text-white"/>

      <table-oil-production-loss
          v-else-if="activeTab === 'oil_production_loss'"
          class="text-white"/>

      <table-financial-loss
          v-else-if="activeTab === 'financial_loss'"
          class="text-white"/>

      <table-additional-stops
          v-else-if="activeTab === 'additional_stops'"
          class="text-white"/>

      <table-oil-production-tech-loss
          v-else-if="activeTab === 'oil_production_tech_loss'"
          class="text-white"/>
    </div>
  </div>
</template>

<script>
import ChartButton from "../ChartButton";
import TableProductionLoss from "./TableProductionLoss";
import TableOilProductionLoss from "./TableOilProductionLoss";
import TableFinancialLoss from "./TableFinancialLoss";
import TableAdditionalStops from "./TableAdditionalStops";
import TableOilProductionTechLoss from "./TableOilProductionTechLoss";

export default {
  name: "Tables",
  components: {
    ChartButton,
    TableProductionLoss,
    TableOilProductionLoss,
    TableFinancialLoss,
    TableAdditionalStops,
    TableOilProductionTechLoss,
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
    activeTab: 'oil_production_tech_loss',
  }),
  computed: {
    tabs() {
      return {
        production_loss: 'Потеря добычи остановок',
        oil_production_loss: 'Потеря добычи по типу рентабельности',
        financial_loss: 'Финансовые потери от остановок',
        additional_stops: 'Возможность дополнительных остановок',
        oil_production_tech_loss: 'Технологические потери: добыча',
      }
    },
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