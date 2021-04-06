<template>
  <div>
    <div class="bd-popup bd-popup_wide">
      <div class="bd-popup__inner">
        <a class="bd-popup__close" href="#" @click.prevent="$emit('close')">{{ trans('bd.close') }}</a>
        <p class="bd-popup__title">{{ title }}</p>
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
        <div class="graph">
          <Plotly :data="graphData"
                  :display-mode-bar="true"
                  :displaylogo="false"
                  :mode-bar-buttons-to-remove="buttonsToRemove"
                  :layout="layout"
                  :options="options"
          />
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
        grid: {rows: 2, columns: 1, pattern: 'independent'},
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

      let result = {};
      this.formParams.columns.filter(item => this.params.graph.columns.indexOf(item.code) > -1).forEach(column => {
        result[column.code] = {
          name: this.trans(column.title),
          type: 'line',
          x: [],
          y: []
        }
      })

      for (let date in this.params.graph.rows) {
        this.params.graph.columns.forEach(column => {
          if (this.params.graph.rows[date][column]) {
            result[column].x.push(moment(date, 'DD.MM.YYYY').format('YYYY-MM-DD'))
            result[column].y.push(this.params.graph.rows[date][column].value)
          }
        })
      }
      return Object.values(result)
    },
    title() {
      let column = this.formParams.columns.find(item => item.code === this.params.selectedColumn)
      return column.history_popup.title
    }
  }
}
</script>
<style lang="scss">
.bd-popup {
  &_wide {
    .bd-popup__inner {
      max-width: 1485px;
      width: calc(100% - 130px);
    }
  }

  .table-page {
    &.table-page_fixed {
      height: 200px;
      overflow: auto;
    }

    .table {
      width: auto;
    }
  }

  .graph {
    margin-top: 15px;

    .selector-rect {
      fill: #2E50E9 !important;
    }
  }
}
</style>