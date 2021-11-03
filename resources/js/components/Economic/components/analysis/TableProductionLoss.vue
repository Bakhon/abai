<template>
  <div>
    <subtitle font-size="16" class="line-height-18px">
      Потери добычи от остановок за май-октябрь 2020 г.
    </subtitle>

    <div class="mt-3 d-flex">
      <table-production-loss-row
          v-for="(row, rowIndex) in tableData"
          :key="rowIndex"
          :row="row"
          :dates="wellsByStatuses.dates"
          :class="rowIndex > 0 ? 'ml-3' : ''"
          is-profitable
          is-profitless
          is-visible-header
      />
    </div>

    <div class="mt-2">
      <subtitle font-size="16" class="mb-2 line-height-18px">
        В т.ч. нерентабельный фонд
      </subtitle>

      <div class="d-flex">
        <table-production-loss-row
            v-for="(row, rowIndex) in tableData"
            :key="rowIndex"
            :row="row"
            :dates="wellsByStatuses.dates"
            :class="rowIndex > 0 ? 'ml-3' : ''"
            is-profitless
        />
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
}
</script>

<style scoped>
.line-height-18px {
  line-height: 18px;
}
</style>