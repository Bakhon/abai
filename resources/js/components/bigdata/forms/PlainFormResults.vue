<template>
  <div>
    <cat-loader v-show="isLoading"/>
    <div v-if="rows" class="table-container scrollable">
      <div class="table-container-header">

        <svg fill="none" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg"
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
            <th class="table-border"><p class="title">ID</p></th>
            <th v-for="column in columns" class="table-border"><p class="title">{{ column.title }}</p>
            </th>
            <th class="table-border"><p class="title">Управление</p></th>
          </tr>
          </thead>
          <tbody class="table-container-element">
          <tr v-for="(row, index) in rows">
            <td class="table-border element-position">
              <p class="title">{{ row.id }}</p>
            </td>
            <td v-for="column in columns" class="table-border element-position">
              <p>{{ getCellValue(row, column) }}</p>
            </td>
            <td class="table-border element-position">
              <div class="table-container-svg">
                <svg fill="none" height="18" viewBox="0 0 18 18" width="18" xmlns="http://www.w3.org/2000/svg"
                     @click.prevent="editRow(row)">
                  <path
                      d="M3 11.4998L1.55336 16.322C1.53048 16.3983 1.6016 16.4694 1.67788 16.4465L6.5 14.9998M3 11.4998C3 11.4998 11.0603 3.4393 12.7227 1.77708C12.8789 1.62091 13.1257 1.6256 13.2819 1.78177C13.8372 2.33702 15.1144 3.61422 16.2171 4.71697C16.3733 4.87322 16.3788 5.12103 16.2226 5.27726C14.5597 6.9399 6.5 14.9998 6.5 14.9998M3 11.4998L3.64727 10.8525L7.14727 14.3525L6.5 14.9998"
                      stroke="white" stroke-width="1.4"/>
                </svg>
                <svg fill="none" height="14" viewBox="0 0 14 14" width="14" xmlns="http://www.w3.org/2000/svg"
                     @click.prevent="deleteRow(row, index)">
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
  </div>
</template>

<script>
import forms from '../../../json/bd/forms.json'
import BigDataPlainForm from './PlainForm'
import {bdFormActions} from '@store/helpers'
import CatLoader from '../../ui-kit/CatLoader'

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
    CatLoader
  },
  data() {
    return {
      forms: forms,
      header: null,
      rows: null,
      columns: null,
      isFormOpened: false,
      formValues: null,
      formParams: null,
      dictFields: {},
      isLoading: false,
      hasFormError: false
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
        this.loadDictionaries()
      })

      this.axios.get(
          this.localeUrl(`/api/bigdata/forms/${this.code}/results`),
          {params: {well_id: this.wellId}}
      ).then(({data}) => {
        this.rows = data.rows
        this.columns = data.columns
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
    showForm() {
      this.formParams = this.forms.find(form => form.code === this.code)
      this.formValues = null
      this.isFormOpened = true
    },
    editRow(row) {
      this.formParams = this.forms.find(form => form.code === this.code)
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

      return row[column.code]
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

    tr:nth-child(2n) {
      td {
        background: #31355E;
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