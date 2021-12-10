<template>
  <div class="d-flex text-center">
    <div :style="row.style"
         class="px-2 py-1 border-grey min-width-50px text-center font-weight-600">
      {{ row.order || '' }}
    </div>

    <div :style="row.style"
         class="px-2 py-1 border-grey min-width-300px flex-grow-1 text-left font-weight-600">
      {{ row.title }}
    </div>

    <div v-for="(header, headerIndex) in headers"
         :key="headerIndex"
         :class="header.styleClass"
         :style="`${row.style || ''}; ${row.values[headerIndex].style || ''}`"
         class="p-1 border-grey flex-95px d-flex align-items-center justify-content-center">
      {{ localeValue(row.values[headerIndex].value, header.dimension) }}
    </div>
  </div>
</template>

<script>
import {formatValueMixin} from "../../mixins/formatMixin";

export default {
  name: "TableFinancialLossRow",
  mixins: [
    formatValueMixin
  ],
  props: {
    row: {
      required: true,
      type: Object
    },
    headers: {
      required: true,
      type: Array
    },
  },
}
</script>

<style scoped>
.border-grey {
  border: 1px solid #454D7D
}

.flex-95px {
  flex: 0 0 95px;
}

.font-weight-600 {
  font-weight: 600;
}

.min-width-50px {
  min-width: 50px;
}

.min-width-300px {
  min-width: 300px;
}
</style>