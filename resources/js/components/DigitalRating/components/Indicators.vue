<template>
  <div class="rating-indicators">
    <div class="d-flex mb-20px">
      <table class="table text-center text-white rating-table w-50 mb-0">
        <thead>
          <tr>
            <th class="align-middle" v-for="col in colsIndicator" :key="col.name">
              {{ col.title }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in indicators" :key="index">
            <td v-for="(col, colIdx) in colsIndicator" :key="colIdx">
              <span>{{ item[col.name] }}</span>
            </td>
          </tr>
        </tbody>
      </table>
      <Plotly
        :data="data"
        :layout="layout"
        :display-mode-bar="false"
        :displaylogo="false"
      />
    </div>
    <div class="d-flex">
      <table class="table text-center text-white rating-table w-50 mb-0">
        <thead>
          <tr>
            <th class="align-middle" v-for="col in secondColsIndicators" :key="col.name">
              {{ col.title }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in secondIndicators" :key="index">
            <td v-for="(col, colIdx) in secondColsIndicators" :key="colIdx">
              <span>{{ item[col.name] }}</span>
            </td>
          </tr>
        </tbody>
      </table>
      <Plotly
          :data="data"
          :layout="layout"
          :display-mode-bar="false"
          :displaylogo="false"
      />
    </div>
  </div>
</template>

<script>
import { indicators, secondIndicators } from '../json/data';
import { Plotly } from 'vue-plotly';

export default {
  name: "Indicators",

  components: {
    Plotly
  },

  data() {
    return {
      indicators: indicators,
      secondIndicators: secondIndicators,
      data:[{
        x: [2015, 2016, 2017, 2018, 2019, 2020, 2021],
        y: [200,400,600,800,1000,1200,1400],
        type:"scatter"
      }],
      layout: {
        height: 320,
        showlegend: true,
        margin: {
          pad: 10
        },
        xaxis: {
          title: "",
          zeroline: false,
          gridcolor: "#3C4270",
        },
        yaxis: {
          title: "Добыча жидкости,м3.Добыча нефти, т",
          showlegend: true,
          zeroline: false,
          gridcolor: "#3C4270",
          rangemode: 'tozero'
        },

        paper_bgcolor: "#2B2E5E",
        plot_bgcolor: "#2B2E5E",
        font: { color: "#fff" },

        legend: {
          orientation: "h",
          y: -0.3,
          font: {
            size: 9.3,
            color: "#fff",
          },
        },
      },
    }
  },

  computed: {
    colsIndicator() {
      return [
        {
          title: this.trans('digital_rating.wellNumber'),
          name: 'number'
        },
        {
          title: this.trans('digital_rating.liquidFlowRate'),
          name: 'liquid'
        },
        {
          title: `${this.trans('digital_rating.waterCut')}, %`,
          name: 'water'
        },
        {
          title: `${this.trans('digital_rating.oilFlowRate')}, ${this.trans('digital_rating.tonDay')}`,
          name: 'oil'
        },
        {
          title: `${this.trans('digital_rating.dynamicLevel')}, м`,
          name: 'level'
        }
      ]
    },
    secondColsIndicators() {
      return [
        {
          title: this.trans('digital_rating.wellNumber'),
          name: 'number'
        },
        {
          title: `${this.trans('digital_rating.throttleResponse')}, ${this.trans('digital_rating.cubeDay')}`,
          name: 'response'
        },
        {
          title: `${this.trans('digital_rating.injectionPressure')}, атм`,
          name: 'pressure'
        },
        {
          title: `${this.trans('digital_rating.distance')}, м`,
          name: 'distance'
        },
        {
          title: `${this.trans('digital_rating.stitchDiameter')}, мм`,
          name: 'diameter'
        }
      ]
    }
  }
}
</script>

<style scoped lang="scss">
.rating-indicators {
  width: 100%;
  color: #fff;
}
.rating-indicators__title {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
}
</style>
