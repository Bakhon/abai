<template>
  <div class="data-analysis-content">
    <component :is="currentComponent[1]"></component>
  </div>
</template>

<script>
import { setDynamicComponentContent } from "../mixins";

export default {
  name: "DataAnalysisContent",
  mixins: [setDynamicComponentContent],
};
</script>

<style>
.data-analysis-content {
  width: 100%;
  height: calc(100% - 46px);
}
</style>
