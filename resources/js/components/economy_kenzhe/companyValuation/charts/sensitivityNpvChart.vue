<template>
  <div class="row proactive-factors-page-container">
    <div class="col-10 middle-block-columns">
      <div class="col px-2 container-col_color">
        <apexchart
          height="350"
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

  data: function () {
    return {
      series: [
        {
          name: "Цена на нефть Brent",
          type: "line",
          color: '#fff',
          data: [
            20,
            29,            
          ],
        },
        {
          name: "Курс $/Тенге",
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
        stroke: {
          width: [1, 1, 4],
          show: true,
          curve: "straight",      
          colors: undefined,
          width: 2,       
        },
        title: {
          text: "Чувствительность NPV (Паук)",
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
              toolbar: {
            show: true,
            Color: "#fff",
          },
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
          style: {
              colors: '#fff',
          },          
          labels: {
            rotate: -90,
          },
        },
      },
    };
  },
};
</script>

