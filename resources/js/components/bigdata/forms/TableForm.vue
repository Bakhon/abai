<template>
  <form ref="form" class="bd-main-block__form scrollable" style="width: 100%">
    <cat-loader v-show="isloading"/>
    <div class="table-page">
      <p v-if="!tech" class="table__message">{{ trans('bd.select_dzo') }}</p>
      <p v-else-if="rows.length === 0" class="table__message">{{ trans('bd.nothing_found') }}</p>
      <div v-else class="table-wrap scrollable">
        <table v-if="rows.length" class="table">
          <thead>
          <tr>
            <th v-for="column in visibleColumns">
              {{ column.title }}
            </th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(row, rowIndex) in rows">
            <td
                v-for="column in visibleColumns"
                :class="{'editable': column.is_editable}"
                @dblclick="editCell(row, column)"
            >
              <template v-if="column.type === 'link'">
                <a :href="row[column.code].href">{{ row[column.code].name }}</a>
              </template>
              <template v-else-if="column.type === 'calc'">
                <span class="value">{{ row[column.code] ? row[column.code].value : '' }}</span>
              </template>
              <template v-else-if="column.type === 'copy'">
                <input
                    v-model="row[column.code].value"
                    :disabled="row[column.code].value"
                    type="checkbox"
                    @change="copyValues(row, column, rowIndex)">
              </template>
              <template v-else-if="column.type === 'history_graph'">
                <a href="#" @click.prevent="showHistoryGraphDataForRow(row, column)">
                      <span class="value">{{
                          row[column.code].date ? row[column.code].old_value : row[column.code].value
                        }}</span>
                  <span v-if="row[column.code] && row[column.code].date" class="date">
                        {{ row[column.code].date | moment().format('YYYY-MM-DD') }}
                      </span>
                </a>
              </template>
              <template v-else-if="column.type === 'history'">
                <a href="#" @click.prevent="showHistoricalDataForRow(row, column)">Посмотреть</a>
              </template>
              <template v-else-if="['text', 'integer', 'float'].indexOf(column.type) > -1">
                <div v-if="isCellEdited(row, column)" class="input-wrap">
                  <input v-model="row[column.code].value" class="form-control" type="text">
                  <button type="button" @click.prevent="saveCell(row, column)">OK</button>
                  <span v-if="errors[column.code]" class="error">{{ showError(errors[column.code]) }}</span>
                </div>
                <template v-else-if="row[column.code]">
                      <span class="value">{{
                          row[column.code].date ? row[column.code].old_value : row[column.code].value
                        }}</span>
                  <span v-if="row[column.code] && row[column.code].date" class="date">
                        {{ row[column.code].date | moment().format('YYYY-MM-DD') }}
                      </span>
                </template>
              </template>
              <template v-if="typeof history[row.uwi.id][column.code] !== 'undefined'">
                <a :id="`history_${row.uwi.id}_${column.code}`" class="icon-history"></a>
                <b-popover :target="`history_${row.uwi.id}_${column.code}`" custom-class="history-popover"
                           placement="top" triggers="hover">
                  <div v-for="(value, time) in history[row.uwi.id][column.code]">
                    <em>{{ time }}</em><br>
                    <b>{{ value.value }}</b> ({{ value.user }})
                  </div>
                </b-popover>
              </template>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div v-if="rowHistory" class="bd-popup">
      <div class="bd-popup__inner">
        <a class="bd-popup__close" href="#" @click.prevent="closeRowHistory()">Закрыть</a>
        <p class="bd-popup__title">Замеры по скважине за последний месяц</p>
        <div class="table-page">
          <table class="table">
            <thead>
            <tr>
              <th>Дата</th>
              <th v-for="column in rowHistoryColumns">
                {{ column.title }}
              </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(fields, date) in rowHistory">
              <td>{{ date }}</td>
              <td v-for="column in rowHistoryColumns">
                {{ fields[column.code] === null ? '' : fields[column.code].value }}
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <RowHistoryGraph
        v-if="rowHistoryGraph"
        :params="rowHistoryGraph"
        v-on:close="rowHistoryGraph = null"
    >
    </RowHistoryGraph>
  </form>
</template>

<script>
import {Datetime} from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
import {bdFormActions, bdFormState} from '@store/helpers'
import BigDataHistory from './history'
import RowHistoryGraph from './RowHistoryGraph'

Vue.use(Datetime)

export default {
  name: "BigDataTableForm",
  props: {
    params: {
      type: Object,
      required: true
    },
    tech: {
      type: Number
    },
    date: {
      type: String
    }
  },
  components: {
    BigDataHistory,
    RowHistoryGraph
  },
  data() {
    return {
      errors: {},
      formValues: {},
      activeTab: 0,
      currentPage: 1,
      rows: [],
      columns: [],
      editableCell: {
        row: null,
        column: null
      },
      isloading: false,
      history: {},
      rowHistory: null,
      rowHistoryColumns: [],
      rowHistoryGraph: null,
    }
  },
  watch: {
    date() {
      this.updateRows()
    },
    tech() {
      this.updateRows()
    },
  },
  computed: {
    ...bdFormState([
      'formParams'
    ]),
    visibleColumns() {
      return this.formParams.columns.filter(column => column.type !== 'hidden')
    }
  },
  mounted() {
  },
  methods: {
    ...bdFormActions([
      'updateForm'
    ]),
    filterForm(item, isSelected) {
      if (isSelected) {
        if (item.data.type === 'org') return false
        this.tech = item.data.id
        this.updateRows()
      }
    },
    updateRows() {

      if (!this.date || !this.tech) return

      this.isloading = true
      this.axios.get(this.localeUrl(`/api/bigdata/forms/${this.params.code}/rows`), {
        params: {
          date: this.date,
          tech: this.tech
        }
      })
          .then(({data}) => {
            this.rows = data
            this.recalculateCells()
            this.loadEditHistory()
          })
          .finally(() => {
            this.isloading = false
          })

    },
    loadEditHistory() {
      this.rows.forEach(row => {

        this.axios.get(this.localeUrl(`/api/bigdata/forms/${this.params.code}/history`), {
          params: {
            date: this.date,
            id: row.uwi.id
          }
        }).then(({data}) => {

          this.$set(this.history, row.uwi.id, data)
        })

      })
    },
    recalculateCells() {
      this.rows.forEach((row, rowIndex) => {
        this.formParams.columns
            .filter(column => column.type === 'calc')
            .forEach(column => {
              this.calculateCellValue(column, row, rowIndex)
            })
      })
    },
    calculateCellValue(cellColumn, cellRow, rowIndex) {

      let formula = this.fillFormulaWithValues(cellColumn, cellRow, rowIndex)

      let value = null
      if (formula.indexOf('$') === -1) {
        value = eval(formula)
      }

      this.$set(this.rows[rowIndex], cellColumn.code, {
        value: value
      })

      return value
    },
    fillFormulaWithValues(cellColumn, cellRow, rowIndex) {
      let formula = cellColumn.formula
      this.formParams.columns.forEach(column => {

        if (formula.indexOf(`$${column.code}$`) > -1) {

          let value
          if (column.type === 'calc') {
            value = this.calculateCellValue(column, cellRow, rowIndex)
          } else if (column.is_editable) {
            value = cellRow[column.code].value
          } else {
            value = cellRow[column.code].old_value || cellRow[column.code].value
          }

          if (value !== null) {
            formula = formula.replace(`$${column.code}$`, value)
          }
        }

      })
      return formula
    },
    editCell(row, column) {
      this.editableCell.row = row
      this.editableCell.column = column
    },
    isCellEdited(row, column) {
      if (!column.is_editable) return false
      if (this.editableCell.row !== row) return false
      if (this.editableCell.column !== column) return false

      return true
    },
    async saveCell(row, column) {

      this.checkLimits(row, column).then(result => {
        if (result === true) {

          let data = {
            well_id: row.uwi.id,
            date: this.date,
          }
          data[column.code] = row[column.code].value
          this.isloading = true

          this.axios
              .patch(this.localeUrl(`/api/bigdata/forms/${this.params.code}/save/${column.code}`), data)
              .then(({data}) => {
                row[column.code].date = null
                this.editableCell = {
                  row: null,
                  cell: null
                }
                this.recalculateCells()
              })
              .catch(error => {
                Vue.set(this.errors, column.code, error.response.data.errors)
              })
              .finally(() => {
                this.isloading = false
              })

        } else {
          this.editableCell = {
            row: null,
            cell: null
          }
        }
      })

    },
    checkLimits(row, column) {
      return new Promise((resolve, reject) => {
        if (!row[column.code].limits || row[column.code].limits.length === 0) {
          resolve(true)
          return
        }

        if (row[column.code].value >= row[column.code].limits.min && row[column.code].value <= row[column.code].limits.max) {
          resolve(true)
          return
        }

        let message = `${this.trans('bd.value_outside')} (${row[column.code].limits.min}, ${row[column.code].limits.max}). ${this.trans('bd.are_you_sure')}`
        this.$bvModal.msgBoxConfirm(message, {
          okTitle: this.trans('app.yes'),
          cancelTitle: this.trans('app.no'),
        })
            .then(result => {
              resolve(result)
            })
      })
    },
    changePage(page = 1) {
      this.currentPage = page
      this.updateForm()
    },
    showError(err) {
      return err.join('<br>')
    },
    closeRowHistory() {
      this.rowHistory = null
      document.body.classList.remove('fixed')
    },
    showHistoricalDataForRow(row, column) {
      this.isloading = true
      document.body.classList.add('fixed')
      this.axios.get(this.localeUrl(`/api/bigdata/forms/${this.params.code}/row-history`), {
        params: {
          well_id: row.uwi.id,
          column: column.code,
          date: this.date
        }
      }).then(({data}) => {
        this.rowHistory = data

        let columns = []
        column.fields.forEach(block => {
          columns = [...columns, ...this.formParams.columns.filter(item => Object.keys(block).includes(item.code))]
        })

        this.rowHistoryColumns = columns
        this.isloading = false
      })
    },
    showHistoryGraphDataForRow(row, column) {
      this.isloading = true
      document.body.classList.add('fixed')
      this.axios.get(this.localeUrl(`/api/bigdata/forms/${this.params.code}/row-history-graph`), {
        params: {
          well_id: row.uwi.id,
          column: column.code,
          date: this.date
        }
      }).then(({data}) => {
        this.isloading = false
        this.rowHistoryGraph = data
      })
    },
    copyValues(row, column, rowIndex) {

      this.$bvModal.msgBoxConfirm(this.trans('bd.sure_you_want_to_copy'), {
        okTitle: this.trans('app.yes'),
        cancelTitle: this.trans('app.no'),
      })
          .then(result => {
            if (result === true) {
              this.isloading = true
              this.axios.get(this.localeUrl(`/api/bigdata/forms/${this.params.code}/copy`), {
                params: {
                  well_id: row.uwi.id,
                  column: column.code,
                  date: this.date
                }
              }).then(({data}) => {
                this.isloading = false
                this.rowHistoryGraph = data

                row[column.copy.to].value = row[column.copy.from].value
                this.$set(this.rows, rowIndex, row)
                this.$nextTick()

              })
            }
          })

    }
  },
};
</script>
<style lang="scss" scoped>
body.fixed {
  overflow: hidden;
}

.bd-main-block {
  &__date {
    align-items: center;
    display: flex;
    margin-bottom: 10px;

    &-title {
      color: #fff;
      margin-right: 10px;
    }

    &-input {
      position: relative;

      &:after {
        background: url(/img/bd/calendar.svg) no-repeat;
        content: "";
        height: 28px;
        position: absolute;
        right: 0;
        top: 0;
        width: 28px;
      }

      input[type="text"] {
        background: #1a1d46;
        border-radius: 4px;
        border: none;
        color: #fff;
        font-size: 14px;
        font-weight: bold;
        height: 28px;
        width: 124px;
      }
    }

  }

  &__body {
    align-items: stretch;
    background: #363B68;
    display: flex;
    justify-content: space-between;
    height: calc(100vh - 430px);
    min-height: 500px;
    padding: 10px;

    &-history {
      width: 100%;
    }
  }

  &__tree {
    background: #272953;
    margin-right: 8px;
    min-width: 310px;
    overflow-y: auto;
    padding: 17px 25px;
    width: 310px;

    .tree-view {
      .tree-node-label {
        color: #fff;

        &:hover {
          color: #fff;
          background: none;
        }
      }
    }
  }

  &__form {
    background: #272953;
    overflow-y: auto;
    width: 100%;
  }

  .table-page {
    height: 100%;
    margin: 0;
    padding: 0;

    .table-wrap {
      height: 100%;
      margin: 0 0 10px;
      overflow-y: auto;
      width: 100%;
    }
  }

  .table {

    &__message {
      align-items: center;
      color: #fff;
      display: flex;
      font-size: 16px;
      height: 100%;
      justify-content: center;
      margin: 0;
      width: 100%;
    }

    th {
      position: sticky;
      top: 0;
      z-index: 10;
    }

    td {
      height: 52px;
      position: relative;

      .icon-history {
        align-items: center;
        background: #3366FF url(/img/bd/info.svg) 50% 50% no-repeat;
        border-radius: 1px;
        bottom: 6px;
        display: flex;
        justify-content: center;
        left: 1px;
        height: 14px;
        position: absolute;
        width: 14px;
      }

      span.date {
        display: block;
        font-size: 10px;
        font-style: italic;
        white-space: nowrap;
      }

      span.error {
        color: #ff6464;
        font-size: 11px;
      }
    }

    .editable {
      span {
        position: relative;

        &.value {
          background: #323370;
          border: 1px solid #272953;
          box-sizing: border-box;
          border-radius: 2px;
          display: inline-block;
          height: 24px;
          line-height: 24px;
          padding: 0 8px;
          margin: 0 20px 3px 0;
          min-width: 50px;

          &:after {
            background: url(/img/bd/edit.svg) no-repeat;
            content: "";
            display: inline-block;
            height: 14px;
            position: absolute;
            right: -20px;
            top: 4px;
            width: 14px;
          }
        }
      }

      .input-wrap {
        display: inline-block;
        position: relative;

        input.form-control {
          background: #1F2142;
          border: 0.5px solid #454FA1;
          border-radius: 4px;
          color: #fff;
          font-size: 14px;
          min-width: 95px;
          outline: none;
          padding: 0 34px 0 10px;
          height: 28px;
        }

        button {
          background: #3366FF;
          border: none;
          border-radius: 4px;
          color: #fff;
          font-size: 10px;
          font-weight: 600;
          height: 24px;
          line-height: 24px;
          position: absolute;
          right: 2px;
          text-align: center;
          top: 2px;
          width: 28px;
        }
      }

    }
  }
}

.history-popover {
  .popover-body {
    background: #40467E;
    border: 1px solid #2E50E9;
    border-radius: 1px;
    color: #fff;
    font-size: 14px;
    padding: 8px;
    white-space: nowrap;
  }

  .arrow {
    display: none;
  }
}
</style>