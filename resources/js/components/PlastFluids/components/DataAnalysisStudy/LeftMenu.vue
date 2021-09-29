<template>
  <div class="data-analysis-panel">
    <div class="main-content-holder">
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
.data-analysis-panel {
  display: flex;
  flex-flow: column;
  justify-content: space-between;
  background: #272953;
  width: 100%;
  height: 100%;
}

.data-analysis-panel__title {
  font-size: 16px;
  padding: 7px 15px;
  background: #323370;
  i {
    color: #868bb2;
    margin-right: 8px;
  }
  .fa-sliders-h {
    transform: rotate(90deg);
  }
}

.data-analysis-panel__area {
  padding: 4px 8px;
}

.data-analysis-panel__area-setting {
  background: #363b68;
  padding: 8px;
}

input[type="checkbox"] {
  transform: scale(1.4);
  cursor: pointer;
}

.list {
  margin-bottom: 0;
  li {
    display: flex;
    align-items: center;
    cursor: pointer;
    line-height: 2;
    label {
      margin-bottom: 0;
      margin-left: 10px;
      cursor: pointer;
    }
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

.data-analysis-panel__btns {
  width: 100%;
  padding: 0 6px;
}

.data-analysis-panel__btns > button {
  font-size: 14px;
  padding: 10px 7px;
  width: 100%;
}

.data-analysis-dropdown__body {
  padding: 0 !important;
}

.pressure__dropdown ul li:hover {
  background-color: #3366ff;
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
