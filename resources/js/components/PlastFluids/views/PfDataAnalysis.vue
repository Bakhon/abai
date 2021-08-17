<template>
  <div class="data-analysis">
    <data-analysis-panel />
    <div class="data-analysis__content">
      <data-analysis-tab />
      <div class="data-analysis__wrapper">
        <div class="data-analysis__wrapper-title">
          <div class="icon-title">
            <i class="fas fa-sliders-h"/>
          </div>
          <span>Детальная статистика изученности по видам исследований</span>
        </div>
        <div class="data-analysis__wrapper-img">
          <img src="/img/PlastFluids/mapProperty.svg" alt="">
        </div>
      </div>
      <div class="data-analysis__wrapper">
        <div class="data-analysis__wrapper-title">
          <span>Данные по пробам</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DataAnalysisPanel from "../components/DataAnalysisPanel";
import DataAnalysisTab from "../components/DataAnalysisTab";

export default {
  name: "PfDataAnalysis",

  components: {
    DataAnalysisPanel,
    DataAnalysisTab
  },

  data() {
    return {

    }
  }
}
</script>

<style scoped lang="scss">
.data-analysis {
  display: flex;
  color: #fff;

  &__content {
    width: calc(100% - 340px);
  }
}

.data-analysis__wrapper {
  background: #272953;
  padding: 8px;

  &-title {
    display: flex;
    align-items: center;
    background: #323370;
    border: 1px solid #545580;
    padding: 8px;
    margin-bottom: 8px;

    .icon-title {
      background-color: #b3b6d1;
      border-radius: 5px;
      margin-right: 10px;
      width: 26px;
      text-align: center;
    }

    .fa-sliders-h {
      color: #868BB2;
      font-size: 16px;
    }

    span {
      font-size: 16px;
    }
  }

  &-img {
    background: #000;
    text-align: center;
    padding: 6px;
  }

  img {
    width: 100%;
  }
}
</style>
