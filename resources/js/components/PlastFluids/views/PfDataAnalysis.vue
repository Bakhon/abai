<template>
  <div class="data-analysis">
    <Header />
    <div class="data-analysis-content">
      <DataAnalysisLeftBlock />
      <DataAnalysisHeaderAndContent />
    </div>
  </div>
</template>

<script>
import Header from "../components/Header.vue";
import DataAnalysisLeftBlock from "../components/DataAnalysisLeftBlock.vue";
import DataAnalysisHeaderAndContent from "../components/DataAnalysisHeaderAndContent.vue";

export default {
  name: "PfDataAnalysis",
  props: {
    route: String,
  },
  components: {
    Header,
    DataAnalysisLeftBlock,
    DataAnalysisHeaderAndContent,
  },
  data() {
    return {
      cartFull: false,
    };
  },
  provide() {
    return {
      headingKey: this.url[1],
    }
  },
  computed: {
    url() {
      const splittedUrl = this.route.split("/");
      splittedUrl.shift();
      return splittedUrl;
    },
  },
};
</script>

<style scoped>
.data-analysis {
  width: 100%;
  height: 100%;
}

.data-analysis-content {
  display: flex;
  width: 100%;
  height: calc(100vh - 143px);
}
</style>
