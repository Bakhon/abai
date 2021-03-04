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

      <div class="col-6 gno-plotly-graph" style="background-color: #2b2e5e; height: 545px;">
        <Plotly :data="chart" :layout="layout" :display-mode-bar="false"></Plotly>
        <div class="col-12" style="padding-bottom: 10px; margin-top: 50px;">
          <div class="col-12" style="float: left; text-align: left; color: white; font-weight: bold;">Выбор глубины спуска насоса Нсп 
            <input style="width: 100px;" v-model="hPumpFromIncl" @change="updateHpump" type="text" onfocus="this.value=''" class="input-box-gno podbor"/>
            </div>
          <!-- <div class="col-6" style="float: left; text-align: left; color: white; height: 25px;">
            Нсп 800м
          </div> -->
          <!-- <button type="button" class="old_well_button_incl" @click="onClickHpump">Применить выбранную Нсп</button> -->
        </div>
        <div class="col-12" style="padding-bottom: 10px;">
          <div class="col-12"  style="font-size: 14px; text-align: left; color: white;">
            <b>Максимальный темп набора кривизны</b> в месте установки насоса 0.3гр/10м в интервале глубины спуска 0.5 гр/10м
          </div> 
        </div>
        <!-- <div class="col-12" style="padding-bottom: 10px;">
          <div class="col-12"  style="font-size: 14px; text-align: left; color: white;">
            в месте установки насоса 0.3гр/10м в интервале глубины спуска 0.5 гр/10м
          </div> 
        </div> -->
        <div class="col-12" style="padding-bottom: 10px;">
          <div class="col-12" style="font-size: 14px; text-align: left; color: white; float: left;"><b>Максимальный зенитный угол</b> в месте установки насоса 2 гр/10м в интервале глубины спуска 3 гр/10м
          </div>
          <!-- <button type="button" class="old_well_button_incl">Применить выбранную НГЛ</button> -->
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
  props: ["wellNumber", "wellIncl", "isLoading"],
  data: function () {
    return {
      hPumpFromIncl: null,
      buttonHpump: false,
      hVal: null,
      dzArray: null,
      dxArray: null,
      dyArray: null,
      xArr: null,
      yArr: null,
      zArr: null,
      indexZ: null,
      pointZ: null,
      pointX: null,
      pointY: null,
      data () {
        return {
          
        }
      },
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
        height: 350,
        gridcolor: "white",
        font: {color: "white"},
        // xaxis: {
        //   tickcolor: "white",
        //   gridcolor: "white",
        //   linewidth: 1,
        // },
        // yaxis: {
        //   tickcolor: "white",
        //   gridcolor: "white",
        //   linewidth: 1,
        // },
        // zaxis: {
        //   tickcolor: "white",
        //   gridcolor: "white",
        //   linewidth: 1,
        // },

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
          // console.log(this.xArr, 'x')
          // console.log(this.yArr, 'y')
          // console.log(this.zArr, 'z')


          // 
        this.indexZ = this.closestVal(this.hVal, this.zArr)
        // console.log(this.indexZ);


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
              color: 'white',
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
     this.buttonHpump = true
     this.$store.commit('UPDATE_HPUMP_BUTTON', this.buttonHpump)
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
        this.xArr = this.data.map((r) => (r.dx * 1))
        this.yArr = this.data.map((r) => (r.dy * 1))
        this.zArr = this.data.map((r) => (r.md * -1))
        this.hVal = this.hPumpFromIncl.substring(0,4) * 1
        // console.log(this.xArr, 'x')
        // console.log(this.yArr, 'y')
        // console.log(this.zArr, 'z')


        // 
      this.indexZ = this.closestVal(this.hVal, this.zArr)
      // console.log(this.indexZ);

        
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
            color: 'white',
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
    vertical-align: middle;
}

.old_well_button_incl:hover {
    background: #222d74;
}

.old_well_button_incl:active {
    outline: none !important;
    background: #1a225e;
}

.input-box-gno {
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
</style>