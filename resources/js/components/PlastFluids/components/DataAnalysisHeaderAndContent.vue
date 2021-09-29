<template>
  <div class="data-analysis-header-and-content">
    <DataAnalysisHeader />
    <DataAnalysisContent />
  </div>
</template>

<script>
import DataAnalysisHeader from "./DataAnalysisHeader.vue";
import DataAnalysisContent from "./DataAnalysisContent.vue";

export default {
  name: "DataAnalysisHeaderAndContent",
  components: {
    DataAnalysisHeader,
    DataAnalysisContent,
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
