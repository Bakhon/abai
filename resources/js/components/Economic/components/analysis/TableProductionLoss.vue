<template>
  <div>
    <subtitle font-size="16" class="line-height-18px">
      Потери добычи от остановок за май-октябрь 2020 г.
    </subtitle>

    <div class="customScroll">
      <div class="mt-2 d-flex table-oil-production">
        <table-production-loss-row
            v-for="(row, rowIndex) in tableData"
            :key="rowIndex"
            :row="row"
            :dates="wellsByStatuses.dates"
            :is-visible-months="rowIndex === 0"
            :class="rowIndex ? 'ml-3' : ''"
            :style="`min-width: ${rowIndex ? 350 : 420}px`"
            class="h-100"
            is-profitable
            is-profitless
            is-visible-header
        />
      </div>

      <div class="mt-3">
        <subtitle font-size="16" class="mb-2 line-height-18px">
          В т.ч. нерентабельный фонд
        </subtitle>

        <div class="d-flex table-oil-production">
          <table-production-loss-row
              v-for="(row, rowIndex) in tableData"
              :key="rowIndex"
              :row="row"
              :dates="wellsByStatuses.dates"
              :is-visible-months="rowIndex === 0"
              :class="rowIndex > 0 ? 'ml-3' : ''"
              :style="`min-width: ${rowIndex ? 350 : 420}px`"
              class="h-100"
              is-profitless
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "../Subtitle";
import TableProductionLossRow from "./TableProductionLossRow";

import {tableDataMixin} from "../../mixins/analysisMixin";

export default {
  name: "TableProductionLoss",
  components: {
    Subtitle,
    TableProductionLossRow
  },
  mixins: [
    tableDataMixin,
  ],
  created() {
    this.$emit('updateWide', this.statuses.length > 4)
  }
}
</script>

<style scoped>
.line-height-18px {
  line-height: 18px;
}

.customScroll {
  overflow-x: auto;
}

.customScroll::-webkit-scrollbar {
  width: 10px;
}

.table-oil-production {
  height: 250px
}
</style>