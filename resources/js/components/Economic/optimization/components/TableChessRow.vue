<template>
  <div class="d-flex">
    <div :style="row.bgColor ? `background: ${row.bgColor}` : ''"
         class="px-3 py-1 border-grey text-center flex-350px">
      {{ row.title }}
    </div>

    <div :style="row.bgColor ? `background: ${row.bgColor}` : ''"
         class="px-3 py-1 border-grey text-center flex-150px">
      {{ row.pp2020 }}
    </div>

    <div v-if="row.subtitle"
         class="px-3 py-1 border-grey bg-dark-blue text-center flex-grow-1">
      {{ row.subtitle }}
    </div>

    <div v-else
         v-for="(column, columnIndex) in row.columns"
         :key="`${index}_${columnIndex}`"
         :style="`flex: 1 1 ${100 / row.columns.length}%; background: ${column.color}`"
         class="px-3 py-1 border-grey text-center">
      {{ (+column.value).toLocaleString() }}
      {{ row.columnDimension }}
    </div>
  </div>
</template>

<script>
export default {
  name: "TableChessRow",
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
.border-grey {
  border: 1px solid #454D7D
}

.bg-dark-blue {
  background: #1A2370;
}

.flex-150px {
  flex: 0 0 150px;
}

.flex-350px {
  flex: 0 0 350px;
}
</style>