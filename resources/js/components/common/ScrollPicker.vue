<template>
  <div class="scroll-picker">
    <div class="scroll-picker__title">
      <span class="scroll-picker__title-ico" v-html="item.ico"></span>
      <span class="scroll-picker__title-name">{{ item.name }}</span>
    </div>
    <smooth-picker ref="smoothPicker" :change="change" :data="data"/>
    <button class="scroll-picker__button" @click.prevent="save">OK</button>
  </div>
</template>

<script>

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
        }
      ],
      pickerValue: []
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

.smooth-picker {
  font-size: 1rem;
  height: 570px;
  position: relative;
  background-color: #272953;
  overflow: hidden;
  @media (max-width: 768px) {
    height: calc(100% - 20vw);
  }
}

.smooth-picker .smooth-list {
  height: 300px;
  line-height: 1;
  margin-top: -15px;
  position: relative;
  top: 50%;
}

.smooth-picker .smooth-item {
  color: #bebecb;
  position: absolute;
  top: 0;
  left: 0;
  overflow: hidden;
  width: 100%;
  text-overflow: ellipsis;
  white-space: nowrap;
  display: block;
  text-align: center;
  will-change: transform;
  contain: strict;
  height: 80px;
  font-size: 40px;

  &-selected {
    color: #fff;
  }
}

.smooth-picker .smooth-handle-layer {
  position: absolute;
  width: 100%;
  height: calc(100% + 2px);
  left: 0;
  right: 0;
  top: -1px;
  bottom: -1px
}

.smooth-picker .smooth-handle-layer .smooth-top {
  background: linear-gradient(
          180deg, #272953 40%, transparent);
  -webkit-transform: translateZ(5.625em);
  transform: translateZ(5.625em)
}

.smooth-picker .smooth-handle-layer .smooth-middle {
  background: rgba(0, 0, 0, 0.24);
  height: 120px;
  position: relative;

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

.smooth-picker .smooth-handle-layer .smooth-bottom {
  background: linear-gradient(
          0deg, #272953 40%, transparent);
  -webkit-transform: translateZ(5.625em);
  transform: translateZ(5.625em)
}

.flex-box {
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex
}

.flex-box.direction-column {
  -webkit-flex-direction: column;
  -ms-flex-direction: column;
  flex-direction: column
}

.flex-box.direction-row {
  -webkit-flex-direction: row;
  -ms-flex-direction: row;
  flex-direction: row
}

.flex-box .flex-1 {
  -webkit-flex: 1;
  -ms-flex: 1;
  flex: 1
}

.flex-box .flex-2 {
  -webkit-flex: 2;
  -ms-flex: 2;
  flex: 2
}

.flex-box .flex-3 {
  -webkit-flex: 3;
  -ms-flex: 3;
  flex: 3
}

.flex-box .flex-4 {
  -webkit-flex: 4;
  -ms-flex: 4;
  flex: 4
}

.flex-box .flex-5 {
  -webkit-flex: 5;
  -ms-flex: 5;
  flex: 5
}

.flex-box .flex-6 {
  -webkit-flex: 6;
  -ms-flex: 6;
  flex: 6
}

.flex-box .flex-7 {
  -webkit-flex: 7;
  -ms-flex: 7;
  flex: 7
}

.flex-box .flex-8 {
  -webkit-flex: 8;
  -ms-flex: 8;
  flex: 8
}

.flex-box .flex-9 {
  -webkit-flex: 9;
  -ms-flex: 9;
  flex: 9
}

.flex-box .flex-10 {
  -webkit-flex: 10;
  -ms-flex: 10;
  flex: 10
}

.flex-box .flex-11 {
  -webkit-flex: 11;
  -ms-flex: 11;
  flex: 11
}

.flex-box .flex-12 {
  -webkit-flex: 12;
  -ms-flex: 12;
  flex: 12
}
</style>