<template>
  <div class="bd-main-block">
    <cat-loader v-show="isloading"/>
    <notifications position="top"></notifications>
    <div class="bd-main-block__header">
      <p class="bd-main-block__header-title">{{ params.title }}</p>
    </div>
    <div class="bd-main-block__date">
      <span>{{ trans('bd.date') }}:</span>
      <datetime
          v-model="date"
          :flow="['year', 'month', 'date']"
          :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
          :phrases="{ok: trans('bd.select'), cancel: trans('bd.exit')}"
          auto
          input-class="form-control"
          type="date"
          value-zone="Asia/Almaty"
          zone="Asia/Almaty"
      >
      </datetime>
    </div>
    <div class="bd-main-block__body">
      <div v-if="history.item" class="bd-main-block__body-history">
        <big-data-history
            :columns="formParams.columns"
            :date="date"
            :form-name="params.code"
            :item="history.item"
            v-on:close="history.item=null"
        >
        </big-data-history>
      </div>
      <template v-else>
      <div class="bd-main-block__tree scrollable">
        <b-tree-view
            v-if="filterTree.length"
            :contextMenu="false"
            :contextMenuItems="[]"
            :data="filterTree"
            :renameNodeOnDblClick="false"
            nodeLabelProp="label"
            v-on:nodeSelect="filterForm"
        ></b-tree-view>
      </div>
      <form ref="form" class="bd-main-block__form scrollable" style="width: 100%">
        <div class="table-page">
          <p v-if="!tech" class="table__message">{{ trans('bd.select_dzo') }}</p>
          <p v-else-if="rows.length === 0" class="table__message">{{ trans('bd.nothing_found') }}</p>
          <div v-else class="table-wrap scrollable">
            <table v-if="rows.length" class="table">
              <thead>
              <tr>
                <th v-for="column in formParams.columns">
                  {{ column.title }}
                </th>
                <th></th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="(row, rowIndex) in rows">
                <td
                    v-for="column in formParams.columns"
                    :class="{'editable': column.isEditable}"
                    @dblclick="editCell(row, column)"
                >
                  <a v-if="column.type === 'link'" :href="row[column.code].href">{{ row[column.code].name }}</a>
                  <template v-else-if="['text', 'integer', 'float'].indexOf(column.type) > -1">
                    <div v-if="isCellEdited(row, column)" class="input-wrap">
                      <input v-model="row[column.code].value" class="form-control" type="text">
                      <button type="button" @click.prevent="saveCell(row, column)">OK</button>
                      <span v-if="errors[column.code]" class="error">{{ showError(errors[column.code]) }}</span>
                    </div>
                    <template v-else>
                      <span class="value">{{ row[column.code] ? row[column.code].value : '' }}</span>
                      <span v-if="row[column.code] && row[column.code].date" class="date">
                        {{ row[column.code].date | moment().format('YYYY-MM-DD') }}
                      </span>
                      </template>
                    </template>
                  </td>
                  <td>
                    <a class="links__item links__item_history" @click="showHistory(row)"></a>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </form>
      </template>
    </div>
  </div>
</template>

<script>
import moment from 'moment'
import {Datetime} from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
import {bTreeView} from 'bootstrap-vue-treeview'
import {bdFormActions, bdFormState} from '@store/helpers'
import BigDataHistory from './history'

Vue.use(Datetime)

export default {
  name: "BigdataTable",
  props: {
    params: {
      type: Object,
      required: true
    },
  },
  components: {
    bTreeView,
    BigDataHistory
  },
  data() {
    return {
      errors: {},
      formValues: {},
      activeTab: 0,
      date: moment().toISOString(),
      filterTree: [],
      tech: null,
      currentPage: 1,
      rows: [],
      columns: [],
      editableCell: {
        row: null,
        column: null
      },
      isloading: false,
      history: {
        item: null
      }
    }
  },
  watch: {
    date() {
      this.updateRows()
    }
  },
  computed: {
    ...bdFormState([
      'formParams'
    ]),
  },
  mounted() {

    this.updateForm(this.params.code).then(data => {
      this.filterTree = data.filterTree
    })

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
      this.axios.get(this.localeUrl(`/bigdata/form/${this.params.code}/rows`), {
        params: {
          date: this.date,
          tech: this.tech
        }
      })
          .then(({data}) => {
            this.rows = data
          })
          .finally(() => {
            this.isloading = false
          })

    },
    editCell(row, column) {
      this.editableCell.row = row
      this.editableCell.column = column
    },
    isCellEdited(row, column) {
      if (!column.isEditable) return false
      if (this.editableCell.row !== row) return false
      if (this.editableCell.column !== column) return false

      return true
    },
    saveCell(row, column) {

      let data = {
        well_id: row.uwi.id,
        date: this.date,
      }
      data[column.code] = row[column.code].value
      this.isloading = true

      this.axios
          .patch(this.localeUrl(`/bigdata/form/${this.params.code}/save/${column.code}`), data)
          .then(({data}) => {
            row[column.code].date = null
            this.editableCell = {
              row: null,
              cell: null
            }
          })
          .catch(error => {
            Vue.set(this.errors, column.code, error.response.data.errors)
          })
          .finally(() => {
            this.isloading = false
          })

    },
    changePage(page = 1) {
      this.currentPage = page
      this.updateForm()
    },
    showError(err) {
      return err.join('<br>')
    },
    showHistory(row) {
      this.history.item = row
    }
  },
};
</script>
<style lang="scss">
.bd-main-block {
  max-width: 1340px;
  margin: 0 auto;

  &__header {
    align-items: center;
    display: flex;
    justify-content: space-between;
    margin: 16px 0 20px;

    &-title {
      color: #fff;
      font-weight: bold;
      font-size: 20px;
      line-height: 24px;
      margin: 0;
    }
  }

  &__date {
    align-items: center;
    display: flex;

    span {
      color: #fff;
      margin-right: 10px;
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

    &-tabs {
      &-header {
        display: flex;
        justify-content: flex-start;

        &-tab {
          align-items: center;
          background: #31335f;
          border-top-left-radius: 3px;
          border-top-right-radius: 3px;
          color: #8389AF;
          display: flex;
          font-size: 14px;
          font-weight: 600;
          height: 28px;
          margin-right: 15px;
          padding: 0 45px;
          @media (max-width: 768px) {
            padding: 0 15px;
          }

          &:hover {
            color: #fff;
          }

          &.active {
            background: #363b68;
            color: #fff;
          }

          p {
            margin-bottom: 0;
          }
        }
      }
    }

    &-tab {
      background: #363b68;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      padding: 10px;
    }

    &-block {
      background: #272953;
      border-left: 1px solid #454D7D;
      height: 600px;
      width: 50%;
      @media (max-width: 767px) {
        border-left: none;
        height: auto;
        width: 100%;
      }

      &_full {
        width: 100%;
      }

      &:first-child {
        border-left: none;
      }

      &-title {
        background: #333975;
        color: #FFFFFF;
        font-weight: bold;
        font-size: 14px;
        height: 48px;
        line-height: 48px;
        margin-bottom: 0;
        padding: 0 0 0 43px;
      }

      &-content {
        height: calc(100% - 50px);
        overflow-y: auto;
        padding: 20px 55px 10px 43px;
        @media (max-width: 767px) {
          height: auto;
        }

        &::-webkit-scrollbar {
          width: 4px;
        }

        &::-webkit-scrollbar-track {
          background: #20274F;
        }

        &::-webkit-scrollbar-thumb {
          background: #656A8A;
        }

        &::-webkit-scrollbar-thumb:hover {
          background: #656A8A;
        }

        &::-webkit-scrollbar-corner {
          background: #20274F;
        }

        label {
          font-size: 14px;
          font-weight: 600;
          line-height: 1;
          margin: 14px 0 10px;
        }

        & > div:first-child {
          label {
            margin-top: 0;
          }
        }

      }
    }

    &-buttons {
      background: #363b68;
      display: flex;
      justify-content: flex-end;
      padding: 0 20px 10px;

      button {
        background: #3366FF;
        border: none;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        margin-left: 8px;
        width: 116px;

        &.btn-info {
          background: #40467E;
        }
      }
    }
  }

  .table-page {
    height: 100%;
    margin: 0;
    padding: 0;

    .table-wrap {
      margin: 0 0 10px;
      overflow-y: auto;
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

      td {
        height: 52px;

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

          &.value:after {
            background: url(/img/bd/edit.svg) no-repeat;
            content: "";
            display: inline-block;
            height: 14px;
            opacity: 0;
            position: absolute;
            right: -20px;
            top: -2px;
            width: 14px;
          }
        }

        &:hover {
          span:after {
            opacity: 1;
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
            min-width: 120px;
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
}
</style>