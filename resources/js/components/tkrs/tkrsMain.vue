<template>
  <div class="tkrs-main">
    <mainHeader />
    <div class="tkrs-content">

      <DataAnalysisHeaderAndContent />
    </div>
  </div>
</template>

<script>
import mainHeader from "../mainHeader.vue";
import TkrsHeaderAndContent from "../tkrsHeaderAndContent.vue";

export default {
  name: "tkrsMain",
  props: {
    route: String,
  },
  components: {
    mainHeader,
    tkrsHeaderAndContent,
  },
};
</script>

<style scoped>
.tkrs-main {
  width: 100%;
  height: 100%;
}

.tkrs-content {
  display: flex;
  width: 100%;
  height: calc(100vh - 143px);
}
</style>