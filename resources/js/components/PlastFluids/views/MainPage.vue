<template>
  <div class="wrapper-info">
    <div class="grid-container">
      <info-table inform_data="21" description="Количество PVT"></info-table>
      <info-table inform_data="17" description="Глубинных проб"></info-table>

      <info-table inform_data="53" description="Рекомбинированных"></info-table>
      <info-table inform_data="9" description="Устьевых проб"></info-table>
    </div>
  </div>
</template>

<script>
import InfoTable from "../components/InfoTable.vue";
export default {
  components: {
    InfoTable,
  },
};
</script>

<style scoped>
.wrapper-info {
  background: #272953;
  padding: 10px 14px 10px;
}
.grid-container {
  display: grid;
  grid-template-rows: 1fr 1fr;
  grid-template-columns: 1fr 1fr;
}
</style>
