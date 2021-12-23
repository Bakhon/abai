<template>
  <div class="fluid-main-block">
    <div class="fluid-body-block">
      <div class="block-header pb-0 pl-2 pt-1 d-flex border-color">
        <div>
          {{ this.trans("prod-plan.material-balance-method") }}
        </div>
        <div class="d-flex">
          <div class="pr-3 pb-1">
            <img src="/img/GTM/download.svg" alt="">
          </div>
          <div class="pr-3 pb-1">
            <img src="/img/GTM/full-screen.svg" alt="">
          </div>
        </div>
      </div>
      <div class="fluid-block">
        <div class="fluid-chart">
          <Plotly :data="matBalData" :layout="layout" :display-mode-bar="false"></Plotly>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { Plotly } from "vue-plotly";
import {getMatBalanceData} from "../api/baseProdForecast";

export default {
  components: {
    Plotly
  },
  data: function () {
    return {
      url: 'http://172.20.103.67:5010/content',
      lineChartSeries: [],
      matBalData: [],
      layout: {
        autosize: true,
        shapes: [{
          type: 'line',
        }],
        height: 810,
        xaxis: {
          title: '',
          gridcolor: "#454D7D",
          linewidth: 1,
          linecolor: "#454D7D"
        },
        yaxis: {
          title: `${this.trans('prod-plan.volume')}`,
          showline: true,
          linecolor: "#454D7D"
        },
        yaxis2: {
          title: `${this.trans('prod-plan.accumulated-oil-production')}`,
          showline: true,
          gridcolor: "#454D7D",
          linewidth: 1,
          linecolor: "#454D7D",
          range: [0, 300],
          overlaying: 'y',
          side: 'right'
        },
        paper_bgcolor: "#272953",
        plot_bgcolor: "#272953",
        font: {
          color: "#fff",
          size: 14
        },
        legend: {
          orientation: "h",
          font: {
            size: 16,
            color: "#fff",
          },
        },
      },
    }
  },
  methods: {
    async getMatBalData() {
      let body = {url: this.url}
      await getMatBalanceData(body).then((res) => {
        this.matBalData = [
          {
            name: `${this.trans('prod-plan.accumulated-oil-production')}`,
            hovertemplate: `<b>${this.trans('prod-plan.accumulated-oil-production')} = %{y}</b><extra></extra>`,
            x: Object.values(res.date),
            y: Object.values(res.oil_v_acc),
            type: 'lines',
            line: {
              size: "15",
              color: "#17955f",
            },
          },
          {
            name: `${this.trans('prod-plan.injection-accumulated')}`,
            hovertemplate: `<b>${this.trans('prod-plan.injection-accumulated')} = %{y}</b><extra></extra>`,
            x: Object.values(res.date),
            y: Object.values(res.inj_v_acc),
            type: 'lines'
          },
          {
            name: `${this.trans('prod-plan.measurement-pressure')}`,
            hovertemplate: `<b>${this.trans('prod-plan.measurement-pressure')} = %{y}</b><extra></extra>`,
            x: Object.values(res.date),
            y: Object.values(res.p_fact),
            yaxis: 'y2',
            mode: 'markers',
            marker: {
              size: 15,
              color: '#c0504d'
            }
          },
          {
            name: `${this.trans('prod-plan.saturation-pressure')}`,
            hovertemplate: `<b>${this.trans('prod-plan.saturation-pressure')} = %{y}</b><extra></extra>`,
            x: Object.values(res.date),
            y: Object.values(res.p_sat),
            yaxis: 'y2',
            mode: 'lines',
            line: {
              dash: 'dot',
              width: 4
            }
          },
          {
            name: `${this.trans('prod-plan.design-pressure')}`,
            hovertemplate: `<b>${this.trans('prod-plan.design-pressure')} = %{y}</b><extra></extra>`,
            x: Object.values(res.date),
            y: Object.values(res.p_calc),
            yaxis: 'y2',
            mode: 'lines',
            line: {
              color: 'rgb(55, 128, 191)',
            }
          }
        ]
      })
    }
  },
  created() {
    this.getMatBalData()
  }
}
</script>
<style scoped>
.fluid-body-block {
  background-color: #0c2e5a;
  width: 100%;
  height: 100%;
}

.fluid-main-block {
  width: 100%;
  height: 100%;
}

.fluid-block {
  background-color: #363B68;
  border: 1px solid #545580;
  width: 100%;
  height: 95%;
  padding: 6px;
}

.fluid-chart {
  width: 100%;
  height: 100%;
  background: #1A214A;
}

.block-header {
  height: 5%;
  background-color: #323370;
}
</style>