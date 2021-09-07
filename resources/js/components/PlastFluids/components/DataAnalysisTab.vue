<template>
  <div class="data-analysis-tab">
    <div class="data-analysis-tab__item">
      Давление и температура
    </div>
    <div class="data-analysis-tab__item active">
      Анализ проб пластовой нефти
    </div>
    <div class="data-analysis-tab__item">
      Утвержденные параметры
    </div>
  </div>
</template>

<script>
export default {
name: "DataAnalysisTab"
}
</script>

<style scoped lang="scss">
.data-analysis-tab {
  display: flex;
  justify-content: space-between;
  background: #272953;
  padding: 8px;
  margin-bottom: 10px;

  &__item {
    width: 33%;
    background: #333975;
    padding: 10px;
    font-size: 16px;
    border-radius: 5px;
    text-align: center;

    &.active {
      background: #2E50E9;
    }
  }
}
</style>
