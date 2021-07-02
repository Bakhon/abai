<template>
  <div class="chart-border_color mt-3">
    <div>
      <div class="col px-2 container-col_color">
        <apexchart
          height="255"
          :options="chartOptions"
          :series="series"
        ></apexchart>
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
          name: this.trans('economy_pf.companyValuationPage.priceBrent'),
          type: "line",
          color: '#fff',
          data: [
            20,
            29,            
          ],
        },
        {
          name: this.trans('economy_pf.companyValuationPage.currency'),
          type: "line",
          data: [
            30,
            20,            
          ],
        },
        {
          name: "Capex",
          type: "line",
          data: [
            28,
            22,            
          ],
        },
         {
          name: "Opex",
          type: "line",
          data: [
            22,
            28,            
          ],
        },
      ],
      chartOptions: {
        grid: {
        show: true,
        borderColor: '#33396f'             
        },
        stroke: {
          width: [1, 1, 4],
          show: true,
          curve: "straight",      
          colors: undefined,
          width: 2,       
        },
        title: {
          text: this.trans('economy_pf.companyValuationPage.sensitivityNPV'),
          align: "center",       
          offsetY: 15,
          style: {
            fontSize: "18px",
            fontWeight: "bold",
            fontFamily: undefined,
            color: "#fff",
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
              return y.toFixed(0) + "%";
            },              
          },
        },
        xaxis: {
          type: "datetime",
          categories: [
            "2011-01-01",
            "2011-02-01",            
          ],          
          labels: {
            rotate: -90,
          },
        },
      },
    };
  }, 
    mounted(){    
        this.chartSettings.xaxis.categories=[
            "2011-01-01",
            "2011-02-01",            
          ];    
        this.chartOptions = this.chartSettings;
    }  
};
</script>

