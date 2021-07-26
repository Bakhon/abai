<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      <div>{{ trans('economic_reference.table_well_changes') }}</div>
    </subtitle>

    <div class="mt-3 d-flex">
      <div v-for="(chunk, index) in tableDataChunks"
           :key="index"
           class="flex-grow-1">
        <div class="text-center border-grey d-flex bg-header">
          <div class="text-center border-grey" style="flex: 1 0 100px;">
            Скв
          </div>

          <div v-for="(price, priceIndex) in oilPrices"
               :key="`${index}_${priceIndex}`"
               class="text-center border-grey"
               style="flex: 0 0 30px;">
            {{ (+price).toLocaleString() }}$
          </div>
        </div>

        <div v-for="uwi in chunk" :key="uwi" class="d-flex">
          <div class="text-center border-grey" style="flex: 1 0 100px;">
            {{ uwi }}
          </div>

          <div v-for="price in oilPrices"
               :key="price"
               :style="`background: ${getColor(tableData[uwi].oilPrices[price])}`"
               class="border-grey"
               style="flex: 0 0 30px;">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "./Subtitle";

export default {
  name: "TableWellChanges",
  components: {
    Subtitle
  },
  props: {
    org: {
      required: true,
      type: Object
    },
    scenarios: {
      required: true,
      type: Array
    },
    scenario: {
      required: true,
      type: Object
    },
    // oilPrices: {
    //   required: true,
    //   type: Array,
    // },
    data: {
      required: true,
      type: Array
    }
  },
  methods: {
    getColor(profitability) {
      if (profitability === 'profitable') {
        return '#387249'
      }

      return profitability === 'profitless_cat_1'
          ? '#8D2540'
          : '#F7BB2E'
    }
  },

  computed: {
    tableData() {
      let data = {}

      this.data.forEach(item => {
        if (data.hasOwnProperty(item.uwi)) {
          return data[item.uwi].oilPrices[item.oil_price] = item.profitability_12m
        }

        data[item.uwi] = {oilPrices: {}}

        data[item.uwi].oilPrices[item.oil_price] = item.profitability_12m
      })

      return data
    },

    tableDataKeys() {
      return Object.keys(this.tableData)
    },

    tableDataChunks() {
      let result = [];

      let keys = this.tableDataKeys

      for (let i = 10; i > 0; i--) {
        result.push(keys.splice(0, Math.ceil(keys.length / i)));
      }

      return result;
    },

    oilPrices() {
      return [60]
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
</style>