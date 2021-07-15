<template>
  <div>
    <select v-model="optionId">
      <option v-for="(value, id) in column.values" :value="id" :key="value.id">{{ value }}</option>
    </select>
  </div>
</template>
<script>
  export default {
    props: {
      column: Object,
      filter: Object,
      updateTableData: Function,
    },
    data() {
      return {
        optionId: 0,
      }
    },
    watch: {
      optionId() {
        this.filter.optionId = this.optionId;
        this.updateTableData();
      }
    },
  }
</script>

<style scoped>
  select {
    background-color: #2C44BD;
    color: #fff;
    margin: 0.5rem;
    padding: 0.3rem;
    border-radius: 0.2rem;
  }
</style>