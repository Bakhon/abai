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
          <tr v-for="(item, index) in indicators.df_prod_sum_well" :key="index">
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
        :data="this.injDiagramIndicators"
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
          <tr v-for="(item, index) in indicators.df_inj_sum_well" :key="index">
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
        :data="this.injDiagramIndicators"
        :layout="layout"
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

    async mounted() {
      await this.fetchIndicators({});
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
        'prodDiagramIndicators'
      ]),
      getInjIndicators() {
        return this.indicators?.df_inj_sum_well?.length;
      },
      getProdIndicators() {
        return this.indicators?.df_prod_sum_well?.length
      },
      colsIndicator() {
        return [
          {
            title: this.trans('digital_rating.wellNumber'),
            name: 'well'
          },
          {
            title: this.trans('digital_rating.liquidFlowRate'),
            name: 'avg_liquid_rate'
          },
          {
            title: `${this.trans('digital_rating.waterCut')}, %`,
            name: 'avg_wc'
          },
          {
            title: `${this.trans('digital_rating.oilFlowRate')}, ${this.trans('digital_rating.tonDay')}`,
            name: 'avg_oil_rate'
          },
          {
            title: `${this.trans('digital_rating.dynamicLevel')}, м`,
            name: 'h_dyn'
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
            name: 'avg_injection'
          },
          {
            title: `${this.trans('digital_rating.injectionPressure')}, атм`,
            name: 'pressure'
          },
          {
            title: `${this.trans('digital_rating.distance')}, м`,
            name: 'distance'
          },
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
  .warning-empty {
    position: absolute;
    width: 50%;
    margin-top: 20px;
    font-size: 20px;
  }
</style>
