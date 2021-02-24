<template>
  <div class="bd-main-block">
    <notifications position="top"></notifications>
    <div class="bd-main-block__header">
      <p class="bd-main-block__header-title">{{ params.title }}</p>
    </div>
    <datetime
        v-model="date"
        :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
        :phrases="{ok: 'Выбрать', cancel: 'Выход'}"
        auto
        type="date"
        value-zone="Asia/Almaty"
        zone="Asia/Almaty"
    >
    </datetime>
    <form ref="form" class="bd-main-block__form" style="width: 100%">
      <div class="table-page">
        <table class="table">
          <thead>
          <tr>
            <th v-for="column in columns">
              {{ column.name }}
            </th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(row, rowIndex) in rows.data">
            <td
                v-for="column in columns"
                :class="{'editable': column.editable}"
                @dblclick="editCell(row, column)"
            >
              <a v-if="column.type === 'link'" href="#">{{ row[column.code] }}</a>
              <template v-else-if="column.type === 'text'">
                <div v-if="isCellEdited(row, column)" class="input-wrap">
                  <input v-model="row[column.code]" type="text">
                  <button type="button" @click.prevent="saveCell()">OK</button>
                </div>
                <span v-else>
                  {{ row[column.code] }}
                </span>
              </template>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </form>
  </div>
</template>

<script>
import moment from 'moment'
import {Datetime} from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'

Vue.use(Datetime)

export default {
  name: "BigdataTable",
  props: {
    params: {
      type: Object,
      required: true
    },
  },
  data() {
    return {
      errors: {},
      formValues: {},
      form: {},
      activeTab: 0,
      date: moment().toISOString(),
      rows: [],
      columns: [],
      editableCell: {
        row: null,
        column: null
      }
    }
  },
  watch: {
    date(newValue, oldValue) {
      if (!moment(newValue).isSame(moment(oldValue), 'day')) {
        this.getData()
      }
    }
  },
  mounted() {

    this.getData()

  },
  methods: {
    getData() {
      this.axios.get(this.localeUrl('/bigdata/form/' + this.params.code), {
        params: {
          date: this.date
        }
      }).then(({data}) => {
        this.form = data.params
        this.rows = data.rows
        this.columns = data.columns
      })
    },
    editCell(row, column) {
      this.editableCell.row = row
      this.editableCell.column = column
    },
    isCellEdited(row, column) {
      if (!column.editable) return false
      if (this.editableCell.row !== row) return false
      if (this.editableCell.column !== column) return false

      return true
    },
    saveCell() {
      this.editableCell = {
        row: null,
        cell: null
      }
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

  &__form {
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
    .table {
      td {
        height: 52px;
      }

      .editable {
        span {
          position: relative;

          &:after {
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

          input[type="text"] {
            background: #1F2142;
            border: 0.5px solid #454FA1;
            border-radius: 4px;
            color: #fff;
            font-size: 14px;
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