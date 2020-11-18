<template>
  <Plotly
    :data="data"
    :layout="layout"
    :display-mode-bar="false"
    :config="config"
  ></Plotly>
</template>

<script>
//
import { Plotly } from "vue-plotly";
import { EventBus } from "../../event-bus.js";
Vue.component("Plotly", Plotly);
export default {
  name: "mix-chart",
  data: function () {
    return {
      /*  rendererOptions: {
plotlyConfig: {
responsive: true,
displayModeBar: true
},},*/
      config: { responsive: true },
      layout: { 
        autosize: true,
        width: 780,
        height: 545,
        //      showlegend: false,    
        xaxis: {
            type: 'date',
            tickformat: '%d. %m. %Y',
          /*range:[new Date('2020, 01, 1').getTime(),
          new Date('2020, 01, 5').getTime()],*/
             
         // hoverformat: ".1f",
          showline: false,
          zeroline: false ,
          showgrid: false,
          // mirror:true,
          // ticklen: 4,
          gridcolor: "#123E73",
          tickfont: { size: 10 },
        },
        yaxis: {
          // rangemode: "tozero",
          hoverformat: ".1f",
          // showline: true,
          zeroline: false,
          //showgrid: true,
          // mirror:true,
          // ticklen: 4,
          gridcolor: "#123E73",
          tickfont: { size: 10 },
        },

        //   scene:{ gridcolor: '#ffffff',},
        paper_bgcolor: "#272953",
        //paper_bgcolor: "#20274e",
        plot_bgcolor: "#272953",
        font: { color: "#fff" },

        legend: {
          orientation: "h",
          //y: -3.8,
          font: {
            size: 12,
            color: "#fff",
          },
        },
      },

      data: [
        {
          x: [1, 2, 3, 4],
          y: [10, 15, 13, 17],
          mode: "scatter",
        },
      ],
    };
  },
  methods: {
    setValue: function (value) {
  //    console.log(value);   
      var mode;
      var productionFactForChart = new Array();
      _.forEach(value, function (item) {
        productionFactForChart.push(item.productionFactForChart);
      });

      var productionPlanForChart = new Array();
      _.forEach(value, function (item) {
        productionPlanForChart.push(item.productionPlanForChart);
      });

    var quantity2 = new Array();
      _.forEach(value, function (item) {
        quantity2.push(item.time);
        //quantity2.push(new Date(Number(item.time)).toLocaleDateString());
      });

      //console.log(quantity2);
       // console.log(productionPlanForChart);


      var quantity = value.length;

    /*  var quantity2 = [];
      for (let i = 1; i <= quantity; i++) {
        quantity2.push(i);
      }*/

      if (quantity <= 1) {
        mode = "markers";
      } else {
        mode = "lines";
      }

      this.data = [
      
         
        {
          name: "План",
           x :quantity2,
         // x: ['2013-10-04 22:23:00', '2013-11-04 22:23:00', '2013-12-04 22:23:00'],//quantity2,
          y: productionPlanForChart,
          mode: mode,

          marker: {
            size: "20",
            color: "#a0a7cb",
          },
        },
        {
          name: "Факт",

           x :quantity2,
         // x: ['1', '2', '3','5','10'],
        //  x: ['2013-10-04 22:23:00', '2013-11-04 22:23:00', '2013-12-04 22:23:00'],//quantity2,
          y: productionFactForChart,
          mode: mode,

          marker: {
            size: "20",
            color: "#2e50ea",
          },
        },
       
      ];
    },
  },

  mounted() {},
  created: function () {
    this.$parent.$on("data", this.setValue);
  },
};
</script>
