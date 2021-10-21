<template>
  <div class="d-flex">
    <div class="py-1 pl-3 pr-2 border-grey d-flex align-items-center justify-content-start flex-10">
      {{ row.date }}
    </div>

    <div v-for="(title, titleIndex) in titles"
         :key="titleIndex"
         class="text-center d-flex flex-18">
      <div v-for="(subTitle, subTitleIndex) in subTitles"
           :key="subTitleIndex"
           :style="`flex: 0 0 ${100 / subTitles.length}%`"
           class="py-2 px-1 border-grey">
        {{ row.values[titleIndex][subTitleIndex] }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TableOilProductionTechLossRow",
  props: {
    row: {
      required: true,
      type: Object
    },
    titles: {
      required: true,
      type: Array
    },
    subTitles: {
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

.flex-18 {
  flex: 0 0 18%;
}
</style>