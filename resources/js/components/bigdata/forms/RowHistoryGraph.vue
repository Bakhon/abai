<template>
  <div>
    <div class="bd-popup bd-popup_wide">
      <div class="bd-popup__inner">
        <a class="bd-popup__close" href="#" @click.prevent="$emit('close')">Закрыть</a>
        <p class="bd-popup__title">Данные телеметрии по скважине</p>
        <div class="table-page table-page_fixed">
          <table class="table">
            <thead>
            <tr>
              <th>Дата</th>
              <th v-for="column in tableColumns">
                {{ column.title }}
              </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(fields, date) in params.table.rows">
              <td>{{ date }}</td>
              <td v-for="column in tableColumns">
                {{ fields[column.code] === null ? '' : fields[column.code].value }}
              </td>
            </tr>
            </tbody>
          </table>
        </div>
        <Plotly :data="graphData"
                :display-mode-bar="false"
                :displaylogo="false"
                :layout="layout"
        />
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
      layout: {
        bargap: 0.05,
        bargroupgap: 0.2,
        barmode: "overlay",
        height: 410,
        margin: {
          l: 0,
          r: 0,
          b: 0,
          t: 30
        },
        xaxis: {
          title: '',
          hoverformat: ".1f",
          gridcolor: "#454D7D",
          linewidth: 1,
          linecolor: "#454D7D",
          rangeselector: {
            buttons: [{
              step: 'month',
              stepmode: 'backward',
              count: 1,
              label: '1m'
            }, {
              step: 'month',
              stepmode: 'backward',
              count: 6,
              label: '6m'
            }, {
              step: 'year',
              stepmode: 'todate',
              count: 1,
              label: 'YTD'
            }, {
              step: 'year',
              stepmode: 'backward',
              count: 1,
              label: '1y'
            }, {
              step: 'all',
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
  },
  mounted() {

  }
}
</script>
<style lang="scss">
.bd-popup {
  &_wide {
    .bd-popup__inner {
      max-width: 1485px;
      width: 100%;
    }
  }

  .table-page.table-page_fixed {
    height: 200px;
    overflow: auto;
  }
}
</style>