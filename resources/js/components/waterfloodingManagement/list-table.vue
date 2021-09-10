<template>
  <table class="table choose-poligon-table">
    <tr v-for="(item, index) in data" :class="[index%2==0 ? 'table-td-first' : '']">
      <td>
        {{ item.title }}
      </td>
    </tr>
  </table>
</template>

<script>
export default {
  name: "list-table",
  props: {
    data: Array
  },
  data: function () {
    return {};
  },
}
</script>

<style scoped>

</style>