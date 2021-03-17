<template>
  <div>
    <div v-if="!data" class="gno-modal-loading-label">Загрузка...</div>
    <div v-else-if="data.length === 0" class="gno-modal-loading-label">No data</div>

    <div v-else
         class="row no-margin col-12 no-padding relative gno-incl-content-wrapper">
      <div class="col-6 no-padding no-scrollbar incl-modal-table" style="height: 100%; overflow-y: auto;">
        <perfect-scrollbar>
          <table
            border="1"
            cellpadding="0"
            cellspacing="0"
            width="525"
            class="gno-table-with-header incl"
          >
            <thead>
            <tr height="80" style="height: 60pt;">
              <td
                height="80"
                class="xl6321650"
                width="64"
                style="height: 60pt; width: 48pt;"
              >
                MD,м
              </td>
              <td
                class="xl6321650"
                width="64"
                style="border-left: none; width: 48pt;"
              >
                TVD, м
              </td>
              <td
                class="xl6321650"
                width="64"
                style="border-left: none; width: 48pt;"
              >
                Удл,м
              </td>
              <td
                class="xl6321650"
                width="88"
                style="border-left: none; width: 66pt;"
              >
                {{trans('pgno.zenitnii_ugol')}}, гр
              </td>
              <td
                class="xl6321650"
                width="95"
                style="border-left: none; width: 71pt;"
              >
                {{trans('pgno.azimut')}}, гр
              </td>
              <td
                class="xl6321650"
                width="160"
                style="border-left: none; width: 120pt;"
              >
                {{trans('pgno.temp_nabora_krivizni')}} (DLS), гр/10м
              </td>
            </tr>
            </thead>

            <tbody>
            <tr height="20" style="height: 15pt;" v-for="(r, i) in data" :key="i">
              <td
                height="20"
                class="xl6621650"
                style="height: 15pt; border-top: none;"
              >
                {{ r.md.toFixed(2) }}
              </td>
              <td
                class="xl6621650"
                style="border-top: none; border-left: none;"
              >
                {{ r.tvd.toFixed(2) }}
              </td>
              <td
                class="xl6621650"
                style="border-top: none; border-left: none;"
              >
                {{ r.ext.toFixed(2) }}
              </td>
              <td
                class="xl6521650"
                style="border-top: none; border-left: none;"
              >
                {{ r.incl.toFixed(2) }}
              </td>
              <td
                class="xl6621650"
                style="border-top: none; border-left: none;"
              >
                {{ r.azim.toFixed(2) }}
              </td>
              <td
                class="xl6421650"
                style="border-top: none; border-left: none;"
              >
                {{ r.dls.toFixed(2) }}
              </td>
            </tr>
            </tbody>
          </table>
        </perfect-scrollbar>
      </div>

      <div class="col-6 gno-plotly-graph" style="background-color: #2b2e5e; height: 700px;">
        <Plotly :data="chart" :layout="layout" :display-mode-bar="false"></Plotly>
        <div class="col-12" style="padding-bottom: 10px; margin-top: 50px;">
          <div class="col-6" style="float: left; text-align: left; color: white; font-weight: bold;">Выбор глубины спуска {{ this.expChoose }} <br> Нсп 
            <input style="width: 60px;" v-model="hPumpFromIncl" @change="updateHpump" type="text" onfocus="this.value=''" class="input-box-gno-incl podbor"/>
            </div>
          <button type="button col-6" class="old_well_button_incl" @click="onClickHpump">Применить выбранную Нсп</button>
        </div>
        <div class="col-12" style="padding-bottom: 10px;">
          <div class="col-12"  style="font-size: 14px; text-align: left; color: white;">
            <b>Максимальный темп набора кривизны</b> <br> в месте установки насоса 
            <input style="width: 60px;" v-model="dls_glubina" :disabled="dls_glubina" type="text" onfocus="this.value=''" class="input-box-gno-incl podbor" /> в интервале глубины спуска  
            <input style="width: 60px;" v-model="max_dls" :disabled="max_dls" type="text" onfocus="this.value=''" class="input-box-gno-incl podbor"/>    
            
            </div> 
        </div>
        <div class="col-12" style="padding-bottom: 10px;">
          <div class="col-12" style="font-size: 14px; text-align: left; color: white; float: left;">
            <b>Максимальный зенитный угол</b>  <br> в месте установки насоса
            
            <input v-model="incl_glubina" :disabled="incl_glubina" style="width: 60px;" type="text" onfocus="this.value=''" class="input-box-gno-incl podbor" />  в интервале глубины спуска 
             <input v-model="max_incl" :disabled="max_incl" style="width: 60px;" type="text" onfocus="this.value=''" class="input-box-gno-incl podbor"/> 
            </div>
        </div>


      </div>

      
    </div>
  </div>
</template>

<script>

import {Plotly} from "vue-plotly";
import {PerfectScrollbar} from "vue2-perfect-scrollbar";
import "vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css";
import { mapState } from 'vuex';


Vue.component("Plotly", Plotly);

export default {
  components: { PerfectScrollbar },
  props: ["wellNumber", "wellIncl", "isLoading","expChoose"],
  data: function () {
    return {
      data() {},
      dls1: "-",
      dls2: "-",
      zu1: "-",
      zu2: "-",
      disabled: false,
      hPumpFromIncl: null,
      buttonHpump: false,
      hVal: null,
      kraska:null,
      tmp: null,
      dzArray: null,
      dxArray: null,
      dyArray: null,
      ecn_color: null,
      dls:null,
      incl:null,
      index1:null,
      index2:null,
      max_dls:null,
      max_incl:null,
      dls_glubina:null,
      incl_glubina:null,
      xArr: null,
      yArr: null,
      zArr: null,
      indexZ: null,
      pointZ: null,
      pointX: null,
      pointY: null,
      chart: null,
      point: null,
      layout: {
        showlegend: false,
        plot_bgcolor: "#272953",
        paper_bgcolor: "#2b2e5e",
        margin: {
          l: 0,
          r: 0,
          b: 0,
          t: 0,
          pad: 0
        },
        height: 450,
        gridcolor: "white",
        font: {color: "white"},

        scene: {
          xaxis: {
            title: 'dx',
            range: [0, 0],
            gridcolor: "white",
            zerolinecolor: "white",
            hovertemplate: "<b>Кривая притока</b><br>" +
              "Qж = %{x:.1f} м³/сут<br>" +
              "Qн = %{text:.1f} т/сут<br>" +
              "Pзаб = %{y:.1f} атм<extra></extra>",
          },
          yaxis: {
            title: 'dy',
            range: [0, 0],
            gridcolor: "white",
            zerolinecolor: "white",
            hovertemplate: "<b>Кривая притока</b><br>" +
              "Qж = %{x:.1f} м³/сут<br>" +
              "Qн = %{text:.1f} т/сут<br>" +
              "Pзаб = %{y:.1f} атм<extra></extra>",
          },
          zaxis: {
            title: 'md',
            gridcolor: "white",
            zerolinecolor: "white",
            hovertemplate: "<b>Кривая притока</b><br>" +
              "Qж = %{x:.1f} м³/сут<br>" +
              "Qн = %{text:.1f} т/сут<br>" +
              "Pзаб = %{y:.1f} атм<extra></extra>",
          },
          
        }
      }
      
    }
    
  },

  methods: {
    closestVal(num, arr) {
        var curr = arr[0],
        diff = Math.abs(num * -1 - curr),
        index = 0;

          for (var val = 0; val < arr.length; val++) {
            let newdiff = Math.abs(num * -1 - arr[val]);
              if (newdiff < diff) {
                diff = newdiff;
                curr = arr[val];
                index = val;
              }
            }
            return index
        },
   updateHpump(event) {
      this.$store.commit('UPDATE_HPUMP', event.target.value)
      this.hPumpFromIncl = this.$store.getters.getHpump
      var wi = this.wellIncl.split('_');
      let uri = "http://172.20.103.187:7575/api/pgno/" + wi[0] + "/" + wi[1] + "/incl";
      this.$emit('update:isLoading', true);
      this.hPumpFromIncl = this.$store.getters.getHpump

      this.axios.get(uri).then((response) => {
        var data = JSON.parse(response.data.InclData)
        if (data.data) {
          this.data = data.data
          this.dxArray = this.data.map((r) => Math.abs(r.dx * 1))
          this.dyArray = this.data.map((r) => Math.abs(r.dy * 1))
          this.dzArray = this.data.map((r) => Math.abs(r.md * 1))
          this.xArr = this.data.map((r) => (r.dx * 1))
          this.yArr = this.data.map((r) => (r.dy * 1))
          this.zArr = this.data.map((r) => (r.md * -1))
          this.hVal = this.hPumpFromIncl.substring(0,4) * 1
          this.indexZ = this.closestVal(this.hVal, this.zArr)
          this.pointZ = this.zArr[this.indexZ]
          this.pointX = this.xArr[this.indexZ]
          this.pointY = this.yArr[this.indexZ]

          if (Math.max(...this.dxArray) < 50 && Math.max(...this.dyArray) < 50) {
            this.layout['scene']['xaxis']['range'][0] = 50
            this.layout['scene']['xaxis']['range'][1] = -50
            this.layout['scene']['yaxis']['range'][0] = 50
            this.layout['scene']['yaxis']['range'][1] = -50
          } else {
            this.layout['scene']['xaxis']['range'][0] = Math.max(...this.dxArray) * 1.5
            this.layout['scene']['xaxis']['range'][1] = Math.max(...this.dxArray) * -1.5
            this.layout['scene']['yaxis']['range'][0] = Math.max(...this.dyArray) * 1.5
            this.layout['scene']['yaxis']['range'][1] = Math.max(...this.dyArray) * -1.5
          }
          this.chart = [{
            type: 'scatter3d',
            mode: 'lines',
            x: this.data.map((r) => r.dx),
            y: this.data.map((r) => r.dy),
            z: this.data.map((r) => r.md * -1),
            text: this.data.map((r) => r.dls),
            hovertemplate:
              "MD = %{z:.1f} м<br>" +
              "DLS = %{text:.1f} гр/10м<extra></extra>",
            opacity: 1,
            line: {
              width: 12,
              color: this.data.map((r) => r.dls_color),
              colorscale: [[0, 'rgb(0,0,255)'], [1, 'rgb(255,0,0)']],
              type: 'heatmap'
            },
          },{
            type: 'scatter3d',
            mode: 'markers',
            x: [this.pointX],
            y: [this.pointY],
            z: [this.pointZ],
            marker: {
              size:10,
              color: '#AFCFEA',
            }
          }
          ],
          this.point = []
        } else this.data = [];
      }).finally(() => {
        this.$emit('update:isLoading', false);
      })
   },
   onClickHpump(){
     this.$emit('update-hpump', this.buttonHpump);
   }
  },
  mounted() {
    this.hPumpFromIncl = this.$store.getters.getHpump
    var wi = this.wellIncl.split('_');
    let uri = "http://172.20.103.187:7575/api/pgno/" + wi[0] + "/" + wi[1] + "/incl";
    this.$emit('update:isLoading', true);
    this.hPumpFromIncl = this.$store.getters.getHpump

    this.axios.get(uri).then((response) => {

      var data = JSON.parse(response.data.InclData)


      if (data.data) {
        this.data = data.data
        this.dxArray = this.data.map((r) => Math.abs(r.dx * 1))
        this.dyArray = this.data.map((r) => Math.abs(r.dy * 1))
        this.dzArray = this.data.map((r) => Math.abs(r.md * 1))
        this.ecn_color = this.data.map((r) => r.dls_color)
        this.xArr = this.data.map((r) => (r.dx * 1))
        this.yArr = this.data.map((r) => (r.dy * 1))
        this.zArr = this.data.map((r) => (r.md * -1))
        this.hVal = this.hPumpFromIncl.substring(0,4) * 1
        this.indexZ = this.closestVal(this.hVal, this.zArr)
        this.dls=this.data.map((r) => Math.round(Math.abs(r.dls * 100))/100)
        this.incl=this.data.map((r) =>Math.round(Math.abs(r.incl * 100))/100)
       

        if (this.expChoose=='ШГН'){
          this.glubina=this.hVal+10
          this.index1 = this.closestVal(this.hVal, this.zArr)
          this.index2 = this.closestVal(this.glubina, this.zArr)
        } else {
          this.glubina=this.hVal+20
          this.index1 = this.closestVal(this.hVal, this.zArr)
          this.index2 = this.closestVal(this.glubina, this.zArr)
        }

        if (this.dzArray.includes(this.glubina)){
          if(this.dzArray.includes(this.hVal)){
          }else{
            if (this.dzArray[this.index1]>this.hVal){
              this.index1=this.index1-1
            }
          }
        } else {
          if (this.dzArray[this.index2]<this.glubina){
              this.index2=this.index2+1
            }
          if(this.dzArray.includes(this.hVal)){
          }else{
            if (this.dzArray[this.index1]>this.hVal){
              this.index1=this.index1-1
            }
          }
        }

        this.dls_glubina=Math.max(...this.dls.slice(this.index1+1,this.index2+1))
        this.incl_glubina=Math.max(...this.incl.slice(this.index1+1,this.index2+1))
        this.max_dls=Math.max(...this.dls.slice(0,this.index2+1))
        this.max_incl=Math.max(...this.incl.slice(0,this.index2+1))
        
        for (const i in this.ecn_color){
          this.tmp=this.dzArray[this.closestVal(this.dzArray[i] + 20, this.zArr)]
          if (this.tmp>=this.dzArray[i] + 20){
            if (Math.max(...this.dls.slice(Number(i)+1,this.closestVal(this.dzArray[i] + 20, this.zArr)+1))>0.3){
              this.ecn_color[i]='red'
            } else if (Math.max(...this.dls.slice(Number(i)+1,this.closestVal(this.dzArray[i] + 20, this.zArr)+1))<=0.3 && Math.max(...this.dls.slice(Number(i)+1,this.closestVal(this.dzArray[i] + 20, this.zArr)+1))>0.05) {
              this.ecn_color[i]='yellow'
            } else {
              this.ecn_color[i]='green'
            }
          } else {
            if (Math.max(...this.dls.slice(Number(i)+1,this.closestVal(this.dzArray[i] + 20, this.zArr)+2))>0.3){
              this.ecn_color[i]='red'
            } else if (Math.max(...this.dls.slice(Number(i)+1,this.closestVal(this.dzArray[i] + 20, this.zArr)+2))<=0.3 && Math.max(...this.dls.slice(Number(i)+1,this.closestVal(this.dzArray[i] + 20, this.zArr)+2))>0.05) {
              this.ecn_color[i]='yellow'
            } else {
              this.ecn_color[i]='green'
            }
          }
        }
        
        if (this.expChoose=='ШГН'){
          this.kraska= this.data.map((r) => r.dls_color)
        } else {
          this.kraska=this.ecn_color
        }
        
        this.pointZ = this.zArr[this.indexZ]
        this.pointX = this.xArr[this.indexZ]
        this.pointY = this.yArr[this.indexZ]

        if (Math.max(...this.dxArray) < 50 && Math.max(...this.dyArray) < 50) {
          this.layout['scene']['xaxis']['range'][0] = 50
          this.layout['scene']['xaxis']['range'][1] = -50
          this.layout['scene']['yaxis']['range'][0] = 50
          this.layout['scene']['yaxis']['range'][1] = -50
        } else {
          this.layout['scene']['xaxis']['range'][0] = Math.max(...this.dxArray) * 1.5
          this.layout['scene']['xaxis']['range'][1] = Math.max(...this.dxArray) * -1.5
          this.layout['scene']['yaxis']['range'][0] = Math.max(...this.dyArray) * 1.5
          this.layout['scene']['yaxis']['range'][1] = Math.max(...this.dyArray) * -1.5
        }

        this.chart = [{
          type: 'scatter3d',
          mode: 'lines',
          x: this.data.map((r) => r.dx),
          y: this.data.map((r) => r.dy),
          z: this.data.map((r) => r.md * -1),
          text: this.data.map((r) => r.dls),
          hovertemplate:
            "MD = %{z:.1f} м<br>" +
            "DLS = %{text:.1f} гр/10м<extra></extra>",
          opacity: 1,
          line: {
            width: 12,
            color: this.kraska.map((r) => r),
            colorscale: [[0, 'rgb(0,0,255)'], [1, 'rgb(255,0,0)']],
            type: 'heatmap'
          },
          
        },{
          type: 'scatter3d',
          mode: 'markers',
          x: [this.pointX],
          y: [this.pointY],
          z: [this.pointZ],
          marker: {
            size:10,
            color: '#AFCFEA',
          }
        }
        ],
        this.point = []
      } else this.data = [];
    }).finally(() => {
      this.$emit('update:isLoading', false);
    })
  },
}

</script>
<style scoped>
.old_well_button_incl {
    width: 200px;
    height: 45px;
    background: #293688;
    border-radius: 8px;
    display: block;
    cursor: pointer;
    color: #ffffff;
    font-weight: bold;
    font-size: 14px;
    text-align: center;
    outline: none !important;
    box-shadow: none;
    border: none;
    margin-top: 7px;
    margin-left: 10px;
    line-height: 14px;
}

.old_well_button_incl:hover {
    background: #222d74;
}

.old_well_button_incl:active {
    outline: none !important;
    background: #1a225e;
}

.input-box-gno-incl {
    background: #494AA5;
    border: 1px solid #272953;
    outline: none;
    width: 50px;
    height: 22px;
    color: white;
    box-sizing: border-box;
    border-radius: 2px;
    line-height: 25px !important;
    padding-right: 5px;
    padding-left: 5px;
}
.square-incl {
    background: #494AA5;
    border: 1px solid #272953;
    outline: none;
    width: 100%;
    height: 22px;
    color: white;
    box-sizing: border-box;
    border-radius: 2px;
    line-height: 25px !important;
    padding-right: 5px;
    padding-left: 5px;
}
.square-incl:focus {
    background: #5657c7;
}
.input-box-gno-incl:disabled {
    color: #928f8f;
    background: #353e70;
}
</style>