<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      <div>{{ trans('economic_reference.table_well_changes') }}</div>
    </subtitle>

    <div class="mt-3 d-flex">
      <div v-for="i in 5"
           :key="i"
           class="flex-grow-1">
        <div class="text-center border-grey d-flex bg-header">
          <div class="text-center border-grey" style="flex: 1 0 100px;">
            Скв
          </div>

          <div class="text-center border-grey" style="flex: 0 0 80px;">
            НГДУ
          </div>

          <div v-for="(price, index) in oilPrices"
               :key="index"
               class="text-center border-grey"
               style="flex: 0 0 30px;">
            {{ (+price).toLocaleString() }}$
          </div>
        </div>

        <div v-for="well in 30" :key="well" class="d-flex">
          <div class="text-center border-grey" style="flex: 1 0 100px;">
            {{ data[0].uwi }}
          </div>

          <div class="text-center border-grey" style="flex: 0 0 80px;">
            {{ data[0].ngdu }}
          </div>

          <div v-for="(price, index) in data[0].oilPrices"
               :key="index"
               :style="`background: ${getColor()}`"
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
  },
  methods: {
    getColor() {
      return ['#8D2540', '#387249', '#F7BB2E'][Math.floor(Math.random() * 3)];
    }
  },

  computed: {
    data() {
      return [
        {
          uwi: 'UZN_0119',
          ngdu: 'НГДУ-1',
          oilPrices: this.oilPrices
        }
      ]
    },
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