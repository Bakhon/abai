<template>
  <div class="data-analysis-panel">
    <data-analysis-left-panel />
    <div class="data-analysis-panel__title">
      <i><img src="/img/PlastFluids/tableSettings.svg" alt=""/></i>
      <span>Настройка таблицы</span>
    </div>
    <div class="data-analysis-panel__area">
      <div class="data-analysis-panel__area-setting">
        <input type="radio" />
        <span>Отбор Проб</span>
      </div>
      <div class="data-analysis-panel__area-setting">
        <input type="radio" />
        <span>PVT эксперименты</span>
      </div>
    </div>
    <div
      class="d-flex justify-content-around pb-10px data-analysis-panel__btns"
    >
      <button type="button" class="btn-button btn-button--thm-dark-blue">
        <i class="fas fa-download pr-5px" />
        <span>Выгрузить данные</span>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "DataAnalysisStudyPanel",
};
</script>

<style scoped lang="scss">
@import "./plast_fluids.scss";

.data-analysis-panel__btns {
  position: absolute;
  width: 100%;
  padding: 7px;
  bottom: 0;

  button {
    width: 100%;
  }
}

.data-analysis__input {
  background: rgba(31, 33, 66, 0.4);
  border: 0.5px solid #454fa1;
  border-radius: 2px;
  outline: none;
  min-width: 186px;
  padding: 4px 8px;
  color: #fff;
}
</style>
