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
    <div
        :class="{'scroll-picker__body_decimal': item.decimal_points > 0}"
        class="scroll-picker__body"
    >
      <smooth-picker v-if="showPicker" ref="smoothPicker" :change="change" :data="data"/>
    </div>
    <button v-if="isValueChanged" class="scroll-picker__button" @click.prevent="save">OK</button>
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
      isValueChanged: false,
      showPicker: false
    }
  },
  beforeMount() {
    this.setupSmoothPickerValue()
  },
  methods: {
    setupSmoothPickerValue() {

      let value = this.value ? this.value.toString().split('.') : null

      this.setupIntegerPart(value)
      this.setupFractionalPart(value)

      this.pickerValue = [
        this.data[INTEGER_PART].list[this.data[INTEGER_PART].currentIndex],
        this.data[FRACTIONAL_PART] ? this.data[FRACTIONAL_PART].list[this.data[FRACTIONAL_PART].currentIndex] : 0
      ]

      this.showPicker = true

    },
    setupIntegerPart(value) {
      let integerValues = _.range(this.item.min, this.item.max).map((itemValue, index) => {
        return itemValue.toString()
      })

      this.data[INTEGER_PART].list = integerValues
      this.data[INTEGER_PART].currentIndex = value ? integerValues.findIndex(item => item === value[INTEGER_PART]) : 0
    },
    setupFractionalPart(value) {

      let decimalPoints = this.item.decimal_points

      if (decimalPoints > 0) {

        let fractionalValues = _.range(0, 10 ^ decimalPoints - 1).map((itemValue, index) => {
          return itemValue.toString()
        })

        this.data[FRACTIONAL_PART].list = fractionalValues
        this.data[FRACTIONAL_PART].currentIndex = value ? fractionalValues.findIndex(item => item === value[FRACTIONAL_PART]) : 0

      } else {
        this.data.splice(FRACTIONAL_PART, 1)
      }
    },
    change(listIndex, valueIndex) {
      this.pickerValue[listIndex] = this.data[listIndex].list[valueIndex]
      this.isValueChanged = this.value !== Number(this.pickerValue.join('.'))
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
    margin: 0 0 0 130px;

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

.scroll-picker__body_decimal {
  .smooth-picker .smooth-handle-layer .smooth-middle {

    &:after {
      background: url(/img/bd/comma.svg) no-repeat;
      bottom: 22px;
      content: "";
      height: 18px;
      left: 50%;
      position: absolute;
      transform: translatex(-50%);
      width: 15px;
    }

  }
}

</style>