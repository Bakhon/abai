<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      {{ trans('economic_reference.table_well_changes') }}
    </subtitle>

    <div id="table-well-changes" class="mt-3 overflow-auto customScroll d-flex">
      <div v-for="(chunk, index) in tableDataChunks"
           :key="index">
        <div
            :style="`width: ${columnWidth}px`"
            class="text-center border-grey d-flex bg-header">
          <div class="text-center border-grey" style="flex: 0 0 100px;">
            Скв
          </div>

          <div v-for="price in oilPrices"
               :key="`${index}_${price}`"
               class="text-center border-grey"
               style="flex: 0 0 30px;">
            {{ (+price).toLocaleString() }}$
          </div>
        </div>

        <div v-for="uwi in chunk" :key="uwi" class="d-flex">
          <div class="text-center border-grey" style="flex: 0 0 100px;">
            {{ uwi }}
          </div>

          <div v-for="price in oilPrices"
               :key="`${uwi}_${price}_profitability_12m`"
               :style="`background: ${getColor(tableData[uwi].oilPrices[+price])}`"
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
    oilPrices: {
      required: true,
      type: Array,
    },
    data: {
      required: true,
      type: Array
    },
  },
  mounted() {
    this.scrollToChanges()
  },
  methods: {
    getColor({profitability_12m}) {
      if (profitability_12m === 'profitable') {
        return '#387249'
      }

      return profitability_12m === 'profitless_cat_1'
          ? '#8D2540'
          : '#F7BB2E'
    },

    scrollToChanges() {
      let table = document.getElementById('table-well-changes')

      if (!table) return

      let index = this.filteredData.findIndex((item, index, data) =>
          index &&
          item.oil_price === data[index - 1].oil_price &&
          item.profitability_12m === 'profitable' &&
          data[index - 1].profitability_12m !== 'profitable'
      )

      if (index === -1) return

      table.scrollLeft = this.columnWidth * index / this.chunkStep - this.columnWidth * 4
    },
  },
  computed: {
    filteredData() {
      return this.data.filter(x => +x.dollar_rate === +this.scenario.dollar_rate)
    },

    tableData() {
      let data = {}

      this.filteredData.forEach(item => {
        if (!data.hasOwnProperty(item.uwi)) {
          data[item.uwi] = {oilPrices: {}, cat1: 0, cat2: 0, profitable: 0}
        }

        data[item.uwi].oilPrices[item.oil_price] = {
          operating_profit_12m: item.operating_profit_12m,
          profitability_12m: item.profitability_12m
        }

        switch (item.profitability_12m) {
          case 'profitable':
            data[item.uwi].profitable += 1
            break
          case 'profitless_cat_1':
            data[item.uwi].cat1 += 1
            break
          case 'profitless_cat_2':
            data[item.uwi].cat2 += 1
            break
        }
      })

      return data
    },

    tableDataKeys() {
      let data = this.tableData

      return Object.keys(data).sort(function (prev, next) {
        return (data[next].cat1 - data[prev].cat1)
            || (data[next].cat2 - data[prev].cat2)
            || (data[prev].profitable - data[next].profitable)
      })
    },

    tableDataChunks() {
      let result = [];

      let keys = this.tableDataKeys

      let length = keys.length

      for (let i = 0; i < Math.ceil(length / this.chunkStep); i += 1) {
        result.push(keys.splice(0, this.chunkStep))
      }

      return result
    },

    chunkStep() {
      return 25
    },

    columnWidth() {
      return 100 + this.oilPrices.length * 30
    }
  },
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