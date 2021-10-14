<template>
  <div class="bd-main-block">
    <div class="bd-main-block__header">
      <p class="bd-main-block__header-title">{{ params.title }}</p>
    </div>
    <div class="bd-main-block__filter">
      <template v-if="filter">
        <template v-if="formParams && formParams.filter">
          <template v-for="filterItem in formParams.filter">

            <span v-if="filterItem.title" class="bd-main-block__filter-title">{{ filterItem.title }}:</span>
            <div
                v-if="filterItem.type === 'date'"
                class="bd-main-block__filter-input bd-main-block__filter-input_date"
            >
              <datetime
                  v-model="filter[filterItem.code]"
                  :flow="filterItem.flow || ['year', 'month', 'date']"
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
            <div
                v-else
                class="bd-main-block__filter-input"
            >
              <bigdata-form-field
                  v-model="filter[filterItem.code]"
                  :item="filterItem"
                  :value="filterItem.default || null"
              >
              </bigdata-form-field>
            </div>
          </template>
        </template>
        <template v-else>
          <span class="bd-main-block__filter-title">{{ trans('bd.date') }}:</span>
          <div class="bd-main-block__filter-input">
            <datetime
                v-model="filter['date']"
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
        </template>
      </template>
    </div>
    <BigDataTableForm
        :id="id"
        :key="params.code"
        :filter="filter"
        :params="params"
        :type="type"
        @initialized="init"
    >
    </BigDataTableForm>
  </div>
</template>

<script>
import Vue from "vue";
import moment from 'moment'
import {Datetime} from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
import {bTreeView} from 'bootstrap-vue-treeview'
import {globalloadingMutations} from '@store/helpers'
import BigDataTableForm from './TableForm'
import BigdataFormField from './field'

Vue.use(Datetime)

export default {
  name: "BigDataTableFormWrapper",
  props: {
    params: {
      type: Object,
      required: true
    },
    id: {
      type: Number,
      required: false
    },
    type: {
      type: String,
      required: false
    },
  },
  components: {
    bTreeView,
    BigDataTableForm,
    BigdataFormField
  },
  data() {
    return {
      filter: null,
      formParams: null
    }
  },
  watch: {
    params() {
      this.filter = null
      this.init()
    },
    filter: {
      handler(val) {
        this.init()
      },
      deep: true
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    ...globalloadingMutations([
      'SET_LOADING'
    ]),
    filterForm(item, isSelected) {
      if (isSelected) {
        if (item.data.type === 'org') return false
        this.id = item.data.id
        this.type = item.data.type
      }
    },
    initFilter() {
      if (this.filter) return
      if (!this.formParams) return

      if (!this.formParams.filter) {
        this.filter = {date: moment().toISOString()}
        return
      }

      let filter = {}
      this.formParams.filter.forEach(filterItem => {
        let value = filterItem.default || null
        filter[filterItem.code] = filterItem.type === 'date' ? moment(value).toISOString() : value
      })

      this.filter = filter

    },
    init(formParams) {
      if (formParams) {
        this.formParams = formParams
        this.initFilter()
      }
    },
  },
};
</script>
<style lang="scss" scoped>
body.fixed {
  overflow: hidden;
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
<style lang="scss">
.bd-main-block {

  &__filter {
    align-items: center;
    display: flex;
    margin-bottom: 10px;

    &-title {
      color: #fff;
      margin-right: 10px;
    }

    &-input {
      margin-right: 15px;
      position: relative;

      &_date {
        &:after {
          background: url(/img/bd/calendar.svg) no-repeat;
          content: "";
          height: 28px;
          position: absolute;
          right: 0;
          top: 0;
          width: 28px;
        }
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

      .v-select {
        width: 300px;
      }
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
}

.bd-popup {
  background: rgba(0, 0, 0, 0.7);
  height: 100%;
  left: 0;
  overflow-y: auto;
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 1000;

  &__inner {
    background: #272953;
    border: 2px solid #656a8a;
    border-radius: 8px;
    color: #fff;
    left: 50%;
    max-width: 90%;
    min-width: 730px;
    padding: 20px 25px;
    position: absolute;
    top: 100px;
    transform: translateX(-50%);
    z-index: 1001;
  }

  &__close {
    background: #656A8A;
    border-radius: 7px;
    color: #fff;
    font-size: 14px;
    font-weight: bold;
    height: 26px;
    line-height: 26px;
    position: absolute;
    right: 19px;
    text-align: center;
    top: 14px;
    width: 87px;

    &:hover {
      color: #fff;
      text-decoration: none;
    }
  }

  &__title {
    font-size: 18px;
    margin-bottom: 30px;
  }

  .table {
    th {
      background: #2b2e5e;
      padding: 10px 5px;

      &:nth-child(2n + 1) {
        background: #2b40a9;
      }
    }

    tbody {
      tr {
        td {
          background: #2b2e5e;
          border: none;

          &:nth-child(2n + 1) {
            background: #343868;
          }

          a {
            color: #82BAFF;
          }
        }

        &:nth-child(2n + 1) {
          td {
            background: #343868;

            &:nth-child(2n + 1) {
              background: #383d6d;
            }
          }
        }
      }
    }
  }

}

</style>