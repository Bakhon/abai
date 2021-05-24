<template>
  <div class="row proactive-factors-page-container">
    <div class="col-10 middle-block-columns">
      <div class="col px-2 container-col_color">
        <!-- <reptt-company2 :data-reptt="companyData"></reptt-company2>-->     
        <apexchart type="line" height="350" :options="chartOptions" :series="series"></apexchart>      
      </div>
    </div>
    <div class="col-2 px-2 middle-block-columns">
      <div class="col px-2">
        <div class="col container-col_color">
       <div class="contro-panel-col_height"> 
       <div class="contro-panel-col_text">
         {{ this.trans("economy_pf.controlPanelCompanyValuation") }}</div>
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
      series: [
        {
          name: "Выручка",
          type: "column",
          data: [1.4, 2, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6],
        },
        {
          name: "Opex",
          type: "column",
          data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5],
        },
        {
          name: "Capex",
          type: "line",
          data: [20, 29, 37, 36, 44, 45, 50, 58],
        },
        {
          name: "Добыча УВС",
          type: "line",
          data: [50, 29, 37, 36, 44, 45, 50, 58],
        },
      ],
      chartOptions: {
        chart: {
          height: 350,
          type: "line",
          stacked: false,
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          width: [1, 1, 4],
          show: true,
          curve: "smooth",
          lineCap: "butt",
          colors: undefined,
          width: 2,
          dashArray: [0, 0, 0, 5],
        },
        title: {
          text: "Основные показатели",
          align: "left",
          offsetX: 110,
        },
        xaxis: {
          categories: [2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016],
        },
        yaxis: [
          {
            axisTicks: {
              show: true,
            },
            axisBorder: {
              show: true,
              color: "#008FFB",
            },
            labels: {
              style: {
                colors: "#008FFB",
              },
            },
            title: {
              text: "Income (thousand crores)",
              style: {
                color: "#008FFB",
              },
            },
            tooltip: {
              enabled: true,
            },
          },
          {
            seriesName: "Income",
            opposite: true,
            axisTicks: {
              show: true,
            },
            axisBorder: {
              show: true,
              color: "#00E396",
            },
            labels: {
              style: {
                colors: "#00E396",
              },
            },
            title: {
              text: "Operating Cashflow (thousand crores)",
              style: {
                color: "#00E396",
              },
            },
          },
          {
            seriesName: "Revenue",
            opposite: true,
            axisTicks: {
              show: true,
            },
            axisBorder: {
              show: true,
              color: "#FEB019",
            },
            labels: {
              style: {
                colors: "#FEB019",
              },
            },
            title: {
              text: "Revenue (thousand crores)",
              style: {
                color: "#FEB019",
              },
            },
          },
        ],
        tooltip: {
          fixed: {
            enabled: true,
            position: "topLeft", // topRight, topLeft, bottomRight, bottomLeft
            offsetY: 30,
            offsetX: 60,
          },
        },
        legend: {
          horizontalAlign: "left",
          offsetX: 40,
        },
      },
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

