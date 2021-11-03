<template>
  <div class="d-flex">
    <div class="py-1 pl-3 pr-2 border-grey d-flex align-items-center justify-content-start flex-10">
      {{ row.date }}
    </div>

    <div v-for="(status, statusIndex) in statuses"
         :key="statusIndex"
         :style="`flex: 0 0 ${90 / statuses.length}%`"
         class="text-center d-flex">
      <div v-for="(column, columnIndex) in columns"
           :key="columnIndex"
           :style="`flex: 0 0 ${100 / columns.length}%`"
           class="py-2 px-1 border-grey d-flex align-items-center justify-content-center">
        {{ row.values[statusIndex][columnIndex] }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TableOilProductionLossRow",
  props: {
    row: {
      required: true,
      type: Object
    },
    statuses: {
      required: true,
      type: Array
    },
    columns: {
      required: true,
      type: Array
    }
  },
}
</script>

<style scoped>
.border-grey {
  border: 1px solid #454D7D
}

.flex-10 {
  flex: 0 0 10%;
}
</style>