<template>
  <div class="d-flex text-center">
    <div :style="row.style"
         class="px-2 py-1 border-grey min-width-50px text-center font-weight-600">
      {{ row.subTitle || '' }}
    </div>

    <div :style="row.style"
         class="px-2 py-1 border-grey min-width-300px flex-grow-1 text-left font-weight-600">
      {{ row.title }}
    </div>

    <div v-for="(title, titleIndex) in titles"
         :key="titleIndex"
         :class="title.styleClass"
         :style="`${row.style || ''}; ${row.values[titleIndex].style || ''}`"
         class="p-1 border-grey flex-95px d-flex align-items-center justify-content-center">
      {{ row.values[titleIndex].value }}
    </div>
  </div>
</template>

<script>

export default {
  name: "TableFinancialLossRow",
  props: {
    row: {
      required: true,
      type: Object
    },
    titles: {
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