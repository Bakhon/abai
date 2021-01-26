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

      <div class="col-6 gno-plotly-graph">
        <Plotly :data="chart" :layout="layout" :display-mode-bar="false"></Plotly>

      </div>
    </div>
  </div>
</template>

<script>

import {Plotly} from "vue-plotly";
import {PerfectScrollbar} from "vue2-perfect-scrollbar";
import "vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css";

Vue.component("Plotly", Plotly);

export default {
  components: { PerfectScrollbar },
  props: ["wellNumber", "wellIncl", "isLoading"],
  data: function () {
    return {
      data: null,
      chart: null,
      layout: {
        plot_bgcolor: "#20274e",
        paper_bgcolor: "#20274e",
        margin: {
          l: 0,
          r: 0,
          b: 0,
          t: 0,
          pad: 0
        },
        height: 500,
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
          }
        }
      }
    }
  },
  // watch: {
  //   isLoading: function (newVal, oldVal) {
  //     this.$emit('update:isLoading', newVal);
  //   },
  // },
  mounted() {
    var wi = this.wellIncl.split('_');
    let uri = "http://172.20.103.187:7575/api/pgno/" + wi[0] + "/" + wi[1] + "/incl";
    this.$emit('update:isLoading', true);

    this.axios.get(uri).then((response) => {

      console.log(response);
      var data = JSON.parse(response.data.InclData)

      console.log(data.data)

      if (data.data) {
        this.data = data.data
        var dxArray = this.data.map((r) => Math.abs(r.dx * 1))
        var dyArray = this.data.map((r) => Math.abs(r.dy * 1))
        if (Math.max(...dxArray) < 50 && Math.max(...dyArray) < 50) {
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
          }

        }]
      } else this.data = [];


    }).finally(() => {
      this.$emit('update:isLoading', false);
    })
  }

}

</script>
