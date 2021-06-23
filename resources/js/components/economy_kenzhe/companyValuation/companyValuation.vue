<template>
  <div class="row m-0">   
    <div class="col-10 px-0">
      <div class="row col px-2 container-col_color m-0">        
      <div class="col charts px-0 mb-3">
            <div style="position:absolute;">
            {{trans('economy_pf.companyValuationPage.pageName')}}</div>
        <div class="chart-one">
          <main-factors-chart :chartSettings="chartSettings"></main-factors-chart>
        </div>
        <div class="chart-two mt-2">
          <cash-flow-dynamics-chart :chartSettings="chartSettings"></cash-flow-dynamics-chart>
        </div>
        <div class="chart-three mt-2">
          <sensitivity-npv-chart :chartSettings="chartSettings"> </sensitivity-npv-chart>          
         </div > 
          </div>                     
           <div class='table table-striped col mt-3'>
             <table class="table table-striped economics-table-color w-100 table-dark">
               <tr>
                 <th>{{trans('economy_pf.companyValuationPage.mainTechnicalAndEconomicIndicators')}}
                 </th>                          
                 <th>{{trans('economy_pf.companyValuationPage.value')}}
                 </th>
                </tr>                
                <tr>
                 <td>{{trans('economy_pf.companyValuationPage.priceBrent')}}
                 </td>
                  <td>40
                 </td>
                </tr>
                <tr>
                 <td style="background-color:#454d7d">Сценарий БП
                 </td>
                  <td style="background-color:#454d7d">Корр. 6
                 </td>
                </tr>
             </table>
            </div>
        </div>
      </div>
      <div class="col-2 px-0">
        <div class="col px-2">
          <div class="col container-col_color m-0">
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
import chartSettings from './charts/chart_settings.json';
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
      chartSettings: chartSettings,
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
      mounted(){    
        chartSettings.xaxis.categories=[2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016];  
        this.chartOptionsMainFactors = chartSettings;
    }  
};
</script>
<style scoped>
@import "./companyValuation.css";
</style>
