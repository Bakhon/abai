<template>
  <div class="d-flex">
    <div class="px-3 py-2 border-grey text-center flex-350px">
      {{ row.title }}
    </div>

    <div v-for="(column, columnIndex) in row.columns"
         :key="`${index}_${columnIndex}`"
         :style="`flex-basis: ${100 / row.columns.length}%;`"
         class="px-3 py-2 border-grey text-center flex-grow-1">
      {{ column.value.toLocaleString() }}
    </div>
  </div>
</template>

<script>
export default {
  name: "TableWellStockRow",
  props: {
    row: {
      required: true,
      type: Object
    },
    index: {
      required: true,
      type: Number
    }
  }
}
</script>

<style scoped>
.flex-350px {
  flex: 0 0 350px;
}

.border-grey {
  border: 1px solid #454D7D
}
</style>