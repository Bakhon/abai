<template>
  <div class="bd-main-block">
    <cat-loader v-show="isloading"/>
    <notifications position="top"></notifications>
    <div class="bd-main-block__header">
      <p class="bd-main-block__header-title">{{ params.title }}</p>
    </div>
    <div class="bd-main-block__date">
      <span class="bd-main-block__date-title">{{ trans('bd.date') }}:</span>
      <div class="bd-main-block__date-input">
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
    </div>
    <div class="bd-main-block__body">
      <div class="bd-main-block__tree scrollable">
        <b-tree-view
            v-if="filterTree.length"
            :contextMenu="false"
            :contextMenuItems="[]"
            :data="filterTree"
            :renameNodeOnDblClick="false"
            nodeLabelProp="name"
            v-on:nodeSelect="filterForm"
        ></b-tree-view>
      </div>
      <BigDataTableForm :date="date" :params="params" :tech="tech"></BigDataTableForm>
    </div>
  </div>
</template>

<script>
import moment from 'moment'
import {Datetime} from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
import {bTreeView} from 'bootstrap-vue-treeview'
import {bdFormActions} from '@store/helpers'
import BigDataTableForm from './TableForm'

Vue.use(Datetime)

export default {
  name: "BigDataTableFormWrapper",
  props: {
    params: {
      type: Object,
      required: true
    },
  },
  components: {
    bTreeView,
    BigDataTableForm
  },
  data() {
    return {
      date: moment().toISOString(),
      filterTree: [],
      tech: null,
      isloading: false
    }
  },
  watch: {
    params() {
      this.init()
    }
  },
  mounted() {
    this.init()
  },
  methods: {
    ...bdFormActions([
      'updateForm'
    ]),
    filterForm(item, isSelected) {
      if (isSelected) {
        if (item.data.type === 'org') return false
        this.tech = item.data.id
      }
    },
    init() {
      this.isloading = true
      this.updateForm(this.params.code).then(data => {
        this.filterTree = data.filterTree
        this.isloading = false
      })
    },
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
<style lang="scss">

.bd-popup {
  background: rgba(0, 0, 0, 0.7);
  height: 100%;
  left: 0;
  overflow: auto;
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