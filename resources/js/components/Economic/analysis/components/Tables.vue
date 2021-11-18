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

      <chart-button
          :text="trans('economic_reference.matrix')"
          class="ml-2 px-2 d-flex align-items-center h-50px"
          @click.native="openMatrix"/>
    </div>

    <div class="mt-2 w-100 h-100">
      <table-production-loss
          v-if="activeTab === 'production_loss'"
          :wells="wellsSumByLossStatus"
          :proposed-stopped-wells="proposedStoppedWells"
          class="text-white"
          @updateWide="updateWide"/>

      <table-oil-production-loss
          v-else-if="activeTab === 'oil_production_loss'"
          :wells="wellsSumByLossStatus"
          key="oil_production_loss"
          class="text-white"
          @updateWide="updateWide"/>

      <table-financial-loss
          v-else-if="activeTab === 'financial_loss'"
          :wells="wellsSum"
          :proposed-wells="proposedWellsSum"
          class="text-white"
          @updateWide="updateWide"/>

      <table-well-distribution
          v-else-if="activeTab === 'well_distribution'"
          :wells="wells"
          :proposed-wells="proposedWells"
          class="text-white"
          @updateWide="updateWide"/>

      <table-additional-stops
          v-else-if="activeTab === 'additional_stops'"
          :wells="profitlessWellsWithPrs"
          class="text-white"
          @updateWide="updateWide"/>

      <table-oil-production-loss
          v-else-if="activeTab === 'oil_production_tech_loss'"
          :wells="wellsSumByStatus"
          key="oil_production_tech_loss"
          class="text-white"
          is-tech-loss
          @updateWide="updateWide"/>

      <table-oil-production-loss
          v-else-if="activeTab === 'economic_tech_loss'"
          :wells="wellsSumByStatus"
          :title="trans('economic_reference.table_economic_tech_loss_title')"
          key="economic_tech_loss"
          class="text-white"
          is-tech-loss
          is-prs
          is-oil-loss-sum
          is-operating-profit-sum
          @updateWide="updateWide"/>

      <table-oil-production-loss
          v-else-if="activeTab === 'prs_cost'"
          :wells="wellsSumByLossStatus"
          key="prs_cost"
          class="text-white"
          is-prs
          @updateWide="updateWide"/>
    </div>
  </div>
</template>

<script>
import ChartButton from "../../components/ChartButton";
import TableProductionLoss from "./TableProductionLoss";
import TableOilProductionLoss from "./TableOilProductionLoss";
import TableFinancialLoss from "./TableFinancialLoss";
import TableWellDistribution from "./TableWellDistribution";
import TableAdditionalStops from "./TableAdditionalStops";

export default {
  name: "Tables",
  components: {
    ChartButton,
    TableProductionLoss,
    TableOilProductionLoss,
    TableFinancialLoss,
    TableWellDistribution,
    TableAdditionalStops,
  },
  props: {
    wells: {
      required: true,
      type: Array
    },
    wellsSumByStatus: {
      required: true,
      type: Array
    },
    wellsSumByLossStatus: {
      required: true,
      type: Array
    },
    wellsSum: {
      required: true,
      type: Array
    },
    proposedWellsSum: {
      required: true,
      type: Array
    },
    proposedWells: {
      required: true,
      type: Array
    },
    proposedStoppedWells: {
      required: true,
      type: Array
    },
    profitlessWellsWithPrs: {
      required: true,
      type: Array
    }
  },
  data: () => ({
    activeTab: 'additional_stops',
  }),
  computed: {
    tabs() {
      return {
        production_loss: this.trans('economic_reference.table_production_loss'),
        oil_production_loss: this.trans('economic_reference.table_oil_production_loss'),
        financial_loss: this.trans('economic_reference.table_financial_loss'),
        well_distribution: this.trans('economic_reference.table_well_distribution'),
        additional_stops: this.trans('economic_reference.table_additional_stops'),
        oil_production_tech_loss: this.trans('economic_reference.table_oil_production_tech_loss'),
        economic_tech_loss: this.trans('economic_reference.table_economic_tech_loss'),
        prs_cost: this.trans('economic_reference.table_prs_cost'),
      }
    },
  },
  methods: {
    selectTab(tab) {
      this.activeTab = tab

      this.$emit('updateTab', tab)
    },

    updateWide(val) {
      this.$emit('updateWide', val)
    },

    openMatrix() {
      window.open(this.localeUrl('/economic/analysis/wells'), '_blank')
    }
  }
}
</script>

<style scoped>
.h-50px {
  height: 50px;
}
</style>