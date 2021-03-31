<template>
  <div v-if="item" class="bd-history">
    <a class="bd-history__close" @click.prevent="$emit('close')">{{ trans('bd.close') }}</a>
    <h1>История изменений {{ item.uwi.name }}</h1>
    <div v-if="history.length > 0" class="bd-history__main">
      <div class="col-3 history__list scrollable">
        <div
            v-for="(historyItem, index) in history"
            :key="`history_${index}`"
            :class="{'history__list-item_active': selectedItem && selectedItem.id === historyItem.id}"
            class="history__list-item"
            @click="showHistoryItem(index)"
        >
          <p><b>{{ historyItem.user }}</b></p>
          <p>{{ historyItem.updated_at | moment().format('YYYY-MM-DD HH:mm') }}</p>
        </div>
      </div>
      <div class="col-9 history__fields scrollable">
        <table v-if="selectedItem" class="table table-bordered scrollable">
          <tr>
            <th><b>{{ trans('app.param_name') }}</b></th>
            <th>
              <p><b>{{ previousUser }}</b></p>
              <span>{{ previousDate | moment().format('YYYY-MM-DD HH:mm') }}</span>
            </th>
            <th>
              <p><b>{{ selectedItem.user }}</b></p>
              <span>{{ selectedItem.updated_at | moment().format('YYYY-MM-DD HH:mm') }}</span>
            </th>
          </tr>
          <tr v-for="column in editableColumns"
              :class="{'changed': typeof selectedItem.payload[column.code] !== 'undefined'}">
            <td>{{ trans(column.title) }}</td>
            <td>{{ calculateOldValue(column, selectedItem.updated_at) }}</td>
            <td>{{
                typeof selectedItem.payload[column.code] !== 'undefined' ? selectedItem.payload[column.code] : calculateOldValue(column, selectedItem.updated_at)
              }}
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment'

export default {
  name: "BigdataHistory",
  props: {
    item: {
      type: Object,
      required: true
    },
    columns: {
      type: Array,
      required: true
    },
    date: {
      type: String,
      required: true
    },
    formName: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      history: [],
      selectedIndex: null,
      selectedItem: null,
      previousUser: null,
      previousDate: null
    }
  },
  watch: {
    date() {
      this.fetchHistory()
    }
  },
  computed: {
    editableColumns() {
      return this.columns.filter(column => !!column.is_editable)
    }
  },
  mounted() {
    this.fetchHistory()
  },
  methods: {
    fetchHistory() {
      this.axios.get(this.localeUrl(`/bigdata/form/${this.formName}/history`), {
        params: {
          date: this.date,
          id: this.item.uwi.id
        }
      }).then(({data}) => {
        this.history = data.data
      })
    },
    showHistoryItem(index) {

      this.selectedIndex = index
      this.selectedItem = this.history[index]

      if (typeof this.history[index + 1] !== 'undefined') {
        this.previousDate = this.history[index + 1].updated_at
        this.previousUser = this.history[index + 1].user
      } else {
        this.previousDate = this.previousUser = ''
      }

    },
    calculateOldValue(column, date) {
      let value = null
      this.history
          .filter(item => moment(item.updated_at) < moment(date))
          .forEach(item => {
            if (typeof item.payload[column.code] !== 'undefined') {
              value = item.payload[column.code]
            }
          })

      return value
    }
  }
}
</script>
<style lang="scss">
.bd-history {
  padding: 15px;
  position: relative;
  width: 100%;

  &__close {
    color: #fff;
    font-size: 15px;
    background: #656A8A;
    border-radius: 5px;
    cursor: pointer;
    padding: 3px 12px;
    position: absolute;
    right: 15px;
    top: 15px;

    &:hover {
      color: #fff;
      text-decoration: none;
    }
  }

  &__main {
    align-items: stretch;
    display: flex;
    height: calc(100% - 80px);

    .history {
      &__list {
        &-item {
          color: #fff;
        }
      }

      &__fields {
        overflow-y: auto;
      }
    }
  }
}
</style>