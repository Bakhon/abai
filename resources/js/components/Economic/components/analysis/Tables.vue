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
    </div>
  </div>
</template>

<script>
import ChartButton from "../ChartButton";
import TableProductionLoss from "./TableProductionLoss";

export default {
  name: "Tables",
  components: {
    ChartButton,
    TableProductionLoss,
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
    activeTab: 'production_loss',
  }),
  computed: {
    tabs() {
      return {
        production_loss: 'Потеря добычи остановок',
        production_loss_by_profitability: 'Потеря добычи по типу рентабельности',
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