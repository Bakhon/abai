<template>
  <div class="bd-forms col">
    <div class="row">
      <div class="col-12 blueblock one">
        <div class="d-flex justify-content-between">
          <div class="d-flex align-items-center">
            <svg class="icon-one" fill="none" height="18" viewBox="0 0 20 18" width="20"
                 xmlns="http://www.w3.org/2000/svg">
              <path clip-rule="evenodd"
                    d="M18.8229 6.3871H14.1176V0H18.8229C19.4719 0 19.999 0.52117 19.999 1.16407V5.22303C19.999 5.86441 19.4724 6.3871 18.8229 6.3871ZM1.177 6.3871C0.527381 6.3871 0 5.86593 0 5.22303V1.16407C0 0.522683 0.526964 0 1.177 0H12.9412V6.3871H1.177ZM1.47079 3.77419C1.30808 3.77419 1.17647 3.64299 1.17647 3.48115V2.90595C1.17647 2.74162 1.30825 2.6129 1.47079 2.6129H7.94097C8.10368 2.6129 8.23529 2.7441 8.23529 2.90595V3.48115C8.23529 3.64548 8.10352 3.77419 7.94097 3.77419H1.47079ZM20 16.837V7.23652C19.6538 7.4348 19.2518 7.54839 18.8229 7.54839H1.17937C0.749402 7.54839 0.34666 7.43506 0 7.23704V16.837C0 17.4793 0.524673 18 1.17643 18H18.8236C19.4733 18 20 17.4809 20 16.837ZM1.47071 10.4516C1.31034 10.4516 1.17647 10.3204 1.17647 10.1586V9.58336C1.17647 9.41904 1.3082 9.29032 1.47071 9.29032H11.4705C11.6308 9.29032 11.7647 9.42152 11.7647 9.58336V10.1586C11.7647 10.3229 11.633 10.4516 11.4705 10.4516H1.47071ZM1.47079 13.3548C1.30808 13.3548 1.17647 13.2236 1.17647 13.0618V12.4866C1.17647 12.3223 1.30825 12.1935 1.47079 12.1935H7.94097C8.10368 12.1935 8.23529 12.3247 8.23529 12.4866V13.0618C8.23529 13.2261 8.10352 13.3548 7.94097 13.3548H1.47079ZM1.47005 16.2581C1.30805 16.2581 1.17647 16.1269 1.17647 15.965V15.3898C1.17647 15.2255 1.30791 15.0968 1.47005 15.0968H9.70643C9.86842 15.0968 10 15.228 10 15.3898V15.965C10 16.1293 9.86856 16.2581 9.70643 16.2581H1.47005ZM18.6682 2.5021C18.8439 2.31861 18.8439 2.02112 18.6682 1.83763C18.4925 1.65414 18.2076 1.65414 18.0318 1.83763L16.4938 3.44354L15.9682 2.8948C15.7925 2.71131 15.5076 2.71131 15.3318 2.8948C15.1561 3.07829 15.1561 3.37578 15.3318 3.55927L16.0483 4.30735C16.2943 4.56423 16.6932 4.56423 16.9392 4.30735L18.6682 2.5021Z"
                    fill="#9EA4C9"
                    fill-rule="evenodd"/>
            </svg>
            <p class="title-one">Форма ввода</p>

            <div class="forms-list__search">
              <input v-model="formNameQuery" placeholder="Журнал" type="text">
            </div>

          </div>

          <div class="block-toggle" @click="toggleFormsList">
            <svg fill="none" height="20" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg">
              <path
                  d="M9 6H6C5.44772 6 5 6.44772 5 7V18C5 18.5523 5.44772 19 6 19H17C17.5523 19 18 18.5523 18 18V15M11.5 12.5L19 5M19 5V10.5M19 5H13.5"
                  stroke="white" stroke-linecap="round" stroke-width="1.4"/>
            </svg>
            <span v-if="formsListExpanded">Свернуть</span>
            <span v-else>Развернуть</span>
          </div>
        </div>
        <div
            :class="{'blueblock__buttons_full': formsListExpanded}"
            class="blueblock__buttons d-flex flex-wrap scrollable"
        >
          <div v-for="form in filteredForms" class="blueblock__buttons-button" @click="loadForm(form.code)">
            <div
                :class="{'active': activeForm === form}"
                class="d-flex flex-row justify-content-center block-one-icon"
                v-html="form.ico"
            >
            </div>
            <div class="block-one-title text-center" v-html="form.name"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 blueblock three">
        <div v-if="activeForm" class="col-12 blueblock three">
          <BigDataPlainFormWrapper v-if="activeForm.type === 'plain'" :params="activeForm"
                                   :well-id="wellId"></BigDataPlainFormWrapper>
          <BigDataTableFormWrapper v-else-if="activeForm.type === 'table'"
                                   :params="activeForm"></BigDataTableFormWrapper>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import forms from '../../json/bd/forms.json'
import BigDataPlainFormWrapper from './forms/PlainFormWrapper'
import BigDataTableFormWrapper from './forms/TableFormWrapper'

export default {
  props: {
    wellId: {
      type: Number,
      required: true
    },
  },
  data() {
    return {
      forms: forms,
      activeForm: null,
      formNameQuery: null,
      formsListExpanded: false
    }
  },
  components: {
    BigDataTableFormWrapper,
    BigDataPlainFormWrapper
  },
  computed: {
    filteredForms() {

      if (this.formNameQuery) {
        return this.forms.filter(button => button.name.toLowerCase().indexOf(this.formNameQuery.trim().toLowerCase()) > -1)
      }

      return this.forms
    }
  },
  mounted() {

    this.activeForm = this.forms[Object.keys(this.forms)[0]]

  },
  methods: {
    loadForm(form) {
      this.activeForm = this.forms.find(formItem => formItem.code === form)
    },
    toggleFormsList() {
      this.formsListExpanded = !this.formsListExpanded
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
}
</style>
