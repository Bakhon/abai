<template>
  <div class="row proactive-factors-page-container">
    <div class="col-10 middle-block-columns">
      <div class="col px-2 container-col_color">
        <div>
          <main-factors-chart></main-factors-chart>
        </div>
        <div class="mt-2">
          <cash-flow-dynamics-chart></cash-flow-dynamics-chart>
        </div>
        <div class="mt-2">
          <sensitivity-npv-chart> </sensitivity-npv-chart>
          </div>
        </div>
      </div>
      <div class="col-2 px-2 middle-block-columns">
        <div class="col px-2">
          <div class="col container-col_color">
            <div class="contro-panel-col_height">
              <div class="contro-panel-col_text">
                {{ this.trans("economy_pf.controlPanelCompanyValuation") }}
              </div>
            </div>
          </div>

          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterCompany"
          ></proactive-factors-select-filter>

          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterVersionBp"
          ></proactive-factors-select-filter>

          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterPriceBrent"
          ></proactive-factors-select-filter>

          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterPriceInnerMarket"
          ></proactive-factors-select-filter>

          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterCurrency"
          ></proactive-factors-select-filter>

          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterCapex"
          ></proactive-factors-select-filter>

          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterGetOil"
          ></proactive-factors-select-filter>

          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterExportSalesPercentage"
          ></proactive-factors-select-filter>

          <proactive-factors-select-filter
            v-bind:selectFilter="costAllocationBase"
          ></proactive-factors-select-filter>
          <button type="button" class="btn btn-primary btn_color mt-2 w-100">
            {{ trans("economy_pf.applySettings") }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import selectFilterCompany from "../proactiveFactors/selectFilterData/company.json";
import selectFilterVersionBp from "../proactiveFactors/selectFilterData/versionBp.json";
import selectFilterPriceBrent from "../proactiveFactors/selectFilterData/priceBrent.json";
import selectFilterPriceInnerMarket from "../proactiveFactors/selectFilterData/priceInnerMarket.json";
import selectFilterCurrency from "../proactiveFactors/selectFilterData/currency.json";
import selectFilterCapex from "../proactiveFactors/selectFilterData/capex.json";
import selectFilterGetOil from "../proactiveFactors/selectFilterData/getOil.json";
import selectFilterExportSalesPercentage from "../proactiveFactors/selectFilterData/exportSalesPercentage.json";
import costAllocationBase from "../proactiveFactors/selectFilterData/costAllocationBase.json";
import VueApexCharts from "vue-apexcharts";

export default {
  components: {
    apexchart: VueApexCharts,
  },
  data: function () {
    return {
      companyData: "",
      selectFilterCompany: selectFilterCompany,
      selectFilterVersionBp: selectFilterVersionBp,
      selectFilterPriceBrent: selectFilterPriceBrent,
      selectFilterPriceInnerMarket: selectFilterPriceInnerMarket,
      selectFilterCurrency: selectFilterCurrency,
      selectFilterCapex: selectFilterCapex,
      selectFilterGetOil: selectFilterGetOil,
      selectFilterExportSalesPercentage: selectFilterExportSalesPercentage,
      costAllocationBase: costAllocationBase,
    };
  },
  methods: {
    getCompany() {
      let uri = this.localeUrl("/module_economy/company");
      this.axios.get(uri).then((response) => {
        let data = response.data;
        this.companyData = data;
      });
    },
  },
  created() {
    this.getCompany();
  },
};
</script>

