<template>
  <div>
    <div class="bd-popup bd-popup_wide">
      <div class="bd-popup__inner">
        <a class="bd-popup__close" href="#" @click.prevent="$emit('close')">{{ trans('bd.close') }}</a>
        <p class="bd-popup__title">{{ title }}</p>
        <div class="bd-popup__content">
          <div class="graph">
            <Plotly
                v-for="(data, index) in graphData"
                :key="`plot_${index}`"
                :data="Object.values(data)"
                :display-mode-bar="true"
                :displaylogo="false"
                :layout="layout"
                :mode-bar-buttons-to-remove="buttonsToRemove"
            />
          </div>
          <div class="table-page table-page_fixed scrollable">
            <table class="table">
              <thead>
              <tr>
                <th>{{ trans('bd.date') }}</th>
                <th v-for="column in tableColumns">
                  {{ column.title }}
                </th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="(fields, date) in params.table.rows">
                <td>{{ fields[tableColumns[0].code] === null ? date : fields[tableColumns[0].code].time }}</td>
                <td v-for="column in tableColumns">
                  {{ fields[column.code] === null ? '' : fields[column.code].value }}
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment'
import {bdFormState} from '@store/helpers'
import {Plotly} from 'vue-plotly'

export default {
  props: {
    params: {
      type: Object,
      required: true
    },
  },
  data() {
    return {
      buttonsToRemove: [
        'zoom2d',
        'pan2d',
        'select2d',
        'lasso2d',
        'zoomIn2d',
        'zoomOut2d',
        'autoScale2d',
        'resetScale2d',
        'hoverClosestCartesian',
        'hoverCompareCartesian',
        'toggleSpikelines'
      ],
      layout: {
        bargap: 0.05,
        bargroupgap: 0.2,
        barmode: "overlay",
        height: 410,
        margin: {
          l: 30,
          r: 0,
          b: 0,
          t: 30
        },
        showlegend: true,
        xaxis: {
          title: '',
          gridcolor: "#454D7D",
          linewidth: 1,
          linecolor: "#454D7D",
          rangeselector: {
            buttons: [{
              step: 'week',
              stepmode: 'backward',
              count: 1,
              label: `1 ${this.trans('bd.week')}`
            }, {
              step: 'month',
              stepmode: 'backward',
              count: 1,
              label: `1 ${this.trans('bd.month')}`
            }, {
              step: 'month',
              stepmode: 'backward',
              count: 3,
              label: `3 ${this.trans('bd.month_1')}`
            }, {
              step: 'month',
              stepmode: 'backward',
              count: 6,
              label: `6 ${this.trans('bd.month_2')}`
            }, {
              step: 'year',
              stepmode: 'backward',
              count: 1,
              label: `1 ${this.trans('bd.year')}`
            }, {
              step: 'all',
              label: this.trans('bd.all')
            }],
          },
          rangeslider: {}
        },
        yaxis: {
          title: '',
          hoverformat: ".1f",
          showline: true,
          gridcolor: "#454D7D",
          linewidth: 1,
          linecolor: "#454D7D",
          fixedrange: true
        },
        yaxis2: {
          title: '',
          showline: true,
          gridcolor: "#454D7D",
          linewidth: 1,
          linecolor: "#454D7D",
          fixedrange: true,
          overlaying: 'y',
          side: 'right'
        },
        yaxis3: {
          title: '',
          showline: true,
          gridcolor: "#454D7D",
          linewidth: 1,
          linecolor: "#454D7D",
          fixedrange: true,
          overlaying: 'y',
          side: 'right'
        },
        yaxis4: {
          title: '',
          showline: true,
          gridcolor: "#454D7D",
          linewidth: 1,
          linecolor: "#454D7D",
          fixedrange: true,
          overlaying: 'y',
          side: 'right'
        },
        paper_bgcolor: "#272953",
        plot_bgcolor: "#272953",
        font: {color: "#fff"}
      }
    }
  },
  components: {
    Plotly
  },
  computed: {
    ...bdFormState([
      'formParams'
    ]),
    tableColumns() {
      return this.formParams.columns.filter(item => this.params.table.columns.indexOf(item.code) > -1)
    },
    graphData() {

      let columnCodes = []
      this.params.graph.columns.forEach(block => {
        columnCodes = [...columnCodes, ...Object.keys(block)]
      })

      let plots = {}
      let plotIndex = 1
      this.params.graph.columns.forEach(block => {
        plots[plotIndex] = {}
        let yAxisIndex = 0
        for (let columnCode in block) {
          let column = this.formParams.columns.find(item => item.code === columnCode)

          if (block[columnCode].axis) {
            yAxisIndex++
          }

          let data = {
            name: this.trans(column.title),
            type: 'line',
            x: [],
            y: []
          }

          if (yAxisIndex > 0) {
            data.yaxis = `y${yAxisIndex}`
          }

          plots[plotIndex][column.code] = data
        }
        plotIndex++
      })
      return this.fillValues(plots)
    },
    title() {
      let column = this.formParams.columns.find(item => item.code === this.params.selectedColumn)
      return column.history_popup.title
    }
  },
  methods: {
    fillValues(plots) {
      for (let date in this.params.graph.rows) {
        let plotIndex = 1;
        this.params.graph.columns.forEach(block => {
          for (let columnCode in block) {
            if (this.params.graph.rows[date][columnCode]) {
              plots[plotIndex][columnCode].x.push(moment(date, 'DD.MM.YYYY').format('YYYY-MM-DD'))
              plots[plotIndex][columnCode].y.push(this.params.graph.rows[date][columnCode].value)
            }
          }
          plotIndex++
        })
      }
      return plots
    }
  }
}
</script>
<style lang="scss">
.selector-rect {
  fill: #2E50E9 !important;
}
</style>
<style lang="scss" scoped>
.bd-popup {
  &_wide {
    .bd-popup__inner {
      max-width: 1485px;
      width: calc(100% - 130px);
    }
  }

  .table-page {
    width: 30%;

    &.table-page_fixed {
      height: 410px;
      overflow: auto;
    }

    .table {
      width: auto;
    }
  }

  .graph {
    margin-top: 15px;
    width: 65%;

  }

  &__content {
    display: flex;
    justify-content: space-between;
  }
}
</style>