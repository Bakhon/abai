<template>
  <div class="rating-indicators">
    <div class="d-flex align-items-start mb-20px">
      <table class="table text-center text-white rating-table mb-0" style="width: 55%">
        <thead>
          <tr>
            <th class="align-middle" v-for="col in colsIndicator" :key="col.name">
              {{ col.title }}
            </th>
          </tr>
        </thead>
        <tbody v-if="getProdIndicators">
          <tr v-for="(item, index) in indicators.prod_table" :key="index">
            <td v-for="(col, colIdx) in colsIndicator" :key="colIdx">
              <span>{{ item[col.name] }}</span>
            </td>
          </tr>
        </tbody>
        <div v-else class="warning-empty">
          <p>{{ trans('app.thereIsNoData') }}</p>
        </div>
      </table>
      <Plotly
        :data="[this.liguidDiagramIndicators, this.oilProdDiagramIndicators]"
        :layout="layout"
        :display-mode-bar="false"
        :displaylogo="false"
        style="width: 45%"
      />
    </div>
    <div class="d-flex align-items-start">
      <table class="table text-center text-white rating-table mb-0" style="width: 55%">
        <thead>
          <tr>
            <th class="align-middle" v-for="col in secondColsIndicators" :key="col.name">
              {{ col.title }}
            </th>
          </tr>
        </thead>
        <tbody v-if="getInjIndicators">
          <tr v-for="(item, index) in indicators.inj_table" :key="index">
            <td v-for="(col, colIdx) in secondColsIndicators" :key="colIdx">
              <span>{{ item[col.name] }}</span>
            </td>
          </tr>
        </tbody>
        <div v-else class="warning-empty">
          <p>{{ trans('app.thereIsNoData') }}</p>
        </div>
      </table>
      <Plotly
        :data="[this.injDiagramIndicators]"
        :layout="layoutInj"
        :display-mode-bar="false"
        :displaylogo="false"
        style="width: 45%"
      />
    </div>
  </div>
</template>

<script>
  import { Plotly } from 'vue-plotly';
  import { digitalRatingState, digitalRatingActions, digitalRatingGetters } from '@store/helpers';

  export default {
    name: "Indicators",

    components: {
      Plotly
    },
    data() {
      return {
        dataInj: [],
        dataProd: [],
        generalSettings: {
          height: 320,
          showlegend: true,
          margin: {
            pad: 10
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
          xaxis: {
            title: "",
            zeroline: false,
            gridcolor: "#3C4270",
          },
        },
      }
    },

    async mounted() {
      if (!this.indicators) {
        await this.fetchIndicators({});
      }
    },

    methods: {
      ...digitalRatingActions([
          'fetchIndicators',
      ]),
    },

    computed: {
      ...digitalRatingState([
        'indicators',
        'prodDiagramIndicators'
      ]),
      ...digitalRatingGetters([
        'injDiagramIndicators',
        'liguidDiagramIndicators',
        'oilProdDiagramIndicators'
      ]),
      getInjIndicators() {
        return this.indicators?.inj_table?.length;
      },
      getProdIndicators() {
        return this.indicators?.prod_table?.length
      },
      colsIndicator() {
        return [
          {
            title: this.trans('digital_rating.wellNumber'),
            name: 'well'
          },
          {
            title: this.trans('digital_rating.liquidFlowRate'),
            name: 'avg_liq'
          },
          {
            title: `${this.trans('digital_rating.waterCut')}, %`,
            name: 'avg_wc'
          },
          {
            title: `${this.trans('digital_rating.oilFlowRate')}, ${this.trans('digital_rating.tonDay')}`,
            name: 'avg_oil'
          },
          {
            title: `${this.trans('digital_rating.dynamicLevel')}, м`,
            name: 'h_dyn'
          },
          {
            title: `${this.trans('digital_rating.distance')}, м`,
            name: 'dist'
          }
        ]
      },
      secondColsIndicators() {
        return [
          {
            title: this.trans('digital_rating.wellNumber'),
            name: 'well'
          },
          {
            title: `${this.trans('digital_rating.throttleResponse')}, ${this.trans('digital_rating.cubeDay')}`,
            name: 'avg_inj'
          },
          {
            title: `${this.trans('digital_rating.injectionPressure')}, атм`,
            name: 'injection_pressure'
          },
          {
            title: `${this.trans('digital_rating.distance')}, м`,
            name: 'dist'
          },
        ]
      },

      layout() {
        return {
          ...this.generalSettings,
          yaxis: {
            title: "Добыча жидкости,м3",
          },
          yaxis2: {
            title: 'Добыча нефти, т',
            anchor: 'x',
            overlaying: 'y',
            side: 'right',
          }
        }
      },

      layoutInj() {
        return {
          ...this.generalSettings,
          yaxis: {
            title: "Приемистость, м3",
            showlegend: true,
            zeroline: false,
            gridcolor: "#3C4270",
            rangemode: 'tozero'
          },
        }
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
  .warning-empty {
    position: absolute;
    width: 50%;
    margin-top: 20px;
    font-size: 20px;
  }
  .rating-table {
    height: 320px;
  }
</style>
