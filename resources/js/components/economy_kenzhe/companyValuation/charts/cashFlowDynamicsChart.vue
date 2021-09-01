<template>
  <div class="chart-border_color mt-3">
    <div>
      <div class="col px-2 container-col_color">
     <apexchart  height="255" :options="chartOptionsCashFlow" :series="series"></apexchart>
      </div>
    </div>
  </div>
</template>
<script>
import VueApexCharts from "vue-apexcharts";

export default {
  components: {
    apexchart: VueApexCharts,
  },
  props: ["chartSettings"],
  data: function () {
    return {
    series: [
      {
        name: "Cash Flow",
        type: "bar",
        data: [1.45, 5.42, 5.9, -0.42, -12.6, -18.1, -20
        ]      
      },  {
          name: "Opex",
          type: "line",
          data: [20, 29, 37, 36, 44, 45,47],
        },
     {
          name: "Opex",
          type: "line",
          data: [29, 37, 36, 44, 45, 50,55],
        },
    ],
    chartOptionsCashFlow: {
        grid: {
        show: true,
        borderColor: '#33396f'             
        },
        stroke: {
          width: [1, 1, 4],
          show: true,
          curve: "smooth",
          lineCap: "butt",
          colors: undefined,
          width: 2,
          dashArray: [0, 0, 5],
        },
         title: {
          text: this.trans('economy_pf.companyValuationPage.CashFlowDynamics'),
          align: "center",    
          offsetY: 15,
      style: {
      fontSize:  '18px',
      fontWeight:  'bold',
      fontFamily:  undefined,
      color:  '#fff'
    },
        },
      chart: {          
      },
      plotOptions: {
        bar: {
          colors: {
            ranges: [
              {
                from: -100,
                to: -46,
                color: "#F15B46",
              },
              {
                from: -45,
                to: 0,
                color: "#FEB019",
              },
            ],
          },
          columnWidth: "80%",
        },
      },
      dataLabels: {
        enabled: false,
      },
      yaxis: {
        title: {
          text: "Growth",
        },
        labels: {
          formatter: function (y) {
            return y.toFixed(0);
          },
        },
      },
      xaxis: {
        type: "datetime",        
        labels: {
          rotate: -90,
        },
      },
    },
   };    
  }, 
    mounted(){
        this.chartOptionsCashFlow = this.chartSettings;
    }  
};
</script>
