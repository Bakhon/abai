<template>
  <div class="row p-3 bg-main1">
    <div class="d-flex">
      <chart-button
          v-for="(tab, index) in tabs"
          :key="index"
          :text="tab"
          :active="activeTab === index"
          :class="index ? 'ml-2' : ''"
          class="col"
          @click.native="activeTab = index"/>
    </div>

    <div class="mt-3 w-100">
      <h5 class="subtitle text-wrap">
        {{ tabs[activeTab] }}
      </h5>

      <chart-with-profitability
          v-if="activeTab === 0"
          :data="charts.profitability"
          :paused-data="charts.pausedProfitability"
          :granularity="granularity"
          :profitability="profitability"
          :title="trans('economic_reference.count_well')"
          :oil-prices="filteredOilPrices"
          :dollar-rates="filteredDollarRates"
          class="bg-economic-chart"/>

      <chart-with-oil-production
          v-if="activeTab === 1"
          :data="charts.oilProduction"
          :granularity="granularity"
          :profitability="profitability"
          :title="trans('economic_reference.oil_production')"
          :tooltip-text="trans('economic_reference.thousand_tons')"
          :oil-prices="filteredOilPrices"
          :dollar-rates="filteredDollarRates"
          class="bg-economic-chart"/>

      <chart-with-operating-profit-top
          v-else-if="activeTab === 2"
          :data="charts.operatingProfitTop"
          :granularity="granularity"
          :profitability="profitability"
          :oil-prices="filteredOilPrices"
          :dollar-rates="filteredDollarRates"
          class="bg-economic-chart"/>

      <chart-with-liquid-production
          v-else-if="activeTab === 3"
          :data="charts.liquidProduction"
          :granularity="granularity"
          :profitability="profitability"
          :oil-prices="filteredOilPrices"
          :dollar-rates="filteredDollarRates"
          class="bg-economic-chart"/>

      <table-uwi-per-month
          v-else-if="activeTab === 4"
          :data="charts.uwiPerMonth"
          property="NetBack_bf_pr_exp"
          class="bg-economic-chart"/>

      <table-uwi-per-month
          v-else-if="activeTab === 5"
          :data="charts.uwiPerMonth"
          property="Overall_expenditures"
          class="bg-economic-chart"/>

      <table-uwi-per-month
          v-else-if="activeTab === 6"
          :data="charts.uwiPerMonth"
          property="Operating_profit"
          class="bg-economic-chart"/>
    </div>
  </div>
</template>

<script>
import ChartButton from "../ChartButton";
import ChartWithProfitability from "./ChartWithProfitability";
import ChartWithOilProduction from "./ChartWithOilProduction";
import ChartWithOperatingProfitTop from "./ChartWithOperatingProfitTop";
import ChartWithLiquidProduction from "./ChartWithLiquidProduction";
import TableUwiPerMonth from "./TableUwiPerMonth";


export default {
  name: "Charts",
  components: {
    ChartButton,
    ChartWithProfitability,
    ChartWithOilProduction,
    ChartWithOperatingProfitTop,
    ChartWithLiquidProduction,
    TableUwiPerMonth,
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
    }
  },
  data: () => ({
    activeTab: 0
  }),
  computed: {
    title() {
      return this.tabs[this.activeTab]
    },

    tabs() {
      return [
        this.trans('economic_reference.distribution_wells_by_profitability'),
        this.trans('economic_reference.distribution_oil_production_by_profitability'),
        this.trans('economic_reference.rating_top_10_wells_by_profitability'),
        this.trans('economic_reference.distribution_liquid_production_by_profitability'),
        this.trans('economic_reference.Revenue'),
        this.trans('economic_reference.costs'),
        this.trans('economic_reference.operating_profit'),
      ]
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
  }
}
</script>

<style scoped>
.bg-economic-chart {
  background: #2B2E5E;
}
</style>