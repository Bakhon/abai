<template>
  <div>
    <div v-if="!data" class="gno-modal-loading-label">{{trans('pgno.zagruzka')}}</div>
    <div v-else-if="data.length === 0" class="gno-modal-loading-label">{{trans('pgno.no_data')}}</div>

    <div v-else class="row no-margin col-12 no-padding relative gno-incl-content-wrapper">
      
      <div class="plot-block col-8 gno-plotly-graph">
        <h5>{{trans('pgno.prichini_prs_god')}}</h5>
       <Plotly style="width: 784px;" :data="data" :layout="layout" :display-mode-bar="false"></Plotly>
       <div class="row">
        <div class="col-6">
          <h5 class="title-plot">
            {{trans('pgno.number_of_repair')}}: {{numberRepairs}}
          </h5>
       </div>
       <div class="col-6">
          <h5 class="title-plot">
            {{trans('pgno.nno')}}: {{numberNNO + ' сут'}}
          </h5>
       </div>
       </div>
      
      </div>

     <div class="col-4 no-padding no-scrollbar incl-modal-table">

      <perfect-scrollbar>
        <table class="gno-table-with-header pgno">
          <thead>
            <tr height="20">
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
            <tr v-for="(row, row_index) in this.krsTable" :key="row_index">
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
        height: 491,
        title: this.trans('pgno.history_prs'),
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
    
    for(let key of Object.keys(this.prs)){
      if(this.prs[key].length!=undefined){
        for(let val of this.prs[key]){
        let nno_days = val['nno_size']
        let isNull = (val['text'] !== "");
        this.data.push({x: [key], 
                      y: [nno_days*1], 
                      name: val['text'], 
                      showlegend: isNull,
                      type: 'bar', 
                      text: nno_days,
                      textposition: 'auto',
                      hoverinfo: 'none',})
        }               
      } else{
        let nno_days = this.prs[key]['nno_size']
        let isNull = (this.prs[key]['text'] !== "");
        if(nno_days!=0){
          this.data.push({x: [key], 
                        y: [nno_days*1], 
                        name: this.prs[key]['text'], 
                        showlegend: isNull,
                        type: 'bar', 
                        text: nno_days,
                        textposition: 'auto',
                        hoverinfo: 'none',})
                      }
      }
      
    }
    console.log(this.data)
    this.layout= {
        showlegend: true,
        legend: {"orientation": "h"},
        xaxis: {
          tickfont:{
            size: 10
          }
        },
        yaxis: {rangemode:'tozero', 
                autorange: true,
                tickformat: ',d'},
                font: {color: "white"},
                plot_bgcolor: "#20274e",
                paper_bgcolor: "#20274e",
                height: 450,
                title: this.trans('pgno.history_prs'),
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
<style scoped>
.plot-block {
  background-color: #272953;
}
.title-plot {
  float: left;
  margin-left: 20px;
  margin-top: 20px;
}

.krs-table-title {
  text-align: center;
}

.incl-modal-table {
  height: 100%;
  overflow-y: auto;
}

.gno-table-with-header {
  height: initial;
}

tr {
  height: 10pt;
  font-weight: bold;
}

.incl-modal-table {
  width: 425px;
  height: 529px;
}

</style>