<template>
  <div>
    <cat-loader v-show="isLoading"/>
    <div v-if="rows" class="table-container scrollable">
      <div class="table-container-header">

        <template v-if="form && form.actions && form.actions.length > 0">
          <div class="dropdown">
            <button id="dropdownMenuButton" aria-expanded="false" aria-haspopup="true" class="download-curve-button"
                    data-toggle="dropdown" type="button">
              {{ trans('bd.actions') }}
              <svg fill="none" height="6" viewBox="0 0 12 6" width="12" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.5 1L5.93356 4.94095C5.97145 4.97462 6.02855 4.97462 6.06644 4.94095L10.5 1" stroke="white"
                      stroke-linecap="round" stroke-width="1.4"/>
              </svg>
            </button>
            <div aria-labelledby="dropdownMenuButton" class="dropdown-menu">
              <template v-for="action in form.actions">
                <a v-if="action.action === 'create'" class="dropdown-item" href="#"
                   @click="showForm(action.form)">{{ action.title }}</a>
                <a v-else-if="action.action === 'edit'" class="dropdown-item" href="#"
                   @click="editRow(selectedRow, action.form)">{{ action.title }}</a>
              </template>
            </div>
          </div>
        </template>
        <svg v-else-if="availableActions.includes('create')" fill="none" height="16" viewBox="0 0 16 16" width="16"
             xmlns="http://www.w3.org/2000/svg"
             @click="showForm()">
          <path d="M14.5 8L1.5 8" stroke="white" stroke-linecap="round" stroke-width="1.5"/>
          <path d="M8 1.5V14.5" stroke="white" stroke-linecap="round" stroke-width="1.5"/>
        </svg>
        <template v-if="header">
          <div class="row">
            <div class="col">
              <h4>
                Текущая оргструктура: <span
                  class="blue-section">НИИ/АО “РД “КазМунайГаз”/АО “Озенмунайгаз”/НГДУ-З/ППД-З</span>
              </h4>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <h4>
                Начало периода: 01.01.1980
              </h4>
              <h4>
                Конец периода: ...
              </h4>
            </div>
          </div>
        </template>
      </div>
      <div class="table-container-body">
        <table class="table-container-table">
          <thead class="table-container-column-header">
          <tr>
            <th v-for="column in columns" class="table-border"><p class="title">{{ column.title }}</p>
            </th>
            <th v-if="!form.actions" class="table-border"><p class="title">Управление</p></th>
          </tr>
          </thead>
          <tbody class="table-container-element">
          <tr
              v-for="(row, index) in rows"
              :class="{'selected': selectedRow === row}"
              @click="selectedRow = row"
          >
            <td v-for="column in columns" class="table-border element-position">
              <p>{{ getCellValue(row, column) }}</p>
            </td>
            <td v-if="!form.actions" class="table-border element-position">
              <div class="table-container-svg">
                <svg v-if="availableActions.includes('update')" fill="none" height="18" viewBox="0 0 18 18" width="18"
                     xmlns="http://www.w3.org/2000/svg"
                     @click.prevent.stop="editRow(row)">
                  <path
                      d="M3 11.4998L1.55336 16.322C1.53048 16.3983 1.6016 16.4694 1.67788 16.4465L6.5 14.9998M3 11.4998C3 11.4998 11.0603 3.4393 12.7227 1.77708C12.8789 1.62091 13.1257 1.6256 13.2819 1.78177C13.8372 2.33702 15.1144 3.61422 16.2171 4.71697C16.3733 4.87322 16.3788 5.12103 16.2226 5.27726C14.5597 6.9399 6.5 14.9998 6.5 14.9998M3 11.4998L3.64727 10.8525L7.14727 14.3525L6.5 14.9998"
                      stroke="white" stroke-width="1.4"/>
                </svg>
                <svg
                    v-if="availableActions.includes('view history')"
                    fill="none"
                    height="14" viewBox="0 0 17 14" width="17" xmlns="http://www.w3.org/2000/svg"
                    @click.prevent.stop="showHistory(row)">
                  <path clip-rule="evenodd"
                        d="M5.53548 11.0045C5.65778 11.1193 5.72938 11.2799 5.73432 11.448C5.74346 11.6191 5.67582 11.7823 5.56092 11.9046C5.44611 12.0295 5.28545 12.1009 5.11471 12.1059C4.94652 12.1114 4.78332 12.0474 4.66102 11.9326C4.38305 11.6724 4.13068 11.3896 3.90371 11.0861C3.80161 10.9511 3.75573 10.7827 3.78142 10.6145C3.80427 10.4461 3.89356 10.2959 4.02857 10.1938C4.16386 10.0917 4.33199 10.0483 4.50045 10.0714C4.66864 10.0942 4.81917 10.1836 4.921 10.3186C5.10464 10.5635 5.31116 10.7928 5.53548 11.0045Z"
                        fill="white" fill-rule="evenodd"/>
                  <path clip-rule="evenodd"
                        d="M12.3454 8.25546C12.4856 8.34979 12.585 8.4951 12.6182 8.661C12.6511 8.82681 12.6183 9.00013 12.5214 9.14035C12.4297 9.28048 12.2817 9.38004 12.1161 9.41323C11.9503 9.44632 11.7796 9.4105 11.6391 9.31626L8.88606 7.48175C8.76896 7.40351 8.67383 7.22604 8.67383 7.08536V3.4265C8.67383 3.25812 8.7424 3.09512 8.86251 2.97766C8.97988 2.85773 9.1431 2.78909 9.31129 2.78909C9.48232 2.78909 9.64262 2.85773 9.76264 2.97766C9.88229 3.09512 9.94876 3.25812 9.94876 3.4265V6.40444C9.94876 6.54539 10.0438 6.72263 10.161 6.8006L12.3454 8.25546Z"
                        fill="white" fill-rule="evenodd"/>
                  <path clip-rule="evenodd"
                        d="M2.59107 6.08744C2.71831 4.7857 3.40448 3.32115 4.5202 2.20781C5.79013 0.9356 7.51618 0.221717 9.31106 0.221717C11.1087 0.221717 12.8349 0.9356 14.1046 2.20781C15.3768 3.47764 16.0909 5.20391 16.0909 7.00134C16.0909 8.7964 15.3768 10.5223 14.1046 11.7948C12.8349 13.0645 11.1087 13.7783 9.31106 13.7783C8.40594 13.781 7.5059 13.5974 6.66971 13.243C6.51404 13.1792 6.39174 13.0543 6.32793 12.8963C6.26395 12.7405 6.26669 12.5646 6.32793 12.4092C6.39375 12.2537 6.51914 12.1288 6.67718 12.0677C6.83267 12.0039 7.00859 12.0038 7.16435 12.0695C7.84241 12.3576 8.57157 12.5056 9.30849 12.503C10.7696 12.503 12.1693 11.9244 13.2018 10.8916C14.232 9.85909 14.8131 8.45939 14.8131 7.0009C14.8131 5.53975 14.232 4.14003 13.2018 3.10749C12.1693 2.07733 10.7696 1.49614 9.30849 1.49614C7.85018 1.49614 6.45019 2.07733 5.41765 3.10749C4.53639 3.98875 3.98575 5.13764 3.87259 6.11031C3.85613 6.24998 3.92385 6.28257 4.02367 6.1834L4.55067 5.65707C4.66803 5.53741 4.83126 5.46849 4.99945 5.46849C5.17019 5.46849 5.33089 5.53741 5.4509 5.65707C5.57056 5.77443 5.63691 5.93771 5.63691 6.1059C5.63691 6.27665 5.57019 6.43723 5.4509 6.55725L3.57489 8.43505C3.37617 8.63423 3.05301 8.63421 2.85429 8.43522L0.976045 6.55725C0.856393 6.43723 0.790039 6.27665 0.790039 6.1059C0.790039 5.93771 0.856758 5.77443 0.976045 5.65707C1.09606 5.53741 1.25902 5.46849 1.42739 5.46849C1.59558 5.46849 1.75881 5.53741 1.87874 5.65707L2.38297 6.16086C2.48279 6.26012 2.57468 6.22693 2.5884 6.08699"
                        fill="white" fill-rule="evenodd"/>
                </svg>
                <svg v-if="availableActions.includes('delete')" fill="none" height="14" viewBox="0 0 14 14" width="14"
                     xmlns="http://www.w3.org/2000/svg"
                     @click.prevent.stop="deleteRow(row, index)">
                  <path d="M12.6574 12.6575L1.34367 1.34383" stroke="white" stroke-linecap="round"
                        stroke-width="1.4"/>
                  <path d="M12.6563 1.34383L1.34262 12.6575" stroke="white" stroke-linecap="round"
                        stroke-width="1.4"/>
                </svg>
              </div>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
      <div v-if="isFormOpened" class="bd-popup">
        <div class="bd-popup__inner">
          <a class="bd-popup__close" href="#" @click.prevent="isFormOpened = false">{{ trans('bd.close') }}</a>
          <div class="bd-main-block__form-block-content">
            <BigDataPlainForm
                :params="formParams"
                :values="formValues"
                :well-id="wellId"
                @change="updateResults"
                @close="isFormOpened = false"
            >
            </BigDataPlainForm>
          </div>
        </div>
      </div>
    </div>
    <div v-else-if="hasFormError">
      <p style="color: #fff">Ошибка загрузки формы</p>
    </div>
    <div v-if="isHistoryShowed" class="bd-popup">
      <div class="bd-popup__inner">
        <a class="bd-popup__close" href="#" @click.prevent="isHistoryShowed = false">{{ trans('bd.close') }}</a>
        <div class="bd-main-block__form-block-content">
          <edit-history :history="history"></edit-history>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import forms from '../../../json/bd/forms.json'
import BigDataPlainForm from './PlainForm'
import {bdFormActions} from '@store/helpers'
import CatLoader from '../../ui-kit/CatLoader'
import EditHistory from '../../common/EditHistory'
import moment from "moment";

export default {
  name: "BigdataPlainFormResults",
  props: {
    code: {
      type: String,
      required: true
    },
    wellId: {
      type: Number,
      required: true
    }
  },
  components: {
    BigDataPlainForm,
    CatLoader,
    EditHistory
  },
  data() {
    return {
      forms: forms,
      header: null,
      columns: null,
      rows: null,
      selectedRow: null,
      isFormOpened: false,
      form: null,
      formValues: null,
      formParams: null,
      dictFields: {},
      isLoading: false,
      hasFormError: false,
      history: {},
      isHistoryShowed: false,
      availableActions: []
    }
  },
  watch: {
    code() {
      this.updateResults()
    },
    wellId() {
      this.rows = null
      this.updateResults()
    },
  },
  mounted() {
    this.updateResults()
  },
  methods: {
    ...bdFormActions([
      'loadDict'
    ]),
    updateResults() {
      this.isLoading = true
      this.hasFormError = false

      this.axios.get(this.localeUrl(`/api/bigdata/forms/${this.code}`)).then(({data}) => {
        let dictFields = {}
        data.params.tabs.forEach(tab => {
          tab.blocks.forEach(blocks => {
            blocks.forEach(block => {

              block.items
                  .filter(item => item.type === 'dict')
                  .map(item => {
                    dictFields[item.code] = item.dict
                  })

            })
          })
        })
        this.dictFields = dictFields
        this.availableActions = data.available_actions
        this.loadDictionaries()
      })

      this.axios.get(
          this.localeUrl(`/api/bigdata/forms/${this.code}/results`),
          {params: {well_id: this.wellId}}
      ).then(({data}) => {
        this.rows = data.rows
        this.columns = data.columns
        this.form = data.form

      }).catch(() => {
        this.rows = null
        this.columns = null
        this.hasFormError = true
      }).finally(() => {
        this.isLoading = false
      })
    },
    loadDictionaries() {
      Object.values(this.dictFields).forEach(code => {
        if (this.getDict(code)) return
        this.loadDict(code)
      })
    },
    getDict(code) {
      return this.$store.getters['bdform/dict'](code);
    },
    showForm(formCode = null) {
      this.formParams = this.forms.find(form => form.code === (formCode || this.code))
      this.formValues = null
      this.isFormOpened = true
    },
    editRow(row, formCode = null) {
      if (!row) return false
      if (this.form.custom_row_edit) {

        this.axios.get(this.localeUrl(`/api/bigdata/forms/${this.code}/form-by-row`), {params: {row: this.selectedRow}}).then(({data}) => {
          this.formParams = this.forms.find(form => form.code === data.form)
          this.formValues = row
          this.isFormOpened = true
        })

        return
      }

      this.formParams = this.forms.find(form => form.code === (formCode || this.code))
      this.formValues = row
      this.isFormOpened = true
    },
    deleteRow(row, rowIndex) {
      this.$bvModal.msgBoxConfirm('Вы хотите удалить запись?', {
        okTitle: this.trans('app.yes'),
        cancelTitle: this.trans('app.no'),
      })
          .then(result => {
            if (result === true) {
              this.axios.delete(this.localeUrl(`/api/bigdata/forms/${this.code}/${row.id}`)).then(({data}) => {
                this.rows.splice(rowIndex, 1)
              })
            }
          })
    },
    getCellValue(row, column) {
      if (
          typeof this.dictFields[column.code] !== 'undefined'
          && typeof this.getDict(this.dictFields[column.code]) !== 'undefined'
      ) {
        let dict = this.getDict(this.dictFields[column.code])

        let value = dict.find(item => item.id === row[column.code])
        if (value) {
          return value.name
        }

      }

      if (column.type === 'date') {
        return moment(row[column.code]).format('DD.MM.YYYY')
      }

      if (column.type === 'datetime') {
        return moment(row[column.code]).format('DD.MM.YYYY HH:MM')
      }

      return row[column.code]
    },
    showHistory(row) {
      this.axios.get(this.localeUrl(`/api/bigdata/forms/${this.code}/history`), {
        params: {
          id: row.id
        }
      }).then(({data}) => {
        this.history = data
        this.isHistoryShowed = true
      })
    }
  }
}
</script>
<style lang="scss" scoped>
.table-container {
  background-color: #272953;
  overflow-y: auto;
  overflow-x: auto;
  width: 100%;
  color: white;

  &-table {
    width: 100%;

    th {
      font-weight: normal;
      padding: 5px 13px;
      vertical-align: middle;

      p {
        margin: 0;
      }
    }

    tr {
      &.selected {
        filter: saturate(2);
      }

      td {
        background: #272953;
      }

      &:nth-child(2n) {
        td {
          background: #31355E;
        }
      }
    }
  }

  &-header {
    text-align: right;
    padding: 14px 20px;
    background-color: #32346C;
  }

  &-column-header {
    background-color: #505684;
    min-height: 50px;
    text-align: center;

    .row {
      flex-wrap: nowrap;
      height: 100%;
    }
  }

  .table-container-element {
    background-color: #272953;

    .table-container-svg {
      display: flex;
    }

    .svg-element {
      padding: 5px 13px 5px 23px;
      display: grid;

      svg {
        margin-left: auto;
        margin-right: auto;
        margin-top: auto;
        margin-bottom: auto;
      }
    }

    .element-position {
      padding: 9px 13px;

      p {
        float: right;
        margin-top: auto;
        margin-bottom: auto;
        margin-left: auto;
      }

      .title {
        margin-left: unset !important;
        margin-right: auto !important;
      }

      svg {
        margin: auto;
      }
    }

    .row {
      min-height: 40px;

      &:nth-child(2n) {
        background-color: #31355E;
      }
    }
  }

  .row {
    margin-right: 0;
  }

  .table-border {
    border: 1px solid #464D7A;
    border-bottom: none;
    border-top: none;
    vertical-align: middle;
  }
}
</style>