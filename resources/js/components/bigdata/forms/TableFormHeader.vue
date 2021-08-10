<template>
  <tr>
    <th v-for="column in columns" :rowspan="column.rowspan">{{ column.title }}</th>
  </tr>
</template>

<script>
export default {
  name: "BigDataTableFormHeader",
  props: {
    columns: {
      type: Object,
      required: true
    },
    maxLevel: {
      type: Number
    },
  }
}
</script>