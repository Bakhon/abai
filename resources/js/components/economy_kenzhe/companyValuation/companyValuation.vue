<template>
  <div class="row m-0">   
    <div class="col-10 px-0">
      <div class="row col px-2 container-col_color m-0">      
      <div class="col charts px-0 mb-3">         
        <div class="chart-one" v-if="show">
            <company-valuation-chart :chartOptionsData="mainFactorsChartOptions">
          </company-valuation-chart>
        </div>
        <div class="chart-two mt-2">
           <company-valuation-chart :chartOptionsData="cashFlowDynamicsChartOptions">
          </company-valuation-chart>
        </div>
        <div class="chart-three mt-2" v-if="show">
            <company-valuation-chart :chartOptionsData="sensitivityNpvChartOptions">
          </company-valuation-chart>
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
                {{ trans("economy_pf.controlPanelCompanyValuation") }}
              </div>
            </div>
          </div>
          <proactive-factors-select-filter
            v-for="(selectFilter,index) in selectFilterAll" :key="index"
            v-bind:selectFilter="selectFilter"
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
Vue.component(
  "company-valuation-chart",
  require("./charts/companyValuationChart.vue").default
);

import mainFactorsChartOptions from "./charts/chart_settings/main_factors.json";
import cashFlowDynamicsChartOptions from "./charts/chart_settings/cash_flow_dynamics.json";
import sensitivityNpvChartOptions from "./charts/chart_settings/sensitivity_npv_chart.json";
import selectFilterCompany from "../proactiveFactors/selectFilterData/company.json";
import selectFilterVersionBp from "../proactiveFactors/selectFilterData/versionBp.json";
import selectFilterPriceBrent from "../proactiveFactors/selectFilterData/priceBrent.json";
import selectFilterPriceInnerMarket from "../proactiveFactors/selectFilterData/priceInnerMarket.json";
import selectFilterCurrency from "../proactiveFactors/selectFilterData/currency.json";
import selectFilterCapex from "../proactiveFactors/selectFilterData/capex.json";
import selectFilterGetOil from "../proactiveFactors/selectFilterData/getOil.json";
import selectFilterExportSalesPercentage from "../proactiveFactors/selectFilterData/exportSalesPercentage.json";
import costAllocationBase from "../proactiveFactors/selectFilterData/costAllocationBase.json";

export default {
  data: function () {
    return {
      show: false,
      mainFactorsChartOptions: mainFactorsChartOptions,
      cashFlowDynamicsChartOptions: cashFlowDynamicsChartOptions,
      sensitivityNpvChartOptions: sensitivityNpvChartOptions,
      companyData: "",
      selectFilterAll: [
        selectFilterCompany,
        selectFilterVersionBp,
        selectFilterPriceBrent,
        selectFilterPriceInnerMarket,
        selectFilterCurrency,
        selectFilterCapex,
        selectFilterGetOil,
        selectFilterExportSalesPercentage,
        costAllocationBase,
      ],
    };
  },
  async created() {
    await this.downloadJson();

    this.mainFactorsChartOptions = Object.assign(this.mainFactorsChartOptions, {
      series: [
        {
          name: this.trans("economy_pf.companyValuationPage.revenue"),
        },
        {
          name: "Opex",
        },
        {
          name: "Capex",
        },
        {
          name: this.trans(
            "economy_pf.companyValuationPage.extractionOfHydrocarbons"
          ),
        },
      ],
      chartOptions: {
        title: {
          text: this.trans("economy_pf.companyValuationPage.mainFactors"),
        },
      },
    });

    this.cashFlowDynamicsChartOptions = Object.assign(
      this.cashFlowDynamicsChartOptions,
      {
        series: [
          {
            name: "Cash Flow",
            type: "bar",
            data: [1.45, 5.42, 5.9, -0.42, -12.6, -18.1, -20],
          },
          {
            name: "Opex",
            type: "line",
            data: [20, 29, 37, 36, 44, 45, 47],
          },
          {
            name: "Opex",
            type: "line",
            data: [29, 37, 36, 44, 45, 50, 55],
          },
        ],
        chartOptions: {
          title: {
            text: this.trans(
              "economy_pf.companyValuationPage.CashFlowDynamics"
            ),
          },
        },
      }
    );

    this.sensitivityNpvChartOptions = Object.assign(
      this.sensitivityNpvChartOptions,
      {
        series: [
          {
            name: this.trans("economy_pf.companyValuationPage.priceBrent"),
          },
          {
            name: this.trans("economy_pf.companyValuationPage.currency"),
          },
          {
            name: "Capex",
          },
          {
            name: "Opex",
          },
        ],
        chartOptions: {
          title: {
            text: this.trans("economy_pf.companyValuationPage.sensitivityNPV"),
          },
        },
      }
    );
  },

  methods: {
    downloadJson() {
      this.show = true;
    },
  },
};
</script>
<style scoped>
@import "./companyValuation.css";
</style>
