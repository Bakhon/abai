<template>
  <div class="data-analysis-panel">
    <div class="main-content-holder">
      <div class="settings-holder">
        <div class="data-analysis-panel__title">
          <i class="fas fa-cog" />
          <span>Настройка</span>
        </div>
        <div class="data-analysis-panel__area">
          <div
            class="data-analysis-panel__area-setting map__table-area-settings"
          >
            <input type="radio" />
            <label for="">Все по месторождению</label>
          </div>
          <div
            class="data-analysis-panel__area-setting map__table-area-settings"
          >
            <input type="radio" />
            <label for="">По Горизонту</label>
          </div>
        </div>
      </div>
      <div class="data-analysis-panel__title">
        <i><img src="/img/PlastFluids/tableSettings.svg" alt=""/></i>
        <span>Настройка таблицы</span>
      </div>
      <div class="data-analysis-panel__area">
        <div class="data-analysis-panel__area-setting">
          <input type="radio" checked />
          <span>Состав пластовой нефти</span>
        </div>
        <div class="data-analysis-panel__area-setting">
          <input type="radio" checked />
          <span>Состав дегазированной нефти</span>
        </div>
      </div>
      <div class="data-analysis-panel__area">
        <div class="data-analysis-panel__area-setting">
          <span>Единица измерения</span>
          <Dropdown :items="pressures" dropKey="name" />
        </div>
      </div>
      <div class="data-analysis-panel__area">
        <div class="data-analysis-panel__area-header">
          Вид таблицы
        </div>
        <div class="data-analysis-panel__area-setting type">
          <input type="checkbox" />
          <span class="ml-1">CN-Ln</span>
        </div>
        <div class="data-analysis-panel__area-setting">
          <input type="checkbox" checked />
          <span class="ml-1">XXK</span>
        </div>
      </div>
    </div>
    <div
      class="d-flex justify-content-around pb-10px data-analysis-panel__btns"
    >
      <button class="btn-button btn-button--thm-dark-blue">
        <i class="fas fa-download pr-5px" />
        <span>Выгрузить данные</span>
      </button>
    </div>
  </div>
</template>

<script>
import Dropdown from "../Dropdown.vue";

export default {
  name: "DataAnalysisFluidCompositionPanel",
  components: {
    Dropdown,
  },

  data() {
    return {
      pressures: [
        { name: "Инфо1" },
        { name: "Инфо2" },
        { name: "Инфо3" },
        { name: "Инфо4" },
      ],
    };
  },
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

.settings-holder {
  margin-bottom: 10px;
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

.data-analysis-panel__area-header {
  padding: 8px 10px;
  background: rgba(50, 51, 112, 0.4);
  border: 1px solid #545580;
}

.data-analysis-panel__area-setting:first-child {
  border: 1px solid #545580;
  border-bottom: 0;
}

.data-analysis-panel__area-setting:last-child {
  border: 1px solid #545580;
  border-top: 0;
}

.data-analysis-panel__area-setting.type {
  border-right: 1px solid #545580;
  border-left: 1px solid #545580;
}

.map__table-area-settings {
  display: flex;
  align-items: center;
  background: #1d3583;
  border: 1px solid #545580;
}

.map__table-area-settings label {
  margin: 0 0 0 7px;
  display: block;
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
