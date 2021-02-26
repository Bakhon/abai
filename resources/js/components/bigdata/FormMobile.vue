<template>
  <div class="bd-form-mobile">
    <notifications position="top"></notifications>
    <form ref="form" style="width: 100%">
      <template v-if="selectedItem">
        <ScrollPicker v-model="formValues[selectedItem.code]" :item="selectedItem" @close="saveItemValue">
        </ScrollPicker>
      </template>
      <template v-else-if="selectedBlock">
        <a class="bd-form-mobile__back" href="#" @click="selectedBlock = null">
          <svg fill="none" height="28" viewBox="0 0 17 28" width="17" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 2L3 14L15 26" stroke="white" stroke-linecap="round" stroke-width="4"/>
          </svg>
          <span>Назад</span>
        </a>
        <div class="bd-form-mobile__items">
          <div
              v-for="item in selectedBlock.items"
              class="bd-form-mobile__item"
              @click="selectedItem = item"
          >
            <span class="bd-form-mobile__item-img" v-html="item.ico"></span>
            <span class="bd-form-mobile__item-name">{{ item.name }}</span>
          </div>
        </div>
      </template>
      <div v-else class="bd-form-mobile__blocks">
        <template v-for="(block, index) in fields.blocks">
          <div
              class="bd-form-mobile__item"
              @click="selectedBlock = block"
          >
            <span class="bd-form-mobile__item-img" v-html="block.ico"></span>
            <span class="bd-form-mobile__item-name">{{ block.name }}</span>
          </div>
        </template>
      </div>
    </form>
  </div>
</template>
<script>
import mobileFormFields from '../../json/bd/mobile_form.json'
import ScrollPicker from '../common/ScrollPicker'

export default {
  name: "bigdata-form-mobile",
  components: {
    ScrollPicker
  },
  data: function () {
    return {
      errors: {},
      formValues: {},
      fields: mobileFormFields,
      selectedBlock: null,
      selectedItem: null,
    }
  },
  mounted() {

    this.axios.get(this.localeUrl('/bigdata/mobileform/values')).then(({data}) => {
      this.formValues = data
    })

  },
  methods: {
    closeItemForm() {
      this.selectedItem = null
    },
    saveItemValue() {

      this.axios.post(this.localeUrl('/bigdata/mobileform'), {
        code: this.selectedItem.code,
        value: this.formValues[this.selectedItem.code],
      })

      this.selectedItem = null
    }
  },
};
</script>
<style lang="scss">
.bd-form-mobile {
  background: #272953;
  padding: 30px 38px;
  position: relative;
  max-width: 736px;

  @media (max-width: 768px) {
    padding: 3vw 3.8vw;
  }

  &__blocks {
    padding: 124px 0;
    @media (max-width: 768px) {
      padding: 11vw 0;
    }
  }

  &__back {
    align-items: center;
    color: #fff;
    display: flex;
    font-size: 32px;
    font-weight: bold;
    left: 42px;
    position: absolute;
    top: 32px;
    @media (max-width: 768px) {
      font-size: 3vw;
      top: 3vw;
      left: 4vw;
    }

    span {
      margin-left: 20px;
      position: relative;
      top: 2px;
    }

    &:hover {
      color: #fff;
      text-decoration: none;
    }
  }

  &__items {
    padding: 124px 0;
    @media (max-width: 768px) {
      display: flex;
      flex-direction: column;
      justify-content: center;
      min-height: calc(100% - 55px);
      padding: 11vw 0;
    }
  }

  &__item {
    align-items: center;
    background: #3366FF;
    color: #fff;
    display: flex;
    font-size: 32px;
    font-weight: bold;
    justify-content: center;
    line-height: 1.2;
    margin-top: 60px;
    padding: 10px 95px;
    height: 180px;
    @media (max-width: 768px) {
      font-size: 3vw;
      height: 17vw;
      margin-top: 5vw;
      padding: 1vw 8vw;
    }

    &:first-child {
      margin-top: 0;
    }

    &-img {
      margin-right: 23px;
      text-align: center;
      width: 79px;
    }
  }
}
</style>