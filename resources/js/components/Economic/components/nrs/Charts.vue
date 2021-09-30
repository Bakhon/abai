<template>
  <div class="row px-3 py-2 bg-main1">
    <div class="d-flex">
      <chart-button
          v-for="(tab, index) in Object.keys(tabs)"
          :key="index"
          :text="tabs[tab]"
          :active="activeTab === tab"
          :class="index ? 'ml-2' : ''"
          class="col"
          @click.native="activeTab = tab"/>

      <chart-button
          :text="trans('economic_reference.matrix')"
          class="ml-2 col"
          style="font-size: 12px"
          @click.native="openMatrix"/>
    </div>

    <div class="w-100 mt-2">
      <subtitle class="text-wrap text-white">
        {{ tabs[activeTab] }}
      </subtitle>

      <chart-with-profitability
          v-if="activeTab === 'profitability'"
          :data="charts.profitability"
          :paused-data="charts.pausedProfitability"
          :granularity="granularity"
          :profitability="profitability"
          :title="trans('economic_reference.count_well')"
          :oil-prices="filteredOilPrices"
          :dollar-rates="filteredDollarRates"
          class="bg-economic-chart mt-2"/>

      <chart-with-oil-production
          v-if="activeTab === 'oil_production'"
          :data="charts.oilProduction"
          :granularity="granularity"
          :profitability="profitability"
          :title="trans('economic_reference.oil_production')"
          :tooltip-text="trans('economic_reference.thousand_tons')"
          :oil-prices="filteredOilPrices"
          :dollar-rates="filteredDollarRates"
          class="bg-economic-chart mt-2"/>

      <chart-with-operating-profit-top
          v-else-if="activeTab === 'operating_profit_top'"
          :data="charts.operatingProfitTop"
          :granularity="granularity"
          :profitability="profitability"
          :oil-prices="filteredOilPrices"
          :dollar-rates="filteredDollarRates"
          :org_id="form.org_id"
          class="bg-economic-chart mt-2"/>

      <chart-with-liquid-production
          v-else-if="activeTab === 'liquid_production'"
          :data="charts.liquidProduction"
          :granularity="granularity"
          :profitability="profitability"
          :oil-prices="filteredOilPrices"
          :dollar-rates="filteredDollarRates"
          class="bg-economic-chart mt-2"/>

      <chart-well-map
          v-else-if="activeTab === 'well_map'"
          :org-form="form"/>
    </div>
  </div>
</template>

<script>
import ChartButton from "../ChartButton";
import ChartWithProfitability from "./ChartWithProfitability";
import ChartWithOilProduction from "./ChartWithOilProduction";
import ChartWithOperatingProfitTop from "./ChartWithOperatingProfitTop";
import ChartWithLiquidProduction from "./ChartWithLiquidProduction";
import ChartWellMap from "./ChartWellMap";
import Subtitle from "../Subtitle";

export default {
  name: "Charts",
  components: {
    ChartButton,
    ChartWithProfitability,
    ChartWithOilProduction,
    ChartWithOperatingProfitTop,
    ChartWithLiquidProduction,
    ChartWellMap,
    Subtitle
  },
  props: {
    charts: {
      required: true,
      type: Object
    },
    granularity: {
      required: true,
      type: String
    },
    profitability: {
      required: true,
      type: String
    },
    oilPrices: {
      required: true,
      type: Array
    },
    dollarRates: {
      required: true,
      type: Array
    },
    form: {
      required: true,
      type: Object
    }
  },
  data: () => ({
    activeTab: 'profitability'
  }),
  computed: {
    title() {
      return this.tabs[this.activeTab]
    },

    tabs() {
      return {
        profitability: this.trans('economic_reference.distribution_wells_by_profitability'),
        oil_production: this.trans('economic_reference.distribution_oil_production_by_profitability'),
        operating_profit_top: this.trans('economic_reference.rating_top_10_wells_by_profitability'),
        liquid_production: this.trans('economic_reference.distribution_liquid_production_by_profitability'),
        well_map: this.trans('economic_reference.well_overview_map'),
      }
    },

    filteredOilPrices() {
      let data = []

      let price = this.oilPrices[0]

      this.charts.profitability.dt.forEach(dt => {
        price = this.oilPrices.find(rate => [rate.dt, rate.dt_month].includes(dt)) || price

        data.push(price ? price.value : 0)
      })

      return data
    },

    filteredDollarRates() {
      let data = []

      let rate = this.dollarRates[0]

      this.charts.profitability.dt.forEach(dt => {
        rate = this.dollarRates.find(rate => [rate.dt, rate.dt_month].includes(dt)) || rate

        data.push(rate ? rate.value : 0)
      })

      return data
    },
  },
  methods: {
    openMatrix() {
      window.open(this.localeUrl('/economic/nrs/wells'), '_blank')
    }
  }
}
</script>

<style scoped>
.bg-economic-chart {
  background: #2B2E5E;
}
</style>