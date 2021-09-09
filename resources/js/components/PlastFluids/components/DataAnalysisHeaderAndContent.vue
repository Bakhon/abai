<template>
  <div class="data-analysis-header-and-content">
    <DataAnalysisHeader />
  </div>
</template>

<script>
import DataAnalysisHeader from "./DataAnalysisHeader.vue";

export default {
  name: "DataAnalysisHeaderAndContent",
  components: {
    DataAnalysisHeader,
  },
};
</script>

<style scoped>
.data-analysis-header-and-content {
  display: flex;
  flex-flow: column;
  flex: 2 1 auto;
  margin: 0 10px;
}
</style>
