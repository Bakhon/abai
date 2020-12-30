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
        months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь','Июль','Август','Сентябрь', 'Октябрь','Ноябрь','Декабрь'],
        prs: [],
        layout: {
        font: {color: "white"},
        plot_bgcolor: "#20274e",
        paper_bgcolor: "#20274e",
        height: 340,
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
    this.prs = response['data']['prs']
    // this.months = response['months']
    console.log(this.prs['keys'])
    // this.data = [{
    // type: 'bar',
    // x: ["2015-01-01", "2015-02-01", "2015-03-01", "2015-04-01", "2015-05-01", "2015-06-01", "2015-07-01", "2015-08-01", "2015-09-01", "2015-10-01", "2015-11-01", "2015-12-01"],
    // y: [1.5, 2.3, 3.5, 1.2, 0.4, 3.1, 1.5, 2.3, 3.5, 1.2, 0.4, 3.1,],
    // }]

    for(let key of this.prs["keys"]){
      console.log(this.prs["data"][key])
      this.data.push({x: this.months, y: this.prs["data"][key], name: key, type: 'bar'})
    }
  }).catch()
  
  .finally(() => {
      this.$emit('update:isLoading', false);
    })
}
}
</script>