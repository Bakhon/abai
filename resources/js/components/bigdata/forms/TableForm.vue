<template>
  <div>
    <template v-if="formParams && formParams.summary">
      <div class="bd-main-block__tabs">
        <div
            v-for="(table, index) in formParams.summary.tables"
            :class="{'bd-main-block__tabs-tab_active': activeTab === `tab_${index}`}"
            class="bd-main-block__tabs-tab"
            @click="activeTab = `tab_${index}`"
        >
          <span>{{ table.title }}</span>
        </div>
        <div
            :class="{'bd-main-block__tabs-tab_active': activeTab === 'tab_form'}"
            class="bd-main-block__tabs-tab"
            @click="activeTab = `tab_form`"
        >
          <span>Форма ввода</span>
        </div>
      </div>
    </template>
    <div ref="container" class="bd-main-block__body">
      <form ref="form" class="bd-main-block__form" @submit.prevent="">
        <div class="table-page">
          <template v-if="formParams">
            <p v-if="formError" class="table__message">
              {{ formError }}
            </p>
            <p v-else-if="!id" class="table__message">
              {{ trans('bd.select_dzo') }}
            </p>
            <p v-else-if="rows.length === 0" class="table__message">{{ trans('bd.nothing_found') }}</p>
            <div v-else ref="table_wrap" :class="{'tables_with-summary': formParams.summary}"
                 class="tables__list scrollable">
              <div v-for="custom_column in formParams.custom_columns">
                <div :is="custom_column.component_name"
                     :allColumns="formParams.columns"
                     :column="custom_column"
                     :filter="filter"
                     :updateTableData="updateTableData">
                </div>
              </div>
              <template v-if="formParams.summary">
                <div
                    v-for="(table, index) in formParams.summary.tables"
                    v-if="activeTab === `tab_${index}`"
                    class="summary"
                >
                  <p class="title">{{ table.title }}</p>
                  <div class="summary-table">
                    <table class="table">
                      <thead>
                      <template v-if="table.data.complicated_header">
                        <tr v-for="row in table.data.complicated_header">
                          <th
                              v-for="column in row"
                              :colspan="column.colspan"
                              :rowspan="column.rowspan"
                          >
                            {{ column.title }}
                          </th>
                        </tr>
                      </template>
                      <template v-else>
                        <tr>
                          <th v-for="column in table.data.columns">
                            {{ column.title }}
                          </th>
                        </tr>
                      </template>
                      </thead>
                      <tbody>
                      <tr v-for="row in table.data.rows">
                        <td v-for="column in table.data.columns">
                          <span v-html="row[column.code]"></span>
                        </td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </template>
              <div v-if="activeTab === 'tab_form'" class="table__wrap">
                <div v-if="hasToggleColumns" class="table-arrow">
                  <div
                      :class="[isToggleColumnsHidden ? 'arrow-left' : 'arrow-right', 'cursor-pointer']"
                      @click="toggleColumns"
                  >
                  </div>
                </div>
                <table v-if="rows.length" class="table">
                  <thead>
                  <template v-if="formParams.complicated_header">
                    <tr v-for="row in formParams.complicated_header">
                      <th
                          v-for="column in row"
                          :colspan="column.colspan"
                          :rowspan="column.rowspan"
                      >
                        {{ column.title }}
                      </th>
                    </tr>
                  </template>
                  <template v-else>
                    <tr>
                      <th v-if="formParams.edit"></th>
                      <th
                          v-for="column in visibleColumns"
                          :class="{'freezed': column.freezed}"
                          :style="getCellStyles(column)"
                      >
                        {{ column.title }}
                      </th>
                    </tr>
                  </template>
                  </thead>
                  <tbody>
                  <template v-if="formParams">
                    <tr v-for="(row, rowIndex) in rows">
                      <td v-if="formParams.edit">
                        <a href="#" @click.prevent="editForm(row)">Редактировать</a>
                      </td>
                      <td
                          v-for="column in visibleColumns"
                          :class="{
                        'editable': isCellEdited(row, column),
                        'freezed': column.freezed
                      }"
                          :style="getCellStyles(column)"
                          @dblclick="editCell(row, column)"
                      >
                        <template v-if="getCellType(row, column) === 'form'">
                          <a href="#" @click.prevent="openForm(row, column)">редактировать</a>
                        </template>
                        <template v-else-if="getCellType(row, column) === 'link'">
                          <a class="well_link_color" v-if="row[column.code]" :href="row[column.code].href"
                             target="_blank">{{ row[column.code].name }}</a>
                        </template>
                        <template v-else-if="getCellType(row, column) === 'label'">
                          <label v-html="row[column.code].name || ''"></label>
                        </template>
                        <template v-else-if="getCellType(row, column) === 'calc'">
                          <span class="value" v-html="row[column.code] ? row[column.code].value : ''"></span>
                        </template>
                        <template v-else-if="getCellType(row, column) === 'copy'">
                          <input
                              v-model="row[column.code].value"
                              :disabled="row[column.code].value"
                              type="checkbox"
                              @change="copyValues(row, column, rowIndex)">
                        </template>
                        <template v-else-if="getCellType(row, column) === 'history_graph'">
                          <a href="#" @click.prevent="showHistoryGraphDataForRow(row, column)">
                      <span v-if="row[column.code]" class="value">{{
                          row[column.code].date ? row[column.code].old_value : row[column.code].value
                        }}</span>
                            <span v-if="row[column.code] && row[column.code].old_value && row[column.code].date"
                                  class="date">
                        {{ row[column.code].date | moment().format('DD.MM.YYYY') }}
                      </span>
                          </a>
                        </template>
                        <template v-else-if="getCellType(row, column) === 'history'">
                          <a href="#" @click.prevent="showHistoricalDataForRow(row, column)">Посмотреть</a>
                        </template>
                        <template v-else-if="getCellType(row, column) === 'date'">
                          <div v-if="isCellEdited(row, column)" class="input-wrap">
                            <datetime
                                v-model="row[column.code].value"
                                :flow="['year', 'month', 'date']"
                                :phrases="{ok: '', cancel: ''}"
                                auto
                                format="dd LLLL yyyy"
                                input-class="form-control"
                                type="date"
                                value-zone="Asia/Almaty"
                                zone="Asia/Almaty"
                            >
                            </datetime>
                          </div>
                          <template v-else-if="row[column.code]">
                      <span class="value">
                        {{ row[column.code].date ? row[column.code].old_value : row[column.code].value }}
                      </span>
                          </template>
                        </template>
                        <template v-else-if="getCellType(row, column) === 'dict'">
                          <bigdata-form-field
                              v-if="row[column.code]"
                              :id="row.id"
                              :key="`field_${column.code}_${row.id}`"
                              v-model="row[column.code].value"
                              :editable="isCellEdited(row, column)"
                              :item="getFieldParams(row, column)"
                          >
                          </bigdata-form-field>
                        </template>
                        <template v-else-if="getCellType(row, column) === 'file'">
                          <template v-if="row[column.code].value && row[column.code].value.length > 0">
                            <span v-html="formatFiles(row[column.code].value)"></span>
                            <a href="#" @click="deleteFile(row, column)">x</a>
                          </template>
                          <template v-else>
                            <vue-upload-component
                                v-model="row[column.code].value"
                                :multiple="false"
                                :name="`file_${column.code}_${row.id}`"
                                @input="saveCell(row, column)"
                            >
                            </vue-upload-component>
                            <label
                                :for="`file_${column.code}_${row.id}`"
                                class="btn btn-primary"
                            >
                              {{ trans('app.upload') }}
                            </label>
                          </template>
                        </template>
                        <template v-else-if="['text', 'integer', 'float'].indexOf(getCellType(row, column)) > -1">
                          <template v-if="isCellEdited(row, column)">
                            <div class="input-wrap">
                              <input
                                  v-if="row[column.code]"
                                  v-model="row[column.code].value"
                                  class="form-control"
                                  type="text">
                            </div>
                          </template>
                          <template v-else-if="row[column.code]">
                            <span
                                :class="[['integer', 'float'].indexOf(getCellType(row, column)) > -1 ? 'value_num' : '']"
                                class="value"
                            >
                              {{ row[column.code].date ? row[column.code].old_value : row[column.code].value }}
                            </span>
                            <span
                                v-if="row[column.code] && row[column.code].old_value && row[column.code].date"
                                class="date"
                            >
                              {{ row[column.code].date | moment().format('DD.MM.YYYY') }}
                            </span>
                          </template>
                        </template>
                        <template
                            v-if="formParams.available_actions.includes('view history') && history[row.id] && history[row.id][column.code]">
                          <a :id="`history_${row.id}_${column.code}`" class="icon-history"></a>
                          <b-popover :target="`history_${row.id}_${column.code}`" custom-class="history-popover"
                                     placement="top" triggers="hover">
                            <div v-for="(value, time) in history[row.id][column.code]">
                              <em>{{ time }}</em><br>
                              <b>{{ value.value }}</b> ({{ value.user }})
                            </div>
                          </b-popover>
                        </template>
                        <span
                            v-if="isCellEdited(row, column) && errors && errors[row.id] && errors[row.id][column.code]"
                            class="error"
                        >
                          {{ showError(errors[row.id][column.code]) }}
                        </span>
                      </td>
                    </tr>
                  </template>
                  </tbody>
                </table>
              </div>
            </div>
          </template>
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
            @close="rowHistoryGraph = null"
        >
        </RowHistoryGraph>
        <div v-if="isInnerFormOpened" class="bd-popup">
          <div class="bd-popup__inner">
            <a class="bd-popup__close" href="#" @click.prevent="isInnerFormOpened = false">{{ trans('bd.close') }}</a>
            <BigDataPlainForm
                :params="innerFormParams"
                :values="innerFormValues"
                :well-id="innerFormWellId"
                @close="isInnerFormOpened = false"
            >
            </BigDataPlainForm>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import {Datetime} from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
import {bdFormActions, globalloadingActions} from '@store/helpers'
import BigDataHistory from './history'
import RowHistoryGraph from './RowHistoryGraph'
import BigDataPlainForm from './PlainForm'
import BigdataFormField from './field'
import forms from '../../../json/bd/forms.json'
import VueUploadComponent from 'vue-upload-component'
import {diff} from 'deep-object-diff'

Vue.use(Datetime);

export default {
  name: "BigDataTableForm",
  props: {
    params: {
      type: Object,
      required: true
    },
    id: {
      type: Number
    },
    type: {
      type: String
    },
    filter: {
      type: Object
    },
    editMode: {
      type: Boolean
    }
  },
  components: {
    BigDataHistory,
    BigDataPlainForm,
    RowHistoryGraph,
    BigdataFormField,
    VueUploadComponent
  },
  data() {
    return {
      errors: {},
      activeTab: 'tab_form',
      currentPage: 1,
      initialRows: [],
      rows: [],
      editableCell: {
        row: null,
        column: null
      },
      history: {},
      rowHistory: null,
      rowHistoryColumns: [],
      rowHistoryGraph: null,
      oldFilter: null,
      formParams: null,
      formError: null,
      forms: forms,
      isInnerFormOpened: false,
      innerFormParams: null,
      innerFormValues: null,
      innerFormWellId: null,
      isToggleColumnsHidden: false
    }
  },
  watch: {
    date() {
      this.updateTableData()
    },
    id() {
      this.updateTableData()
    },
    filter: {
      deep: true,
      handler(val) {
        this.updateTableData()
      }
    },
    initialRows(value) {
      this.rows = JSON.parse(JSON.stringify(value))
      this.recalculateCells()
    }
  },
  computed: {
    visibleColumns() {
      return this.formParams.columns.filter(column => {
            if (column.type === 'hidden') return false
            if (column.visible === false) return false
            if (this.isToggleColumnsHidden && column.toggle && column.toggle === true) return false

            return true
          }
      )
    },
    hasToggleColumns() {
      return this.formParams.columns.filter(column => {
        return column.toggle && column.toggle === true
      }).length > 0
    }
  },
  mounted() {
    this.updateForm(this.params.code)
        .then(data => {
          this.formParams = data
          this.$emit('initialized', data)
          this.updateTableData()
        })

    window.addEventListener('resize', this.setTableHeight, true);
  },
  destroyed() {
    window.removeEventListener('resize', this.setTableHeight, true);
  },
  methods: {
    ...bdFormActions([
      'updateForm'
    ]),
    ...globalloadingActions([
      'setLoading'
    ]),
    updateTableData() {

      this.formError = null
      if (!this.filter || !this.id || !this.type) return

      this.setLoading(true)
      this.axios.get(this.localeUrl(`/api/bigdata/forms/${this.params.code}/results`), {
        params: {
          filter: this.filter,
          id: this.id,
          type: this.type
        }
      })
          .then(({data}) => {
            this.initialRows = data.rows
            if (data.columns) {
              this.formParams.columns = data.columns
            }
            if (data.merge_columns) {
              this.formParams.merge_columns = data.merge_columns
            }
            if (data.complicated_header) {
              this.formParams.complicated_header = data.complicated_header
            }
            if (data.summary) {
              this.formParams.summary = data.summary
            }
            this.recalculateCells()
            if (this.formParams.show_history !== false) {
              this.loadEditHistory()
            }
          })
          .catch(error => {
            console.log(error)
            this.formError = error.response.data.message
          })
          .finally(() => {
            this.setLoading(false)
            this.setTableHeight()
          })

    },
    loadEditHistory() {
      this.rows.forEach(row => {

        this.axios.get(this.localeUrl(`/api/bigdata/forms/${this.params.code}/history`), {
          params: {
            date: this.filter.date,
            id: row.id
          }
        }).then(({data}) => {

          this.$set(this.history, row.id, data)
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
          } else if (this.isEditable(cellRow, column)) {
            value = cellRow[column.code].old_value || cellRow[column.code].value
          } else {
            value = cellRow[column.code].old_value || cellRow[column.code].value
          }

          if (typeof value !== 'undefined') {
            formula = formula.replace(`$${column.code}$`, value)
          }
        }

      })
      return formula
    },
    editCell(row, column) {

      if (!this.formParams.available_actions.includes('update')) return

      if (row[column.code].value === null && row[column.code].old_value !== null) {
        row[column.code].value = row[column.code].old_value
      }

      this.editableCell.row = row
      this.editableCell.column = column
    },
    isEditable(row, column) {
      return column.is_editable || (row[column.code] && row[column.code].is_editable)
    },
    getCellType(row, column) {
      return (row[column.code] && row[column.code].type) ? row[column.code].type : column.type
    },
    getFieldParams(row, column) {
      let params = {...column}
      let fieldsToOverwrite = ['type', 'is_editable', 'dict']
      if (row[column.code]) {
        fieldsToOverwrite.forEach(field => {
          if (!row[column.code][field]) return

          params[field] = row[column.code][field]
        })
      }
      return params
    },
    isCellEdited(row, column) {
      if (!this.isEditable(row, column)) return false
      if (this.formParams.new === true) {
        return this.editMode
      } else {
        if (this.editableCell.row !== row) return false
        if (this.editableCell.column !== column) return false

        return true
      }
    },
    submit() {
      let difference = diff(this.initialRows, this.rows)
      let fields = {}
      this.rows.map((row, index) => {
        if (!difference[index]) return
        fields[row.id] = difference[index]

        for (let code in fields[row.id]) {
          if (row[code].id) {
            fields[row.id][code].id = row[code].id
          }
          if (row[code].params) {
            fields[row.id][code].params = row[code].params
          }
        }

        this.visibleColumns.forEach(column => {
          if (column.is_editable === false) {
            if (typeof row[column.code] !== 'undefined' && (!row[column.code].hasOwnProperty('is_editable') || !row[column.code].is_editable)) {
              delete fields[row.id][column.code]
            }
          }
          if (this.isColumnRequired(column) && !fields[row.id][column.code]) {
            fields[row.id][column.code] = {value: row[column.code].value}
            if (row[column.code].id) {
              fields[row.id][column.code].id = row[column.code].id
            }
            if (row[column.code].params) {
              fields[row.id][column.code].params = row[column.code].params
            }
          }
        })
      })

      let data = {
        fields: fields,
        filter: this.filter
      }

      this.setLoading(true)
      this.axios
          .post(this.localeUrl(`/api/bigdata/forms/${this.params.code}`), data)
          .then(({data}) => {
            if (this.formParams.update_after_edit !== false) {
              this.updateTableData()
            } else {
              this.initialRows = JSON.parse(JSON.stringify(this.rows))
              this.setLoading(false)
            }
            this.$emit('sent')
          })
          .catch(error => {
            this.setLoading(false)
            if (error.response.status === 500) {
              this.$notifyError(error.response.data.message)
              return
            }
            this.errors = error.response.data.errors
          })
    },
    isColumnRequired(column) {
      if (!column.validation) return false
      return column.validation.indexOf('required') !== -1
    },
    async saveCell(row, column) {
      //todo: переделать отправку по аналогии с submitFile
      if (this.getCellType(row, column) === 'file' && row[column.code].value) {
        this.submitFile(row, column)
        return
      }

      this.checkLimits(row, column).then(result => {
        if (result === true) {

          let data = {
            well_id: row.id,
            ...this.filter
          }

          if (row[column.code].params) {
            data['params'] = row[column.code].params
          }

          data[column.code] = row[column.code].value

          this.setLoading(true)
          this.axios
              .patch(this.localeUrl(`/api/bigdata/forms/${this.params.code}/save/${column.code}`), data)
              .then(({data}) => {
                row[column.code].date = null
                this.editableCell = {
                  row: null,
                  cell: null
                }
                if (this.formParams.update_after_edit !== false) {
                  this.updateTableData()
                } else {
                  this.setLoading(false)
                }
              })
              .catch(error => {
                Vue.set(this.errors, column.code, error.response.data.errors)
                this.setLoading(false)
              })
        } else {
          this.editableCell = {
            row: null,
            cell: null
          }
        }
      })

    },
    async submitFile(row, column) {

      this.setLoading(true)
      let formData = new FormData()

      formData.append('row', JSON.stringify(row))
      formData.append('column', JSON.stringify(column))
      formData.append('filter', JSON.stringify(this.filter))

      let existedFiles = []
      row[column.code].value.forEach((file, index) => {
        if (file.exists) {
          existedFiles.push(file.id)
          return
        }
        formData.append(`uploads[]`, file.file)
      })

      this.axios
          .post(this.localeUrl(`/api/bigdata/forms/${this.params.code}/upload/${column.code}`), formData)
          .then(({data}) => {
            row[column.code].date = null
            this.editableCell = {
              row: null,
              cell: null
            }
            if (this.formParams.update_after_edit !== false) {
              this.updateTableData()
            } else {
              this.setLoading(false)
            }
          })
          .catch(error => {
            Vue.set(this.errors, column.code, error.response.data.errors)
            this.setLoading(false)
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
    showError(err) {
      return err.join('<br>')
    },
    closeRowHistory() {
      this.rowHistory = null
      document.body.classList.remove('fixed')
    },
    showHistoricalDataForRow(row, column) {
      this.setLoading(true)
      document.body.classList.add('fixed')
      this.axios.get(this.localeUrl(`/api/bigdata/forms/${this.params.code}/row-history`), {
        params: {
          well_id: row.id,
          column: column.code,
          date: this.filter.date
        }
      }).then(({data}) => {
        this.rowHistory = data

        let columns = []
        column.fields.forEach(block => {
          columns = [...columns, ...this.formParams.columns.filter(item => Object.keys(block).includes(item.code))]
        })

        this.rowHistoryColumns = columns
        this.setLoading(false)
      })
    },
    showHistoryGraphDataForRow(row, column) {
      this.setLoading(true)
      document.body.classList.add('fixed')
      this.axios.get(this.localeUrl(`/api/bigdata/forms/${this.params.code}/row-history-graph`), {
        params: {
          well_id: row.id,
          column: column.code,
          date: this.filter.date
        }
      }).then(({data}) => {
        this.setLoading(false)
        this.rowHistoryGraph = data
      })
    },
    copyValues(row, column, rowIndex) {

      if (!row[column.copy.from].value) return

      this.$bvModal.msgBoxConfirm(this.trans('bd.sure_you_want_to_copy'), {
        okTitle: this.trans('app.yes'),
        cancelTitle: this.trans('app.no'),
      })
          .then(result => {
            if (result === true) {
              this.setLoading(true)
              this.axios.get(this.localeUrl(`/api/bigdata/forms/${this.params.code}/copy`), {
                params: {
                  well_id: row.id,
                  column: column.code,
                  date: this.filter.date
                }
              }).then(({data}) => {
                this.setLoading(false)
                this.rowHistoryGraph = data

                row[column.copy.to].value = row[column.copy.from].value
                row[column.copy.to].old_value = null
                row[column.copy.to].date = null
                this.$set(this.rows, rowIndex, row)
                this.$nextTick()

              })
            }
          })
    },
    openForm(row, column) {
      this.isInnerFormOpened = true
      this.innerFormParams = this.forms.find(formItem => formItem.code === column.form)
      this.innerFormWellId = row.id
      this.innerFormValues = {}
      this.innerFormValues[column.code] = row[column.code].value
    },
    editForm(row) {
      this.axios.post(this.localeUrl(`/api/bigdata/forms/${this.formParams.edit.form}/edit-form`), {
            id: row.id,
            filter: this.filter
          }
      ).then(response => {
        this.isInnerFormOpened = true
        this.innerFormParams = this.forms.find(formItem => formItem.code === this.formParams.edit.form)
        this.innerFormWellId = response.data.well_id
        this.innerFormValues = response.data.values
      })
    },
    formatFiles(files) {
      return files.map(file => {
        return '<a href="' + this.localeUrl(`/attachments/${file.id}`) + `">${file.filename} (${file.size})</a>`
      }).join('<br>')
    },
    deleteFile(row, column) {
      row[column.code].value = ''
      this.saveCell(row, column).then(res => {
        row[column.code].value = []
      })
    },
    getCellStyles(column) {
      if (!column.freezed) return null

      let left = 0

      this.visibleColumns.some(visibleColumn => {
        if (visibleColumn === column) return true
        if (visibleColumn.width) left += visibleColumn.width
      })

      return {
        'left': left + 'px',
        'min-width': column.width + 'px',
        'width': column.width + 'px'
      }
    },
    setTableHeight() {
      this.$nextTick(() => {
        let height = window.innerHeight - this.$refs.container.getBoundingClientRect().top - 5;
        this.$refs.container.style.height = height + 'px'
        this.$refs.table_wrap.style.height = (height - 10) + 'px'
      })
    },
    toggleColumns() {
      this.isToggleColumnsHidden = !this.isToggleColumnsHidden
    }
  },
};
</script>
<style lang="scss" scoped>
body.fixed {
  overflow: hidden;
}

.well_link_color {
  color: #fff;
}

.bd-main-block {

  &__tabs {
    display: flex;

    &-tab {
      border: 1px solid #454D7D;
      border-bottom: none;
      border-top-left-radius: 3px;
      border-top-right-radius: 3px;
      color: #fff;
      margin-right: 5px;
      padding: 5px 20px;

      &_active {
        background: #333975;
        font-weight: bold;
      }
    }
  }

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
    padding: 5px;

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
    width: 100%;
  }

  .table-page {
    height: 100%;
    margin: 0;
    padding: 0;

    .tables__list {
      overflow-x: auto;
      overflow-y: auto;
      width: 100%;
    }

    .table__wrap {
      position: relative;

      .table-arrow {
        background: #8F95BA;
        border-radius: 5px 0 0 5px;
        width: 13px;
        height: 50px;
        position: absolute;
        left: 0;
        top: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        transform: translateY(-50%);

        & + .table {
          margin-left: 13px;
          width: calc(100% - 13px);
        }
      }

      .arrow-right {
        background: url(/img/bd/arrow-well-right.svg) no-repeat;
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        background-position: center;
      }

      .arrow-left {
        background: url(/img/bd/arrow-well-left.svg) no-repeat;
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        background-position: center;
      }

    }

    .summary {
      .title {
        color: #fff;
        font-size: 16px;
        margin: 5px 0;
        text-align: center;
      }

      &-table {
        margin-bottom: 20px;
        overflow-x: auto;

        .table {
          margin-bottom: 0;
        }
      }

      & + .table__wrap {
        overflow-x: auto;
      }

    }
  }

  .table {

    border-collapse: separate;
    border-spacing: 0;
    margin-bottom: 0;

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

    thead {
      position: sticky;
      top: 0;
      z-index: 21;

      th.freezed {
        position: sticky;
        z-index: 21;
      }
    }

    td {
      height: 5px;
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

      span {

        &.value_num {
          white-space: nowrap;
        }

        &.date {
          display: block;
          font-size: 10px;
          font-style: italic;
          white-space: nowrap;
        }

        &.error {
          color: #ff6464;
          font-size: 11px;
        }
      }
    }

    tbody {
      tr {
        td.freezed {
          position: sticky;
          z-index: 20;
        }
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
        display: flex;
        justify-content: center;
        margin: 2px 0;
        position: relative;

        input.form-control {
          background: #1F2142;
          border: 0.5px solid #454FA1;
          border-radius: 4px;
          color: #fff;
          font-size: 14px;
          width: 95px;
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