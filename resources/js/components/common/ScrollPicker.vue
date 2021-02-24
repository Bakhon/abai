<template>
  <div class="scroll-picker">
    <a class="bd-form-mobile__back" href="#" @click="$emit('close')">
      <svg fill="none" height="28" viewBox="0 0 17 28" width="17" xmlns="http://www.w3.org/2000/svg">
        <path d="M15 2L3 14L15 26" stroke="white" stroke-linecap="round" stroke-width="4"></path>
      </svg>
      <span>Назад</span>
    </a>
    <div class="scroll-picker__title">
      <span class="scroll-picker__title-ico" v-html="item.ico"></span>
      <span class="scroll-picker__title-name">{{ item.name }}</span>
    </div>
    <smooth-picker ref="smoothPicker" :change="change" :data="data"/>
    <button v-if="valueChanged" class="scroll-picker__button" @click.prevent="save">OK</button>
  </div>
</template>

<script>

import SmoothPicker from "./SmoothPicker";

const INTEGER_PART = 0
const FRACTIONAL_PART = 1


export default {
  props: {
    value: {
      type: Number
    },
    item: {
      type: Object
    }
  },
  components: {
    SmoothPicker
  },
  data() {
    return {
      data: [
        {
          currentIndex: 0,
          flex: 3,
          list: [],
          textAlign: 'center',
        },
        {
          currentIndex: 0,
          flex: 3,
          list: [],
          textAlign: 'center',
        },
      ],
      pickerValue: [],
      valueChanged: false
    }
  },
  beforeMount() {
    this.setupSmoothPickerValue()
  },
  methods: {
    setupSmoothPickerValue() {

      let value = this.value.toString().split('.')

      this.setupIntegerPart(value)
      this.setupFractionalPart(value)

      this.pickerValue = [
        this.data[INTEGER_PART].list[this.data[INTEGER_PART].currentIndex],
        this.data[FRACTIONAL_PART].list[this.data[FRACTIONAL_PART].currentIndex]
      ]

    },
    setupIntegerPart(value) {
      let integerValues = _.range(this.item.min, this.item.max).map((itemValue, index) => {
        return itemValue.toString()
      })

      this.data[INTEGER_PART].list = integerValues
      this.data[INTEGER_PART].currentIndex = integerValues.findIndex(item => item === value[INTEGER_PART])
    },
    setupFractionalPart(value) {
      let fractionalValues = _.range(0, 10).map((itemValue, index) => {
        return itemValue.toString()
      })

      this.data[FRACTIONAL_PART].list = fractionalValues
      this.data[FRACTIONAL_PART].currentIndex = fractionalValues.findIndex(item => item === value[FRACTIONAL_PART])
    },
    change(listIndex, valueIndex) {
      this.pickerValue[listIndex] = this.data[listIndex].list[valueIndex]
      this.valueChanged = this.value !== Number(this.pickerValue.join('.'))
    },
    save() {
      this.$emit('input', Number(this.pickerValue.join('.')))
      this.$emit('close')
    }
  }
}
</script>

<style lang="scss">

.scroll-picker {
  &__title {
    align-items: center;
    color: #fff;
    display: flex;
    justify-content: center;

    &-ico {
      margin-right: 37px;
      @media (max-width: 768px) {
        margin-right: 3.5vw;
      }

      svg {
        path {
          stroke: #3366ff;
        }
      }
    }

    &-name {
      font-size: 32px;
      font-weight: bold;
      @media (max-width: 768px) {
        font-size: 3vw;
      }
    }
  }

  &__button {
    background: #3366FF;
    border: none;
    color: #fff;
    font-size: 32px;
    font-weight: bold;
    height: 76px;
    text-align: center;
    width: 100%;
    @media (max-width: 768px) {
      font-size: 3vw;
      height: 7vw;
    }
  }
}
</style>