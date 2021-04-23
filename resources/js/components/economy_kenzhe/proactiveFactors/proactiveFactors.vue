<template>
  <div class="row proactive-factors-page-container">
    <div class="col-10 middle-block-columns">
      <div class="col px-2 container-col_color">
         <reptt-company2 :data-reptt="companyData"></reptt-company2>
      </div>
    </div>
    <div class="col-2 px-2 middle-block-columns">
      <div class="col px-2">
        <div class="col container-col_color">
       <div class="contro-panel-col_height"> 
       <div class="contro-panel-col_text">
         {{ this.trans("economy_pf.controlPanel") }}</div>
        </div></div>
       
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
           <button type="button" class="btn btn-primary btn_color mt-2 w-100">{{trans('economy_pf.applySettings')}}</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import selectFilterCompany from "./selectFilterData/company.json";
import selectFilterVersionBp from "./selectFilterData/versionBp.json";
import selectFilterPriceBrent from "./selectFilterData/priceBrent.json";
import selectFilterPriceInnerMarket from "./selectFilterData/priceInnerMarket.json";
import selectFilterCurrency from "./selectFilterData/currency.json";
import selectFilterCapex from "./selectFilterData/capex.json";
import selectFilterGetOil from "./selectFilterData/getOil.json";
import selectFilterExportSalesPercentage from "./selectFilterData/exportSalesPercentage.json";
import costAllocationBase from "./selectFilterData/costAllocationBase.json";

export default {
  data: function () {
    return { 
      companyData:'',
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
    }},
    created() {  
    this.getCompany();
    }
};
</script>

