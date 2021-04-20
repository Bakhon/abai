<template>
  <div class="row proactive-factors-page-container">
    <div class="col-10 middle-block-columns">
      <div class="col px-2 container-col_color"></div>
    </div>
    <div class="col-2 px-2 middle-block-columns">
      <div class="col px-2">
        <div class="col container-col_color">
          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterFactor"
          ></proactive-factors-select-filter>
        </div>
        <div :class="filterClass">
          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterCompany"
          ></proactive-factors-select-filter>
        </div>

        <div :class="filterClass">
          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterVersionBp"
          ></proactive-factors-select-filter>
        </div>

        <div :class="filterClass">
          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterPriceBrent"
          ></proactive-factors-select-filter>
        </div>

        <div :class="filterClass">
          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterPriceInnerMarket"
          ></proactive-factors-select-filter>
        </div>

        <div :class="filterClass">
          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterCurrency"
          ></proactive-factors-select-filter>
        </div>

        <div :class="filterClass">
          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterCapex"
          ></proactive-factors-select-filter>
        </div>

        <div :class="filterClass">
          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterGetOil"
          ></proactive-factors-select-filter>
        </div>

        <div :class="filterClass">
          <proactive-factors-select-filter
            v-bind:selectFilter="selectFilterExportSalesPercentage"
          ></proactive-factors-select-filter>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import selectFilterFactor from "./selectFilterData/controlPanel.json";
import selectFilterCompany from "./selectFilterData/company.json";
import selectFilterVersionBp from "./selectFilterData/versionBp.json";
import selectFilterPriceBrent from "./selectFilterData/priceBrent.json";
import selectFilterPriceInnerMarket from "./selectFilterData/priceInnerMarket.json";
import selectFilterCurrency from "./selectFilterData/currency.json";
import selectFilterCapex from "./selectFilterData/Capex.json";
import selectFilterGetOil from "./selectFilterData/getOil.json";
import selectFilterExportSalesPercentage from "./selectFilterData/exportSalesPercentage.json";

export default {
  data: function () {
    return {
      filterClass: "col container-col_color mt-2",
      selectFilterFactor: selectFilterFactor,
      selectFilterCompany: selectFilterCompany,
      selectFilterVersionBp: selectFilterVersionBp,
      selectFilterPriceBrent: selectFilterPriceBrent,
      selectFilterPriceInnerMarket: selectFilterPriceInnerMarket,
      selectFilterCurrency: selectFilterCurrency,
      selectFilterCapex: selectFilterCapex,
      selectFilterGetOil: selectFilterGetOil,
      selectFilterExportSalesPercentage: selectFilterExportSalesPercentage,
    };
  },
};
</script>
