<template>
  <div class="text-white">
    <subtitle font-size="18" style="line-height: 26px">
      <div>{{ trans('economic_reference.table_chess_title') }}</div>
    </subtitle>

    <div class="mt-3 border-grey bg-header">
      <div class="px-3 py-1 border-grey" style="font-size: 16px; line-height: 20px; font-weight: 600">
        Потребность в субсидировании со стороны КМГ при различных ценах на нефть и ПП
      </div>

      <div class="d-flex">
        <div class="px-3 py-1 border-grey text-center flex-200px"></div>

        <div class="px-3 py-1 border-grey text-center flex-120px"></div>

        <div class="px-3 py-1 border-grey bg-dark-blue text-center flex-grow-1">
          Производственная программа при цене на нефть
        </div>
      </div>

      <div class="d-flex bg-light-blue">
        <div class="px-3 py-1 border-grey text-center flex-200px">
          Курс {{ scenario.dollar_rate }} тенге / $
        </div>

        <div class="px-3 py-1 border-grey text-center flex-120px">
          ПП-2020
        </div>

        <div v-for="oilPrice in reverseOilPrices"
             :key="oilPrice"
             class="px-3 py-1 border-grey flex-grow-1 text-center">
          {{ (+oilPrice).toLocaleString() }}$/барр
        </div>
      </div>

      <div class="d-flex">
        <div class="px-3 py-1 border-grey text-center flex-200px">
          Добыча, тыс.тонн
        </div>

        <div class="px-3 py-1 border-grey text-center flex-120px">
          5560
        </div>

        <div v-for="oilPrice in oilPrices"
             :key="oilPrice"
             class="px-3 py-1 border-grey flex-grow-1 text-center">
          5570
        </div>
      </div>

      <div class="d-flex bg-deep-blue">
        <div class="px-3 py-1 border-grey text-center flex-200px"></div>

        <div class="px-3 py-1 border-grey text-center flex-120px"></div>

        <div class="px-3 py-1 border-grey bg-dark-blue text-center flex-grow-1">
          Доходы, млн. тенге
        </div>
      </div>

      <div v-for="(oilPrice, oilIndex) in reverseOilPrices"
           :key="oilPrice"
           :class="oilIndex % 2 === 0 ? 'bg-light-blue' : 'bg-deep-blue'"
           class="d-flex">
        <div class="px-3 py-1 border-grey text-center flex-200px">
          {{ (+oilPrice).toLocaleString() }}$/
        </div>

        <div class="px-3 py-1 border-grey text-center flex-120px"></div>

        <div v-for="(price, priceIndex) in reverseOilPrices"
             :key="priceIndex"
             :style="`background: ${getColor(priceIndex)}`"
             class="px-3 py-1 border-grey flex-grow-1 text-center">

        </div>
      </div>

      <div class="d-flex bg-deep-blue">
        <div class="px-3 py-1 border-grey text-center flex-200px height-31px"></div>

        <div class="px-3 py-1 border-grey text-center flex-120px height-31px"></div>

        <div v-for="price in reverseOilPrices"
             :key="price"
             class="px-3 py-1 border-grey flex-grow-1 text-center height-31px">
        </div>
      </div>

      <div class="d-flex bg-deep-blue">
        <div class="px-3 py-1 border-grey text-center flex-200px"></div>

        <div class="px-3 py-1 border-grey text-center flex-120px"></div>

        <div class="px-3 py-1 border-grey bg-dark-blue text-center flex-grow-1">
          Расходы, млн. тенге
        </div>
      </div>

      <div v-for="(oilPrice, oilIndex) in reverseOilPrices"
           :key="oilPrice"
           :class="oilIndex % 2 === 0 ? 'bg-light-blue' : 'bg-deep-blue'"
           class="d-flex">
        <div class="px-3 py-1 border-grey text-center flex-200px">
          {{ (+oilPrice).toLocaleString() }}$/
        </div>

        <div class="px-3 py-1 border-grey text-center flex-120px"></div>

        <div v-for="(price, priceIndex) in reverseOilPrices"
             :key="priceIndex"
             :style="`background: ${getColor(priceIndex)}`"
             class="px-3 py-1 border-grey flex-grow-1 text-center">

        </div>
      </div>

      <div class="d-flex bg-light-blue">
        <div class="px-3 py-1 border-grey text-center flex-200px height-31px"></div>

        <div class="px-3 py-1 border-grey text-center flex-120px height-31px"></div>

        <div v-for="price in reverseOilPrices"
             :key="price"
             class="px-3 py-1 border-grey flex-grow-1 text-center height-31px">
        </div>
      </div>

      <div class="d-flex">
        <div class="px-3 py-1 border-grey text-center flex-200px">
          Цена на нефть
        </div>

        <div class="px-3 py-1 border-grey text-center flex-120px"></div>

        <div class="px-3 py-1 border-grey bg-dark-blue text-center flex-grow-1">
          Производственная программа при цене на нефть
        </div>
      </div>

      <div class="d-flex bg-deep-blue">
        <div class="px-3 py-1 border-grey text-center flex-200px"></div>

        <div class="px-3 py-1 border-grey text-center flex-120px"></div>

        <div v-for="oilPrice in reverseOilPrices"
             :key="oilPrice"
             class="px-3 py-1 border-grey flex-grow-1 text-center">
          {{ (+oilPrice).toLocaleString() }}$/барр
        </div>
      </div>

      <div v-for="(oilPrice, oilIndex) in reverseOilPrices"
           :key="oilPrice"
           :class="oilIndex % 2 === 0 ? 'bg-light-blue' : 'bg-deep-blue'"
           class="d-flex">
        <div class="px-3 py-1 border-grey text-center flex-200px">
          {{ (+oilPrice).toLocaleString() }}$/
        </div>

        <div :style="`background: ${getColor(priceIndex)}`"
             class="px-3 py-1 border-grey text-center flex-120px">
        </div>

        <div v-for="(price, priceIndex) in reverseOilPrices"
             :key="priceIndex"
             :style="`background: ${getColor(priceIndex)}`"
             class="px-3 py-1 border-grey flex-grow-1 text-center">

        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "./Subtitle";

export default {
  name: "TableChess",
  components: {
    Subtitle
  },
  props: {
    scenario: {
      required: true,
      type: Object
    },
    oilPrices: {
      required: true,
      type: Array
    }
  },
  computed: {
    reverseOilPrices() {
      return [...this.oilPrices].reverse()
    },
  },
  methods: {
    getColor(index) {
      const colors = [
        '#106B4B',
        '#BDA74D',
        '#505585',
        '#AC7550',
        '#272953',
        '#272953'
      ]

      return colors[Math.floor(Math.random() * colors.length)];
    }
  }
}
</script>

<style scoped>
.border-grey {
  border: 1px solid #454D7D
}

.bg-header {
  background: #333975;
}

.bg-dark-blue {
  background: #1A2370;
}

.bg-light-blue {
  background: #505585;
}

.bg-deep-blue {
  background: #272953;
}

.flex-120px {
  flex: 0 0 120px;
}

.flex-200px {
  flex: 0 0 200px;
}

.height-31px {
  height: 31px;
}
</style>