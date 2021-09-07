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
  methods: {
    getColor({profitability_12m}) {
      if (profitability_12m === 'profitable') {
        return '#387249'
      }

      return profitability_12m === 'profitless_cat_1'
          ? '#8D2540'
          : '#F7BB2E'
    },
  },
  computed: {
    filteredData() {
      return this.data.filter(x => +x.dollar_rate === +this.scenario.dollar_rate)
    },

    tableData() {
      let wells = {}

      this.filteredData.forEach(well => {
        if (!wells.hasOwnProperty(well.uwi)) {
          wells[well.uwi] = {oilPrices: {}, cat1: 0, cat2: 0, profitable: 0}
        }

        wells[well.uwi].oilPrices[well.oil_price] = {
          operating_profit_12m: well.operating_profit_12m,
          profitability_12m: well.profitability_12m
        }

        switch (well.profitability_12m) {
          case 'profitable':
            wells[well.uwi].profitable += 1
            break
          case 'profitless_cat_1':
            wells[well.uwi].cat1 += 1
            break
          case 'profitless_cat_2':
            wells[well.uwi].cat2 += 1
            break
        }
      })

      return wells
    },

    tableDataKeys() {
      let wells = this.tableData

      return Object.keys(wells).sort(function (prev, next) {
        return (wells[next].cat1 - wells[prev].cat1)
            || (wells[next].cat2 - wells[prev].cat2)
            || (wells[prev].profitable - wells[next].profitable)
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