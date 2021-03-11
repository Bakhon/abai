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
        // annotations: [],
        chart: null,
        months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь','Июль','Август','Сентябрь', 'Октябрь','Ноябрь','Декабрь'],
        prs: [],
        layout: {
          annotations: this.annotations,
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
    let uri = "http://172.20.103.187:7574/api/nno/history/"  + wi[0] + "/" + wi[1] + "/";
    this.$emit('update:isLoading', true);
    this.axios.get(uri).then((response) => {
    this.prs = response['data']['prs']['data']
    for(let key of Object.keys(this.prs)){
      console.log(key)
      console.log(this.prs[key])
      this.data.push({x: [key], y: this.prs[key]['nno-size'], name: this.prs[key]['text'], type: 'bar'})
      // this.annotations.push({x: key, y: this.prs[key]['nno-size']+1, text: this.prs[key]['text'], showarrow: false, font: {size: 10}})
    }
    this.layout= {
        // annotations: this.annotations,
        showlegend: true,

        yaxis: {rangemode:'tozero', 
                range: [0, 3], 
                tickformat: ',d'},
        font: {color: "white"},
        plot_bgcolor: "#20274e",
        paper_bgcolor: "#20274e",
        height: 340,
        title: 'История ПРС',
        // barmode: 'group',
        bargap: 4
        }

    // for(let key of this.prs["keys"]){
    //   console.log(this.prs["data"][key])
    //   this.data.push({x: this.months, y: this.prs["data"][key], name: key, type: 'bar'})
    // }
  }).catch()
  
  .finally(() => {
      this.$emit('update:isLoading', false);
    })
}
}
</script>