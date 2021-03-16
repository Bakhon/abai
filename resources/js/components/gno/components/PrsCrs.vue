<template>
  <div>
    <div v-if="!data" class="gno-modal-loading-label">Загрузка...</div>
    <div v-else-if="data.length === 0" class="gno-modal-loading-label">No data</div>

    <div v-else class="row no-margin col-12 no-padding relative gno-incl-content-wrapper">
      
      <div class="col-7 gno-plotly-graph" style="background-color: #272953;">
        <h5>Причины ПРС за скользящий год</h5>
       <Plotly style="width: 730px;" :data="data" :layout="layout" :display-mode-bar="false"></Plotly>
       <div class="row">
          <div class="col-12">
         <h5 style="float: left;">
          Количество ремонтов без ГТМ: {{numberRepairs}}
       </h5>
       </div>
       <div class="col-12">
          <h5 style="float: left;">
         ННО: {{numberNNO + ' сут'}}
       </h5>
       </div>
       </div>
      
       
      
      </div>

     <div class="col-5 no-padding no-scrollbar incl-modal-table" style="height: 100%; overflow-y: auto;">

         <h5 style="text-align: center;">Информация по КРС</h5>

      <perfect-scrollbar>
        <table class="gno-table-with-header pgno" style="height: initial;">
          <thead>
            <tr height="10" style="height: 10pt;">
              <td>
                {{trans('pgno.data_nachala_rabot')}}
              </td>
              <td>
                {{trans('pgno.data_okonchania')}}
              </td>
              <td>
                {{trans('pgno.vid_remontnih_rabot')}}
              </td>
                            
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, row_index) in this.krsTable" :key="row_index" style="font-weight: bold;">
              <td>{{row.dbeg.substring(0, 10)}}</td>
              <td>{{row.dend.substring(0, 10)}}</td>
              <td>{{row.krs_name}}</td>
            </tr>
          </tbody>
        </table>
      </perfect-scrollbar>
    </div>

    </div>
  </div>
</template>
<script>
import {Plotly} from "vue-plotly";

Vue.component("Plotly", Plotly);

export default {
props: ["wellNumber", "field", "wellIncl"],
data: function(){
    return {
        krsTable: null,
        numberRepairs: null,
        numberNNO: null,
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
    let uriPrsKrs = "http://172.20.103.187:7575/api/nno/history/"+ this.field + "/" + this.wellNumber + "/";
      this.axios.get(uriPrsKrs).then((response) => {
        let krs = response['data']['krs']
        let nno = JSON.parse(response['data']['prs']['nno'])
        this.numberRepairs = nno['prs']
        this.numberNNO = nno['NNO'].toFixed(0)
        this.krsTable = JSON.parse(krs)["data"]
    })
    var wi = this.wellIncl.split('_');
    let uri = "http://172.20.103.187:7575/api/nno/history/"  + wi[0] + "/" + wi[1] + "/";
    this.$emit('update:isLoading', true);
    this.axios.get(uri).then((response) => {
    this.prs = response['data']['prs']['data']
    console.log(this.data);
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