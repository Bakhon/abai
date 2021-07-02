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
        /*this.chartSettings.xaxis.categories= [
          "2011-01-01",
          "2011-02-01",
          "2011-03-01",
          "2011-04-01",
          "2011-05-01",
          "2011-06-01",
          "2011-07-01",
          "2011-08-01",
          "2011-09-01",
          "2011-10-01",
          "2011-11-01",
          "2011-12-01",
          "2012-01-01",
          "2012-02-01",
          "2012-03-01",
          "2012-04-01",
          "2012-05-01",
          "2012-06-01",
          "2012-07-01",
          "2012-08-01",
          "2012-09-01",
          "2012-10-01",
          "2012-11-01",
          "2012-12-01",
          "2013-01-01",
          "2013-02-01",
          "2013-03-01",
          "2013-04-01",
          "2013-05-01",
          "2013-06-01",
          "2013-07-01",
          "2013-08-01",
          "2013-09-01",
        ], */ 
        console.log(this.chartSettings.xaxis.categories);
        this.chartOptionsCashFlow = this.chartSettings;
    }  
};
</script>

