<template>
  <div class="row m-0 p-0">
    <cat-loader v-show="isloading"/>
    <div class="col col-9 p-0">
      <proto-form :wellId="wellId"></proto-form>
    </div>
    <div class="col col-3 p-0">
      <proto-org-select-tree
          @modalChangeVisible="(value) => modalChangeVisible(value)"
          @wellIdChange="wellIdChange"
          @changeOrgSelector="(data) => changeOrgSelector(data)">
      </proto-org-select-tree>
    </div>
    <proto-wells-select-modal
        v-if="isModalShow"
        :wellsSelectorData="wellsSelectorData"
        @wellIdChange="(id) => wellIdChange(id)"
        @close="modalChangeVisible(false)">
    </proto-wells-select-modal>
  </div>
</template>

<script>

export default {
  data() {
    return {
      wellId: 0,
      isModalShow: false,
      isloading: false,
      wellsSelectorData: [],
    }
  },
  methods: {
    wellIdChange(wellId) {
      this.wellId = wellId;
      this.modalChangeVisible(false)
    },
    modalChangeVisible(value) {
      if (this.wellsSelectorData.length > 0) {
        this.isModalShow = value;
      }
    },
    changeOrgSelector(data) {
      this.wellsSelectorData = '';
      if (data.length > 0) {
        this.wellsSelectorData = data;
      }
    }
  }
}
</script>

<style lang="scss">
.bd-forms {

  .blueblock {
    background-color: #272953 !important;
    margin: 7px;

    &.one {
      padding: 16px 24px 10px;
    }

    &__buttons {
      background: #31335F;
      border-radius: 8px;
      height: 136px;
      line-height: 17px;
      margin: 12px 0 0;
      overflow: hidden;
      padding: 18px 35px 16px;

      &_full {
        height: auto;
      }

      &-button {
        margin-bottom: 20px;
        width: 9%;
      }
    }
  }

  .two {
    height: 335px
  }

  .three {
    padding: 0 24px 15px;
    @media (max-width: 1200px) {
      height: auto;
    }
  }

  .protobutton {
    position: absolute;
    bottom: 15px;
    width: calc(100% - 30px);
  }

  .icon-one {
    margin-right: 14px;
  }

  .title-one {
    color: #fff;
    font-size: 20px;
    font-weight: 400;
    line-height: 1;
    margin: 0;
  }

  .block-one-icon {
    margin: 0 0 12px;

    &.active {
      svg {
        rect {
          fill: #2C44BD;
        }

        path {
          fill: #fff;
        }
      }
    }
  }

  .block-one-title {
    font-size: 14px;
    color: #fff;
    white-space: nowrap;
  }

  .block-two-header {
    margin: 16px 24px auto 24px;
  }

  .block-two-reload {
    margin: 5px auto auto 20px;
  }

  #block-two-datepicker {
    background-color: #1A1D46;
    border: none;
    width: 127px;
    height: 24px;
    color: #9EA4C9;
  }

  .block-two-child {
    background-color: #2B2E5E;
    height: 269px;
    margin-top: 50px;
  }

  .block-two-child-cards {
    width: 438px;
  }


  .block-form-header {
    display: flex;
    justify-content: space-between;
    margin: 16px 24px auto 24px;
  }

  .block-three-edit {
    margin-left: 15px;
    margin-right: 20px;
  }

  .excel-title {
    color: #fff;
    font-size: 12px;
    margin-top: 5px;
    margin-left: 7px;
  }

  .block-four-title {
    margin-bottom: 30px;
    font-size: 22px;
    font-weight: 700;
  }

  .report-filter {
    &-content {
      &-wrapper {
        color: white;
        height: calc(100% - 14px);
        margin-right: -7px;
        position: relative;
        padding: 20px 15px 100px;
        @media (max-width: 768px) {
          margin: 0 -20px 0 -7px;
        }
      }
    }

    &-items {
      @media(max-width: 1200px) {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
      }

      .filter-group {
        @media (max-width: 1200px) {
          width: 32%;
        }
        @media (max-width: 768px) {
          width: 48%;
        }
      }
    }
  }


  .scrollable {
    &::-webkit-scrollbar {
      height: 10px;
      width: 4px;
    }

    &::-webkit-scrollbar-track {
      background: #40467E;
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
  }

  .forms-list {
    &.expand {
      bottom: 0;
      left: 0;
      position: absolute;
      right: 0;
      top: 0;
      z-index: 100;

      .blueblock__buttons {
        height: auto;
      }
    }

    &__search {
      margin-left: 41px;
      position: relative;

      input {
        background: #393D75;
        border: 0.4px solid #656A8A;
        border-radius: 4px;
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        display: block;
        height: 30px;
        padding: 0 10px 0 46px;
        width: 290px;

        &::placeholder {
          color: #eaeaea;
        }
      }

      &:before {
        background: #42487D;
        content: "";
        height: 16px;
        left: 38px;
        position: absolute;
        top: 7px;
        width: 1px;
      }

      &:after {
        background: url(/img/bd/search.svg) no-repeat;
        content: "";
        height: 20px;
        left: 10px;
        position: absolute;
        top: 5px;
        width: 20px;
      }
    }
  }

  .block-toggle {
    align-items: center;
    display: flex;
    color: #fff;

    span {
      margin-left: 5px;
    }
  }

  .bd-main-block {
    .table-container {
      height: calc(100vh - 360px);
    }
  }
}
</style>