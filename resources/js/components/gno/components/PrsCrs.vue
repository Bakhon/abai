<template>
  <div>
    <Plotly :data="data" :layout="layout" :display-mode-bar="false"></Plotly>
  </div>
</template>
<script>
import {Plotly} from "vue-plotly";

Vue.component("Plotly", Plotly);

export default {
props: ["wellNumber", "field", "wellIncl"],
data: function(){
    return {
        data: [],
        chart: null,
        prs: [],
        layout: {
          showlegend: false,
          yaxis: {rangemode:'tozero', 
                  autorange:true, 
                  tickformat: ',d'},
        font: {color: "white"},
        plot_bgcolor: "#20274e",
        paper_bgcolor: "#20274e",
        height: 450,
        title: 'История ПРС',
        barmode: 'group',
        },
    }
},
mounted() {
    var wi = this.wellIncl.split('_');
    let uri = "http://172.20.103.187:7575/api/nno/history/"  + wi[0] + "/" + wi[1] + "/";
    this.$emit('update:isLoading', true);
    this.axios.get(uri).then((response) => {
    this.prs = response['data']['prs']['data']
    for(let key of Object.keys(this.prs)){

      var nno_days = this.prs[key]['nno_size']

      this.data.push({x: [key], 
                      y: [nno_days*1], 
                      name: this.prs[key]['text'], 
                      type: 'bar', 
                      text: "ННО = "+nno_days+" дней",
                      textposition: 'auto',
                      hoverinfo: 'none',})
    }
    this.layout= {
        showlegend: true,
        yaxis: {rangemode:'tozero', 
                autorange: true,
                tickformat: ',d'},
                font: {color: "white"},
                plot_bgcolor: "#20274e",
                paper_bgcolor: "#20274e",
                height: 450,
                title: 'История ПРС',
                barmode: 'group',
                bargap: 4
        }
  }).catch()
  
  .finally(() => {
      this.$emit('update:isLoading', false);
    })
}
}
</script>