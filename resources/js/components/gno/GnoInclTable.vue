<template>
    <div v-if="!data">Loading...</div>
    <div v-else-if="data.length === 0">No data</div>

    <div v-else class="row col-12 relative" style="height: 100%;">
        <div class="col-6" style="height: 100%; overflow-y: auto;">
            <table
    border="1"
    cellpadding="0"
    cellspacing="0"
    width="525"
    style="
      border-collapse: collapse;
      table-layout: fixed;
      width: 401pt;
      font-size: 10px;
    "

  >
    <col width="64" span="3" style="width: 48pt;" />
    <col
      width="88"
      style="
        mso-width-source: userset;
        mso-width-alt: 3218;
        width: 66pt;
      "
    />
    <col
      width="95"
      style="
        mso-width-source: userset;
        mso-width-alt: 3474;
        width: 71pt;
      "
    />
    <col
      width="160"
      style="
        mso-width-source: userset;
        mso-width-alt: 5851;
        width: 120pt;
      "
    />
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
        Зенитный угол, гр
      </td>
      <td
        class="xl6321650"
        width="95"
        style="border-left: none; width: 71pt;"
      >
        Азимут, гр
      </td>
      <td
        class="xl6321650"
        width="160"
        style="border-left: none; width: 120pt;"
      >
        Темп набора пространственной кривизны, (DLS), гр/10м
      </td>
    </tr>


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
        {{ r.tvd.toFixed(2)}}
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
        {{ r.dls.toFixed(2)}}
      </td>
    </tr>


    <tr height="0" style="display: none;">
      <td width="64" style="width: 48pt;"></td>
      <td width="64" style="width: 48pt;"></td>
      <td width="64" style="width: 48pt;"></td>
      <td width="88" style="width: 66pt;"></td>
      <td width="95" style="width: 71pt;"></td>
      <td width="160" style="width: 120pt;"></td>
    </tr>
  </table>

        </div>

        <div class="col-6" >
             <Plotly :data="chart" :layout="layout" :display-mode-bar="false"></Plotly>

        </div>
    </div>

</template>

<script>

import { Plotly } from "vue-plotly";
Vue.component("Plotly", Plotly);

export default {
  props:["wellNumber", "wellIncl"],
  data: function () {
    return {
        data:null,
        chart:null,
        layout:{
            margin: {
                l: 0,
                r: 0,
                b: 0,
                t: 0,
                pad: 0
            },
            height:500,
            scene: {
                xaxis: {title: 'dx',
                        range: [0, 0]
                },
                yaxis: {title: 'dy',
                        range: [0, 0]
                },
                zaxis: {title: 'md'}
            }
        }
    }
  },

  mounted(){
    var wi = this.wellIncl.split('_');
    let uri = "http://172.20.103.187:7575/api/pgno/" + wi[0] + "/" + wi[1] + "/incl";
    this.axios.get(uri).then((response) => {

        console.log(response);
        var data = JSON.parse(response.data.InclData)

        console.log(data.data)

        if (data.data) {
            this.data = data.data
            var dxArray = this.data.map((r) => Math.abs(r.dx * 1))
            var dyArray = this.data.map((r) => Math.abs(r.dy * 1))
            if(Math.max(...dxArray) < 50 && Math.max(...dyArray) < 50) {
            this.layout['scene']['xaxis']['range'][0] = 50
            this.layout['scene']['xaxis']['range'][1] = -50
            this.layout['scene']['yaxis']['range'][0] = 50
            this.layout['scene']['yaxis']['range'][1] = -50
            } else {
            this.layout['scene']['xaxis']['range'][0] = Math.max(...dxArray) * 1.5
            this.layout['scene']['xaxis']['range'][1] = Math.max(...dxArray) * -1.5
            this.layout['scene']['yaxis']['range'][0] = Math.max(...dyArray) * 1.5
            this.layout['scene']['yaxis']['range'][1] = Math.max(...dyArray) * -1.5
            }
            this.chart = [{
                type: 'scatter3d',
                mode: 'lines',
                x: this.data.map((r) => r.dx),
                y: this.data.map((r) => r.dy),
                z: this.data.map((r) => r.md * -1),
                opacity: 1,
                line:{
                    width: 12,
                    color: this.data.map((r) => r.dls_color),
                    colorscale: [[0, 'rgb(0,0,255)'], [1, 'rgb(255,0,0)']],
                    type: 'heatmap'
                }

            }]
        } else this.data = [];


    })
  }

}

</script>
